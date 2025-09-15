<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'User 1',
            'email' => 'user_1@example.com',
            'password' => Hash::make('123123'),
        ]);

        User::factory()->create([
            'name' => 'User 2',
            'email' => 'user_2@example.com',
            'password' => Hash::make('123123')
        ]);
    }
}
