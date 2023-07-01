<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:82:"/www/wwwroot/douyin_xunpang/public/../application/agent/view/store/edit_store.html";i:1627541916;s:62:"/www/wwwroot/douyin_xunpang/application/agent/view/footer.html";i:1627542144;}*/ ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>代理管理后台</title>
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
            .layui-form-label{font-size: 14px;width:100px;}
            .footbiao img{ width: 25px;height: 25px;margin-bottom: 8px; }
            .footer{height: 60px;padding-top: 10px;}
            .keyword_content p{background: #eee;display: inline-block;padding: 5px;border-radius: 5px;margin:0px;margin-right: 10px;margin-top: 10px;}
            .keyword_content{max-height: 100px; overflow-y: scroll;}
            .layui-form-item{margin-bottom: 10px;}
            .recomm_keyword{background: #e6e6e6;padding: 5px ;margin-bottom: 10px;margin-right: 10px;color: #666;display: inline-block;}
            .delete_keyword{margin-left: 5px;color: #000;}
            #jiexi_btn{background: #000;color: #fff;width: 100px;margin-bottom: 10px;margin-top: 10px;}
            .ending{padding: 10px 0px;}
            .jiexi_result{text-align: center;}
            .task_price{font-size:20px;color:orange;    font-weight: bold;}
        </style>
    </head>
    <body style="margin: 0 auto;">
        <header style="height: 40px;background: #fff;color: #ffffff;padding: 0px 10px 0px 20px;overflow: hidden;">
            <a href="javascript:history.back(-1)" style="    display: block;float: left;margin-top: 0.12rem;height: 0.64rem;width: 10%;"><img style="height: 20px !important;margin-top: 15px;" src="/assets/img/back_000.png"></a>
            <span style="font-size: 20px;color: #666;float: left;width: 80%;height: 40px;line-height: 50px;text-align: center;">编辑商家</span>
        </header>
        <form class="mui-input-group top_on"  method="post" enctype="multipart/form-data" id="activity_edit">
            <div class="layui-tab layui-tab-card" overflow="" style="padding:0px 10px;">

            <div class="layui-form-item" style="padding-top:10px;">
                <label class="layui-form-label">商家名称</label>
                <div class="layui-input-block">
                  <input type="text" name="store_name" id="store_name" value="<?php echo $store['store_name']; ?>" maxlength="20" placeholder="请输入商家名称" class="layui-input" />
                </div>
            </div>
            <div class="layui-form-item" style="padding-top:10px;">
                <label class="layui-form-label">登录账号</label>
                <div class="layui-input-block">
                  <input type="text" name="username" id="username" value="<?php echo $store['store_name']; ?>" maxlength="20" placeholder="建议输入手机号码作为登录账号" class="layui-input" disabled style="background:#eee;" />
                </div>
            </div>
            <div class="layui-form-item" style="padding-top:10px;">
                <label class="layui-form-label">过期时间</label>
                <div class="layui-input-block">
                    <input type="date" name="out_date" id="out_date" value="<?php echo $store['out_date']; ?>" class="layui-input" />
                </div>
            </div>
            <input type="hidden" name="store_id" id="store_id" value="<?php echo $store['id']; ?>">
        </div>
        <div class="ending">
            <div class="total" id="data_save" >
                提交
            </div>
        </div>

    </form>


<div class="footer">
    <a class="maobin" href="/agent/index/index">
        <div class="footer_li ">
            <div class="footbiao">
                <img src="/assets/img/home_<?php if($html_name!='index'): ?>no<?php endif; ?>select.png">
            </div>
            <div class="footzi" <?php if($html_name=="index"): ?>style="color:#2196F3;"<?php endif; ?>>
                首页
            </div>
        </div>
    </a>
    <a class="maobin" href="/agent/store/index">
        <div class="footer_li ">
            <div class="footbiao">
                <img src="/assets/img/task_<?php if($html_name!='store'): ?>no<?php endif; ?>select.png">
            </div>
            <div class="footzi" <?php if($html_name=="store"): ?>style="color:#2196F3;"<?php endif; ?>>
                所属管理
            </div>
        </div>
    </a>
    <a class="maobin" href="/agent/user/info">
        <div class="footer_li ">
            <div class="footbiao">
                <img src="/assets/img/user_<?php if($html_name!='user'): ?>no<?php endif; ?>select.png">
            </div>
            <div class="footzi" <?php if($html_name=="user"): ?>style="color:#2196F3;"<?php endif; ?>>
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
            show_message(0, '商家名称不能为空', 2000, 1);
        }
        $.post("/agent/store/edit_store_post", {store_id:$('#store_id').val(),store_name:$('#store_name').val(),out_date:$('#out_date').val()}, function(ret) {
            if (ret.code == 0) {
                window.location.href = "/agent/store/index";
                return;
            }
            layer.msg(ret.msg);return;
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
