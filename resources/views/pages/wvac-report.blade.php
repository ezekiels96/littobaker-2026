<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover">
    <meta name="robots" content="noindex, nofollow">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#10233f">
    <title>Quarterly Report · WVCAC</title>
    <style>
        :root {
            --navy: #10233f;
            --teal: #2f7d6b;
            --ink: #1b1b18;
            --muted: #6b7280;
            --line: #e6e8ec;
            --bg: #f4f6f9;
            --english: #2563eb;
            --chinese: #9b1c1c;
        }
        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        html, body { margin: 0; padding: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'PingFang SC',
                         'Microsoft YaHei', 'Noto Sans CJK SC', sans-serif;
            background: var(--bg); color: var(--ink);
            -webkit-font-smoothing: antialiased;
            padding-bottom: calc(24px + env(safe-area-inset-bottom));
        }

        .topbar {
            position: sticky; top: 0; z-index: 20;
            background: var(--navy); color: #fff;
            padding: 12px 14px; padding-top: max(12px, env(safe-area-inset-top));
            box-shadow: 0 2px 14px rgba(0,0,0,.12);
        }
        .topbar .row1 { display: flex; align-items: center; gap: 10px; }
        .back {
            color: #fff; text-decoration: none; font-size: 22px; font-weight: 700;
            width: 34px; height: 34px; display: flex; align-items: center; justify-content: center;
            background: rgba(255,255,255,.12); border-radius: 10px; flex: 0 0 auto;
        }
        .topbar h1 { font-size: 17px; margin: 0; font-weight: 800; }
        .topbar .sub { font-size: 11px; opacity: .7; margin-top: 1px; }

        .qnav { display: flex; align-items: center; gap: 8px; margin-top: 12px; }
        .qnav a, .qnav span.disabled {
            width: 40px; height: 40px; flex: 0 0 auto; border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(255,255,255,.12); color: #fff; text-decoration: none;
            font-size: 20px; font-weight: 700; border: 1px solid rgba(255,255,255,.18);
        }
        .qnav span.disabled { opacity: .3; }
        .qselect {
            flex: 1; appearance: none; -webkit-appearance: none;
            background: rgba(255,255,255,.12) url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='3'><path d='M6 9l6 6 6-6'/></svg>") no-repeat right 12px center;
            color: #fff; border: 1px solid rgba(255,255,255,.2);
            border-radius: 12px; padding: 11px 34px 11px 14px;
            font-size: 15px; font-weight: 700; text-align: center; text-align-last: center;
        }
        .qselect option { color: #000; }

        .container { max-width: 640px; margin: 0 auto; padding: 14px; }
        .card {
            background: #fff; border: 1px solid var(--line); border-radius: 18px;
            padding: 16px; margin-bottom: 14px;
        }
        .card h2 {
            font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: .07em;
            color: var(--muted); margin: 0 0 12px;
        }

        .legend { display: flex; gap: 16px; margin: 4px 0 10px; }
        .legend .item { display: flex; align-items: center; gap: 7px; font-size: 13px; font-weight: 700; }
        .legend .dot { width: 14px; height: 14px; border-radius: 4px; }
        .legend .eng { background: var(--english); }
        .legend .chi { background: var(--chinese); }

        .chart { width: 100%; height: auto; display: block; }
        /* CSS vars don't resolve inside SVG presentation attributes — style strokes here. */
        .line-eng { stroke: var(--english); }
        .line-chi { stroke: var(--chinese); }
        .mk-eng { stroke: var(--english); }
        .mk-chi { stroke: var(--chinese); }

        /* Summary tiles */
        .tiles { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 6px; }
        .tile { border: 1px solid var(--line); border-radius: 14px; padding: 12px 14px; }
        .tile .cap { font-size: 11px; text-transform: uppercase; letter-spacing: .05em; color: var(--muted); font-weight: 700; }
        .tile .val { font-size: 24px; font-weight: 800; margin-top: 3px; line-height: 1; }
        .tile.eng { border-left: 4px solid var(--english); }
        .tile.chi { border-left: 4px solid var(--chinese); }
        .tile .val.eng { color: var(--english); }
        .tile .val.chi { color: var(--chinese); }
        .tile .sub { font-size: 11px; color: var(--muted); margin-top: 4px; }

        /* Table */
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        thead th {
            text-align: right; font-size: 11px; text-transform: uppercase; letter-spacing: .04em;
            color: var(--muted); font-weight: 800; padding: 8px 6px; border-bottom: 2px solid var(--line);
        }
        thead th:first-child { text-align: left; }
        tbody td { text-align: right; padding: 10px 6px; border-bottom: 1px solid #f0f2f5; }
        tbody td:first-child { text-align: left; color: var(--muted); font-weight: 600; }
        tbody td.eng { color: var(--english); font-weight: 700; }
        tbody td.chi { color: var(--chinese); font-weight: 700; }
        tbody td.tot { font-weight: 800; }
        tfoot td {
            text-align: right; padding: 10px 6px; font-weight: 800; border-top: 2px solid var(--line);
        }
        tfoot td:first-child { text-align: left; font-size: 12px; text-transform: uppercase; letter-spacing: .04em; color: var(--muted); }

        .empty { text-align: center; color: var(--muted); padding: 40px 16px; font-size: 15px; line-height: 1.5; }
    </style>
</head>
<body>
    @php
        $idx   = collect($quarters)->search(fn ($x) => $x['key'] === $selected['key']);
        $newer = ($idx !== false && $idx > 0) ? $quarters[$idx - 1] : null;               // newest-first
        $older = ($idx !== false && $idx < count($quarters) - 1) ? $quarters[$idx + 1] : null;
    @endphp

    <div class="topbar">
        <div class="row1">
            <a class="back" href="{{ route('wvac.home') }}" aria-label="Back">‹</a>
            <div>
                <h1>Quarterly Report</h1>
                <div class="sub">{{ $rangeLabel }}</div>
            </div>
        </div>
        <div class="qnav">
            @if($older)
                <a href="{{ route('wvac.report', ['q' => $older['key']]) }}" aria-label="Older quarter">‹</a>
            @else
                <span class="disabled">‹</span>
            @endif
            <select class="qselect" id="qSelect" aria-label="Select quarter">
                @foreach($quarters as $q)
                    <option value="{{ $q['key'] }}" @selected($q['key'] === $selected['key'])>{{ $q['label'] }}</option>
                @endforeach
            </select>
            @if($newer)
                <a href="{{ route('wvac.report', ['q' => $newer['key']]) }}" aria-label="Newer quarter">›</a>
            @else
                <span class="disabled">›</span>
            @endif
        </div>
    </div>

    <div class="container">
        @if(count($weeks) === 0)
            <div class="card">
                <div class="empty">No attendance recorded for this quarter yet.<br>Pick another quarter above.</div>
            </div>
        @else
            @php
                // ---- Chart geometry (server-rendered SVG, no JS needed) ----
                $W = 360; $H = 200;
                $padL = 30; $padR = 14; $padT = 16; $padB = 30;
                $plotW = $W - $padL - $padR;
                $plotH = $H - $padT - $padB;
                $n = count($weeks);

                $nice = (int) (ceil($chartMax / 5) * 5);
                if ($nice < 5) $nice = 5;
                $gridVals = [0, (int) round($nice / 2), $nice];

                $xAt = fn ($i) => $n === 1 ? $padL + $plotW / 2 : $padL + $plotW * $i / ($n - 1);
                $yAt = fn ($v) => $padT + $plotH * (1 - $v / $nice);

                $engPts = $chiPts = [];
                foreach ($weeks as $i => $w) {
                    $engPts[] = round($xAt($i), 1) . ',' . round($yAt($w['english']), 1);
                    $chiPts[] = round($xAt($i), 1) . ',' . round($yAt($w['chinese']), 1);
                }
                $labelStep = (int) ceil($n / 7);
            @endphp

            <div class="card">
                <h2>Weekly attendance</h2>
                <div class="legend">
                    <span class="item"><span class="dot eng"></span>English</span>
                    <span class="item"><span class="dot chi"></span>中文 Chinese</span>
                </div>
                <svg class="chart" viewBox="0 0 {{ $W }} {{ $H }}" preserveAspectRatio="xMidYMid meet"
                     role="img" aria-label="Weekly attendance line chart for the quarter">
                    <!-- gridlines + y labels -->
                    @foreach($gridVals as $gv)
                        @php $gy = round($yAt($gv), 1); @endphp
                        <line x1="{{ $padL }}" y1="{{ $gy }}" x2="{{ $W - $padR }}" y2="{{ $gy }}"
                              stroke="#eceef1" stroke-width="1"/>
                        <text x="{{ $padL - 6 }}" y="{{ $gy + 3 }}" text-anchor="end"
                              font-size="9" fill="#9aa0a8">{{ $gv }}</text>
                    @endforeach
                    <!-- x labels (first anchored start, last anchored end, so they don't clip) -->
                    @foreach($weeks as $i => $w)
                        @if($i % $labelStep === 0 || $i === $n - 1)
                            @php $anchor = $i === 0 ? 'start' : ($i === $n - 1 ? 'end' : 'middle'); @endphp
                            <text x="{{ round($xAt($i), 1) }}" y="{{ $H - 10 }}" text-anchor="{{ $anchor }}"
                                  font-size="9" fill="#9aa0a8">{{ $w['label'] }}</text>
                        @endif
                    @endforeach
                    <!-- English line -->
                    <polyline class="line-eng" fill="none" stroke-width="2.4"
                              stroke-linejoin="round" stroke-linecap="round"
                              points="{{ implode(' ', $engPts) }}"/>
                    <!-- Chinese line -->
                    <polyline class="line-chi" fill="none" stroke-width="2.4"
                              stroke-linejoin="round" stroke-linecap="round"
                              points="{{ implode(' ', $chiPts) }}"/>
                    <!-- markers (circle = English, square = Chinese, redundant with color) -->
                    @foreach($weeks as $i => $w)
                        <circle class="mk-eng" cx="{{ round($xAt($i), 1) }}" cy="{{ round($yAt($w['english']), 1) }}"
                                r="3" fill="#fff" stroke-width="2"/>
                    @endforeach
                    @foreach($weeks as $i => $w)
                        @php $sx = round($xAt($i), 1); $sy = round($yAt($w['chinese']), 1); @endphp
                        <rect class="mk-chi" x="{{ $sx - 2.6 }}" y="{{ $sy - 2.6 }}" width="5.2" height="5.2"
                              fill="#fff" stroke-width="2"/>
                    @endforeach
                </svg>

                <div class="tiles">
                    <div class="tile eng">
                        <div class="cap">English avg</div>
                        <div class="val eng">{{ $summary['eng_avg'] }}</div>
                        <div class="sub">Peak {{ $summary['eng_peak'] }} · {{ $summary['eng_total'] }} total</div>
                    </div>
                    <div class="tile chi">
                        <div class="cap">Chinese avg</div>
                        <div class="val chi">{{ $summary['chi_avg'] }}</div>
                        <div class="sub">Peak {{ $summary['chi_peak'] }} · {{ $summary['chi_total'] }} total</div>
                    </div>
                </div>
            </div>

            <div class="card">
                <h2>Raw numbers</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Sunday</th>
                            <th>English</th>
                            <th>Chinese</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($weeks as $w)
                            <tr>
                                <td>{{ $w['label'] }}</td>
                                <td class="eng">{{ $w['english'] }}</td>
                                <td class="chi">{{ $w['chinese'] }}</td>
                                <td class="tot">{{ $w['total'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Average</td>
                            <td>{{ $summary['eng_avg'] }}</td>
                            <td>{{ $summary['chi_avg'] }}</td>
                            <td>{{ $summary['eng_avg'] + $summary['chi_avg'] }}</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td>{{ $summary['eng_total'] }}</td>
                            <td>{{ $summary['chi_total'] }}</td>
                            <td>{{ $summary['eng_total'] + $summary['chi_total'] }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif
    </div>

    <script>
        document.getElementById('qSelect').addEventListener('change', function () {
            window.location.href = '{{ route('wvac.report') }}?q=' + encodeURIComponent(this.value);
        });
    </script>
</body>
</html>
