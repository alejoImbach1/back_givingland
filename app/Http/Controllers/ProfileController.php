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
    public function show(int $profileId)
    {
        $profile = Profile::included()->find($profileId);
        if(!$profile){
            return response()->json(['error','perfil no encontrado'],404);
        }
        // Profile::with()
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
