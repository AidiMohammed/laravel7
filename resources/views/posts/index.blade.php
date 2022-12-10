@extends('layouts.app')

@section('content')
    <h1>List Posts</h1>
    @auth
        @if(Auth::user()->is_admin)    
            <ul class="nav nav-tabs my-3">
                <li class="nav-item"><a class="nav-link @if($tab === 'index') active @endif" href="/posts/">List ({{$indexCount}})</a></li>
                <li class="nav-item"><a class="nav-link @if($tab === 'archive') active @endif" href="/posts/archive">Archive ({{$archiveCount}})</a></li>
                <li class="nav-item"><a class="nav-link @if($tab === 'all') active @endif" href="/posts/all">All ({{$allCount}})</a></li>
            </ul>
        @endif
    @endauth

    <div class="row">

        <div class="col-8">
            @forelse ($posts as $post)
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <a style="font-weight: bold;font-size: 30px" href="">{{$post->title}}</a>
                    <button type="button" class="btn btn-primary position-relative ">
                        comment(s)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{$post->comments_count}}
                        </span>
                    </button>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Created by : {{$post->user->username}}</h5>
                    <p class="card-text">{{$post->content}}</p>
                    <br>
                    <span class="badge bg-secondary text-light p-2">created at {{$post->created_at}}</span>
                </div>
                <div class="card-footer">
                    
                    <div class="d-flex justify-content-between">
                        @can('update', $post)
                            <a class="btn btn-secondary" href="{{route('posts.edit',$post->id)}}">Edit your post</a>
                        @endcan
                        @can('delete', $post)
                            <form action="{{route('posts.destroy',$post->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delet your post</button>
                            </form>
                        @endcan
                    </div>

                    <div class="form-group">
                        <label for="comment" class="form-label mt-4"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Comment</font></font></label>
                        <textarea class="form-control" id="comment" rows="4"></textarea>
                    </div>
                    <button class="btn btn-outline-primary">Add comment</button>
                </div>
            </div>                
            @empty
                <div class="">list is empty</div>
            @endforelse

        </div>

        <!--Side bar-->

        <div class=" col-4">
            <div class="card my-3">
                <div class="card-body">
                    <h4 class="card-title">Most Commented posts</h4>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse ($mostCommented as $post)
                    <li class="list-group-item">
                        <a href="#">{{$post->title}}</a>
                        <div class="d-flex justify-content-between">
                            <p>created by : {{$post->user->username}}</p>
                            {{$post->comments_count}} comment(s)
                        </div>
                    </li>
                    @empty
                        <div>List is empty</div>                    
                    @endforelse
                </ul>
            </div>

            <div class="card my-3">
                <div class="card-body">
                    <h4 class="card-title">Most Active users</h4>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse ($mostActiveUser as $user)
                        <li class="list-group-item">
                            <p>{{$user->username}}</p>
                            <div class="d-flex justify-content-between">
                                <p>email : {{$user->email}}</p>
                                {{$user->posts_count}} post(s)
                            </div>
                        </li>
                    @empty
                        <div>List is empty</div>                    
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    
    


@endsection