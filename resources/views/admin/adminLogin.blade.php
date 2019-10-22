 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <title>登录界面</title>
    <link href="{{asset('admins/layui_login/css/default.css')}}" rel="stylesheet" type="text/css" />
    <!--必要样式-->
    <link href="{{asset('admins/layui_login/css/styles.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admins/layui_login/css/demo.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admins/layui_login/css/loaders.css')}}" rel="stylesheet" type="text/css" />
</head>
<body>
<div class='login'>
    <div class='login_title'>
        <span>管理员登录</span>
    </div>
    <div class='login_fields'>
        <div class='login_fields__user'>
            <div class='icon'>
                <img alt="" src='{{asset('admins/layui_login/img/user_icon_copy.png')}}'>
            </div>
            @if(empty($_COOKIE['user']))
                <input name="login" placeholder='用户名' maxlength="16" type='text' autocomplete="off"/>
            @elseif($_COOKIE['pwd'])
                <input name="login" placeholder='用户名' maxlength="16" value="{{$_COOKIE['user']}}" type='text' autocomplete="off"/>
            @endif
            <div class='validation'>
                <img alt="" src='{{asset('admins/layui_login/img/tick.png')}}'>
            </div>
        </div>
        <div class='login_fields__password'>
            <div class='icon'>
                <img alt="" src='{{asset('admins/layui_login/img/lock_icon_copy.png')}}'>
            </div>
            @if(empty($_COOKIE['pwd']))
            <input name="pwd" placeholder='密码' maxlength="16" type='password' autocomplete="off">
            @elseif($_COOKIE['pwd'])
                <input name="pwd" placeholder='密码' maxlength="16" value="{{$_COOKIE['pwd']}}"  type='password' autocomplete="off">
            @endif
            <div class='validation'>
                <img alt="" src='{{asset('admins/layui_login/img/tick.png')}}'>
            </div>
        </div>

        <div class='login_fields__password'>
            <div class='icon'>
                <input id="remember_me" type="checkbox">
            </div>
            <p style="padding:5px 55px;">账号密码,记录十天</p>
        </div>
        <div class='login_fields__submit'>
            <input type='button' value='登录'>
        </div>
    </div>
    <div class='success'>
    </div>
    <div class='disclaimer'>
        <p>欢迎登录政协后台管理系统</p>
    </div>
</div>
<div class='authent'>
    <div class="loader" style="height: 44px;width: 44px;margin-left: 28px;">
        <div class="loader-inner ball-clip-rotate-multiple">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <p>全屏认证中...</p>
</div>
<div class="OverWindows"></div>

<link href="{{asset('admins/layui_login/layui/css/layui.css')}}" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="{{asset('admins/layui_login/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admins/layui_login/js/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admins/layui_login/js/stopExecutionOnTimeout.js?t=1')}}"></script>
<script type="text/javascript" src="{{asset('admins/layui_login/layui/layui.js')}}"></script>
<script type="text/javascript" src="{{asset('admins/layui_login/js/Particleground.js')}}"></script>
<script type="text/javascript" src="{{asset('admins/layui_login/js/Treatment.js')}}"></script>
<script type="text/javascript" src="{{asset('admins/layui_login/js/jquery.mockjax.js')}}"></script>

<script type="text/javascript">
    $(document).keypress(function (e) {
        // 回车键事件
        if (e.which == 13) {
            $('input[type="button"]').click();
        }
    });
    //粒子背景特效
    $('body').particleground({
        dotColor: '#E8DFE8',
        lineColor: '#133b88'
    });

    layui.use('layer', function () {
        var msgalert = '请勿胡乱更改：'+"后果自负";
        var index = layer.alert(msgalert, { icon: 6, time: 4000, offset: 't', closeBtn: 0, title: '友情提示', btn: [], anim: 2, shade: 0 });
        layer.style(index, {
            color: '#777'
        });
        //非空验证
        $('input[type="button"]').click(function () {
            var login = $('input[name="login"]').val();
            var remember_me=$("#remember_me").is(':checked');
            var pwd = $('input[name="pwd"]').val();

            if (login == '') {
                layer.msg("请输入您的账号");
            } else if (pwd == '') {
                layer.msg("请输入密码");
            }  else {
                fullscreen();
                $('.login').addClass('test'); //倾斜特效
                setTimeout(function () {
                    $('.login').addClass('testtwo'); //平移特效
                }, 300);
                setTimeout(function () {
                    $('.authent').show().animate({ right: -320 }, {
                        easing: 'easeOutQuint',
                        duration: 600,
                        queue: false
                    });
                    $('.authent').animate({ opacity: 1 }, {
                        duration: 200,
                        queue: false
                    }).addClass('visible');
                }, 500);

                //登录
                //  login: login, pwd: pwd
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url     :   '/adminLogin',
                    data: {login:login,pwd:pwd,remember_me:remember_me},
                    async: true, // 异步 || 同步
                    dataType: 'json',
                    type: 'post',
                    timeout: 10000,
                    success :   function(data){
                        setTimeout(function () {
                            $('.authent').show().animate({ right: 90 }, {
                                easing: 'easeOutQuint',
                                duration: 600,
                                queue: false
                            });
                            $('.authent').animate({ opacity: 0 }, {
                                duration: 200,
                                queue: false
                            }).addClass('visible');
                            $('.login').removeClass('testtwo'); //平移特效
                        }, 2000);
                        //跳转操作
                        setTimeout(function () {

                            if(data.Status == "200"){
                                $('.authent').hide();
                                $('.login').removeClass('test');
                                //登录成功
                                $('.login div').fadeOut(100);
                                $('.success').fadeIn(1000);
                                $('.success').html('登录成功,正在跳转主页面');
                                setTimeout(function () {
                                    window.location.href = "{{url('/admin')}}"
                                }, 2000);
                            }else{
                                layer.msg("账号或密码错误，正在刷新页面，请重新登录");
                                setTimeout(function () {
                                    window.location.reload()//刷新父页面
                                }, 2000);
                            }
                        }, 2400);
                    }
                });


            }
        })
    });

    var fullscreen = function () {
        elem = document.body;
        if (elem.webkitRequestFullScreen) {
            elem.webkitRequestFullScreen();
        } else if (elem.mozRequestFullScreen) {
            elem.mozRequestFullScreen();
        } else if (elem.requestFullScreen) {
            elem.requestFullscreen();
        } else {
            //浏览器不支持全屏API或已被禁用
        }
    };

</script>

</body>
</html>
