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
use App\Models\Balance;
use App\Models\Debit;
use App\Models\Credit;
use Exception;

class MemberAuthController extends Controller
{

    public function login(Request $request)
    {
        try {
              return view('member.login');
         } catch (Exception $e) {
              return  view('errors.error', ['error' => $e]);
         }
    }


   
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


    public function dashboard(Request $request)
     {
          try {
                   $member_id = $request->header('member_id');
                   $member = Member::leftjoin('plots','plots.id','=','members.plot_id')
                   ->where('members.id',$member_id)->select('plots.plot_no','members.*')->first();
                   $balance=Balance::where('member_id',$member_id)->latest()->first();
                   return view('member.dashboard',['balance'=>$balance,'member'=>$member]);
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



       public function debit(Request $request)
         {
             try {
                 $member_id = $request->header('member_id');
             if ($request->ajax()) {
              $data = Debit::where('member_id',$member_id)->where('debit_status',1)->latest()->get();
                return Datatables::of($data)
                  ->addIndexColumn()
                  ->make(true);
              }
          return view('member.debit');  
               } catch (Exception $e) {
                     return  view('errors.error', ['error' => $e]);
               }
          } 




}
