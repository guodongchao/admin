<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<div class="layui-header">
    <div class="layui-logo"><img src="{{asset('images/logo_title.png')}}">政协后台管理系统</div>
    <ul class="layui-nav layui-layout-right">
        {{--<li class="layui-nav-item">--}}
            {{--<a href="javascript:;">--}}
                {{--<i class="layui-icon layui-icon-add-1"></i>--}}
                {{--<span>添加</span>--}}
            {{--</a>--}}
            {{--<dl class="layui-nav-child">--}}
                {{--<dd><a href="">其他</a></dd>--}}
            {{--</dl>--}}
        {{--</li>--}}
        <li class="layui-nav-item">
            <a href="javascript:;">
                <i class="layui-icon layui-icon-username"></i>
                <span>用户</span>
            </a>
            <dl class="layui-nav-child">
                <dd><a href="javascript:;">{{$_COOKIE['name']}}</a></dd>
                <dd><a href="{{url('/adminquit')}}">退出</a></dd>
            </dl>

        </li>
    </ul>
</div>
</body>
</html>
