<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactInformation>
 */
class ContactInformationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $is_link = fake()->randomElement([0,1]);
        return [
            'name' => fake()->words(rand(1,3),true),
            'info' => ($is_link) ? fake()->url() : fake()->word(),
            'is_link' => $is_link,
        ];
    }
}
