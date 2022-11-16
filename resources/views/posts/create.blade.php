@extends('layouts.app')

@section('content')
      <h1>Create new post</h1>
      
      <form method="POST" action="{{route('posts.store')}}">
        @csrf
        @include('posts.form')
        
        <button type="submit" class="btn btn-primary" id="submit">Create new post</button>
      </form>
@endsection