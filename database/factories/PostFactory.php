<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;
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
            'body' => $this->faker->paragraph(),
            'author' => $this->faker->name(),
            'category_id' => Category::factory(),
        ];
    }
}
