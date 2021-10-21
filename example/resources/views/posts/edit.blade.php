@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-5xl">Edit Post</h1>

        <form action="{{route('posts.update', $post)}}" method="POST">
            @method('PUT')
            @csrf
            <div>
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="{{$post->title}}">
            </div>
            <div>
                <label for="content">Content</label>
                <input name="content" id="content" type="text" value="{{$post->content}}"/>
            </div>
            <button>Submit</button>
        </form>
    </div>

@endsection

@section('scripts')
    <script>
        Laraberg.init('content')
    </script>
@endsection
