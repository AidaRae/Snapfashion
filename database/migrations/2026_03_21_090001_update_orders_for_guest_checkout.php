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
        Schema::table('orders', function (Blueprint $table) {
            // Make user_id nullable for guest orders
            $table->unsignedBigInteger('user_id')->nullable()->change();

            // Guest checkout fields
            $table->string('guest_name')->nullable()->after('user_id');
            $table->string('guest_email')->nullable()->after('guest_name');
            $table->string('guest_phone')->nullable()->after('guest_email');

            // Tracking
            $table->string('tracking_code')->unique()->nullable()->after('payment_status');

            // Order extras
            $table->text('notes')->nullable()->after('tracking_code');
            $table->string('coupon_code')->nullable()->after('notes');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('coupon_code');
            $table->decimal('subtotal', 12, 2)->default(0)->after('discount_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'guest_name', 'guest_email', 'guest_phone',
                'tracking_code', 'notes', 'coupon_code',
                'discount_amount', 'subtotal',
            ]);
        });
    }
};
