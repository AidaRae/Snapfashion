<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Show all wishlists with their session IDs
$all = \App\Models\Wishlist::with('product')->get();
echo "=== ALL WISHLIST ENTRIES ===\n";
echo "Total: " . $all->count() . "\n\n";

foreach ($all as $w) {
    $pName = $w->product ? $w->product->name : 'PRODUCT DELETED';
    echo "ID: {$w->id} | Product: {$w->product_id} ({$pName}) | User: " . ($w->user_id ?: 'null') . " | Session: {$w->session_id}\n";
}

echo "\n=== SESSION FILE CHECK ===\n";
$sessionPath = storage_path('framework/sessions');
if (is_dir($sessionPath)) {
    $files = scandir($sessionPath);
    $sessionFiles = array_filter($files, fn($f) => !in_array($f, ['.', '..']));
    echo "Session files in storage: " . count($sessionFiles) . "\n";
    foreach ($sessionFiles as $f) {
        echo "  - {$f}\n";
    }
} else {
    echo "Session driver is not 'file' or path doesn't exist.\n";
    echo "SESSION_DRIVER env: " . env('SESSION_DRIVER', 'not set') . "\n";
}
