<?php

namespace App\Observers;

use App\Comment;
use Illuminate\Support\Facades\Cache;

class CommentObserve
{

    /**
     * Handle the comment "deleted" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function deleting(Comment $comment)
    {
        Cache::forget("show-post-{$comment->commentable->id}");
    }

    public function creating(Comment $comment)
    {
        Cache::forget("show-post-{$comment->commentable->id}");
    }

}
