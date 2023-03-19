<div class="card my-3">
    <div class="card-body">
        <h4 class="card-title">{{$title}}</h4>
        @isset($text)
            <p class="text-muted">{{$text}}</p>
        @endisset 
    </div>
    <ul class="list-group list-group-flush">
        @forelse ($items as $item)
            <li class="list-group-item">
                <p><span class="badge badge-info ">{{$item->posts_count}} </span> <a href="{{route('user.show',['user' => $item->id])}}">{{$item->username}}</a></p>
            </li>
        @empty
            <div>Non item found !!</div>
        @endforelse
    </ul>
</div>