<?php

namespace App\Observers;

use App\Post;
use Illuminate\Support\Facades\Cache;

class PostObserve
{
    /**
     * Handle the post "created" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function creating(Post $post)
    {
        Cache::forget('posts');
    }

    /**
     * Handle the post "updated" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function updating(Post $post)
    {
        Cache::forget("show-post-{$post->id}");
        Cache::forget('posts');
    }

    /**
     * Handle the post "deleted" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function deleting(Post $post)
    {
        $post->comments()->delete();
        Cache::forget('posts');
    }

    /**
     * Handle the post "restored" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function restoring(Post $post)
    {
        $post->comments()->restore();
        Cache::forget('posts');
    }
}
