<?php

namespace Tests\Feature;

use App\Mail\PostCreated;
use App\Mail\PostStatusUpdated;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
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
    public function post_show_list_page()
    {
        $this->signIn();
        $this->actingAs(auth()->user())
            ->get(route('home', ['month' => '2021-01']))
            ->assertStatus(200);
    }

    /** @test */
    public function post_show_my_posts()
    {
        $this->signIn();
        $this->actingAs(auth()->user())
            ->get(route('user.posts'))
            ->assertStatus(200);
    }

    /** @test */
    public function an_authenticated_user_can_see_the_post_create_view()
    {
        $this->signIn();

        $this->get(route('posts.create'))
            ->assertStatus(200);
    }

    /** @test */
    public function a_user_can_create_a_post()
    {
        Storage::fake();
        $this->withoutExceptionHandling();
        $this->signIn()->createAdmin();

        $postData = Post::factory()->make()->toArray();
        $tag = Tag::factory()->create();
        $postData['tags'] = [$tag->id];
        $postData['image'] = UploadedFile::fake()->image('cover.jpg', 200, 200);

        $response = $this->post(route('posts.store'), $postData);
        $response->assertStatus(302);
        $this->assertDatabaseHas('tags', [
            'name' => $tag->name,
            'slug' => $tag->slug,
        ]);

        Storage::assertExists('uploads/' .$postData['image']->hashName());

        $this->assertDatabaseHas('taggables', [
            'tag_id' => $tag->id,
            'taggable_type' => Post::class,
        ]);
    }

    /** @test */
    public function post_created_image_has_validation()
    {
        Storage::fake();
        $this->signIn()->createAdmin();

        $postData = Post::factory()->make()->toArray();
        $tag = Tag::factory()->create();
        $postData['tags'] = [$tag->id];

        // Testing image width min 100px
        $postData['image'] = UploadedFile::fake()->image('cover.jpg', 50, 200);
        $this->post(route('posts.store'), $postData)
        ->assertSessionHasErrors('image');
        Storage::assertMissing('uploads/' .$postData['image']->hashName());

        // Testing image width max 1000px
        $postData['image'] = UploadedFile::fake()->image('cover.jpg', 1050, 200);
        $this->post(route('posts.store'), $postData)
            ->assertSessionHasErrors('image');
        Storage::assertMissing('uploads/' .$postData['image']->hashName());

        // Testing image height min 100px
        $postData['image'] = UploadedFile::fake()->image('cover.jpg', 200, 50);
        $this->post(route('posts.store'), $postData)
            ->assertSessionHasErrors('image');
        Storage::assertMissing('uploads/' .$postData['image']->hashName());

        // Testing image height max 1000px
        $postData['image'] = UploadedFile::fake()->image('cover.jpg', 200, 1050);
        $this->post(route('posts.store'), $postData)
            ->assertSessionHasErrors('image');
        Storage::assertMissing('uploads/' .$postData['image']->hashName());

        // Testing valid image dimension
        $postData['image'] = UploadedFile::fake()->image('cover.jpg', 200, 200);
        $this->post(route('posts.store'), $postData)
            ->assertSessionMissing('image');
        Storage::assertExists('uploads/' .$postData['image']->hashName());

        // Testing uploaded file is an image
        $postData['image'] = "test";
        $this->post(route('posts.store'), $postData)
            ->assertSessionHasErrors('image');

        // Testing uploaded file is a jpg or png
        $postData['image'] = UploadedFile::fake()->create('test.pdf', 200, 200);
        $this->post(route('posts.store'), $postData)
            ->assertSessionHasErrors('image');
    }

    /** @test */
    public function a_post_will_send_mail()
    {
        $this->withoutExceptionHandling();
        $this->signIn()->createAdmin();
        Mail::fake();

        $attributes = Post::factory()->make()->toArray();
        $tag = Tag::factory()->create();
        $attributes['tags'] = [$tag->id];

        $this->post(route('posts.store'), $attributes);

        Mail::assertQueued(PostCreated::class);
    }

    /** @test */
    public function a_user_can_see_a_post()
    {
        $this->signIn();
        $post = Post::factory()->accepted()->create();
        $this->get(route('posts.show', $post))
            ->assertSee($post->title)
            ->assertSee($post->introduction)
            ->assertSeeText($post->body);
    }

    /** @test */
    public function a_user_can_update_a_post()
    {
        $this->signIn();
        $post = Post::factory()->draft()->create(['author_id' => auth()->id()]);

        $attributes = $post->only(['title', 'introduction', 'body', 'category_id', 'status']);
        $attributes['title'] = 'Changed';
        $attributes['status'] = 'accepted';

        $this->get(route('posts.edit', $post))->assertOk();

        $this->actingAs($post->author)
            ->patch(route('posts.update', $post), $attributes)
            ->assertRedirect(route('posts.show', $post));

    }

    /** @test */
    public function a_user_can_send_update_mail()
    {
        $this->signIn();
        $post = Post::factory()->draft()->create(['author_id' => auth()->id()]);
        Mail::fake();
        $attributes = $post->only(['title', 'introduction', 'body', 'category_id', 'status']);
        $attributes['title'] = 'Changed';
        $attributes['status'] = 'accepted';

        $this->get(route('posts.edit', $post))->assertOk();

        $this->actingAs($post->author)
            ->patch(route('posts.update', $post), $attributes);

        Mail::assertQueued(PostStatusUpdated::class);

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

    /** @test */
    public function a_post_can_be_favorited()
    {
        $this->signIn();
        $post = Post::factory()->create();

        $this->actingAs($post->author)
            ->post(route('user.posts.favorite', $post))
            ->assertStatus(302);

        $this->assertDatabaseHas('favorites', [
            'user_id' => $post->author->id,
            'favoritable_type' => get_class($post),
            'favoritable_id' => $post->id
        ]);

        $this->actingAs($post->author)
            ->post(route('user.posts.favorite', $post))
            ->assertStatus(302);

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $post->author->id,
            'favoritable_type' => get_class($post),
            'favoritable_id' => $post->id
        ]);
    }

    /** @test */
    public function crud_user_can_see_post()
    {
        $this->withoutExceptionHandling();
        $user = $this->signInAsAdmin();

        $this->actingAs(auth()->user())
            ->get(route('post.index'))
            ->assertStatus(200);

    }

    /** @test */
    public function crud_user_can_create_post()
    {
        $this->withoutExceptionHandling();
        $this->createAdmin();
        $attributes = Post::factory()->make()->toArray();

        $this->actingAs(auth()->user())
            ->post(route('post.store'), $attributes)
            ->assertStatus(302);
    }

    /** @test */
    public function crud_user_can_update_post()
    {
        $this->withoutExceptionHandling();
        $this->createAdmin();
        $post = Post::factory()->create();
        $attributes = $post->toArray();
        $attributes['name'] = 'changed';

        $this->actingAs(auth()->user())
            ->put(route('post.update', $post), $attributes)
            ->assertStatus(302);

    }

}
