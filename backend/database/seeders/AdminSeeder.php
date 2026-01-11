<?php

namespace Database\Seeders;

use App\Domain\User\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@tcg.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // User normal
        User::create([
            'name' => 'User Normal',
            'email' => 'user@tcg.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);
    }
}