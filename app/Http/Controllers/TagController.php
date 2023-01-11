<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index($id)
    {
        $tag = Tag::findOrFail($id);

        return view('posts.index',[
            'posts' => $tag->posts()->get(),
            'tab' => 'index'
        ]);
    }
}
