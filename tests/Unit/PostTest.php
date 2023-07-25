<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_post_can_have_tags()
    {
        $post = Post::factory()->create();
        $tags = Tag::factory(3)->create();
        $post->tags()->sync($tags->pluck('id'));

        foreach ($tags as $tag) {
            $this->assertDatabaseHas('tags', [
                'name' => $tag->name,
                'slug' => $tag->slug,
            ]);

            $this->assertDatabaseHas('taggables', [
                'tag_id' => $tag->id,
                'taggable_type' => get_class($post),
                'taggable_id' => $post->id
            ]);
        }
    }
}
