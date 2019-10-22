<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Access;
use App\Models\RoleAccess;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
class Login
{
    public function handle(Request $request,Closure $next){



        $token=$_COOKIE['token']??'';//获取token
        if($token){
            $user=User::where(['token'=>$token])->first();
            if(!empty($user)){
                return $next($request);
            }else{
                return response()->view('admin.adminLogin', ['success' => '200']);
            }
        }else{
            return response()->view('admin.adminLogin', ['success' => '200']);
        }

       return $next($request);

    }
    public function access(){

    }
}
