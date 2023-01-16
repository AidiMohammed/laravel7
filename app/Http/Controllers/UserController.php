<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\UpdateProfile;
use App\Image;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(User::class,'user');
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $myUser = User::withCount('comments')->findOrFail($user->id);
        $postCommentsCount = Comment::where('user_id',$user->id)->where('commentable_type',Post::class)->count();
        
        return view('users.show',['user' => $myUser,'postCommentsCount' => $postCommentsCount]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit',['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfile $request, User $user)
    {

        if($request->hasFile('avatar'))
        {
            $pathNewAvatar = $request->file('avatar')->store('users');
            if($user->iamge)
            {
                //delet last avatar
                Storage::delete($user->image->path);
                $user->image->path = $pathNewAvatar;
                $user->iamge->save();
            }
            else//if user has no image
                $user->image()->save(Image::make(['path' => $pathNewAvatar]));
        }

        $data = $request->only('username');
        $user->update($data);

        return redirect()->back()->withStatus('profile hass updated !!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
