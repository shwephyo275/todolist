<?php

namespace Database\Factories;

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
    public function definition(): array
    {
        $address = ['yangon', 'mandalay', 'pyay', 'bago', 'pyin oo lwin', 'taung gyi'];
        return [
            'title' => $this->faker->sentence(8),
            'description' => $this->faker->text(200),
            'price' => rand(200, 5000),
            'address' => $address[array_rand($address)],
            'rating' => rand(0,5)
        ];
    }
}
