<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover">
    <meta name="robots" content="noindex, nofollow">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#10233f">
    <title>WVCAC</title>
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
            min-height: 100vh; display: flex; flex-direction: column;
        }
        .logobar {
            background: #fff; text-align: center;
            padding: 12px 16px; padding-top: max(12px, env(safe-area-inset-top));
            border-bottom: 1px solid var(--line);
        }
        .logobar img { height: 46px; width: auto; max-width: 100%; }

        .wrap {
            flex: 1; width: 100%; max-width: 480px; margin: 0 auto;
            padding: 24px 18px calc(24px + env(safe-area-inset-bottom));
            display: flex; flex-direction: column; gap: 16px;
        }
        .lead { text-align: center; margin: 6px 0 6px; }
        .lead h1 { font-size: 22px; font-weight: 800; color: var(--navy); margin: 0; }
        .lead p { font-size: 14px; color: var(--muted); margin: 6px 0 0; }

        .bigbtn {
            display: flex; align-items: center; gap: 16px; text-decoration: none;
            background: #fff; border: 1.5px solid var(--line); border-radius: 20px;
            padding: 22px 20px; color: var(--ink);
            box-shadow: 0 2px 14px rgba(16,35,63,.05);
            transition: transform .08s, border-color .12s, box-shadow .12s;
        }
        .bigbtn:active { transform: scale(.98); }
        .bigbtn .ic {
            flex: 0 0 auto; width: 56px; height: 56px; border-radius: 16px;
            display: flex; align-items: center; justify-content: center; font-size: 28px;
        }
        .bigbtn .tx { display: flex; flex-direction: column; gap: 3px; }
        .bigbtn .tx .t { font-size: 19px; font-weight: 800; }
        .bigbtn .tx .s { font-size: 13px; color: var(--muted); }
        .bigbtn .arrow { margin-left: auto; color: #c3c8d0; font-size: 24px; font-weight: 700; }

        .bigbtn.attend { border-left: 5px solid var(--teal); }
        .bigbtn.attend .ic { background: #e6f4f0; }
        .bigbtn.report { border-left: 5px solid var(--english); }
        .bigbtn.report .ic { background: #e3ecfd; }
    </style>
</head>
<body>
    <div class="logobar">
        <img src="{{ asset('images/wvac-logo.jpg') }}" alt="West Valley Christian Alliance Church">
    </div>

    <div class="wrap">
        <div class="lead">
            <h1>Attendance</h1>
            <p>Choose an option</p>
        </div>

        <a class="bigbtn attend" href="{{ route('wvac.attendance') }}">
            <span class="ic">📋</span>
            <span class="tx">
                <span class="t">Take Attendance</span>
                <span class="s">Check people in for Sunday</span>
            </span>
            <span class="arrow">›</span>
        </a>

        <a class="bigbtn report" href="{{ route('wvac.report') }}">
            <span class="ic">📊</span>
            <span class="tx">
                <span class="t">Quarterly Report</span>
                <span class="s">Attendance graph &amp; numbers by quarter</span>
            </span>
            <span class="arrow">›</span>
        </a>
    </div>
</body>
</html>
