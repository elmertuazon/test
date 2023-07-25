<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ManageCommentsTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /** @test */
    public function user_can_add_comment()
    {
        // Feature tests *have* to make http requests to your application.
        // Unit tests *cannot* make http requests to your application.

        // ARRANGE - set up what you need to test
        $this->signIn();
        $post = Post::factory()->create();

        // HTTP REQUEST
        // ACT - take the action you want to test
        $this->post(route('user.posts.comments', $post), [
            'body' => 'sample comment'
        ]);

        // ASSERT - make sure the action you took had the intended effect
        $this->assertDatabaseHas('comments', [
            'user_id' => auth()->id(),
            'body' => 'sample comment',
        ]);
    }

    /** @test */
    public function user_can_reply_to_a_comment()
    {
        // Feature tests *have* to make http requests to your application.
        // Unit tests *cannot* make http requests to your application.
        // A feature test should test one controller method only
        // A unit test should test one method only
        // The three stages of a test are
        // ARRANGE - set up what you need to test
        // ACT - take the action you want to test
        // ASSERT - make sure the action you took had the intended effect

        // ARRANGE - set up what you need to test
        // Create the comment we want to reply to
        $comment = Comment::factory()->create();

        // HTTP REQUEST
        // ACT - take the action you want to test
        $this->signIn();
        // Make the http request to leave the intended reply
        $this->post(route('user.comments.comments', $comment), [
            'body' => 'replied comment'
        ]);

        // ASSERT - make sure the action you took had the intended effect
        $this->assertDatabaseHas('comments', [
            'user_id' => Auth::id(),
            'body' => 'replied comment',
        ]);
    }

}
