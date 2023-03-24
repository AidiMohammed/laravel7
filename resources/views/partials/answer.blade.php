@foreach ($item->answers as $item)

<div class="be-img-comment">	
    @if ($item->user->image)
        <a href="{{route('user.show',$item->user_id)}}">
            <img src="{{Storage::url($item->user->image->path)}}" alt="avatar user" class="be-ava-comment">
        </a>
    @else 
        <a href="blog-detail-2.html">
            <img src="{{Storage::url('/users/default/default-avatar.jpg')}}" alt="avater default user" class="be-ava-comment">
        </a>
    @endif
</div>
<div class="be-comment-content">
    <span class="be-comment-name">
        <a href="{{route('user.show',$item->user_id)}}">{{$item->user->username}}</a> @ {{$item->comment->user->username}}
    </span>
    <span class="be-comment-time">
        <i class="fa fa-clock-o"></i>
        {{$item->created_at->diffForHumans()}}
    </span>

    <p class="be-comment-text bg-dark">
        {{$item->content}}
    </p>

    <div class="my-3 d-flex">
        @can('update', $item)
            <a href="" class="btn btn-primary btn-sm mr-2">Edit</a>
        @endcan
        @can('delete', $item)
            <form style="display: inline;" action="{{route('comment.answer.delete',['answer' => $item->id])}}" method="POST">
                @csrf
                @method("DELETE")
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
        @endcan

    </div>
</div>
@endforeach