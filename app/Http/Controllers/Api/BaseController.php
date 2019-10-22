<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Commonality;
use Symfony\Component\HttpFoundation\Request;
use App\Models\Site;
use App\Models\Facility;
class BaseController extends Commonality
{

    const RESPONSE_CODE_OK = 0;
    const RESPONSE_CODE_USER_EXIST = 100001;
    const RESPONSE_CODE_USER_NOT_ENABLED = 100002;
    const RESPONSE_CODE_USER_PERMISSION_ERROR = 100003;
    const RESPONSE_CODE_USER_NOT_EXIST = 100004;
    const RESPONSE_CODE_FILE_ERROR = 100005;
    const RESPONSE_CODE_OBJECT_NOT_EXIST = 100006;
    const RESPONSE_CODE_SMS_API_ERROR= 100007;
    const RESPONSE_CODE_SMS_CODE_NOT_VALID = 100008;
    const RESPONSE_CODE_PRODUCT_WARRANTY_OUT = 100009;
    const RESPONSE_CODE_DEVICE_NOT_EXIST= 100010;
    
    const RESPONSE_CODE_PARAM_ERROR = 200001;

    public function verify($name, $mvc){
        //验证为空
        if(empty($mvc)){
            $res=$this->getResult(BaseController::RESPONSE_CODE_PARAM_ERROR,$mvc);
            return $res;
        }
        //验证未审核
        $audit=Facility::where(['sole'=>$mvc])->value('audit');
        if($audit==1){
            $res=$this->getResult(BaseController::RESPONSE_CODE_USER_NOT_ENABLED,$mvc);
            return $res;
        }
        //验证审核通过
        if($audit==2){
            $res=$this->getResult(BaseController::RESPONSE_CODE_OK,$mvc);
            $res['data']=Facility::where(['sole'=>$mvc])->first();
            return $res;
        }

        //验证注册
        if($mvc=='mac'){
            $sole=$this->sole();
            $where=[
                'sole'=>$sole,
                'type'=>'新建未知',
                'name'=>$name,
                'number'=>'新建未知',
                'luminance'=>0,
                'volume'=>0,
                'password'=>md5('123456'),
                'boot_time'=>null,
                'off_time'=>null,
                'site_id'=>null,
                'time'=>date("Y-m-d H:i:s",time())
            ];
            //缺少判断
            $res = Facility::insertGetId($where);
            if($res){
                $info=[
                    'sole'=>$sole,
                    'message' =>'注册成功,请等待审核',
                ];
            }else{
                $info=[
                    'sole'=>null,
                    'message' =>'注册失败,请重试',
                ];
            }
            return $info;

        }
        if($audit==''){
            $res=$this->getResult(BaseController::RESPONSE_CODE_DEVICE_NOT_EXIST,$mvc);
            return $res;
        }
    }
    public function getResult($code, $data)
    {
        $res['code'] = $code;
        switch ($code){
            case BaseController::RESPONSE_CODE_OK:
                $res['message']='OK';
                break;
            case BaseController::RESPONSE_CODE_USER_EXIST:
                $res['message']='用户已存在';
                break;
            case BaseController::RESPONSE_CODE_PARAM_ERROR:
                $res['message']='参数错误';
                break;
            case BaseController::RESPONSE_CODE_USER_PERMISSION_ERROR:
                $res['message']='权限错误';
                break;
            case BaseController::RESPONSE_CODE_USER_NOT_ENABLED:
                $res['message']='设备待审核中';
                break;
            case BaseController::RESPONSE_CODE_FILE_ERROR:
                $res['message'] = '文件错误';
                break;
            case BaseController::RESPONSE_CODE_OBJECT_NOT_EXIST:
                $res['message'] = '对象不存在';
                break;
            case BaseController::RESPONSE_CODE_SMS_CODE_NOT_VALID:
                $res['message'] =  '验证码无效';
                break;
            case BaseController::RESPONSE_CODE_PRODUCT_WARRANTY_OUT:
                $res['message'] =  '产品已过保质期';
                break;
            case BaseController::RESPONSE_CODE_DEVICE_NOT_EXIST:
                $res['message'] =  '设备不存在';
                break;
            default:
                $res['message']='OK';
        }
        $res['data'] = $data ?: array();
        return $res;
    }
    

}
