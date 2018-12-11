@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="/posts/create" class='btn btn-primary'>Create Post</a>
                    <h3>Your Blog Post</h3>

                    @if(count($posts)>0)
                        <table class='table table-stripped table-hover'>
                            <tr>
                                <th>Title</th>
                            </tr>
                            
                            @foreach ($posts as $post)
                                    <tr>
                                           
                                        <td>
                                                <a href="/posts/{{$post->id}}">                                               
                                                {{$post->title}}
                                                </a>
                                        </td>
                                    

                                        <td class='btn'>
                                            <a href="/posts/{{$post->id}}/edit" class="btn btn-info">Edit</a>
                                        </td>
                                        <td class='pt-1'>
                                            {!! Form::open(['action' => ['PostsController@destroy',$post->id], 'method'=>'POST', 'class'=>'btn float-right']) !!}
                                            {{Form::hidden('_method','DELETE')}}
                                            {{Form::submit('Delete',['class'=>'btn btn-danger'])}}
                                            {!! Form::close() !!}
                                       </td>
                                    </tr>
                            @endforeach
                        </table>
                    @else
                        <p>You have no post</p>
                    @endif




                </div>
            </div>
        </div>
    </div>
</div>
@endsection
