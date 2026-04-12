<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Show the track order form / handle search.
     */
    public function trackOrderForm(Request $request)
    {
        $code = $request->query('code');
        if ($code) {
            $order = Order::where('tracking_code', $code)->with('items.product')->first();
            if ($order) {
                return view('shop.pages.view-order', compact('order'));
            } else {
                return redirect()->route('shop.track.form')->with('error', 'We could not find an order matching that tracking code. Please try again.');
            }
        }
        return view('shop.pages.track-order-form');
    }

    /**
     * Track an order by its tracking code.
     */
    public function trackOrder(Order $order)
    {
        $order->load('items.product');

        return view('shop.pages.view-order', compact('order'));
    }

    /**
     * About page.
     */
    public function about()
    {
        return view('shop.pages.about');
    }

    /**
     * Contact page.
     */
    public function contact()
    {
        return view('shop.pages.contact');
    }

    /**
     * Handle contact form submission.
     */
    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // TODO: Send contact email or store in database

        return back()->with('success', 'Your message has been sent. We will get back to you shortly!');
    }

    /**
     * FAQ page.
     */
    public function faq()
    {
        return view('shop.pages.faq');
    }

    /**
     * Privacy policy page.
     */
    public function privacy()
    {
        return view('shop.pages.privacy');
    }

    /**
     * Terms of service page.
     */
    public function terms()
    {
        return view('shop.pages.terms');
    }
}
