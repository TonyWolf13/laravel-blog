<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function owns(User $user, Comment $comment): bool
    {
        return $user->id == $comment->user_id;
    }
}
