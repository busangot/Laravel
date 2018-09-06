<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use Cache;
use DB;
use App\Post;
use App\User;
use Carbon\Carbon;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
        $this->storage = Redis::Connection();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $start = microtime(true);
        //with cache
        $posts = Cache::remember('posts', 1, function(){
            return Post::orderBy('created_at', 'desc')->paginate('5');
        });

        // without cache
        // $posts = Post::orderBy('created_at', 'desc')->paginate('5');
        
        $duration = (microtime(true) - $start) * 1000;
        print_r("delay/µs: ".$duration);
        
        return view('posts.index')->with('posts', $posts);     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Cache::forget('posts');
        Cache::forget('temp_post');
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        $posts = new Post;
        $posts->title = $request->input('title');
        $posts->body = $request->input('body');
        $posts->user_id = auth()->user()->id;
        $posts->save();

        return redirect('/post')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $start = microtime(true);
        $this->id = $id;
        if ($id == Cache::get('id')){
            $post = Cache::remember('temp_post', 1, function(){
                return Post::find($this->id);
            });
            $duration = (microtime(true) - $start) * 1000;
            print_r("delay/µs: ".$duration);
            return view('posts.show')->with('post', $post);

        } else {
            Cache::put('id', $id, 1);
            Cache::forget('temp_post');
            $post = Cache::remember('temp_post', 1, function(){
                return Post::find($this->id);
            });
            
            $duration = (microtime(true) - $start) * 1000;
            print_r("delay/µs: ".$duration);
            return view('posts.show')->with('post', $post);   
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        if(auth()->user()->id !== $post->user_id){
            return redirect('/post')->with('error','Page Cannot be access');
        }

        Cache::forget('posts');
        Cache::forget('temp_post');
        return view('posts.edit')->with('post', $post);
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
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        $posts = Post::find($id);
        $posts->title = $request->input('title');
        $posts->body = $request->input('body');
        $posts->save();

        Cache::forget('posts');
        Cache::forget('temp_post');
        return redirect('/post')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if(auth()->user()->id !== $post->user_id){
            return redirect('/post')->with('error','Page Cannot be access');
        }
        $post->delete();
        Cache::forget('posts');
        Cache::forget('temp_post');

        return redirect('/post')->with('error', 'Post Deleted');
    }
}
