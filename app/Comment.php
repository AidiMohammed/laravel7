<?php

namespace App;

use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = ['content','user_id'];
//---------------------- relation shipe ---------------------
    /**
     * this method that maked the one to many relationship between the comment and post model
     *
     * @return void
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * this method that maked the one ton many relationship between the comment and user post model
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class,'taggable')->withTimestamps();
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    
//------------------------ relation shipe morph -------------
    /**
     * function morph realtion
     *
     * @return void
     */
    public function commentable()
    {
        return $this->morphTo();
    }

//------------------------ local scope ----------------------
    /**
     * function locale scope 
     *
     * @param Builder $builder
     * @return void
     */
    public function scopeDernier(Builder $builder)
    { 
        return $builder->orderBy(static::CREATED_AT,'desc');
    }
}
