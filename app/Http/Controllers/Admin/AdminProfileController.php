<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminProfileController extends Controller
{
    /**
     * Display the admin profile page.
     */
    public function index()
    {
        $user = Auth::guard('admin')->user();

        // Stats for the profile hero card
        $stats = [
            'total_orders'   => Order::count(),
            'total_products' => Product::count(),
        ];

        // Recent activity feed (last 10 order + product events)
        $activities = collect();

        // Recent orders as activity items
        $recentOrders = Order::latest()->take(5)->get();
        foreach ($recentOrders as $order) {
            $activities->push([
                'type'        => 'order',
                'description' => "Order #{$order->tracking_code} was placed — ₦" . number_format($order->total_amount, 2),
                'created_at'  => $order->created_at,
            ]);
        }

        // Recently added/updated products
        $recentProducts = Product::latest('updated_at')->take(5)->get();
        foreach ($recentProducts as $product) {
            $activities->push([
                'type'        => 'product',
                'description' => "Product \"{$product->name}\" was updated",
                'created_at'  => $product->updated_at,
            ]);
        }

        // Sort by most recent and limit to 10
        $activities = $activities->sortByDesc('created_at')->take(10)->values();

        return view('admin.profile.profile', compact('stats', 'activities'));
    }

    /**
     * Update admin profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::guard('admin')->user();

        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:50', Rule::unique('admins')->ignore($user->id)],
            'email'    => ['required', 'email', 'max:255', Rule::unique('admins')->ignore($user->id)],
            'phone'    => ['nullable', 'string', 'max:30'],
            'bio'      => ['nullable', 'string', 'max:500'],
            'avatar'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'prefs'    => ['nullable', 'array'],
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        // Split the name into first_name and last_name
        $nameParts = explode(' ', $validated['name'], 2);
        $user->first_name = $nameParts[0];
        $user->last_name  = $nameParts[1] ?? '';

        $user->username = $validated['username'] ?? null;
        $user->email    = $validated['email'];
        $user->phone    = $validated['phone'] ?? null;
        $user->bio      = $validated['bio'] ?? null;

        // Save preferences as JSON
        if ($request->has('prefs')) {
            $prefs = [];
            foreach ($request->input('prefs') as $key => $value) {
                $prefs[$key] = (bool) $value;
            }
            $user->preferences = $prefs;
        }

        $user->save();

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
    }

    /**
     * Update admin password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::guard('admin')->user();

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->password = $request->password;
        $user->save();

        return redirect()->route('admin.profile')->with('success', 'Password updated successfully.');
    }
}
