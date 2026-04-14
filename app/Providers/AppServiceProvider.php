<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;  
use Illuminate\Support\Facades\Queue;  
use Illuminate\Support\Facades\View;    
use Illuminate\Support\Facades\Schema;      

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
                'banner_enabled'     => '0',
                'banner_tag'         => '',
                'banner_title'       => '',
                'banner_subtitle'    => '',
                'banner_button_text' => '',
                'banner_link'        => '',
                'banner_image'       => '',
                'banner_bg_color'    => '#2C2218',
                'banner_text_color'  => '#F7F3EE',
            ];

            if (Schema::hasTable('settings')) {
                $dbSettings = \App\Models\Settings::pluck('value', 'key')->toArray();
                $settings   = array_merge($defaults, $dbSettings);
            } else {
                $settings = $defaults;
            }

            View::share('settings', $settings);

            // ── Apply sender identity from admin email settings ──
            if (Schema::hasTable('email_settings')) {
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
            Queue::failing(function (\Illuminate\Queue\Events\JobFailed $event) {
                Log::critical('Queue job failed permanently', [
                    'connection' => $event->connectionName,
                    'job'        => $event->job->resolveName(),
                    'exception'  => $event->exception->getMessage(),
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Settings boot error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            // Do not throw during migrations — share defaults so views still render
            View::share('settings', [
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
                'banner_enabled'     => '0',
                'banner_tag'         => '',
                'banner_title'       => '',
                'banner_subtitle'    => '',
                'banner_button_text' => '',
                'banner_link'        => '',
                'banner_image'       => '',
                'banner_bg_color'    => '#2C2218',
                'banner_text_color'  => '#F7F3EE',
            ]);
        }
    }


 
}
