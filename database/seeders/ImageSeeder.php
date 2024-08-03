<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Post;
use App\Models\Profile;
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
            $profile->image()->create(['url' => 'default.svg',]);
        }

        $posts = Post::all();

        $defaultFilesNames = array_map('basename', Storage::files('default/posts_images'));

        foreach ($posts as $post) {
            $limit = rand(1, 5);
            for ($i = 0; $i < $limit; $i++) {
                $defaultFileName = $defaultFilesNames[array_rand($defaultFilesNames)];
                $image = $post->images()->create(['url' => 'posts_images/' . $post->user->username . '/image_' .Str::uuid().'.jpg']);
                Storage::copy('default/posts_images/' . $defaultFileName, 'public/'. $image->url);
            }
        }
    }
}
