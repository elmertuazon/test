<?php

namespace App\Policies;

use App\Models\Link;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LinkPolicy
{
    use HandlesAuthorization;

    public function view(?User $user, Link $link): bool
    {
        $isTheLinkPublished = $link->publish_at <= now();

        $isTheLinkAccepted = $link->status === 'accepted';
        
        if($user === null) {
            return $isTheLinkPublished && $isTheLinkAccepted;
        }

        $isTheLinkInDraftOrDeclinedAndTheUserIsTheAuthor = in_array($link->status, ['draft', 'declined']) && $user->id == $link->author_id;
        
        return $isTheLinkPublished && ($isTheLinkAccepted || $isTheLinkInDraftOrDeclinedAndTheUserIsTheAuthor);
    }

    public function update(User $user, Link $link): bool
    {
        return $link->status === 'draft' && $user->id == $link->author_id;
    }
}
