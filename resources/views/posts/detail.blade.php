@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card detail-card">
                <div class="card-header">投稿詳細</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="user_info">
                        <h2 class="user_name">
                            {{ $post->user->name }}
                        </h2>
                        <div class="user_id">id:{{ $post->user_id }}</div>
                    </div>
                    <p class="post_text">{{ $post->content }}</p>
                    @if($post->file_name)
                    <div class="post_image">
                        <img class="img" src="{{ asset('storage/'.$post->file_name) }}" alt="">
                    </div>
                    @endif
                </div>
                <div class="postUnder">
                    <p class="timestamp">{{ $post->created_at }}</p>
                    <div class="postNav">
                    @if($post->users()->where('user_id', Auth::id())->exists())
                    <form action="{{ route('unlikes', $post) }}" method = "post" class="likeForm">
                    {{ csrf_field() }}
                        <input type="submit" class="fas fa-heart likeBtn onLike" value="&#xf004"></i>
                    </form>
                    @else
                    <form action="{{ route('likes', $post) }}" method = "post" class="likeForm">
                    {{ csrf_field() }}
                        <input type="submit" class="far fa-heart likeBtn" value="&#xf004"></i>
                    </form>
                    @endif
                        <a href="{{ route('comments.create', ['post_id' => $post->id]) }}"><div class="btn btn-primary reply">返信</div></a>
                    </div>
                </div>
            </div>
            @if(count($post->comments) > 0)
                <h4 class="comment-show">返信一覧</h4>
            @endif

            <div class="comment-container">
            @foreach($post->comments as $comment)
                <div class="card comment-card">
                <div class="user_info">
                        <h2 class="user_name">
                            {{ $comment->user->name }}
                        </h2>
                        <div class="user_id">id:{{ $comment->user_id }}</div>
                    </div>
                    <p class="post_text">{{ $comment->comment }}</p>
                    @if($comment->file_name)
                    <div class="post_image">
                        <img class="img" src="{{ asset('storage/'.$comment->file_name) }}" alt="">
                    </div>
                    @endif
                    <p class="timestamp">{{ $comment->created_at }}</p>

                </div>
            @endforeach
            </div>
        </div>
    </div>
</div>
@endsection