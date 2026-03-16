<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; color: #1b1b18; background: #fbf6ef; margin: 0; padding: 24px; }
        .wrap { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #b9a7ff, #F46EE5); padding: 28px 32px; }
        .header h1 { margin: 0; font-size: 24px; color: #1b1b18; font-weight: 800; }
        .header p { margin: 4px 0 0; font-size: 13px; color: #1b1b18; opacity: .6; }
        .body { padding: 28px 32px; }
        .field { margin-bottom: 16px; }
        .field-label { font-size: 11px; text-transform: uppercase; letter-spacing: .1em; color: #706f6c; font-weight: 700; margin-bottom: 4px; }
        .field-value { font-size: 15px; color: #1b1b18; }
        .divider { border: none; border-top: 1px solid #f0ecf0; margin: 20px 0; }
        .message-box { background: #fbf6ef; border-radius: 12px; padding: 16px 20px; }
        .message-text { font-size: 15px; color: #5a5246; line-height: 1.7; white-space: pre-wrap; }
        .footer { background: #1b1b18; padding: 14px 32px; text-align: center; color: rgba(255,255,255,.5); font-size: 12px; }
    </style>
</head>
<body>
<div class="wrap">
    <div class="header">
        <h1>✉️ New Contact Message</h1>
        <p>From the littobaker website contact form</p>
    </div>
    <div class="body">
        <div class="field">
            <div class="field-label">From</div>
            <div class="field-value">{{ $data['name'] }}</div>
        </div>
        <div class="field">
            <div class="field-label">Email</div>
            <div class="field-value"><a href="mailto:{{ $data['email'] }}" style="color: #8f7cfa;">{{ $data['email'] }}</a></div>
        </div>
        @if(!empty($data['phone']))
        <div class="field">
            <div class="field-label">Phone</div>
            <div class="field-value">{{ $data['phone'] }}</div>
        </div>
        @endif
        @if(!empty($data['subject']))
        <div class="field">
            <div class="field-label">Subject</div>
            <div class="field-value">{{ $data['subject'] }}</div>
        </div>
        @endif

        <hr class="divider">

        <div class="field-label" style="margin-bottom: 10px;">Message</div>
        <div class="message-box">
            <div class="message-text">{{ $data['message'] }}</div>
        </div>
    </div>
    <div class="footer">littobaker · Home Bakery · Sunnyvale, CA</div>
</div>
</body>
</html>
