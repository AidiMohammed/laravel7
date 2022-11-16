<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title','content','active','user_id'];

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    //suppression physique
    /*public static function boot()
    {
        parent::boot();

        static::deleting(function($post){
            $post->comments()->delete();
        });
    }*/
}
