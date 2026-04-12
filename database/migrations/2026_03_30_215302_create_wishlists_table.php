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
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('session_id')->nullable();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            // Either user_id or session_id should be present. We can index session_id for faster lookups.
            $table->index('session_id');
            // We can add a unique constraint so a user/session can't wishlist the same product twice
            // But since MySQL considers nulls as distinct, a unique compound index with nullable user_id/session_id 
            // is tricky. We'll handle duplicate prevention in the controller.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
