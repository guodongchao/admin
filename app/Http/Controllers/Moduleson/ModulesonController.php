<?php

namespace App\Http\Controllers\Moduleson;

use Illuminate\Http\Request;
use App\Http\Controllers\Commonality;
use App\Models\CommonAreas;
use App\Models\Site;
use App\Models\Facility;
use App\Models\Module;
use App\Models\Moduleson;

class ModulesonController extends Commonality
{
    //模块内容展示
    public function ModulesonShow(Request $request){

        $module=Module::where(['status'=>1,])->get(); //所有模块
        //根据id判断是添加操作还是修改操作
        $id = $request -> input('id');
        $module_id = $request -> input('module_id');
        if(!empty($module_id)){
            $arrson = Moduleson::where(['id'=>$module_id])->first();
        }else{
            $arrson =array();
        }
        if(!empty($id)){
            $arr = Module::where(['id'=>$id])->first();
            $moduleson=Moduleson::where(['status'=>1,'module_id'=>$id])->get(); //所有模块

        }else{
            $arr=array();
        }
        $info=[
            'module'=>$module,
            'moduleson'=>$moduleson,
            'arr'=>$arr,
            'arrson'=>$arrson,
        ];
        return view('admin.moduleson.modulesonshow',$info);
    }
    /*
     * 模块内容添加、修改
     */
    public function modulesonAdd(Request $request){

        if( $request -> isMethod('post') ) {
            $arr = $request -> input();
            $id = $request -> input('id');
            //添加或修改的数据
            $where=[
                'module_id'=>$arr['module_id'],
                'name'=>$arr['name'],
                'img'=>$arr['img'],
                'time'=>date("Y-m-d H:i:s",time())
            ];
            if(!empty($id)){
                //缺少判断
                $res=Moduleson::where(['id'=>$id])->update($where);
            }else{
                //缺少判断
                $res = Moduleson::insertGetId($where);
            }
            $res=$this->successful($res);
            return json_encode($res);

        }else{

        }
    }
    /*
    * 模块内容删除
    */
    public function modulesonDel(Request $request){

        if( $request -> isMethod('post') ) {
            $id = $request -> input('id');
            $where=[
                'id'=>$id,
            ];
            $res = Moduleson::where($where)->update(['status'=>2]);
            $res=$this->successful($res);
            //缺少判断
            return json_encode($res);
        }else{

        }
    }
    /*
       * 模块内容修改（及点击改）
       */
    public function modulesonUp(Request $request){

        if( $request -> isMethod('post') ) {
            $id = $request -> input('id');
            $name = $request -> input('name');
            //缺少判断
            $res=Moduleson::where(['id'=>$id])->update(['name'=>$name]);
            $res=$this->successful($res);
            return json_encode($res);
        }else{

        }
    }
}
