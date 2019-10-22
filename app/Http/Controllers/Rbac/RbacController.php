<?php

namespace App\Http\Controllers\Rbac;

use Illuminate\Http\Request;
use App\Http\Controllers\Commonality;
use App\Models\CommonAreas;
use App\Models\Site;
use App\Models\Access;
use App\Models\RoleAccess;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;

class RbacController extends Commonality
{
    //权限展示
    public function rbacShow(Request $request){
        //根据id判断是添加操作还是修改操作
        $id = $request -> input('id');
        $name = $request -> input('name');
        $type= $request -> input('type');//根据type分别判断用户、角色、权限
        if(!empty($id)){
            if($type==1){
                $arr = User::where(['id'=>$id])->first();
                $arr['password']=base64_decode($arr['password']);//密码解密
            }elseif($type==2){
                $arr = Role::where(['id'=>$id])->first();
            }elseif($type==3){
                $arr = Access::where(['id'=>$id])->first();
            }
        }else{
            $arr=array();
        }
        $access=Access::where(['status'=>1,'pid'=>0])->get();// pid为0的权限
        $accessall=Access::where(['status'=>1])->get();// 所有权限
        foreach($access as $k=>$v){
            $v['son']=Access::where(['status'=>1,'pid'=>$v['id']])->get();// pid为0的子级权限
        }

        $role=Role::where(['status'=>1])->get();//所有角色
        foreach($role as $k=>$v){
            $v['access_id']=explode(' ',$v['access_id']);//分割成数组
        }
        $user=User::where(['status'=>1])->get();//所有用户
        foreach($user as $k=>$v){
            $v['password']=base64_decode($v['password']);//密码解密
            $v['role_id']=explode(' ',$v['role_id']);//分割成数组
            $v['site_id']=explode(' ',$v['site_id']);//分割成数组
        }
        $usershow=User::where(['status'=>1])->where("name", 'like', '%' . $name . '%')->paginate(3);//分页用户
        foreach($usershow as $k=>$v){
            $v['password']=base64_decode($v['password']);//密码解密
            $v['role_id']=explode(' ',$v['role_id']);//分割成数组
            $v['site_id']=explode(' ',$v['site_id']);//分割成数组
        }
        $roleshow=Role::where(['status'=>1])->where("name", 'like', '%' . $name . '%')->paginate(3);//分页角色
        foreach($roleshow as $k=>$v){
            $v['access_id']=explode(' ',$v['access_id']);//分割成数组
        }
        $accessshow=Access::where(['status'=>1])->where("title", 'like', '%' . $name . '%')->paginate(3);//分页权限
        $site=Site::where(['status'=>1])->get(); //所有单位
        $info=[
            'access'=>$access,
            'accessall'=>$accessall,
            'role'=>$role,
            'user'=>$user,
            'usershow'=>$usershow,
            'roleshow'=>$roleshow,
            'accessshow'=>$accessshow,
            'type'=>$type,
            'name'=>$name,
            'arr'=>$arr,
            'site'=>$site
        ];
        return view('admin.rbac.rbacshow',$info);

    }
    /*
     * 权限添加、修改
     */
    public function rbacAdd(Request $request){

        if( $request -> isMethod('post') ) {
            $arr = $request -> input();
            $id = $request -> input('id');
            //添加或修改的数据
            $where=[
                'title'=>$arr['title'],
                'uris'=>$arr['uris'],
                'time'=>date("Y-m-d H:i:s",time())
            ];
            if(!empty($id)){
                //缺少判断
                $res=Access::where(['id'=>$id])->update($where);
            }else{
                //缺少判断
                $res = Access::insertGetId($where);
            }
            $res=$this->successful($res);
            return json_encode($res);

        }else{

        }
    }
    /*
     * 角色添加、修改
     */
    public function roleAdd(Request $request){

        if( $request -> isMethod('post') ) {
            $arr = $request -> input();
            $id = $request -> input('id');
            //添加或修改的数据
            $where=[
                'name'=>$arr['name'],
                'access_id'=>$arr['access_id'],
                'time'=>date("Y-m-d H:i:s",time())
            ];
            if(!empty($id)){
                //缺少判断
                $res=Role::where(['id'=>$id])->update($where);
                RoleAccess::where(['role_id'=>$id])->delete();
                $role_id=$id;
            }else{
                //缺少判断
                $res = Role::insertGetId($where);
                $role_id=$res;
            }
            if(!empty($arr['access_id'])){
                $access_id=explode(' ',$arr['access_id']);
                foreach($access_id as $k=>$v){
                    $wheres=[
                        'role_id'=>$role_id,
                        'access_id'=>$v,
                        'time'=>date("Y-m-d H:i:s",time())
                    ];
                    RoleAccess::insert($wheres);
                }
            }

            $res=$this->successful($res);
            return json_encode($res);

        }else{

        }
    }
    /*
     * 用户添加、修改
     */
    public function userAdd(Request $request){

        if( $request -> isMethod('post') ) {
            $arr = $request -> input();
            $id = $request -> input('id');
            //添加或修改的数据
            $where=[
                'name'=>$arr['name'],
                'password'=>base64_encode($arr['password']),
                'role_id'=>$arr['role_id'],
                'site_id'=>$arr['site_id'],
                'time'=>date("Y-m-d H:i:s",time())
            ];
            if(!empty($id)){
                //缺少判断
                $res=User::where(['id'=>$id])->update($where);
                UserRole::where(['uid'=>$id])->delete();
                $uid=$id;
            }else{
                //缺少判断
                $user_name=User::where(['name'=>$arr['name']])->first();
                if(!empty($user_name)){
                    $info=[
                        'icon'=>2,
                        'msg'=>'用户已存在'
                    ];
                    return $info;
                }
                $res = User::insertGetId($where);
                $uid=$res;

            }
            if(!empty($arr['role_id'])){
                $role_id=explode(' ',$arr['role_id']);
                foreach($role_id as $k=>$v){
                    $wheres=[
                        'uid'=>$uid,
                        'role_id'=>$v,
                        'time'=>date("Y-m-d H:i:s",time())
                    ];
                    UserRole::insert($wheres);
                }
            }

            $res=$this->successful($res);
            return json_encode($res);

        }else{

        }
    }
    /*
    * 用户、角色、权限删除
    */
    public function userDel(Request $request){

        if( $request -> isMethod('post') ) {
            $id = $request -> input('id');
            $type = $request -> input('type');
            $where=[
                'id'=>$id,
            ];
            //根据type判断   1修改用户表  2修改角色表   3修改权限表
            if($type==1){
                $res = User::where($where)->update(['status'=>2]);
            }elseif($type==2){
                $res = Role::where($where)->update(['status'=>2]);
            }elseif($type==3){
                $res = Access::where($where)->update(['status'=>2]);
            }
            $res=$this->successful($res);
            //缺少判断
            return json_encode($res);
        }else{

        }
    }
    /*
     * 用户、角色、权限修改（及点击改）
    */
    public function userUp(Request $request){

        if( $request -> isMethod('post') ) {
            $id = $request -> input('id');
            $name = $request -> input('name');
            $audit = $request -> input('audit');
            $type= $request -> input('type');
            $title= $request -> input('title');
            //根据type判断   1修改用户表  2修改角色表   3修改权限表
            if($type==1){
                if(empty($audit)){
                    $res=User::where(['id'=>$id])->update(['name'=>$name]);
                }else{
                    $is_audit=$this->audit();
                    if($is_audit['icon']==1){
                        $res=User::where(['id'=>$id])->update(['audit'=>$audit]);
                    }else{
                        return $is_audit;
                    }

                }
            }elseif($type==2){
                if(empty($audit)){
                    $res=Role::where(['id'=>$id])->update(['name'=>$name]);
                }else{
                    $is_audit=$this->audit();
                    if($is_audit['icon']==1){
                        $res=Role::where(['id'=>$id])->update(['audit'=>$audit]);
                    }else{
                        return $is_audit;
                    }
                }
            }elseif($type==3){
                if(empty($audit)){
                    $res=Access::where(['id'=>$id])->update(['title'=>$title]);
                }
            }


            $res=$this->successful($res);
            return json_encode($res);
        }else{

        }
    }
}
