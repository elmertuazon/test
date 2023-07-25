<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Link;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageLinksTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /** @test */
    public function link_can_have_a_comment()
    {
        $this->signIn();
        $category = Category::factory()->create();
        $link = Link::factory()->create([
            'author_id' => auth()->id(),
            'category_id' => $category->id
        ]);
        $link->comments()->create([
            'user_id' => auth()->id(),
            'body' => 'sample link'
        ]);

        $this->assertDatabaseHas('links', [
            'title' => $link->title,
            'introduction' => $link->introduction,
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => auth()->id(),
            'body' => 'sample link',
            'commentable_type' => 'App\Models\Link',
            'commentable_id' => $link->id
        ]);
    }

    /** @test */
    public function link_can_have_tags()
    {
        $this->signIn();
        $category = Category::factory()->create();
        $link = Link::factory()->create([
            'author_id' => auth()->id(),
            'category_id' => $category->id
        ]);
        $tag = Tag::factory()->create();
        $link->tags()->sync([$tag->id]);

        $this->assertDatabaseHas('taggables', [
            'tag_id' => $tag->id,
            'taggable_type' => 'App\Models\Link',
            'taggable_id' => $link->id
        ]);
    }

    /** @test */
    public function link_can_show_create_page()
    {
        $this->signIn();
        $this->actingAs(auth()->user())
            ->get(route('links.create'))
            ->assertStatus(200);
    }

    /** @test */
    public function link_can_show_edit_page()
    {
        $this->signIn();
        $category = Category::factory()->create();
        $link = Link::factory()->create([
            'author_id' => auth()->id(),
            'category_id' => $category->id
        ]);
        $this->actingAs(auth()->user())
            ->get(route('links.edit', $link))
            ->assertStatus(200);
    }

    /** @test */
    public function link_can_be_update()
    {
        $this->signIn();
        $category = Category::factory()->create();
        $link = Link::factory()->create([
            'author_id' => auth()->id(),
            'category_id' => $category->id
        ]);
        $tags = Tag::factory(2)->create();
        $link->tags()->sync([$tags[0]->id]);

        $this->assertDatabaseHas('tags', [
            'name' => $tags[0]->name,
            'slug' => $tags[0]->slug,
        ]);
        $this->assertDatabaseHas('tags', [
            'name' => $tags[1]->name,
            'slug' => $tags[1]->slug,
        ]);

        $link->tags()->sync([$tags[1]->id]);

        $this->assertDatabaseMissing('taggables', [
            'tag_id' => $tags[0]->id,
            'taggable_type' => 'App\Models\Link',
            'taggable_id' => $link->id
        ]);

        $this->assertDatabaseHas('taggables', [
            'tag_id' => $tags[1]->id,
            'taggable_type' => 'App\Models\Link',
            'taggable_id' => $link->id
        ]);
    }

    /** @test */
    public function link_can_show_comments()
    {
        $this->signIn();
        $category = Category::factory()->create();
        $link = Link::factory()->create([
            'author_id' => auth()->id(),
            'category_id' => $category->id,
            'status' => 'accepted'
        ]);
        $this->actingAs(auth()->user())
            ->post(route('user.links.comments', $link), [
                'user_id' => auth()->id(),
                'body' => 'sample'
            ])
            ->assertStatus(200);
    }
}
