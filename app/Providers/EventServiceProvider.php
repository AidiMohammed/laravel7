<?php

namespace App\Providers;

use App\Events\CommentPosted;
use App\Events\EventDeletCommentFromPost;
use App\Events\EventNewPostCreated;
use App\Listeners\ListenerDeletCommentFromPost;
use App\Listeners\ListenerNewPostCreated;
use App\Listeners\NotifyUserAboutComment;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        CommentPosted::class =>[
            NotifyUserAboutComment::class,
        ],

        EventDeletCommentFromPost::class => [
            ListenerDeletCommentFromPost::class,
        ],

        EventNewPostCreated::class => [
            ListenerNewPostCreated::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
