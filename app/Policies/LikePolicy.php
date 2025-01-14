<?php

namespace App\Policies;

use App\Models\Like;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LikePolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function owns(User $user, Like $like): bool
    {
        return $user->id == $like->user_id;
    }
}
