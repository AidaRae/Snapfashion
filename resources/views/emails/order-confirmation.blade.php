<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f1f5f9; margin: 0; padding: 40px 20px; color: #334155; }
        .wrapper { max-width: 600px; margin: 0 auto; }
        .logo { text-align: center; margin-bottom: 24px; font-weight: 800; font-size: 24px; color: #0f172a; text-transform: uppercase; letter-spacing: 1px; }
        .container { background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; }
        .header { padding: 40px 40px 20px; text-align: center; border-bottom: 1px solid #f1f5f9; }
        .header h1 { margin: 0; font-size: 22px; color: #0f172a; font-weight: 700; letter-spacing: -0.5px; }
        .header p { margin: 8px 0 0; color: #64748b; font-size: 15px; }
        .content { padding: 40px; }
        .greeting { font-size: 16px; color: #1e293b; margin-top: 0; margin-bottom: 24px; font-weight: 500; }
        .custom-message { background-color: #eff6ff; border-left: 4px solid #3b82f6; border-radius: 4px; padding: 16px 20px; margin-bottom: 32px; font-size: 14px; color: #1e3a8a; line-height: 1.6; }
        .intro { color: #475569; font-size: 15px; line-height: 1.6; margin-bottom: 32px; }
        
        .order-meta { display: table; width: 100%; border-collapse: collapse; margin-bottom: 40px; }
        .meta-col { display: table-cell; width: 50%; padding: 16px; background-color: #f8fafc; border: 1px solid #e2e8f0; }
        .meta-col:first-child { border-right: none; border-radius: 6px 0 0 6px; }
        .meta-col:last-child { border-radius: 0 6px 6px 0; }
        .meta-label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; margin-bottom: 6px; font-weight: 600; }
        .meta-value { font-size: 14px; color: #0f172a; font-weight: 600; }
        
        .section-title { font-size: 12px; text-transform: uppercase; letter-spacing: 0.8px; color: #94a3b8; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px; margin-bottom: 16px; font-weight: 700; }
        
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 32px; }
        .items-table th { padding: 0 0 12px; text-align: left; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #e2e8f0; }
        .items-table th.right { text-align: right; }
        .items-table td { padding: 16px 0; border-bottom: 1px solid #f1f5f9; font-size: 14px; color: #334155; vertical-align: middle; }
        .items-table td.right { text-align: right; }
        .product-name { font-weight: 500; color: #0f172a; }
        .product-qty { color: #64748b; font-size: 13px; margin-top: 4px; }
        
        .totals { width: 100%; border-collapse: collapse; margin-bottom: 40px; }
        .totals td { padding: 8px 0; font-size: 14px; color: #475569; }
        .totals td.amount { text-align: right; color: #0f172a; font-weight: 500; }
        .totals tr.discount td { color: #16a34a; }
        .totals tr.discount td.amount { color: #16a34a; }
        .totals tr.grand-total td { padding: 16px 0 0; font-size: 18px; font-weight: 700; color: #0f172a; border-top: 1px solid #e2e8f0; }
        .totals tr.grand-total td.amount { color: #3b82f6; }
        
        .address-box { background-color: #f8fafc; padding: 20px; border-radius: 6px; border: 1px solid #e2e8f0; margin-bottom: 40px; }
        .address-box p { margin: 0; font-size: 14px; line-height: 1.6; color: #334155; }
        
        .action { text-align: center; margin-bottom: 20px; }
        .btn { display: inline-block; background-color: #3b82f6; color: #ffffff; text-decoration: none; font-size: 15px; font-weight: 600; padding: 14px 32px; border-radius: 6px; transition: background-color 0.2s; }
        
        .footer { text-align: center; padding: 32px 20px 0; color: #94a3b8; font-size: 12px; line-height: 1.6; }
        .footer a { color: #64748b; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="logo">
            {{ config('app.name') }}
        </div>
        <div class="container">
            <div class="header">
                <h1>Order Confirmed</h1>
                <p>Thank you for your purchase.</p>
            </div>
            
            <div class="content">
                <p class="greeting">Hi {{ $order->guest_name }},</p>
                
                @if(!empty($customMessage))
                <div class="custom-message">
                    {!! nl2br(e($customMessage)) !!}
                </div>
                @endif
                
                <p class="intro">We're getting your order ready to be shipped. We will notify you when it has been sent.</p>
                
                <div class="order-meta">
                    <div class="meta-col">
                        <div class="meta-label">Order Number</div>
                        <div class="meta-value">{{ $order->tracking_code }}</div>
                        <div class="meta-label" style="margin-top: 16px;">Date</div>
                        <div class="meta-value">{{ $order->created_at->format('M d, Y') }}</div>
                    </div>
                    <div class="meta-col">
                        <div class="meta-label">Payment Method</div>
                        <div class="meta-value">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</div>
                        <div class="meta-label" style="margin-top: 16px;">Status</div>
                        <div class="meta-value">Pending</div>
                    </div>
                </div>
                
                <div class="section-title">Order Summary</div>
                
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th class="right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <div class="product-name">{{ $item->product->name ?? 'Product' }}</div>
                                <div class="product-qty">Qty: {{ $item->quantity }} x ₦{{ number_format($item->price, 2) }}</div>
                            </td>
                            <td class="right">₦{{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <table class="totals">
                    <tr>
                        <td>Subtotal</td>
                        <td class="amount">₦{{ number_format($order->subtotal, 2) }}</td>
                    </tr>
                    @if($order->discount_amount > 0)
                    <tr class="discount">
                        <td>Discount ({{ $order->coupon_code }})</td>
                        <td class="amount">-₦{{ number_format($order->discount_amount, 2) }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td>Shipping</td>
                        @if($order->shipping_fee > 0)
                        <td class="amount">₦{{ number_format($order->shipping_fee, 2) }}</td>
                        @else
                        <td class="amount" style="color: #16a34a;">Free</td>
                        @endif
                    </tr>
                    <tr class="grand-total">
                        <td>Total</td>
                        <td class="amount">₦{{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                </table>
                
                <div class="section-title">Shipping Address</div>
                <div class="address-box">
                    <p>{!! nl2br(e($order->shipping_address)) !!}</p>
                </div>
                
                <div class="action">
                    <a href="{{ $trackingUrl }}" class="btn">View Order Details</a>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p>Need help? reply to this email or contact support.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
