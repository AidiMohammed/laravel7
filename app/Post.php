<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{

    use SoftDeletes;//add deleted_at to posts tabel avec la method softDeletes() 

    protected $fillable = ['title','content','active','user_id'];

    public function comments()
    {
        return $this->hasMany(Comment::class)->dernier();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeMostCommented(Builder $builder)
    {
        return $builder->withCount('comments')->orderBy('comments_count','desc');
    }    

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new LatestScope);

        static::deleting(function($post){
            $post->comments()->delete();
        });

        static::restoring(function($post){
            $post->comments()->restore();
        });
    }

}
