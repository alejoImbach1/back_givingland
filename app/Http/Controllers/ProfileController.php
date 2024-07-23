<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(int $userId)
    {
        $user = User::find($userId);
        if(!$user){
            return response()->json(['error','perfil no encontrado'],404);
        }
        // Profile::with()
        $profile = $user->profile;
        return response()->json($profile);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $userId)
    {
        //
    }

}
