<?php

namespace App\Listeners;

use App\Events\EventNewPostCreated;
use App\Jobs\JobNewPostCreate;
use App\Mail\NewPostCreate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class ListenerNewPostCreated
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
    public function handle(EventNewPostCreated $event)
    {
        Mail::to(config('mail.from.address'))->queue(new NewPostCreate($event->post));

        JobNewPostCreate::dispatch($event->post)->delay(now()->addSeconds(10));
    }
}
