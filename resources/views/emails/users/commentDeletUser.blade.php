@component('mail::message')
# **[{{$comment->user->username}}]({{route('user.show',['user' => $comment->user->id])}})** to delete his comment !

### comment

@component('mail::panel')
    {{$comment->content}}
@endcomponent

@component('mail::button', ['url' => route('user.show',['user' => $comment->commentable->id])])
    Your profile
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
