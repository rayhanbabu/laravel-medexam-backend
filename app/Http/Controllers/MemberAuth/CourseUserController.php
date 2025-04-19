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




class CourseUserController extends Controller
{

  

      public function course_list(Request $request){
             $data = Course::where('course_status',1)->orderBy('serial','asc')->get();        
                return response()->json([
                  'data' => $data,
                ],200);
         }

         public function subscription_list(Request $request){
               $data = Subscription::where('subscription_status',1)->orderBy('serial','asc')->get();          
                return response()->json([
                  'data' => $data,
                ],200);
           }

        public function course_enrollment_list(Request $request){
            $member_id = $request->header('member_id');
            $data = CourseUser::with('course')->where('user_id',$member_id)->orderBy('id','desc')->get();
           
               return response()->json([
                 'data' => $data,
               ],200);
         }


     public function course_enrollment(Request $request){   
         DB::beginTransaction();
          try {

             $member_id = $request->header('member_id');  
             $validator=\Validator::make($request->all(),[  
                'course_id' => 'required|integer|exists:courses,id',
                'subscription_id' => 'required|integer|exists:subscriptions,id',
              ],
            );

             if($validator->fails()){
                     return response()->json([
                        'validate_err'=>$validator->messages(),
                    ],400);
              }

             $course_id = $request->input('course_id');
             $subscription_id = $request->input('subscription_id');
             $subscription = Subscription::where('id',$subscription_id)->first();

             $course = CourseUser::where('course_id',$course_id)->where('user_id',$member_id)->first();

             $start = now();
             $end = now()->addMonths($subscription->subscription_month);

             if($course){
                 return response()->json([
                     'message' => "Already Enrolled in this Course",
                 ],400);
              }
            
             $model =new CourseUser;
             $model->course_id = $course_id;
             $model->user_id = $member_id;
             $model->access_expired_date = $end;
             $model->purchase_date = $start;
             $model->status = 0;
             $model->created_by = $member_id;
             $model->save();


                $invoice=new Invoice;
                $invoice->tran_id = Str::random(10);
                $invoice->user_id = $member_id;
                $invoice->courseuser_id = $model->id;
                $invoice->subscription_id = $subscription_id;
                $invoice->amount = $subscription->amount;
                $invoice->discount = 0;
                $invoice->total_amount = $subscription->amount;
                $invoice->access_expired_date = $end;
                $invoice->start_date = $start;
                $invoice->invoice_date = now();
                $invoice->billing_cycle = $subscription->subscription_month;
                $invoice->payment_status =0;
                $invoice->save();

                DB::commit();
           
               return response()->json([
                     'message' => "Course Enrolled Successfully",
                ],200);


            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    'message' => 'Failed to update agent',
                    'error' => $e->getMessage(),
                ], 500);
            }
        }



        public function invoice_list(Request $request){
            $member_id = $request->header('member_id');
            $data = Invoice::with('subscription')->with('course')->where('user_id',$member_id)->orderBy('id','desc')->get();
           
               return response()->json([
                 'data' => $data,
               ],200);
       
      }
     




}
