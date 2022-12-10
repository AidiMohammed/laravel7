@extends('layouts.app')

@section('content')
    <h1>show post {{$post->title}}</h1>

    
    <div class="card">
        <div class="card-header">
            {{$post->title}}
        </div>
        <div class="card-body">
            <h4 class="card-title">{{$post->title}}</h4>
            <p class="card-text">{{$post->content}}</p>
            <em>created at : {{$post->created_at->diffForhumans()}}</em>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-body d-flex justify-content-center" >
          <h3><strong>Comments </strong></h3>
        </div>
    </div>
    @if (count($post->comments) > 0)
        <div class="row row-cols-1 row-cols-md-2 g-4 mt-2">
    @endif
        @forelse ($post->comments->all() as $comment)
         <div class="col">
          <div class="card">
            <div class="card-body">
              <p class="card-text">{{$comment->content}}</p>
              <em>created at : {{$comment->created_at->diffForHumans()}}</em>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <div >
                    <a class="btn btn-warning" style="direction: unset" href="">Edit</a>
                    <form style="display: inline" action="{{route('comment.destroy',$comment->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit" id="submit">Delete</button>
                    </form>
                </div>
                <h6 style="font-size: 0.8em">Comment create by {{$comment->user->username}}</h6>
            </div>
          </div>
        </div>
        @empty
        <div class="alert alert-warning mt-2 d-flex justify-content-center" role="alert">
            No comment for this post!
        </div>
        @endforelse

    @if (count($post->comments) > 0)
        </div>
    @endif

@endsection