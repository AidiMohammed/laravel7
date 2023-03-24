<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    //use SoftDeletes;

    public function posts()
    {
        return $this->morphedByMany(Post::class,'taggable')->withTimestamps();
    }

    public function comments()
    {
        return $this->morphedByMany(Comment::class,'taggable')->withTimestamps();
    }
}
