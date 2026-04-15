<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();

            // ── General ──
            $table->string('site_name')->default('Snapfashion');
            $table->string('site_title')->default('Snapfashion');
            $table->string('site_address')->default('');
            $table->text('description')->nullable();
            $table->string('timezone')->default('UTC');

            // ── SEO ──
            $table->string('keywords')->nullable();
            $table->string('meta_author')->nullable();
            $table->string('google_analytics')->nullable();
            $table->string('facebook_pixel')->nullable();
            $table->text('custom_header_code')->nullable();

            // ── Branding ──
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();

            // ── Contact ──
            $table->string('phone_num')->nullable();
            $table->string('contact_instagram')->nullable();

            // ── Banner ──
            $table->boolean('banner_enabled')->default(false);
            $table->string('banner_tag')->nullable();
            $table->string('banner_title')->nullable();
            $table->string('banner_subtitle')->nullable();
            $table->string('banner_button_text')->nullable();
            $table->string('banner_link')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('banner_bg_color')->default('#2C2218');
            $table->string('banner_text_color')->default('#F7F3EE');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
