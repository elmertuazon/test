<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateLinkFavoritesTest extends TestCase
{
    /** @test */
    public function a_user_can_favorite_a_link()
    {
        $user = $this->signIn();
        $category = Category::factory()->create();
        $link = Link::factory()->create([
            'author_id' => $user->id,
            'category_id' => $category->id
        ]);
        $favorite = $link->favorites()->create(['user_id'=>$user->id]);

        $this->assertDatabaseHas('favorites', $favorite->toArray());

    }
}
