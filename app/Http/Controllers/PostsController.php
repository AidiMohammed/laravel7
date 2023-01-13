<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\PostStore;
use App\Image;
use App\Post;
use Illuminate\Support\Facades\Storage;

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
        /*$hasfile = $request->hasFile('picture');
        dump($hasfile);
        if($hasfile)
        {
            $file = $request->file('picture');
            dump($file);
            dump("Mine Type :  {$file->getClientMimeType()}");
            dump("Original Extension : {$file->getClientOriginalExtension()}");
            dump("Original Name : {$file->getClientOriginalName()}");

            $lastOne = DB::table('posts')->latest('id')->first();

            $file->store('thumbnails');//uploadfile
            dump(Storage::putFile('posts/thumbnails',$file));
            dump(Storage::disk('public')->putFile('posts/thumbnails',$file));

            $name1 = $file->storeAs('thumbnails',random_int(1,1000).'.'.$file->guessExtension());
            $name2 = Storage::disk('public')->putFileAs('thumbnails',$file,random_int(1,3000).'.'.$file->guessExtension());

            dump(Storage::url($name1));
            dump(Storage::disk('public')->url($name2));
        }*/

        $newPost = new Post();
        $data = request()->only(['title','content']);

        $data['active'] = false;
        $data['user_id'] = Auth::id();//request->user()->id

        $post = $newPost->create($data);

        //upload picture for this post
        if($request->hasFile('picture'))
        {
            $path = $request->file('picture')->store('posts');
            $image = new Image(['path' => $path]);

            $post->image()->save($image);
        }

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
        $post = Post::getPost($id);
            
        $this->authorize('update',$post);

        if($request->hasFile('picture'))
        {
            //upload picture 
            $path = $request->file('picture')->store('posts');
            if($post->image)
            {       
                //delete physically last image
                Storage::delete($post->image->path);
                //change path last image by a new path
                $post->image->path = $path;
                //update image
                $post->image->save();
            }
            else
            {
                
                //$post->image->update(Image::create(['path' => $path]));
                $image = new Image();
                $image->path = $path;
                $image->post_id = $post->id;
                $image->save();
            }
        }

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
