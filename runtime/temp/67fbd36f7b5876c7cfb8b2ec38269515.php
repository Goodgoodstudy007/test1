<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:75:"/www/wwwroot/douyin_xunpang/public/../application/store/view/task/info.html";i:1627895598;s:62:"/www/wwwroot/douyin_xunpang/application/store/view/footer.html";i:1627905460;}*/ ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>商家管理后台</title>
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
            .footbiao img{ width: 25px;height: 25px;margin-bottom: 8px; }
            .footer{height: 60px;padding-top: 10px;}
            .task_info_ul {padding: 10px;}
            .task_info_ul img{ width: 60px;height: 60px;border-radius: 50%;text-align: center;margin: 0px auto;display:block; border:1px solid #eee;margin-bottom: 10px;}
            .task_info_ul li{line-height: 35px;border-bottom: 1px solid #eee;clear: both;}
            .task_info_left{text-align: right;width: 25%;display: block;float: left;    color: #8c8c8c;}
            .task_info_right{width: 70%;margin-left: 5%;float: left;}
            .task_info_right font{color: orange}
            .task_info_data {padding: 15px;font-size: 14px;}
            .task_info_data span{margin-bottom: 15px;width: 48%;display: inline-block;}
            .task_info_data a{padding: 5px 10px;background: #2196F3;border-radius: 5px;color: #fff!important;}
            .task_info_edit{}
            .task_info_edit a{display: inline-block;width: 17%;height: 35px;line-height: 35px;text-align: center;color: #fff!important;background: #000;margin-left: 2%;}
        </style>
    </head>
    <body style="margin: 0 auto;background: #fff!important;">
        <header style="height: 50px;background: #fff;color: #ffffff;padding: 0px 10px 0px 20px;overflow: hidden;">
            <a href="javascript:history.back(-1)" style="    display: block;float: left;margin-top: 0.12rem;height: 0.64rem;width: 10%;"><img style="height: 20px !important;margin-top: 15px;" src="/assets/img/back_000.png"></a>
            <span style="font-size: 20px;color: #666;float: left;width: 80%;height: 40px;line-height: 50px;text-align: center;">任务详情 [ <?php echo $task['status_info']; ?> ]</span>
        </header>
        <div>
            <ul class="task_info_ul">
                <?php if($task['head']): ?>
                    <img src="<?php echo $task['head']; ?>">
                <?php endif; ?>
                <li>
                    <span class="task_info_left">任务名称：</span>
                    <span class="task_info_right"><?php echo $task['title']; ?>  </span>
                </li>
                <li>
                    <span class="task_info_left">采集源：</span>
                    <span class="task_info_right"><?php echo $task['url']; ?></span>
                </li>
                <?php if($task['username']): ?>
                <li>
                    <span class="task_info_left">用户昵称：</span>
                    <span class="task_info_right"><?php echo $task['username']; ?></span>
                </li>
                <?php endif; if($task['desc']): ?>
                <li>
                    <span class="task_info_left">简介：</span>
                    <span class="task_info_right" style="line-height: 20px;padding:10px 0px;"><?php echo $task['desc']; ?></span>
                </li>
                <?php endif; ?>
                <li>
                    <span class="task_info_left">咨询关键词：</span>
                    <span class="task_info_right"><?php echo $task['keywords']; ?></span>
                </li>
                <li>
                    <span class="task_info_left">视频消耗：</span>
                    <span class="task_info_right">最大视频数(<font><?php echo $task['dcount']; ?>个</font>)&nbsp;&nbsp;&nbsp;&nbsp;消耗点数:(<font><?php echo $task['price']; ?>点)</font></span>
                </li>
                <?php if($task['mode']==1): ?>
                <li>
                    <span class="task_info_left">其他数据：</span>
                    <span class="task_info_right">视频(<font><?php echo $task['video_count']; ?></font>)&nbsp;&nbsp;点赞:(<font><?php echo $task['zan']; ?></font>)&nbsp;&nbsp;粉丝:(<font><?php echo $task['fans']; ?></font>)&nbsp;&nbsp;关注:(<font><?php echo $task['follow']; ?></font>)</span>
                </li>
                <?php endif; ?>
                <li>
                    <span class="task_info_left">添加时间：</span>
                    <span class="task_info_right"><?php echo $task['addtime']; ?></span>
                </li>
                <div style="clear:both;width:100%;height:1px;"></div>
                <div class="task_info_data">
                    <span>
                        线索视频：  <a ><?php echo $vcount; ?>个</a>
                    </span>
                    <span>
                        潜在客户：  <a ><?php echo $ccount; ?>个</a>
                    </span>
                    <span >
                        手机号码：  <a ><?php echo $pcount; ?>个</a>
                    </span>
                    <span>
                        采集总次数：  <a ><?php echo $scount; ?>次</a>
                    </span>
                </div>
                <div class="task_info_edit">
                    <a id="update_status" onclick="update_status(<?php echo $task['id']; ?>,1)" style="background: #4CAF50;">启动</a>
                    <a onclick="update_status(<?php echo $task['id']; ?>,0)">暂停</a>
                    <a href="/store/task/videos?task_id=<?php echo $task['id']; ?>">视频</a>
                    <a href="/store/task/users?task_id=<?php echo $task['id']; ?>">客户</a>
                    <a href="/store/task/output?task_id=<?php echo $task['id']; ?>" style="background:#E91E63">导出</a>
                </div>
            </ul>
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

    // 更新状态
    function update_status(id,status){
        $.get("/store/task/update_status",{task_id: id,status:status},function (data) {
            if (data.code == 0) {   
                show_message(1, '更新成功', 3000, 1);
                setTimeout(function(){
                    window.location.href = "/store/task/info?task_id="+id;
                },2000);
                return;
            }
            show_message(0, data.msg, 3000, 1);
        },"json");
    }

</script>
    <Style>
    .layui-layer-btn .layui-layer-btn0{ background:#fd4835;background-color:#fd4835;color:#fff;border:1px solid #fd4835}
    </style>
</body>
</html>
<script type="text/javascript" src="/assets/js/mui.min.js" ></script>
<script>

</script>
