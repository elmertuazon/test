<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Link;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ManageLinksTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guests_cannot_manage_links()
    {
        $link = Link::factory()->accepted()->create();


        $this->post(route('links.store'), $link->toArray())->assertRedirect('login');
        $this->get(route('links.create'))->assertRedirect('login');
        $this->get(route('links.edit', $link))->assertRedirect('login');

        $this->get(route('links.show', $link))->assertSee($link->title);
    }

    /** @test */
    public function link_show_list_page()
    {
        $this->signIn();
        $this->actingAs(auth()->user())
            ->get(route('links.index', ['month' => '2021-01']),)
            ->assertStatus(200);
    }

    /** @test */
    public function link_edit_page()
    {
        $this->signIn();
        $link = Link::factory()->draft()->create([
            'author_id' => auth()->id()
        ]);
        $this->actingAs(auth()->user())
            ->get(route('links.edit', $link))
            ->assertStatus(200);
    }

    /** @test */
    public function link_show_my_list()
    {
        $this->signIn();
        $this->actingAs(auth()->user())
            ->get(route('user.links'))
            ->assertStatus(200);
    }

    /** @test */
    public function link_show_a_post_page()
    {
        $this->signIn();
        $category = Category::factory()->create();

        $link = Link::factory()->create([
            'author_id' => auth()->id(),
            'category_id' => $category->id
        ]);
        $this->actingAs(auth()->user())
            ->get(route('links.show', $link))
            ->assertStatus(200);

        $this->get(route('links.show', $link))
            ->assertStatus(200);
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
    public function link_can_be_stored()
    {
        $this->signIn();
        $attributes = Link::factory()->make()->toArray();
        Storage::fake(storage_path('uploads'));
        $tag = Tag::factory()->create();
        $attributes['tags'] = [$tag->id];
        $attributes['image'] = new \Illuminate\Http\UploadedFile(storage_path('uploads/ZLCL1rI5JLRMd04rY7KCQ3hBShEMxykXUgXFJaJf.png'), 'ZLCL1rI5JLRMd04rY7KCQ3hBShEMxykXUgXFJaJf.png', null, null, true);
        $this->actingAs(auth()->user())
            ->post(route('links.store'), $attributes)
            ->assertStatus(302);
        $uploaded = storage_path('uploads').'/ZLCL1rI5JLRMd04rY7KCQ3hBShEMxykXUgXFJaJf.png';
        $this->assertFileExists($uploaded);
        $this->assertDatabaseHas('links', [
            'title' => $attributes['title'],
            'introduction' => $attributes['introduction']
        ]);
    }

    /** 2test */
    public function link_can_show_edit_page()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $category = Category::factory()->create();
        $link = Link::factory()->create([
            'author_id' => auth()->id(),
            'category_id' => $category->id,
            'status' => 'accepted'
        ]);

        $this->actingAs(auth()->user())
            ->get(route('links.edit', $link))
            ->assertStatus(200);
    }

    /** @test */
    public function link_can_be_updated()
    {
        $this->signIn();

        $link = Link::factory()->draft()->create(['author_id' => auth()->id()]);
        $attributes = $link->only(['title', 'introduction', 'url', 'category_id']);
        $attributes['title'] = 'Changed';

        $this->actingAs($link->author)
        ->patch(route('links.update', $link), $attributes)
        ->assertRedirect(route('links.show', $link));
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
            ->assertStatus(302);
    }

    /** @test */
    public function link_can_be_favorited()
    {
        $this->signIn();
        $category = Category::factory()->create();
        $link = Link::factory()->create([
            'author_id' => auth()->id(),
            'category_id' => $category->id,
            'status' => 'accepted'
        ]);
        $this->actingAs(auth()->user())
            ->post(route('user.links.favorite', $link))
            ->assertStatus(302);

        $this->assertDatabaseHas('favorites', [
            'user_id' => $link->author->id,
            'favoritable_type' => get_class($link),
            'favoritable_id' => $link->id
        ]);

        $this->actingAs(auth()->user())
            ->post(route('user.links.favorite', $link))
            ->assertStatus(302);

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $link->author->id,
            'favoritable_type' => get_class($link),
            'favoritable_id' => $link->id
        ]);
    }
}
