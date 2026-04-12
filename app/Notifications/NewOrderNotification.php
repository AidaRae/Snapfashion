<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
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
            'type' => 'new_order',
            'title' => 'New Order Received',
            'message' => 'Order #' . ($this->order->tracking_code ?? $this->order->id) . ' has been placed.',
            'url' => route('admin.order.details', $this->order->id),
            'amount' => $this->order->total_amount
        ];
    }
}
