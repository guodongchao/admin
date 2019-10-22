@extends('admin.layout')
@section('content')
    <table class="layui-table">
        <colgroup>
            <col width="10">
            <col width="10">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>ID</th>
            <th>内容名称</th>
            <th>内容图片</th>
            <th>添加时间</th>
            <th>模块名称</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($moduleson as $k=>$v)
        <tr class="{{$v['id']}}">
            <td>{{$v['id']}}</td>
            @if($arr['type']==0)
                <td onclick="up({{$v['id']}})">{{$v['name']}} <input type="text" value="{{$v['name']}}"class="up  {{'up'.$v['id']}}" onblur="ups({{$v['id']}})" ></td>
                <td><img src="{{$v['img']}}" alt=""></td>
            @elseif($arr['type']==1)
                <td><img src="{{$v['img']}}" alt=""></td>
                <td onclick="up({{$v['id']}})">{{$v['name']}} <input type="text" value="{{$v['name']}}"class="up  {{'up'.$v['id']}}" onblur="ups({{$v['id']}})" ></td>
            @elseif($arr['type']==2)
                <td><img src="{{$v['img']}}" alt=""></td>
                <td><img src="{{$v['name']}}" alt=""></td>
            @endif



            <td>{{$v['time']}}</td>
            <td>{{$arr['name']}}</td>
            <td>
                <div class="layui-btn-group">
                    <a href="/moduleson?module_id={{$v['id']}}&id={{$arr['id']}}"><button type="button" class="layui-btn layui-btn-sm">
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
            {{--{{$moduleson -> links()}}--}}
        </div>
    </div>

    <hr>
    <a href="/moduleson?id={{$arr['id']}}"> <button type="button" class="layui-btn">
            <i class="layui-icon">&#xe608;</i> 添加
        </button></a>

