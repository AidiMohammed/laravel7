@extends('layouts.app')

@section('content')

<h1>Edit your profile</h1>
<div class="row hidden tab" id="profile">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12 text-center">
                <img class="rounded-circle " src="https://bootdey.com/img/Content/avatar/avatar4.png"/>
                <h2>{{$user->username}}</h2>
            </div>

            <div class="col-md-8 ">
                <form action="{{route('user.update',['user'=> $user->id])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="form-label" for="name">Name* :</label>
                        <input type="text" class="form-control" name='username' value="{{old('username',$user->username ?? null)}}">
                    </div>

                    <div class="form-group my-4">
                        <label class="form-label" for="avatar">Avatare :</label>
                        <input type="file" class="form-control-file" value="Mohamed.png">
                    </div>

                    <button class="btn btn-primary" type="submit" >Update profile</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection