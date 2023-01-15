@extends('layouts.app')

@section('content')

<h1>Profile user: {{ $user->username}}</h1>
<div class="row hidden tab" id="profile">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12 text-center">
                <!-- chack user is has avatar -->
                @if ($user->image)
                    <img class="rounded-circle my-4" src="{{$user->image->url()}}"/>                    
                @else
                    <img class="rounded-circle my-4" src="http://localhost:8000/storage/users/default/default-avatar.jpg"/>                    
                @endif
                <h2>{{$user->username}}</h2>

                @can('update', $user)
                    <a href="{{route('user.edit',['user' => $user->id])}}" class="btn btn-info btn-sm">Edit Profile</a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection