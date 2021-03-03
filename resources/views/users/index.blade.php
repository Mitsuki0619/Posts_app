@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card user-card">
            <div class="card-header"><span class="user-name">{{ $user->name }}</span>の投稿</div>
                <div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        <ul class="posts">
                        @foreach($user->posts as $post)
                            <a href="{{ url('posts/'.$post->id) }}">
                                <li class="post">
                                        <object data="" type="">
                                                <a href="{{ url('users/'.$post->user_id) }}">
                                                    <div class="user_info">
                                                        <h2 class="user_name">
                                                            {{ $post->user->name }}
                                                        </h2>
                                                        <div class="user_id">id:{{ $post->user_id }}</div>
                                                    </div>
                                                </a>
                                        </object>
                                    <p class="post_text">{{ $post->content }}</p>
                                    @if($post->file_name)
                                        <div class="post_image">
                                            <img class="img" src="{{ asset('storage/'.$post->file_name) }}" alt="">
                                        </div>
                                    @endif
                                </li>
                            </a>
                        @endforeach
                        </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection