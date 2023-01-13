<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\PostStore;
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
    

        $posts = Cache::remember('posts', now()->addSeconds(60),function(){
            return Post::withCount('comments')->with(['user','tags'])->get();//I use Scope For Model Post with orderBy desc
        });

        if(Auth::check())
        {
            if(Auth::user()->is_admin)
            {
                $archiveCount = Post::onlyTrashed()->get();
                $allCount = Post::withTrashed()->get();
                $indexCount = Post::withoutTrashed()->get();
                 
                return view('posts.index',[
                    'posts' => $posts,
                    'tab' => 'index',
                    'archiveCount' => $archiveCount->count() ,
                    'allCount'=> $allCount->count(), 
                    'indexCount' => $indexCount->count()]);
            }
            else
            {
                return view('posts.index',[
                    'posts' => $posts,
                    'tab' => 'index',]);
            }
        }
        else
        {
            return view('posts.index',[
                'posts' => $posts,
                'tab' => 'index',]);
        }



    }

    public function archive()
    {

        $posts = Post::onlyTrashed()->withCount('comments')->with('user')->get();
        $archiveCount = Post::onlyTrashed()->get();
        $allCount = Post::withTrashed()->get();
        $indexCount = Post::withoutTrashed()->get();
        return view('posts.index',[
            'posts' => $posts,
            'tab' => 'archive',
            'archiveCount' => $archiveCount->count() ,
            'allCount'=> $allCount->count(),
            'indexCount' => $indexCount->count()]);
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
        $hasfile = $request->hasFile('picture');
        dump($hasfile);
        if($hasfile)
        {
            $file = $request->file('picture');
            dump($file);
            dump("Mine Type :  {$file->getClientMimeType()}");
            dump("Original Extension : {$file->getClientOriginalExtension()}");
            dump("Original Name : {$file->getClientOriginalName()}");

            $file->store('thumbnails');//uploadfile
        }

        die();

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

        $posts = Cache::remember("show-post-{$id}",now()->addSeconds(10),function()
        {
            return Post::withTrashed()->with(['tags','user','comments','comments.user'])->get();
        });
        //Post::trashedWithComments($id);
        $myPost= null;

        foreach ($posts as $post)
        {
            if($post->id == $id)
            {
                $myPost = $post;
                break;
            }
        }

        if($myPost == null)
            abort(404,'Post not fund !!');

        if($post->deleted_at != null)
            abort(404);

    
        return view('posts.show',['post' => $myPost]);
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
        $posts = Post::with('comments')->withTrashed()->get();

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

        $this->authorize('edit',$myPost);

        return view('posts.edit',['post' => $myPost]);
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
