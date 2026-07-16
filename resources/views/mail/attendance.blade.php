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
            <div class="svc">
                <p class="svc-title">{{ $service === 'chinese' ? '中文 Chinese Service' : 'English Service' }}</p>
                <div class="count-row">
                    <span class="count-big">{{ $data['count'] }}</span>
                    <span class="count-cap">present</span>
                </div>
                <p class="trend">
                    Previous Sundays —
                    {{ $data['prev1_label'] }}: <strong>{{ $data['prev1'] }}</strong>,
                    {{ $data['prev2_label'] }}: <strong>{{ $data['prev2'] }}</strong>
                </p>
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
