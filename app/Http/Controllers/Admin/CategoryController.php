<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\validator;

class CategoryController extends Controller
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
          return view('admin.category',['course'=>$course, 'course_id'=>$course_id]); 
      }



    public function fetch(Request $request,$course_id){
         $data=Category::where('course_id',$course_id)->orderBy('id','desc')->paginate(15);
         return view('admin.category_data',compact('data'));
     }


     public function store(Request $request){
         $user=user_info();
         $validator=\Validator::make($request->all(),[  
             'course_id' => 'required',
             'category_name' => 'required',
           ],
       );
     
    if($validator->fails()){
           return response()->json([
             'status'=>400,
             'validate_err'=>$validator->messages(),
          ]);
      }else{
             $app= new Category;
             $app->category_name=$request->input('category_name');
             $app->course_id=$request->input('course_id');
             $app->category_status=$request->input('category_status');
             $app->created_by=$user->id;
             $app->save();
                return response()->json([
                   'status'=>200,  
                   'message'=>'Inserted Data Successfully',
                ]);
          }
     }


       public function edit($id){
           $edit_value=Category::find($id);
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
          'category_name' => 'required',
       ]);

     if($validator->fails()){
       return response()->json([
         'status'=>400,
         'validate_err'=>$validator->messages(),
      ]);
     }else{
           $app=Category::find($id);
           if($app){
             $app->category_name=$request->input('category_name');
             $app->category_status=$request->input('category_status');
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
           $post = Category::find($id);  
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
     $data = Category::where('course_id',$course_id)               
             ->where(function($query) use ($search) {
                 $query->orwhere('category_name', 'like', '%'.$search.'%');
                 $query->orWhere('category_status', 'like', '%'.$search.'%');
                 })
                   ->orderBy($sort_by, $sort_type)
                   ->paginate(15);
                   return view('admin.category_data', compact('data'))->render();
                  
    }
   }

}
