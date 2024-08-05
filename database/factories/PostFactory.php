<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Location;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function configure(): static
    {
        return $this->afterMaking(function (Post $post) {
            if ($post->purpose == 'intercambio') {
                $post->expected_item = fake()->words(rand(1,5),true);
            }
            $post->save();
        });
    }
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(4,true),
            'purpose' => fake()->randomElement(['donación','intercambio']),
            'description' => fake()->text(),
            'user_id' => User::all()->random()->id,
            'category_id' => Category::all()->random()->id,
            'location_id' => Location::all()->random()->id,
        ];
    }
}
