<?php

namespace App\Http\Controllers;

use App\Mail\AttendanceMail;
use App\Models\WvacAttendance;
use App\Models\WvacAttendee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WvacAttendanceController extends Controller
{
    /** Addresses that receive the submitted attendance stats. */
    private const RECIPIENTS = ['ezekielsung96@gmail.com', 'bettysung@gmail.com'];

    /** Today if it's Sunday, otherwise the upcoming Sunday. */
    private function defaultSunday(): Carbon
    {
        $today = Carbon::today();
        return $today->isSunday() ? $today : $today->next(Carbon::SUNDAY);
    }

    /** Parse a requested date, snapping to a valid day; falls back to the default Sunday. */
    private function resolveDate(?string $date): Carbon
    {
        if ($date) {
            try {
                return Carbon::parse($date)->startOfDay();
            } catch (\Throwable $e) {
                // fall through
            }
        }
        return $this->defaultSunday();
    }

    public function index(Request $request)
    {
        $selected    = $this->resolveDate($request->query('date'));
        $selectedStr = $selected->toDateString();
        $default     = $this->defaultSunday();

        // Build the Sunday dropdown: 12 weeks back through 1 week ahead of the
        // default Sunday, plus any date that already has saved data, plus whatever
        // is currently selected. This guarantees the page is always ready with no setup.
        $datesWithData = WvacAttendance::query()
            ->select('service_date')->distinct()->pluck('service_date')
            ->map(fn ($x) => Carbon::parse($x)->toDateString());

        $sundays = collect();
        for ($d = $default->copy()->subWeeks(12); $d->lte($default->copy()->addWeek()); $d->addWeek()) {
            $sundays->push($d->toDateString());
        }
        $sundays = $sundays->merge($datesWithData)->push($selectedStr)
            ->unique()->sort()->reverse()->values(); // newest first

        $dataSet = $datesWithData->flip();
        $sundayOptions = $sundays->map(function ($d) use ($selectedStr, $default, $dataSet) {
            $c = Carbon::parse($d);
            return [
                'value'       => $d,
                'label'       => $c->format('D, M j, Y'),
                'is_selected' => $d === $selectedStr,
                'is_default'  => $d === $default->toDateString(),
                'has_data'    => $dataSet->has($d),
            ];
        });

        // Roster with present-flag for the selected date.
        $presentSet = WvacAttendance::where('service_date', $selectedStr)
            ->pluck('attendee_id')->flip();

        $attendees = WvacAttendee::where('is_active', true)
            ->orderBy('name')->get()
            ->map(function ($a) use ($presentSet) {
                $a->present = $presentSet->has($a->id);
                return $a;
            });

        $byService = [
            'english' => $attendees->where('service', 'english')->values(),
            'chinese' => $attendees->where('service', 'chinese')->values(),
        ];

        // Stats: selected Sunday + previous two Sundays, counts per service.
        $statDates = [
            $selected->toDateString(),
            $selected->copy()->subWeek()->toDateString(),
            $selected->copy()->subWeeks(2)->toDateString(),
        ];
        $rawCounts = WvacAttendance::whereIn('service_date', $statDates)
            ->selectRaw('service_date, service, COUNT(*) as c')
            ->groupBy('service_date', 'service')
            ->get();

        $countFor = function (string $service, string $date) use ($rawCounts) {
            $row = $rawCounts->first(fn ($r) =>
                $r->service === $service &&
                Carbon::parse($r->service_date)->toDateString() === $date
            );
            return $row ? (int) $row->c : 0;
        };

        $stats = [];
        foreach (['english', 'chinese'] as $svc) {
            $stats[$svc] = [
                'this'  => $countFor($svc, $statDates[0]),
                'prev1' => $countFor($svc, $statDates[1]),
                'prev2' => $countFor($svc, $statDates[2]),
                'prev1_label' => Carbon::parse($statDates[1])->format('M j'),
                'prev2_label' => Carbon::parse($statDates[2])->format('M j'),
            ];
        }

        return view('pages.wvac-attendance', [
            'selectedDate'  => $selectedStr,
            'selectedLabel' => $selected->format('l, F j, Y'),
            'isSunday'      => $selected->isSunday(),
            'sundayOptions' => $sundayOptions,
            'byService'     => $byService,
            'stats'         => $stats,
        ]);
    }

    public function toggle(Request $request)
    {
        $data = $request->validate([
            'attendee_id' => 'required|integer|exists:wvac_attendees,id',
            'date'        => 'required|date',
        ]);

        $date     = Carbon::parse($data['date'])->toDateString();
        $attendee = WvacAttendee::findOrFail($data['attendee_id']);

        $existing = WvacAttendance::where('attendee_id', $attendee->id)
            ->where('service_date', $date)->first();

        if ($existing) {
            $existing->delete();
            $present = false;
        } else {
            WvacAttendance::create([
                'attendee_id'  => $attendee->id,
                'service'      => $attendee->service,
                'service_date' => $date,
            ]);
            $present = true;
        }

        return response()->json([
            'present' => $present,
            'service' => $attendee->service,
            'count'   => $this->serviceCount($date, $attendee->service),
        ]);
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'name_zh' => 'nullable|string|max:255',
            'service' => 'required|in:english,chinese',
            'date'    => 'required|date',
        ]);

        $date = Carbon::parse($data['date'])->toDateString();

        $attendee = WvacAttendee::create([
            'name'      => $data['name'],
            'name_zh'   => $data['name_zh'] ?? null,
            'service'   => $data['service'],
            'is_active' => true,
        ]);

        // New people are marked present for the week they're added.
        WvacAttendance::create([
            'attendee_id'  => $attendee->id,
            'service'      => $attendee->service,
            'service_date' => $date,
        ]);

        return response()->json([
            'attendee' => [
                'id'      => $attendee->id,
                'name'    => $attendee->name,
                'name_zh' => $attendee->name_zh,
                'service' => $attendee->service,
                'present' => true,
            ],
            'count' => $this->serviceCount($date, $attendee->service),
        ]);
    }

    public function submit(Request $request)
    {
        $data = $request->validate([
            'date'    => 'required|date',
            'service' => 'required|in:english,chinese,both',
        ]);

        $date     = Carbon::parse($data['date']);
        $dateStr  = $date->toDateString();
        $services = $data['service'] === 'both' ? ['english', 'chinese'] : [$data['service']];

        $payload = [];
        foreach ($services as $svc) {
            $present = WvacAttendance::with('attendee')
                ->where('service_date', $dateStr)
                ->where('service', $svc)
                ->get()
                ->map(fn ($m) => $m->attendee)
                ->filter()
                ->sortBy('name')
                ->values();

            $payload[$svc] = [
                'attendees' => $present,
                'count'     => $present->count(),
                'prev1'     => $this->serviceCount($date->copy()->subWeek()->toDateString(), $svc),
                'prev2'     => $this->serviceCount($date->copy()->subWeeks(2)->toDateString(), $svc),
                'prev1_label' => $date->copy()->subWeek()->format('M j'),
                'prev2_label' => $date->copy()->subWeeks(2)->format('M j'),
            ];
        }

        Mail::to(self::RECIPIENTS)->send(
            new AttendanceMail($dateStr, $date->format('l, F j, Y'), $payload)
        );

        $total = array_sum(array_map(fn ($p) => $p['count'], $payload));

        return response()->json(['success' => true, 'total' => $total]);
    }

    private function serviceCount(string $date, string $service): int
    {
        return WvacAttendance::where('service_date', $date)
            ->where('service', $service)->count();
    }
}
