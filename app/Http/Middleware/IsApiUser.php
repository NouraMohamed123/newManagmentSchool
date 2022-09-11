<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class IsApiUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->has('access_token')){
            if($request->access_token != NULL){
               $user= User::where('access_token',$request->access_token)->first();

               if(!$user ==null)
               {
                return $next($request);
               }
               else
               {
                  return  response()->json('therer is no user');
               }
            }

            else
            {
                return  response()->json('there is no exist');
            }
        }
        else{
            return  response()->json('there is no token');
        }

    }
}
