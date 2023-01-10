@foreach ($tags as $tag)
    <x-badge type='success'>{{$tag->name}}</x-badge>
@endforeach