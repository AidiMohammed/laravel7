<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    <title>Document</title>
</head>
<body>

    <nav class="navbar navbar-expand navbar-dark bg-primary shadow-sm d-flex justify-content-between">
        <ul class="nav navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{route('home')}}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('home.aboutPage')}}">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('posts.index')}}">Posts</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('posts.create')}}">New post</a>
            </li>
        </ul>
        <ul class="nav navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{route('factories.createPosts')}}">Factories</a>
            </li>
        </ul>
    </nav>
    
    <div class="container">
            @if (session()->has('status'))
            <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                {{session()->get('status')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        @yield('content')
    </div>

</body>
</html>