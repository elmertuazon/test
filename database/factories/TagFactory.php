<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tag = $this->faker->unique()->word();
        $slug = Str::slug($tag);
        return [
            'name' => $tag,
            'slug' => $slug,
        ];
    }
}
