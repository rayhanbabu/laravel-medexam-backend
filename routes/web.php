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
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\SubsubcategoryController;
use App\Http\Controllers\Admin\QuestionController;




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


           //admin category
           Route::get('/admin/category',[CategoryController::class,'index']);
           Route::get('/admin/category_fetch/{course_id}',[CategoryController::class,'fetch']);
           Route::get('/admin/category/fetch_data/{course_id}',[CategoryController::class,'fetch_data']);
           Route::post('admin/category_insert',[CategoryController::class,'store']);
           Route::get('/admin/category_edit/{id}',[CategoryController::class,'edit']);
           Route::post('/admin/category_update/{id}',[CategoryController::class,'update']);
           Route::delete('/admin/category_delete/{id}',[CategoryController::class,'destroy']);


             //admin sub_category
             Route::get('/category-fetch',[SubcategoryController::class,'category_fetch']); 

             Route::get('/admin/sub_category',[SubcategoryController::class,'index']);
             Route::get('/admin/sub_category_fetch/{course_id}/{category_id}',[SubcategoryController::class,'fetch']);
             Route::get('/admin/sub_category/fetch_data/{course_id}/{category_id}',[SubcategoryController::class,'fetch_data']);
             Route::post('admin/sub_category_insert',[SubcategoryController::class,'store']);
             Route::get('/admin/sub_category_edit/{id}',[SubcategoryController::class,'edit']);
             Route::post('/admin/sub_category_update/{id}',[SubcategoryController::class,'update']);
             Route::delete('/admin/sub_category_delete/{id}',[SubcategoryController::class,'destroy']);


             //admin sub_sub_category
             Route::get('/category-fetch',[SubsubcategoryController::class,'category_fetch']); 
             Route::get('/subcategory-fetch',[SubsubcategoryController::class,'subcategory_fetch']);

             Route::get('/admin/sub_sub_category',[SubsubcategoryController::class,'index']);
             Route::get('/admin/sub_sub_category_fetch/{course_id}/{category_id}/{sub_category_id}',[SubsubcategoryController::class,'fetch']);
             Route::get('/admin/sub_sub_category/fetch_data/{course_id}/{category_id}/{sub_category_id}',[SubsubcategoryController::class,'fetch_data']);
             Route::post('admin/sub_sub_category_insert',[SubsubcategoryController::class,'store']);
             Route::get('/admin/sub_sub_category_edit/{id}',[SubsubcategoryController::class,'edit']);
             Route::post('/admin/sub_sub_category_update/{id}',[SubsubcategoryController::class,'update']);
             Route::delete('/admin/sub_sub_category_delete/{id}',[SubsubcategoryController::class,'destroy']);


           //admin question
           Route::get('/category-fetch',[QuestionController::class,'category_fetch']); 
           Route::get('/subcategory-fetch',[QuestionController::class,'subcategory_fetch']);
           Route::get('/subsubcategory-fetch',[QuestionController::class,'subsubcategory_fetch']);

           Route::get('/admin/question',[QuestionController::class,'index']);
           Route::get('/admin/question_fetch/{course_id}/{category_id}/{sub_category_id}/{sub_sub_category_id}',[QuestionController::class,'fetch']);
           Route::get('/admin/question/fetch_data/{course_id}/{category_id}/{sub_category_id}/{sub_sub_category_id}',[QuestionController::class,'fetch_data']);
           Route::post('admin/question_insert',[QuestionController::class,'store']);
           Route::get('/admin/question_edit/{id}',[QuestionController::class,'edit']);
           Route::post('/admin/question_update/{id}',[QuestionController::class,'update']);
           Route::delete('/admin/question_delete/{id}',[QuestionController::class,'destroy']);

           Route::post('/admin/question_import',[QuestionController::class,'question_import']);


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




          
    


      

        





  require __DIR__.'/auth.php';
