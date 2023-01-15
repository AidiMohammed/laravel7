@extends('layouts.app')

@section('content')

<h1>Edit your profile</h1>
<div class="row hidden tab" id="profile">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12 text-center">
                @if ($user->image)
                    <img class="rounded-circle my-4" src="{{$user->image->url()}}" height="320" width="320"/>                    
                @else
                    <img class="rounded-circle my-4" src="http://localhost:8000/storage/users/default/default-avatar.jpg" height="320" width="320"/>                    
                @endif
                <h2>{{$user->username}}</h2>
            </div>

            <div class="col-md-8 ">
                <form action="{{route('user.update',['user'=> $user->id])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="form-label" for="username">Name* :</label>
                        <input type="text" id="username" class=" @error('username') is-invalid @enderror form-control" name='username' value="{{old('username',$user->username ?? null)}}">

                        @error('username')
                            <span class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group my-4">
                        <label class="form-label" for="avatar">Avatare :</label>
                        <input type="file" class="form-control-file @error('avatar') is-invalid @enderror" name="avatar" id="avatar">

                        @error('avatar')
                            <span class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </span>    
                        @enderror
                    </div>

                    <button class="btn btn-primary" type="submit" >Update profile</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection