<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_favorite_a_link()
    {
        $this->signIn();
        $category = Category::factory()->create();
        $link = Link::factory()->create([
            'author_id' => auth()->id(),
            'category_id' => $category->id
        ]);

        $link->favorites()->create(['user_id'=> auth()->id()]);

        $this->assertDatabaseHas('favorites', [
            'user_id' => auth()->id(),
            'favoritable_type' => get_class($link),
            'favoritable_id' => $link->id
        ]);

    }
}
