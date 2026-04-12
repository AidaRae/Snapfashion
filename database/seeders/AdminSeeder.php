<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Seed the default admin account.
     */
    public function run(): void
    {
        Admin::firstOrCreate(
            ['email' => 'admin@snapfashion.com'],
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'email' => 'admin@snapfashion.com',
                'password' => Hash::make('password'),
            ]
        );
    }
}
