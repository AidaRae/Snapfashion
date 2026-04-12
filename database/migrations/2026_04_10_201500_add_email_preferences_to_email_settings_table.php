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
        Schema::table('email_settings', function (Blueprint $table) {
            $table->boolean('order_emails_enabled')->default(true)->after('smtp_encryption');
            $table->string('reply_to_address')->nullable()->after('order_emails_enabled');
            $table->string('order_confirmation_subject')->nullable()->after('reply_to_address');
            $table->string('order_status_subject')->nullable()->after('order_confirmation_subject');
            $table->text('custom_message')->nullable()->after('order_status_subject');
            $table->string('bcc_address')->nullable()->after('custom_message');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('email_settings', function (Blueprint $table) {
            $table->dropColumn([
                'order_emails_enabled',
                'reply_to_address',
                'order_confirmation_subject',
                'order_status_subject',
                'custom_message',
                'bcc_address',
            ]);
        });
    }
};
