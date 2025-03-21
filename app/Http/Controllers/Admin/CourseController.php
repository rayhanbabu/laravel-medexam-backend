<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Course;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function course(Request $request){
        if ($request->ajax()) {
             $data = Course::latest()->get();
             return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $statusBtn = $row->course_status == '1' ? 
                        '<button class="btn btn-success btn-sm">Active</button>' : 
                        '<button class="btn btn-secondary btn-sm">Inactive</button>';
                     return $statusBtn;
                 })
                 ->addColumn('edit', function($row){
                   $btn = '<a href="/admin/course/manage/'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                   return $btn;
               })
               ->addColumn('delete', function($row){
                 $btn = '<a href="/admin/course/delete/'.$row->id.'" onclick="return confirm(\'Are you sure you want to delete this item?\')" class="delete btn btn-danger btn-sm">Delete</a>';
                 return $btn;
             })
               ->rawColumns(['status','edit','delete'])
               ->make(true);
            }
          return view('admin.course');  
      }


      public function course_manage(Request $request, $id=''){
           if($id>0){
               $arr=course::where(['id'=>$id])->get();
               $result['id']=$arr['0']->id;
               $result['course_name']=$arr['0']->course_name;
               $result['serial']=$arr['0']->serial;
               $result['course_status']=$arr['0']->course_status;
          } else {
              $result['id']='';
              $result['course_name']='';
              $result['course_status']='';
              $result['serial']='';
          }

            return view('admin.course_manage',$result);  
        }

      public function course_insert(Request $request)
      {
          $user=user_info();
          if(!$request->input('id')){
              $request->validate([
                 'course_name' => 'required|unique:courses,course_name',
                 'course_status' => 'required',
               ]);
          }else{
              $request->validate([
                 'course_name' => 'required|unique:courses,course_name,' . $request->input('id'),
                 'course_status' => 'required',
              ]);
          }

      if($request->post('id')>0){
          $model=course::find($request->post('id'));
          $model->updated_by=$user->id;
      }else{
           $model= new course; 
           $model->created_by=$user->id;   
       }
         $model->serial=$request->input('serial');
         $model->course_name=$request->input('course_name');
         $model->course_status=$request->input('course_status');
         $model->save();

         return redirect('/admin/course')->with('success', 'Changes saved successfully.');

      }


      public function course_delete(Request $request,$id){          
         $model=course::find($id);
         $model->delete();
         return back()->with('success','Data deleted successfully.');

       }

}
