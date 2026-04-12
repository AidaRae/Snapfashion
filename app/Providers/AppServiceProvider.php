<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            // Default values for every settings key used across views
            $defaults = [
                'site_name'          => config('app.name', 'Snapfashion'),
                'site_title'         => config('app.name', 'Snapfashion'),
                'site_address'       => config('app.url', ''),
                'description'        => '',
                'keywords'           => '',
                'timezone'           => config('app.timezone', 'UTC'),
                'logo'               => '',
                'favicon'            => '',
                'phone_num'          => '',
                'contact_instagram'  => '',
                'meta_author'        => '',
                'google_analytics'   => '',
                'facebook_pixel'     => '',
                'custom_header_code' => '',
            ];

            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                $dbSettings = \App\Models\Settings::pluck('value', 'key')->toArray();
                $settings   = array_merge($defaults, $dbSettings);
            } else {
                $settings = $defaults;
            }

            \Illuminate\Support\Facades\View::share('settings', $settings);

            // ── Apply sender identity from admin email settings ──
            if (\Illuminate\Support\Facades\Schema::hasTable('email_settings')) {
                $emailSettings = \App\Models\EmailSetting::first();

                if ($emailSettings) {
                    if (!empty($emailSettings->mail_from_address)) {
                        config(['mail.from.address' => $emailSettings->mail_from_address]);
                    }
                    if (!empty($emailSettings->mail_from_name)) {
                        config(['mail.from.name' => $emailSettings->mail_from_name]);
                    }
                }
            }

            // ── Log failed queue jobs so silent breakages surface ──
            \Illuminate\Support\Facades\Queue::failing(function (\Illuminate\Queue\Events\JobFailed $event) {
                \Illuminate\Support\Facades\Log::critical('Queue job failed permanently', [
                    'connection' => $event->connectionName,
                    'job'        => $event->job->resolveName(),
                    'exception'  => $event->exception->getMessage(),
                ]);
            });
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Settings boot error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            // Do not throw during migrations — share defaults so views still render
            \Illuminate\Support\Facades\View::share('settings', [
                'site_name'          => config('app.name', 'Snapfashion'),
                'site_title'         => config('app.name', 'Snapfashion'),
                'site_address'       => '',
                'description'        => '',
                'keywords'           => '',
                'timezone'           => 'UTC',
                'logo'               => '',
                'favicon'            => '',
                'phone_num'          => '',
                'contact_instagram'  => '',
                'meta_author'        => '',
                'google_analytics'   => '',
                'facebook_pixel'     => '',
                'custom_header_code' => '',
            ]);
        }
    }


 
}
