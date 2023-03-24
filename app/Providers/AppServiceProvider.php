<?php

namespace App\Providers;

use App\Answer;
use App\Comment;
use App\Observers\AnswerObserver;
use App\Observers\CommentObserve;
use App\Observers\PostObserve;
use App\Post;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('posts.sidebar','App\Http\ViewComposers\ActivityComposer');
        Post::observe(PostObserve::class);
        Comment::observe(CommentObserve::class);
        Answer::observe(AnswerObserver::class);
    }
}
