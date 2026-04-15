<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailSetting;
use App\Models\PaymentSetting;
use App\Models\Settings;
use App\Models\ShippingSetting;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSettingController extends Controller
{
    /**
     * Display the settings overview page.
     */
    public function index()
    {
        $settings = Settings::all()->groupBy('group');

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * General settings update.
     */
    public function update(Request $request)
    {
        $group = $request->input('group', 'general');
        $settings = $request->except(['_token', '_method', 'group']);

        foreach ($settings as $key => $value) {
            Settings::set($key, $value, $group);
        }

        return back()->with('success', 'Settings updated successfully.');
    }

    /**
     * Show shipping settings.
     */
    public function shipping()
    {
        $settings = ShippingSetting::firstOrCreate([], []);

        return view('admin.settings.site_setting.shipping_setup', compact('settings'));
    }

    /**
     * Update shipping settings.
     */
    public function updateShipping(Request $request)
    {
        $settings = ShippingSetting::firstOrCreate([], []);

        $settings->fill($request->only([
            'free_shipping_threshold', 'default_delivery_estimate', 'origin_state',
            'remote_area_surcharge', 'bulky_surcharge', 'bulky_weight_kg', 'holiday_notice'
        ]));

        $settings->cod_enabled = $request->boolean('cod_enabled');

        $settings->zones = $request->has('zones') ? array_values($request->input('zones')) : [];
        $settings->couriers = $request->has('couriers') ? $request->input('couriers') : [];

        $settings->save();

        return back()->with('success', 'Shipping settings updated.');
    }

    /**
     * Show payment settings.
     */
    public function payment()
    {
        $settings = PaymentSetting::firstOrCreate([], []);

        return view('admin.settings.payment_setting.payment_setting', compact('settings'));
    }

    /**
     * Update payment settings.
     */
    public function updatePayment(Request $request)
    {
        $settings = PaymentSetting::firstOrCreate([], []);

        $settings->fill([
            'bank_name' => $request->input('bank_name'),
            'bank_account_number' => $request->input('bank_account_number'),
            'bank_account_name' => $request->input('bank_account_name'),
            'paystack_public_key' => $request->input('paystack_public_key'),
            'paystack_secret_key' => $request->input('paystack_secret_key'),
            'flutterwave_public_key' => $request->input('flutterwave_public_key'),
            'flutterwave_secret_key' => $request->input('flutterwave_secret_key'),
        ]);

        $settings->enable_cod = $request->boolean('enable_cod');
        $settings->enable_bank_transfer = $request->boolean('enable_bank_transfer');
        $settings->enable_paystack = $request->boolean('enable_paystack');
        $settings->enable_flutterwave = $request->boolean('enable_flutterwave');

        $settings->save();

        return back()->with('success', 'Payment settings updated.');
    }

    /**
     * Show email settings.
     */
    public function email()
    {
        $settings = EmailSetting::firstOrCreate([], []);

        return view('admin.settings.email', compact('settings'));
    }

    /**
     * Update email settings.
     */
    public function updateEmail(Request $request)
    {
        $request->validate([
            'mail_from_name'              => 'required|string|max:255',
            'mail_from_address'           => 'required|email|max:255',
            'reply_to_address'            => 'nullable|email|max:255',
            'order_confirmation_subject'  => 'nullable|string|max:255',
            'order_status_subject'        => 'nullable|string|max:255',
            'custom_message'              => 'nullable|string|max:2000',
            'bcc_address'                 => 'nullable|email|max:255',
        ]);

        $settings = EmailSetting::firstOrCreate([], []);

        $settings->fill($request->only([
            'mail_from_name', 'mail_from_address', 'reply_to_address',
            'order_confirmation_subject', 'order_status_subject',
            'custom_message', 'bcc_address',
        ]));

        $settings->order_emails_enabled = $request->boolean('order_emails_enabled', false);

        $settings->save();

        return back()->with('success', 'Email settings updated.');
    }

    /**
     * Send a test email to verify email configuration.
     */
    public function sendTestEmail(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email|max:255',
        ]);

        try {
            \Illuminate\Support\Facades\Mail::to($request->input('test_email'))
                ->send(new \App\Mail\TestMail());

            return back()->with('success', 'Test email sent successfully to ' . $request->input('test_email') . '!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send test email: ' . $e->getMessage());
        }
    }

    /**
     * Show website info settings.
     */
    public function webSettings()
    {
        $settings = SiteSetting::firstOrCreate([], [
            'site_name' => config('app.name', 'Snapfashion'),
            'site_title' => config('app.name', 'Snapfashion'),
            'site_address' => config('app.url', ''),
        ]);

        $shipping  = ShippingSetting::firstOrCreate([], [])->toArray();
        $timezones = timezone_identifiers_list();

        return view('admin.settings.site_setting.webinfo', compact('settings', 'shipping', 'timezones'));
    }

    /**
     * Update website info settings.
     */
    public function updateWebInfo(Request $request)
    {
        $request->validate([
            'site_name'    => 'required|string|max:255',
            'site_title'   => 'required|string|max:255',
            'site_address' => 'required|string|max:255',
            'logo'         => 'nullable|mimes:jpg,jpeg,png,svg,webp|max:500',
            'favicon'      => 'nullable|mimes:jpg,jpeg,png,svg,webp|max:500',
            'banner_image' => 'nullable|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $settings = SiteSetting::firstOrCreate([], []);

        // Random prefix to prevent filename collisions
        $strtxt = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'), 0, 6);

        // ── File uploads ──
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $logoName = $strtxt . '_' . $file->getClientOriginalName();
            $file->storeAs('public/logos', $logoName);
            $settings->logo = 'storage/logos/' . $logoName;
        }

        if ($request->hasFile('favicon')) {
            $file = $request->file('favicon');
            $favName = $strtxt . '_' . $file->getClientOriginalName();
            $file->storeAs('public/logos', $favName);
            $settings->favicon = 'storage/logos/' . $favName;
        }

        if ($request->hasFile('banner_image')) {
            $file = $request->file('banner_image');
            $bannerName = $strtxt . '_' . $file->getClientOriginalName();
            $file->storeAs('public/banners', $bannerName);
            $settings->banner_image = 'banners/' . $bannerName;
        }

        // ── Home Slides ──
        for ($i = 1; $i <= 5; $i++) {
            $field = 'home_slide_' . $i;
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $slideName = $strtxt . '_' . $file->getClientOriginalName();
                $file->storeAs('public/slides', $slideName);
                $settings->{$field} = 'slides/' . $slideName;
            } elseif ($request->boolean('remove_' . $field)) {
                $settings->{$field} = null;
            }
        }

        // ── Text fields ──
        $settings->fill($request->only([
            'site_name', 'site_title', 'site_address', 'description', 'keywords',
            'timezone', 'phone_num', 'contact_instagram',
            'meta_author', 'google_analytics', 'facebook_pixel', 'custom_header_code',
            'banner_tag', 'banner_title', 'banner_subtitle',
            'banner_button_text', 'banner_link', 'banner_bg_color', 'banner_text_color',
        ]));

        $settings->banner_enabled = $request->boolean('banner_enabled');
        $settings->save();

        // ── Shipping fields (stored in 'shipping_settings' table) ──
        $shippingSettings = ShippingSetting::firstOrCreate([], []);
        $request->merge([
            'is_enabled' => $request->has('is_enabled'),
            'is_flat_rate_enabled' => $request->has('is_flat_rate_enabled'),
            'is_free_shipping_enabled' => $request->has('is_free_shipping_enabled'),
        ]);

        $shippingSettings->fill($request->only([
            'is_enabled', 'is_flat_rate_enabled', 'is_free_shipping_enabled', 'flat_rate_price', 'free_shipping_threshold', 'default_delivery_estimate', 'origin_state',
            'remote_area_surcharge', 'bulky_surcharge', 'bulky_weight_kg', 'holiday_notice'
        ]));

        $shippingSettings->zones = $request->has('zones') ? array_values($request->input('zones')) : [];
        $shippingSettings->couriers = $request->has('couriers') ? $request->input('couriers') : [];

        $shippingSettings->save();

        return back()->with('success', 'Settings saved successfully.');
    }
}
