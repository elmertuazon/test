<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageTagsTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /** @test */
    public function a_post_can_have_tags()
    {
        $post = Post::factory()->create();
        $tag = Tag::factory()->create();
        $post->tags()->sync([$tag->id]);

        $this->assertDatabaseHas('tags', [
            'name' => $tag->name,
            'slug' => $tag->slug,
        ]);

        $this->assertDatabaseHas('taggables', [
            'tag_id' => $tag->id,
            'taggable_type' => 'App\Models\Post',
            'taggable_id' => $post->id
        ]);
    }

    /** @test */
    public function a_post_can_have_updated_tags()
    {
        $post = Post::factory()->create();
        $tags = Tag::factory(2)->create();

        $post->tags()->sync([$tags[0]->id]);

        $this->assertDatabaseHas('tags', [
            'name' => $tags[0]->name,
            'slug' => $tags[0]->slug,
        ]);
        $this->assertDatabaseHas('tags', [
            'name' => $tags[1]->name,
            'slug' => $tags[1]->slug,
        ]);

        $post->tags()->sync([$tags[1]->id]);

        $this->assertDatabaseMissing('taggables', [
            'tag_id' => $tags[0]->id,
            'taggable_type' => 'App\Models\Post',
            'taggable_id' => $post->id
        ]);

        $this->assertDatabaseHas('taggables', [
            'tag_id' => $tags[1]->id,
            'taggable_type' => 'App\Models\Post',
            'taggable_id' => $post->id
        ]);
    }

    /** @test */
    public function tag_can_show_list()
    {
        $tag = Tag::factory()->create();
        $this->get(route('tag.show', $tag))
            ->assertStatus(200);
    }

}
