<?php

namespace App\Http\Controllers\Site;

use App\Models\Facility;
use App\Models\SiteFacility;
use Illuminate\Http\Request;
use App\Http\Controllers\Commonality;
use App\Models\CommonAreas;
use App\Models\Site;

class SiteController extends Commonality
{
    //三级联动
    public function siteShow(Request $request){

        if( $request -> isMethod('post') ) {
            $parent_id = $request -> input('parent_id');
            $res = CommonAreas::where(['parent_id'=> $parent_id])->get()->toArray();
            return json_encode($res);
        }else{
            //根据$site_name变量判断是否为模糊匹配
            $site_name = $request -> input('site_name');
            if(empty($site_name)){
               $where='';
            }else{
                $where=$site_name;
            }
            //三级联动
            $res = CommonAreas::where(['parent_id'=> 0])->get()->toArray();
            //单位表单
            static $site='';
            $site=Site::where(['status'=>1])->where("site_name", 'like', '%' . $site_name . '%')->paginate(3);
            $facility=Facility::where(['status'=>1])->get()->toArray();//所有模块

                foreach($site as $k=>$v){
                    foreach($facility as $f=>$l){
                    $v['province']=CommonAreas::where(['area_id'=>$v['province']])->value('area_name');
                    $v['city']=CommonAreas::where(['area_id'=>$v['city']])->value('area_name');
                    $v['area']=CommonAreas::where(['area_id'=>$v['area']])->value('area_name');
                    $v['town']=CommonAreas::where(['area_id'=>$v['town']])->value('area_name');
                    if($l['site_id']==$v['id']){
                       // echo $l['site_id'].$v['id'];exit;
                       $v['facility']=$v['facility'].'～'.$l['name'];

                    }
                }
            }






            //根据id判断是添加操作还是修改操作
            $id = $request -> input('id');
            if(!empty($id)){
                $arr = Site::where(['id'=>$id])->first();
            }else{
                $arr=array();
            }
            $info=[
              'res'     =>  $res,
              'site'    =>$site,
              'arr'    =>$arr,
              'site_name'=>$site_name
            ];
            return view('admin.site.siteshow',$info);
        }
    }
    /*
     * 单位添加、修改
     */
    public function siteAdd(Request $request){

        if( $request -> isMethod('post') ) {
            $arr = $request -> input();
            $id = $request -> input('id');
            //将地址id换成名字
//            $arr['province']=CommonAreas::where(['area_id'=>$arr['province']])->value('area_name');
//            $arr['city']=CommonAreas::where(['area_id'=>$arr['city']])->value('area_name');
//            $arr['area']=CommonAreas::where(['area_id'=>$arr['area']])->value('area_name');
//            $arr['town']=CommonAreas::where(['area_id'=>$arr['town']])->value('area_name');
            //添加或修改的数据
            $where=[
                'site_name'=>$arr['title'],
                'province'=>$arr['province'],
                'city'=>$arr['city'],
                'area'=>$arr['area'],
                'town'=>$arr['town'],
                'desc'=>$arr['desc'],
                'time'=>date("Y-m-d H:i:s",time())
            ];
            if(!empty($id)){
                //缺少判断
                $res=Site::where(['id'=>$id])->update($where);
            }else{
                //缺少判断
                $res = Site::insertGetId($where);
            }
            $res=$this->successful($res);
            return json_encode($res);

        }else{

        }
    }
    /*
    * 单位删除
    */
    public function siteDel(Request $request){

        if( $request -> isMethod('post') ) {
            $id = $request -> input('id');
            $where=[
                'id'=>$id,
            ];
            $res = Site::where($where)->update(['status'=>2]);
            $res=$this->successful($res);
            //缺少判断
            return json_encode($res);
        }else{
            $res = CommonAreas::where(['parent_id'=> 0])->get()->toArray();
            return view('admin.site.siteshow',['res'=>$res]);
        }
    }
    /*
       * 单位修改（及点击改）
       */
    public function siteUp(Request $request){

        if( $request -> isMethod('post') ) {
            $id = $request -> input('id');
            $site_name = $request -> input('site_name');
            $res=Site::where(['id'=>$id])->update(['site_name'=>$site_name]);
            $res=$this->successful($res);
            return json_encode($res);
        }else{
            $res = CommonAreas::where(['parent_id'=> 0])->get()->toArray();
            return view('admin.site.siteshow',['res'=>$res]);
        }
    }
}
