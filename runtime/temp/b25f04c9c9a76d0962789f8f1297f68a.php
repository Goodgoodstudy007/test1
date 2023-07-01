<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:77:"/www/wwwroot/douyin_xunpang/public/../application/agent/view/index/index.html";i:1627572632;s:62:"/www/wwwroot/douyin_xunpang/application/agent/view/footer.html";i:1627542144;}*/ ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>代理商管理</title>
        <link rel="stylesheet" href="/assets/css/layui.css"/>
        <link rel="stylesheet" href="/assets/css/mui.css" />
        <link rel="stylesheet" href="/assets/css/after_index.css" />
        <link rel="stylesheet" href="/assets/css/bootstrap.css" />
        <script src="/assets/js/jquery-2.1.1.min.js"></script>
        <script src="/assets/js/layui.js"></script>
        <link rel="stylesheet" href="/assets/css/layer.css"/>
        <script src="/assets/js/layer.js"></script>
        <script src="https://res.wx.qq.com/open/js/jweixin-1.3.2.js" ></script>
        <Style>
            .layui-layer-btn-c {color:#fff;}
            .xinbeijing{background: #2196F3;}
            .manes_one,.manes_two{margin-left: 10px;}
            .jingxiang{text-align: center;font-size: 18px;font-weight: bold;padding-bottom: 10px;}
            .hongbao .yong {flex: unset; width: 50%;text-align: center;}
            .hongbao_two .yong {flex: unset; width: 33.3%;text-align: center;}
            .footbiao img{ width: 25px;height: 25px;margin-bottom: 8px; }
            .footer{height: 60px;padding-top: 10px;}
            .pay_btn{width: 60px;height:30px;line-height: 30px;background: orange;color: #fff;text-align: center;border-radius: 5px;font-size: 14px;display: inline-block;float: right;margin-right: 10px;margin-top: -25px;}
            .top{height: 100px;}
        </style>
    </head>
    <body style="margin: 0 auto;">
        <!--头部-->
        <div class="xinbeijing">
            <div class="dings">
                <div class="top_zuo">

                </div>
                <div class="top_zhong"></div>
                <div class="top_you" >
                    <div class="heiying_two">
                        <a href="javascript:void(0);">
                            <span class="icon-off" id="confirmBtn">退出</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="top">
                <div class="top_tu">
                    <div class="manes_one">
                        商家：<?php echo $agent['agent_name']; ?>   <span style="    font-size: 12px;color: #FFEB3B;">[ 过期：<?php echo $agent['out_date']; ?> ] </span>               
                    </div>
                    <div class="manes_one" style="margin-top: 5px;">
                        账号：<?php echo $agent['username']; ?>  <span style="    font-size: 12px;color: #FFEB3B;">[ 分红比例：<?php echo $agent['rate']; ?>% ] </span>
                    </div>
                    <div class="manes_one" style="margin-top: 5px;font-size:14px;">
                        <?php if($agent['level']==1): ?><span  style=" margin-right:20px;">可开代理：<?php echo $agent['agent_count']; ?>个  </span><?php endif; ?>
                        <span>可开商家：<?php echo $agent['store_count']; ?>个</span>
                    </div>
                    <!--</div>-->
                </div>
            </div>
        </div>
        <div class="hongbao_two">
            <div class="jingxiang">
                <div>我的账户</div>
                <a href="/agent/user/withdrawal">
                    <span class="pay_btn">提现</span>
                </a>
            </div>
            <div class="yuen">
                <div class="yuen_bottmo">
                    <div class="yong">
                        <div class="yong_top">
                            剩余点数
                        </div>
                        <div class="yong_bottmo" style="color: #ff7272;">
                            <?php echo $agent['dianshu']; ?>   <span>点</span>
                        </div>
                    </div>
                   <div class="yong">
                        <div class="yong_top">
                            历史总佣金
                        </div>
                        <div class="yong_bottmo" style="color: #ff7272;">
                            <?php echo $all_commission; ?>   <span>元</span>
                        </div>
                    </div>
                     <div class="yong">
                        <div class="yong_top">
                            可提现佣金
                        </div>
                        <div class="yong_bottmo" style="color: #ff7272;">
                            <?php echo $agent['commission']; ?>  <span>元</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
           
        <div class="hongbao">
            <div class="jingxiang">
                <div>我的商家充值</div>
            </div>
            <div class="yuen">
                <div class="yuen_bottmo">
                   <div class="yong">
                        <div class="yong_top">
                            商家总充值
                        </div>
                        <div class="yong_bottmo" style="color: #ff7272;">
                            <?php echo $all_price; ?>   <span>元</span>
                        </div>
                    </div>
                     <div class="yong">
                        <div class="yong_top">
                            今日充值
                        </div>
                        <div class="yong_bottmo" style="color: #ff7272;">
                            <?php echo $today_price; ?>  <span>元</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if($agent['level']==1): ?>
        <div class="hongbao" style="margin-top:10px;">
            <div class="jingxiang">
                <div>下级代理商家充值</div>
            </div>
            <div class="yuen">
                <div class="yuen_bottmo">
                   <div class="yong">
                        <div class="yong_top">
                            商家总充值
                        </div>
                        <div class="yong_bottmo" style="color: #ff7272;">
                            <?php echo $agent_all_price; ?>   <span>元</span>
                        </div>
                    </div>
                     <div class="yong">
                        <div class="yong_top">
                            今日充值
                        </div>
                        <div class="yong_bottmo" style="color: #ff7272;">
                            <?php echo $agent_today_price; ?>  <span>元</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="hongbao_two">
            <div class="jingxiang">
                <div>下属统计</div>
            </div>
            <div class="yuen">
                <div class="yuen_bottmo">
                     <div class="yong">
                        <div class="yong_top">
                            直属商家
                        </div>
                        <div class="yong_bottmo" style="color: #ff7272;">
                            <?php echo $store_count; ?>  <span>个</span>
                            
                        </div>
                    </div>
                    <?php if($agent['level']==1): ?>
                    <div class="yong">
                        <div class="yong_top">
                            直属代理
                        </div>
                        <div class="yong_bottmo" style="color: #ff7272;">
                            <?php echo $agent_count; ?>   <span>个</span>
                        </div>
                    </div>
                    <div class="yong">
                        <div class="yong_top">
                            下级商家
                        </div>
                        <div class="yong_bottmo" style="color: #ff7272;">
                            <?php echo $agent_store_count; ?>  <span>个</span>
                            
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!--        活动
        -->        
        <div class="hongbao_two">
            <a>
                <div class="jingxiang">
                    商家任务
                </div>
            </a>
            <div class="yuen">

                <div class="yuen_bottmo">
                    <div class="yong">
                        <div class="yong_top">
                            运行中
                        </div>
                        <div class="yong_bottmo" style="color: #4CAF50;">
                            <?php echo $run_task; ?> <span>个</span>
                        </div>
                    </div>
                
                </div>
            </div>
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
</script>
    <Style>
    .layui-layer-btn .layui-layer-btn0{ background:#fd4835;background-color:#fd4835;color:#fff;border:1px solid #fd4835}
    </style>
</body>
</html>
<script type="text/javascript" src="/assets/js/mui.min.js" ></script>
<script>
    document.getElementById("confirmBtn").addEventListener('tap', function() {
        var btnArray = ['否', '是'];
        mui.confirm('您确定要退出？', '提示', btnArray, function(e) {
            if (e.index == 1) {
                location.href = "/agent/user/logout";
            }
        })
    });
    layui.use("layer",function(){
        var layer = layui.layer;  
    });


</script>
