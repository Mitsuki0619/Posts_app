<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;
use App\Models\Tag;
use App\Http\Requests\PostRequest;


class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $q = \Request::query();
        if(isset($q['name'])){

            $posts = Post::latest()->where('content', 'like', "%{$q['name']}%")->paginate(30);
            $posts->load('user', 'tags');

            $tags = Tag::withCount('posts')->orderBy('posts_count', 'desc')->paginate(7);


            return view('posts.index', [
                'posts' => $posts,
                'name' => $q['name'],
                'trendTags' => $tags
            ]);

        } else {
            $posts = Post::latest()->paginate(30);
            $posts->load('user', 'tags');
            $tags = Tag::withCount('posts')->orderBy('posts_count', 'desc')->paginate(7);
            return view('posts.index', ['posts' => $posts, 'trendTags' => $tags]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {

        // 画像アップロード処理
        if($request->hasFile('file')){
            if($request->file('file')->isValid([])) {
                $path = $request->file->store('public');
                $file_name = basename($path);
            }
        } 
        else {
            $file_name = null;
        }
        
        // 投稿処理
        $post = new Post();
        $user = Auth::user();
        $user_id = $user->id;
        $post->content = $request->content;
        $post->user_id = $user_id;
        $post->file_name = $file_name;

        preg_match_all('/#([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $request->content, $match);

        $tags = [];
        foreach ($match[1] as $tag) {
            $found = Tag::firstOrCreate(['name' => $tag]);

            array_push($tags, $found);
        }

        $tag_ids = [];

        foreach ($tags as $tag) {
            array_push($tag_ids, $tag['id']);
        }

        $post->save();
        $post->tags()->attach($tag_ids);


        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        if(is_null($post)){
            \Session::flash('err_msg', 'データがありません。');
            return redirect('/');
        }

        return view('posts.detail', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(Request $request)
    {
        $posts = Post::where('content', 'like', "%{$request->search}%")
                ->paginate(30);
        
        $tags = Tag::withCount('posts')->orderBy('posts_count', 'desc')->paginate(7);



        $search_result = $request->search.'の検索結果'.$posts->total().'件';

        return view('posts.index', [
            'posts' => $posts,
            'search_result' => $search_result,
            'search_query'  => $request->search,
            'trendTags' => $tags,
        ]);
    }
}
