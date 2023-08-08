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
            'title' => implode(' ', $this->faker->words(3)),
            'introduction' => $this->faker->paragraph(2),
            'url' => $this->faker->url,
            'author_id' => User::factory(),
            'category_id' => Category::factory(),
            'publish_at' => $this->faker->dateTimeBetween('-2 year', '-1 day'),
            'status' => $this->faker->randomElement(['draft', 'accepted'])
        ];
    }

    public function draft()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'draft',
            ];
        });
    }
}
