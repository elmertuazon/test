<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
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

    /** @test */
    public function a_post_can_have_tags_as_links()
    {
        $post = Post::factory()->create();
        $tags = Tag::factory(3)->create();
        $post->tags()->sync($tags->pluck('id'));
        $tagsAsLinks = $post->tagsAsLinks();
        $this->assertEquals($tagsAsLinks, ($tags->map(function ($tag) {
            return '<a href="' . route('tag.show', $tag) . '">#' . $tag->name . '</a>';
        })->implode(', ')));
    }

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

    /** @test */
    public function a_user_can_have_post()
    {
        $this->signIn();
        Post::factory()->create(['author_id' => auth()->id()]);
        
        $this->assertInstanceOf(Collection::class, auth()->user()->posts);
    }

    /** @test */
    public function a_post_has_favorites()
    {
        $user = $this->signIn();
        $posts = Post::factory(3)->create(['author_id' => auth()->id()]);
        foreach($posts as $post)
        {
            $post->favorites()->create(['user_id' => auth()->id()]);
        }
        $this->assertInstanceOf(Collection::class, $post->favorites);
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
    public function a_post_can_have_author()
    {
        $this->signIn();
        $post = Post::factory()->create();
        
        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'body' => 'sample'
        ]);
        $this->assertInstanceOf(User::class, $comment->author);
    }

    /** @test */
    public function a_post_can_have_comments()
    {
        $this->signIn();
        $post = Post::factory()->create();
        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'body' => 'sample'
        ]);
        $this->assertInstanceOf(Post::class, $comment->commentable);
    }
}
