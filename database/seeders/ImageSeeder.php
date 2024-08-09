<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Post;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profiles = Profile::all();

        foreach ($profiles as $profile) {
            $profile->image()->create(['url' => 'users_profile_images/default.svg',]);
        }

        $posts = Post::whereNotIn('user_id', [1, 2])->get();

        $defaultFilesNames = array_map('basename', Storage::files('default/posts_images'));

        foreach ($posts as $post) {
            $limit = rand(1, 5);
            for ($i = 0; $i < $limit; $i++) {
                $defaultFileName = $defaultFilesNames[array_rand($defaultFilesNames)];
                $image = $post->images()->create(['url' => "posts_images/{$post->user->username}" . '/image_' . Str::uuid() . '.jpg']);
                Storage::copy('default/posts_images/' . $defaultFileName, 'public/' . $image->url);
            }
        }

        $posts_user_1 = User::find(1)->posts;
        $posts_user_2 = User::find(2)->posts;

        for ($p = 1; $p < 5; $p++) {
            for ($i = 0; $i < 6; $i++) {
                $image_user_1 = $posts_user_1[$p - 1]->images()->create(['url' => "posts_images/{$posts_user_1[$p - 1]->user->username}" . '/image_' . Str::uuid() . '.jpeg']);
                Storage::copy("default/fotosusers/post_{$p}" . ' (' . ($i + 1) . ').jpeg', "public/{$image_user_1->url}");
                $image_user_2 = $posts_user_2[$p - 1]->images()->create(['url' => "posts_images/{$posts_user_2[$p - 1]->user->username}" . '/image_' . Str::uuid() . '.jpeg']);
                Storage::copy('default/fotosusers/post_' . ($p + 4) . ' (' . ($i + 1) . ').jpeg', "public/{$image_user_2->url}");
            }
        }
    }
}
