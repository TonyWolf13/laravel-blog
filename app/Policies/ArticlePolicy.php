<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function owns(User $user, Article $article): bool
    {
        return $user->id == $article->user_id; 
    }
}
