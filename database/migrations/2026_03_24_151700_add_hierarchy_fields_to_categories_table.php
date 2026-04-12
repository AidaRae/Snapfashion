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
        Schema::table('categories', function (Blueprint $table) {
            $table->string('title')->nullable()->after('name');
            $table->unsignedBigInteger('parent_id')->default(0)->after('id');
            $table->integer('sort')->default(0)->after('is_active');
            $table->string('thumbnail')->nullable()->after('image');
            $table->string('icon')->nullable()->after('thumbnail');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['title', 'parent_id', 'sort', 'thumbnail', 'icon']);
        });
    }
};
