{{--
    Paystack Inline Payment Partial
    ─────────────────────────────────
    Expected variables (passed from parent view):
      • $order           – the Order model instance
      • $paymentSettings – the PaymentSetting model instance
--}}

@php
    $paystackPublicKey = $paymentSettings->paystack_public_key ?? '';
    $amount            = $order->total_amount;          // e.g. 12500.00
    $amountInKobo      = intval($amount * 100);         // Paystack expects kobo
    $customerEmail     = $order->guest_email;
    $customerName      = $order->guest_name;
    $reference         = $order->tracking_code;         // unique per order
    $callbackUrl       = route('checkout.callback');
@endphp

@if(!empty($paystackPublicKey))
<!-- Paystack Inline JS SDK -->
<script src="https://js.paystack.co/v1/inline.js"></script>

<script>
    /**
     * Open the Paystack inline payment popup.
     * Called when the user clicks "Pay with Paystack" on the order page.
     */
    function payWithPaystack() {
        var handler = PaystackPop.setup({
            key: '{{ $paystackPublicKey }}',
            email: '{{ $customerEmail }}',
            amount: {{ $amountInKobo }},
            currency: 'NGN',
            ref: '{{ $reference }}',
            metadata: {
                custom_fields: [
                    {
                        display_name: 'Customer Name',
                        variable_name: 'customer_name',
                        value: '{{ $customerName }}'
                    },
                    {
                        display_name: 'Order ID',
                        variable_name: 'order_id',
                        value: '{{ $order->id }}'
                    }
                ]
            },
            callback: function(response) {
                // Payment was successful — redirect to your existing callback
                // which verifies the transaction server-side and marks the order paid
                window.location.href = '{{ $callbackUrl }}?reference=' + response.reference;
            },
            onClose: function() {
                // User closed the popup without completing payment
                // Stay on the same page so they can retry
                console.log('Payment popup closed.');
            }
        });

        handler.openIframe();
    }
</script>
@endif
