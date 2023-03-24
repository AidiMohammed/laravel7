<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStore;
use App\Mail\CommentUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserCommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(CommentStore $request,User $user)
    {
        $comment = $user->comments()->create([
            'content' => $request->content,
            'user_id' => $request->user()->id,
        ]);
        
        Mail::to($user->email)->send(new CommentUser($comment));

        return redirect()->back()->with('new comment for user created');
    }
}
