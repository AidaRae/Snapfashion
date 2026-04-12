<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailSetting extends Model
{
    protected $fillable = [
        // SMTP (kept for backward compat, managed via .env now)
        'mail_from_address',
        'mail_from_name',
        'smtp_host',
        'smtp_port',
        'smtp_username',
        'smtp_password',
        'smtp_encryption',

        // Email preferences (managed via admin UI)
        'order_emails_enabled',
        'reply_to_address',
        'order_confirmation_subject',
        'order_status_subject',
        'custom_message',
        'bcc_address',
    ];

    protected $casts = [
        'order_emails_enabled' => 'boolean',
    ];

    /**
     * Get a cached singleton instance of email settings.
     */
    public static function current(): static
    {
        return static::firstOrCreate([], []);
    }

    /**
     * Check if order emails are enabled.
     */
    public function emailsEnabled(): bool
    {
        return $this->order_emails_enabled ?? true;
    }
}
