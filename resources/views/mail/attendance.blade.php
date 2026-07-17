<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica Neue', 'PingFang SC', 'Microsoft YaHei', Arial, sans-serif; color: #1b1b18; background: #fbf6ef; margin: 0; padding: 24px; }
        .wrap { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #7c9cff, #5ec9c0); padding: 28px 32px; }
        .header h1 { margin: 0; font-size: 24px; color: #10233f; font-weight: 800; }
        .header p { margin: 4px 0 0; font-size: 13px; color: #10233f; opacity: .7; }
        .body { padding: 28px 32px; }
        .svc { margin-bottom: 28px; }
        .svc-title { font-size: 18px; font-weight: 800; color: #1b1b18; margin: 0 0 4px; }
        .count-row { display: flex; align-items: baseline; gap: 10px; margin: 6px 0 14px; }
        .count-big { font-size: 40px; font-weight: 800; color: #2f7d6b; line-height: 1; }
        .count-cap { font-size: 12px; text-transform: uppercase; letter-spacing: .08em; color: #706f6c; font-weight: 700; }
        .trend { font-size: 13px; color: #5a5246; margin: 0 0 12px; }
        .names { background: #f6faf8; border-radius: 12px; padding: 14px 18px; }
        .name-item { font-size: 15px; color: #1b1b18; padding: 4px 0; border-bottom: 1px solid #edf3f0; }
        .name-item:last-child { border-bottom: none; }
        .name-zh { color: #706f6c; font-size: 13px; margin-left: 6px; }
        .empty { font-size: 14px; color: #a09880; font-style: italic; }
        /* ---- Quarter chart ---- */
        .chart-card { background: #fbfbfa; border: 1px solid #eee7db; border-radius: 14px; padding: 16px 16px 12px; margin: 4px 0 14px; }
        .chart-head { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: #706f6c; margin: 0 0 12px; }
        .stat-tiles td { padding: 0 6px; }
        .stat-tile { background: #fff; border: 1px solid #efeade; border-radius: 10px; padding: 8px 4px; text-align: center; }
        .stat-num { font-size: 20px; font-weight: 800; line-height: 1; }
        .stat-cap { font-size: 10px; text-transform: uppercase; letter-spacing: .05em; color: #8a8378; margin-top: 3px; }
        .divider { border: none; border-top: 1px solid #f0ecf0; margin: 24px 0; }
        .footer { background: #10233f; padding: 14px 32px; text-align: center; color: rgba(255,255,255,.55); font-size: 12px; }
    </style>
</head>
<body>
<div class="wrap">
    <div class="header">
        <h1>⛪ WVAC Attendance</h1>
        <p>{{ $dateLabel }}</p>
    </div>
    <div class="body">
        @php $first = true; @endphp
        @foreach($payload as $service => $data)
            @if(!$first)<hr class="divider">@endif
            @php $first = false; @endphp
            @php
                $svcColor = $service === 'chinese' ? '#9b1c1c' : '#2563eb';
                $series   = $data['series'] ?? [];
                $maxC     = max(1, ...array_map(fn ($p) => $p['count'], $series ?: [['count' => 0]]));
            @endphp
            <div class="svc">
                <p class="svc-title">{{ $service === 'chinese' ? '中文 Chinese Service' : 'English Service' }}</p>
                <div class="count-row">
                    <span class="count-big" style="color: {{ $svcColor }};">{{ $data['count'] }}</span>
                    <span class="count-cap">present</span>
                </div>
                <p class="trend">
                    Previous Sundays —
                    {{ $data['prev1_label'] }}: <strong>{{ $data['prev1'] }}</strong>,
                    {{ $data['prev2_label'] }}: <strong>{{ $data['prev2'] }}</strong>
                </p>

                {{-- Quarter (last 13 Sundays) trend for the quarterly report --}}
                @if(count($series))
                <div class="chart-card">
                    <p class="chart-head">Last quarter · weekly attendance</p>
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                        <tr>
                            @foreach($series as $p)
                                @php $h = $p['count'] > 0 ? max(6, (int) round($p['count'] / $maxC * 118)) : 2; @endphp
                                <td valign="bottom" align="center" style="vertical-align: bottom; padding: 0 1px;">
                                    <div style="font-size: 9px; color: #8a8378; height: 13px; line-height: 13px;">{{ $p['count'] ?: '' }}</div>
                                    <div style="height: {{ $h }}px; background: {{ $p['count'] > 0 ? $svcColor : '#e6e2da' }}; border-radius: 3px 3px 0 0;">&nbsp;</div>
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            @foreach($series as $i => $p)
                                <td align="center" style="padding-top: 5px; font-size: 8px; color: #a8a294; white-space: nowrap;">
                                    {{ ($i === 0 || $p['month'] !== $series[$i - 1]['month']) ? $p['month'] : '' }}
                                </td>
                            @endforeach
                        </tr>
                    </table>
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="stat-tiles" style="border-collapse: separate; margin-top: 14px;">
                        <tr>
                            <td width="33%"><div class="stat-tile"><div class="stat-num" style="color: {{ $svcColor }};">{{ $data['q_avg'] }}</div><div class="stat-cap">Qtr avg</div></div></td>
                            <td width="33%"><div class="stat-tile"><div class="stat-num" style="color: {{ $svcColor }};">{{ $data['q_peak'] }}</div><div class="stat-cap">Qtr peak</div></div></td>
                            <td width="33%"><div class="stat-tile"><div class="stat-num" style="color: {{ $svcColor }};">{{ $data['q_weeks'] }}</div><div class="stat-cap">Wks recorded</div></div></td>
                        </tr>
                    </table>
                </div>
                @endif

                @if($data['attendees']->count())
                    <div class="names">
                        @foreach($data['attendees'] as $a)
                            <div class="name-item">
                                {{ $a->name }}@if($a->name_zh)<span class="name-zh">{{ $a->name_zh }}</span>@endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="empty">No one marked present.</p>
                @endif
            </div>
        @endforeach
    </div>
    <div class="footer">WVAC · Weekly Attendance</div>
</div>
</body>
</html>
