<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Settings;
use App\Models\ShippingSetting;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewOrderNotification;
use App\Notifications\NewPaymentNotification;
use App\Notifications\PaymentFailureNotification;
use App\Notifications\NewCustomerNotification;

class CheckoutController extends Controller
{
    /**
     * Display the checkout form.
     */
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $coupon = session()->get('coupon');
        $discount = $coupon ? $coupon['discount'] : 0;
        $total = max(0, $subtotal - $discount);

        // Fetch shipping settings from admin
        $shippingSettings =      ShippingSetting::firstOrCreate([], []);
        $zones = $shippingSettings->zones ?: [];
        $freeShippingThreshold = (float) $shippingSettings->free_shipping_threshold;
        $defaultDeliveryEstimate = $shippingSettings->default_delivery_estimate ?? '3 - 5 business days';
        $holidayNotice = $shippingSettings->holiday_notice ?? '';

        $shippingEnabled = (bool) ($shippingSettings->is_enabled ?? true);
        $flatRateEnabled = (bool) ($shippingSettings->is_flat_rate_enabled ?? false);
        $freeShippingEnabled = (bool) ($shippingSettings->is_free_shipping_enabled ?? false);
        $flatRatePrice   = (float) ($shippingSettings->flat_rate_price ?? 0);
        
        // Build a state-to-zone map for the frontend
        $stateZoneMap = [];

        if ($shippingEnabled && !$freeShippingEnabled) {
            if ($flatRateEnabled) {
                // Ignore all zones; apply single flat rate
                $stateZoneMap['Standard Delivery'] = [
                    'zone'  => 'Standard Delivery',
                    'rate'  => $flatRatePrice,
                    'days'  => $defaultDeliveryEstimate,
                ];
            } else {
                foreach ($zones as $zone) {
                    $statesStr = trim($zone['states'] ?? '');
                    if (empty($statesStr)) {
                        // If the user didn't enter any states, use the zone name as the selectable location itself!
                        $zoneName = trim($zone['name'] ?? 'Unknown Location');
                        if ($zoneName) {
                            $stateZoneMap[$zoneName] = [
                                'zone'  => $zoneName,
                                'rate'  => (float) ($zone['rate'] ?? 0),
                                'days'  => $zone['days'] ?? $defaultDeliveryEstimate,
                            ];
                        }
                    } else {
                        // Admin entered comma separated states
                        $states = array_map('trim', explode(',', $statesStr));
                        foreach ($states as $state) {
                            if ($state) {
                                $stateZoneMap[$state] = [
                                    'zone'  => $zone['name'] ?? '',
                                    'rate'  => (float) ($zone['rate'] ?? 0),
                                    'days'  => $zone['days'] ?? $defaultDeliveryEstimate,
                                ];
                            }
                        }
                    }
                }
            }
        }

        // Determine if free shipping applies
        $qualifiesForFreeShipping = $freeShippingEnabled;

        $countries = [
            'Afghanistan', 'Albania', 'Algeria', 'Andorra', 'Angola', 'Antigua and Barbuda', 'Argentina', 'Armenia', 'Australia', 'Austria',
            'Azerbaijan', 'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bhutan',
            'Bolivia', 'Bosnia and Herzegovina', 'Botswana', 'Brazil', 'Brunei', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Cabo Verde', 'Cambodia',
            'Cameroon', 'Canada', 'Central African Republic', 'Chad', 'Chile', 'China', 'Colombia', 'Comoros', 'Congo', 'Costa Rica',
            'Croatia', 'Cuba', 'Cyprus', 'Czech Republic', 'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic', 'East Timor', 'Ecuador',
            'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Eswatini', 'Ethiopia', 'Fiji', 'Finland', 'France',
            'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Greece', 'Grenada', 'Guatemala', 'Guinea', 'Guinea-Bissau',
            'Guyana', 'Haiti', 'Honduras', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq', 'Ireland',
            'Israel', 'Italy', 'Ivory Coast', 'Jamaica', 'Japan', 'Jordan', 'Kazakhstan', 'Kenya', 'Kiribati', 'Korea North',
            'Korea South', 'Kosovo', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libya',
            'Liechtenstein', 'Lithuania', 'Luxembourg', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Marshall Islands',
            'Mauritania', 'Mauritius', 'Mexico', 'Micronesia', 'Moldova', 'Monaco', 'Mongolia', 'Montenegro', 'Morocco', 'Mozambique',
            'Myanmar', 'Namibia', 'Nauru', 'Nepal', 'Netherlands', 'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'North Macedonia',
            'Norway', 'Oman', 'Pakistan', 'Palau', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Poland',
            'Portugal', 'Qatar', 'Romania', 'Russia', 'Rwanda', 'Saint Kitts and Nevis', 'Saint Lucia', 'Saint Vincent and the Grenadines', 'Samoa', 'San Marino',
            'Sao Tome and Principe', 'Saudi Arabia', 'Senegal', 'Serbia', 'Seychelles', 'Sierra Leone', 'Singapore', 'Slovakia', 'Slovenia', 'Solomon Islands',
            'Somalia', 'South Africa', 'South Sudan', 'Spain', 'Sri Lanka', 'Sudan', 'Suriname', 'Sweden', 'Switzerland', 'Syria',
            'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', 'Togo', 'Tonga', 'Trinidad and Tobago', 'Tunisia', 'Turkey', 'Turkmenistan',
            'Tuvalu', 'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'United States', 'Uruguay', 'Uzbekistan', 'Vanuatu', 'Vatican City',
            'Venezuela', 'Vietnam', 'Yemen', 'Zambia', 'Zimbabwe'
        ];

