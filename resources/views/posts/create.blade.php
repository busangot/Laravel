@extends('layouts.app')
@section('content')

<h1>Create Post</h1>

{!! Form::open(['action'=>'PostsController@store','method' => 'POST','enctype' => 'multipart/form-data']) !!}
    {{Form::label('title', 'Title')}}
    {{Form::text('title','', ['class'=>'form-control','placeholder'=>'Title'])}}

    {{Form::label('body', 'Body')}}
    {{Form::textarea('body','', ['class'=>'form-control','placeholder'=>'Enter your text here'])}}
    <br>

    {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
    <a href="/post" class="btn btn-secondary">Back</a>
    
{!! Form::close() !!}

@endsection