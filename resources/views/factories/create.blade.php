@extends('masterPage')

@section('content')
    <h1>Create Posts</h1>
    <form method="POST" action="{{route('factories.storePosts')}}">
        @csrf
        <div class="mb-3">
          <label for="nmbrPosts" class="form-label">Nomber Post</label>
          <input type="number" name="nmbrPosts" class="form-control" id="nmbrPosts" aria-describedby="nmbrPosts">
          <div id="emailHelp" class="form-text">nomber of posts you want create</div>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
      </form>
@endsection