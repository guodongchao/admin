<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>政协后台管理系统</title>
    <link rel="stylesheet" href="{{asset('layui/css/layui.css')}}">
    <script src="{{asset('layui/layui.js')}}"></script>
    <script src="{{asset('admins/jquery-3.2.1.min.js')}}"></script>
    <script src="{{asset('/js/jquery-1.8.3.min.js')}}"></script>
    <script src="{{asset('/js/jquery.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">

</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">

    <!-- 头部导航区域（可配合layui已有的垂直导航） -->
    @include ('admin.public.top')

    <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
    @include ('admin.public.left')

    <!-- 内容主体区域 -->
    <div class="layui-body">
        <div style="padding: 2%;width:100%;">
            @section('content')
                <style>
                    html, body {
                        background-color: #fff;
                        color: #636b6f;
                        font-family: 'Nunito', sans-serif;
                        font-weight: 200;
                        height: 100vh;
                        margin: 0;
                    }

                    .full-height {
                        height: 100vh;
                    }

                    .flex-center {

                        align-items: center;
                        display: flex;
                        justify-content: center;

                    }

                    .position-ref {

                        position: relative;
                    }

                    .top-right {
                        position: absolute;
                        right: 10px;
                        top: 18px;
                    }

                    .content {
                        text-align: center;
                    }

                    .title {
                        margin: 250px;
                        font-size: 84px;
                        width: 1000px;
                        color: darkcyan;
                        text-align: center;
                    }

                    .links > a {
                        color: #636b6f;
                        padding: 0 25px;
                        font-size: 13px;
                        font-weight: 600;
                        letter-spacing: .1rem;
                        text-decoration: none;
                        text-transform: uppercase;
                    }

                    .m-b-md {

                        margin-bottom: 30px;
                    }
                </style>
                <body>
                <div class="flex-center position-ref ">
                    <div class="content">
                        <div class="title m-b-md">
                            欢迎你 <b style="color: red">{{$_COOKIE['name']}}</b>
                        </div>
                    </div>
                </div>
                </body>

                <input type="hidden" value="{{$_COOKIE['token']}}" id="token">
            @show
        </div>
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
                if(res.super!=2){
                    $('#role').hide();
                }

            }
        });
    });
</script>
</body>
</html>
