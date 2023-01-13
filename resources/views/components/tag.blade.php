@foreach ($tags as $tag)
    <a href="{{route('posts.tag.index',['tag' => $tag->id])}}"><x-badge type='success'>#{{$tag->name}}</x-badge></a>
@endforeach