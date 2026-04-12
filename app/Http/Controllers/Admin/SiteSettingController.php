<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
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
     * Show the site settings form.
     */
    public function siteSettings()
    {
        $settings = Settings::group('general')->pluck('value', 'key');

        return view('admin.settings.site_setting.index', compact('settings'));
    }

    /**
     * Show the email settings form.
     */
    public function emailSettings()
    {
        $settings = Settings::group('email')->pluck('value', 'key');

        return view('admin.settings.site_setting.email', compact('settings'));
    }

    /**
     * Show the payment settings form.
     */
    public function paymentSettings()
    {
        $settings = Settings::group('payment')->pluck('value', 'key');

        return view('admin.settings.payment_setting.index', compact('settings'));
    }

    /**
     * Show the website info settings form.
     */
    public function webSettings()
    {
        $settings = Settings::group('general')->pluck('value', 'key');
        $timezones = timezone_identifiers_list();
        
        $currenciesPath = __DIR__ . '/currencies.php';
        if (file_exists($currenciesPath)) {
            include $currenciesPath;
        } else {
            $currencies = [];
        }

        return view('admin.settings.site_setting.webinfo', compact('settings', 'timezones', 'currencies'));
    }

    // for front end content management
    function RandomStringGenerator($n)
    {
        $generated_string = "";
        $domain = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        $len = strlen($domain);
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, $len - 1);
            $generated_string = $generated_string . $domain[$index];
        }
        return $generated_string;
    }

    /**
     * Update website info settings (from webinfo form).
     */
    public function updateWebInfo(Request $request)
    {
        $request->validate([
            'logo' => 'mimes:jpg,jpeg,png,svg|max:500',
            'favicon' => 'mimes:jpg,jpeg,png,svg|max:500',
        ]);

        $strtxt = $this->RandomStringGenerator(6);

        if ($request->hasfile('logo')) {
            $file = $request->file('logo');
            $logoname = $strtxt . $file->getClientOriginalName();
            $file->storeAs('public/logos', $logoname);
            Settings::set('logo', 'storage/logos/' . $logoname, 'general');
        }

        if ($request->hasfile('favicon')) {
            $favfile = $request->file('favicon');
            $favname = $strtxt . $favfile->getClientOriginalName();
            $favfile->storeAs('public/logos', $favname);
            Settings::set('favicon', 'storage/logos/' . $favname, 'general');
        }

        // Updating standard fields
        $fieldsToUpdate = [
            'newupdate' => $request['update'],
            'site_name' => $request['site_name'],
            'description' => $request['description'],
            'keywords' => $request['keywords'],
            'timezone' => $request['timezone'],
            'site_title' => $request['site_title'],
            'phone_num' => $request['phone_num'],
            'site_address' => $request['site_address'],
            'contact_instagram' => $request['contact_instagram'],
        ];

        foreach ($fieldsToUpdate as $key => $val) {
            if ($val !== null) {
                Settings::set($key, $val, 'general');
            }
        }

        return redirect()->back()->with('success', 'Settings Saved successfully');
    }

    public function updatepreference(Request $request)
    {
        // Validate the inputs
        $request->validate([
            'contact_email' => 'required|string|max:255',
            'currency' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        Settings::set('contact_email', $request->input('contact_email'), 'general');
        Settings::set('currency', $request->input('currency'), 'general');
        Settings::set('location', $request->input('location'), 'general');

        // Update checkboxes
        Settings::set('enable_kyc', $request->has('enable_kyc') ? 1 : 0, 'general');
        Settings::set('enable_kyc_registration', $request->has('enable_kyc_registration') ? 1 : 0, 'general');
        Settings::set('enable_verification', $request->has('email_verify') ? 1 : 0, 'general');

        return redirect()->back()->with('success', 'Settings Saved successfully');
    }

    public function updateemail(Request $request)
    {
        // Validate the inputs
        $request->validate([
            'emailfrom' => 'required|string|max:255',
            'emailfromname' => 'required|string|max:255',
            'smtp_host' => 'required|string|max:255',
            'smtp_port' => 'required|string|max:255',
            'smtp_encrypt' => 'required|string|max:255',
            'smtp_user' => 'required|string|max:255',
            'smtp_password' => 'required|string|max:255',
            'google_id' => 'nullable|string|max:255',
            'google_secret' => 'nullable|string|max:255',
            'google_redirect' => 'nullable|string|max:255',
            'capt_secret' => 'nullable|string|max:255',
            'capt_sitekey' => 'nullable|string|max:255',
        ]);

        Settings::set('mail_server', $request->has('server') ? 1 : 0, 'email');

        $emailFields = ['emailfrom', 'emailfromname', 'smtp_host', 'smtp_port', 'smtp_encrypt', 'smtp_user', 'smtp_password', 'google_id', 'google_secret', 'google_redirect', 'capt_secret', 'capt_sitekey'];
        
        foreach ($emailFields as $field) {
            if ($request->has($field)) {
                Settings::set($field, $request->input($field), 'email');
            }
        }

        return redirect()->back()->with('success', 'Settings Saved successfully');
    }

    /**
     * Bulk-update settings from any settings form.
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
}
