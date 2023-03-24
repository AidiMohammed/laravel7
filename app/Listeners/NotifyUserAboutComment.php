<?php

namespace App\Listeners;

use App\Events\CommentPosted;
use App\Jobs\NotifyUserPostHasBeenCommented;
use App\Mail\CommentedPostMarkdown;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NotifyUserAboutComment
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
    public function handle(CommentPosted $event)
    {
        //send email with queue
        Mail::to($event->comment->commentable->user->email)->queue(new CommentedPostMarkdown($event->comment));

        //jobs
        NotifyUserPostHasBeenCommented::dispatch($event->comment)->delay(now()->addMinutes(1));
    }
}
