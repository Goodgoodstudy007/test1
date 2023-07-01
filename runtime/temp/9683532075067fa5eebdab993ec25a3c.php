<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:85:"/www/wwwroot/douyin_xunpang/public/../application/storeadmin/view/store_task/add.html";i:1635435920;s:75:"/www/wwwroot/douyin_xunpang/application/storeadmin/view/layout/default.html";i:1617358420;s:72:"/www/wwwroot/douyin_xunpang/application/storeadmin/view/common/meta.html";i:1617358420;s:74:"/www/wwwroot/douyin_xunpang/application/storeadmin/view/common/script.html";i:1629014048;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">
<meta name="referrer" content="never">
<meta name="robots" content="noindex, nofollow">

<link rel="shortcut icon" href="/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<?php if(\think\Config::get('fastadmin.adminskin')): ?>
<link href="/assets/css/skins/<?php echo \think\Config::get('fastadmin.adminskin'); ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">
<?php endif; ?>

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/assets/js/html5shiv.js"></script>
  <script src="/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>

    </head>

    <body class="inside-header inside-aside <?php echo defined('IS_DIALOG') && IS_DIALOG ? 'is-dialog' : ''; ?>">
        <div id="main" role="main">
            <div class="tab-content tab-addtabs">
                <div id="content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <section class="content-header hide">
                                <h1>
                                    <?php echo __('Dashboard'); ?>
                                    <small><?php echo __('Control panel'); ?></small>
                                </h1>
                            </section>
                            <?php if(!IS_DIALOG && !\think\Config::get('fastadmin.multiplenav') && \think\Config::get('fastadmin.breadcrumb')): ?>
                            <!-- RIBBON -->
                            <div id="ribbon">
                                <ol class="breadcrumb pull-left">
                                    <?php if($auth->check('dashboard')): ?>
                                    <li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> <?php echo __('Dashboard'); ?></a></li>
                                    <?php endif; ?>
                                </ol>
                                <ol class="breadcrumb pull-right">
                                    <?php foreach($breadcrumb as $vo): ?>
                                    <li><a href="javascript:;" data-url="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                            <!-- END RIBBON -->
                            <?php endif; ?>
                            <div class="content">
                                <style type="text/css">
    #jiexi_btn {
    background: #000;
    color: #fff;
    width: 100px;display: inline-block;height: 35px;border-radius: 5px;line-height: 35px;text-align: center;font-size: 16px;cursor: pointer;
    margin-bottom: 10px;
    margin-top: 10px;
}
.recomm_keyword,.no_recomm_keyword{background: #3ca793;padding: 5px ;margin-bottom: 10px;margin-right: 10px;color: #fff;display: inline-block;cursor: pointer;}
 .delete_keyword{margin-left: 5px;color: #ccc;}
</style>
<form id="add-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">任务名:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-title" data-rule="required" class="form-control" name="row[title]" type="text" value="" placeholder="随意取一个名字吧">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">采集源:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-url" data-rule="required" class="form-control" name="row[url]" type="text" value="" placeholder="输入采集源">
            <p class="jiexi_result" style="display:none">
                昵称: <span class="jiexi_result_name">干饭人</span>
                <input type="hidden" name="row[desc]" class="desc">
                <input type="hidden" name="row[fans]" class="fans">
                <input type="hidden" name="row[follow]" class="follow">
                <input type="hidden" name="row[head]" class="head">
                <input type="hidden" name="row[userid]" class="userid">
                <input type="hidden" name="row[username]" class="username">
                <input type="hidden" name="row[zan]" class="zan">
                <input type="hidden" name="row[sec_user_id]" class="sec_user_id" value="">
                <input type="hidden" name="row[video_count]" class="video_count">
            </p>
            <?php if($mode==1): ?>
                <p style="margin-top:5px;color:#888;">D音app博主首页分享链接：https://v.douyin.com/espdeqQ/</p>
                <span id="jiexi_btn">解析链接</span>
            <?php elseif($mode==2): ?>
                <p style="margin-top:5px;color:#888;">D音app视频分享链接：https://v.douyin.com/e3CFn8C/</p>
            <?php elseif($mode==3): ?>
                <p style="margin-top:5px;color:#888;">筛选全网视频关键词，例如：北京二手车 </p>
            <?php endif; ?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">筛选关键词:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-keywords" class="form-control " rows="3" name="row[keywords]" cols="20"></textarea>
            <div class="layui-form-item" style="font-size:14px;">
                <div >系统推荐关键词 <font style="color:#ccc;font-size: 12px;">(点击关键词快速添加到词库)</font></div>
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
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">屏蔽关键词(选填):</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-no_keywords" class="form-control " rows="3" name="row[no_keywords]" cols="20"></textarea>
            <div class="layui-form-item" style="font-size:14px;">
                <div >系统推荐屏蔽关键词 <font style="color:#ccc;font-size: 12px;">(点击关键词快速添加到屏蔽关键词库)</font></div>
                <div class="input-group" style="margin-top:10px;">
                    <span class="no_recomm_keyword">假的</span>
                    <span class="no_recomm_keyword">联系我</span>
                    <span class="no_recomm_keyword">我有</span>
                    <span class="no_recomm_keyword">不要</span>
                    <span class="no_recomm_keyword">骗人</span>
                    <span class="no_recomm_keyword">联系我</span>
                    <span class="no_recomm_keyword">找我</span>
                </div>
            </div>
        </div>
    </div>
    <?php if($mode==3): ?>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">搜索排序:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="radio">
                <label>
                    <input type="radio" name="row[sort_type]" checked value="0">默认排序
                </label>
                <label>
                    <input type="radio" name="row[sort_type]"  value="1">最多点赞
                </label>
                <label>
                    <input type="radio" name="row[sort_type]" value="2">最新发布
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">发布时间:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="radio">
                <label>
                    <input type="radio" name="row[publish_time]" checked value="0">默认
                </label>
                <label>
                    <input type="radio" name="row[publish_time]"  value="1">一天内
                </label>
                <label>
                    <input type="radio" name="row[publish_time]" value="7">一周内
                </label>
                <label>
                    <input type="radio" name="row[publish_time]" value="182">半年内
                </label>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="form-group" style="display: none;">
        <label class="control-label col-xs-12 col-sm-2">是否自动关注:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="radio">
                <label>
                    <input type="radio" name="row[auto_follow]" checked value="0">不关注
                </label>
                <label>
                    <input type="radio" name="row[auto_follow]"  value="1">关注
                </label>
            </div>
            <p style="margin-top:5px;color:#888;">该功能需要先配置D音登录账号，否则选择不生效</p>
        </div>
    </div>
    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled" disabled="disabled" style="background:#ccc;"><?php echo __('OK'); ?></button>
        </div>
    </div>
    <input type="hidden" name="row[mode]" class="mode" value="<?php echo $mode; ?>">

</form>
<script type="text/javascript" src='/storeadmin/libs/jquery/dist/jquery.min.js?v=162913148'></script>

<input type="hidden" name="is_jiexi" class="is_jiexi" value="0">
<script type="text/javascript">
    var mode = <?php echo $mode; ?>;
    if(mode != 1){
        $('.is_jiexi').val(1);
        $('.btn-embossed').css('background','#fd4835');
        $('.btn-embossed').removeAttr('disabled');
    }

    $('#jiexi_btn').click(function(){
        douyin_url = $('#c-url').val();
        if(douyin_url==''){
            layer.msg('请填写博主主页分享链接');return;
        }
        layer.msg('解析中...',{time: 20000});
        $.post("/store/task/jiexi", {douyin_url:douyin_url}, function(ret) {
            if (ret.code == 0) {
                $('.jiexi_result').show();
                $('.jiexi_result_name').html(ret.data.username);
                $('.sec_user_id').val(ret.data.sec_user_id);
                $('.desc').val(ret.data.desc);
                $('.fans').val(ret.data.fans);
                $('.follow').val(ret.data.follow);
                $('.head').val(ret.data.head);
                $('.userid').val(ret.data.userid);
                $('.username').val(ret.data.username);
                $('.zan').val(ret.data.zan);
                $('.video_count').val(ret.data.video_count);
                $('.is_jiexi').val(1);
                $('.btn-embossed').css('background','#fd4835');
                $('.btn-embossed').removeAttr('disabled');
            }
            layer.close();
            layer.msg(ret.msg);return;
        }, 'json');
    });

    $('.recomm_keyword').click(function(){
        keyword = $(this).html();
        add_keyword(keyword);
    });

    function add_keyword(keyword){
        var add_keyword = $('#c-keywords').val();
        var has_keyword = add_keyword.split(',');
        for(var i=0;i<has_keyword.length;i++){
            if(has_keyword[i] == keyword){
                layer.msg('已存在');return;
            }
        }
        if($('#c-keywords').val() != ''){
            add_keyword = add_keyword+',';
        }
        add_keyword = add_keyword + keyword;

        $('#c-keywords').val(add_keyword);
        
        event.stopPropagation(); 
    }

    $('.no_recomm_keyword').click(function(){
        keyword = $(this).html();
        add_no_keyword(keyword);
    });

    function add_no_keyword(keyword){
        var add_keyword = $('#c-no_keywords').val();
        var has_keyword = add_keyword.split(',');
        for(var i=0;i<has_keyword.length;i++){
            if(has_keyword[i] == keyword){
                layer.msg('已存在');return;
            }
        }
        if($('#c-no_keywords').val() != ''){
            add_keyword = add_keyword+',';
        }
        add_keyword = add_keyword + keyword;

        $('#c-no_keywords').val(add_keyword);
        
        event.stopPropagation(); 
    }

</script>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/storeadmin/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/storeadmin/js/require-backend.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>
