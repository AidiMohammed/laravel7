<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('post.delete','App\Policies\postPolicy@delete');
        Gate::define('post.edit','App\Policies\postPolicy@edit');


       /* Gate::define('post.update',function($user,$post){
            return $user->id == $post->user_id;
        });

        Gate::define('post.edit',function($user,$post){
            return $user->id == $post->user_id;
        });

        Gate::define('post.delete',function($user,$post){
            return $user->id == $post->user_id; 
        });

        Gate::define('post.forceDelete',function($user,$post){
            if($user->id == $post->user_id)
                return true;
        });

        Gate::before(function($user,$ability)
        {
            if($user->is_admin && in_array($ability,['post.delete','post.edit','post.update','post.forceDelete']))
                return true;
        });*/
    }
}
