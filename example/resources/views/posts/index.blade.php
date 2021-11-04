<?php
/**
 * @var \Illuminate\Support\Collection|\App\Models\Post[]
 */
?>

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Posts</h2>

        @foreach($posts as $post)
            <div class="post-item">
                <h3 class="post-item__title">{{$post->title}}</h3>
                <div>
                    <a href="{{route('posts.show', $post)}}" class="button">Read</a>
                </div>
            </div>
        @endforeach
    </div>

@endsection
