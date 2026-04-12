<?php

namespace App\Mail;

use App\Models\EmailSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    protected ?EmailSetting $emailSettings;

    public function __construct()
    {
        $this->emailSettings = EmailSetting::first();
    }

    public function envelope(): Envelope
    {
        $envelope = new Envelope(
            subject: 'Test Email — ' . ($this->emailSettings?->mail_from_name ?: config('app.name')) . ' Email Working!',
        );

        // From name override
        if ($this->emailSettings?->mail_from_name) {
            $fromAddress = $this->emailSettings->mail_from_address ?: config('mail.from.address');
            $envelope->from = new Address($fromAddress, $this->emailSettings->mail_from_name);
        }

        // Reply-to
        if ($this->emailSettings?->reply_to_address) {
            $envelope->replyTo = [new Address($this->emailSettings->reply_to_address)];
        }

        return $envelope;
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.test',
        );
    }
}
