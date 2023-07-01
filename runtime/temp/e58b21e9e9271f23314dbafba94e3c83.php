<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:76:"/www/wwwroot/douyin_xunpang/public/../application/agent/view/user/login.html";i:1626919282;}*/ ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>代理商登录</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="/assets/css/skycons.css" rel="stylesheet">
        <link href="/assets/css/bootkit.css" rel="stylesheet"> 
        <link href="/assets/css/jquery.mmenu.css" rel="stylesheet">    
        <link href="/assets/css/style.css" rel="stylesheet">
        <link href="/assets/css/add-ons.min.css" rel="stylesheet">
        <style>
            footer {
                display: none;
            }
            .login-box .header img, .register-box .header img{ padding-left:0; max-width:60%; margin:10px auto; max-height:120px}
            .login-box .header, .register-box .header, .recover-box .header{    background: #5bb0f5;height: 50px;line-height: 50px;font-size: 20px;}
            .login-box .login .form-group label, .register-box .register .form-group label{font-size: 16px;}
            .input-group-icon input{height: 40px;line-height: 40px;}
            .btn-login{background: #5bb0f5;color: #fff;border:0px;width: 150px;}
            .xunpang-title{text-align: center;margin-bottom: 30px;}
        </style>
        
    </head>

    <body>
        <!-- Start: Content -->
        <div class="container-fluid content">
            <div class="row">
                <!-- Main Page -->
                <div id="content" class="col-sm-12 full">
                    <div class="row">
                        
                        <div class="login-box">
                            <h1 class="xunpang-title">
                                <?php echo $site_name; ?>
                            </h1>
                            <div class="panel">
                                <div class="panel-body">                                
                                    <div class="header bk-margin-bottom-20 text-center" style="color:#fff!important;">                                        
                                        代理商登陆
                                    </div>      
                                    <form class="form-horizontal login" id="login"  method="post">
                                        <div class="bk-padding-left-20 bk-padding-right-20">
                                            <div class="form-group">
                                                <label>登陆账户</label>
                                                <div class="input-group input-group-icon">
                                                    <input type="text" class="form-control bk-radius" id="username" name="username" placeholder="请输入账号" />
                                                    <span class="input-group-addon">
                                                        <span class="icon">
                                                            <i class="fa fa-user"></i>
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>                                          
                                            <div class="form-group">
                                                <label>密码</label>
                                                <div class="input-group input-group-icon">
                                                    <input type="password" class="form-control bk-radius"  name="password" id="password" placeholder="请输入密码" />
                                                    <span class="input-group-addon">
                                                        <span class="icon">
                                                            <i class="fa fa-key"></i>
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row bk-margin-top-20 bk-margin-bottom-10">
                                                <div class="col-sm-6 text-center">
                                                    <span  class="bk-margin-10 btn   btn-lg btn-login">登陆</span>
                                                </div>
                                             </div>
                                            <div class="text-with-hr">
                                                <span></span>
                                            </div>                                          
                                                                                        <p class="text-center"></p>
                                                                                    </div>
                                    </form>
                                </div>
                            </div>
    
                        </div>
                    </div>          
                </div>
                <!-- End Main Page -->
            </div>
        </div><!--/container-->     

        <script src="/assets/js/jquery-2.1.1.min.js"></script>
        <script>
            $(function() {
                $('.btn-login').on('click', function() {
                    if (!$('#username').val() || !$('#password').val()) {
                        alert('用户名/密码不能为空');
                        return;
                    }
                    var form = $('#login').serialize();
                    $.post("/agent/user/login_post", form, function(ret) {
                        if (ret.code == 0) {
                            window.location.href = "/agent/index/index";
                            return;
                        }
                        alert(ret.msg); return;
                    }, 'json');
                     return;
                });
            });
        </script>
</body>
    
</html>
        
