<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:75:"/www/wwwroot/douyin_xunpang/public/../application/admin/view/store/add.html";i:1634054460;s:70:"/www/wwwroot/douyin_xunpang/application/admin/view/layout/default.html";i:1617358420;s:67:"/www/wwwroot/douyin_xunpang/application/admin/view/common/meta.html";i:1617358420;s:69:"/www/wwwroot/douyin_xunpang/application/admin/view/common/script.html";i:1629013468;}*/ ?>
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
                                <form id="add-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-3"><?php echo __('Store_name'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-store_name" data-rule="required" class="form-control" name="row[store_name]" type="text" value="" placeholder="请输入商户名称">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-3"><?php echo __('Agent_id'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-agent_id" data-rule="required" class="form-control" name="row[agent_id]" type="text" value="0">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-3"><?php echo __('Username'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-username" data-rule="required" class="form-control" name="row[username]" type="text" value="" placeholder="请输入商户登录的账号，不能包含中文跟特殊字符">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-3"><?php echo __('Password'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-password" data-rule="required" class="form-control" name="row[password]" type="text" value="" placeholder="******">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-3">点数:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-price" class="form-control" name="row[price]" type="number" value="0">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-3">同时监控任务限制:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-task_count" class="form-control"  name="row[task_count]" type="number" value="0">
            <label style="font-weight:unset;color: #999;padding-top:5px;font-size: 12px;">限制商户只能同时监控X个任务，设置0则使用常规管理里面的统一配置</label>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-3">抖音任务视频限制:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-dy_count" class="form-control"  name="row[dy_count]" type="number" value="0">
            <label style="font-weight:unset;color: #999;padding-top:5px;font-size: 12px;">限制每个抖音任务最多采集X个视频，设置0则使用常规管理里面的统一配置</label>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-3">小红书任务笔记限制:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-xhs_count" class="form-control"  name="row[xhs_count]" type="number" value="0">
            <label style="font-weight:unset;color: #999;padding-top:5px;font-size: 12px;">限制每个小红书任务最多采集X个笔记，设置0则使用常规管理里面的统一配置</label>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-3">是否重复采集:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="radio">
                <label>
                    <input type="radio" name="row[is_repeat]" class="is_repeat" checked value="0">重复采集
                </label>
                <label>
                    <input type="radio" name="row[is_repeat]" class="is_repeat"  value="1">去重采集
                </label>
            </div>
            <label style="font-weight:unset;color: #999;padding-top:5px;font-size: 12px;">选择去重采集，即每个用户只采集一次，其他任务有出现该用户也不会采集</label>
        </div>
    </div>
    <!-- <div class="form-group">
        <label class="control-label col-xs-12 col-sm-3"><?php echo __('Status'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-status" data-rule="required" class="form-control" name="row[status]" type="number" value="1">
        </div>
    </div> -->
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-3"><?php echo __('Out_date'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-out_date" class="form-control datetimepicker" data-date-format="YYYY-MM-DD" data-use-current="true" name="row[out_date]" type="text" value="<?php echo date('Y-m-d'); ?>">
        </div>
    </div>
    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-3"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
</form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>
