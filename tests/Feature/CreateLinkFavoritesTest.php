<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateLinkFavoritesTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_user_can_favorite_a_link()
    {
        $user = $this->signIn();
        $category = Category::factory()->create();
        $link = Link::factory()->create([
            'author_id' => $user->id,
            'category_id' => $category->id
        ]);

        $link->favorites()->create(['user_id'=>$user->id]);

        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'favoritable_type' => get_class($link),
            'favoritable_id' => $link->id
        ]);

    }
}
