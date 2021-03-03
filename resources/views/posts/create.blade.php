@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card post-create-card">
                <div class="card-header">投稿を作成</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        
        
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">投稿内容</label>
                            <textarea class="content" name="content" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>
                        @if($errors->has('content'))
                            <div class="error">
                                <p class="errors">{{ $errors->first('content') }}</p>
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



                        <button type="submit" class="btn btn-primary">投稿</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
