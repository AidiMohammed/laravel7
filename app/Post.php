<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Post extends Model
{

    use SoftDeletes;//add deleted_at to posts tabel avec la method softDeletes() via ficher de migration

    protected $fillable = ['title','content','active','user_id'];

    //---------------- relationship ---------------------//
    public function comments()
    {
        return $this->hasMany(Comment::class)->dernier();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function image()
    {
        return $this->hasOne(Image::class);
    }

    //----------------- scope --------------------------//
    public function scopeMostCommented(Builder $builder)
    {
        return $builder->withCount('comments')->orderBy('comments_count','desc');
    }    
    
    public static function boot()
    {
        //ajouter des scope Global avent le boot "SoftDeletes"
        parent::boot();

        static::addGlobalScope(new LatestScope);

        static::deleting(function($post){
            $post->comments()->delete();
        });

        /*static::updating(function($post){
            Cache::forget("show-post-{$post->id}");
        });*/

        static::restoring(function($post){
            $post->comments()->restore();
        });
    }

}
