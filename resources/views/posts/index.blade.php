@extends('layouts.app')
@section('content')

<h1>Post Feed</h1>

@if(count($posts) > 0)
    <ul class="list-group">
        @foreach($posts as $post)
        <li class="list-group-item">
            <h3><a href="/post/{{$post->id}}">{{$post->title}}</a></h3>
            <p>{{$post->body}}</p>
            <hr>
            <small>{{$post->created_at}}</small>
        </li>
        @endforeach
        {{$posts->links()}}
    </ul>
@endif

@endsection