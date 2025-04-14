<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberAuth\MemberAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


  Route::post('/member/login',[MemberAuthController::class,'login_insert']);

  
  Route::middleware('MemberToken')->group(function(){ 
    Route::get('/member/logout',[MemberAuthController::class,'logout']);
    Route::get('/member/profile',[MemberAuthController::class,'profile']);
 
});