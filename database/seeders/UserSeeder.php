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
            'email' => 'test@mail.com',
            'password' => Hash::make('buenas')
        ]);

        User::factory()->count(4)->create();
    }
}
