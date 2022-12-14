@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{Auth::user()->username}} You are logged in! your acompte created at {{Auth::user()->created_at->diffForHumans()}}
                    
                    @if(Auth::user()->is_admin)
                        <p><a href="{{route('secret')}}">Page administration</a></p>
                        <p><a href="{{route('factories')}}">Create posts</a></p>   
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
