@extends('admin.layout')
@section('content')
    <form action="/facility" method="post">
        <input type="text" name="name" placeholder="请输入设备名称">
        <button class="layui-btn layui-btn-sm">搜索</button>
    </form>

    <table class="layui-table">
        <colgroup>
            <col width="10">
            <col width="10">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>ID</th>
            <th>唯一标识</th>
            <th>设备名称</th>
            <th>设备密码</th>
            <th>设备类型</th>
            <th>设备地址</th>
            <th>设备状态</th>
            <th>开机时间</th>
            <th>关机时间</th>
            <th>添加时间</th>
            <th>单位</th>
            <th>审核</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($facility as $k=>$v)

        <tr class="{{$v['id']}}">
            <td>{{$v['id']}}</td>
            <td>{{$v['sole']}}</td>
            <td onclick="up({{$v['id']}})">{{$v['name']}} <input type="text" value="{{$v['name']}}"class="up  {{'up'.$v['id']}}" onblur="ups({{$v['id']}})" ></td>
            <td>{{$v['password']}}</td>
            <td>{{$v['type']}}</td>
            <td>{{$v['province'].$v['city'].$v['area'].$v['town'].$v['desc']}}</td>
            <td>
                @if($v['is_status']==0)
                    <b style="color: #43ff1d">开机</b>
                @elseif($v['is_status']==1)
                    <b style="color: red">异常</b>
                @elseif($v['is_status']==2)
                    <b style="color: #0608ff">关机</b>
                @endif
                </td>
            <td>{{$v['boot_time']}}</td>
            <td> {{$v['off_time']}} </td>
            <td>{{$v['time']}}</td>
            <td>
                @foreach($site as $kk=>$vv)
                    @if($vv['id']==$v['site_id'])
                        {{$vv['site_name']}}
                    @endif
                @endforeach
            </td>
            <td>
                <form class="layui-form" action="">
                    @if($username['super']==2)
                        @if($v['audit']==2)
                            <a href="#" onclick="upstatus({{$v['id']}})"> <input type="checkbox" name="zzz" class="status{{$v['id']}}"
                                                                                 value="{{$v['audit']}}" checked lay-skin="switch" lay-text="已审|未审"@if($username['super']!=2)disabled @endif ></a>
                        @else
                            <a href="#" onclick="upstatus({{$v['id']}})"> <input type="checkbox" name="zzz" class="status{{$v['id']}}" value="{{$v['audit']}}" lay-skin="switch" lay-text="已审|未审"@if($username['super']!=2)disabled @endif ></a>
                        @endif
                        @else
                        @if($v['audit']==2)
                           <input type="checkbox" name="zzz" class="status{{$v['id']}}" value="{{$v['audit']}}" checked lay-skin="switch" lay-text="已审|未审"@if($username['super']!=2)disabled @endif >
                        @else
                            <input type="checkbox" name="zzz" class="status{{$v['id']}}" value="{{$v['audit']}}" lay-skin="switch" lay-text="已审|未审"@if($username['super']!=2)disabled @endif >
                        @endif
                    @endif

                </form>
            </td>

            <td><div class="layui-btn-group">

                    <a href="/facility?id={{$v['id']}}"><button type="button" class="layui-btn layui-btn-sm">
                            <i class="layui-icon">&#xe642;</i>
                        </button></a>


                    <button type="button" class="layui-btn layui-btn-sm"  onclick="del({{$v['id']}})"  >
                        <i class="layui-icon">&#xe640;</i>
                    </button>

                </div></td>
        </tr>

        @endforeach

        </tbody>

    </table>
    <div style="text-align: center">
        <div class="layui-inline">
            {{$facility->appends(['name'=>$name])-> links()}}
        </div>
    </div>

    <hr>
    <a href="/facility"> <button type="button" class="layui-btn">
            <i class="layui-icon">&#xe608;</i> 添加
        </button></a>





    @if(empty($arr))
    <form class="layui-form" action="">

        <div class="layui-form-item" style="width: 50%">
            <label class="layui-form-label" style="width: 13%">设备ID</label>
            <div class="layui-input-block">
                <input type="text" name="sole" required  lay-verify="required" value="{{$str}}" autocomplete="off" class="layui-input" readonly   >
            </div>
        </div>
        <div class="layui-form-item" style="width: 50%">
            <label class="layui-form-label" style="width: 13%">设备类型</label>
            <div class="layui-input-block">
                <input type="text" name="type" required  lay-verify="required" placeholder="如:政府机关、商业广告、等" autocomplete="off" class="layui-input"  >
            </div>
        </div>
        <div class="layui-form-item" style="width: 50%">
            <label class="layui-form-label" style="width: 13%">设备名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" required  lay-verify="required" placeholder="请输入设备名称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item" style="width: 50%">
            <label class="layui-form-label" style="width: 13%">设备密码</label>
            <div class="layui-input-inline">
                <input type="password" name="password" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">辅助文字</div>
        </div>

        <div class="layui-form-item" style="width: 50%">
            <label class="layui-form-label" style="width: 13%">设备编号</label>
            <div class="layui-input-block">
                <input type="text" name="number" required  lay-verify="required" placeholder="请输入设备编号" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item" style="width: 50%">
            <label class="layui-form-label" style="width: 13%">WiFi开关</label>
            <div class="layui-input-block">
                <input type="checkbox" name="wifi" lay-skin="switch" lay-text="开启|关闭">
            </div>
        </div>
        <div class="layui-form-item" style="width: 50%">
            <label class="layui-form-label" style="width: 13%">设备亮度</label>
            <div class="layui-input-block" id="slideTest1">
            </div>
            <input type="hidden" name="luminance" id="luminance"  required  lay-verify="required" placeholder="请调整亮度" autocomplete="off" class="layui-input" >
        </div>
        <div class="layui-form-item" style="width: 50%">
            <label class="layui-form-label" style="width: 13%">设备音量</label>
            <div class="layui-input-block" id="slideTest2">
            </div>
            <input type="hidden" name="volume" id="volume"  required  lay-verify="required" placeholder="请调整音量" autocomplete="off" class="layui-input" >
        </div>

        <div class="layui-form-item" style="width: 50%">
            <label class="layui-form-label" style="width: 13%">开关机时间</label>
            <div class="layui-inline"> <!-- 注意：这一层元素并不是必须的 -->
                <input type="text" name="boot_time" class="layui-input" id="test1" placeholder="请输入开机时间">
            </div>

            <div class="layui-inline"> <!-- 注意：这一层元素并不是必须的 -->
                <input type="text" name="off_time" class="layui-input" id="test2" placeholder="请输入关机时间">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label "style="width: 7%">单位地址</label>
            <div class="layui-input-inline">
                <select id="province" name="province" lay-filter="province">
                    <option value="0">---请选择---</option>
                    <?php foreach($res as $k=>$v){ ?>
                    <option value="<?php echo $v['area_id'] ?>"><?php echo $v['area_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="layui-input-inline">
                <select id="city" name="city" lay-filter="city">
                    <option value="0">---请选择---</option>
                </select>
            </div>
            <div class="layui-input-inline">
                <select id="area" name="area" lay-filter="area">
                    <option value="0">---请选择---</option>
                </select>
            </div>
            <div class="layui-input-inline">
                <select id="town" name="town" lay-filter="town">
                    <option value="0">---请选择---</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label" style="width: 6%">详细地址</label>
            <div class="layui-input-block">
                <textarea name="desc" placeholder="请输入详细地址" class="layui-textarea"></textarea>
            </div>
        </div>


        @if($username['super']==2)
        <div class="layui-form-item" style="width: 50%">
            <label class="layui-form-label" style="width: 13%">通过审核</label>
            <div class="layui-input-block">
                <input type="checkbox" name="audit" lay-skin="switch" lay-text="通过|未通过">
            </div>
        </div>
        @endif
        <div class="layui-form-item" style="width: 50%">
            <label class="layui-form-label"style="width: 13%">绑定单位</label>
            <div class="layui-input-block">
                @foreach($site as $k=>$v)
                <input type="radio" name="site" value={{$v['id']}} title={{$v['site_name']}}>
                @endforeach
            </div>
        </div>


        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
  @else
        <form class="layui-form" action="">
            <input type="hidden" value="{{$arr['id']}}" name="id">
            <div class="layui-form-item" style="width: 50%">
                <label class="layui-form-label" style="width: 13%">设备ID</label>
                <div class="layui-input-block">
                    <input type="text" name="sole" required  lay-verify="required" value="{{$arr['sole']}}" autocomplete="off" class="layui-input" readonly   >
                </div>
            </div>
            <div class="layui-form-item" style="width: 50%">
                <label class="layui-form-label" style="width: 13%">设备类型</label>
                <div class="layui-input-block">
                    <input type="text" name="type" required  lay-verify="required" value="{{$arr['type']}}" placeholder="如:政府机关、商业广告、等" autocomplete="off" class="layui-input"  >
                </div>
            </div>

            <div class="layui-form-item" style="width: 50%">
                <label class="layui-form-label" style="width: 13%">设备名称</label>
                <div class="layui-input-block">
                    <input type="text" name="name" required value="{{$arr['name']}}"  lay-verify="required" placeholder="请输入设备名称" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item" style="width: 50%">
                <label class="layui-form-label" style="width: 13%">设备密码</label>
                <div class="layui-input-inline">
                    <input type="password" name="password" value="{{$arr['password']}}" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">辅助文字</div>
            </div>
            <div class="layui-form-item" style="width: 50%">
                <label class="layui-form-label" style="width: 13%">设备编号</label>
                <div class="layui-input-block">
                    <input type="text" name="number" required  value="{{$arr['number']}}" lay-verify="required" placeholder="请输入设备编号" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item" style="width: 50%">
                <label class="layui-form-label" style="width: 13%">WiFi开关</label>
                <div class="layui-input-block">
                    <input type="checkbox" @if($arr['wifi']==2) checked @else  @endif name="wifi" lay-skin="switch" lay-text="开启|关闭">
                </div>
            </div>

            <div class="layui-form-item" style="width: 50%">
                <label class="layui-form-label" style="width: 13%">设备亮度</label>
                <div class="layui-input-block" id="slideTest1">
                </div>
                <input type="hidden" name="luminance" id="luminance" value="{{$arr['luminance']}}"  required  lay-verify="required" placeholder="请调整亮度" autocomplete="off" class="layui-input" >
            </div>
            <div class="layui-form-item" style="width: 50%">
                <label class="layui-form-label" style="width: 13%">设备音量</label>
                <div class="layui-input-block" id="slideTest2">
                </div>
                <input type="hidden" name="volume" id="volume" value="{{$arr['volume']}}" required  lay-verify="required" placeholder="请调整音量" autocomplete="off" class="layui-input" >
            </div>

            <div class="layui-form-item" style="width: 50%">
                <label class="layui-form-label" style="width: 13%">开关机时间</label>
                <div class="layui-inline"> <!-- 注意：这一层元素并不是必须的 -->
                    <input type="text" name="boot_time" value="{{$arr['boot_time']}}" class="layui-input" id="test1" placeholder="请输入开机时间">
                </div>

                <div class="layui-inline"> <!-- 注意：这一层元素并不是必须的 -->
                    <input type="text" name="off_time"value="{{$arr['off_time']}}" class="layui-input" id="test2" placeholder="请输入关机时间">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label "style="width: 7%">单位地址</label>
                <div class="layui-input-inline">
                    <select id="province" name="province" lay-filter="province">
                        <option value="{{$arr['province']}}">---请选择---</option>
                        <?php foreach($res as $k=>$v){ ?>
                        <option value="<?php echo $v['area_id'] ?>" @if( $v['area_name']==$arr['province']) selected @endif><?php echo $v['area_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="layui-input-inline">
                    <select id="city" name="city" lay-filter="city">
                        <option value="{{$arr['city']}}">---请选择---</option>
                    </select>
                </div>
                <div class="layui-input-inline">
                    <select id="area" name="area" lay-filter="area">
                        <option value="{{$arr['area']}}">---请选择---</option>
                    </select>
                </div>
                <div class="layui-input-inline">
                    <select id="town" name="town" lay-filter="town">
                        <option value="{{$arr['town']}}">---请选择---</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label" style="width: 6%">详细地址</label>
                <div class="layui-input-block" style="height: 50%;width: 50%">
                    <textarea name="desc" placeholder="请输入详细地址" class="layui-textarea">{{$arr['desc']}}</textarea>
                </div>
            </div>

            @if($username['super']==2)
            <div class="layui-form-item" style="width: 50%">
                <label class="layui-form-label" style="width: 13%">通过审核</label>
                <div class="layui-input-block">
                    <input type="checkbox" @if($arr['audit']==2) checked @else  @endif name="audit" lay-skin="switch" lay-text="通过|未通过">
                </div>
            </div>
            @endif
            <div class="layui-form-item" style="width: 50%">
                <label class="layui-form-label"style="width: 13%">绑定单位</label>
                <div class="layui-input-block">
                    @foreach($site as $k=>$v)
                        @if($v['id']==$arr['site_id'])
                        <input type="radio" name="site" checked  value={{$v['id']}} title={{$v['site_name']}}>
                        @else
                        <input type="radio" name="site" value={{$v['id']}} title={{$v['site_name']}}>
                        @endif
                    @endforeach
                </div>
            </div>


            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn layui-btn-warm" lay-submit lay-filter="formDemo">立即修改</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
        @endif
    <script>
        $('.up').hide();
        //Demo
        layui.use(['form','laydate','slider'], function(){
            var form = layui.form;
            var laydate = layui.laydate;
            var slider = layui.slider;
            // 地址监听-省
            form.on('select(province)', function(data) {
                var parent_id =data.value;
                $.ajax({
                    type: "post",
                    url: '/facility',
                    data:{parent_id:parent_id},
                    dataType: "json",
                    success: function(res) {
                        var _option="";
                        for(var i in res){
                            _option+="<option value='"+res[i]['area_id']+"'>"+res[i]['area_name']+"</option>";
                        }
                        $("#city").append().html("<option value=\"0\">---请选择---</option>");
                        $("#city").append(_option);
                        $("#area").append().html("<option value=\"0\">---请选择---</option>");
                        $("#town").append().html("<option value=\"0\">---请选择---</option>");
                        form.render();
                    }
                });
            });

            // 地址监听-市
            form.on('select(city)', function(data) {
                var parent_id =data.value;
                $.ajax({
                    type: "post",
                    url: '/facility',
                    data:{parent_id:parent_id},
                    dataType: "json",
                    success: function(res) {
                        var _option="";
                        for(var i in res){
                            _option+="<option value='"+res[i]['area_id']+"'>"+res[i]['area_name']+"</option>";
                        }
                        $("#area").append().html("<option value=\"0\">---请选择---</option>");
                        $("#area").append(_option);
                        $("#town").append().html("<option value=\"0\">---请选择---</option>");
                        form.render();
                    }
                });
            });

            // 地址监听-区县
            form.on('select(area)', function(data) {
                var parent_id =data.value;
                $.ajax({
                    type: "post",
                    url: '/facility',
                    data:{parent_id:parent_id},
                    dataType: "json",
                    success: function(res) {
                        var _option="";
                        for(var i in res){
                            _option+="<option value='"+res[i]['area_id']+"'>"+res[i]['area_name']+"</option>";
                        }
                        $("#town").append().html("<option value=\"0\">---请选择---</option>");
                        $("#town").append(_option);
                        form.render();
                    }
                });
            });

            // 地址监听-区县
            form.on('select(town)', function(data) {
                var parent_id =data.value;
                $.ajax({
                    type: "post",
                    url: '/facility',
                    data:{parent_id:parent_id},
                    dataType: "json",
                    success: function(res) {
                        console.log(res);
                    }
                });
            });

            //设备亮度
            var ins1=slider.render({
                elem: '#slideTest1'
               // , range:true
                ,change: function(value){
                    $('#luminance').val(value)
                    console.log(value) //动态获取滑块数值
                    //do something
                }
            });
            ins1.setValue($('#luminance').val())
            //设备音量
            var ins2=slider.render({
                elem: '#slideTest2'
                ,change: function(value){
                    $('#volume').val(value)
                    console.log(value) //动态获取滑块数值
                    //do something
                }
            });
            ins2.setValue( $('#volume').val())
            //执行开机时间实例
            laydate.render({
                elem: '#test1' //指定元素
                ,type: 'time'
            });
            //执行关机时间实例
            laydate.render({
                elem: '#test2' //指定元素
                ,type: 'time'
            });
            //监听提交
            form.on('submit(formDemo)', function(data){

                    if(data.field.audit=='on'){
                        data.field.audit=2;
                    }
                    if(data.field.audit==undefined){
                    data.field.audit=1;
                    }
                    if(data.field.wifi=='on'){
                    data.field.wifi=2;
                    }
                    if(data.field.wifi==undefined){
                    data.field.wifi=1;
                    }
                    if(data.field.site==undefined){
                    data.field.site='';
                    }
                var  arr={
                    id:data.field.id,
                    type:data.field.type,
                    sole:data.field.sole,
                    name:data.field.name,
                    password:data.field.password,
                    number:data.field.number,
                    luminance:data.field.luminance,
                    volume:data.field.volume,
                    boot_time:data.field.boot_time,
                    off_time:data.field.off_time,
                    audit:data.field.audit,
                    wifi:data.field.wifi,
                    site_id:data.field.site,

                    province:data.field.province,
                    city:data.field.city,
                    area:data.field.area,
                    town:data.field.town,
                    desc:data.field.desc,
                }

                $.ajax({
                    type: "post",
                    url: '/facilityadd',
                    data:arr,
                    dataType: "json",
                    success: function(res) {
                        layer.msg(res.msg, {icon: res.icon});
                        //layer.alert(res.msg, { icon: res.icon, time: 4000, offset: 't', closeBtn: 0, title: '提醒您', btn: [], anim: 2, shade: 0 })
                        location.reload();
                    },
                    error:function(){
                        alert('失败')
                    }
                });
                return false;
            });
        });
        //监听删除
        function del(id){
            layer.confirm('确认删除吗?', {icon: 2, title:'提示'}, function(index){
                layer.close(index);
                $.ajax({
                    type: "post",
                    url: '/facilitydel',
                    data:{id:id},
                    dataType: "json",
                    success: function(res) {
                        layer.alert(res.msg, { icon: res.icon, time: 4000, offset: 't', closeBtn: 0, title: '提醒您', btn: [], anim: 2, shade: 0 })
                        if(res.icon=1){
                            $('.'+id).remove();
                        }
                    }
                });
            });
        }
        //监听 显示文本框   点击事件
        function up(id){
            $('.up'+id).show().focus();
        }
        //监听 修改文本框   失去焦点事件
        function ups(id){
            $('.up'+id).hide();
            // layer.confirm('确定修改吗?', {icon: 3, title:'提示'}, function(index){
            //        layer.close(index);
            var name=$('.up'+id).val();
            $.ajax({
                type: "post",
                url: '/facilityup',
                data:{id:id,name:name},
                dataType: "json",
                success: function(res) {
                    layer.alert(res.msg, { icon: res.icon, time: 4000, offset: 't', closeBtn: 0, title: '提醒您', btn: [], anim: 2, shade: 0 })
                    if(res.icon=1){
                        parent.location.reload()

                    }
                }
            });
            // });

        }
        //修改审核(及点及改)
        function upstatus(id){
            var audit=$('.status'+id).val();
            if(audit==2){
                audit=1;
            }else {
                audit=2;
            }
            // layer.confirm('确定修改吗?', {icon: 3, title:'提示'}, function(index){
            //        layer.close(index);
            $.ajax({
                type: "post",
                url: '/facilityup',
                data:{id:id,audit:audit},
                dataType: "json",
                success: function(res) {
                    layer.alert(res.msg, { icon: res.icon, time: 4000, offset: 't', closeBtn: 0, title: '提醒您', btn: [], anim: 2, shade: 0 })
                    if(res.icon=1){
                        parent.location.reload()

                    }
                }
            });
            // });

        }

    </script>
@endsection






