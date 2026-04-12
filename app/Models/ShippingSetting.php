<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingSetting extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_enabled' => 'boolean',
        'is_flat_rate_enabled' => 'boolean',
        'is_free_shipping_enabled' => 'boolean',
        'flat_rate_price' => 'float',
        'cod_enabled' => 'boolean',
        'zones' => 'array',
        'couriers' => 'array',
    ];
}
