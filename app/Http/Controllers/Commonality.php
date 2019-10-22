<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
/*
 * 这里是公共的方法
 */
class Commonality extends Controller
{
    public function successful($arr){
        if($arr){
            $info=[
                'icon'=>1,
                'msg'=>'成功'
            ];
        }else{
            $info=[
                'icon'=>2,
                'msg'=>'失败'
            ];
        }
        return $info;
}
    public function sole(){
        $str = uniqid(mt_rand(),1); //生成唯一字符串
        $str=substr(md5($str),21).substr(md5($str),25); //截取18位
        return $str;
    }

    public function audit(){
        $token=$_COOKIE['token'];
        $username=User::where(['status'=>1,'token'=>$token])->first();
        if($username['super']!=2){
            return  $info=[
                'icon'=>2,
                'msg'=>'你没有权限'
            ];
        }else{
            return  $info=[
                'icon'=>1,
                'msg'=>'ok',
            ];
        }
    }
}
