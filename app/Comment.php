<?php

namespace App;

use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = ['content'];

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


    /*public static function boot()
    {
        parent::boot();
        static::addGlobalScope(new LatestScope);
    }*/
}
