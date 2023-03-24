<p>
    <span style="font-weight: 700 ">{{$comment->user->username}} </span> commented on your profile
    <a href="{{route('user.show',['user' => $comment->commentable->id])}}" class="button-blue">Your profile</a>
</p>