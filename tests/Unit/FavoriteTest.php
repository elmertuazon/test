<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Link;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_favorite_post_can_have_instance_of_post()
    {
        $user = $this->signIn();
        $post = Post::factory()->create(['author_id' => auth()->id()]);
        $favorite = $post->favorites()->create(['user_id' => auth()->id()]);
        // $this->assertInstanceOf(User::class, $favorite->author);
        $this->assertInstanceOf(Post::class, $favorite->favoritable);
    }

    /** @test */
    public function a_favorite_post_can_have_user()
    {
        $user = $this->signIn();
        $post = Post::factory()->create(['author_id' => auth()->id()]);
        $favorite = $post->favorites()->create(['user_id' => auth()->id()]);
        $this->assertInstanceOf(User::class, $favorite->author);
    }

     /** @test */
     public function a_user_can_have_favorite_posts()
     {
         $this->signIn();
         $posts = Post::factory(3)->create(['author_id' => auth()->id()]);
         foreach($posts as $post)
         {
            $post->favorites()->create(['user_id' => auth()->id()]);
         }
         $this->assertInstanceOf(Collection::class, auth()->user()->favorites);
     }
}
