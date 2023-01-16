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

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeDernier(Builder $builder)
    { 
        return $builder->orderBy(static::CREATED_AT,'desc');
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public static function boot()
    {
        parent::boot();
        
        static::deleting(function($comment){
            Cache::forget("show-post-{$comment->commentable->id}");
        });
    }
}
