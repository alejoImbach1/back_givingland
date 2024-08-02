<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::get('/logout',[AuthController::class,'logout']);
    
    Route::apiSingleton('profile',ProfileController::class)->only('update');
});
Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [AuthController::class, 'register']);

// Route::post('/email-code', [RegisterController::class, 'generateCode']);

// Route::post('/verify-email-code',[RegisterController::class,'verifyCode']);

// Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource('profiles', ProfileController::class)->only('show')->parameter('profiles','user');

Route::apiResource('posts',PostController::class);


Route::get('/profile-image/{profile}',function ($profileId){
    // $path = env('app_url') . ;
    $profile = Profile::find($profileId);
    if(!$profile){
        return response(null,404);
    }
    return response()->json($profile->getImageUrl());
});

Route::get('/p',function(){
    return response()->json('hello');
});

