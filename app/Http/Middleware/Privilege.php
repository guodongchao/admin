<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Access;
use App\Models\RoleAccess;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
class Privilege
{
    public function handle(Request $request,Closure $next){

        $mid=$request->input('id');

            $path=$request->path();//获取当前路由
            $token=$_COOKIE['token'];//获取token
            $arr=User::where(['status'=>1,'token'=>$token])->first();//根据token查询用户
            if(!empty($arr)){
                if($arr['super']==2){
                    return $next($request);
                }else{
                    $role_id=UserRole::where(['uid'=>$arr['id']])->get('role_id')->toArray();//用户、角色派生表
                    if(!empty($role_id)){

                        $id=[];
                        foreach($role_id as $k=>$v){
                            $id[]=$v['role_id'];
                        }
                        $role=Role::where(['status'=>1,'audit'=>2])->whereIn('id',$id)->get();//角色表
                        $access_id=[];
                        foreach($role as $r=>$e){
                            $access_id[]=RoleAccess::where(['role_id'=>$e['id']])->get();//角色、权限表
                        }
                        if(!empty($access_id)){
                            $access=[];
                            foreach($access_id as $a=>$c){
                                foreach($c as $c1=>$c2){
                                    $access[]=$c2['access_id'];
                                }
                            }
                            $access=array_unique($access);//去除重复的值
                            $uris=Access::where(['status'=>1])->whereIn('id',$access)->get('uris');//权限表
                            $url=[];
                            foreach($uris as $u=>$s){
                                $url[]=$s['uris'];

                            }
                            //判断权限
                            if(!in_array($path.$mid,$url)){
                                if( $request -> isMethod('post') ) {
                                    $info=[
                                        'icon'=>2,
                                        'msg'=>'你没有权限'
                                    ];
                                    return response()->json($info);

                                }else{
                                    return response()->view('admin.access.accessshow');
                                }

                            }
                        }else{

                            if( $request -> isMethod('post') ) {

                                $info=[
                                    'icon'=>2,
                                    'msg'=>'你没有权限'
                                ];
                                return response()->json($info);

                            }else{
                                return response()->view('admin.access.accessshow');
                            }
                            //access_id
                        }
                    }else{

                        if( $request -> isMethod('post') ) {
                            $info=[
                                'icon'=>2,
                                'msg'=>'你没有权限'
                            ];
                            return response()->json($info);

                        }else{
                            return response()->view('admin.access.accessshow');
                        }
                        //role_id
                    }
                }


            }else{

                return response()->view('admin.adminLogin', ['success' => '200']);
            }

       return $next($request);

    }

}
