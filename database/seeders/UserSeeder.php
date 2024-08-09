<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Alejandro Imbachí Hoyos',
            'email' => 'alejoimbachihoyos@gmail.com',
            'password' => Hash::make('buenas')
        ]);

        User::factory()->create([
            'name' => 'Johann Alexander Campo',
            'email' => 'johann@gmail.com',
            'password' => Hash::make('holamundo')
        ]);

        User::factory()->count(4)->create();
    }
}
