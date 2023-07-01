<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:81:"/www/wwwroot/douyin_xunpang/public/../application/admin/view/dashboard/index.html";i:1634020524;s:70:"/www/wwwroot/douyin_xunpang/application/admin/view/layout/default.html";i:1617358420;s:67:"/www/wwwroot/douyin_xunpang/application/admin/view/common/meta.html";i:1617358420;s:69:"/www/wwwroot/douyin_xunpang/application/admin/view/common/script.html";i:1629013468;}*/ ?>
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
    .sm-st{background:#fff;padding:20px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;margin-bottom:20px;-webkit-box-shadow:0 1px 0 rgba(0,0,0,.05);box-shadow:0 1px 0 rgba(0,0,0,.05)}
    .sm-st-icon{width:60px;height:60px;display:inline-block;line-height:60px;text-align:center;font-size:30px;background:#eee;-webkit-border-radius:5px;-moz-border-radius:5px;border-radius:5px;float:left;margin-right:10px;color:#fff}
    .sm-st-info{font-size:12px;padding-top:2px}
    .sm-st-info span{display:block;font-size:24px;font-weight:600}
    .orange{background:#fa8564!important}
    .tar{background:#45cf95!important}
    .sm-st .green{background:#86ba41!important}
    .pink{background:#ac75f0!important}
    .yellow-b{background:#fdd752!important}
    .stat-elem{background-color:#fff;padding:18px;border-radius:40px}
    .stat-info{text-align:center;background-color:#fff;border-radius:5px;margin-top:-5px;padding:8px;-webkit-box-shadow:0 1px 0 rgba(0,0,0,.05);box-shadow:0 1px 0 rgba(0,0,0,.05);font-style:italic}
    .stat-icon{text-align:center;margin-bottom:5px}
    .st-red{background-color:#f05050}
    .st-green{background-color:#27c24c}
    .st-violet{background-color:#7266ba}
    .st-blue{background-color:#23b7e5}
    .stats .stat-icon{color:#28bb9c;display:inline-block;font-size:26px;text-align:center;vertical-align:middle;width:50px;float:left}
    .stat{white-space:nowrap;overflow:hidden;text-overflow:ellipsis;display:inline-block}
    .stat .value{font-size:20px;line-height:24px;overflow:hidden;text-overflow:ellipsis;font-weight:500}
    .stat .name{overflow:hidden;text-overflow:ellipsis}
    .stat.lg .value{font-size:26px;line-height:28px}
    .stat.lg .name{font-size:16px}
    .stat-col .progress{height:2px}
    .stat-col .progress-bar{line-height:2px;height:2px}
    .item{padding:30px 0}
    #statistics .panel{min-height:150px}
    #statistics .panel h5{font-size:13px}

</style>

<div style="margin-bottom: 10px;">
    <a href="/CSiRHAJcsG.php/update" target="_blank" style="color:#fff;background:#222d32;display:inline-block;width:100px;height:35px;line-height:35px;text-align:center;margin-left:15px;border-radius:5px;" py="dlgl" pinyin="update"  url="/CSiRHAJcsG.php/update"  title="检查更新"><i class="fa fa-arrow-circle-down"></i> <span>检查更新</span> <span class="pull-right-container"> </span></a>
    <a href="/store.php" target="_blank" style="color:#fff;background:#419edd;display:inline-block;width:150px;height:35px;line-height:35px;text-align:center;margin-left:15px;border-radius:5px;" py="dlgl" pinyin="update"  title="商家电脑端入口"> <span>商家电脑端入口</span> <span class="pull-right-container"> </span></a> 
    <a href="/store/" target="_blank" style="color:#fff;background:#18bc9c;display:inline-block;width:150px;height:35px;line-height:35px;text-align:center;margin-left:15px;border-radius:5px;" py="dlgl" pinyin="update" title="商家移动端入口"> <span>商家移动端入口</span> <span class="pull-right-container"> </span></a> 
    <a href="/agent/" target="_blank" style="color:#fff;background:#726eb1;display:inline-block;width:150px;height:35px;line-height:35px;text-align:center;margin-left:15px;border-radius:5px;" py="dlgl" pinyin="update" title="代理端入口"> <span>代理端入口</span> <span class="pull-right-container"> </span></a> 
    <a href="https://www.yuque.com/books/share/88f3b4cb-55e3-4b6c-9302-85456def5a2d?# 《获客侠询盘》"  target="_blank"  style="color: #419edd;margin-left: 20px;font-size: 16px;font-weight: bold;">点我查看使用教程</a>
</div>
<div class="panel panel-default panel-intro">
        
    <div class="panel-body">



        <h1 style="text-align:center;margin-bottom:50px;font-weight:bold;font-family:'微软雅黑';color:#6763ac;"><?php echo htmlentities(mb_strtoupper(mb_substr($site['name'],0,8,'utf-8'),'utf-8')); ?></h1>
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="one">

                <div class="row">
                    <div class="col-sm-3 col-xs-6">
                        <div class="sm-st clearfix">
                            <span class="sm-st-icon st-red"><i class="fa fa-users"></i></span>
                            <div class="sm-st-info">
                                <span><?php echo $store_count; ?></span>
                                商家数
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="sm-st clearfix">
                            <span class="sm-st-icon st-violet"><i class="fa fa-magic"></i></span>
                            <div class="sm-st-info">
                                <span><?php echo $agent_one_count; ?></span>
                                一级代理
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="sm-st clearfix">
                            <span class="sm-st-icon st-green"><i class="fa fa-user"></i></span>
                            <div class="sm-st-info">
                                <span><?php echo $agent_sub_count; ?></span>
                                二级代理
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <div id="echart" class="btn-refresh" style="height:200px;width:100%;"></div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card sameheight-item stats">
                            <div class="card-block">
                                <div class="row row-sm stats-container">
                                    <div class="col-xs-6 stat-col">
                                        <div class="stat-icon"><i class="fa fa-rocket"></i></div>
                                        <div class="stat">
                                            <div class="value"> <?php echo $today_store_count; ?></div>
                                            <div class="name"> 今日商家</div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" style="width: 30%"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 stat-col">
                                        <div class="stat-icon"><i class="fa fa-vcard"></i></div>
                                        <div class="stat">
                                            <div class="value"> <?php echo $today_agent_one; ?></div>
                                            <div class="name"> 今日一级代理</div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" style="width: 25%"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6  stat-col">
                                        <div class="stat-icon"><i class="fa fa-calendar"></i></div>
                                        <div class="stat">
                                            <div class="value"> <?php echo $today_agent_sub; ?></div>
                                            <div class="name">今日二级代理</div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" style="width: 25%"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 stat-col">
                                        <div class="stat-icon"><i class="fa fa-calendar-plus-o"></i></div>
                                        <div class="stat">
                                            <div class="value"> <?php echo $today_store_pay; ?></div>
                                            <div class="name"> 今日充值</div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" style="width: 25%"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6  stat-col">
                                        <div class="stat-icon"><i class="fa fa-user-circle"></i></div>
                                        <div class="stat">
                                            <div class="value"> <?php echo $agent_commission; ?></div>
                                            <div class="name"> 今日分佣</div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" style="width: 25%"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6  stat-col">
                                        <div class="stat-icon"><i class="fa fa-user-circle-o"></i></div>
                                        <div class="stat">
                                            <div class="value"> <?php echo $thirty_pay; ?>元</div>
                                            <div class="name"> 30天内充值</div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" style="width: 25%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top:15px;" id="statistics">

                    <div class="col-lg-12">
                    </div>
                    <div class="col-xs-6 col-md-3">
                        <div class="panel bg-blue-gradient no-border">
                            <div class="panel-body">
                                <div class="panel-title">
                                    <span class="label label-primary pull-right"><?php echo __('Real time'); ?></span>
                                    <h5>运行任务</h5>
                                </div>
                                <div class="panel-content">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h1 class="no-margins"><?php echo $run_task; ?></h1>
                                            <div class="font-bold"><i class="fa fa-magic"></i>
                                                <small>当前运行中任务数</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-3">
                        <div class="panel bg-aqua-gradient no-border">
                            <div class="panel-body">
                                <div class="ibox-title">
                                    <span class="label label-primary pull-right"><?php echo __('Real time'); ?></span>
                                    <h5>全部任务</h5>
                                </div>
                                <div class="ibox-content">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h1 class="no-margins"><?php echo $all_task; ?></h1>
                                            <div class="font-bold"><i class="fa fa-database"></i>
                                                <small>全部任务总数</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-6 col-md-3">
                        <div class="panel bg-purple-gradient no-border">
                            <div class="panel-body">
                                <div class="ibox-title">
                                    <span class="label label-primary pull-right"><?php echo __('Real time'); ?></span>
                                    <h5>采集视频</h5>
                                </div>
                                <div class="ibox-content">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <h1 class="no-margins"><?php echo $all_video; ?></h1>
                                            <div class="font-bold"><i class="fa fa-files-o"></i>
                                                <small>已采集视频全部总数</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-3">
                        <div class="panel bg-green-gradient no-border">
                            <div class="panel-body">
                                <div class="ibox-title">
                                    <span class="label label-primary pull-right"><?php echo __('Real time'); ?></span>
                                    <h5>意向用户</h5>
                                </div>
                                <div class="ibox-content">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <h1 class="no-margins"><?php echo $all_comment; ?></h1>
                                            <div class="font-bold"><i class="fa fa-picture-o"></i>
                                                <small>已采集意向用户全部总数</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    

                </div>
            </div>
            <div class="tab-pane fade" id="two">
                <div class="row">
                    <div class="col-xs-12">
                        <?php echo __('Custom zone'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>
