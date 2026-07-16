<?php

namespace App\Console\Commands;

use App\Models\WvacAttendance;
use App\Models\WvacAttendee;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SeedWvacPeople extends Command
{
    protected $signature = 'wvac:seed-people {--fresh : Wipe the existing WVAC roster + attendance before seeding}';
    protected $description = 'Seed the WVAC attendance roster (Chinese & English services)';

    /** Chinese service roster. */
    private array $chinese = [
        'jet wan', 'ps lewis', 'emma luo', 'alice kearns', 'david fong', 'florence fong', 'helen lee', 'amy cheng', 'teddy cheng', 'henry wong',
        'susan wong', 'margaret yip', 'mrs shum', 'yvonne tso', 'zhi q liu', 'olwen tam', 'letitia lam', 'ellis hung', 'simon kuang', 'leo wang',
        'emily wang', 'tom wang', 'jenny chaing', 'guest', 'mrs sung', 'anny fong', 'francis fong', 'carey wan', 'eva yim', 'bo chan',
        'kitty lee', 'jackson lee', 'leo tam', 'may young', 'dg young', 'paul cham', 'annie chan', 'michael pang', 'dennis cheong', 'eliza cheong',
        'fiona', 'joyce wan', 'kevin tam', 'shan hong', 'bill huang', 'ben tam', 'jay fung', 'shue kuang', 'betty sung', 'frances tang',
        'ps ron', 'nu luong', 'emily yin', 'nora kong', 'monica yan', 'jacob chiu', 'louisa luk', 'derek mui', 'nancy young', 'dennis young',
        'joanne lee', 'kim chin', 'ed chin', 'fanny wong', 'eric wong', 'mrs ng', 'mrs pang', 'catherine pang', 'dia fong',
        'bruce fong', 'alice leung', 'alred wong', 'frances feng', 'victor tso', 'mervyn cheung', 'joyce lam', 'david zhou', 'david', 'bowie',
        'icy ng', 'natalie yuen', 'silphy ou', 'jack ou', 'julie sung', 'nelson chan', 'meekie cheung', 'amour kwok', 'alex kwok', 'ms dong',
        'moses goh', 'raymond wong', 'florene law', 'kay lieu', 'jr feng', 'wendy gu', 'carsya pang',
    ];

    /** English service roster. */
    private array $english = [
        'vincent wong', 'jennifer chou', 'candice chen', 'kara chen', 'jeriel goh', 'charis goh', 'juno wang', 'louisa ng', 'kevin ng', 'hayson ng',
        'jason sit', 'winnie chen', 'isaiah sit', 'jeremiah sit', 'maynnet', 'brandon fong', 'lyn fong', 'melinda coucil', 'leo au', 'melina au',
        'dennis yau', 'janet yau', 'margaret lee', 'po sing tsui', 'jan tsui', 'paul johnson', 'tom johnson', 'kennedy johnson', 'dianne johnson', 'yuko johnson',
        'ezekiel sung', 'jacy auyeung', 'christopher lo', 'claudia lo', 'calvin lo', 'clara', 'maya', 'zack', 'shanin', 'francis ap',
        'arthur woo', 'laisha', 'jocelyn', 'ohymn yan', 'ps ron',
    ];

    public function handle(): int
    {
        if ($this->option('fresh')) {
            DB::transaction(function () {
                WvacAttendance::query()->delete();
                WvacAttendee::query()->delete();
            });
            $this->warn('Wiped existing WVAC roster + attendance.');
        }

        $totalAdded = 0;
        $totalSkipped = 0;

        foreach (['chinese' => $this->chinese, 'english' => $this->english] as $service => $names) {
            // Trim, drop blanks, and de-duplicate names within the service.
            $roster = collect($names)
                ->map(fn ($n) => trim($n))
                ->filter(fn ($n) => $n !== '')
                ->unique()
                ->values();

            $added = 0;
            $skipped = 0;

            foreach ($roster as $name) {
                $person = WvacAttendee::firstOrCreate(
                    ['name' => $name, 'service' => $service],
                    ['is_active' => true],
                );
                $person->wasRecentlyCreated ? $added++ : $skipped++;
            }

            $this->info(sprintf('%-8s → added %d, skipped %d (already present)', ucfirst($service), $added, $skipped));
            $totalAdded += $added;
            $totalSkipped += $skipped;
        }

        $this->newLine();
        $this->info("Done. Added {$totalAdded} people, skipped {$totalSkipped}.");
        $this->line('Chinese service names have no 中文名 yet — add characters later via the page if you want them shown in the Chinese list.');

        return self::SUCCESS;
    }
}
