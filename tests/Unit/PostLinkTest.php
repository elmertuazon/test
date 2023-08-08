<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Link;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostLinkTest extends TestCase
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

        $this->assertInstanceOf(Collection::class, $link->favorites);
        $this->assertEquals(1, $link->favorites->count());

    }

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
}
