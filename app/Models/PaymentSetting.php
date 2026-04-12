<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    protected $fillable = [
        'enable_cod',
        'enable_bank_transfer',
        'bank_name',
        'bank_account_number',
        'bank_account_name',
        'enable_paystack',
        'paystack_public_key',
        'paystack_secret_key',
        'enable_flutterwave',
        'flutterwave_public_key',
        'flutterwave_secret_key',
    ];
}
