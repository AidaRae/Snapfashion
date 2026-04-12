<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentFailureNotification extends Notification
{
    use Queueable;

    public $order;
    public $reason;

    public function __construct($order, $reason = 'Payment verification failed')
    {
        $this->order = $order;
        $this->reason = $reason;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'payment_failure',
            'title' => 'Payment Failed',
            'message' => 'Payment failed for Order #' . ($this->order->tracking_code ?? $this->order->id) . '. ' . $this->reason,
            'url' => route('admin.order.details', $this->order->id),
            'amount' => $this->order->total_amount
        ];
    }
}
