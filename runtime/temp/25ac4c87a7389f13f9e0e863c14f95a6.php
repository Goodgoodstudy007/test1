<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:81:"/www/wwwroot/douyin_xunpang/public/../application/agent/view/user/withdrawal.html";i:1627541966;s:62:"/www/wwwroot/douyin_xunpang/application/agent/view/footer.html";i:1627542144;}*/ ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>代理商管理后台</title>
        <link rel="stylesheet" href="/assets/css/layui.css"/>
        <link rel="stylesheet" href="/assets/css/mui.css" />
        <link rel="stylesheet" href="/assets/css/activity.css" />
        <link rel="stylesheet" href="/assets/css/bootstrap.css" />
        <script src="/assets/js/jquery-2.1.1.min.js"></script>
        <script src="/assets/js/layui.js"></script>
        <link rel="stylesheet" href="/assets/css/layer.css"/>
        <script src="/assets/js/layer.js"></script>
        <script src="https://res.wx.qq.com/open/js/jweixin-1.3.2.js" ></script>
        <Style>
            .layui-layer-btn-c {color:#fff;}
            .footbiao img{ width: 25px;height: 25px;margin-bottom: 8px; }
            .footer{height: 60px;padding-top: 10px;}
            .pay_btn{width: 60px;height:30px;line-height: 30px;background: orange;color: #fff;text-align: center;border-radius: 5px;font-size: 14px;display: inline-block;float: right;margin-right: 10px;margin-top: -25px;}
            .show_time{font-size: 14px;color: #2196F3!important;width: 100px;}
            .cash_content{padding: 15px 0;}
            .huyong h2{background: #fff;font-size: 16px;padding: 10px;border-top:1px solid #eee; }
            #price{width: 50%;margin: 0 auto;display: block;border:1px solid #eee;border-radius: 5px;color: #777;padding-left: 5px;line-height: 35px;font-size: 14px;}
            .agent_commission{width: 100%;text-align: center;font-size: 14px;color: #888;display: block;padding: 6px 0;}
            .cash_btn{width: 80px;height: 35px;line-height: 35px;background: #2196F3;color: #fff!important;border-radius: 5px;text-align: center;display: block;margin: 0 auto;font-size: 14px;}
        </style>
    </head>
    <body style="margin: 0 auto;background:#fff !important;">
        <header style="height: 50px;background: #fff;color: #ffffff;padding: 0px 10px 0px 20px;overflow: hidden;">
            <a href="javascript:history.back(-1)" style="    display: block;float: left;margin-top: 0.12rem;height: 0.64rem;width: 10%;"><img style="height: 20px !important;margin-top: 15px;" src="/assets/img/back_000.png"></a>
            <span style="font-size: 20px;color: #666;float: left;width: 80%;height: 40px;line-height: 50px;text-align: center;">提现管理</span>
        </header>
        <!-- 提现操作 -->
        <div class="cash_content">
            <input type="number" name="price" id="price" placeholder="请输入提现金额">
            <span class="agent_commission">可提现金额：<?php echo $agent['commission']; ?> 元，最低提现100元</span>
            <a class="cash_btn">提现</a>
        </div>
        <div class="huyong" style="background:#f5f5f5;">
            <h2>提现记录</h2>
            <?php foreach($withdrawals as $k=>$v): ?>
            <div class="bottmo" id="list<?php echo $v['id']; ?>">
                <div class="liebiao">
                    <div class="lie_top">
                        <div class="names">
                            提现金额： <span style="color:orange;"><?php echo $v['price']; ?> 元  </span>                   
                        </div>
                    </div>
                    <div class="add_miss">
                        <div class="surplus" style="width:100%;">
                            提现时间：<?php echo $v['addtime']; ?>
                            <span style="float: right;font-size:14px;<?php if($v['status']==1): ?>color:orange;<?php elseif($v['status']==2): ?>color:green;<?php else: ?>color:red;<?php endif; ?>">状态：<?php echo $v['status_info']; ?></span>
                        </div>
                    </div>
                    <div class="rise" id="info_45" >
                        <div class="lie_there">
                            <div class="money_sol">
                                <?php if($v['status']==3): ?>失败原因：<span style="color:red;"><?php echo $v['reason']; ?></span><?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
    </div>


  
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
    
    $(".guang .dialogs_bottmo").click(function(){
    $(".code_ok").hide();
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

    $('.cash_btn').click(function(){
        price = $('#price').val();
        if(price <= 0){
            show_message(0, '提现金额输入有误', 2000, 1);
        }

        $.post("/agent/user/withdrawal_post", {price:$('#price').val()}, function(ret) {
            if (ret.code == 0) {
                layer.msg(ret.msg);
                setTimeout(function(){
                    window.location.href = "/agent/user/withdrawal";
                },2000);
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
