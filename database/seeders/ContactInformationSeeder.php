<?php

namespace Database\Seeders;

use App\Models\ContactInformation;
use App\Models\Profile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profiles = Profile::all();
        foreach ($profiles as $profile) {
            $profile->contactInformation()->saveMany(ContactInformation::factory()->count(rand(1,4))->create());
        }
    }
}
