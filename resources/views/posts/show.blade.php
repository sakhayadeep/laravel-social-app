@extends('layouts.app')

@section('content')

<a href='/posts' class="btn btn-primary">Go back</a>
    <h1>{{$post->title}}</h1>
    <p> by <b>{{$post->user->name}}</b></p>
    <hr>
    <img style='width:100%' class="rounded" src='/storage/cover_images/{{$post->cover_image}}'>

    <div class="">
        {!!$post->body!!}
    </div>
    <hr>
<small>written on : {{$post->created_at}}</small>
    
    <hr>
    @if(Auth::id()==$post->user->id)
            <a href="/posts/{{$post->id}}/edit" class="btn btn-info">Edit</a>

            {!! Form::open(['action' => ['PostsController@destroy',$post->id], 'method'=>'POST', 'class'=>'btn float-right']) !!}
                {{Form::hidden('_method','DELETE')}}
                {{Form::submit('Delete',['class'=>'btn btn-danger'])}}
            {!! Form::close() !!}
    @endif
@endsection