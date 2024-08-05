<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $profile = Profile::included()->find($id);
        if (!$profile) {
            return response()->json(['error', 'perfil no encontrado'], 404);
        }
        // Profile::with()
        return response()->json($profile);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $profile = $request->user()->profile;
        $imageToDelete = $profile->image;
        if (basename($imageToDelete->url) != 'default.svg') {
            Storage::delete('public/' . $imageToDelete->url);
        }
        $profile->update(['google_avatar' => false]);
        if (!$request->hasFile('image')) {
            $profile->image->update(['url' => 'users_profile_images/default.svg']);
            return response()->json(['message' => 'se eliminó la foto de perfil']);
        }
        $imageToDelete->delete();

        $image = $request->file('image');
        $path = 'users_profile_images/' . '/image_' . Str::uuid() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public', $path);
        $profile->image()->create(['url' => $path]);
        return response()->json(['message' => 'se actualizó la foto de perfil']);
    }

    //para front laravel
    public function store(Request $request)
    {
        $profile = $request->user()->profile;
        $imageToDelete = $profile->image;
        if (basename($imageToDelete->url) != 'default.svg') {
            Storage::delete('public/' . $imageToDelete->url);
        }
        $profile->update(['google_avatar' => false]);
        if (!$request->hasFile('image')) {
            $profile->image->update(['url' => 'users_profile_images/default.svg']);
            return response()->json(['message' => 'se eliminó la foto de perfil']);
        }
        $imageToDelete->delete();

        $image = $request->file('image');
        $path = 'users_profile_images/' . '/image_' . Str::uuid() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public', $path);
        $profile->image()->create(['url' => $path]);
        return response()->json(['message' => 'se actualizó la foto de perfil']);
    }
}
