<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@edubridge.com',
            'password' => Hash::make('password'),
            'role' => 'Admin',
        ]);

        User::create([
            'name' => 'Organization User',
            'email' => 'org@edubridge.com',
            'password' => Hash::make('password'),
            'role' => 'Organization',
        ]);

        User::create([
            'name' => 'Youth User',
            'email' => 'youth@edubridge.com',
            'password' => Hash::make('password'),
            'role' => 'Youth',
        ]);
    }
}
