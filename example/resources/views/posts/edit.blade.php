@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-5xl">Edit Post</h2>

        <form action="{{route('posts.update', $post)}}" method="POST">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                @error('title')
                    <div class="validation--error">{{$message}}</div>
                @enderror
                <input type="text" id="title" name="title" value="{{$post->title}}">
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                @error('content')
                    <div class="validation--error">{{$message}}</div>
                @enderror
                <input name="content" id="content" type="text" value="{{$post->content}}"/>
            </div>
            <button type="submit" class="button">Save</button>
        </form>
    </div>

@endsection
