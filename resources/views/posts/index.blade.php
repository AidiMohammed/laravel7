@extends('layouts.app')

@section('content')
    <h1>List Posts</h1>
    
    @if (count($posts) > 0)
        <div class="row">
    @endif
        @forelse ($posts as $post)
        <div class="col-sm-6">
            <div class="card mt-4">

                <div class="card-header d-flex justify-content-between">
                    <h2><a href="{{route('posts.show',$post->id)}}">{{$post->title}}</a></h2>

                    <form method="GET" action="{{route('posts.show',$post->id)}}">
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary position-relative">
                                Comments
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{$post->comments_count}}
                                </span>
                            </button>
                        </div>
                    </form>

                </div>
                
                <div class="card-body">
                    <h6 style="font-size: 0.8em">Post created by : {{$post->user->username}}</h6>
                    <p class="card-text">{{$post->content}}</p>
                    <em>Created at : {{$post->created_at->diffForhumans()}}</em>
                    <br>
                    @if ($post->created_at != $post->updated_at)
                        <em>Last update : {{$post->updated_at->diffForhumans()}}</em>
                    @endif
                </div>

                @if (Auth::check())
                    
                    <div class="card-footer text-muted">
                        @if (Auth::id() == $post->user_id)
                            <div class="d-flex justify-content-between">
                                <div class="btn btn-warning">
                                    <a href="{{route('posts.edit',$post->id)}}">Edit</a>
                                </div>
                                
                                <form style="display: inline" method="POST" action="{{route('posts.destroy',$post->id)}}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">Delet</button>
                                </form>
                            </div>
                        @endif
                
                        <form method="POST" action="{{route('comments.storeMyComment',$post->id)}}">
                            @csrf
                            <div class="mb-3 mt-4">
                                <textarea class="form-control" id="content" rows="3" name="content" placeholder="Your comment hier"></textarea>
                                @if (session()->has('errorComment') && session()->get('id') == $post->id)
                                    <div class="alert alert-danger d-flex align-items-center mt-4" role="alert">
                                        <div>
                                            {{session()->get('errorComment')}}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <button class="btn btn-outline-primary" type="submit" id="submit">Add comment</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
        
        @empty
        <div class="alert alert-secondary" role="alert">
            List Posts is empty <a href="{{route('posts.create')}}" class="alert-link">Add new post.</a>
        </div>
    @if (count($posts) > 0)
        </div>
    @endif

    @endforelse
@endsection