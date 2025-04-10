<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Subcategory;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\validator;

class SubcategoryController extends Controller
{
    public function index(Request $request){
         $user=user_info();
         $course=Course::where('course_status',1)->orderBy('id','desc')->get();
         $category=Category::where('category_status',1)->orderBy('id','desc')->get();
         if(isset($_GET['course_id']) && $_GET['category_id'] !=''){
              $course_id=Course::where('id',$_GET['course_id'])->first();  
              $category_id=Category::where('id',$_GET['category_id'])->first();  
          }else{
              $course_id='';  
              $category_id='';
          }
          return view('admin.subcategory',['course'=>$course,'course_id'=>$course_id,'category_id'=>$category_id,'category'=>$category]); 
      }


       public function category_fetch(Request $request){
          $data =Category::where('course_id',$request->course_id)->get();
            if(count($data) > 0) {
               return response()->json($data);
            }
        }



    public function fetch(Request $request,$course_id,$category_id){
         $data=Subcategory::where('course_id',$course_id)->where('category_id',$category_id)->orderBy('id','desc')->paginate(15);
         return view('admin.Subcategory_data',compact('data'));
     }


     public function store(Request $request){
         $user=user_info();
         $validator=\Validator::make($request->all(),[  
             'course_id' => 'required',
             'category_id' => 'required',
             'sub_category_name' => 'required',
           ],
       );
     
    if($validator->fails()){
           return response()->json([
             'status'=>400,
             'validate_err'=>$validator->messages(),
          ]);
      }else{
             $app= new Subcategory;
             $app->sub_category_name=$request->input('sub_category_name');
             $app->category_id=$request->input('category_id');
             $app->course_id=$request->input('course_id');
             $app->sub_category_status=$request->input('sub_category_status');
             $app->created_by=$user->id;
             $app->save();
                return response()->json([
                   'status'=>200,  
                   'message'=>'Inserted Data Successfully',
                ]);
          }
     }


       public function edit($id){
           $edit_value=Subcategory::find($id);
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
          'sub_category_name' => 'required',
       ]);

     if($validator->fails()){
       return response()->json([
         'status'=>400,
         'validate_err'=>$validator->messages(),
      ]);
     }else{
           $app=Subcategory::find($id);
           if($app){
             $app->sub_category_name=$request->input('sub_category_name');
             $app->Sub_category_status=$request->input('sub_category_status');
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
           $post = Subcategory::find($id);  
           $post->delete();
              return response()->json([
                  'status'=>200,  
                   'message'=>'Data Deleted Successfully',
                ]);
      }
   


   function fetch_data(Request $request,$course_id,$category_id)
   {
    if($request->ajax())
    {
          $sort_by = $request->get('sortby');
          $sort_type = $request->get('sorttype'); 
              $search = $request->get('search');
              $search = str_replace(" ", "%", $search);
          $data = Subcategory::where('course_id',$course_id)->where('category_id',$category_id)
                            
               ->where(function($query) use ($search) {
                   $query->orwhere('sub_category_name', 'like', '%'.$search.'%');
                   $query->orWhere('sub_category_status', 'like', '%'.$search.'%');
                  })
                   ->orderBy($sort_by, $sort_type)
                   ->paginate(15);
                   return view('admin.subcategory_data', compact('data'))->render();                 
         }
      }



}
