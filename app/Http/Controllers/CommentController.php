<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Http\Requests\CommentStore;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth')->only(['storeMyComment','destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
        /*$newComment = new Comment();
        $post = Post::findOrfail($id);

        $newComment->content = $request->input('content');
        $newComment->post()->associate($post)->save();

        session()->flash('status','The new comment has ben created !!');
        return redirect()->route('posts.index');*/

        $validator = Validator::make($request->all(),[
            'content' => 'bail|required|min:4'
        ]);

        if($validator->fails())
        {
            session()->flash('errorComment',$validator->errors()->all()[0]);
            session()->flash('id',$id);
            return redirect()->route('posts.index');
        }

        $newComment = new Comment();
        $post = Post::findOrfail($id);
        
        $newComment->content = $request->input('content');
        $newComment->user_id = Auth::id();
        $newComment->post()->associate($post)->save();

        session()->flash('status','The new comment has ben created !!');
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Comment = Comment::findOrFail($id);
        $Comment->delete();


        session()->flash('status','The Comment has ben deleted !');
        return redirect()->route('posts.show',$Comment->post_id);
    }
}
