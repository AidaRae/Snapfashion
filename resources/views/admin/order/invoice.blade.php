<style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 13px;
        color: #333;
        margin: 20px;
        background: #f9f9f9;
    }

    .invoice-container {
        background: #fff;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        max-width: 900px;
        margin: 0 auto;
    }

    .header {
        border-bottom: 1px solid #e1e1e1;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }

    .header h2 {
        margin: 0;
        color: #000;
    }

    .invoice-meta {
        text-align: right;
    }

    .invoice-meta p {
        margin: 2px 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 25px;
    }

    table th,
    table td {
        padding: 10px;
        border: 1px solid #e1e1e1;
        text-align: left;
    }

    table th {
        background: #f1f5ff;
        color: #333;
    }

    .text-right {
        text-align: right;
    }

    .summary {
        padding-top: 15px;
    }

    .summary ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .summary ul li {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .total {
        font-size: 14px;
        font-weight: bold;
        color: #000;
    }

    .footer {
        text-align: center;
        border-top: 1px solid #e1e1e1;
        padding-top: 15px;
        margin-top: 30px;
        color: #777;
    }

    /* Flex helpers for the browser */
    .d-flex {
        display: flex;
    }

    .justify-content-between {
        justify-content: space-between;
    }
</style>
</head>

<body>

    <div class="invoice-container">
        {{-- Header --}}
        <div class="header d-flex justify-content-between">
            <h2>Order Invoice</h2>
            <div class="invoice-meta">
                <p><strong>Invoice No:</strong> #{{ $order->id + 100 }}</p>
                <p><strong>Date:</strong> {{ date('d M, Y', strtotime($order->created_at)) }}</p>
            </div>
        </div>

        {{-- Billing/Shipping details added for completeness --}}
        <div style="margin-bottom: 25px;">
            <h4 style="margin: 0 0 8px 0; font-size: 15px; font-weight: 600; color: #000;">Customer Details</h4>
            <p style="margin: 3px 0; color: #555;"><strong>Name:</strong> {{ $order->customer_name }}</p>
            <p style="margin: 3px 0; color: #555;"><strong>Email:</strong> {{ $order->customer_email }}</p>
            <p style="margin: 3px 0; color: #555;"><strong>Phone:</strong> {{ $order->guest_phone ?? 'N/A' }}</p>
            <p style="margin: 3px 0; color: #555;"><strong>Address:</strong> {{ $order->shipping_address ?? 'N/A' }}</p>
        </div>

        {{-- Order Items --}}
        <h3 style="margin-bottom:10px;">Order Items</h3>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $order_item)
                    @php
                        $product = $order_item->product;
                    @endphp
                    <tr>
                        <td>{{ $product ? $product->name : 'Unknown Product' }}</td>
                        <td>{{ $order_item->quantity }}</td>
                        <td class="text-right">₦{{ number_format($order_item->price, 2) }}</td>
                        <td class="text-right">₦{{ number_format($order_item->price * $order_item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Summary --}}
        <div class="summary">
            <h4 style="margin-bottom:12px; font-size:15px; font-weight:600; color:#000;">
                Total Summary
            </h4>

            <table style="width:100%; border-collapse:collapse; border:none;">
                <tbody>
                    <tr>
                        <td style="padding:8px 10px; text-align:left; border:none; color:#555;">
                            Subtotal
                        </td>
                        <td style="padding:8px 10px; text-align:right; border:none; color:#555;">
                            ₦{{ number_format($order->subtotal, 2) }}
                        </td>
                    </tr>
                    @if ($order->discount_amount > 0)
                        <tr>
                            <td style="padding:8px 10px; text-align:left; border:none; color:#555;">
                                Discount
                            </td>
                            <td style="padding:8px 10px; text-align:right; border:none; color:#555;">
                                - ₦{{ number_format($order->discount_amount, 2) }}
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td style="padding:8px 10px; text-align:left; border:none; color:#555;">
                            Shipping Cost
                        </td>
                        <td style="padding:8px 10px; text-align:right; border:none; color:#555;">
                            ₦0.00
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:8px 10px; text-align:left; border:none; color:#555;">
                            VAT
                        </td>
                        <td style="padding:8px 10px; text-align:right; border:none; color:#555;">
                            ₦0.00
                        </td>
                    </tr>
                    <tr style="background:#f1f5ff; border-top:1px solid #e1e1e1;">
                        <td style="padding:12px 10px; text-align:left; font-weight:bold; color:#000;">
                            Grand Total
                        </td>
                        <td style="padding:12px 10px; text-align:right; font-weight:bold; color:#000; font-size:15px;">
                            ₦{{ number_format($order->total_amount, 2) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

    <script>
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('download') === 'pdf') {
                window.print();
            }
        }
    </script>

</body>

</html>
