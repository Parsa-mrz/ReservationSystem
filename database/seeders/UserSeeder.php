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
        ]);

        // Owner
        User::factory()->owner()->create([
            'name' => 'Business Owner',
            'email' => 'owner@example.com',
        ]);

        // Client
        User::factory()->client()->create([
            'name' => 'Client User',
            'email' => 'client@example.com',
        ]);
    }
}
