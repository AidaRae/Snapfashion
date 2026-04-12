<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewPaymentNotification extends Notification
{
    use Queueable;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_payment',
            'title' => 'Payment Successful',
            'message' => 'Payment of ₦' . number_format($this->order->total_amount, 2) . ' received for Order #' . ($this->order->tracking_code ?? $this->order->id) . '.',
            'url' => route('admin.order.details', $this->order->id),
            'amount' => $this->order->total_amount
        ];
    }
}
