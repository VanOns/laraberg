@extends('layouts.app')

@section('content')
    <h1>Home</h1>

    <ul>
        <li><a href="{{route('posts.index')}}">Posts</a></li>
        <li><a href="{{route('posts.create')}}">Create Post</a></li>
    </ul>
@endsection
