<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', [
            'settings' => $this->settings(),
            'posts' => Post::published()->paginate(9),
        ]);
    }

    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)->published()->firstOrFail();

        return view('posts.show', [
            'settings' => $this->settings(),
            'post' => $post,
            'recent' => Post::published()->where('id', '!=', $post->id)->take(3)->get(),
        ]);
    }
}
