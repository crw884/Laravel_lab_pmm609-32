<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('posts', [
            'posts' => Post::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::all()->where('id', $id)->first();
        $rating = $post->rates()->avg('rate');

        return view('post', [
            'post' => $post,
            'comments' => Comment::all()->where('post_id', $id),
            'rating' => $rating,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function getImage(string $id)
    {
        $post = Post::findOrFail($id);

        if (!$post->image) {
            return null;
        }

        return response($post->image);
    }

    public function getAudio(string $id)
    {
        $post = Post::findOrFail($id);

        if (!$post->audio) {
            return null;
        }

        return response($post->audio);
    }
}
