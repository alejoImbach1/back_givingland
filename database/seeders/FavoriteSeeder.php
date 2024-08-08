<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        foreach ($users as $user) {
            $ids = Post::where('user_id', '!=', $user->id)->pluck('id');
            $ids = $ids->random(rand(1,count($ids)))->all();
            $data = [];
            foreach ($ids as $id) {
                $data[$id] = ['created_at' => now()];
            }
            $user->favorites()->attach($data);
        }
    }
}
