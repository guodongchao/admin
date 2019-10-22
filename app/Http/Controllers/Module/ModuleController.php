<?php

namespace App\Http\Controllers\Module;

use App\Models\SiteFacility;
use Illuminate\Http\Request;
use App\Http\Controllers\Commonality;
use App\Models\CommonAreas;
use App\Models\Site;
use App\Models\Facility;
use App\Models\Module;
use App\Models\Access;
use App\Models\FacilityModule;
use App\Models\User;

class ModuleController extends Commonality
{
    //模块展示
    public function moduleShow(Request $request){
        $token=$_COOKIE['token']??'';
        $username=User::where(['status'=>1,'audit'=>2,'token'=>$token])->first();
        $site=Site::where(['status'=>1])->get();
        foreach($site as $k=>$v){
            $v['son']=SiteFacility::where(['site_id'=>$v['id']])->get();
            foreach($v['son'] as $kk=>$vv){
                $vv['son']=Facility::where(['status'=>1,'id'=>$vv['facility_id']])->get();

            }
        }
        $facility_module=FacilityModule::get()->toArray();
        $facility=Facility::where(['status'=>1])->get();
        foreach ($facility as $k=>$v) {
            $v['facility_id']=explode(' ',$v['facility_id']);
        }
        $name = $request -> input('name');
        if(empty($name)){
            $where='';
        }else{
            $where=$name;
        }
        $module=Module::where(['status'=>1])->where("name", 'like', '%' . $name . '%')->paginate(3); //所有模块
        $modules=Module::where(['status'=>1])->get(); //所有模块 复选框默认选中
        foreach ($modules as $kk=>$vv) {
            $vv['site_id']=explode(' ',$vv['site_id']);

        }
        foreach ($module as $k=>$v) {
            $v['site_id']=explode(' ',$v['site_id']);

        }
        //根据id判断是添加操作还是修改操作
        $id = $request -> input('id');
        if(!empty($id)){
            $arr = Module::where(['id'=>$id])->first();
        }else{
            $arr=array();
        }
        $info=[
            'site'=>$site,
            'facility_module'=>$facility_module,
            'facility'=>$facility,
            'module'=>$module,
            'modules'=>$modules,
            'arr'=>$arr,
            'name'=>$name,
            'username'=>$username
        ];
        return view('admin.module.moduleshow',$info);
    }
    /*
     * 模块添加、修改
     */
    public function moduleAdd(Request $request){

        if( $request -> isMethod('post') ) {
            $arr = $request -> input();
            $id = $request -> input('id');
            //添加或修改的数据
            $where=[
                'name'=>$arr['name'],
                'type'=>$arr['type'],
                'img'=>$arr['img'],
                'rank'=>$arr['rank'],
                'audit'=>$arr['audit'],
                'site_id'=>$arr['site_id'],
                'time'=>date("Y-m-d H:i:s",time())
            ];
            if(!empty($id)){
                //缺少判断
                $res=Module::where(['id'=>$id])->update($where);
                $del=FacilityModule::where(['module_id'=>$id])->delete();
                if(!empty($arr['site_id'])){
                    $facility_id=explode(' ',$arr['facility_id']);
                    foreach($facility_id as $k=>$v){
                        $wheres=[
                            'module_id'=>$id,
                            'facility_id'=>$v
                        ];
                        FacilityModule::insert($wheres);
                    }
                }

            }else{
                //缺少判断
                $res = Module::insertGetId($where);
                $num=$res;
                //添加或修改的数据
                $access=[
                    'title'=>$arr['name'],
                    'uris'=>'module'.$res,
                    'pid'=>0,
                    'time'=>date("Y-m-d H:i:s",time())
                ];
                $module_id = Access::insertGetId($access);//生成模块权限
                    for($i=1;$i<=4;$i++){
                        if($i==1){
                            $name='新增内容';
                            $module='moduleson'.$num;
                        }
                        if($i==2){
                            $name='修改';
                            $module='moduleadd'.$num;
                        }
                        if($i==3){
                            $name='删除';
                            $module='moduledel'.$num;
                        }
                        if($i==4){
                            $name='即点即改';
                            $module='moduleup'.$num;
                        }
                        $access=[
                            'title'=>$name,
                            'uris'=>$module,
                            'pid'=>$module_id,
                            'time'=>date("Y-m-d H:i:s",time())
                        ];
                        //缺少判断
                        $res = Access::insertGetId($access);//生成模块权限
                    }
                if(!empty($arr['site_id'])){
                    $facility_id=explode(' ',$arr['facility_id']);
                    foreach($facility_id as $k=>$v){
                        $wheres=[
                            'module_id'=>$num,
                            'facility_id'=>$v
                        ];
                        FacilityModule::insert($wheres);
                    }
                }

            }
            $res=$this->successful($res);
            return json_encode($res);

        }else{

        }
    }
    /*
    * 模块删除
    */
    public function moduleDel(Request $request){

        if( $request -> isMethod('post') ) {
            $id = $request -> input('id');
            $where=[
                'id'=>$id,
            ];
            $res = Module::where($where)->update(['status'=>2]);
            if($res){
                $wheres=[
                    'uris'=>'module'.$id,
                ];
                Access::where($wheres)->update(['status'=>2]);
            }
            $res=$this->successful($res);

            //缺少判断
            return json_encode($res);
        }else{

        }
    }
    /*
       * 模块修改（及点击改）
       */
    public function moduleUp(Request $request){

        if( $request -> isMethod('post') ) {
            $id = $request -> input('id');
            $name = $request -> input('name');
            $audit = $request -> input('audit');
            if(!empty($name)){
                $res=Module::where(['id'=>$id])->update(['name'=>$name]);
            }else{
                $is_audit=$this->audit();
                if($is_audit['icon']==1){
                    $res=Module::where(['id'=>$id])->update(['audit'=>$audit]);
                }else{
                    return $is_audit;
                }

            }
            $res=$this->successful($res);
            return json_encode($res);
        }else{

        }
    }
}
