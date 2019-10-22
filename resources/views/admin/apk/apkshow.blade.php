@extends('admin.layout')
@section('content')
    <form action="/apk" method="post">
        <input type="text" name="name" placeholder="请输入版本名称">
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
            <th>名称</th>
            <th>apk</th>
            <th>全部更新</th>
            <th>更新时间</th>
            <th>添加时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($apk as $k=>$v)
        <tr class="{{$v['id']}}">
            <td>{{$v['id']}}</td>
            <td onclick="up({{$v['id']}})">{{$v['name']}} <input type="text" value="{{$v['name']}}"class="up  {{'up'.$v['id']}}" onblur="ups({{$v['id']}})" ></td>
            <td>{{$v['file_path']}}</td>
            <td>
                <form class="layui-form" action="">
                    @if($v['is_update']==1)
                        <a href="#" onclick="upstatus({{$v['id']}})"> <input type="checkbox" name="zzz" class="status{{$v['id']}}" value="{{$v['is_update']}}" checked lay-skin="switch" lay-text="是|否" ></a>
                    @else
                        <a href="#" onclick="upstatus({{$v['id']}})"> <input type="checkbox" name="zzz" class="status{{$v['id']}}" value="{{$v['is_update']}}" lay-skin="switch" lay-text="是|否" ></a>
                    @endif
                </form>


            </td>
            <td>{{$v['is_time']}}</td>
            <td>{{$v['time']}}</td>
            <td>
                <div class="layui-btn-group">
                    <a href="/apk?id={{$v['id']}}"><button type="button" class="layui-btn layui-btn-sm">
                            <i class="layui-icon">&#xe642;</i>
                        </button></a>
                </div>
                <div class="layui-btn-group">
                    <button type="button" class="layui-btn layui-btn-sm"  onclick="del({{$v['id']}})"  >
                        <i class="layui-icon">&#xe640;</i>
                    </button>
                </div>

            </td>
        </tr>

        @endforeach

        </tbody>

    </table>
    <div style="text-align: center">
        <div class="layui-inline">
            {{$apk->appends(['name'=>$name]) -> links()}}
        </div>
    </div>

    <hr>
    <a href="/apk"> <button type="button" class="layui-btn">
            <i class="layui-icon">&#xe608;</i> 添加
        </button></a>

