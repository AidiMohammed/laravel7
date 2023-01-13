@extends('layouts.app')

@section('content')

    @if (session('errorComment'))
    <div class="alert alert-danger" role="alert">
        {{session('errorComment')}}
    </div>
    @endif           

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
                    <a style="font-weight: bold;font-size: 30px" href="{{route('posts.show',$post->id)}}">
                        @if ($post->trashed() && $tab == 'archive')
                            <del>
                                {{$post->title}}
                            </del>
                        @else
                            {{$post->title}}
                        @endif
                    </a>
                    <button type = "button" class = "btn btn-primary position-relative ">
                        comment(s)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{$post->comments_count}}
                        </span>
                    </button>
                </div>
                <div class="card-body">

                    <x-username :username="$post->user->username"></x-username>

                    <x-tag :tags="$post->tags"></x-tag>
                    <hr>

                    <p class="card-text">{{$post->content}}</p>
                    <br>

                    @if ($post->created_at->diffInHours() < 1)
                        <x-badge type='success'> New </x-badge>
                    @else
                        <x-badge type='secondary'> Old</x-badge>
                    @endif

                    <div class="d-inline">
                        <x-created-updated :date='$post->created_at'> Crated at</x-created-updated>
                        @if ($post->created_at != $post->updated_at)
                            <x-created-updated :date='$post->updated_at'> Updated at</x-created-updated>
                        @endif
                    </div>
                    
                </div>
                @auth           
                    <div class="card-footer">
                        
                        <div class="d-flex justify-content-between">
                            <div>
                                @can('update', $post)
                                    <a class="btn btn-secondary" href="{{route('posts.edit',$post->id)}}">Edit your post</a>
                                @endcan
                                @can('restore', $post)
                                    @if ($post->deleted_at)
                                        <form class="d-inline" action="{{route('post.restore',$post->id)}}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="submit" class="btn btn-success" value="Restore">
                                        </form>
                                    @endif
                                @endcan
                            </div>
                            

                            @can('delete', $post)
                                @if ($post->deleted_at === null)
                                    <form action="{{route('posts.destroy',$post->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delet your post</button>
                                    </form>                            
                                @else
                                    <form action="{{route('posts.destroy',$post->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Force delet </button>
                                    </form>       
                                @endif

                            @endcan

                        </div>
                        
                        @include('posts.formComment',['id' => $post->id])

                    </div>
                @endauth
            </div>                
            @empty
                <div class="">list is empty</div>
            @endforelse

        </div>

        <!--Side bar-->
        @include('posts.sidebar')
    </div>

@endsection