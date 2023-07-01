<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:77:"/www/wwwroot/douyin_xunpang/public/../application/store/view/index/index.html";i:1631801486;s:62:"/www/wwwroot/douyin_xunpang/application/store/view/footer.html";i:1627905460;}*/ ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>商家管理</title>
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
            .pay_btn{width: 70px;height:30px;line-height: 30px;background: orange;color: #fff;text-align: center;border-radius: 5px;font-size: 14px;display: inline-block;float: right;margin-right: 10px;margin-top: -25px;}
            .layui-layer-btn1{background-color: #ccc !important;}
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
                        商家：<?php echo $store['store_name']; ?>   <span style="    font-size: 12px;color: #FFEB3B;">[ 过期：<?php echo $store['out_date']; ?> ] </span>               
                    </div>
                    <div class="manes_one" style="margin-top: 5px;">
                        账号：<?php echo $store['username']; ?>  
                    </div>
                    <!--</div>-->
                </div>
            </div>
        </div>
        <div class="hongbao">
            <div class="jingxiang">
                <div>我的账户</div>
                <span class="pay_btn">充值点数</span>
            </div>
            <div class="yuen">
                <div class="yuen_bottmo">
                   <div class="yong">
                        <div class="yong_top">
                            累计充值
                        </div>
                        <div class="yong_bottmo" style="color: #ff7272;">
                            <?php echo $all_price; ?>   <span>点</span>
                        </div>
                    </div>
                     <div class="yong">
                        <div class="yong_top">
                            剩余点数
                        </div>
                        <div class="yong_bottmo" style="color: #ff7272;">
                            <?php echo $store['price']; ?>  <span>点</span>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
           
        
        <!--        活动
        -->        
        <div class="hongbao_two">
            <a href="/store/task/index">
                <div class="jingxiang">
                    我的任务
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
                    <div class="yong">
                        <div class="yong_top">
                            已暂停
                        </div>
                        <div class="yong_bottmo" style="    color: #F44336;">
                            <?php echo $stop_task; ?> <span>个</span>
                        </div>
                    </div>
                    <div class="yong">
                        <div class="yong_top">
                            已结束
                        </div>
                        <div class="yong_bottmo" style="color: #d6d6d6;">
                            <?php echo $finish_task; ?> <span>个</span>
                        </div>
                    </div>
                    
                
                </div>
            </div>
        </div>
        <div class="hongbao_two">
            <a href="">
                <div class="jingxiang">
                    任务数据统计
                </div>
            </a>
            <div class="yuen">

                <div class="yuen_bottmo">
                    <div class="yong">
                        <div class="yong_top">
                            任务数
                        </div>
                        <div class="yong_bottmo" >
                            <?php echo $all_task; ?> <span>个</span>
                        </div>
                    </div>
                    <div class="yong">
                        <div class="yong_top">
                            采集视频数
                        </div>
                        <div class="yong_bottmo" >
                            <?php echo $video_count; ?> <span>个</span>
                        </div>
                    </div>
                    <div class="yong">
                        <div class="yong_top">
                            意向用户数
                        </div>
                        <div class="yong_bottmo" >
                            <?php echo $user_count; ?> <span>个</span>
                        </div>
                    </div>
                    <div class="yong">
                        <div class="yong_top">
                            过滤总评论数
                        </div>
                        <div class="yong_bottmo" >
                            <?php echo $comment_count; ?> <span>个</span>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <input type="hidden" id="openid" value="<?php echo $openid; ?>">

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
    var dianshu = <?php echo $dianshu; ?>;
    document.getElementById("confirmBtn").addEventListener('tap', function() {
        var btnArray = ['否', '是'];
        mui.confirm('您确定要退出？', '提示', btnArray, function(e) {
            if (e.index == 1) {
                location.href = "/store/user/logout";
            }
        })
    });
    layui.use("layer",function(){
        var layer = layui.layer;  
    });


    $('.pay_btn').click(function(){
        pay();
    });

    if($('#openid').val() == ""){
        $('.pay_btn').hide();
    }

    function pay(){
        var ua = window.navigator.userAgent.toLowerCase();
        if(ua.match(/MicroMessenger/i) == 'micromessenger'){
            if($('#openid').val() == ""){
                layer.msg('微信授权失败，请刷新或退出重新登录');
                return ;
            }
            layer.prompt({
                    formType: 0,
                    value: '',
                    closeBtn:'1',
                    title: '1元='+dianshu+'点,最低充值1元',
                    btn: ['确定','取消'], //按钮，
                    btnAlign: 'c'
                }, function(value,index){
                    // layer.close(index);
                    
                    $.ajax({
                        type:"post",
                        data:{"num":value,'openid':$('#openid').val()},
                        url:"/store/index/pay",
                        datatype:"json",
                        success:function(data){
                            console.log(data)
                            if(data.code != 0){
                                if(data.code == 400){
                                    return;
                                }
                                layer.msg(data.msg);
                                return ;
                            }else{
                                layer.close(index);
                            }
                            data = data.data;
                            callpay(data.jsApiParameters);
                            is_call = 1;
                        }
                    });
                }
            );
        }else{
              //非微信环境逻辑
              layer.msg('请在微信浏览下打开');
              return ;
        }   
        return ;
        
    }
    
    function jsApiCall(pay)
    {
        WeixinJSBridge.invoke('getBrandWCPayRequest', JSON.parse(pay),
            function(res){
            WeixinJSBridge.log(res.err_msg);
            if(res.err_msg == "get_brand_wcpay_request:ok") {
                layer.msg('支付成功');
                setTimeout(function(){
                    location.reload();
                },2000);
                
            } else if (res.err_msg == "get_brand_wcpay_request:cancel"){
                /*location.reload(true);*/
                alert("已取消付费!");
            } else{
                layer.msg(res.err_msg);
                console.log(res.err_code + res.err_desc + res.err_msg);
            }
        });
    }
    
    function callpay(pay)
    {
        if (typeof WeixinJSBridge == "undefined"){
            if (document.addEventListener){
                document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
            } else if (document.attachEvent){
                document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
            }
        } else{
            jsApiCall(pay);
        }
    }
</script>
