<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    public const LOCALES = [
        'en' => 'English',
        'ar' => 'Arabic',
        'fr' => 'Français'
    ];

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

    //------------------------- relationship -----------------------------

    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable')->dernier();
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function answer()
    {
        return $this->hasMany(Answer::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class,'imageable');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    //-------------------------- scopos ----------------------------------
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

    //------------------------ foot fucntion -------------------------------

    public static function boot()
    {
        parent::boot();

        static::updating(function($user){
            Storage::delete($user->image);
        });
    }
}
