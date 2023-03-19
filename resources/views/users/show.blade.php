@extends('layouts.app')

@section('content')
    <div class="row">
         <div class="col-md-4 ">
            <div class="d-flex justify-content-center">

                <div class="card-user p-3">

                    <div class="d-flex align-items-center">
                        <div class="image">
                            @if ($user->image)
                                <img src="{{Storage::url($user->image->path)}}" alt="avatar user" class="rounded" width="100">
                            @else
                                <img src="http://localhost:8000/storage/users/default/default-avatar.jpg" class="rounded" width="100" >
                            @endif
                        </div>
                    <div class="ml-3 w-100">
                        
                       <h4 class="mb-0 mt-0">{{$user->username}}</h4>
                       <span>{{$user->email}}</span>
    
                       <div class="text-center p-2 mt-2 bg-primary d-flex justify-content-between rounded text-white stats">
    
                        <div class="d-flex flex-column">
    
                            <span class="articles">Posts</span>
                            <span class="number1">{{count($user->posts)}}</span>
                            
                        </div>
    
                        <div class="d-flex flex-column">
    
                            <span class="followers">Opinions</span>
                            <span class="number2">{{$user->comments_count}}</span>
                            
                        </div>
    
    
                        <div class="d-flex flex-column">
    
                            <span class="rating">Comments</span>
                            <span class="number3">{{$postCommentsCount}}</span>
                            
                        </div>
                           
                       </div>
    
    
                       <div class="button mt-2 d-flex flex-row align-items-center">
                        @can('update', $user)
                            <a href="{{route('user.edit',$user->id)}}" class="btn btn-sm btn-outline-primary w-100">Edit Profile</a>
                        @endcan
    
                       </div>
    
    
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <x-form-comment :model="$user" action="{{route('user.comment.store',$user->id)}}"></x-form-comment>
        </div>
    </div>

        <div class="card mt-4">
            <div class="card-body d-flex justify-content-center" >
              <h3><strong>Opinions </strong></h3>
            </div>
        </div>

        <x-list-items :items='$user->comments'></x-list-items>
    
@endsection