@if(empty($arr))
        <form class="layui-form" action="">
            <div class="layui-form-item" style="width: 50%">
                <label class="layui-form-label" style="width: 13%">名称</label>
                <div class="layui-input-inline" >
                    <input type="text" name="name" required   lay-verify="required" placeholder="请输入内容名称" autocomplete="off" class="layui-input"  >
                </div>
            </div>

            <div class="layui-form-item" style="width: 50%">
                <label class="layui-form-label" style="width: 13%">apk文件</label>
                <div class="layui-input-inline" id="test3">
                    <a href="#"><img src="/uploads/timg.jpg" alt="" style="width: 50%;height: 50%"></a>
                </div>

            </div>

            <div class="layui-form-item" style="width: 50%">
                <div class="layui-input-inline">
                    <input type="hidden" name="file_path" id="img" required  lay-verify="required"   autocomplete="off" class="layui-input" >
                </div>
                {{--<div class="layui-form-mid layui-word-aux">辅助文字</div>--}}
            </div>

            <div class="layui-form-item" style="width: 50%">
                <label class="layui-form-label" style="width: 13%">全部更新</label>
                <div class="layui-input-block">
                    <input type="checkbox" name="is_update" lay-skin="switch" lay-text="是|否" checked>
                </div>
            </div>

            <div class="layui-form-item" style="width: 50%">
                <label class="layui-form-label" style="width: 13%">更新时间</label>
                <div class="layui-inline"> <!-- 注意：这一层元素并不是必须的 -->
                    <input type="text" name="is_time" class="layui-input" id="test1" placeholder="请输入更新时间">
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
        <input type="hidden" name="id" value="{{$arr['id']}}">

        <div class="layui-form-item" style="width: 50%">
            <label class="layui-form-label" style="width: 13%">名称</label>
            <div class="layui-input-inline" >
                <input type="text" name="name" value="{{$arr['name']}}" required   lay-verify="required" placeholder="请输入内容名称" autocomplete="off" class="layui-input"  >
            </div>
        </div>

        <div class="layui-form-item" style="width: 50%">
            <label class="layui-form-label" style="width: 13%">apk文件</label>
            <div class="layui-input-inline" id="test3">
                <a href="#"><img src="{{$arr['file_path']}}" alt="" style="width: 50%;height: 50%"></a>
            </div>

        </div>

        <div class="layui-form-item" style="width: 50%">
            <div class="layui-input-inline">
                <input type="hidden" name="file_path"value="{{$arr['file_path']}}" id="img" required  lay-verify="required"   autocomplete="off" class="layui-input" >
            </div>
            {{--<div class="layui-form-mid layui-word-aux">辅助文字</div>--}}
        </div>

        <div class="layui-form-item" style="width: 50%">
            <label class="layui-form-label" style="width: 13%">全部更新</label>
            <div class="layui-input-block">
                @if($arr['is_update']==2)
                    <input type="checkbox" name="is_update" lay-skin="switch" lay-text="是|否" >
                @else
                    <input type="checkbox" name="is_update" lay-skin="switch" lay-text="是|否" checked>
                @endif
            </div>
        </div>

        <div class="layui-form-item" style="width: 50%">
            <label class="layui-form-label" style="width: 13%">更新时间</label>
            <div class="layui-inline"> <!-- 注意：这一层元素并不是必须的 -->
                <input type="text" name="is_time"value="{{$arr['is_time']}}" class="layui-input" id="test1" placeholder="请输入更新时间">
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
        layui.use(['form','laydate','upload'], function(){
            var form = layui.form;
            var laydate = layui.laydate;
            var upload = layui.upload;
            //单文件上传
            upload.render({
                elem: '#test3'
                ,url: '/upload'
                ,done: function(res, index, upload){ //上传后的回调
                    if(res.icon==1){
                        layer.msg(res.msg, {icon: res.icon});
                        $('#test3').html(" <img src='"+res.img+"' alt=''style='width: 50%;height: 50%'>")
                        $('#img').val(res.img)
                    }else{
                        layer.msg(res.msg, {icon: res.icon});
                    }

                }
                ,accept: 'file' //允许上传的文件类型
                //,size: 50 //最大允许上传的文件大小
                //,……
            })
            //执行开机时间实例
            laydate.render({
                elem: '#test1' //指定元素
                ,type: 'datetime'
            });


            //监听提交
            form.on('submit(formDemo)', function(data){
                if(data.field.is_update=='on'){
                    data.field.is_update=1;
                }
                if(data.field.is_update==undefined){
                    data.field.is_update=2;
                }
                var  arr={
                    id:data.field.id,
                    name:data.field.name,
                    file_path:data.field.file_path,
                    is_update:data.field.is_update,
                    is_time:data.field.is_time,
                }
                $.ajax({
                    type: "post",
                    url: '/apkadd',
                    data:arr,
                    dataType: "json",
                    success: function(res) {
                        layer.msg(res.msg, {icon: res.icon});
                        //layer.alert(res.msg, { icon: res.icon, time: 4000, offset: 't', closeBtn: 0, title: '提醒您', btn: [], anim: 2, shade: 0 })
                        location.reload();
                    },
                    error:function(){
                        layer.msg('失败', {icon: 2});
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
                    url: '/apkdel',
                    data:{id:id},
                    dataType: "json",
                    success: function(res) {
                        layer.msg(res.msg, {icon: res.icon});
                       // layer.alert(res.msg, { icon: res.icon, time: 4000, offset: 't', closeBtn: 0, title: '提醒您', btn: [], anim: 2, shade: 0 })
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
             layer.confirm('确定修改吗?', {icon: 3, title:'提示'}, function(index){
                    layer.close(index);
            var name=$('.up'+id).val();
            $.ajax({
                type: "post",
                url: '/apkup',
                data:{id:id,name:name},
                dataType: "json",
                success: function(res) {
                    layer.msg(res.msg, {icon: res.icon});
                   // layer.alert(res.msg, { icon: res.icon, time: 4000, offset: 't', closeBtn: 0, title: '提醒您', btn: [], anim: 2, shade: 0 })
                    if(res.icon=1){
                        parent.location.reload()

                    }
                }
            });
             });

        }
        //修改审核(及点及改)
        function upstatus(id){
            var is_update=$('.status'+id).val();
            if(is_update==2){
                is_update=1
            }else {
                is_update=2
            }
//             layer.confirm('确定修改吗?', {icon: 3, title:'提示'}, function(index){
//                    layer.close(index);
            $.ajax({
                type: "post",
                url: '/apkup',
                data:{id:id,is_update:is_update},
                dataType: "json",
                success: function(res) {
                    layer.msg(res.msg, {icon: res.icon});
                    //layer.alert(res.msg, { icon: res.icon, time: 4000, offset: 't', closeBtn: 0, title: '提醒您', btn: [], anim: 2, shade: 0 })
                    if(res.icon=1){
                        parent.location.reload()

                    }
                }
            });
//             });

        }



    </script>
@endsection






