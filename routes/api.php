<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordResetController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// public route
// Route::post('/post_url',[UserController::class, 'post_url']);
Route::post('/register',[UserController::class, 'register']);
Route::post('/login',[UserController::class,'login']);
Route::post('/send_password_reset',[PasswordResetController::class,'send_password_reset']);
Route::post('/password_reset/{token}',[PasswordResetController::class,'reset']);
Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout',[UserController::class,'logout']);
    Route::get('/logged_user',[UserController::class,'logged_user']);
    Route::post('/change_pass',[UserController::class,'change_pass']);
    Route::post('/delete/{id}',[UserController::class,'delete']);
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
