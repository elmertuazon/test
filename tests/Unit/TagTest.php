<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Link;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function tags_can_have_link()
    {
        $this->signIn();
        $category = Category::factory()->create();
        $link = Link::factory()->create([
            'author_id' => auth()->id(),
            'category_id' => $category->id
        ]);
        $tag = Tag::factory()->create();
        $link->tags()->sync([$tag->id]);
        
        foreach($link->tags as $tag) 
        {
            $this->assertInstanceOf(Collection::class, $tag->links);
        }
    }
}
