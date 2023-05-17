<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $category = $this->faker->unique()->word();
        $slug = Str::slug($category);

        return [
            'name' => ucfirst($category),
            'slug' => $slug,
        ];
    }
}
