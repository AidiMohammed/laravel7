<?php

namespace App\Observers;

use App\Answer;
use Illuminate\Support\Facades\Cache;

class AnswerObserver
{
    /**
     * Handle the answer "created" event.
     *
     * @param  \App\Answer  $answer
     * @return void
     */
    public function creating(Answer $answer)
    {
        Cache::forget("show-post-{$answer->comment->commentable->id}");
    }

    /**
     * Handle the answer "updated" event.
     *
     * @param  \App\Answer  $answer
     * @return void
     */
    public function updated(Answer $answer)
    {
        //
    }

    /**
     * Handle the answer "deleted" event.
     *
     * @param  \App\Answer  $answer
     * @return void
     */
    public function deleting(Answer $answer)
    {
        Cache::forget("show-post-{$answer->comment->commentable->id}");
    }

    /**
     * Handle the answer "restored" event.
     *
     * @param  \App\Answer  $answer
     * @return void
     */
    public function restored(Answer $answer)
    {
        //
    }

    /**
     * Handle the answer "force deleted" event.
     *
     * @param  \App\Answer  $answer
     * @return void
     */
    public function forceDeleted(Answer $answer)
    {
        //
    }
}
