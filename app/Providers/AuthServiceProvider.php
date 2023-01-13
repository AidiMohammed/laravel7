<?php

namespace App\Providers;

use App\Policies\CommentPolicy;
use App\Policies\PostPolicy;
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
        'App\Post' => PostPolicy::class,
        'App\Comment' => CommentPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('secret.page',function($user){
            if($user->is_admin)
                return true;
        });

        Gate::define('factories.createPosts',function($user){
            if($user->is_admin)
                return true;
        });
        Gate::define('isAdmin',function($user){
            if($user->is_admin)
            {
                redirect()->back();
                return true;
            }
        });

        /*Gate::define('post.delete','App\Policies\postPolicy@delete');
        Gate::define('post.edit','App\Policies\postPolicy@edit');*/

        /*Gate::resource('post','App\Policies\PostPolicy');
        /*Gate::define('post.edit','App\Policies\PostPolicy@edit');
        
        Gate::define('post.restore','App\Policies\PostPolicy@restore');
        Gate::define('post.forceDelete','App\Policies\PostPolicy@forceDelete');*/
        //Gate::define('post.archive','App\Policies\PostPolicy@archive');
        //Gate::resource('post','App\Policies\PostPolicy');
        

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
        });*/

       Gate::before(function($user,$ability)
        {
            if($user->is_admin && in_array($ability,['delete','edit','update','forceDelete','create','restore']))
                return true;
        });
    }
}
