@extends('admin.layout')
@section('content')
    <form action="/module" method="post">
        <input type="text" name="name" placeholder="请输入模块名称">
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
            <th>模块名称</th>
            <th>模块图片</th>
            <th>排序</th>
            <th>绑定单位</th>
            <th>添加时间</th>
            <th>审核</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($module as $k=>$v)

        <tr class="{{$v['id']}}">
            <td>{{$v['id']}}</td>
            <td onclick="up({{$v['id']}})">{{$v['name']}} <input type="text" value="{{$v['name']}}"class="up  {{'up'.$v['id']}}" onblur="ups({{$v['id']}})" ></td>
            <td><img src="{{$v['img']}}" alt=""></td>

            <td>{{$v['rank']}}</td>
            <td>
                @foreach($v['site_id'] as $kkk=>$vvv)
                @foreach($site as $kk=>$vv)
                    @if($vv['id']==$vvv)
                        {{$vv['site_name']}}
                    @endif
                @endforeach
                @endforeach
            </td>
            <td>{{$v['time']}}</td>

            <td>
                <form class="layui-form" action="">
                    @if($username['super']==2)
                    @if($v['audit']==2)
                        <a href="#" onclick="upstatus({{$v['id']}})"> <input type="checkbox" name="zzz" class="status{{$v['id']}}" value="{{$v['audit']}}" checked lay-skin="switch" lay-text="已审|未审" @if($username['super']!=2)disabled @endif></a>
                    @else
                        <a href="#" onclick="upstatus({{$v['id']}})"> <input type="checkbox" name="zzz" class="status{{$v['id']}}" value="{{$v['audit']}}" lay-skin="switch" lay-text="已审|未审" @if($username['super']!=2)disabled @endif></a>
                    @endif
                    @else
                        @if($v['audit']==2)
                           <input type="checkbox" name="zzz" class="status{{$v['id']}}" value="{{$v['audit']}}" checked lay-skin="switch" lay-text="已审|未审" @if($username['super']!=2)disabled @endif>
                        @else
                           <input type="checkbox" name="zzz" class="status{{$v['id']}}" value="{{$v['audit']}}" lay-skin="switch" lay-text="已审|未审" @if($username['super']!=2)disabled @endif>
                        @endif
                    @endif
                </form>
            </td>
            <td>
                <div class="layui-btn-group">
                    <a href="moduleson?id={{$v['id']}}"><button type="button" class="layui-btn layui-btn-sm">
                            <i class="layui-icon">&#xe654;</i>
                        </button></a>
                </div>
                <div class="layui-btn-group">
                    <a href="/module?id={{$v['id']}}"><button type="button" class="layui-btn layui-btn-sm">
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
            {{$module->appends(['name'=>$name]) -> links()}}
        </div>
    </div>

    <hr>
    <a href="/module"> <button type="button" class="layui-btn">
            <i class="layui-icon">&#xe608;</i> 添加
        </button></a>





    @if(empty($arr))
    <form class="layui-form" action="">
        <div class="layui-form-item" style="width: 50%">
            <label class="layui-form-label" style="width: 13%">模块名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" required  lay-verify="required" placeholder="请输入模块名称" autocomplete="off" class="layui-input"    >
            </div>
        </div>

        <div class="layui-form-item" style="width: 50%">
            <label class="layui-form-label" style="width: 13%">模块类型</label>
            <div class="layui-input-block">
                <input type="text" name="type" required  lay-verify="required" placeholder="默认（0 左字右图片）（1 右图左文字）（2 双图） 注意：一旦定义无法修改" autocomplete="off" class="layui-input"  >
                {{--<div class="layui-form-mid layui-word-aux">默认（0 左字右图片）（1 右图左文字）（2 双图） 注意：一旦定义无法修改</div>--}}
            </div>
        </div>

        <div class="layui-form-item" style="width: 50%">
            <label class="layui-form-label" style="width: 13%">排序</label>
            <div class="layui-input-block">
                <input type="text" name="rank" required  lay-verify="required" placeholder="根据数字大小排序" autocomplete="off" class="layui-input"  >
            </div>
        </div>
        <div class="layui-form-item" style="width: 50%">
            <label class="layui-form-label" style="width: 13%">模块图片</label>
            <div class="layui-input-inline"id="test3">
                <a href="#"><img src="/uploads/timg (1).jpg" alt="" style="width: 50%;height: 50%"></a>
            </div>
        </div>
        <div class="layui-form-item" style="width: 50%">
            <div class="layui-input-inline">
                <input type="hidden" name="filename" id="filename"   autocomplete="off" class="layui-input" >
            </div>
            {{--<div class="layui-form-mid layui-word-aux">辅助文字</div>--}}
        </div>
        <div class="layui-form-item" style="width: 50%">
            <div class="layui-input-inline">
                <input type="hidden" name="img" id="img"   autocomplete="off" class="layui-input" >
            </div>
            {{--<div class="layui-form-mid layui-word-aux">辅助文字</div>--}}
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
            <div class="layui-input-block" >
                @foreach($site as $s=>$t)
                    <div>
                        <input type="checkbox" name="site" class="parent"   value={{$t['id']}} title={{$t['site_name']}}>
                            <div class="layui-input-block">
                                @foreach($t['son'] as $k=>$v)
                                    @foreach($v['son'] as $kk=>$vv)
                                       <input type="checkbox" name="facility" value={{$vv['id']}} title={{$vv['name']}}>
                                    @endforeach
                                @endforeach

                            </div>
                    </div>
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
                <label class="layui-form-label" style="width: 13%">模块名称</label>
                <div class="layui-input-block">
                    <input type="text" name="name" required value="{{$arr['name']}}"  lay-verify="required" placeholder="请输入设备名称" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item" style="width: 50%">
                <label class="layui-form-label" style="width: 13%">模块类型</label>
                <div class="layui-input-block" >
                    <input type="text" name="type" required value="{{$arr['type']}} "lay-verify="required" placeholder="默认（0 左字右图片）（1 右图左文字）（2 双图） 注意：一旦定义无法修改" autocomplete="off" class="layui-input" readonly >
                    <div class="layui-form-mid layui-word-aux">默认（0 左字右图片）（1 右图左文字）（2 双图） 注意：一旦定义无法修改</div>
                </div>

            </div>

            <div class="layui-form-item" style="width: 50%">
                <label class="layui-form-label" style="width: 13%">排序</label>
                <div class="layui-input-block">
                    <input type="text" name="rank" required value="{{$arr['rank']}}" lay-verify="required" placeholder="根据数字大小排序" autocomplete="off" class="layui-input"  >
                </div>
            </div>

            <div class="layui-form-item" style="width: 50%">
                <label class="layui-form-label" style="width: 13%">模块图片</label>
                <div class="layui-input-inline"id="test3">
                    <a href="#"><img src="{{$arr['img']}}" alt="" style="width: 50%;height: 50%"></a>
                </div>
            </div>
            <div class="layui-form-item" style="width: 50%">
                <div class="layui-input-inline">
                    <input type="hidden" name="filename" id="filename" value="{{$arr['filename']}}"   autocomplete="off" class="layui-input" >
                </div>
                {{--<div class="layui-form-mid layui-word-aux">辅助文字</div>--}}
            </div>
            <div class="layui-form-item" style="width: 50%">
                <div class="layui-input-inline">
                    <input type="hidden" name="img" id="img" value="{{$arr['img']}}"   autocomplete="off" class="layui-input" >
                </div>
                {{--<div class="layui-form-mid layui-word-aux">辅助文字</div>--}}
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

                    @foreach($site as $ss=>$tt)
                    <div>
                        <input type="checkbox" name="site"class="parent"
                               @foreach($modules as $m=>$d)
                               @foreach($d['site_id'] as $mm=>$dd)
                               @if($d['id']==$arr['id'])
                               @if($dd==$tt['id'])
                                checked
                               @endif
                               @endif
                               @endforeach
                               @endforeach
                               value={{$tt['id']}} title={{$tt['site_name']}} >

                        <div class="layui-input-block">
                            @foreach($tt['son'] as $k=>$v)
                                @foreach($v['son'] as $kk=>$vv)
                                    <input type="checkbox" name="facility"
                                           @foreach($facility_module as $ty=>$le)
                                            @if($le['module_id']==$arr['id'] &&$le['facility_id']==$vv['id'])
                                           checked
                                             @endif
                                           @endforeach
                                           value={{$vv['id']}} title={{$vv['name']}}>
                                @endforeach
                            @endforeach
                        </div>
                     </div>
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
        layui.use(['form','laydate','upload','table','jquery'], function(){
            var form = layui.form;
            var laydate = layui.laydate;
            var upload = layui.upload;
            var table = layui.table;
            var $=layui.jquery;

            form.on('checkbox()', function(data){
                var pc =  data.elem.classList //获取选中的checkbox的class属性

                /* checkbox处于选中状态  */
                if(data.elem.checked==true){//并且当前checkbox为选中状态
                    /*如果是parent节点 */
                    if(pc=="parent"){  //如果当前选中的checkbox class里面有parent
                        //获取当前checkbox的兄弟节点的孩子们是 input[type='checkbox']的元素
                        var c =$(data.elem).siblings().children("input[type='checkbox']");
                        c.each(function(){//遍历他们的孩子们
                            var e = $(this); //添加layui的选中的样式   控制台看元素
                            e.next().addClass("layui-form-checked");
                        });
                    }else{/*如果不是parent*/
                        //选中子级选中父级
                        $(data.elem).parent().prev().addClass("layui-form-checked");
                    }

                }else{    /*checkbox处于 false状态*/

                    //父级没有选中 取消所有的子级选中
                    if(pc=="parent"){/*判断当前取消的是父级*/
                        var c =$(data.elem).siblings().children("input[type='checkbox']");
                        c.each(function(){
                            var e = $(this);
                            e.next().removeClass("layui-form-checked")
                        });
                    }else{/*不是父级*/

                        var c = $(data.elem).siblings("div");
                        var count =0;
                        c.each(function(){//遍历他们的孩子们
                            //如果有一个==3那么久说明是处于选中状态
                            var is =  $(this).get(0).classList;
                            if(is.length==3){
                                count++;
                            }
                        });
                        //如果大于0说明还有子级处于选中状态
                        if(count>0){

                        }else{/*如果不大于那么就说明没有子级处于选中状态那么就移除父级的选中状态*/
                            $(data.elem).parent().prev().removeClass("layui-form-checked");
                        }
                    }
                }
            });



            //单文件上传
            upload.render({
                elem: '#test3'
                ,url: 'upload'
                ,done: function(res, index, upload){ //上传后的回调
                    if(res.icon==1){
                        layer.msg(res.msg, {icon: res.icon});
                        $('#test3').html(" <img src='"+res.img+"' alt=''style='width: 50%;height: 50%'>")
                        $('#img').val(res.img)
                        $('#filename').val(res.filename)
                    }else{
                        layer.msg(res.msg, {icon: res.icon});
                    }

                }
                ,accept: 'file' //允许上传的文件类型
                //,size: 50 //最大允许上传的文件大小
                //,……
            })


            //监听提交
            form.on('submit(formDemo)', function(data){
                    if(data.field.audit=='on'){
                        data.field.audit=2;
                    }
                    if(data.field.audit==undefined){
                    data.field.audit='';
                    }

                    if(data.field.site==undefined){
                    data.field.site='';
                    }

                var obj = $('input[name="site"]');//选择所有name="interest"的对象，返回数组
                var s='';//如果这样定义var s;变量s中会默认被赋个null值
                for(var i=0;i<obj.length;i++){
                    if(obj[i].checked) //取到对象数组后，我们来循环检测它是不是被选中
                        s+=obj[i].value+' ';   //如果选中，将value添加到变量s中
                }
                var facility = $('input[name="facility"]');//选择所有name="interest"的对象，返回数组
                var ss='';//如果这样定义var s;变量s中会默认被赋个null值
                for(var ii=0;ii<facility.length;ii++){
                    if(facility[ii].checked) //取到对象数组后，我们来循环检测它是不是被选中
                        ss+=facility[ii].value+' ';   //如果选中，将value添加到变量s中
                }


                var  arr={
                    id:data.field.id,
                    name:data.field.name,
                    type:data.field.type,
                    img:data.field.img,
                    rank:data.field.rank,
                    facility_id:ss,
                    site_id:s,
                    audit:data.field.audit,
                }

                $.ajax({
                    type: "post",
                    url: '/moduleadd',
                    data:arr,
                    dataType: "json",
                    success: function(res) {

                        if(res.icon==1){
                            layer.msg(res.msg, {icon: res.icon});
                            location.reload();
                        }else {
                            layer.msg(res.msg, {icon: res.icon});
                        }
                        //layer.alert(res.msg, { icon: res.icon, time: 4000, offset: 't', closeBtn: 0, title: '提醒您', btn: [], anim: 2, shade: 0 })

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
                    url: '/moduledel',
                    data:{id:id},
                    dataType: "json",
                    success: function(res) {
                        layer.msg(res.msg, {icon: res.icon});

                       // layer.alert(res.msg, { icon: res.icon, time: 4000, offset: 't', closeBtn: 0, title: '提醒您', btn: [], anim: 2, shade: 0 })
                        if(res.icon==1){
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
                url: '/moduleup',
                data:{id:id,name:name},
                dataType: "json",
                success: function(res) {
                    layer.msg(res.msg, {icon: res.icon});
                   // layer.alert(res.msg, { icon: res.icon, time: 4000, offset: 't', closeBtn: 0, title: '提醒您', btn: [], anim: 2, shade: 0 })
                    if(res.icon==1){
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

        //添加内容
//       $('#add').on('click',function(){
//           var aa=$(this).parent().prev().html();
//           var _str= "<input type='text' name='img' required='' lay-verify='required' placeholder='请输入名称' autocomplete='off' class='layui-input'>"+
//                   " <a href='#'class='test3'><img src='/uploads/timg.jpg' alt=''></a>";
//
//           $(this).parent().prev().append(_str)
//           console.log(aa)
//       })

    </script>
@endsection






