<?php

namespace App\Http\Controllers\MemberAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Exception;
use App\Models\Member;
use App\Models\Course;
use App\Models\CourseUser;
use App\Models\Subscription;
use App\Models\Invoice;
use App\Models\Question;

class CourseDetailController extends Controller
{

        public function course_detail(Request $request){
              $course_id = $request->course_id;
              $member_id = $request->header('member_id');
              $data = Course::with('category')->with('subcategory')->with('subsubcategory')->where('id',$course_id)->first();        
                  return response()->json([
                        'data' => $data,
                   ],200);
         }



         public function question_number(Request $request){
              $course_id = $request->course_id;
              $sub_sub_category_id = $request->sub_sub_category_id;
              $member_id = $request->header('member_id');
              $data = Question::where('sub_sub_category_id',$sub_sub_category_id)->count();        
                return response()->json([
                      'data' => $data,
                 ],200);
          }

   

     

    


   


}
