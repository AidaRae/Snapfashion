<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status Update</title>
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
        
        .status-badge { display: inline-block; padding: 12px 28px; border-radius: 30px; font-weight: 700; font-size: 16px; text-transform: capitalize; margin: 0 auto 32px; text-align: center; color: #854d0e; background-color: #fef08a; letter-spacing: 0.5px; }
        .status-badge-container { text-align: center; }

        .order-meta { display: table; width: 100%; border-collapse: collapse; margin-bottom: 40px; }
        .meta-col { display: table-cell; width: 50%; padding: 16px; background-color: #f8fafc; border: 1px solid #e2e8f0; }
        .meta-col:first-child { border-right: none; border-radius: 6px 0 0 6px; }
        .meta-col:last-child { border-radius: 0 6px 6px 0; }
        .meta-label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; margin-bottom: 6px; font-weight: 600; }
        .meta-value { font-size: 14px; color: #0f172a; font-weight: 600; }
        
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
                <h1>Order Status Update</h1>
                <p>There is an update regarding your order.</p>
            </div>
            
            <div class="content">
                <p class="greeting">Hi {{ $order->guest_name }},</p>
                
                @if(!empty($customMessage))
                <div class="custom-message">
                    {!! nl2br(e($customMessage)) !!}
                </div>
                @endif
                
                <div class="status-badge-container">
                    <div class="status-badge">
                        {{ $order->status }}
                    </div>
                </div>
                
                <div class="order-meta">
                    <div class="meta-col">
                        <div class="meta-label">Order Number</div>
                        <div class="meta-value">{{ $order->tracking_code }}</div>
                        <div class="meta-label" style="margin-top: 16px;">Items</div>
                        <div class="meta-value">{{ count($order->items) }} item(s)</div>
                    </div>
                    <div class="meta-col">
                        <div class="meta-label">Total Amount</div>
                        <div class="meta-value">₦{{ number_format($order->total_amount, 2) }}</div>
                        <div class="meta-label" style="margin-top: 16px;">Payment Method</div>
                        <div class="meta-value">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</div>
                    </div>
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
