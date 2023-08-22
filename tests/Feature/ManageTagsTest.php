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
    public function tag_can_show_list()
    {
        $tag = Tag::factory()->create();
        $this->get(route('tag.show', $tag))
            ->assertStatus(200);
    }

    /** @test */
    public function crud_user_can_see_tag()
    {
        $this->withoutExceptionHandling();
        $user = $this->signInAsAdmin();

        $this->actingAs(auth()->user())
            ->get(route('tag.index'))
            ->assertStatus(200);

    }

    /** @test */
    public function crud_user_can_create_tag()
    {
        $this->withoutExceptionHandling();
        $this->createAdmin();
        $attributes = Tag::factory()->make()->toArray();

        $this->actingAs(auth()->user())
            ->post(route('tag.store'), $attributes)
            ->assertStatus(302);
    }

    /** @test */
    public function crud_user_can_update_tag()
    {
        $this->withoutExceptionHandling();
        $this->createAdmin();
        $tag = Tag::factory()->create();
        $attributes = $tag->except(['id']);
        $attributes['name'] = 'changed';

        $this->actingAs(auth()->user())
            ->put(route('tag.update', $tag), $attributes)
            ->assertStatus(302);

    }

}
