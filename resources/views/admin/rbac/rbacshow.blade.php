@extends('admin.layout')
@section('content')

    <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
        <input type="hidden" value="{{$type}}" id="type">
        <ul class="layui-tab-title">
            @if($type==1)
            <a href="{{url('/access?type=1')}}"><li class="layui-this">用户管理</li></a>
            <a href="{{url('/access?type=2')}}"><li>角色管理</li></a>
            <a href="{{url('/access?type=3')}}"><li>权限管理</li></a>

            @elseif($type==2)
                <a href="{{url('/access?type=1')}}"><li>用户管理</li></a>
                <a href="{{url('/access?type=2')}}"><li class="layui-this">角色管理</li></a>
                <a href="{{url('/access?type=3')}}"><li>权限管理</li></a>
            @elseif($type==3)
                <a href="{{url('/access?type=1')}}"><li>用户管理</li></a>
                <a href="{{url('/access?type=2')}}"><li>角色管理</li></a>
                <a href="{{url('/access?type=3')}}"><li class="layui-this">权限管理</li></a>
            @endif
        </ul>
        <div class="layui-tab-content" style="height: 100px;">
            @if($type==1)
            <div class="layui-tab-item layui-show">
            @else
            <div class="layui-tab-item ">
            @endif
                <form action="/access" method="post">
                    <input type="text" name="name" placeholder="请输入账号名称">
                    <input type="hidden" name="type" value="1">
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
                        <th>账号</th>
                        <th>密码</th>
                        <th>绑定角色</th>
                        <th>绑定单位</th>
                        <th>添加时间</th>
                        <th>是否启用</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($usershow as $k=>$v)

                        <tr class="{{$v['id']}}">
                            <td>{{$v['id']}}</td>
                            <td onclick="up({{$v['id']}})">{{$v['name']}} <input type="text" value="{{$v['name']}}"class="up  {{'up'.$v['id']}}" onblur="ups({{$v['id']}})" ></td>
                            <td>{{$v['password']}}</td>

                            <td>
                                @foreach($v['role_id'] as $kkk=>$vvv)
                                    @foreach($role as $kk=>$vv)
                                        @if($vv['id']==$vvv)
                                            {{$vv['name']}}
                                        @endif
                                    @endforeach
                                @endforeach
                            </td>

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
                                    @if($v['audit']==2)
                                        <a href="#" onclick="upstatus({{$v['id']}})"><input type="checkbox" name="zzz" class="audit{{$v['id']}}" value="{{$v['audit']}}" checked lay-skin="switch" lay-text="启用|未启用" ></a>
                                    @else
                                        <a href="#" onclick="upstatus({{$v['id']}})"><input type="checkbox" name="zzz" class="audit{{$v['id']}}" value="{{$v['audit']}}" lay-skin="switch" lay-text="启用|未启用" ></a>
                                    @endif
                                </form>
                            </td>
                            <td>

                                <div class="layui-btn-group">
                                    <a href="/access?id={{$v['id']}}&type=1"><button type="button" class="layui-btn layui-btn-sm">
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
                        {{$usershow->appends(['type'=>$type,'name'=>$name]) -> links()}}
                    </div>
                </div>

                @if(empty($arr))

                <form class="layui-form" action="">

                    <div class="layui-form-item" style="width: 50%">
                        <label class="layui-form-label" style="width: 13%">账号</label>
                        <div class="layui-input-inline" >
                            <input type="text" name="name" required   lay-verify="required" placeholder="请输入用户名称" autocomplete="off" class="layui-input"  >
                        </div>
                    </div>

                    <div class="layui-form-item" style="width: 50%">
                        <label class="layui-form-label" style="width: 13%">密码</label>
                        <div class="layui-input-inline" >
                            <input type="password" name="password" required   lay-verify="required" placeholder="请输入用户密码" autocomplete="off" class="layui-input"  >
                        </div>
                    </div>

                    <div class="layui-form-item" style="width: 50%">
                        <label class="layui-form-label" style="width: 13%">确认密码</label>
                        <div class="layui-input-inline" >
                            <input type="password" name="passwords" required   lay-verify="required" placeholder="请确认用户密码" autocomplete="off" class="layui-input"  >
                        </div>
                    </div>


                    <div class="layui-form-item" style="width: 50%">
                        <label class="layui-form-label" style="width: 13%">用户角色</label>
                        <div class="layui-input-block" >
                            @foreach($role as $r=>$l)
                                <input type="checkbox" name="role_id" value={{$l['id']}} title={{$l['name']}}>
                            @endforeach
                        </div>
                    </div>

                    <div class="layui-form-item" style="width: 50%">
                        <label class="layui-form-label"style="width: 13%">绑定单位</label>
                        <div class="layui-input-block">
                            @foreach($site as $s=>$t)
                                <input type="checkbox" name="site" value={{$t['id']}} title={{$t['site_name']}}>
                            @endforeach
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit lay-filter="formDemou">立即提交</button>
                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        </div>
                    </div>
                </form>
                @else
                    <form class="layui-form" action="">
                        <input type="hidden" value="{{$arr['id']}}" name="id">
                        <div class="layui-form-item" style="width: 50%">
                            <label class="layui-form-label" style="width: 13%">账号</label>
                            <div class="layui-input-inline" >
                                <input type="text" name="name" value="{{$arr['name']}}" required   lay-verify="required" placeholder="请输入用户名称" autocomplete="off" class="layui-input"  >
                            </div>
                        </div>

                        <div class="layui-form-item" style="width: 50%">
                            <label class="layui-form-label" style="width: 13%">密码</label>
                            <div class="layui-input-inline" >
                                <input type="password" name="password" value="{{$arr['password']}}" required   lay-verify="required" placeholder="请输入用户密码" autocomplete="off" class="layui-input"  >
                            </div>
                        </div>

                        <div class="layui-form-item" style="width: 50%">
                            <label class="layui-form-label" style="width: 13%">确认密码</label>
                            <div class="layui-input-inline" >
                                <input type="password" name="passwords" value="{{$arr['password']}}" required   lay-verify="required" placeholder="请确认用户密码" autocomplete="off" class="layui-input"  >
                            </div>
                        </div>



                        <div class="layui-form-item" style="width: 50%">
                            <label class="layui-form-label" style="width: 13%">用户角色</label>
                            <div class="layui-input-block" >

                                @foreach($role as $r=>$l)

                                    <input type="checkbox" name="role_id"
                                           @foreach($user as $m=>$d)
                                           @foreach($d['role_id'] as $mm=>$dd)
                                           @if($d['id']==$arr['id'])
                                           @if($dd==$l['id'])
                                           checked
                                           @endif
                                           @endif
                                           @endforeach
                                           @endforeach

                                           value={{$l['id']}} title={{$l['name']}}>

                                @endforeach

                            </div>
                        </div>
                        <div class="layui-form-item" style="width: 50%">
                            <label class="layui-form-label"style="width: 13%">绑定单位</label>
                            <div class="layui-input-block">
                                @foreach($site as $s=>$t)
                                    <input type="checkbox" name="site_id"

                                           @foreach($user as $m=>$d)
                                           @foreach($d['site_id'] as $mm=>$dd)
                                           @if($d['id']==$arr['id'])
                                           @if($dd==$t['id'])
                                           checked
                                           @endif
                                           @endif
                                           @endforeach
                                           @endforeach

                                           value={{$t['id']}} title={{$t['site_name']}}>
                                @endforeach
                            </div>
                        </div>


                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button class="layui-btn layui-btn-warm" lay-submit lay-filter="formDemou">立即修改</button>
                                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                            </div>
                        </div>
                    </form>
                @endif

            </div>


                @if($type==2)
                <div class="layui-tab-item layui-show">
                @else
                <div class="layui-tab-item ">
                @endif
                <form action="/access" method="post">
                    <input type="text" name="name" placeholder="请输入角色名称">
                    <input type="hidden" name="type" value="2">
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
                        <th>角色名称</th>
                        <th>角色权限</th>
                        <th>添加时间</th>
                        <th>审核</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roleshow as $k=>$v)
                        <tr class="{{$v['id']}}">
                            <td>{{$v['id']}}</td>
                            <td onclick="up({{$v['id']}})">{{$v['name']}} <input type="text" value="{{$v['name']}}"class="up  {{'up'.$v['id']}}" onblur="ups({{$v['id']}})" ></td>

                            <td>
                                @foreach($v['access_id'] as $kkk=>$vvv)
                                    @foreach($accessall as $kk=>$vv)
                                        @if($vv['id']==$vvv)
                                            {{$vv['title']}}
                                        @endif
                                    @endforeach
                                @endforeach
                            </td>
                            <td>{{$v['time']}}</td>
                            <td>
                                <form class="layui-form" action="">
                                    @if($v['audit']==2)
                                        <a href="#" onclick="upstatus({{$v['id']}})"> <input type="checkbox" name="zzz" class="audits{{$v['id']}}" value="{{$v['audit']}}" checked lay-skin="switch" lay-text="启用|未启用" ></a>
                                    @else
                                        <a href="#" onclick="upstatus({{$v['id']}})"> <input type="checkbox" name="zzz" class="audits{{$v['id']}}" value="{{$v['audit']}}" lay-skin="switch" lay-text="启用|未启用" ></a>
                                    @endif
                                </form>
                            </td>
                            <td>

                                <div class="layui-btn-group">
                                    <a href="/access?id={{$v['id']}}&type=2"><button type="button" class="layui-btn layui-btn-sm">
                                            <i class="layui-icon">&#xe642;</i>
                                        </button></a>
                                </div>
                                <div class="layui-btn-group">
                                    <button type="button" class="layui-btn layui-btn-sm"  onclick="del({{$v['id']}})">
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
                        {{$roleshow->appends(['type'=>$type,'name'=>$name]) -> links()}}
                    </div>
                </div>
                @if(empty($arr))
                <form class="layui-form" action="">

                    <div class="layui-form-item" style="width: 50%">
                        <label class="layui-form-label" style="width: 13%">角色名称</label>
                        <div class="layui-input-inline" >
                            <input type="text" name="name" required   lay-verify="required" placeholder="请输入角色名称" autocomplete="off" class="layui-input"  >
                        </div>
                    </div>


                    <div class="layui-form-item" style="width: 50%">
                        <label class="layui-form-label" style="width: 13%">角色权限</label>
                        <div class="layui-input-block" >
                            @foreach($access as $s=>$t)
                                <div>
                                <input type="checkbox" name="access_id" class="parent" value={{$t['id']}} title={{$t['title']}}>
                                <div class="layui-input-block" >
                                    @foreach($t['son'] as $o=>$n)
                                        <input type="checkbox" name="access_id" value={{$n['id']}} title={{$n['title']}}>
                                    @endforeach
                                </div>
                                </div>
                            @endforeach
                        </div>
                    </div>


                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit lay-filter="formDemos">立即提交</button>
                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        </div>
                    </div>
                </form>
                @else
                    <form class="layui-form" action="">
                        <input type="hidden" value="{{$arr['id']}}" name="id">
                        <div class="layui-form-item" style="width: 50%">
                            <label class="layui-form-label" style="width: 13%">角色名称</label>
                            <div class="layui-input-inline" >
                                <input type="text" name="name" value="{{$arr['name']}}" required   lay-verify="required" placeholder="请输入角色名称" autocomplete="off" class="layui-input"  >
                            </div>
                        </div>


                        <div class="layui-form-item" style="width: 50%">
                            <label class="layui-form-label" style="width: 13%">角色权限</label>
                            <div class="layui-input-block" >
                                @foreach($access as $s=>$t)
                                    <div>
                                    <input type="checkbox" name="access_id"class="parent"

                                           @foreach($role as $m=>$d)
                                           @foreach($d['access_id'] as $mm=>$dd)
                                           @if($d['id']==$arr['id'])
                                           @if($dd==$t['id'])
                                           checked
                                           @endif
                                           @endif
                                           @endforeach
                                           @endforeach

                                           value={{$t['id']}} title={{$t['title']}} >
                                    <div class="layui-input-block" >
                                        @foreach($t['son'] as $o=>$n)
                                            <input type="checkbox" name="access_id"

                                                   @foreach($role as $m=>$d)
                                                   @foreach($d['access_id'] as $mm=>$dd)

                                                   @if($dd==$n['id'])
                                                   checked

                                                   @endif
                                                   @endforeach
                                                   @endforeach

                                                   value={{$n['id']}} title={{$n['title']}}>
                                        @endforeach
                                    </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>


                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button class="layui-btn layui-btn-warm" lay-submit lay-filter="formDemos">立即修改</button>
                                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>

             @if($type==3)
              <div class="layui-tab-item layui-show">
              @else
              <div class="layui-tab-item ">
              @endif
                  <form action="/access" method="post">
                      <input type="text" name="name" placeholder="请输入权限名称">
                      <input type="hidden" name="type" value="3">

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
                          <th>权限名称</th>
                          <th>权限路径</th>
                          <th>添加时间</th>
                          <th>操作</th>
                      </tr>
                      </thead>
                      <tbody>
                      @foreach($accessshow as $k=>$v)
                          <tr class="{{$v['id']}}">
                              <td>{{$v['id']}}</td>
                              <td onclick="up({{$v['id']}})">{{$v['title']}} <input type="text" value="{{$v['title']}}"class="up  {{'ups'.$v['id']}}" onblur="ups({{$v['id']}})" ></td>
                              <td>{{$v['uris']}}</td>
                              <td>{{$v['time']}}</td>
                              <td>

                                  <div class="layui-btn-group">
                                      <a href="/access?id={{$v['id']}}&type=3"><button type="button" class="layui-btn layui-btn-sm">
                                              <i class="layui-icon">&#xe642;</i>
                                          </button></a>
                                  </div>
                                  <div class="layui-btn-group">
                                      <button type="button" class="layui-btn layui-btn-sm"  onclick="del({{$v['id']}})">
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
                          {{$accessshow->appends(['type'=>$type,'name'=>$name]) -> links()}}
                      </div>
                  </div>
                  @if(empty($arr))
                <form class="layui-form" action="">

                    <div class="layui-form-item" style="width: 50%">
                        <label class="layui-form-label" style="width: 13%">权限名称</label>
                        <div class="layui-input-inline" >
                            <input type="text" name="title" required   lay-verify="required" placeholder="请输入权限名称" autocomplete="off" class="layui-input"  >
                        </div>
                    </div>

                    <div class="layui-form-item" style="width: 50%">
                        <label class="layui-form-label" style="width: 13%">权限路径</label>
                        <div class="layui-input-inline" >
                            <input type="text" name="uris" required   lay-verify="required" placeholder="请输入权限路径" autocomplete="off" class="layui-input"  >
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
                          <label class="layui-form-label" style="width: 13%">权限名称</label>
                          <div class="layui-input-inline" >
                              <input type="text" name="title" value="{{$arr['title']}}" required   lay-verify="required" placeholder="请输入权限名称" autocomplete="off" class="layui-input"  >
                          </div>
                      </div>

                      <div class="layui-form-item" style="width: 50%">
                          <label class="layui-form-label" style="width: 13%">权限路径</label>
                          <div class="layui-input-inline" >
                              <input type="text" name="uris" value="{{$arr['uris']}}" required   lay-verify="required" placeholder="请输入权限路径" autocomplete="off" class="layui-input"  >
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
            </div>

        </div>
    </div>




    <script>
        $('.up').hide();
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
            //监听权限提交
            form.on('submit(formDemo)', function(data){

                var  arr={
                    id:data.field.id,
                    title:data.field.title,
                    uris:data.field.uris,
                }
                $.ajax({
                    type: "post",
                    url: '/accessadd',
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
            //监听角色提交
            form.on('submit(formDemos)', function(data){

                var obj = $('input[name="access_id"]');//选择所有name="interest"的对象，返回数组
                var s='';//如果这样定义var s;变量s中会默认被赋个null值
                for(var i=0;i<obj.length;i++){
                    if(obj[i].checked) //取到对象数组后，我们来循环检测它是不是被选中
                        s+=obj[i].value+' ';   //如果选中，将value添加到变量s中
                }
                var  arr={
                    id:data.field.id,
                    name:data.field.name,
                    access_id:s,
                }
                $.ajax({
                    type: "post",
                    url: '/roleadd',
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
            //监听用户提交
            form.on('submit(formDemou)', function(data){
                var obj = $('input[name="role_id"]');//选择所有name="interest"的对象，返回数组
                var s='';//如果这样定义var s;变量s中会默认被赋个null值
                for(var i=0;i<obj.length;i++){
                    if(obj[i].checked) //取到对象数组后，我们来循环检测它是不是被选中
                        s+=obj[i].value+' ';   //如果选中，将value添加到变量s中
                }

                var site_id = $('input[name="site_id"]');//选择所有name="interest"的对象，返回数组
                var ss='';//如果这样定义var s;变量s中会默认被赋个null值
                for(var ii=0;ii<site_id.length;ii++){
                    if(site_id[ii].checked) //取到对象数组后，我们来循环检测它是不是被选中
                        ss+=site_id[ii].value+' ';   //如果选中，将value添加到变量s中
                }

                //判断密码是否一致
                if(data.field.password!=data.field.passwords){
                    layer.msg('密码不一致', {icon: 5});return false;
                }
                var  arr={
                    id:data.field.id,
                    name:data.field.name,
                    password:data.field.password,
                    site_id:ss,
                    role_id:s,
                }

                $.ajax({
                    type: "post",
                    url: '/useradd',
                    data:arr,
                    dataType: "json",
                    success: function(res) {
                        layer.msg(res.msg, {icon: res.icon});
                        if(res.icon==1){
                            //layer.alert(res.msg, { icon: res.icon, time: 4000, offset: 't', closeBtn: 0, title: '提醒您', btn: [], anim: 2, shade: 0 })
                            location.reload();
                        }

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
                var type=$('#type').val();
                $.ajax({
                    type: "post",
                    url: '/userdel',
                    data:{id:id,type:type},
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
            $('.ups'+id).show().focus();
        }
        //监听 修改文本框   失去焦点事件
        function ups(id){
            $('.ups'+id).hide();
            $('.up'+id).hide();
            layer.confirm('确定修改吗?', {icon: 3, title:'提示'}, function(index){
                layer.close(index);
                var name=$('.up'+id).val();
                var title=$('.ups'+id).val();
                var type=$('#type').val();
                $.ajax({
                    type: "post",
                    url: '/userup',
                    data:{id:id,name:name,type:type,title:title},
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
        $('.status').on('click',function(){

        })
        function upstatus(id){
            var audit=$('.audit'+id).val();
            var type=$('#type').val();
            if(type==2){
                audit=$('.audits'+id).val();
            }
            if(audit==2){
                audit=1
            }else {
                audit=2
            }
//             layer.confirm('确定修改吗?', {icon: 3, title:'提示'}, function(index){
//                    layer.close(index);
            $.ajax({
                type: "post",
                url: '/userup',
                data:{id:id,audit:audit,type:type},
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






