<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = Tag::all();

        $author = User::factory()->create([
            'name' => 'Elmer',
            'email' => 'e.tuazon@morrowsodali.com'
        ]);

        foreach (range(1, 50) as $_) {
            Post::factory()
                ->for(Category::factory(), 'category')
                ->for($author, 'author')
                ->create();
        }

        $posts = Post::all();

        foreach ($posts as $post)
        {
            $post->tags()
                ->attach($tags->random(rand(1, 3))->pluck('id')->toArray()
                );
        }
    }
}
