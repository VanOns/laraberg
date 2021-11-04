@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>{{$post->title}}</h2>
        <div>{!! $post->content !!}</div>
    </div>

    <a href="{{route('posts.edit', $post)}}" class="button button--edit">Edit</a>
@endsection
