@extends('layouts.app')
@section('content')

    <h1>{{$title}}</h1>
    <ul>    
        @for ($i = 0; $i < count($services); $i++)
            <li>         
                <a href="{{$ids[$i]}}">{{$services[$i]}}        
            </li>
        @endfor
    </ul>

@endsection