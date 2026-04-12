<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function paymentSettings()
    {
        return view('admin.settings.payment_setting.index');
    }
}
