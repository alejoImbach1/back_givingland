<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\SocialMedia;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $user->profile()->save(Profile::create());
            $socialMedia = SocialMedia::all()->random(rand(1, 5));
            foreach ($socialMedia as $item) {
                $username = ($item->id != 1) ? fake()->userName() : str_shuffle('3014132233');
                $user->profile->socialMedia()->attach($item->id, compact('username'));
            }
        }
    }
}
