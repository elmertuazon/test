<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'introduction' => $this->faker->sentences(2, true),
            'url' => 'https://www.google.com',
            'author_id' => User::factory(),
            'category_id' => Category::factory(),
            'publish_at' => $this->faker->dateTimeBetween('-2 year', '-1 day'),
            'status' => $this->faker->randomElement(['draft', 'accepted'])
        ];
    }
}
