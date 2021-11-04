@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-5xl">Edit Post</h2>

        <form action="{{route('posts.update', $post)}}" method="POST">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="{{$post->title}}">
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <input name="content" id="content" type="text" value="{{$post->content}}"/>
            </div>
            <button type="submit" class="button">Save</button>
        </form>
    </div>

@endsection

@push('scripts')
    <script>
        Laraberg.init('content')
    </script>
@endpush
