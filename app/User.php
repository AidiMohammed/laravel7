<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username','email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function scopeMostActiveUser(Builder $builder)
    {
        return $builder->withCount('posts')->orderBy('posts_count','desc');
    }

    public function scopeMostActiveUsersLastMonth(Builder $builder)
    {
        return $builder->withCount(['posts' => function(Builder $builder){
            $builder->whereBetween(static::CREATED_AT,[now()->subMonth(1),now()]);
        }])->orderBy('posts_count','desc');
    }
}
