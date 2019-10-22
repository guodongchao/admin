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

class ApkController extends BaseController
{
    //apk接口
    public function ApkShow(Request $request){
        $mvc=$request->input('mac');
        
    }

}
