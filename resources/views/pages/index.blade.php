@extends('layouts.app')
@section('content')

<h1>Written Post</h1>
<ul class="list-group">
    @foreach($posts as $post)
        <li class="list-group-item">
            <a href="/post/{{$post->id}}"><h1>{{$post->title}}</h1></a>
            <p>{{$post->body}}</p>
            <hr>
            <small>written by {{$post->user->name}} on {{$post->created_at}}</small>
        </li>
    @endforeach
</ul>

@endsection