<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'guest_name', 'guest_email', 'guest_phone',
        'status', 'total_amount', 'subtotal', 'shipping_fee', 'discount_amount',
        'shipping_address', 'payment_method', 'payment_status', 'payment_receipt',
        'tracking_code', 'notes', 'coupon_code',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
        'discount_amount' => 'decimal:2',
    ];

    /**
     * Auto-generate a unique tracking code on creation.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->tracking_code)) {
                $order->tracking_code = 'SF-' . strtoupper(Str::random(8));
            }
        });
    }

    // ── Relationships ──

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // ── Scopes ──

    public function scopeByGuestEmail($query, string $email)
    {
        return $query->where('guest_email', $email);
    }

    public function scopeRecent($query, int $limit = 10)
    {
        return $query->latest()->limit($limit);
    }

    // ── Accessors ──

    /**
     * Get the customer name (guest or registered user).
     */
    public function getCustomerNameAttribute(): string
    {
        return $this->guest_name ?? ($this->user->name ?? 'N/A');
    }

    /**
     * Get the customer email (guest or registered user).
     */
    public function getCustomerEmailAttribute(): string
    {
        return $this->guest_email ?? ($this->user->email ?? 'N/A');
    }
}
