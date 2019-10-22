<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
class AdminController extends Controller
{
    //后台主页
    public function admin(){
        return view('admin.layout');
    }
    //验证身份
    public function verify(Request $request){
        $token=$request->input('token');
        $arr=User::where(['status'=>1,'token'=>$token])->first();
        return $arr;
    }
    //后台登录
    public function adminLogin(Request $request){
        if( $request -> isMethod('post') ) {
            $user=$request->input('login');
            $pwd=$request->input('pwd');
            $remember_me=$request->input('remember_me');
            $arr=User::where(['status'=>1,'name'=>$user])->first();
            if($user!=$arr['name']){
                $response=['Status'=>"1"];
            }else if(base64_encode($pwd)!=$arr['password']){
                $response=['Status'=>"2"];
            }else{
                $token=substr(md5(rand(1,9999)),8);
                User::where(['id'=>$arr['id']])->update(['token'=>$token]);
                setcookie('token', $token, time() + 60 * 60 * 10);//储存10小时
                setcookie('name', $arr['name'], time() + 60 * 60 * 10);//储存10小时
                $response=['Status'=>"200"];
            }

            $time=time();
            //记住密码
            if ($remember_me == "true") {
                setcookie('user', $user, $time + 60 * 60 * 24 * 10);
                setcookie('pwd', $pwd, $time + 60 * 60 * 24 * 10);

            }

            return $response;
        }else {
            return view('admin.adminLogin');
        }
    }

    //退出
    public function adminQuit()
    {
        setcookie('token','',-1);
        setcookie('name','',-1);
        return view('admin.adminLogin', ['success' => '200']);
    }

}
