@php
/**
 * @var \App\Models\Post $post
 */
@endphp

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>{{$post->title}}</h2>
        <div>{!! $post->render() !!}</div>
    </div>

    <a href="{{route('posts.edit', $post)}}" class="button--primary button--edit">Edit</a>
@endsection
