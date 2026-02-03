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
        \App\Models\User::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'phone' => '08123456789',
            'password' => bcrypt('password'),
        ]);

        \App\Models\User::factory(10)->create();
    }
}
