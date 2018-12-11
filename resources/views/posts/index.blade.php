@extends('layouts.app')

@section('content')
    <h1>Posts</h1>
    
    @if(count($posts)>0)
        @foreach ($posts as $post)
        <div class='card p-3 well'>
        <div class='row col-md-3 col-sm-3'>
                                <h3><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
                                
             </div>
             <div class='row col-md-12 col-sm-12'>
                    <table class='table-stripped col-sm-12 col-md-12'>
                            
                            <tr>
                                <td>
                                        <i>by {{$post->user->name}}</i>
                                </td>
                                @if(Auth::id()==$post->user->id)
                                <td>
                                    <a href="/posts/{{$post->id}}/edit" class="btn btn-info">Edit</a>
                                </td>
                                @endif
                            </tr>
                           
                            </table>
             </div>
                    
                    <div class='row col-md-8 col-sm-8'>
                    <a href="/posts/{{$post->id}}"><img style='width:50%' class="img-thumbnail" src='/storage/cover_images/{{$post->cover_image}}'></a>    
                </div>
                <div class="container btn-group p-2">
                    <a href="/posts/{{$post->id}}/like" class="btn btn-success">Like</a>
                    <a href="/posts/{{$post->id}}/dislike" class="btn btn-danger">Dislike</a>
                </div>
        </div>
                    <hr>
                
        @endforeach
        {{$posts->links()}}
    @else
        <p>No post found</p>
    @endif

@endsection