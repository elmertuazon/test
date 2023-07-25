<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageCommentsTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /** @test */
    public function user_can_add_comment()
    {
        $this->signIn();
        $post = Post::factory()->create();
        $post->comments()->create([
            'user_id' => auth()->id(),
            'body' => 'sample comment'
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => auth()->id(),
            'body' => 'sample comment',
        ]);
    }

    /** @test */
    public function user_can_reply_to_a_comment()
    {
        $this->signIn();
        $post = Post::factory()->create();
        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'body' => 'sample comment'
        ]);

        $anotherUser = User::factory()->create();
        $comment->comments()->create([
            'user_id' => $anotherUser->id,
            'body' => 'replied comment'
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $anotherUser->id,
            'body' => 'replied comment',
        ]);

    }

}
