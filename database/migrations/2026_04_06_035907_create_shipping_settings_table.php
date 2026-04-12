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
        Schema::create('shipping_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('free_shipping_threshold', 10, 2)->default(15000);
            $table->string('default_delivery_estimate')->default('3 - 5 business days');
            $table->string('origin_state')->default('Lagos');
            $table->boolean('cod_enabled')->default(true);
            $table->decimal('remote_area_surcharge', 10, 2)->default(1000);
            $table->decimal('bulky_surcharge', 10, 2)->default(2000);
            $table->decimal('bulky_weight_kg', 8, 2)->default(10);
            $table->string('holiday_notice')->nullable();
            $table->json('zones')->nullable();
            $table->json('couriers')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_settings');
    }
};
