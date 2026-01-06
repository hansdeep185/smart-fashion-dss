<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat user admin default
        User::create([
            'name' => 'Admin Smart Fashion',
            'email' => 'admin@admin.com', // Ini yang dipakai login
            'password' => Hash::make('password'), // Passwordnya 'password'
        ]);
    }
}