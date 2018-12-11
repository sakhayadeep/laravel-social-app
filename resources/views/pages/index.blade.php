@extends('layouts.app')

@section('content')
  
  <div class="container">
    <div class="jumbotron text-center">
      <h1 class="display-3">Welcome to Laravel Social Media</h1>
      @guest
      <p>Log in to create posts</p>
      @endguest
      <p>
        @guest
            <a class="btn btn-primary btn-lg" href="/login" role="button">login</a>  
            <a class="btn btn-success btn-lg" href="/register" role="button">Sign Up</a>
        @else
            <p>Welcome {{Auth::User()->name}}</p>
        @endguest
      </p>
    </div>
  </div>
@endsection
