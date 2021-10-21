<?php
/**
 * @var \Illuminate\Support\Collection|\App\Models\Post[]
 */
?>

@extends('layouts.app')

@section('content')
    <h1>Posts Index</h1>

    @foreach($posts as $post)
        <div>
            <h2>{{$post->title}}</h2>
            <a href="{{route('posts.show', $post)}}">Show</a>
            <a href="{{route('posts.edit', $post)}}">Edit</a>
        </div>
    @endforeach
@endsection
