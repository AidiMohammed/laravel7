@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-8">
            <h1>show post {{$post->title}}</h1>
            <div class="card">
                <div class="card-header">
                    {{$post->title}}
                </div>

                <div class="card-body">
                    @if ($post->image)
                        <img src="{{$post->image->url()}}" class="card-img fluid mb-4" alt="image {{$post->title}}">
                    @else
                        <img src="{{Storage::url('posts/default/default-post.jpg')}}" class="card-img mb-4" alt="iamge defaut post" height="600" width="600">
                    @endif
                    <h4 class="card-title">{{$post->title}}</h4>
        
                    <x-tag :tags="$post->tags"></x-tag>
                    <hr>
        
                    <p class="card-text">{{$post->content}}</p>
                    <em>created at : {{$post->created_at->diffForhumans()}}</em>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <div class="">
                        @can('update', $post)
                            <a class="btn btn-secondary" href="{{route('posts.edit',['post' => $post->id])}}">Edit</a>
                        @endcan
                    </div>
                    <h6 class="text-muted">Created by : {{$post->user->username}}</h6>

                </div>
            </div>

            <div id="comments-post">

                <div class="card mt-4">
                    <div class="card-body d-flex justify-content-center" >
                    <h3><strong>Comments </strong></h3>
                    </div>
                </div>

                @include('posts.formComment',['id' => $post->id])

                <x-list-items :items='$post->comments'></x-list-items>

            </div>

        </div>

        @include('posts.sidebar')
    </div>
   

@endsection