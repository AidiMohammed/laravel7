<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;
use App\Comment;
use App\Events\CommentPosted;
use App\Http\Requests\AnswerStore;
use App\Mail\CommentDeletUser;
use App\Post;
use App\User;
use Illuminate\Support\Facades\Mail;
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
        
        $comment = $post->comments()->save(Comment::make([
            'content' => $request->content,
            'user_id' => $request->user()->id,
        ]));

        event(new CommentPosted($comment));

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
        $user = User::find($comment->commentable->id); 
        Mail::to($user->email)->send(new CommentDeletUser($comment));
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
            return redirect()->route('posts.show',['post' => $comment->commentable->id])->withStatus('you have update your comment');        
    }

    public function replyComment(AnswerStore $request,Comment $comment)
    {
        $answer = new Answer();

        $answer->user_id = $request->user()->id;
        $answer->comment_id = $comment->id;
        $answer->content = $request->content;

        $answer->comment()->associate($comment)->save();
        
        //$comment->answers()->save($answer);

        return redirect()->back();
    }

    public function deleteAnswer(Answer $answer)
    {


        $answer->delete();

        return redirect()->back()->with('status','Answer has been delete !');
    }

    public function editAnsewr(Answer $answer)
    {

    }

}
