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
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CommentStore  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storeMyComment(Request $request,Post $post)
    {
        $validator = Validator::make($request->all(),[
            "content" => 'bail|required|min:4',
        ]);

        if($validator->fails())
        {
            session()->flash('errorComment',$validator->errors()->all()[0]);
            session()->flash('errorCommentId',$post->id);
            return redirect()->back();
        }
        $newComment = new Comment();
        
        $post->comments()->save(Comment::make([
            'content' => $request->content,
            'user_id' => $request->user()->id,
        ]));
        

        return redirect()->back()->withStatus('The new commetn has ben created !!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->back()->withStatus('The Comment has ben deleted !');
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

        if($comment->commentable_type == 'App\User')
            return redirect()->route('user.show',$comment->commentable->id)->withStatus('your opinion updeted !!');
        
        else if($comment->commentable_type == 'App\Post')
            return redirect()->route('post.index')->withStatus('you have update your comment');

        
    }
}
