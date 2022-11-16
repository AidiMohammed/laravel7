@extends('layouts.app')

@section('content')

  <h1>Edit Post {{$post->title}}</h1>
  
  <form method="POST" action="{{route('posts.update',$post)}}">
    @csrf
    @method('PUT')
    @include('posts.form')
    
    <button type="submit" class="btn btn-warning">Update post</button>
  </form>

@endsection