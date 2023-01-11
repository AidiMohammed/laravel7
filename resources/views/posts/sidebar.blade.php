<div class=" col-4">
    <div class="card my-3">
        <div class="card-body">
            <h4 class="card-title">Most Commented posts</h4>
        </div>
        
        <ul class="list-group list-group-flush">
            @forelse ($mostCommented as $post)
            <li class="list-group-item">
                <a href="#">{{$post->title}}</a>
                <div class="d-flex justify-content-between">
                    <p>created by : {{$post->user->username}}</p>
                    {{$post->comments_count}} comment(s)
                </div>
            </li>
            @empty
            <div>List is empty</div>                    
            @endforelse
        </ul>
    </div>

    <div class="card my-3">
        <div class="card-body">
            <h4 class="card-title">Most Active users</h4>
        </div>
        <ul class="list-group list-group-flush">
            @forelse ($mostActiveUser as $user)
                <li class="list-group-item">
                    <p>{{$user->username}}</p>
                    <div class="d-flex justify-content-between">
                        <p>email : {{$user->email}}</p>
                        {{$user->posts_count}} post(s)
                    </div>
                </li>
            @empty
                <div>List is empty</div>                    
            @endforelse
        </ul>
    </div>

    <x-card
        title="Most Active users"
        :items="collect($mostActiveUser)">
    </x-card>

    <x-card
        title="User Active"
        text="User active in last month"
        :items="collect($userAvtiveLastMonth)">
    </x-card>
</div>