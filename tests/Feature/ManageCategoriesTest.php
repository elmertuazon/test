<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageCategoriesTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function unauthenticated_user_can_see_category()
    {
        $category = Category::factory()->create();

        $this->get($category->path())->assertOk();

    }

    /** @test */
    public function crud_user_can_see_categories()
    {
        $user = $this->createAdmin();

        $this->actingAs(auth()->user())
            ->get(config('backpack.base.route_prefix') . '/category')
            ->assertStatus(302);

    }
}