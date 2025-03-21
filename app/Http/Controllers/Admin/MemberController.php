<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Member;
use App\Models\Plot;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\validator;

class MemberController extends Controller
{
    public function member(Request $request){

      
        $member = Member::get();
      if ($request->ajax()) {
      
        $data = Member::latest()->get();
        return Datatables::of($data)
           ->addIndexColumn()
           ->addColumn('image', function($row){
            $imageUrl = asset('uploads/admin/'.$row->image); // Assuming 'image' is the field name in the database
            return '<img src="'.$imageUrl.'" alt="Image" style="width: 50px; height: 50px;"/>';
          })
          ->addColumn('status', function($row){
            $statusBtn = $row->member_status == '1' ? 
                '<button class="btn btn-success btn-sm">Active</button>' : 
                '<button class="btn btn-secondary btn-sm" >Inactive</button>';
            return $statusBtn;
          })
          ->addColumn('view', function($row){
            $btn = '<a href="/admin/member/Personal/'.$row->id.'" class="btn btn-info btn-sm">View Detail</a>';
            return $btn;
        })
          ->addColumn('edit', function($row){
            $btn = '<a href="javascript:void(0);" data-id="' . $row->id . '" class="edit btn btn-primary btn-sm">Edit</a>';
            return $btn;
        })
          ->addColumn('delete', function($row){
            $btn = '<a href="javascript:void(0);" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm">Delete</a>';
            return $btn;
        })
          ->rawColumns(['image','status','edit','delete','view'])
          ->make(true);
       }

          return view('admin.member',["member"=>$member]);  
      }



      public function store(Request $request)
      {

          $user=user_info();
          $validator = \Validator::make(
              $request->all(),
              [
                  'member_name'=> 'required',
                  'bangla_name'=> 'required',
                  'phone' => 'required|unique:members,phone',
                  'email' => 'required|unique:members,email',
                  'image' => 'image|mimes:jpeg,png,jpg|max:400',
               
               ]);
  
          if ($validator->fails()) {
              return response()->json([
                  'status' =>400,
                  'message' =>$validator->messages(),
              ]);
          } else {
              $model = new Member;
              $model->member_name = $request->input('member_name');
              $model->bangla_name = $request->input('bangla_name');
              $model->email = $request->input('email');
              $model->phone = $request->input('phone');
              $model->member_category = $request->input('member_category');
              $model->current_address = $request->input('current_address');
              $model->permanet_address = $request->input('permanet_address');
              $model->password = "DUhousing12";
              $model->member_status = 0;
              $model->created_by=$user->id;

               if ($request->hasfile('image')) {
                      $imgfile = 'booking-';
                      $image = $request->file('image');
                      $new_name = $imgfile . rand() . '.' . $image->getClientOriginalExtension();
                      $image->move(public_path('uploads/admin'), $new_name);
                      $model->image = $new_name;   
                 }
              $model->save();
  
              return response()->json([
                  'status' => 200,
                  'message' => 'Data Added Successfully',
              ]);
          }
      }


      public function edit(Request $request)
        {
          $id = $request->id;
          $data = Member::find($id);
            return response()->json([
                'status' => 200,
                'value' => $data,
            ]);
         }
  
  


      public function update(Request $request)
      {
  
          $user=user_info();
          $validator = \Validator::make($request->all(), [
              'member_name' => 'required',
              'bangla_name'=> 'required',
              'phone' => 'required|unique:members,phone,' . $request->input('edit_id'),
              'image' => 'image|mimes:jpeg,png,jpg|max:400',
          ]);
  
         
          if ($validator->fails()) {
              return response()->json([
                  'status' => 400,
                  'message' => $validator->messages(),
              ]);
          } else {
              $model = Member::find($request->input('edit_id'));
              if ($model) {
                $model->member_name = $request->input('member_name');
                $model->bangla_name = $request->input('bangla_name');
                $model->email = $request->input('email');
                $model->phone = $request->input('phone');
                $model->member_type = $request->input('member_type');
                $model->member_category = $request->input('member_category');
                $model->current_address = $request->input('current_address');
                $model->permanet_address = $request->input('permanet_address');
                $model->dept = $request->input('dept');

                $model->member_status = $request->input('member_status');
             

             
           

                $model->updated_by=$user->id;

                  if ($request->hasfile('image')) {
                      $imgfile = 'booking-';
                          $path = public_path('uploads/admin') . '/' . $model->image;
                          if (File::exists($path)) {
                               File::delete($path);
                          }
                          $image = $request->file('image');
                          $new_name = $imgfile . rand() . '.' . $image->getClientOriginalExtension();
                          $image->move(public_path('uploads/admin'), $new_name);
                          $model->image = $new_name;
                  }
                 $model->update();
                     return response()->json([
                        'status' => 200,
                        'message' => 'Data Updated Successfully'
                      ]);
              } else {
                  return response()->json([
                      'status' => 404,
                      'message' => 'Student not found',
                  ]);
              }
          }
      }
  

      public function delete(Request $request)
      {
  
          $model = Member::find($request->input('id'));
          $filePath = public_path('uploads/admin') . '/' . $model->image;
          if (File::exists($filePath)) {
              File::delete($filePath);
          }
          $model->delete();
          return response()->json([
              'status' => 200,
              'message' => 'Data Deleted Successfully',
          ]);
  
          // }
      }
  
     

}
