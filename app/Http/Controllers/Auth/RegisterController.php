<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function generateToken(Request $request)
    {
        $email = $request->email;
        $token = bin2hex(random_bytes(16));
        DB::table('email_verification')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'expires_at' => Carbon::now()->addMinutes(),
            'created_at' => now()
        ]);
        return response()->json(compact('email','token'));
    }
}
