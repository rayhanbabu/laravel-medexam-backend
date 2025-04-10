<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Subsubcategory;
use App\Models\Subcategory;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\validator;

class SubsubcategoryController extends Controller
{
    public function index(Request $request){
         $user=user_info();
         $course=Course::where('course_status',1)->orderBy('id','desc')->get();
         $category=Category::where('category_status',1)->orderBy('id','desc')->get();
         $subcategory=Subcategory::where('sub_category_status',1)->orderBy('id','desc')->get();


         if(isset($_GET['course_id']) && $_GET['category_id'] !='' && $_GET['sub_category_id'] !=''){
              $course_id=Course::where('id',$_GET['course_id'])->first();  
              $category_id=Category::where('id',$_GET['category_id'])->first();
              $sub_category_id=Subcategory::where('id',$_GET['sub_category_id'])->first();  
          }else{
              $course_id='';  
              $category_id='';
              $sub_category_id='';
          }
          return view('admin.subsubcategory',['course'=>$course,'course_id'=>$course_id,'category_id'=>$category_id,
          'category'=>$category,'subcategory'=>$subcategory,'sub_category_id'=>$sub_category_id]); 
      }


       public function category_fetch(Request $request){
          $data =Category::where('course_id',$request->course_id)->get();
            if(count($data) > 0) {
               return response()->json($data);
            }
        }


        public function subcategory_fetch(Request $request){
          $data =Subcategory::where('category_id',$request->category_id)->get();
            if(count($data) > 0) {
               return response()->json($data);
            }
        }



    public function fetch(Request $request,$course_id,$category_id,$sub_category_id){
         $data=Subsubcategory::where('course_id',$course_id)->where('category_id',$category_id)
         ->where('sub_category_id',$sub_category_id)->orderBy('id','desc')->paginate(15);
         return view('admin.subsubcategory_data',compact('data'));
     }


     public function store(Request $request){
         $user=user_info();
         $validator=\Validator::make($request->all(),[  
             'course_id' => 'required',
             'category_id' => 'required',
             'sub_category_id' => 'required',
             'sub_sub_category_name' => 'required',
           ],
       );
     
    if($validator->fails()){
           return response()->json([
             'status'=>400,
             'validate_err'=>$validator->messages(),
          ]);
      }else{
             $app= new Subsubcategory;
             $app->sub_sub_category_name=$request->input('sub_sub_category_name');
             $app->category_id=$request->input('category_id');
             $app->sub_category_id=$request->input('sub_category_id');
             $app->course_id=$request->input('course_id');
             $app->sub_sub_category_status=$request->input('sub_sub_category_status');
             $app->created_by=$user->id;
             $app->save();
                return response()->json([
                   'status'=>200,  
                   'message'=>'Inserted Data Successfully',
                ]);
          }
     }


       public function edit($id){
           $edit_value=Subsubcategory::find($id);
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
          'sub_sub_category_name' => 'required',
       ]);

     if($validator->fails()){
       return response()->json([
         'status'=>400,
         'validate_err'=>$validator->messages(),
      ]);
     }else{
           $app=Subsubcategory::find($id);
           if($app){
             $app->sub_sub_category_name=$request->input('sub_sub_category_name');
             $app->Sub_sub_category_status=$request->input('sub_sub_category_status');
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
           $post = Subsubcategory::find($id);  
           $post->delete();
              return response()->json([
                  'status'=>200,  
                   'message'=>'Data Deleted Successfully',
                ]);
      }
   


   function fetch_data(Request $request,$course_id,$category_id,$sub_category_id)
   {
    if($request->ajax())
    {
          $sort_by = $request->get('sortby');
          $sort_type = $request->get('sorttype'); 
              $search = $request->get('search');
              $search = str_replace(" ", "%", $search);
            $data = Subsubcategory::where('course_id',$course_id)->where('category_id',$category_id)
                    ->where('sub_category_id',$sub_category_id)
                    ->where(function($query) use ($search) {
                    $query->orwhere('sub_sub_category_name', 'like', '%'.$search.'%');
                    $query->orWhere('sub_sub_category_status', 'like', '%'.$search.'%');
                    })
                    ->orderBy($sort_by, $sort_type)
                    ->paginate(15);
                    return view('admin.subsubcategory_data', compact('data'))->render();                 
           }
      }



}
