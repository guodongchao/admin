<?php

namespace App\Http\Controllers\Facility;

use Illuminate\Http\Request;
use App\Http\Controllers\Commonality;
use App\Models\CommonAreas;
use App\Models\Site;
use App\Models\Facility;
use App\Models\SiteFacility;
use App\Models\User;

class FacilityController extends Commonality
{
    //设备展示
    public function facilityShow(Request $request){
        $site=Site::where(['status'=>1])->get(); //所有单位
        $parent_id = $request -> input('parent_id');
        if(!empty($parent_id)){
            $res = CommonAreas::where(['parent_id'=> $parent_id])->get()->toArray();
            return json_encode($res);
        }else{
            $res = CommonAreas::where(['parent_id'=> 0])->get()->toArray();//三级联动
        }
        //根据$site_name变量判断是否为模糊匹配
        $name = $request -> input('name');
        if(empty($name)){
            $where='';
        }else{
            $where=$name;
        }
        $token=$_COOKIE['token']??'';
        $username=User::where(['status'=>1,'audit'=>2,'token'=>$token])->first();
        $site_id=explode(' ',$username['site_id']);
        //判断是否为超级管理员
        if($username['super']!=2){
            $user_site=Site::where(['status'=>1])->whereIn('id',$site_id)->get();
            $facility_id=[];
            foreach($user_site as $u=>$s){
                $facility_id[] =$s['id'];
            }
            $facility=Facility::where(['status'=>1])->where("name", 'like', '%' . $name . '%')->whereIn('id',$facility_id)->paginate(3); //所有设备
            
        }else{
            $facility=Facility::where(['status'=>1])->where("name", 'like', '%' . $name . '%')->paginate(3); //所有设备
        }


        foreach($facility as $k=>$v){
            $v['province']=CommonAreas::where(['area_id'=>$v['province']])->value('area_name');
            $v['city']=CommonAreas::where(['area_id'=>$v['city']])->value('area_name');
            $v['area']=CommonAreas::where(['area_id'=>$v['area']])->value('area_name');
            $v['town']=CommonAreas::where(['area_id'=>$v['town']])->value('area_name');
        }
        $str=$this->sole();
//        $str = uniqid(mt_rand(),1); //生成唯一字符串
//        $str=substr(md5($str),21).substr(md5($str),25); //截取18位
        //根据id判断是添加操作还是修改操作
        $id = $request -> input('id');

        if(!empty($id)){
            $arr = Facility::where(['id'=>$id])->first();

            $arr['password']=base64_decode($arr['password']);

        }else{
            $arr=array();
        }
        $info=[
            'site'=>$site,
            'res'=>$res,
            'facility'=>$facility,
            'str'=>$str,
            'arr'=>$arr,
            'name'=>$name,
            'username'=>$username,
        ];

        return view('admin.facility.facilityshow',$info);
    }
    /*
     * 设备添加、修改
     */
    public function facilityAdd(Request $request){

        if( $request -> isMethod('post') ) {
            $arr = $request -> input();
            $id = $request -> input('id');

            //添加或修改的数据
            $where=[
                'sole'=>$arr['sole'],
                'type'=>$arr['type'],
                'name'=>$arr['name'],
                'number'=>$arr['number'],
                'wifi'=>$arr['wifi'],
                'luminance'=>$arr['luminance'],
                'volume'=>$arr['volume'],
                'password'=>base64_encode($arr['password']),
                'boot_time'=>$arr['boot_time'],
                'off_time'=>$arr['off_time'],
                'audit'=>$arr['audit'],
                'site_id'=>$arr['site_id'],
                'province'=>$arr['province'],
                'city'=>$arr['city'],
                'area'=>$arr['area'],
                'town'=>$arr['town'],
                'desc'=>$arr['desc'],
                'time'=>date("Y-m-d H:i:s",time())
            ];
            if(!empty($id)){
                //缺少判断
                $res=Facility::where(['id'=>$id])->update($where);


                $sitefacility=SiteFacility::where(['facility_id'=>$id])->first();

                if($sitefacility!=NULL){
                    SiteFacility::where(['facility_id'=>$id])->delete();
                }
                $facility_id=$id;
            }else{
                //缺少判断
                $fac=Facility::where(['sole'=>$arr['sole']])->first();
                if(!empty($fac)){
                    $info=[
                        'icon'=>2,
                        'msg'=>'设备ID重复，请重试'
                    ];
                    return $info;
                }
                $res = Facility::insertGetId($where);
                $facility_id=$res;
            }
            if(!empty($arr['site_id'])){

                $wheres=[
                    'site_id'=>$arr['site_id'],
                    'facility_id'=>$facility_id,
                ];

                SiteFacility::insert($wheres);
            }

            $res=$this->successful($res);
            return json_encode($res);

        }else{

        }
    }
    /*
    * 设备删除
    */
    public function facilitydel(Request $request){

        if( $request -> isMethod('post') ) {
            $id = $request -> input('id');
            $where=[
                'id'=>$id,
            ];
            $res = Facility::where($where)->update(['status'=>2]);
            $res=$this->successful($res);
            //缺少判断
            return json_encode($res);
        }else{
            $res = CommonAreas::where(['parent_id'=> 0])->get()->toArray();
            return view('admin.site.siteshow',['res'=>$res]);
        }
    }
    /*
       * 设备修改（及点击改）
       */
    public function facilityup(Request $request){

        if( $request -> isMethod('post') ) {
            $id = $request -> input('id');
            $name = $request -> input('name');
            $audit = $request -> input('audit');
            if(!empty($name)){
                $res=Facility::where(['id'=>$id])->update(['name'=>$name]);
            }else{
                $is_audit=$this->audit();
                if($is_audit['icon']==1){
                    $res=Facility::where(['id'=>$id])->update(['audit'=>$audit]);
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
