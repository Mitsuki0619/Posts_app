@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card post-create-card">
                <div class="card-header">返信</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('comments.store') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">返信内容</label>
                            <textarea class="content" name="comment" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>
                        @if($errors->has('comment'))
                            <div class="error">
                                <p class="errors">{{ $errors->first('comment') }}</p>
                            </div>
                        @endif 
                        <div class="form-group">
                            <input type="file" name="file" class="">
                        </div>
                        @if($errors->has('file'))
                            <div class="error">
                                <p class="errors">{{ $errors->first('file') }}</p>
                            </div>
                        @endif 
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        <input type="hidden" name="post_id" value="{{ $post_id }}">

                        <button type="submit" class="btn btn-primary">投稿</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
