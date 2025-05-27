<?php

namespace App\Http\Controllers\MemberAuth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Helpers\MemberJWTToken;

use App\Models\Member;
use App\Models\Service;
use Exception;

class MemberAuthController extends Controller
{



   public function registration(Request $request)
     {
        // Validate the input
        $validator = \Validator::make($request->all(), [
            'member_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:members'],
            'phone' => ['required', 'string', 'max:15', 'unique:members'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }
    
        // Create the member
        $member = Member::create([
            'member_name' => $request->member_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password, // Note: This should be hashed in a real application
            'member_status' => 1, // Assuming 1 means active
        ]);
    
        return response()->json([
            'message' => 'Registration successful',
        ], 201);
    }
   

   
    public function login_insert(Request $request)
    {
        // Validate the input
        $validator = \Validator::make($request->all(), [
            'phone' => ['required', 'string', 'max:255'],
            'password' => ['required'],
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }
    
        // Rate-limiting (Throttle)
        $throttleKey = Str::lower($request->input('phone')) . '|' . $request->ip();
    
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            return response()->json([
                'message' => 'Too many login attempts',
                'retry_after' => RateLimiter::availableIn($throttleKey)
            ], 400);
        }
    
        // Retrieve member by phone
        $member = Member::where('phone', $request->phone)->first();
    
        if (!$member) {
            RateLimiter::hit($throttleKey);
            return response()->json([
                'message' => 'These credentials do not match our records.'
            ], 400);
        }
    
        if ($member->member_status == 0) {
            return response()->json([
                'message' => 'Your account is inactive.'
            ], 400);
        }
    
        // Check plain-text password (not secure — see note below!)
        if ($request->password === $member->password) {
            RateLimiter::clear($throttleKey);
    
            $token_member = MemberJWTToken::CreateToken($member->member_name, $member->email, $member->id);
    
            return response()->json([
                'message' => 'Login successful',
                'TOKEN_MEMBER' => $token_member,
                'member_info' => $member->select('member_name', 'email', 'bangla_name','phone')->first()
            ], 200);
        } else {
            RateLimiter::hit($throttleKey);
    
            return response()->json([
                'message' => 'These credentials do not match our records.'
            ], 400);
        }
    }



      public function logout()
       {
          Cookie::queue('token_member', '', -1);
          Cookie::queue('member_info', '', -1);
          return redirect('member/login');
       }


    public function profile(Request $request)
     {
          try {
                   $member_id = $request->header('member_id');
                   $member = Member::where('members.id',$member_id)->first();
                   return response()->json([
                       'member_info' => $member,
                ], 200);

                  
           } catch (Exception $e) {
                  return  view('errors.error', ['error' => $e]);
           }
      }


      public function credit(Request $request)
      {
        //    try {
                   // $member_id = $request->header('member_id');

                    // $data = Credit::where('member_id',$member_id)->latest()->get();
                    // return $data;
                    if ($request->ajax()) {
                        $member_id = $request->header('member_id');
                        $data = Credit::where('member_id',$member_id)->latest()->get();
                        return Datatables::of($data)
                           ->addIndexColumn()
                           ->addColumn('status', function($row){
                                 $statusBtn = $row->credit_status == '1' ? 
                                     '<a href="#"  class="btn btn-info btn-sm">Paid</a>' : 
                                     '<a href="#"  class="btn btn-warning btn-sm">Pending</a>';
                                return $statusBtn;
                            })              
                          ->rawColumns(['status'])
                          ->make(true);
                       }
                     return view('member.credit');  

            //    } catch (Exception $e) {
            //        return  view('errors.error', ['error' => $e]);
            //   }
       }



     



}
