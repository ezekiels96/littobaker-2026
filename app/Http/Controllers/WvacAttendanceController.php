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
    private const RECIPIENTS = ['ezekielsung96@gmail.com', 'bettysung@gmail.com','bettysung@yahoo.com'];

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

            // 13-week (one quarter) trend ending on this Sunday, for the admin's
            // quarterly report. Weeks with no recorded data are left out of the
            // average/peak so an un-entered Sunday doesn't drag the numbers down.
            $series   = $this->weeklySeries($date, $svc, 13);
            $recorded = array_values(array_filter(array_column($series, 'count'), fn ($c) => $c > 0));

            $payload[$svc] = [
                'attendees' => $present,
                'count'     => $present->count(),
                'prev1'     => $this->serviceCount($date->copy()->subWeek()->toDateString(), $svc),
                'prev2'     => $this->serviceCount($date->copy()->subWeeks(2)->toDateString(), $svc),
                'prev1_label' => $date->copy()->subWeek()->format('M j'),
                'prev2_label' => $date->copy()->subWeeks(2)->format('M j'),
                'series'      => $series,
                'q_avg'       => $recorded ? (int) round(array_sum($recorded) / count($recorded)) : 0,
                'q_peak'      => $recorded ? max($recorded) : 0,
                'q_weeks'     => count($recorded),
            ];
        }

        Mail::to(self::RECIPIENTS)->send(
            new AttendanceMail($dateStr, $date->format('l, F j, Y'), $payload)
        );

        $total = array_sum(array_map(fn ($p) => $p['count'], $payload));

        return response()->json(['success' => true, 'total' => $total]);
    }

    /** Simple landing page: attendance vs. quarterly report. */
    public function landing()
    {
        return view('pages.wvac-home');
    }

    /** Rename a person. */
    public function update(Request $request)
    {
        $data = $request->validate([
            'attendee_id' => 'required|integer|exists:wvac_attendees,id',
            'name'        => 'nullable|string|max:255',
            'name_zh'     => 'nullable|string|max:255',
        ]);

        if (empty($data['name']) && empty($data['name_zh'])) {
            return response()->json(['error' => 'A name is required.'], 422);
        }

        $attendee = WvacAttendee::findOrFail($data['attendee_id']);
        $attendee->update([
            'name'    => $data['name'] ?: $data['name_zh'],
            'name_zh' => $data['name_zh'] ?: null,
        ]);

        return response()->json(['success' => true, 'attendee' => [
            'id'      => $attendee->id,
            'name'    => $attendee->name,
            'name_zh' => $attendee->name_zh,
            'service' => $attendee->service,
        ]]);
    }

    /**
     * Remove a person from the roster. Deactivates them (so past reports keep
     * their history) and clears their mark for the day being edited so the live
     * count stays correct.
     */
    public function destroy(Request $request)
    {
        $data = $request->validate([
            'attendee_id' => 'required|integer|exists:wvac_attendees,id',
            'date'        => 'nullable|date',
        ]);

        $attendee = WvacAttendee::findOrFail($data['attendee_id']);
        $attendee->update(['is_active' => false]);

        if (!empty($data['date'])) {
            WvacAttendance::where('attendee_id', $attendee->id)
                ->where('service_date', Carbon::parse($data['date'])->toDateString())
                ->delete();
        }

        return response()->json(['success' => true]);
    }

    /**
     * Quarterly report: weekly attendance chart + raw table for a chosen quarter.
     * Renders fresh on every load so newly submitted data always shows.
     */
    public function report(Request $request)
    {
        $earliest  = WvacAttendance::min('service_date');
        $firstDate = $earliest ? Carbon::parse($earliest) : Carbon::today();
        $today     = Carbon::today();

        // Every quarter from the first quarter with data through the current one.
        $quarters = [];
        $cursor   = $firstDate->copy()->startOfQuarter();
        $lastQ    = $today->copy()->startOfQuarter();
        while ($cursor->lte($lastQ)) {
            $quarters[] = [
                'key'   => $cursor->year . '-Q' . $cursor->quarter,
                'year'  => $cursor->year,
                'q'     => $cursor->quarter,
                'label' => 'Q' . $cursor->quarter . ' ' . $cursor->year
                           . ' · ' . $cursor->copy()->startOfQuarter()->format('M')
                           . '–' . $cursor->copy()->endOfQuarter()->format('M'),
            ];
            $cursor->addQuarter();
        }
        $quarters = array_reverse($quarters); // newest first

        // Selected quarter (?q=YYYY-Qn), defaulting to the current one.
        $selected = collect($quarters)->firstWhere('key', $request->query('q'))
            ?? ($quarters[0] ?? [
                'key'  => $today->year . '-Q' . $today->quarter,
                'year' => $today->year,
                'q'    => $today->quarter,
            ]);

        $qStart = Carbon::create($selected['year'], ($selected['q'] - 1) * 3 + 1, 1)->startOfDay();
        $qEnd   = $qStart->copy()->endOfQuarter();
        $loopEnd = $qEnd->lt($today) ? $qEnd : $today; // don't list Sundays that haven't happened yet

        $rows = WvacAttendance::whereBetween('service_date', [$qStart->toDateString(), $qEnd->toDateString()])
            ->selectRaw('service_date, service, COUNT(*) as c')
            ->groupBy('service_date', 'service')
            ->get();

        $lookup = [];
        foreach ($rows as $r) {
            $lookup[Carbon::parse($r->service_date)->toDateString()][$r->service] = (int) $r->c;
        }

        $weeks = [];
        $engTotal = $chiTotal = $engWeeks = $chiWeeks = $peak = 0;
        $sun = $qStart->copy();
        if (!$sun->isSunday()) {
            $sun->next(Carbon::SUNDAY);
        }
        for (; $sun->lte($loopEnd); $sun->addWeek()) {
            $d = $sun->toDateString();
            $e = $lookup[$d]['english'] ?? 0;
            $c = $lookup[$d]['chinese'] ?? 0;
            $weeks[] = ['date' => $d, 'label' => $sun->format('M j'), 'english' => $e, 'chinese' => $c, 'total' => $e + $c];
            if ($e > 0) { $engTotal += $e; $engWeeks++; }
            if ($c > 0) { $chiTotal += $c; $chiWeeks++; }
            $peak = max($peak, $e, $c);
        }

        $summary = [
            'eng_avg'  => $engWeeks ? (int) round($engTotal / $engWeeks) : 0,
            'chi_avg'  => $chiWeeks ? (int) round($chiTotal / $chiWeeks) : 0,
            'eng_peak' => collect($weeks)->max('english') ?: 0,
            'chi_peak' => collect($weeks)->max('chinese') ?: 0,
            'eng_total' => $engTotal,
            'chi_total' => $chiTotal,
        ];

        return view('pages.wvac-report', [
            'quarters'   => $quarters,
            'selected'   => $selected,
            'rangeLabel' => $qStart->format('M j') . ' – ' . $qEnd->format('M j, Y'),
            'weeks'      => $weeks,
            'summary'    => $summary,
            'chartMax'   => max(1, $peak),
        ]);
    }

    private function serviceCount(string $date, string $service): int
    {
        return WvacAttendance::where('service_date', $date)
            ->where('service', $service)->count();
    }

    /**
     * Weekly attendance counts for a service across the $weeks Sundays ending on
     * $endDate. Returns a list of ['date','label','month','count'], oldest first.
     */
    private function weeklySeries(Carbon $endDate, string $service, int $weeks = 13): array
    {
        $start = $endDate->copy()->subWeeks($weeks - 1)->toDateString();

        $rows = WvacAttendance::where('service', $service)
            ->whereBetween('service_date', [$start, $endDate->toDateString()])
            ->selectRaw('service_date, COUNT(*) as c')
            ->groupBy('service_date')
            ->get()
            ->keyBy(fn ($r) => Carbon::parse($r->service_date)->toDateString());

        $series = [];
        for ($i = $weeks - 1; $i >= 0; $i--) {
            $d  = $endDate->copy()->subWeeks($i);
            $ds = $d->toDateString();
            $series[] = [
                'date'  => $ds,
                'label' => $d->format('M j'),
                'month' => $d->format('M'),
                'count' => isset($rows[$ds]) ? (int) $rows[$ds]->c : 0,
            ];
        }
        return $series;
    }
}
