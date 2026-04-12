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
        Schema::table('products', function (Blueprint $table) {
            $table->integer('max_purchase_qty')->nullable()->after('stock');
            $table->integer('low_stock_qty')->nullable()->after('max_purchase_qty');
            $table->string('unit')->nullable()->after('low_stock_qty');
            $table->boolean('is_purchasable')->default(true)->after('featured');
            $table->boolean('show_stock_out')->default(true)->after('is_purchasable');
            $table->boolean('is_refundable')->default(false)->after('show_stock_out');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'max_purchase_qty',
                'low_stock_qty',
                'unit',
                'is_purchasable',
                'show_stock_out',
                'is_refundable'
            ]);
        });
    }
};
