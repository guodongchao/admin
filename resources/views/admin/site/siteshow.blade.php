@extends('admin.layout')
@section('content')
    <form action="/site" method="get">
        <input type="text" name="site_name" placeholder="请输入单位名称">
        <button class="layui-btn layui-btn-sm">搜索</button>
    </form>

    <table class="layui-table">
        <colgroup>
            <col width="150">
            <col width="200">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>ID</th>
            <th>单位名称</th>
            <th>单位地址</th>
            <th>详细地址</th>
            <th>单位设备</th>
            <th>添加时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($site as $k=>$v){ ?>

        <tr class="<?php echo $v['id'] ?>">
            <td><?php echo $v['id'] ?></td>
            <td onclick="up(<?php echo $v['id'] ?>)"><?php echo $v['site_name'] ?> <input type="text" value="<?php echo $v['site_name'] ?>"class="up <?php echo 'up'.$v['id'] ?>" onblur="ups(<?php echo $v['id'] ?>)" ></td>
            <td><?php echo $v['province'].$v['city'].$v['area'].$v['town'] ?></td>
            <td> <?php echo $v['desc'] ?> </td>
            <td> <?php echo $v['facility'] ?> </td>
            <td><?php echo $v['time'] ?></td>
            <td><div class="layui-btn-group">
                    
                    <a href="/site?id=<?php echo $v['id'] ?>"><button type="button" class="layui-btn layui-btn-sm">
                            <i class="layui-icon">&#xe642;</i>
                        </button></a>


                    <button type="button" class="layui-btn layui-btn-sm"  onclick="del(<?php echo $v['id'] ?>)"  >
                        <i class="layui-icon">&#xe640;</i>
                    </button>
                   
                </div></td>
        </tr>

        <?php } ?>

        </tbody>

    </table>
    <div style="text-align: center">
        <div class="layui-inline">
            {{$site->appends(['site_name'=>$site_name]) -> links()}}
        </div>
    </div>

    <hr>
    <a href="/site"> <button type="button" class="layui-btn">
            <i class="layui-icon">&#xe608;</i> 添加
        </button></a>
    @if(empty($arr))
        <form class="layui-form" action="">
            <div class="layui-form-item" style="width: 50%">
                <label class="layui-form-label" style="width: 13%">单位名称</label>
                <div class="layui-input-block">
                    <input type="text" name="title" required  lay-verify="required" placeholder="请输入单位名称" autocomplete="off" class="layui-input">
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
                <label class="layui-form-label" style="width: 13%">单位名称</label>
                <div class="layui-input-block">
                    <input type="text" name="title" required  lay-verify="required" placeholder="请输入单位名称" autocomplete="off" class="layui-input" value="{{$arr['site_name']}}">
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
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn layui-btn-warm" lay-submit lay-filter="formDemo">立即修改</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
     @endif

    <script>
        //Demo
        $('.up').hide();
        layui.use('form', function(){
            var form = layui.form;
            // 地址监听-省
            form.on('select(province)', function(data) {
                var parent_id =data.value;
                $.ajax({
                    type: "post",
                    url: '/site',
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
                    url: '/site',
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
                    url: '/site',
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
                    url: '/site',
                    data:{parent_id:parent_id},
                    dataType: "json",
                    success: function(res) {
                        console.log(res);
                    }
                });
            });

            //监听提交
            form.on('submit(formDemo)', function(data){

              var  arr={
                        id:data.field.id,
                        area:data.field.area,
                        city:data.field.city,
                        desc:data.field.desc,
                        province:data.field.province,
                        title:data.field.title,
                        town:data.field.town
                    }
                $.ajax({
                    type: "post",
                    url: '/siteadd',
                    data:arr,
                    dataType: "json",
                    success: function(res) {
                        layer.alert(res.msg, { icon: res.icon, time: 4000, offset: 't', closeBtn: 0, title: '提醒您', btn: [], anim: 2, shade: 0 })
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
                    url: '/sitedel',
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
                var site_name=$('.up'+id).val();
                $.ajax({
                    type: "post",
                    url: '/siteup',
                    data:{id:id,site_name:site_name},
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






