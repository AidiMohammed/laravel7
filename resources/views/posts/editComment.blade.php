@extends('layouts.app')

@section('content')
    <h1>Edit Comment</h1>


    <form method="POST" action="{{route('comment.update', ['comment' => $comment->id])}}" >
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="comment" class="form-label mt-4">Edit your comment :</label>
    
            @if (session('errorCommentId') == $comment->id)
                <textarea class="form-control is-invalid" id="comment" name="content" rows="4"></textarea>
            @else          
                <textarea class="form-control" id="comment" name="content" rows="4">{{old('comment',$comment->content)}}</textarea>
            @endif
    
            @if(session('errorCommentId') == $comment->id)
                <span class="invalid-feedback"><strong>{{session('errorComment')}}</strong></span>
            @endif
        </div>
        <button type="submit" class="btn btn-warning">Edit comment</button>
    </form>
@endsection