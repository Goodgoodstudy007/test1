<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:75:"/www/wwwroot/douyin_xunpang/public/../application/store/view/task/edit.html";i:1627913152;s:62:"/www/wwwroot/douyin_xunpang/application/store/view/footer.html";i:1627905460;}*/ ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>商户管理后台</title>
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
            <span style="font-size: 20px;color: #666;float: left;width: 80%;height: 40px;line-height: 50px;text-align: center;">新建任务</span>
        </header>
        <form class="mui-input-group top_on"  method="post" enctype="multipart/form-data" id="activity_edit">
            <div class="layui-tab layui-tab-card" overflow="" style="padding:0px 10px;">

            <div class="layui-form-item" style="padding-top:10px;">
                <label class="layui-form-label">任务名称</label>
                <div class="layui-input-block">
                  <input type="text" name="title" id="title" value="<?php echo $store_task['title']; ?>" maxlength="20" placeholder="请输入任务名称" class="layui-input" />
                </div>
            </div>
            <div class="layui-form-item" >
                <label class="layui-form-label">链接</label>
                <div class="layui-input-block">
                  <input type="text" name="douyin_url" id="douyin_url" value="<?php echo $store_task['url']; ?>"  placeholder="抖音为app博主主页分享链接" class="layui-input" disabled="disabled" style="background:#eee" />
                </div>
            </div>
            
            <div class="layui-form-item" style="font-size:14px;margin-left:30px;">
                <div >咨询关键词 <font style="color:red">(精准的定位咨询内容包含的关键词用户)</font></div>
                <ul class="keyword_content">
                        <?php foreach($keywords as $k=>$v): ?>
                            <p><input type="hidden" name="keywords[]" class="keywords" value="<?php echo $v; ?>"><?php echo $v; ?><span class="delete_keyword" onclick="deleteElement(this)">X</span> </p>
                        <?php endforeach; ?>
                </ul>
                <div class="input-group" style="margin-top:10px;">
                    <input type="text" name="add_keyword" id="add_keyword" value=""  placeholder="输入新的词语添加至词库" class="layui-input" />
                    <span class="input-group-addon add_keyword_btn" style="background:#000;color:#fff;">添加</span>
                </div>
            </div>
            <div class="layui-form-item" style="font-size:14px;margin-left:30px;">
                <div >推荐关键词 <font style="color:red">(点击关键词快速添加到词库)</font></div>
                <div class="input-group" style="margin-top:10px;">
                    <span class="recomm_keyword">多少钱</span>
                    <span class="recomm_keyword">价格</span>
                    <span class="recomm_keyword">厂家</span>
                    <span class="recomm_keyword">哪里</span>
                    <span class="recomm_keyword">地址</span>
                    <span class="recomm_keyword">联系</span>
                    <span class="recomm_keyword">电话</span>
                    <span class="recomm_keyword">购买</span>
                    <span class="recomm_keyword">怎么买</span>
                    <span class="recomm_keyword">怎么卖</span>
                    <span class="recomm_keyword">售卖</span>
                    <span class="recomm_keyword">采购</span>
                    <span class="recomm_keyword">感兴趣</span>
                    <span class="recomm_keyword">有兴趣</span>
                    <span class="recomm_keyword">合作</span>
                    <span class="recomm_keyword">喜欢</span>
                    <span class="recomm_keyword">咋买</span>
                    <span class="recomm_keyword">咋卖</span>
                    <span class="recomm_keyword">下单</span>
                    <span class="recomm_keyword">怎么</span>
                </div>
            </div>
        </div>
        <div class="ending">
            <input type="hidden" name="mode" class="mode" value="<?php echo $store_task['mode']; ?>">
            <div class="total" id="data_save" >
                提交
            </div>
        </div>
        <input type="hidden" name="task_id" id="task_id" value="<?php echo $store_task['id']; ?>">
    </form>

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
        keywords = $('.keywords').map(function() {return this.value;}).get().join(',');

        $.post("/store/task/edit_post", {title:$('#title').val(),keywords:keywords,task_id:$('#task_id').val()}, function(ret) {
            if (ret.code == 0) {
                window.location.href = "/store/task/index?mode="+$('.mode').val();
                return;
            }
            layer.msg(ret.msg);return;
        }, 'json');
    });


    $('.add_keyword_btn').click(function(){
        keyword = $('#add_keyword').val();
        if(keyword=='' || keyword==null){
            layer.msg('请填写新词');return;
        }
        add_keyword(keyword);
        $('#add_keyword').val('');
    });
    // 推荐关键词
    $('.recomm_keyword').click(function(){
        keyword = $(this).html();
        add_keyword(keyword);
    });

    function add_keyword(keyword){
        is_has = 0;
        $(".keyword_content input[type=hidden]").each(function () {
            if(keyword == this.value){
                is_has = 1;
            }
        });
        if(is_has==1){
            layer.msg('已经存在');return;
        }
        html = '<p><input type="hidden" name="keywords[]" class="keywords" value="'+keyword+'">\
                    '+keyword+' <span class="delete_keyword" onclick="deleteElement(this)">X</span> </p>';
        $('.keyword_content').append(html);
        layer.msg('添加成功');
        event.stopPropagation(); 
    }

    function deleteElement(Obj){
        Obj.parentNode.parentNode.removeChild(Obj.parentNode);
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
