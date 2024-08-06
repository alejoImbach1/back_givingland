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
        if ($request->hasFile('image')) {
            $profile->update(['google_avatar' => false]);
            $imageToDelete = $profile->image;
            if (basename($imageToDelete->url) != 'default.svg') {
                Storage::delete('public/' . $imageToDelete->url);
            }
            $image = $request->file('image');
            $path = 'users_profile_images/' . '/image_' . Str::uuid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public', $path);
            $imageToDelete->update(['url' => $path]);
            return response()->json(['message' => 'se actualizó la foto de perfil']);
        }

        if ($request->has('social_media')) {
            $socialMedia = $request->social_media;
            if (!$socialMedia['store']) {
                $profile->socialMedia()->detach($socialMedia['id']);
                return response()->json(['message' => 'se eliminó la red social']);
            }
            $profile->socialMedia()->attach($socialMedia['id'], ['username' => $socialMedia['username']]);
            return response()->json(['message' => 'se creó la red social']);
        }
        return response(null, 400);
    }

    //para front laravel
    public function store(Request $request)
    {
        $profile = $request->user()->profile;
        $profile->update(['google_avatar' => false]);
        $imageToDelete = $profile->image;
        if (basename($imageToDelete->url) != 'default.svg') {
            Storage::delete('public/' . $imageToDelete->url);
        }
        $image = $request->file('image');
        $path = 'users_profile_images/' . '/image_' . Str::uuid() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public', $path);
        $imageToDelete->update(['url' => $path]);
        return response()->json(['message' => 'se actualizó la foto de perfil']);
    }

    public function deleteImage(Request $request)
    {
        $request->user()->profile->image->update(['url' => 'users_profile_images/default.svg']);
        return response()->json(['message' => 'se eliminó la foto de perfil']);
    }

    public function storeSocialMedia(Request $request)
    {
    }
}
