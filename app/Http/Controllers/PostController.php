<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */

    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum', only: ['store','destroy']),
        ];
    }

    public function index()
    {
        return response()->json(Post::included()->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate( [
            'images' => 'required|array|max:5'
        ]);

        $validator = Validator::make($request->except('images'), [
            'name' => 'required|max:100|regex:/^[\p{L}\p{N}\sñÑáéíóúÁÉÍÓÚüÜ.,:;-_()]+$/u',
            'purpose' => 'required',
            'expected_item' => 'exclude_unless:purpose,intercambio|required|max:100|regex:/^[\p{L}\p{N}\sñÑáéíóúÁÉÍÓÚüÜ.,:;-_()]+$/u',
            'description' => 'required|max:255|regex:/^[\p{L}\p{N}\sñÑáéíóúÁÉÍÓÚüÜ.,:;-_()]+$/u',
            'location_id' => 'required',
            'category_id' => 'required'
        ])->validate();
        $post = $request->user()->posts()->create($validator);
        $images = $request->images;
        foreach ($images as $image) {
            $path = 'posts_images/' . $request->user()->username . '/image_' . Str::uuid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public', $path);
            $post->images()->create(['url' => $path]);
        }
        return response()->json(['message' => 'se creó la publicación'],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $postId)
    {
        $post = Post::with('images')->find($postId);
        if (!$post) {
            return response()->json(['error' => 'la publicación no se encuentra'], 404);
        }
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $postId)
    {
        $post = Post::find($postId);
        if (!$post) {
            return response()->json(['error' => 'la publicación no se encuentra'], 404);
        }
        $post->update($request->all());
        return response()->json(['message' => 'se actualizó la publicación']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,string $postId)
    {
        $post = $request->user()->posts()->find($postId);
        if (!$post) {
            return response()->json(['error' => 'la publicación no se encuentra'], 404);
        };
        $post->delete();
        return response()->json(['message' => 'Se eliminó la publicación']);
    }
}
