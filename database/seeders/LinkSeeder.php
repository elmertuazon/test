<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Link;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class LinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = Tag::all();

        $author = User::first();

        foreach (range(1, 50) as $_) {
            Link::factory()
                ->for(Category::factory(), 'category')
                ->for($author, 'author')
                ->create();
        }

        $links = Link::all();

        foreach ($links as $link)
        {
            $link->tags()
                ->attach($tags->random(rand(1, 3))->pluck('id')->toArray());
        }
    }
}
