<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:77:"/www/wwwroot/douyin_xunpang/public/../application/agent/view/store/index.html";i:1629907176;s:62:"/www/wwwroot/douyin_xunpang/application/agent/view/footer.html";i:1627542144;}*/ ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>代理管理后台</title>
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
            header{padding: 10px 0px;}
            header a{width: 100px;height: 40px;line-height: 40px;background:#2196F3;display: inline-block;text-align: center;color: #fff!important;}
            .layui-layer-btn1{background-color: #ccc !important;}
        </style>
    </head>
    <body style="margin: 0 auto;">
        <header>
            <a href="/agent/store/index">直属商家</a>
            <?php if($agent['level']==1): ?>
            <a href="/agent/store/agent_list" style="background:#81c7ff!important;">直属代理</a>
            <a href="/agent/store/sub_store" style="background:#81c7ff!important;">下级商家</a>
            <?php endif; ?>
        </header>
        <div class="top">
            <div class="top_one" style="padding-right: 0px;">
                <a href="/agent/store/add_store">
                    <div class="one_li" style="background: #fd4835;">
                        新建商家
                    </div>
                </a>
            </div>
        </div>
        <div class="huyong">
            <?php foreach($stores as $k=>$v): ?>
            <div class="bottmo" id="list<?php echo $v['id']; ?>">
                <div class="liebiao">
                    <div class="lie_top">
                        <div class="names">
                            <?php echo $v['store_name']; ?>                        
                        </div>
                    </div>
                    <div class="add_miss">
                        <div class="surplus" style="width:100%;">
                            充值总金额：<span><?php echo $v['all_price']; ?> 元</span>
                            <span style="float: right;font-size:14px;color:orange;">到期时间：<?php echo $v['out_date']; ?></span>
                        </div>
                    </div>
                    <div class="rise" id="info_45" >
                        <div class="lie_there">
                            <div class="money_sol">
                                剩余点数：<span><?php echo $v['price']; ?> 点</span>
                            </div>
                            <div class="money_sol">
                                运行任务：<span><?php echo $v['run_task']; ?> 个</span>
                            </div>
                        </div>
                        <div class="lie_four">
                            <a class="four_one" href="/agent/store/edit_store?store_id=<?php echo $v['id']; ?>"><span>编辑</span></a>
                            <a class="four_one" href="javascript:void(0)" onclick="pay_store(<?php echo $v['id']; ?>)" style="background: orange;"><span>充值</span></a>
                            <a class="four_two" href="javascript:void(0)" onclick="delete_store(<?php echo $v['id']; ?>)" style="background: #9c9c9c;"><span>删除</span></a>
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
    
    function pay_store(store_id){
        layer.prompt({
                formType: 0,
                value: '',
                title: '请输入充值点数',
                btn: ['确定','取消'], //按钮，
                btnAlign: 'c'
            }, function(value,index){
                // layer.close(index);
                $.ajax({
                    type:"post",
                    data:{"dianshu":value,'store_id':store_id},
                    url:"/agent/store/pay_store",
                    datatype:"json",
                    success:function(data){
                        console.log(data)
                        if(data.code != 0){
                            layer.msg(data.msg);
                            layer.close(index);
                            return ;
                        }else{
                            layer.msg(data.msg);
                            layer.close(index);
                            setTimeout(function(){
                                location.reload();
                            },2000);
                        }
                    }
                });
            }
        );
        
    }
    
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

    function delete_store(id) {
        var btnArray = ['确定', '取消'];
        var run_confim = false;
        mui.confirm('删除商家后数据不可恢复，你确定要删除吗？', '删除提示', btnArray, function (e) {
            if (e.index == 0 && !run_confim) {
                run_confim = true;
                $.get("/agent/store/delete_store",{"store_id": id},function (data) {
                    if (data.code == 0) {   
                        show_message(1, '删除成功', 3000, 1);
                        setTimeout(function(){
                            window.location.href = "/agent/store/index";
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
