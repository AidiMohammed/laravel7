<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStore;
use App\User;
use Illuminate\Http\Request;

class UserCommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(CommentStore $request,User $user)
    {
        $user->comments()->create([
            'content' => $request->content,
            'user_id' => $request->user()->id,
        ]);
        
        return redirect()->back()->with('new comment for user created');
    }
}
