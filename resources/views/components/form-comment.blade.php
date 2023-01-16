<form method="POST" action="{{$action}}">
    @csrf

    <div class="form-group">
        <label for="comment-{{$model->id}}" class="form-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Add new comment :</font></font></label>

        @if (session('errorCommentId') == $model->id)
            <textarea class="form-control is-invalid" id="comment-{{$model->id}}" name="content" rows="3" placeholder="Add new comment"></textarea>
            <span class="invalid-feedback"><strong>{{session('errorComment')}}</strong></span>
        @else          
            <textarea class="form-control" id="comment-{{$model->id}}" name="content" rows="4"></textarea>
        @endif
    </div>
    <button type="submit" class="btn btn-outline-primary">Add comment</button>
</form>