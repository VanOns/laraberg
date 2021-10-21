@extends('layouts.app')

@section('content')
    <h1>Show Post</h1>
    <h2>{{$post->title}}</h2>
    <div>{{$post->content}}</div>
@endsection
