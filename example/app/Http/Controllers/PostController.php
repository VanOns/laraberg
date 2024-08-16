<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string'],
            'slug' => ['string'],
            'content' => ['string'],
        ]);

        $post = Post::create([
            ...$data,
            'slug' => Str::slug($data['title']),
        ]);

        return redirect(
            route('posts.show', compact('post'))
        );
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => ['string'],
            'slug' => ['string'],
            'content' => ['string'],
        ]);

        $post->update($data);

        return redirect(
            route('posts.show', $post)
        );
    }
}
