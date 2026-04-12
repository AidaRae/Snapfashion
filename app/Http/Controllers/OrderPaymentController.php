<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\OrderMailService;

class OrderPaymentController extends Controller
{
    /**
     * Show the order summary and payment selection page.
     */
    public function pay(Order $order)
    {
        // Ensure the order is still pending payment
        if ($order->payment_status !== 'pending') {
            return redirect()->route('checkout.success', $order)->with('info', 'This order has already been paid/processed.');
        }

        $paymentSettings = PaymentSetting::firstOrCreate([], []);
        $enablePaystack = $paymentSettings->enable_paystack;
        $enableCOD = $paymentSettings->enable_cod;
        $enableBankTransfer = $paymentSettings->enable_bank_transfer;
        $enableFlutterwave = $paymentSettings->enable_flutterwave;

        $order->load('items.product');

        return view('Shop.Order.index', compact(
            'order', 
            'paymentSettings', 
            'enablePaystack', 
            'enableCOD', 
            'enableBankTransfer',
            'enableFlutterwave'
        ));
    }

    /**
     * Process the payment method selected constraints.
     */
    public function process(Request $request, Order $order)
    {
        if ($order->payment_status !== 'pending') {
            return redirect()->route('checkout.success', $order)->with('info', 'This order has already been paid/processed.');
        }

        $rules = [
            'payment_method' => 'required|in:paystack,flutterwave,pod,bank_transfer',
        ];

        if ($request->input('payment_method') === 'bank_transfer') {
            $rules['payment_receipt'] = 'required|file|mimes:jpeg,png,jpg,pdf|max:3072';
        }

        $validated = $request->validate($rules);

        $updateData = ['payment_method' => $validated['payment_method']];

        if ($request->hasFile('payment_receipt')) {
            $path = $request->file('payment_receipt')->store('receipts', 'public');
            $updateData['payment_receipt'] = $path;
        }

        $order->update($updateData);

        // Handle Paystack initialization
        if ($validated['payment_method'] === 'paystack') {
            $paymentSettings = PaymentSetting::firstOrCreate([], []);
            $secretKey = $paymentSettings->paystack_secret_key;
            
            if (empty($secretKey)) {
                return redirect()->back()->with('error', 'Paystack is not configured properly.');
            }

            try {
                $response = Http::withToken($secretKey)->post('https://api.paystack.co/transaction/initialize', [
                    'email' => $order->guest_email,
                    'amount' => $order->total_amount * 100, // Paystack expects amount in Kobo/lowest denomination
                    'reference' => $order->tracking_code,
                    'callback_url' => route('checkout.callback'),
                    'metadata' => [
                        'order_id' => $order->id,
                        'cancel_action' => route('order.pay', $order->tracking_code),
                    ]
                ]);

                if ($response->successful() && $response->json('status')) {
                    return redirect($response->json('data.authorization_url'));
                }

                Log::error('Paystack Initialization Failed: ', $response->json());
                return redirect()->route('order.pay', $order->tracking_code)->with('error', 'Unable to initialize payment gateway.');
            } catch (\Exception $e) {
                Log::error('Paystack Exception: ' . $e->getMessage());
                return redirect()->route('order.pay', $order->tracking_code)->with('error', 'Payment initialization error.');
            }
        }

        // Handle Flutterwave — the JS SDK handles the popup client-side.
        // We just save the payment method; the callback verifies the transaction.
        if ($validated['payment_method'] === 'flutterwave') {
            // Return back to the order page where the Flutterwave JS will open the popup
            return redirect()->route('order.pay', $order->tracking_code)->with('launch_flutterwave', true);
        }

        // Send confirmation email for COD and Bank Transfer
        OrderMailService::sendConfirmation($order);

        return redirect()->route('checkout.success', $order)->with('success', 'Order submitted successfully!');
    }

    /**
     * Handle Flutterwave Callback (redirect after payment).
     */
    public function flutterwaveCallback(Request $request)
    {
        $status = $request->query('status');
        $txRef = $request->query('tx_ref');
        $transactionId = $request->query('transaction_id');

        if ($status !== 'successful' || !$txRef || !$transactionId) {
            // Payment was not successful
            $order = Order::where('tracking_code', $txRef)->first();
            if ($order) {
                return redirect()->route('order.pay', $order->tracking_code)->with('error', 'Payment was not completed. Please try again.');
            }
            return redirect()->route('shop.home')->with('error', 'Payment verification failed.');
        }

        // Verify the transaction server-side with Flutterwave
        $paymentSettings = PaymentSetting::firstOrCreate([], []);
        $secretKey = $paymentSettings->flutterwave_secret_key;

        try {
            $response = Http::withToken($secretKey)
                ->get("https://api.flutterwave.com/v3/transactions/{$transactionId}/verify");

            if (
                $response->successful() &&
                $response->json('status') === 'success' &&
                $response->json('data.status') === 'successful' &&
                $response->json('data.tx_ref') === $txRef
            ) {
                $order = Order::where('tracking_code', $txRef)->first();

                if ($order && $order->payment_status !== 'paid') {
                    $order->update([
                        'payment_method' => 'flutterwave',
                        'payment_status' => 'paid',
                        'status' => 'processing',
                    ]);

                    // Send order confirmation email
                    OrderMailService::sendConfirmation($order);

                    return redirect()->route('checkout.success', $order)->with('success', 'Payment successful and order placed!');
                }

                // Order already paid
                if ($order) {
                    return redirect()->route('checkout.success', $order)->with('info', 'This order has already been paid.');
                }
            }

            Log::error('Flutterwave Verification Failed: ', $response->json() ?? []);
            return redirect()->route('shop.home')->with('error', 'Payment verification failed.');
        } catch (\Exception $e) {
            Log::error('Flutterwave Verification Exception: ' . $e->getMessage());
            return redirect()->route('shop.home')->with('error', 'Payment verification error.');
        }
    }

    /**
     * Handle Paystack Callback.
     */
    public function callback(Request $request)
    {
        $reference = $request->query('reference', $request->query('trxref'));

        if (!$reference) {
            return redirect()->route('shop.home')->with('error', 'No payment reference provided.');
        }

        $paymentSettings = PaymentSetting::firstOrCreate([], []);
        $secretKey = $paymentSettings->paystack_secret_key;

        try {
            $response = Http::withToken($secretKey)->get("https://api.paystack.co/transaction/verify/{$reference}");

            if ($response->successful() && $response->json('status') && $response->json('data.status') === 'success') {
                $orderId = $response->json('data.metadata.order_id');
                $order = Order::find($orderId);

                if ($order) {
                    $order->update([
                        'payment_status' => 'paid',
                        'status' => 'processing'
                    ]);

                    // Send order confirmation email
                    OrderMailService::sendConfirmation($order);

                    return redirect()->route('checkout.success', $order)->with('success', 'Payment successful and order placed!');
                }
            }

            return redirect()->route('shop.home')->with('error', 'Payment verification failed.');
        } catch (\Exception $e) {
            Log::error('Paystack Verification Exception: ' . $e->getMessage());
            return redirect()->route('shop.home')->with('error', 'Payment verification error.');
        }
    }
}
