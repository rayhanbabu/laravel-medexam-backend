<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\MemberJWTToken;
use Illuminate\Support\Facades\Cookie;
use App\Models\CourseUser;

class CourseAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

         $course_id = $request->route('course_id');
         $member_id = $request->headers->get('member_id');

         $result = CourseUser::where('course_id',$course_id)->where('user_id',$member_id)->where('status',1)->first();

            if($result==null){
                return response([
                    "status"=>"unauthorized",
                    "message"=>"You are not authorized to access this course"
                ],401);
        
            }else if($result->status==0){

                return response([
                    "status"=>"unauthorized",
                    "message"=>"Your subscription is expired"
                ],401);
            }else if($result->status==2){
                return response([
                    "status"=>"unauthorized",
                    "message"=>"Your subscription is cancelled"
                ],401);
            }else if($result->status==3){
                return response([
                    "status"=>"unauthorized",
                    "message"=>"Your subscription is on hold"
                ],401);
            }



            return $next($request);
            
    }
}