        return view('shop.checkout.index', compact(
            'cart', 'subtotal', 'coupon', 'discount', 'total',
            'stateZoneMap', 'freeShippingThreshold', 'qualifiesForFreeShipping',
            'defaultDeliveryEstimate', 'holidayNotice', 'countries', 'shippingEnabled', 'freeShippingEnabled'
        ));
    }

    /**
     * Process the guest checkout.
     */
    public function process(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'company_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'address2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'notes' => 'nullable|string|max:500',
        ]);

        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $couponData = session()->get('coupon');
        $discount = $couponData ? $couponData['discount'] : 0;

        // Calculate shipping fee from admin zones
        $shippingFee = $this->calculateShippingFee($validated['state'], $subtotal);
        $total = max(0, $subtotal - $discount + $shippingFee);

        $order = DB::transaction(function () use ($validated, $cart, $subtotal, $discount, $shippingFee, $total, $couponData) {
            
            $fullName = trim($validated['first_name'] . ' ' . $validated['last_name']);
            $fullAddressArray = array_filter([
                $validated['company_name'] ?? null,
                $validated['address'],
                $validated['address2'] ?? null,
                $validated['city'] ?? null,
                $validated['state'],
                $validated['zip_code'] ?? null,
                $validated['country']
            ]);
            $fullAddress = implode(', ', $fullAddressArray);

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'guest_name' => $fullName,
                'guest_email' => $validated['email'],
                'guest_phone' => $validated['phone'],
                'shipping_address' => $fullAddress,
                'payment_method' => 'pending',
                'notes' => $validated['notes'] ?? null,
                'subtotal' => $subtotal,
                'shipping_fee' => $shippingFee,
                'discount_amount' => $discount,
                'total_amount' => $total,
                'coupon_code' => $couponData['code'] ?? null,
                'status' => 'pending',
                'payment_status' => 'pending',
            ]);

            // Create order items & decrement stock
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                Product::where('id', $item['id'])->decrement('stock', $item['quantity']);
            }

            // Increment coupon usage if applied
            if ($couponData) {
                $coupon = Coupon::where('code', $couponData['code'])->first();
                $coupon?->incrementUsage();
            }

            return $order;
        });

        // Clear cart & coupon
        session()->forget(['cart', 'coupon']);

        $admins = Admin::all();

        // Dispatch New Order Notification
        Notification::send($admins, new NewOrderNotification($order));

        // Check if new customer (first order)
        if (Order::where('guest_email', $order->guest_email)->count() === 1) {
            Notification::send($admins, new NewCustomerNotification($order->guest_name, $order->guest_email));
        }

        return redirect()->route('order.pay', $order->tracking_code);
    }

    /**
     * Display the order success page.
     */
    public function success(Order $order)
    {
        $order->load('items.product');

        return view('shop.checkout.success', compact('order'));
    }

    /**
     * Calculate shipping fee based on the customer's state and admin zone settings.
     */
    protected function calculateShippingFee($state, $subtotal)
    {
        // ── SHIPPING CALCULATIONS ──
        $shippingSettings = \App\Models\ShippingSetting::firstOrCreate([], []);
        
        if (isset($shippingSettings->is_enabled) && !$shippingSettings->is_enabled) {
            return 0;
        }

        if (isset($shippingSettings->is_free_shipping_enabled) && $shippingSettings->is_free_shipping_enabled) {
            return 0;
        }

        if (isset($shippingSettings->is_flat_rate_enabled) && $shippingSettings->is_flat_rate_enabled) {
            return (float) ($shippingSettings->flat_rate_price ?? 0);
        }
        
        $zones = $shippingSettings->zones ?: [];
        $fallbackShippingFee = 0;
        
        // Look up state in zones to find shipping rate
        $shippingFee = $fallbackShippingFee;
        $deliveryEstimate = $shippingSettings->default_delivery_estimate ?? '3 - 5 business days';
        
        foreach ($zones as $zone) {
            $statesStr = trim($zone['states'] ?? '');
            
            if (empty($statesStr)) {
                $zoneName = trim($zone['name'] ?? '');
                if ($zoneName === $state) {
                    $shippingFee = (float) ($zone['rate'] ?? 0);
                    $deliveryEstimate = $zone['days'] ?? $deliveryEstimate;
                    break;
                }
            } else {
                $states = array_map('trim', explode(',', $statesStr));
                if (in_array($state, $states)) {
                    $shippingFee = (float) ($zone['rate'] ?? 0);
                    $deliveryEstimate = $zone['days'] ?? $deliveryEstimate;
                    break;
                }
            }
        }

        // Determine free shipping
        $freeShippingThreshold = (float) $shippingSettings->free_shipping_threshold;
        
        if ($freeShippingThreshold > 0 && $subtotal >= $freeShippingThreshold) {
            return 0;
        }

        return $shippingFee;
    }
}
