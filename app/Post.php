<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{

    use SoftDeletes;//add deleted_at to posts tabel avec la method softDeletes() 

    protected $fillable = ['title','content','active','user_id'];

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }


    public static function boot()
    {
        parent::boot();

        static::deleting(function($post){
            $post->comments()->delete();
        });

        static::restoring(function($post){
            $post->comments()->restore();
        });
    }

}
