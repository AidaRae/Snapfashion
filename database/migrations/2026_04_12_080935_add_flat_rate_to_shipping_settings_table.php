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
        Schema::table('shipping_settings', function (Blueprint $table) {
            $table->boolean('is_flat_rate_enabled')->default(false)->after('is_enabled');
            $table->decimal('flat_rate_price', 10, 2)->default(0)->after('is_flat_rate_enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipping_settings', function (Blueprint $table) {
            $table->dropColumn(['is_flat_rate_enabled', 'flat_rate_price']);
        });
    }
};
