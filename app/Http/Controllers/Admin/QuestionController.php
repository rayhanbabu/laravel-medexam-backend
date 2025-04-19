<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Subsubcategory;
use App\Models\Subcategory;
use App\Models\Category;
use App\Models\Course;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\Exception;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\QuestionImport;


class QuestionController extends Controller
{
    public function index(Request $request){
         $user=user_info();
         $course=Course::where('course_status',1)->orderBy('id','desc')->get();
         $category=Category::where('category_status',1)->orderBy('id','desc')->get();
         $subcategory=Subcategory::where('sub_category_status',1)->orderBy('id','desc')->get();
         $subsubcategory=Subsubcategory::where('sub_sub_category_status',1)->orderBy('id','desc')->get();


         if(isset($_GET['course_id']) && $_GET['category_id'] !='' && $_GET['sub_category_id'] !='' && $_GET['sub_sub_category_id'] !=''){
              $course_id=Course::where('id',$_GET['course_id'])->first();  
              $category_id=Category::where('id',$_GET['category_id'])->first();
              $sub_category_id=Subcategory::where('id',$_GET['sub_category_id'])->first();
              $sub_sub_category_id=Subsubcategory::where('id',$_GET['sub_sub_category_id'])->first();  
          }else{
              $course_id='';  
              $category_id='';
              $sub_category_id='';
              $sub_sub_category_id='';
          }
          return view('admin.Question',['course'=>$course,'course_id'=>$course_id,'category_id'=>$category_id,
          'category'=>$category,'subcategory'=>$subcategory,'sub_category_id'=>$sub_category_id
          ,'subsubcategory'=>$subsubcategory,'sub_sub_category_id'=>$sub_sub_category_id]); 
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


      public function subsubcategory_fetch(Request $request){
          $data =Subsubcategory::where('sub_category_id',$request->sub_category_id)->get();
            if(count($data) > 0) {
               return response()->json($data);
            }
      }



    public function fetch(Request $request,$course_id,$category_id,$sub_category_id,$sub_sub_category_id){
         $data=Question::with('options')->where('course_id',$course_id)->where('category_id',$category_id)
         ->where('sub_category_id',$sub_category_id)->where('sub_sub_category_id',$sub_sub_category_id)->orderBy('id','desc')->paginate(15);
         return view('admin.question_data',compact('data'));
     }


     public function store(Request $request){

      DB::beginTransaction();
      try {
         $user=user_info();
         $validator=\Validator::make($request->all(),[  
             'course_id' => 'required',
             'category_id' => 'required',
             'sub_category_id' => 'required',
             'sub_sub_category_id' => 'required',
             'title' => 'required',
           ],
       );

    
       if($validator->fails()){
             return response()->json([
                'status'=>400,
                'validate_err'=>$validator->messages(),
             ]);
          }

          $option=$request->input('option');
          $is_correct=$request->input('is_correct');

             $app= new Question;
             $app->title=$request->input('title');
             $app->category_id=$request->input('category_id');
             $app->sub_category_id=$request->input('sub_category_id');
             $app->sub_sub_category_id=$request->input('sub_sub_category_id');
             $app->course_id=$request->input('course_id');
             $app->created_by=$user->id;
             $app->save();

             if($option){
              foreach($option as $key => $value){
                  $option= new Option;
                  $option->question_id=$app->id;
                  $option->option=$value;
                  $option->is_correct=$is_correct[$key];
                  $option->created_by=$user->id;
                  $option->save();
                 
              }
            }

            DB::commit();

            return response()->json([
                'status'=>200,  
                'message'=>'Inserted Data Successfully',
             ]);

         } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Failed to update agent',
                'error' => $e->getMessage(),
            ], 500);
        }
          
     }


       public function edit($id){
           $edit_value=Question::with('options')->find($id);
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

      DB::beginTransaction();
      try {
      $user=user_info();
      $validator=\Validator::make($request->all(),[       
          'title' => 'required',
          'image' => 'image|mimes:jpeg,png,jpg|max:500',
       ]);

     if($validator->fails()){
       return response()->json([
         'status'=>400,
         'validate_err'=>$validator->messages(),
      ]);
     }
           $app=Question::find($id);
           if($app){
             $app->title=$request->input('title');
             if ($request->hasfile('image')) {
                       $imgfile = 'booking-';
                       $path = public_path('uploads/admin') . '/' . $app->image;
                       if (File::exists($path)) {
                          File::delete($path);
                        }
                       $image = $request->file('image');
                       $new_name = $imgfile . rand() . '.' . $image->getClientOriginalExtension();
                       $image->move(public_path('uploads/admin'), $new_name);
                       $app->image = $new_name;
                 }
             $app->update();   

             $option=$request->input('option');
             $is_correct=$request->input('is_correct');
             $option_id=$request->input('option_id');

              if($option){
                foreach($option as $key => $value){
                    if(isset($option_id[$key])){
                        $option= Option::find($option_id[$key]);
                        $option->question_id=$app->id;
                        $option->option=$value;
                        $option->is_correct=$is_correct[$key];
                        $option->updated_by=$user->id;
                        $option->update();
                    }
                }


               DB::commit(); 
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

      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
            'message' => 'Failed to update agent',
            'error' => $e->getMessage(),
        ], 500);
    }

    }  


     public function destroy($id){
            $post = Question::find($id);  
            $filePath = public_path('uploads/admin') . '/' . $post->image;
              if (File::exists($filePath)) {
                 File::delete($filePath);
               }
            $post->delete();
              return response()->json([
                  'status'=>200,  
                   'message'=>'Data Deleted Successfully',
                ]);
      }
   


   function fetch_data(Request $request,$course_id,$category_id,$sub_category_id,$sub_sub_category_id)
   {
    if($request->ajax())
    {
          $sort_by = $request->get('sortby');
          $sort_type = $request->get('sorttype'); 
              $search = $request->get('search');
              $search = str_replace(" ", "%", $search);
            $data = Question::with('options')->where('course_id',$course_id)->where('category_id',$category_id)
                    ->where('sub_category_id',$sub_category_id)->where('sub_sub_category_id',$sub_sub_category_id)
                    ->where(function($query) use ($search) {
                     $query->orwhere('title', 'like', '%'.$search.'%');
                     $query->orwhere('id', 'like', '%'.$search.'%');
                    })
                    ->orderBy($sort_by, $sort_type)
                    ->paginate(15);
                    return view('admin.question_data', compact('data'))->render();                 
           }
      }




      public function question_import(Request $request){


      
        $user=user_info();
        $course_id=$request->input('course_id');
        $category_id=$request->input('category_id');
        $sub_category_id=$request->input('sub_category_id');
        $sub_sub_category_id=$request->input('sub_sub_category_id');
      
         Excel::Import(new QuestionImport($course_id,$category_id,$sub_category_id,$sub_sub_category_id,$user->id),request()->file('file'));
          return back()->with('success','Data Imported Successfully');
    
      
    }



}
