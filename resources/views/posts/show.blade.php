@extends('layouts.app')
@section('content')

<center>

<h1>{{$post->title}}</a></h1>
<p>{{$post->body}}</p>
<hr>
<footer>
    <small>
           Written {{$post->created_at}} Posted: {{\Carbon\Carbon::parse($post->created_at)->diffForHumans()}}<br>
           Written by {{$post->user->name}}
    </small>
</footer>

@if(!Auth::guest())
    @if(Auth::user()->id == $post->user_id)
        {!!Form::open(['action'=>['PostsController@destroy',$post->id], 'method'=>'POST' ,'class' => 'pull-right'])!!}
        {{Form::hidden('_method','DELETE')}}
        <a href="/post/{{$post->id}}/edit" class="btn btn-primary">Edit</a>
        {{Form::submit('Delete',['class'=>'btn btn-danger'])}}
        <a href="/post" class="btn btn-secondary">Back</a>
        {!!Form::close()!!}
    @else
        <br><br><a href="/post" class="btn btn-secondary">Back</a>
    @endif
@endif

@guest
<br><br><a href="/post" class="btn btn-secondary">Back</a>
@endif


</center>
@endsection