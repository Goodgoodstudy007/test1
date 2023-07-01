<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:75:"/www/wwwroot/douyin_xunpang/public/../application/store/view/user/info.html";i:1627541662;s:62:"/www/wwwroot/douyin_xunpang/application/store/view/footer.html";i:1627905460;}*/ ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>商家管理后台</title>
        <link rel="stylesheet" href="/assets/css/layui.css"/>
        <link rel="stylesheet" href="/assets/css/mui.css" />
        <link rel="stylesheet" href="/assets/css/new_activity.css" />
        <link rel="stylesheet" href="/assets/css/bootstrap.css" />
        <script src="/assets/js/jquery-2.1.1.min.js"></script>
        <script src="/assets/js/layui.js"></script>
        <link rel="stylesheet" href="/assets/css/layer.css"/>
        <script src="/assets/js/layer.js"></script>
        <script src="https://res.wx.qq.com/open/js/jweixin-1.3.2.js" ></script>
        <Style>
            .footbiao img{ width: 25px;height: 25px;margin-bottom: 8px; }
            .footer{height: 60px;padding-top: 10px;}
            .ending{padding: 10px 0px;}
        </style>
    </head>
    <body style="margin: 0 auto;">
        <h2 style="text-align:center;font-size:18px;padding:10px 0px;margin-top:10px;margin-bottom:10px;">个人信息修改</h2>
        <form class="mui-input-group top_on"  id="activity_edit">
            <div class="layui-tab layui-tab-card" overflow="" style="padding:0px 10px;">
                <div class="layui-form-item" style="padding-top:10px;">
                    <label class="layui-form-label">商户名称</label>
                    <div class="layui-input-block">
                      <input type="text" name="store_name" id="store_name" value="<?php echo $store['store_name']; ?>" maxlength="20" placeholder="请输入商户名称" class="layui-input" />
                    </div>
                </div>
                <div class="layui-form-item" >
                    <label class="layui-form-label">商户账号</label>
                    <div class="layui-input-block">
                      <input type="text" name="username" id="username" value="<?php echo $store['username']; ?>"  class="layui-input" disabled="disabled"  style="background:#eee;" />
                    </div>
                </div>
                <div class="layui-form-item" >
                    <label class="layui-form-label">商户密码</label>
                    <div class="layui-input-block">
                      <input type="password" name="password" id="password" placeholder="******（留空则不修改）"  class="layui-input" />
                    </div>
                </div>

            </div>
        </form>
        <div class="ending">
            <div class="total" id="data_save" >
                修改
            </div>
            <div class="total" id="logout" style="margin-top:20px;background:#ccc;" >
                退出登录
            </div>
        </div>


        <!--底部-->
<div class="footer">
    <a class="maobin" href="/store/index/index">
        <div class="footer_li ">
            <div class="footbiao">
                <img src="/assets/img/home_<?php if($html_name!='index'): ?>no<?php endif; ?>select.png">
            </div>
            <div class="footzi" <?php if($html_name=="index"): ?>style="color:#2196F3;"<?php endif; ?>>
                首页
            </div>
        </div>
    </a>
    <a class="maobin" href="/store/task/index?mode=1">
        <div class="footer_li ">
            <div class="footbiao">
                <img src="/assets/img/task_<?php if($html_name!='task_mode1'): ?>no<?php endif; ?>select.png">
            </div>
            <div class="footzi"  <?php if($html_name=="task_mode1"): ?>style="color:#2196F3;"<?php endif; ?>>
                主页监控
            </div>
        </div>
    </a>
    <a class="maobin" href="/store/task/index?mode=2">
        <div class="footer_li ">
            <div class="footbiao">
                <img src="/assets/img/<?php if($html_name!='task_mode2'): ?>no<?php endif; ?>video.png">
            </div>
            <div class="footzi"  <?php if($html_name=="task_mode2"): ?>style="color:#2196F3;"<?php endif; ?>>
                单视频监控
            </div>
        </div>
    </a>
    <a class="maobin" href="/store/task/index?mode=3">
        <div class="footer_li ">
            <div class="footbiao">
                <img src="/assets/img/<?php if($html_name!='task_mode3'): ?>no<?php endif; ?>search.png">
            </div>
            <div class="footzi"  <?php if($html_name=="task_mode3"): ?>style="color:#2196F3;"<?php endif; ?>>
                关键词监控
            </div>
        </div>
    </a>
    <a class="maobin" href="/store/user/info">
        <div class="footer_li ">
            <div class="footbiao">
                <img src="/assets/img/user_<?php if($html_name!='user'): ?>no<?php endif; ?>select.png">
            </div>
            <div class="footzi"  <?php if($html_name=="user"): ?>style="color:#2196F3;"<?php endif; ?>>
                个人信息
            </div>
        </div>
    </a>
</div>

<!--全局提示弹窗-->
<div class="code_ok" hidden>
    <div class="code_li_ok">
        <div class="dialogs">
            <div class="dialogs_top">
                操作提示
                <span class="mui-icon mui-icon-close guang"></span> 
            </div>
            <div class="dialogs_ok">
                <span class="glyphicon glyphicon-ok-circle yess"></span>

            </div>
        </div>
    </div>
</div>
<script>
    
    $('#logout').click(function() {
        var btnArray = ['否', '是'];
        mui.confirm('您确定要退出？', '提示', btnArray, function(e) {
            if (e.index == 1) {
                location.href = "/store/user/logout";
            }
        })
    });
    
    function show_message(type, text, time, back_status) {
        $(".code_ok").hide();
        if (type == 1) {
            $(".dialogs_ok").html('<span class="glyphicon glyphicon-ok-circle yess"></span>' + text);
        } else {
            $(".dialogs_ok").html('<span class="glyphicon glyphicon-remove-circle nos"></span>' + text);
        }
        $(".code_ok").show();
        if (time) {
            setTimeout('$(".code_ok").hide();', time);
        }
        return 1;
    }

    // 提交
    $('#data_save').click(function(){
        store_name = $('#store_name').val();
        if(store_name==""){
            show_message(0, '商户名称不能为空', 2000, 1);
        }
        $.post("/store/user/edit", {store_name:$('#store_name').val(),password:$('#password').val()}, function(ret) {
            if (ret.code == 0) {
                show_message(1, '修改成功', 2000, 1);
                setTimeout(function(){
                    window.location.href = "/store/user/info";
                },2000);
                return;
            }
            show_message(0, ret.msg, 2000, 1);return;
        }, 'json');
    });

</script>
    <Style>
    .layui-layer-btn .layui-layer-btn0{ background:#fd4835;background-color:#fd4835;color:#fff;border:1px solid #fd4835}
    </style>
</body>
</html>
<script type="text/javascript" src="/assets/js/mui.min.js" ></script>
<script>

</script>
