<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManagePostsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_posts()
    {
        $post = Post::factory()->accepted()->create();
        $this->post(route('posts.store'), $post->toArray())->assertRedirect('login');
        $this->get(route('posts.create'))->assertRedirect('login');
        $this->get(route('posts.edit', $post))->assertRedirect('login');
        $this->get(route('posts.show', $post))->assertSee($post->title);
    }

    /** @test */
    public function a_user_can_create_a_post()
    {
        $this->withoutExceptionHandling();
        $this->signIn()->createAdmin();

        $this->get(route('posts.create'))
            ->assertStatus(200);

        $attributes = Post::factory()->make([
            'slug' => 'test-slug',
        ])->toArray();

        $this->followingRedirects()
            ->post(route('posts.store'), $attributes)
            ->assertSee($attributes['title'])
            ->assertSee($attributes['introduction'])
            ->assertSee($attributes['author_id']);
    }

    /** @test */
    public function a_user_can_update_a_post()
    {
        $this->signIn();
        $post = Post::factory()->draft()->create(['author_id' => auth()->id()]);

        $attributes = $post->only(['title', 'introduction', 'body', 'category_id']);
        $attributes['title'] = 'Changed';

        $this->get(route('posts.edit', $post))->assertOk();

        $this->actingAs($post->author)
            ->patch(route('posts.update', $post), $attributes)
            ->assertRedirect(route('posts.show', $post));

    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->signIn();

        $attributes = Post::factory()->raw(['title' => '']);

        $this->post('/posts', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_slug()
    {
        $this->signIn();

        $attributes = Post::factory()->raw(['slug' => '']);

        $this->post('/posts', $attributes)->assertSessionHasErrors('slug');
    }

    /** @test */
    public function a_project_requires_a_introduction()
    {
        $this->signIn();

        $attributes = Post::factory()->raw(['introduction' => '']);

        $this->post('/posts', $attributes)->assertSessionHasErrors('introduction');
    }

    /** @test */
    public function a_project_requires_a_body()
    {
        $this->signIn();

        $attributes = Post::factory()->raw(['body' => '']);

        $this->post('/posts', $attributes)->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_project_requires_a_category_id()
    {
        $this->signIn();

        $attributes = Post::factory()->raw(['category_id' => '']);

        $this->post('/posts', $attributes)->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function an_authenticated_user_cannot_update_post()
    {
        $post = Post::factory()->create();

        $this->patch(route('posts.update', $post))->assertRedirect('login');
    }
}
