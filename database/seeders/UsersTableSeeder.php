<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create one admin user
        User::factory()->admin()->create();

        // Create 50 regular users
        User::factory()->count(15)->create();

        // Create 10 unverified users
        User::factory()->count(10)->unverified()->create();
    }
}
