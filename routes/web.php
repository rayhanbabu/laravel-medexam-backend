<?php
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SpendController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\WebCustomize\NoticeController;
use App\Http\Controllers\WebCustomize\PageCategoryController;
use App\Http\Controllers\MemberAuth\MemberAuthController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

       Route::get('/', function () {
            return view('welcome');
       });


       Route::get('/forget_password', [ProfileController::class,'forget_password']);
       Route::post('/forget_password_send', [ProfileController::class,'forget_password_send']);
       Route::get('/reset_password/{token}', [ProfileController::class,'reset_password']);
       Route::post('/reset_password_update', [ProfileController::class,'reset_password_update']);
     

         Route::middleware('auth')->group(function () {
               Route::get('/admin/dashboard', [AdminController::class,'index']);
               Route::get('admin/logout', [AuthenticatedSessionController::class, 'destroy']);

               Route::get('/password_change', [ProfileController::class,'password_change']);
               Route::post('/password_update', [ProfileController::class,'password_update']); 
         });


         // Admin route access
         Route::middleware('SupperAdminMiddleware')->group(function (){
           


         });

          //Mixed Supperadmin & Admin route access
          Route::middleware('MixedMiddleware')->group(function (){
              //role Access
              Route::get('/admin/role_access', [AdminController::class,'role_access']);
              Route::get('/admin/role_access/manage', [AdminController::class,'role_access_manage']);
              Route::get('/admin/role_access/manage/{id}', [AdminController::class,'role_access_manage']);
              Route::post('/admin/role_access/insert', [AdminController::class,'role_access_insert']);
              Route::get('/admin/role_access/delete/{id}', [AdminController::class,'role_access_delete']);
          });


         // Admin route access
         Route::middleware('AdminMiddleware')->group(function (){

           

         });


            // Manager and Admin route access
         Route::middleware('ManagerMiddleware')->group(function (){


             // Course
           Route::get('/admin/course', [CourseController::class,'course']);
           Route::get('/admin/course/manage', [CourseController::class,'course_manage']);
           Route::get('/admin/course/manage/{id}', [CourseController::class,'course_manage']);
           Route::post('/admin/course/insert', [CourseController::class,'course_insert']);
           Route::get('/admin/course/delete/{id}', [CourseController::class,'course_delete']);


           // Spend Category
           Route::get('/admin/spendcategory', [SpendCategoryController::class,'spendcategory']);
           Route::get('/admin/spendcategory/manage', [SpendCategoryController::class,'spendcategory_manage']);
           Route::get('/admin/spendcategory/manage/{id}', [SpendCategoryController::class,'spendcategory_manage']);
           Route::post('/admin/spendcategory/insert', [SpendCategoryController::class,'spendcategory_insert']);
           Route::get('/admin/spendcategory/delete/{id}', [SpendCategoryController::class,'spendcategory_delete']);


            // Spend View
            Route::get('/admin/spend',[SpendController::class,'spend']);
            Route::get('/admin/spend/manage',[SpendController::class,'spend_manage']);
            Route::get('/admin/spend/manage/{id}',[SpendController::class,'spend_manage']);
            Route::post('/admin/spend/insert',[SpendController::class,'spend_insert']);
            Route::get('/admin/spend/delete/{id}',[SpendController::class,'spend_delete']);


         //Member 
         Route::get('/admin/member',[MemberController::class,'member']);
         Route::post('/admin/member/insert',[MemberController::class,'store']);
         Route::get('/admin/member_view/{id}',[MemberController::class,'edit']);
         Route::post('/admin/member/update',[MemberController::class,'update']);
         Route::delete('/admin/member/delete',[MemberController::class,'delete']);

      
            //website customize 
            
            //pagecategory 
            Route::get('/admin/pagecategory', [PageCategoryController::class,'pagecategory']);
            Route::get('/admin/pagecategory/manage', [PageCategoryController::class,'pagecategory_manage']);
            Route::get('/admin/pagecategory/manage/{id}', [PageCategoryController::class,'pagecategory_manage']);
            Route::post('/admin/pagecategory/insert', [PageCategoryController::class,'pagecategory_insert']);
            Route::get('/admin/pagecategory/delete/{id}', [PageCategoryController::class,'pagecategory_delete']);
        
            // Web Page
            Route::get('/admin/notice/{pagecategory_id}',[NoticeController::class,'notice']);
            Route::get('/admin/notice/manage/{pagecategory_id}',[NoticeController::class,'notice_manage']);
            Route::get('/admin/notice/manage/{pagecategory_id}/{id}',[NoticeController::class,'notice_manage']);
            Route::post('/admin/notice/insert', [NoticeController::class,'notice_insert']);
            Route::get('/admin/notice/delete/{id}', [NoticeController::class,'notice_delete']);

        
          
      });




          
      Route::get('/member/login',[MemberAuthController::class,'login'])->middleware('MemberTokenExist');
      Route::post('/member/login-insert',[MemberAuthController::class,'login_insert']);

      

      Route::middleware('MemberToken')->group(function(){ 
            Route::get('/member/logout',[MemberAuthController::class,'logout']);
            Route::get('/member/dashboard',[MemberAuthController::class,'dashboard']);
            Route::get('/member/credit',[MemberAuthController::class,'credit']);
            Route::get('/member/debit',[MemberAuthController::class,'debit']);

       });
        





  require __DIR__.'/auth.php';
