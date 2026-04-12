<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payment_settings', function (Blueprint $table) {
            $table->boolean('enable_flutterwave')->default(false)->after('paystack_secret_key');
            $table->string('flutterwave_public_key')->nullable()->after('enable_flutterwave');
            $table->string('flutterwave_secret_key')->nullable()->after('flutterwave_public_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_settings', function (Blueprint $table) {
            //
        });
    }
};
