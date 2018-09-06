@extends('layouts.app')
@section('content')

<h1>Edit Post</h1>

{!! Form::open(['action'=>['PostsController@update',$post->id],'method' => 'POST','enctype' => 'multipart/form-data']) !!}
    {{Form::label('title', 'Title')}}
    {{Form::text('title', $post->title, ['class'=>'form-control','placeholder'=>'Title'])}}

    {{Form::label('body', 'Body')}}
    {{Form::textarea('body',$post->body, ['class'=>'form-control','placeholder'=>'Enter your text here'])}}
    <br>

    {{Form::hidden('_method','PUT')}}
    {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
    <a href="/post" class="btn btn-secondary">Back</a>
    
{!! Form::close() !!}

@endsection