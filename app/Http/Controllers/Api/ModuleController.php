<?php

namespace App\Http\Controllers\Api;

use App\Models\Moduleson;
use Illuminate\Http\Request;
use App\Http\Controllers\Commonality;
use App\Models\CommonAreas;
use App\Models\Site;
use App\Models\Facility;
use App\Models\FacilityModule;
use App\Models\Module;

class ModuleController extends BaseController
{
    //模块展示
    public function moduleShow(Request $request){
        $mvc=$request->input('mac');//接收mac
        $name=$request->server('HTTP_USER_AGENT');
        $res=$this->verify ($name,$mvc);
        //根据参数判断设备状态
        if($res['code']==0){
            $facility_id=Facility::where(['status'=>1,'sole'=>$mvc])->value('site_id');//根据mac查询设备

            $module_id=FacilityModule::where(['facility_id'=>$facility_id])->get();//查询此设备下的模块
            $id=[];
            foreach($module_id as $k=>$v){
                $id[]=$v['module_id'];
            }
            $http_host=$request->server('HTTP_HOST');//获取域名
            $modules=Module::where(['status'=>1])->whereIn('id',$id)->orderBy('rank','asc')->get();//根据模块id查询
            foreach($modules as $k=>$v){
                $v['img']='http://'.$http_host.'/'.$v['img'];//给图片拼接域名
                $moduleson=Moduleson::where(['module_id'=>$v['id']])->get();//查询模块的子内容
                foreach($moduleson as $m=>$s){
                    $s['img']='http://'.$http_host.'/'.$s['img'];//给图片拼接域名
                }
                $v['module']=$moduleson;
            }

            $info=[
                'modules'=>$modules,
            ];
            return $info;
        }else{
            return $res;
        }

    }

}
