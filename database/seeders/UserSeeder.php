<?php

namespace Database\Seeders;

use App\Domain\Users\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::factory()->admin()->create([
            'name' => 'System Admin',
            'email' => 'admin@example.com',
            'password' => '12345678',
        ]);

        // Owner
        User::factory()->owner()->create([
            'name' => 'Business Owner',
            'email' => 'owner@example.com',
            'password' => '12345678',
        ]);

        // Client
        User::factory()->client()->create([
            'name' => 'Client User',
            'email' => 'client@example.com',
            'password' => '12345678',
        ]);
    }
}
