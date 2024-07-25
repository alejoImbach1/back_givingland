<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmailVerification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function generateCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);
        $email = $request->email;
        $plainCode = substr(str_shuffle('123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);
        $code = Hash::make($plainCode);
        $expires_at = Carbon::now()->addMinutes();

        EmailVerification::create(compact('email','code','expires_at'));
        return response()->json(compact('plainCode'));
    }

    public function verifyCode(Request $request)
    {
        $model = EmailVerification::where('email', $request->email) // Condición
        ->orderBy('id', 'desc') // Ordenar por 'id' en orden descendente
        ->first();
        // return response(null);
        $inputCode = implode("", $request->code);
        if(!$model){
            return response()->json(['error' => 'no se ha generado un código'],404);
        }
        if($model->expires_at <= Carbon::now()){
            return response()->json(['error' => 'el código ha expirado'],401);
        }

        if(!Hash::check($inputCode,$model->code)){
            return response()->json(['error' => 'no coincide el correo electrónico con el código'],401);
        }



    }
}
