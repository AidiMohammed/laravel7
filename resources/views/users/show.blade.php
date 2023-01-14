@extends('layouts.app')

@section('content')

<h1>Profile user: {{ $user->username}}</h1>
<div class="row hidden tab" id="profile">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12 text-center">
                <!-- chack user is has avatar -->
                    <img class="rounded-circle my-4" src="https://bootdey.com/img/Content/avatar/avatar4.png"/>
                <h2>{{$user->username}}</h2>
            </div>
        </div>
    </div>
</div>
@endsection