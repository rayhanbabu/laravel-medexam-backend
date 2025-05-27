<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberAuth\MemberAuthController;
use App\Http\Controllers\MemberAuth\CourseUserController;
use App\Http\Controllers\MemberAuth\CourseDetailController;

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

  Route::post('/member/registration',[MemberAuthController::class,'registration']);  

  Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
      return $request->user();
  });


  Route::post('/member/login',[MemberAuthController::class,'login_insert']);

  Route::get('/course-list',[CourseUserController::class,'course_list']);
  Route::get('/subscription-list',[CourseUserController::class,'subscription_list']);
  
    Route::middleware('MemberToken')->group(function(){ 
        Route::get('/member/logout',[MemberAuthController::class,'logout']);
        Route::get('/member/profile',[MemberAuthController::class,'profile']);

        Route::post('/course-enrollment',[CourseUserController::class,'course_enrollment']);
        Route::get('/course-enrollment-list',[CourseUserController::class,'course_enrollment_list']);
        Route::get('/invoice-list',[CourseUserController::class,'invoice_list']);
 
 
          Route::middleware('CourseAccess:{course_id}')->group(function(){ 
             // Course Details
             Route::get('/{course_id}/course-detail',[CourseDetailController::class,'course_detail']);
             Route::get('/{course_id}/question-number/{sub_sub_category_id}',[CourseDetailController::class,'question_number']);
         });


    });