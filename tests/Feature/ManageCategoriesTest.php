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
        $this->withoutExceptionHandling();
        $user = $this->signInAsAdmin();

        $this->actingAs(auth()->user())
            ->get(route('category.index'))
            ->assertStatus(200);

    }

    /** @test */
    public function crud_user_can_create_categories()
    {
        $this->withoutExceptionHandling();
        $this->createAdmin();
        $attributes = Category::factory()->make()->toArray();

        $this->actingAs(auth()->user())
            ->post(route('category.store'), $attributes)
            ->assertStatus(302);
    }

    /** @test */
    public function crud_user_can_update_categories()
    {
        $this->withoutExceptionHandling();
        $this->createAdmin();
        $category = Category::factory()->create();
        $attributes = $category->toArray();
        $attributes['name'] = 'changed';

        $this->actingAs(auth()->user())
            ->put(route('category.update', $category), $attributes)
            ->assertStatus(302);

    }
}
