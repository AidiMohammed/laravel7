<h5 class="card-title">
    <a href="#" class="" id="navbarDropdown" class ="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        
        <img src="
            @if ($user->image)
                {{$user->image->url()}}
            @else
                http://localhost:8000/storage/users/default/default-avatar.jpg
            @endif
        " alt="default iamge user" class="rounded-circle" width="40" height="40" >
    </a>
    <a href="{{route('user.show',['user' => $user->id])}}">{{$user->username}}</a>
</h5>