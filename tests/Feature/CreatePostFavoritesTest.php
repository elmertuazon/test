<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreatePostFavoritesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_favorite_a_post()
    {
        $user = $this->signIn();
        $post = Post::factory()->create(['author_id' => auth()->id()]);
        $favorite = $post->favorites()->create(['user_id' => auth()->id()]);

        $this->assertDatabaseHas('favorites', [
            'user_id' => auth()->id(),
            'favoritable_type' => get_class($post),
            'favoritable_id' => $post->id
        ]);

    }
}
