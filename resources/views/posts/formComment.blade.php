<form method="POST" action="{{route('comments.storeMyComment', ['post' => $id])}}" class="mb-4">
    @csrf

    <div class="form-group">
        <label for="comment-{{$post->id}}" class="form-label mt-4"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Add new comment :</font></font></label>

        @if (session('errorCommentId') == $id)
            <textarea class="form-control is-invalid" id="comment-{{$post->id}}" name="content" rows="4"></textarea>
        @else          
            <textarea class="form-control" id="comment-{{$post->id}}" name="content" rows="4"></textarea>
        @endif

        @if(session('errorCommentId') == $id)
            <span class="invalid-feedback"><strong>{{session('errorComment')}}</strong></span>
        @endif
    </div>
    <button type="submit" class="btn btn-outline-primary">Add comment</button>
</form>