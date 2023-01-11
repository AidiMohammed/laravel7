<?php

namespace App\Http\ViewComposers;

use App\Post;
use App\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ActivityComposer
{
    public function compose(View $view)
    {
        $mostCommented = Cache::remember('mostCommented',now()->addSeconds(30),function(){
            return Post::mostCommented()->take(5)->get();
        });

        $mostActiveUser = Cache::remember('mostActiveUser',now()->addSeconds(30),function(){
            return User::mostActiveUser()->take(5)->get();
        });
        $userAvtiveLastMonth = Cache::remember('userAvtiveLastMonth',now()->addSeconds(30),function(){
            return User::mostActiveUsersLastMonth()->take(5)->get();
        });

        $view->with([
            'mostCommented' => $mostCommented,
            'mostActiveUser' => $mostActiveUser,
            'userAvtiveLastMonth' => $userAvtiveLastMonth
        ]);
    }
}