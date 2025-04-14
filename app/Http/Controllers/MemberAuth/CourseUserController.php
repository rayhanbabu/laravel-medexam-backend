<?php

namespace App\Http\Controllers\MemberAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use Exception;

class CourseUserController extends Controller
{

  

   
    public function login_insert(Request $request)
    {
        // Validate the input
        $request->validate([
            'phone' => ['required','string','max:255'],
            'password' => ['required'],
        ]);
    
    
        // Rate-limiting (Throttle)
        $throttleKey = Str::lower($request->input('phone')) . '|' . $request->ip();
    
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            throw ValidationException::withMessages([
                'email' => ['Too many login attempts. Please try again in ' . RateLimiter::availableIn($throttleKey) . ' seconds.'],
            ]);
        }
    
        // Retrieve member by email
        $member = Member::where('phone',$request->phone)->first();

        if ($member && $member->member_status == 0) {
            // If the user exists and their status is inactive, throw an exception
            throw ValidationException::withMessages([
                'email' => ['Your account is inactive.'],
            ]);
        }

        if($request->password==$member->password) {
              // Increment the throttle attempts if login fails
              // Reset the rate limiter on successful login
             RateLimiter::clear($throttleKey);
    
             $token_member = MemberJWTToken::CreateToken($member->member_name, $member->email, $member->id);
             Cookie::queue('token_member',$token_member, 60*24*30); //96 hour

             $member_info = [
                 "member_name" => $member->member_name, "email" => $member->email ,"bangla_name" => $member->bangla_name
              ];
             $member_info_array = serialize($member_info);
              Cookie::queue('member_info', $member_info_array, 60 * 24*30);

             // You can also update any status or redirect here
              return redirect("/member/dashboard")->with('success', 'Logged in successfully!');

        }else{
            RateLimiter::hit($throttleKey);
            throw ValidationException::withMessages([
                'email' => ['These credentials do not match our records.'],
            ]);
        }

        // return $member->password.'-'.$request->password;
 
    }



      public function logout()
       {
          Cookie::queue('token_member', '', -1);
          Cookie::queue('member_info', '', -1);
          return redirect('member/login');
       }





     

     




}
