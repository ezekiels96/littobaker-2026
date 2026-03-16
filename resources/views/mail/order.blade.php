<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; color: #1b1b18; background: #fbf6ef; margin: 0; padding: 24px; }
        .wrap { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #FFC447, #F46EE5); padding: 28px 32px; }
        .header h1 { margin: 0; font-size: 26px; color: #1b1b18; font-weight: 800; }
        .header p { margin: 4px 0 0; font-size: 13px; color: #1b1b18/70; opacity: .7; }
        .body { padding: 28px 32px; }
        .section { margin-bottom: 24px; }
        .section h2 { font-size: 14px; text-transform: uppercase; letter-spacing: .1em; color: #706f6c; margin: 0 0 12px; border-bottom: 1px solid #e3e3e0; padding-bottom: 8px; }
        .info-row { display: flex; margin-bottom: 8px; }
        .info-label { font-weight: 600; color: #5a5246; min-width: 90px; font-size: 14px; }
        .info-value { font-size: 14px; color: #1b1b18; }
        .item { display: flex; align-items: flex-start; gap: 14px; padding: 14px 0; border-bottom: 1px solid #f3f3f0; }
        .item:last-child { border-bottom: none; }
        .item img { width: 60px; height: 60px; object-fit: cover; border-radius: 10px; flex-shrink: 0; }
        .item-no-img { width: 60px; height: 60px; border-radius: 10px; background: linear-gradient(135deg, #FFC447, #F46EE5); flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 24px; }
        .item-info { flex: 1; }
        .item-title { font-weight: 700; font-size: 15px; margin: 0 0 3px; }
        .item-meta { font-size: 13px; color: #706f6c; margin: 0 0 3px; }
        .item-notes { font-size: 12px; color: #9a8e86; font-style: italic; margin: 3px 0 0; }
        .item-price { font-weight: 700; font-size: 15px; color: #1b1b18; text-align: right; white-space: nowrap; }
        .total-row { display: flex; justify-content: space-between; align-items: center; padding: 16px 0 0; border-top: 2px solid #1b1b18; margin-top: 8px; }
        .total-label { font-size: 16px; font-weight: 800; }
        .total-amount { font-size: 22px; font-weight: 800; background: linear-gradient(135deg, #FFC447, #F46EE5); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .footer { background: #1b1b18; padding: 16px 32px; text-align: center; color: #fff; font-size: 12px; }
    </style>
</head>
<body>
<div class="wrap">
    <div class="header">
        <h1>🍪 New Order Received!</h1>
        <p>Someone placed an order on littobaker</p>
    </div>
    <div class="body">
        <div class="section">
            <h2>Customer Info</h2>
            <div class="info-row"><span class="info-label">Name:</span><span class="info-value">{{ $data['name'] }}</span></div>
            <div class="info-row"><span class="info-label">Email:</span><span class="info-value"><a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a></span></div>
            @if(!empty($data['phone']))
            <div class="info-row"><span class="info-label">Phone:</span><span class="info-value">{{ $data['phone'] }}</span></div>
            @endif
            @if(!empty($data['date']))
            <div class="info-row"><span class="info-label">Date Needed:</span><span class="info-value">{{ $data['date'] }}</span></div>
            @endif
            @if(!empty($data['message']))
            <div class="info-row"><span class="info-label">Note:</span><span class="info-value">{{ $data['message'] }}</span></div>
            @endif
        </div>

        <div class="section">
            <h2>Order Items</h2>
            @foreach($data['cart'] as $item)
            <div class="item">
                @if(!empty($item['image']))
                    <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}">
                @else
                    <div class="item-no-img">🍰</div>
                @endif
                <div class="item-info">
                    <div class="item-title">{{ $item['title'] }}</div>
                    <div class="item-meta">Qty: {{ $item['quantity'] }} × ${{ number_format($item['price'], 2) }} / {{ $item['quantity_type'] }}</div>
                    @if(!empty($item['notes']))
                    <div class="item-notes">Note: {{ $item['notes'] }}</div>
                    @endif
                </div>
                <div class="item-price">${{ number_format($item['price'] * $item['quantity'], 2) }}</div>
            </div>
            @endforeach

            <div class="total-row">
                <span class="total-label">Total</span>
                <span class="total-amount">${{ number_format($data['total'], 2) }}</span>
            </div>
        </div>
    </div>
    <div class="footer">
        littobaker · Home Bakery · Sunnyvale, CA
    </div>
</div>
</body>
</html>
