<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // User::factory()->count(10)->create();
        User::factory()->create([
            'name' => 'user1',
            'email' => 'user@mail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123'),
        ]);
    }
} 