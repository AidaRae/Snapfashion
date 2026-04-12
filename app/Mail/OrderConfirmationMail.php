<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\EmailSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected ?EmailSetting $emailSettings;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Order $order
    ) {
        $this->emailSettings = EmailSetting::first();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->emailSettings?->order_confirmation_subject
            ?: 'Order Confirmation — #' . $this->order->tracking_code;

        // Replace placeholders in custom subject
        $subject = str_replace(
            ['{tracking_code}', '{order_id}'],
            [$this->order->tracking_code, $this->order->id],
            $subject
        );

        $envelope = new Envelope(subject: $subject);

        // From name override
        if ($this->emailSettings?->mail_from_name) {
            $fromAddress = $this->emailSettings->mail_from_address ?: config('mail.from.address');
            $envelope->from = new Address($fromAddress, $this->emailSettings->mail_from_name);
        }

        // Reply-to
        if ($this->emailSettings?->reply_to_address) {
            $envelope->replyTo = [new Address($this->emailSettings->reply_to_address)];
        }

        // BCC for admin notifications
        if ($this->emailSettings?->bcc_address) {
            $envelope->bcc = [new Address($this->emailSettings->bcc_address)];
        }

        return $envelope;
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order-confirmation',
            with: [
                'order' => $this->order->load('items.product'),
                'trackingUrl' => route('order.track', $this->order->tracking_code),
                'customMessage' => $this->emailSettings?->custom_message,
            ],
        );
    }
}
