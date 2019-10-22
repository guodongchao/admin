<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
        <ul class="layui-nav layui-nav-tree"  lay-filter="test">
            <li class="layui-nav-item layui-nav-itemed">
                <a class="" href="javascript:;">单位管理</a>
                <dl class="layui-nav-child"style="text-indent:0.6cm;">
                    <dd><a href="{{url('/site')}}">单位信息</a></dd>

                </dl>
            </li>
            <li class="layui-nav-item layui-nav-itemed">
                <a class="" href="javascript:;">设备管理</a>
                <dl class="layui-nav-child"style="text-indent:0.6cm;">
                    <dd><a href="{{url('/facility')}}">设备信息</a></dd>

                </dl>
            </li>
            <li class="layui-nav-item layui-nav-itemed">
                <a class="" href="javascript:;">模块管理</a>
                <dl class="layui-nav-child"style="text-indent:0.6cm;">
                    <dd><a href="{{url('/module')}}">模块信息</a></dd>

                </dl>
            </li>
            <li class="layui-nav-item layui-nav-itemed">
                <a class="" href="javascript:;">apk管理</a>
                <dl class="layui-nav-child"style="text-indent:0.6cm;">
                    <dd><a href="{{url('/apk')}}">apk信息</a></dd>

                </dl>
            </li>
            
            <li class="layui-nav-item layui-nav-itemed" id="role">
                <a class="" href="javascript:;">权限管理</a>
                <dl class="layui-nav-child"style="text-indent:0.6cm;">
                    <dd><a href="{{url('/access?type=1')}}">权限信息</a></dd>

                </dl>
            </li>
        </ul>
    </div>
    <input type="hidden" value="{{$_COOKIE['token']}}" id="token">
    <div class="layui-footer">
        <!-- 底部固定区域 -->
        <img src="{{asset('layui/images/face/30.gif')}}">
    </div>

</div>
<script>
    //JavaScript代码区域

    layui.use(['element'], function(){
        var element = layui.element;
        var token=$('#token').val();
        $.ajax({
            type: "post",
            url: '/verify',
            data:{token:token},
            dataType: "json",
            success: function(res) {
                if(res.name!='admin'){
                    $('#role').hide();
                }

            }
        });
    });
</script>
</body>
</html>




