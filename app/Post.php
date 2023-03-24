<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Post extends Model
{

    use SoftDeletes;//add deleted_at to posts tabel avec la method softDeletes() via ficher de migration

    protected $fillable = ['title','content','active','user_id'];

    //---------------- relationship ---------------------//
    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable')->dernier();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class,'taggable')->withTimestamps();
    }

    public function image()
    {
        return $this->morphOne(Image::class,'imageable');
    }

    //----------------- scope --------------------------//
    public function scopeMostCommented(Builder $builder)
    {
        return $builder->withCount('comments')->orderBy('comments_count','desc');
    }    

    public function scopeGetPost(Builder $builder,$id)
    {
        $myPost = null;

        if(Auth::user()->is_admin)
        {
            $posts = $builder->withTrashed()->get();

            foreach($posts as $post)
            {
                if($post->id == $id)
                {
                    $myPost = $post;
                    break;
                }
            }

            if($myPost === null)
                abort(404);
            else
                return $myPost;
        }
        else
            return $builder->findOrFail($id);
    }
    
    public static function boot()
    {
        //ajouter des scope Global avent le boot "SoftDeletes"
        parent::boot();
        static::addGlobalScope(new LatestScope);

    }

}
