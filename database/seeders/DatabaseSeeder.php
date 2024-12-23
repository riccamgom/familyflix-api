<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->createMany([
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => 'pass123',
            ],
            [
                'name' => 'Test User 2',
                'email' => 'test2@example.com',
                'password' => 'pass123',
            ],
            [
                'name' => 'Test User 3',
                'email' => 'test3@example.com',
                'password' => 'pass123',
            ],
        ]);
    }
}
