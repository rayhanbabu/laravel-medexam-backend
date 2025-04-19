<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Subscription;
use App\Models\Course;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\validator;

class SubscriptionController extends Controller
{
    public function index(Request $request){
         $user=user_info();
         $course=Course::where('course_status',1)
           ->orderBy('id','desc')->get();
         if(isset($_GET['course_id'])){
              $course_id=Course::where('id',$_GET['course_id'])->first();  
          }else{
              $course_id='';  
          }
          return view('admin.subscription',['course'=>$course, 'course_id'=>$course_id]); 
      }



    public function fetch(Request $request,$course_id){
         $data=Subscription::where('course_id',$course_id)->orderBy('id','desc')->paginate(15);
         return view('admin.subscription_data',compact('data'));
     }


     public function store(Request $request){
         $user=user_info();
         $validator=\Validator::make($request->all(),[  
             'course_id' => 'required',
             'subscription_name' => 'required',
           ],
       );
     
    if($validator->fails()){
           return response()->json([
             'status'=>400,
             'validate_err'=>$validator->messages(),
          ]);
      }else{
             $app= new Subscription;
             $app->subscription_name=$request->input('subscription_name');
             $app->course_id=$request->input('course_id'); 
             $app->amount=$request->input('amount');
             $app->subscription_status=$request->input('subscription_status');
             $app->subscription_month=$request->input('subscription_month');
             $app->created_by=$user->id;
             $app->save();
                return response()->json([
                   'status'=>200,  
                   'message'=>'Inserted Data Successfully',
                ]);
          }
     }


       public function edit($id){
           $edit_value=Subscription::find($id);
           if($edit_value){
              return response()->json([
                   'status'=>200,  
                   'edit_value'=>$edit_value,
                 ]);
            }else{
                return response()->json([
                   'status'=>404,  
                   'message'=>'Student not found',
                 ]);
            }
    }


    public function update(Request $request, $id){

      $validator=\Validator::make($request->all(),[       
          'subscription_name' => 'required',
       ]);

     if($validator->fails()){
       return response()->json([
         'status'=>400,
         'validate_err'=>$validator->messages(),
      ]);
     }else{
           $app=Subscription::find($id);
           if($app){
             $app->subscription_name=$request->input('subscription_name');
             $app->amount=$request->input('amount');
             $app->subscription_status=$request->input('subscription_status');
             $app->subscription_month=$request->input('subscription_month');
             $app->update();   
             return response()->json([
                 'status'=>200,
                 'message'=>'Data Updated Successfully',
              ]);
            }else{
               return response()->json([
                   'status'=>404,  
                   'message'=>'Student not found',
                 ]);
           }

        }
    }  


     public function destroy($id){
           $post = Subscription::find($id);  
           $post->delete();
              return response()->json([
                  'status'=>200,  
                   'message'=>'Data Deleted Successfully',
                ]);
      }
   


   function fetch_data(Request $request,$course_id)
   {
    if($request->ajax())
    {

  
     $sort_by = $request->get('sortby');
     $sort_type = $request->get('sorttype'); 
           $search = $request->get('search');
           $search = str_replace(" ", "%", $search);
     $data = Subscription::where('course_id',$course_id)               
             ->where(function($query) use ($search) {
                 $query->orwhere('subscription_name', 'like', '%'.$search.'%');
                 $query->orWhere('subscription_status', 'like', '%'.$search.'%');
                 })
                   ->orderBy($sort_by, $sort_type)
                   ->paginate(15);
                   return view('admin.subscription_data', compact('data'))->render();
                  
    }
   }

}
