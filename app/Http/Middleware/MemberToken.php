<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\MemberJWTToken;
use Illuminate\Support\Facades\Cookie;

class MemberToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        $TOKEN_MEMBER=$request->header('TOKEN_MEMBER');
        $result=MemberJWTToken::ReadToken($TOKEN_MEMBER);
          if($result=="unauthorized"){
               return response([
                    "status"=>"unauthorized",
                    "message"=>"Please login"
                ],401);
           }else { 
               $request->headers->set('member_name',$result->name);
               $request->headers->set('email',$result->email);
               $request->headers->set('member_id',$result->member_id);
               return $next($request);
           }
    }
}
