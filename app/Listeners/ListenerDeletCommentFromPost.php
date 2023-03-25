<?php

namespace App\Listeners;

use App\Events\EventDeletCommentFromPost;
use App\Jobs\JobDeletingCommentToPost;
use App\Mail\CommentDeletUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class ListenerDeletCommentFromPost
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(EventDeletCommentFromPost $event)
    {

        Mail::to($event->comment->commentable->user->email)->queue(new CommentDeletUser($event->comment));

        JobDeletingCommentToPost::dispatch($event->comment->commentable->user)->delay(now()->addSeconds(15));
    }
}
