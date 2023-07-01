<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:76:"/www/wwwroot/douyin_xunpang/public/../application/store/view/task/users.html";i:1629209520;s:62:"/www/wwwroot/douyin_xunpang/application/store/view/footer.html";i:1627905460;}*/ ?>

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
            .layui-layer-btn-c {color:#fff;}
            .footbiao img{ width: 25px;height: 25px;margin-bottom: 8px; }
            .footer{height: 60px;padding-top: 10px;}
            .task_info_ul {padding: 10px;margin-bottom: 10px;clear: both;background: #fff;display:block;}
            .task_info_ul img{ width: 50px;height: 50px;border-radius: 50%;text-align: center;margin: 0px auto;display:block; border:1px solid #eee;margin-bottom: 10px;}
            .task_info_ul li{line-height: 35px;border-bottom: 1px solid #eee;clear: both;display: flex;}
            .task_info_left{text-align: right;width: 25%;display: block;float: left;    color: #8c8c8c;}
            .task_info_right{width: 70%;margin-left: 5%;float: left;}
            .task_info_right font{color: orange}

        </style>
    </head>
    <body style="margin: 0 auto;">
        <header style="height: 50px;background: #fff;color: #ffffff;padding: 0px 10px 0px 20px;overflow: hidden;">
            <a href="javascript:history.back(-1)" style="    display: block;float: left;margin-top: 0.12rem;height: 0.64rem;width: 10%;"><img style="height: 20px !important;margin-top: 15px;" src="/assets/img/back_000.png"></a>
            <span style="font-size: 20px;color: #666;float: left;width: 80%;height: 40px;line-height: 50px;text-align: center;">潜在客户</span>
        </header>

        <div>
            <?php if($users): foreach($users as $k=>$v): ?>
                <ul class="task_info_ul">
                    <img src="<?php echo $v['head']; ?>">
                    <li>
                        <span class="task_info_left">线索视频：</span>
                        <span class="task_info_right"><?php echo msubstr($v['video_desc'],0,18,'utf-8'); ?></span>
                    </li>
                    <li>
                        <span class="task_info_left">咨询内容：</span>
                        <span class="task_info_right"><?php echo $v['comment']; ?></span>
                    </li>
                    <li>
                        <span class="task_info_left">用户昵称：</span>
                        <span class="task_info_right"><?php echo $v['username']; ?></span>
                    </li>
                    <li>
                        <span class="task_info_left">抖音号：</span>
                        <span class="task_info_right">
                            <?php echo $v['userid']; ?>
                            <span style="color:#999;" class="copy_url"  title="<?php echo $v['userid']; ?>"> (点击复制)</span>
                            <?php if($v['uid'] && $v['sec_uid']): ?>
                                <a href="snssdk1128://user/profile/<?php echo $v['uid']; ?>" target="_blank" style="color:#2196F3 !important;margin-left:10px;">[打开抖音]</a>
                            <?php endif; ?>
                        </span>
                    </li>
                    <?php if($v['phone']): ?>
                    <li>
                        <span class="task_info_left">手机号码：</span>
                        <span class="task_info_right"><a href="tel:<?php echo $v['phone']; ?>"><?php echo $v['phone']; ?></a></span>
                    </li>
                    <?php endif; if($v['other']): ?>
                    <li>
                        <span class="task_info_left">其他联系：</span>
                        <span class="task_info_right"><?php echo $v['other']; ?></span>
                    </li>
                    <?php endif; if($v['desc']): ?>
                    <li>
                        <span class="task_info_left">简介：</span>
                        <span class="task_info_right" style="line-height: 20px;padding:10px 0px;"><?php echo $v['desc']; ?></span>
                    </li>
                    <?php endif; ?>
                    <li>
                        <span class="task_info_left">咨询时间：</span>
                        <span class="task_info_right"><?php echo $v['comment_time']; ?></span>
                    </li>
                    <li>
                        <span class="task_info_left">挖掘时间：</span>
                        <span class="task_info_right"><?php echo $v['addtime']; ?></span>
                    </li>
                </ul>
                <?php endforeach; else: ?>
                <p style="text-align:center;padding:20px;">暂无数据</p>
            <?php endif; ?>
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
<textarea  id="copy_text" style="width:1px;height:1px;" readonly></textarea>
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

    $(".copy_url").click(function(){
        text = $(this).attr('title');
        $('#copy_text').html(text);
        var dcopy = document.getElementById("copy_text");
        dcopy.select();
        try {
            var flag = document.execCommand("copy");//执行复制
        } catch(eo) {
            var flag = false;
        }
        layer.msg(flag ? "复制成功！" : "复制失败！");
    })

</script>
    <Style>
    .layui-layer-btn .layui-layer-btn0{ background:#fd4835;background-color:#fd4835;color:#fff;border:1px solid #fd4835}
    </style>
</body>
</html>
<script type="text/javascript" src="/assets/js/mui.min.js" ></script>
<script>

</script>
