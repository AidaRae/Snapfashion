<?php

namespace App\Services;

use App\Mail\OrderConfirmationMail;
use App\Mail\OrderStatusUpdatedMail;
use App\Models\EmailSetting;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Centralizes all order email dispatch logic.
 *
 * Single place to check the admin toggle, send emails, and log.
 * Controllers call this instead of Mail:: directly.
 */
class OrderMailService
{
    /**
     * Dispatch an order confirmation email.
     */
    public static function sendConfirmation(Order $order): void
    {
        if (!static::shouldSend($order)) {
            return;
        }

        try {
            Mail::to($order->guest_email)
                ->send(new OrderConfirmationMail($order));

            Log::info("Order confirmation sent to {$order->guest_email} (#{$order->tracking_code})");
        } catch (\Exception $e) {
            Log::error("Failed to send order confirmation for #{$order->tracking_code}: {$e->getMessage()}");
        }
    }

    /**
     * Dispatch an order status update email.
     */
    public static function sendStatusUpdate(Order $order): void
    {
        if (!static::shouldSend($order)) {
            return;
        }

        try {
            Mail::to($order->guest_email)
                ->send(new OrderStatusUpdatedMail($order));

            Log::info("Order status update sent to {$order->guest_email} (#{$order->tracking_code} → {$order->status})");
        } catch (\Exception $e) {
            Log::error("Failed to send status update for #{$order->tracking_code}: {$e->getMessage()}");
        }
    }

    /**
     * Check if an email should be sent (admin toggle + valid email).
     */
    protected static function shouldSend(Order $order): bool
    {
        $settings = EmailSetting::first();
        $enabled = $settings?->emailsEnabled() ?? true;

        if (!$enabled) {
            Log::info("Order emails disabled — skipping for #{$order->tracking_code}");
            return false;
        }

        if (empty($order->guest_email)) {
            Log::warning("No email address for order #{$order->tracking_code} — skipping");
            return false;
        }

        return true;
    }
}
