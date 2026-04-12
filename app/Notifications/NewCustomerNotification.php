<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewCustomerNotification extends Notification
{
    use Queueable;

    public $customerName;
    public $customerEmail;

    public function __construct($name, $email)
    {
        $this->customerName = $name;
        $this->customerEmail = $email;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_customer',
            'title' => 'New Customer Registration',
            'message' => $this->customerName . ' (' . $this->customerEmail . ') has just registered or checked out as a new guest.',
            'url' => route('admin.customers'),
            'amount' => null
        ];
    }
}
