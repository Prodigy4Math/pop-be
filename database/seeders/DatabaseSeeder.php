<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create an Admin and a sample Peserta for development/testing
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => 'password',
        ]);

        User::factory()->create([
            'name' => 'Peserta Contoh',
            'email' => 'peserta@example.com',
            'role' => 'peserta',
            'age' => 15,
            'school' => 'SMP Contoh',
            'password' => 'password',
        ]);
    }
}
