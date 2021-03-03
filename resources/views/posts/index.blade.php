@extends('layouts.app')

@section('content')
<div class="all-container">
    <!-- メニュー -->
    <div class="menu">
        <nav class="top-menu">
            <a class="" href="{{ route('posts.create') }}">
                <li>
                    投稿する
                </li>
            </a>
           
            <a href="{{ route('posts.index') }}">
                <li>
                    ホーム
                </li>
            </a>   
            <a href="{{ route('users.show', Auth::id()) }}">
                <li>
                    自分の投稿
                </li>
            </a>   
            
            <a class="" href="{{ route('logout') }}"  onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                <li>
                    ログアウト
                </li>
            </a>

        </nav>

    </div>

    <!-- 投稿一覧 -->
    <div class="post-container">
        <div class="top-title">投稿一覧 
            @isset($search_result)
                <h5 class="card-title">{{ $search_result }}</h5>
            @endisset
            @isset($name)
                <h5 class="card-title">#{{ $name }}</h5>
            @endisset
        </div>
                <div class="">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif



                    <!-- 投稿 -->
                        <ul class="posts">
                        @foreach($posts as $post)
                            <a href="{{ route('posts.show', $post->id) }}">
                                <li class="post">
                                    <!-- 投稿者 -->
                                    <object class="user" data="" type="">
                                            <a href="{{ route('users.show', $post->user_id) }}">
                                                <div class="user_info">
                                                    <h2 class="user_name">
                                                        {{ $post->user->name }}
                                                    </h2>
                                                    <div class="user_id">id:{{ $post->user_id }}</div>
                                                </div>
                                            </a>
                                    </object>

                                    <!-- 投稿内容 -->
                                    <p class="post_text">{{ $post->content }}</p>
                                    @if($post->file_name)
                                        <div class="post_image">
                                            <img class="img" src="{{ asset('storage/'.$post->file_name) }}" alt="">
                                        </div>
                                    @endif

                                    <!-- タグ -->
                                    <h5 class="card-title">
                                    @foreach($post->tags as $tag)
                                        <object data="" type="">
                                            <a href="{{ route('posts.index', ['name' => $tag->name]) }}">
                                                #{{ $tag->name }}
                                            </a>
                                        </object>
                                    @endforeach
                                    </h5>

                                    <!-- 機能 -->
                                    <object class="postUnder">
                                        <div class="postNav">
                                            <!-- いいね -->
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

                                            <!-- 返信 -->
                                            <object data="" type="" class="">
                                                <a href="{{ route('comments.create', ['post_id' => $post->id]) }}"><div class="btn btn-primary reply">返信</div></a>
                                            </object>
                                        </div>
                                    </object>
                                </li>
                            </a>
                        @endforeach
                        </ul>
                </div>
            
    </div>

    <!-- トレンド -->
    <div class="trend-container">
        <h3 class="top-title-trend">投稿検索</h3>

        <!-- 検索 -->
        <form  action="{{ route('posts.search') }}" class="form-inline my-2 my-lg-0 ml-2 search-form" method="get">
         {{ csrf_field() }}
             <div class="form-group">
             <input type="text" class="form-control mr-sm-2" name="search"  value="" placeholder="キーワードを入力" >
             </div>
             <input type="submit" value="検索" class="btn btn-info">
         </form>

         <h3　class="top-title-trend">人気のタグ</h3>
         <div class="trendTags">
            @foreach($trendTags as $trendTag)
            <a href="{{ route('posts.index', ['name' => $trendTag->name]) }}" >
                <div class="trendTag">
                    #{{ $trendTag->name }}
                </div>
            </a>
            <br>
            @endforeach
         </div>
    </div>
</div>



@endsection