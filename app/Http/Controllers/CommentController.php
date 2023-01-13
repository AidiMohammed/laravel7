<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class CommentController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth')->only(['storeMyComment','destroy','edit','update']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CommentStore  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storeMyComment(Request $request,int $id)
    {
        $validator = Validator::make($request->all(),[
            "content" => 'bail|required|min:4'
        ]);

        if($validator->fails())
        {
            session()->flash('errorComment',$validator->errors()->all()[0]);
            session()->flash('errorCommentId',$id);
            return redirect()->back();
        }

        $newComment = new Comment();
        $post = Post::findOrfail($id);
        
        $newComment->content = $request->input("content");
        $newComment->user_id = Auth::id();
        $newComment->post()->associate($post)->save();

        session()->flash('status','The new comment has ben created !!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $Comment)
    {
        $Comment->delete();

        session()->flash('status','The Comment has ben deleted !');
        return redirect()->route('posts.show',$Comment->post_id);
    }

    /**
     * Show from edit the specified resource from storage.
     *
     * @param Comment $comment
     * @return View
     */
    public function edit(Comment $comment)
    {
        $this->authorize('update',$comment);
        return view('posts.editComment',['comment' => $comment]);
    }

    public function update(Comment $comment,Request $request)
    {
        $this->authorize('update',$comment);

        $validator = Validator::make($request->all(),[
            "content" => 'required|min:4'
        ]);

        if($validator->fails())
        {
            session()->flash('errorComment',$validator->errors()->all()[0]);
            session()->flash('errorCommentId',$comment->id);
            return redirect()->back();
        }

        $comment->update($request->only('content'));
        session()->flash('status','The comment hass updaetd !!');
        return redirect()->route('posts.show',['post' => $comment->post_id]);
    }
}
