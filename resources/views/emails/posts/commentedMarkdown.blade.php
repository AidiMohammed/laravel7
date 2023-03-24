@component('mail::message')
# you hav one comment 

SomeOne has comment your post {{$comment->commentable->title}}

The body of your message.

@component('mail::button', ['url' => route('posts.show',['post' => $comment->commentable->id])])
show post
@endcomponent

@component('mail::button',['url' => route('user.show',['user' => $comment->user->id])])
    {{$comment->user->username}}
@endcomponent

@component('mail::panel')
    {{$comment->content}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
