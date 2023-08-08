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

}
