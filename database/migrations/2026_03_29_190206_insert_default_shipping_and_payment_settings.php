<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $settings = [
            // Shipping Defaults
            ['key' => 'free_shipping_threshold', 'value' => '15000', 'group' => 'shipping'],
            ['key' => 'default_delivery_estimate', 'value' => '3 - 5 business days', 'group' => 'shipping'],
            ['key' => 'origin_state', 'value' => 'Lagos', 'group' => 'shipping'],
            ['key' => 'cod_enabled', 'value' => '1', 'group' => 'shipping'],
            ['key' => 'remote_area_surcharge', 'value' => '1000', 'group' => 'shipping'],
            ['key' => 'bulky_surcharge', 'value' => '2000', 'group' => 'shipping'],
            ['key' => 'bulky_weight_kg', 'value' => '10', 'group' => 'shipping'],
            ['key' => 'holiday_notice', 'value' => '', 'group' => 'shipping'],
            
            // Payment Defaults
            ['key' => 'enable_cod', 'value' => '1', 'group' => 'payment'],
            ['key' => 'enable_bank_transfer', 'value' => '1', 'group' => 'payment'],
            ['key' => 'bank_name', 'value' => '', 'group' => 'payment'],
            ['key' => 'bank_account_number', 'value' => '', 'group' => 'payment'],
            ['key' => 'bank_account_name', 'value' => '', 'group' => 'payment'],
            ['key' => 'enable_paystack', 'value' => '0', 'group' => 'payment'],
            ['key' => 'paystack_public_key', 'value' => '', 'group' => 'payment'],
            ['key' => 'paystack_secret_key', 'value' => '', 'group' => 'payment'],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key'], 'group' => $setting['group']],
                ['value' => $setting['value'], 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $keys = [
            'free_shipping_threshold', 'default_delivery_estimate', 'origin_state', 'cod_enabled', 
            'remote_area_surcharge', 'bulky_surcharge', 'bulky_weight_kg', 'holiday_notice',
            'enable_cod', 'enable_bank_transfer', 'bank_name', 'bank_account_number', 'bank_account_name', 
            'enable_paystack', 'paystack_public_key', 'paystack_secret_key'
        ];

        DB::table('settings')->whereIn('key', $keys)->delete();
    }
};