@if(empty($arrson))
        <form class="layui-form" action="">
            <div class="layui-form-item" style="width: 50%">
                <label class="layui-form-label" style="width: 13%">模块图片</label>
                <div class="layui-input-inline" >
                    <a href="#"><img src="{{$arr['img']}}" alt="" style="width: 50%;height: 50%"></a>
                </div>
            </div>

            <div class="layui-form-item" style="width: 50%">
                <label class="layui-form-label" style="width: 13%">模块名称</label>
                <div class="layui-input-inline">
                    <select id="module" name="module" lay-filter="module">
                        <?php foreach($module as $k=>$v){ ?>
                        <option value="{{$v['id']}}" @if($arr['id']==$v['id']) selected @endif >{{$v['name']}}</option>
                        <?php } ?>
                    </select>
                </div>

            </div>

            {{--<div class="layui-form-item" style="width: 50%">--}}
                {{--<label class="layui-form-label" style="width: 13%">模块类型</label>--}}
                {{--<div class="layui-input-inline" >--}}
                    {{--<input type="text" value="{{$arr['type']}}" name="type" readonly>--}}
                {{--</div>--}}
            {{--</div>--}}
        @if($arr['type']==0)
            <div class="layui-form-item" style="width: 50%">
                <label class="layui-form-label" style="width: 13%">内容名称</label>
                <div class="layui-input-inline" >
                    <input type="text" name="name" required  lay-verify="required" placeholder="请输入内容名称" autocomplete="off" class="layui-input"  >
                </div>
                <div class="layui-input-inline" id="test3">
                    <a href="#"><img src="/uploads/timg.jpg" alt="" style="width: 50%;height: 50%"></a>
                </div>
            </div>
        @elseif($arr['type']==1)
                <div class="layui-form-item" style="width: 50%">
                    <label class="layui-form-label" style="width: 13%">内容图片</label>
                    <div class="layui-input-inline" id="test3">
                        <a href="#"><img src="/uploads/timg.jpg" alt="" style="width: 50%;height: 50%"></a>
                    </div>
                </div>

                <div class="layui-form-item" style="width: 50%">
                    <label class="layui-form-label" style="width: 13%">内容名称</label>
                    <div class="layui-input-inline" >
                        <input type="text" name="name" required  lay-verify="required" placeholder="请输入内容名称" autocomplete="off" class="layui-input"  >
                    </div>
                </div>
        @elseif($arr['type']==2)
                <div class="layui-form-item" style="width: 50%">
                    <label class="layui-form-label" style="width: 13%">内容图片</label>
                    <div class="layui-input-inline" id="test3">
                        <a href="#"><img src="/uploads/timg.jpg" alt="" style="width: 50%;height: 50%"></a>
                    </div>
                </div>

                <div class="layui-form-item" style="width: 50%">
                    <label class="layui-form-label" style="width: 13%">内容图片</label>
                    <div class="layui-input-inline" id="test4">
                        <a href="#"><img src="/uploads/timg.jpg" alt="" style="width: 50%;height: 50%"></a>
                    </div>
                </div>

                <div class="layui-form-item" style="width: 50%">
                    <div class="layui-input-inline">
                        <input type="hidden" name="name" id="imgs" required  lay-verify="required"   autocomplete="off" class="layui-input" >
                    </div>
                    {{--<div class="layui-form-mid layui-word-aux">辅助文字</div>--}}
                </div>
        @endif
            <div class="layui-form-item" style="width: 50%">
                <div class="layui-input-inline">
                    <input type="hidden" name="img" id="img" required  lay-verify="required"   autocomplete="off" class="layui-input" >
                </div>
                {{--<div class="layui-form-mid layui-word-aux">辅助文字</div>--}}
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
        <input type="hidden" name="id" value="{{$arrson['id']}}">
        <div class="layui-form-item" style="width: 50%">
            <label class="layui-form-label" style="width: 13%">模块图片</label>
            <div class="layui-input-inline" >
                <a href="#"><img src="{{$arr['img']}}" alt="" style="width: 50%;height: 50%"></a>
            </div>
        </div>

        <div class="layui-form-item" style="width: 50%">
            <label class="layui-form-label" style="width: 13%">模块名称</label>
            <div class="layui-input-inline">
                <select id="module" name="module" lay-filter="module">
                    <?php foreach($module as $k=>$v){ ?>
                    <option value="{{$v['id']}}" @if($arr['id']==$v['id']) selected @endif >{{$v['name']}}</option>
                    <?php } ?>
                </select>
            </div>

        </div>

        <div class="layui-form-item" style="width: 50%">
            <label class="layui-form-label" style="width: 13%">模块类型</label>
            <div class="layui-input-inline" >
                <input type="text" value="{{$arr['type']}}" name="type" readonly>
            </div>
        </div>

        <div class="layui-form-item" style="width: 50%">
            <label class="layui-form-label" style="width: 13%">内容名称</label>
            <div class="layui-input-inline" >
                <input type="text" name="name" required value="{{$arrson['name']}}"  lay-verify="required" placeholder="请输入内容名称" autocomplete="off" class="layui-input"  >
            </div>
        </div>

        <div class="layui-form-item" style="width: 50%">
            <label class="layui-form-label" style="width: 13%">内容图片</label>
            <div class="layui-input-inline" id="test3">
                <a href="#"><img src="{{$arrson['img']}}" alt="" style="width: 50%;height: 50%"></a>
            </div>
        </div>

        <div class="layui-form-item" style="width: 50%">
            <div class="layui-input-inline">
                <input type="hidden" name="img" id="img" value="{{$arrson['img']}}"   autocomplete="off" class="layui-input" >
            </div>
            {{--<div class="layui-form-mid layui-word-aux">辅助文字</div>--}}
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
                ,url: 'upload'
                ,done: function(res, index, upload){ //上传后的回调
                    if(res.icon==1){
                        layer.msg(res.msg, {icon: res.icon});
                        $('#test3').html(" <img src='"+res.img+"' alt=''style='width: 50%;height: 50%'>")
                        $('#img').val(res.img)
                    }else{
                        layer.msg(res.msg, {icon: res.icon});
                    }

                }
                //,accept: 'file' //允许上传的文件类型
                //,size: 50 //最大允许上传的文件大小
                //,……
            })
            //单文件上传
            upload.render({
                elem: '#test4'
                ,url: 'upload'
                ,done: function(res, index, upload){ //上传后的回调
                    if(res.icon==1){
                        layer.msg(res.msg, {icon: res.icon});
                        $('#test4').html(" <img src='"+res.img+"' alt=''style='width: 50%;height: 50%'>")
                        $('#imgs').val(res.img)
                    }else{
                        layer.msg(res.msg, {icon: res.icon});
                    }

                }
                //,accept: 'file' //允许上传的文件类型
                //,size: 50 //最大允许上传的文件大小
                //,……
            })
            // 模块名称-下拉菜单
            form.on('select(module)', function(data) {
                var id =data.value;
                location.href="/moduleson?id="+id;
            });
            //监听提交
            form.on('submit(formDemo)', function(data){

                var  arr={
                    id:data.field.id,
                    module_id:data.field.module,
                    type:data.field.type,
                    name:data.field.name,
                    img:data.field.img,
                }
                $.ajax({
                    type: "post",
                    url: '/modulesonadd',
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
                    url: '/modulesondel',
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
                url: '/modulesonup',
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
            var audit=$('.status'+id).val();
            if(audit==2){
                audit=''
            }else {
                audit=2
            }
//             layer.confirm('确定修改吗?', {icon: 3, title:'提示'}, function(index){
//                    layer.close(index);
            $.ajax({
                type: "post",
                url: '/moduleup',
                data:{id:id,audit:audit},
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






