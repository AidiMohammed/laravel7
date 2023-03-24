<p>
    SomeOne has comment your post
    <a href="{{route('posts.show',['post'=> $comment->commentable->id])}}">{{$comment->commentable->title}}</a>
</p>

<p>
    <a href="{{route('user.show',['user' => $comment->user->id])}}">{{$comment->user->username}}</a> Said: 
</p>

<p>
    {{$comment->content}}.
</p>