<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostStore;
use Illuminate\Support\Facades\Gate;
use App\Post;
use App\User;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $posts = Post::withCount('comments')->get();//I use Scope For Model Post with orderBy desc
        $postMostCommented = Post::mostCommented()->take(5)->get();
        $mostActiveUser = User::MostActiveUser()->take(5)->get();
        $userActiveLastMonths = User::mostActiveUsersLastMonth()->take(5)->get();
        $archiveCount = Post::onlyTrashed()->get();
        $allCount = Post::withTrashed()->get();
        $indexCount = Post::withoutTrashed()->get();

        return view('posts.index',[
            'posts' => $posts,
            'index' => 0,
            'tab' => 'index',
            'archiveCount' => $archiveCount->count() ,
            'mostCommented' => $postMostCommented ,
            'mostActiveUser' => $mostActiveUser,
            'userAvtiveLastMonth' => $userActiveLastMonths,
            'allCount'=> $allCount->count(), 
            'indexCount' => $indexCount->count()]);
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
        return view('posts.index',[
            'posts' => $posts,
            'tab' => 'all',
            'archiveCount' => $archiveCount->count(),
            'allCount'=> $allCount->count(),
            'indexCount' => $indexCount->count()]);
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
        $data['user_id'] = Auth::id();//request->user()->id

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
        return view('posts.show',['post' => Post::with('comments')->findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //$post = Post::findOrFail($id);
        $posts = Post::withTrashed()->get();
        $myPost = null;

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
        

        $this->authorize('edit',$post);

        return view('posts.edit',['post' => $post]);
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
        $posts = Post::withTrashed()->get();
        $myPost = null;

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
            
        $this->authorize('update',$post);
        //if(Gate::denies('post.update',$post)) abort(403,"You can't edit this post !");

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

        $this->authorize('delete',$post);
        //if(Gate::denies('post.delete',$post)) abort(403);

        $post->delete();

        session()->flash('status','The message has ben deleted !!');
        return redirect()->route('posts.index');
    }

    public function forceDelete($id)
    {
        $post = Post::onlyTrashed($id)->where('id',$id)->first();

        $this->authorize('forceDelete',$post);

        $post->forceDelete();
        return redirect()->back();
    }

    public function restore($id)
    {
        $post = Post::onlyTrashed()->where('id',$id)->first();

        $this->authorize('restore',$post);
        $post->restore();

        session()->flash('status','The post <strong> '.$post->title.'</strong> has ben restored !! ');
        return redirect()->back();
    }
}
