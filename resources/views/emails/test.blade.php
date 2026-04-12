<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Email</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f4f4f7; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #10b981, #059669); padding: 30px; text-align: center; color: #fff; }
        .header h1 { margin: 0; font-size: 24px; }
        .content { padding: 30px; }
        .check-icon { display: inline-block; width: 60px; height: 60px; background: #d1fae5; border-radius: 50%; margin: 0 auto 20px; line-height: 60px; font-size: 32px; text-align: center; }
        .footer { text-align: center; padding: 20px 30px; color: #999; font-size: 12px; border-top: 1px solid #eee; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ SMTP Test Successful</h1>
        </div>
        <div class="content">
            <div style="text-align: center;">
                <div class="check-icon">🎉</div>
                <h2 style="color: #333; margin-bottom: 10px;">Your email settings are working!</h2>
                <p style="color: #666; font-size: 14px; line-height: 1.6;">
                    This test email confirms that your SMTP configuration is correct.
                    Order confirmation and status update emails will now be delivered to your customers automatically.
                </p>
            </div>

            <div style="background: #f0fdf4; border-radius: 8px; padding: 16px; margin-top: 24px; border: 1px solid #bbf7d0;">
                <p style="margin: 0; font-size: 13px; color: #166534;">
                    <strong>What happens now?</strong><br>
                    Customers will receive email notifications when:
                </p>
                <ul style="margin: 8px 0 0; padding-left: 20px; font-size: 13px; color: #166534;">
                    <li>They place a new order (Order Confirmation)</li>
                    <li>You update an order status (Processing, Shipped, Delivered, Cancelled)</li>
                </ul>
            </div>
        </div>
        <div class="footer">
            <p>Sent from {{ config('app.name') }} at {{ now()->format('M d, Y h:i A') }}</p>
        </div>
    </div>
</body>
</html>
