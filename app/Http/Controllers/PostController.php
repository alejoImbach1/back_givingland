<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('images')->get();
        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Post::create([$request->except('images')]);
        return response()->json(['message' => 'se creó la publicación'],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $postId)
    {
        $post = Post::with('images')->find($postId);
        if(!$post){
            return response()->json(['error' => 'la publicación no se encuentra'],404);
        }
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $postId)
    {
        $post = Post::find($postId);
        if(!$post){
            return response()->json(['error' => 'la publicación no se encuentra'],404);
        }
        $post->update($request->all());
        return response()->json(['message' => 'se actualizó la publicación']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $postId)
    {
        if(!Post::destroy($postId)){
            return response()->json(['error' => 'la publicación no se encuentra'],404);
        };
        return response()->json(['message' => 'Se eliminó la publicación']);
    }
}
