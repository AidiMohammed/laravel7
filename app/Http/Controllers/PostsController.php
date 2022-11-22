<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostStore;
use App\Post;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index','show','all','archive']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::withCount('comments')->orderBy('created_at','desc')->with('user')->get();
        $archiveCount = Post::onlyTrashed()->get();
        $allCount = Post::withTrashed()->get();
        $indexCount = Post::withoutTrashed()->get();
        return view('posts.index',['posts' => $posts,'tab' => 'index','archiveCount' => $archiveCount->count() , 'allCount'=> $allCount->count(), 'indexCount' => $indexCount->count()]);
    }

    public function archive()
    {
        $posts = Post::onlyTrashed()->withCount('comments')->with('user')->get();
        $archiveCount = Post::onlyTrashed()->get();
        $allCount = Post::withTrashed()->get();
        $indexCount = Post::withoutTrashed()->get();
        return view('posts.index',['posts' => $posts,'tab' => 'archive','archiveCount' => $archiveCount->count() , 'allCount'=> $allCount->count(), 'indexCount' => $indexCount->count()]);
    }

    public function all()
    {
        $posts = Post::withTrashed()->withCount('comments')->with('user')->get();
        $archiveCount = Post::onlyTrashed()->get();
        $allCount = Post::withTrashed()->get();
        $indexCount = Post::withoutTrashed()->get();
        return view('posts.index',['posts' => $posts,'tab' => 'all','archiveCount' => $archiveCount->count() , 'allCount'=> $allCount->count(), 'indexCount' => $indexCount->count()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostStore $request)
    {

        $newPost = new Post();
        $data = request()->only(['title','content']);

        $data['active'] = false;
        $data['user_id'] = Auth::id();

        $newPost->create($data);

        session()->flash('status','The post has ben created !!');

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
        $post = Post::findOrFail($id);
        $comments = $post->comments()->with('user')->get();

        return view('posts.show',['post' => $post,'comments' => $comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('posts.edit',['post' => Post::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostStore $request, $id)
    {
        $post = Post::findOrFail($id);

        $data = $request->only(['title','content']);
        
        $post->update($data);

        session()->flash('status','The post hass updated !!');

        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        session()->flash('status','The message has ben deleted !!');
        return redirect()->route('posts.index');
    }

    public function forceDelete($id)
    {
        $post = Post::onlyTrashed($id)->where('id',$id);
        $post->forceDelete();
        return redirect()->back();
    }

    public function restore($id)
    {
        $post = Post::onlyTrashed()->where('id',$id)->first();

        $post->restore();
        return redirect()->back();
    }
}
