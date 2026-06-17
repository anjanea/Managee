<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed regular user (Penyewa)
        \App\Models\User::updateOrCreate(
            ['email' => 'penyewa@managee.com'],
            [
                'name' => 'Budi Santoso',
                'password' => bcrypt('password123'),
                'role' => 'user',
            ]
        );

        // Seed property Owner
        \App\Models\User::updateOrCreate(
            ['email' => 'owner@managee.com'],
            [
                'name' => 'Pak Hendra (Owner)',
                'password' => bcrypt('password123'),
                'role' => 'owner',
            ]
        );
    }
}
