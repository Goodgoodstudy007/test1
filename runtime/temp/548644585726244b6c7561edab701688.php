<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:86:"/www/wwwroot/douyin_xunpang/public/../application/storeadmin/view/store_task/edit.html";i:1634055642;s:75:"/www/wwwroot/douyin_xunpang/application/storeadmin/view/layout/default.html";i:1617358420;s:72:"/www/wwwroot/douyin_xunpang/application/storeadmin/view/common/meta.html";i:1617358420;s:74:"/www/wwwroot/douyin_xunpang/application/storeadmin/view/common/script.html";i:1629014048;}*/ ?>
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
                                <div class="panel panel-default panel-intro">

    <div class="panel-body">
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="one">
                <div class="widget-body no-padding">
                    <div id="toolbar" class="toolbar">
                        <a href="javascript:;" onclick="location.reload()"  class="btn btn-primary btn-refresh" title="<?php echo __('Refresh'); ?>" ><i class="fa fa-refresh"></i> </a>
                        <a href="javascript:history.back(-1)" class="btn btn-success btn-add "  >返回</a>                        
                    </div>
                    

                    <form id="edit-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">
                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-2">任务名:</label>
                            <div class="col-xs-12 col-sm-8">
                                <input id="c-title" data-rule="required" class="form-control" disabled type="text" value="<?php echo htmlentities($row['title']); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-2">采集源:</label>
                            <div class="col-xs-12 col-sm-8">
                                <input id="c-url" data-rule="required" class="form-control" disabled type="text" value="<?php echo htmlentities($row['url']); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-2">筛选关键词:</label>
                            <div class="col-xs-12 col-sm-8">
                                <textarea id="c-keywords" class="form-control "  data-rule="required" rows="3" name="row[keywords]" cols="20"><?php echo htmlentities($row['keywords']); ?></textarea>
                                <p style="margin-top:5px;color:#888;">多个关键词，请用逗号隔开，如：怎么，哪里，地址，在哪儿，购买，我想要，联系，电话，地址，厂家，价格，多少钱，合作，喜欢，有兴趣，采购，怎么卖，怎么买，哪里买</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-2">屏蔽关键词(选填):</label>
                            <div class="col-xs-12 col-sm-8">
                                <textarea id="c-no_keywords" class="form-control "  rows="3" name="row[no_keywords]" cols="20"><?php echo htmlentities($row['no_keywords']); ?></textarea>
                                <p style="margin-top:5px;color:#888;">多个关键词，请用逗号隔开，如：假的，联系我，我有，不要</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-2">任务状态:</label>
                            <div class="col-xs-12 col-sm-8">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="row[status]" <?php if($row['status']==0): ?>checked<?php endif; ?>  value="0">暂停采集
                                    </label>
                                    <label>
                                        <input type="radio" name="row[status]" <?php if($row['status']==1): ?>checked<?php endif; ?> value="1">运行中
                                    </label>
                                    <label>
                                        <input type="radio" name="row[status]"<?php if($row['status']==2): ?>checked<?php endif; ?>  value="2">完成
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group layer-footer">
                            <label class="control-label col-xs-12 col-sm-2"></label>
                            <div class="col-xs-12 col-sm-8">
                                <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
                            </div>
                        </div>
                    </form>
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
        <script src="/storeadmin/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/storeadmin/js/require-backend.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>
