<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function view(?User $user, Post $post): bool
    {
        $isThePostPublished = $post->publish_at <= now();

        $isThePostAccepted = $post->status === 'accepted';

        if($user === null) {
            return $isThePostPublished && $isThePostAccepted;
        }

        $isThePostInDraftOrDeclinedAndTheUserIsTheAuthor = in_array($post->status, ['draft', 'declined']) && $user->id === $post->author_id;

        return $isThePostPublished && ($isThePostAccepted || $isThePostInDraftOrDeclinedAndTheUserIsTheAuthor);
    }

    public function update(User $user, Post $post): bool
    {
        return $post->status === 'draft' && $user->id === $post->author_id;
    }
}
