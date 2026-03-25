<?php
// database/seeders/AdminSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'name' => 'Chris Admin',
            'email' => 'chrisbetuelmlay@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        Admin::create([
            'name' => 'Admin User',
            'email' => 'admin@oweru.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        Admin::create([
            'name' => 'Moderator User',
            'email' => 'moderator@oweru.com',
            'password' => Hash::make('password'),
            'role' => 'moderator',
            'is_active' => true,
        ]);
    }
}