<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:76:"/www/wwwroot/douyin_xunpang/public/../application/store/view/task/index.html";i:1627978990;s:62:"/www/wwwroot/douyin_xunpang/application/store/view/footer.html";i:1627905460;}*/ ?>

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
            .xinbeijing{background: #2196F3;}
            .manes_one,.manes_two{margin-left: 10px;}
            .jingxiang{text-align: center;font-size: 18px;font-weight: bold;padding-bottom: 10px;}
            .hongbao .yong {flex: unset; width: 50%;text-align: center;}
            .hongbao_two .yong {flex: unset; width: 33.3%;text-align: center;}
            .footbiao img{ width: 25px;height: 25px;margin-bottom: 8px; }
            .footer{height: 60px;padding-top: 10px;}
            .pay_btn{width: 60px;height:30px;line-height: 30px;background: orange;color: #fff;text-align: center;border-radius: 5px;font-size: 14px;display: inline-block;float: right;margin-right: 10px;margin-top: -25px;}
            .show_time{font-size: 14px;color: #2196F3!important;width: 100px;}
            .top_one a{margin-left: 5%;}
        </style>
    </head>
    <body style="margin: 0 auto;">
        <?php if($is_add==1): ?>
        <div class="top" style="padding:0px;background:#fff;">
            <div class="top_one">
                <?php if($mode==1): ?>
                <a href="/store/task/add?mode=1">
                    <div class="one_li" style="background: #2196F3;">
                        新建主页监控
                    </div>
                </a>
                <?php endif; if($mode==2): ?>
                <a href="/store/task/add?mode=2">
                    <div class="one_li" style="background: #2196F3;">
                        新建单视频监控
                    </div>
                </a>
                <?php endif; if($mode==3): ?>
                <a href="/store/task/add?mode=3">
                    <div class="one_li" style="background: #2196F3;">
                        新建关键词监控
                    </div>
                </a>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="top">
            
            <div class="top_two">
                <a class="btn_there vious" href="/store/task/index?status=1&mode=<?php echo $mode; ?>" style="border-radius:0px;margin-right:0px;color:#fff!important;">运行中</a>
                <a class="btn_two vious" href="/store/task/index?status=0&mode=<?php echo $mode; ?>" style="border-radius:0px;margin-right:0px;color:#fff!important;    background: #F44336;">已暂停</a>
                <a class="btn_one vious" href="/store/task/index?status=2&mode=<?php echo $mode; ?>" style="border-radius:0px;margin-right:0px;color:#fff!important;">已结束</a>
            </div>
        </div>
        <div class="huyong">
            <?php foreach($tasks as $k=>$v): ?>
            <div class="bottmo" id="list<?php echo $v['id']; ?>">
                <div class="liebiao">
                    <div class="lie_top">
                        <div class="names">
                            <span style="<?php if($v['status']==1): ?>color: #3dc34a<?php elseif($v['status']==2): ?>color: #9d9ca4<?php else: ?>color: #F44336<?php endif; ?>">[<?php echo $v['status_info']; ?>]</span> <?php echo $v['title']; ?>                        
                        </div>
                    </div>
                    <div class="lie_two" >
                        <div class="litwo_san" style="right: 2%;">
                            <a class="show_time" href="/store/task/info?task_id=<?php echo $v['id']; ?>">
                                [询盘详情]
                            </a>
                        </div>
                    </div>
                    <div class="add_miss">
                        <div class="surplus">
                            消耗：<span><?php echo $v['price']; ?> 点数</span>
                        </div>
                    </div>
                    <div class="rise" id="info_45" >
                        <div class="lie_there">
                            <!-- <div class="money_sol">
                                视频最大数：<span><?php echo $v['dcount']; ?>个</span>
                            </div> -->
                            <div class="money_sol">
                                采集视频：<span><?php echo $v['vcount']; ?>个</span>
                            </div>
                            <div class="money_sol">
                                意向用户：<span><?php echo $v['ccount']; ?>个</span>
                            </div>
                        </div>
                        <div class="lie_four">
                            <a class="four_one" href="/store/task/edit?task_id=<?php echo $v['id']; ?>"><span>编辑</span></a>
                            <a class="four_two" href="javascript:void(0)" onclick="delete_activity(<?php echo $v['id']; ?>)"><span>删除</span></a>

                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
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

    function show_code(url,activitytype){
                    $(".dialogs_center img").attr("src",url);
                    $(".codetext").hide();
                    $(".codetext"+activitytype).show();
                    $(".code").show();
                }

    function delete_activity(id) {
        var btnArray = ['确定', '取消'];
        var run_confim = false;
        mui.confirm('删除任务不退回余额，你确定要删除任务吗？', '删除提示', btnArray, function (e) {
            if (e.index == 0 && !run_confim) {
                run_confim = true;
                $.get("/store/task/delete",{"task_id": id},function (data) {
                    if (data.code == 0) {   
                        show_message(1, '删除成功', 3000, 1);
                        setTimeout(function(){
                            window.location.href = "/store/task/index";
                        },2000);
                        return;
                    }
                    show_message(0, data.msg, 3000, 1);
                },"json");
            }
        });
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
