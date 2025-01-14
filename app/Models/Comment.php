<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
    */
    protected $fillable = [
        'body',
        'user_id',
    ];

    /**
     * Get the parent commentable model (article or comment).
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get all of the comment's comments.
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')
            ->orderBy('id', 'DESC')
            ->with('comments')
            ->withCount('likes');
    }
    
    /**
     * Get all of the comment's likes.
     */
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likable');
    }
}
