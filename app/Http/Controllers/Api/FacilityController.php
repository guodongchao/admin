<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Models\CommonAreas;
use App\Models\Site;
use App\Models\Facility;

class FacilityController extends BaseController
{
    //设备接口
    public function facilityShow(Request $request){

        $mvc=$request->input('mac');
        $name=$request->server('HTTP_USER_AGENT');
        $res=$this->verify ($name,$mvc);
        return $res;
    }

}
