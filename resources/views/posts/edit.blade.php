@extends('layouts.app')

@section('content')

  <h1>Edit Post {{$post->title}}</h1>
  @if ($post->image)
    <div class="text-center">
      <img class="fluid m-6" src="{{$post->image->url()}}" alt="image {{$post->title}}" width="760" height="600">
    </div>
  @endif
  
  <form method="POST" action="{{route('posts.update',$post)}}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('posts.form')
    
    <button type="submit" class="btn btn-warning">Update post</button>
  </form>

@endsection