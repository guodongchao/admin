<?php

namespace App\Http\Controllers\Apk;

use Illuminate\Http\Request;
use App\Http\Controllers\Commonality;
use App\Models\CommonAreas;
use App\Models\Site;
use App\Models\Facility;
use App\Models\Module;
use App\Models\Moduleson;
use App\Models\Apk;

class ApkController extends Commonality
{
    //apk展示
    public function ApkShow(Request $request){
        $name = $request -> input('name');
        if(empty($name)){
            $where='';
        }else{
            $where=$name;
        }
        $apk=apk::where(['status'=>1])->where("name", 'like', '%' . $name . '%')->paginate(3); //所有设备
        //根据id判断是添加操作还是修改操作
        $id = $request -> input('id');
        if(!empty($id)){
            $arr = Apk::where(['id'=>$id])->first();
        }else{
            $arr=array();
        }
        $info=[
            'apk'=>$apk,
            'arr'=>$arr,
            'name'=>$name,
        ];
        return view('admin.apk.apkshow',$info);
    }
    /*
     * apk添加、修改
     */
    public function apkAdd(Request $request){

        if( $request -> isMethod('post') ) {
            $arr = $request -> input();
            $id = $request -> input('id');
            //添加或修改的数据
            $where=[
                'name'=>$arr['name'],
                'file_path'=>$arr['file_path'],
                'is_update'=>$arr['is_update'],
                'is_time'=>$arr['is_time'],
                'time'=>date("Y-m-d H:i:s",time())
            ];
            if(!empty($id)){
                //缺少判断
                $res=Apk::where(['id'=>$id])->update($where);
            }else{
                //缺少判断
                $res = Apk::insertGetId($where);
            }
            $res=$this->successful($res);
            return json_encode($res);

        }else{

        }
    }
    /*
    * apk删除
    */
    public function apkDel(Request $request){

        if( $request -> isMethod('post') ) {
            $id = $request -> input('id');
            $where=[
                'id'=>$id,
            ];
            $res = Apk::where($where)->update(['status'=>2]);
            $res=$this->successful($res);
            //缺少判断
            return json_encode($res);
        }else{

        }
    }
    /*
       * apk修改（及点击改）
       */
    public function apkUp(Request $request){

        if( $request -> isMethod('post') ) {
            $id = $request -> input('id');
            $name = $request -> input('name');
            $is_update = $request -> input('is_update');
            //缺少判断
            if(empty($name)){
                $res=Apk::where(['id'=>$id])->update(['is_update'=>$is_update]);
            }else{
                $res=Apk::where(['id'=>$id])->update(['name'=>$name]);
            }
            
            $res=$this->successful($res);
            return json_encode($res);
        }else{

        }
    }
}
