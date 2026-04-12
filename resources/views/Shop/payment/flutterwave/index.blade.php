{{--
    Flutterwave Inline Payment Partial
    ─────────────────────────────────
    Expected variables (passed from parent view):
      • $order           – the Order model instance
      • $paymentSettings – the PaymentSetting model instance
--}}

@php
    $flutterwavePublicKey = $paymentSettings->flutterwave_public_key ?? '';
    $amount               = $order->total_amount;
    $customerEmail        = $order->guest_email;
    $customerName         = $order->guest_name;
    $customerPhone        = $order->guest_phone ?? '';
    $txRef                = $order->tracking_code;
    $callbackUrl          = route('checkout.flutterwave.callback');
@endphp

@if(!empty($flutterwavePublicKey))
<!-- Flutterwave Inline JS SDK -->
<script src="https://checkout.flutterwave.com/v3.js"></script>

<script>
    /**
     * Open the Flutterwave inline payment popup.
     * Called when the user clicks "Pay with Flutterwave" on the order page.
     */
    function payWithFlutterwave() {
        FlutterwaveCheckout({
            public_key: '{{ $flutterwavePublicKey }}',
            tx_ref: '{{ $txRef }}',
            amount: {{ $amount }},
            currency: 'NGN',
            payment_options: 'card, banktransfer, ussd',
            redirect_url: '{{ $callbackUrl }}',
            customer: {
                email: '{{ $customerEmail }}',
                phone_number: '{{ $customerPhone }}',
                name: '{{ $customerName }}',
            },
            customizations: {
                title: '{{ $settings["site_name"] ?? config("app.name") }}',
                description: 'Payment for Order #{{ $order->tracking_code }}',
            },
            callback: function(response) {
                // Payment completed – redirect to callback for server-side verification
                window.location.href = '{{ $callbackUrl }}?transaction_id=' + response.transaction_id + '&tx_ref=' + response.tx_ref + '&status=' + response.status;
            },
            onclose: function() {
                // User closed the popup without completing payment
                console.log('Flutterwave payment popup closed.');
            }
        });
    }
</script>
@endif
