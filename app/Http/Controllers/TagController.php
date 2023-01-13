<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    public function index($id)
    {
        $tag = Tag::findOrFail($id);


        
        if(Auth::check())
        {
            if(Auth::user()->is_admin)
            {
                $archiveCount = Post::onlyTrashed()->get();
                $allCount = Post::withTrashed()->get();
                $indexCount = $tag->posts()->get();
                
                return view('posts.index',[
                    'posts' => $tag->posts()->get(),
                    'tab' => 'index',
                    'archiveCount' => $archiveCount->count() ,
                    'allCount'=> $allCount->count(),
                    'indexCount' => $indexCount->count()
                ]);
            }            
        }


        return view('posts.index',[
            'posts' => $tag->posts()->withCount('comments')->with(['user','tags','comments'])->get(),
            'tab' => 'index'
        ]);
    }
}
