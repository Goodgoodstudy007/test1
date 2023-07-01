<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:76:"/www/wwwroot/douyin_xunpang/public/../application/admin/view/agent/edit.html";i:1631451618;s:70:"/www/wwwroot/douyin_xunpang/application/admin/view/layout/default.html";i:1617358420;s:67:"/www/wwwroot/douyin_xunpang/application/admin/view/common/meta.html";i:1617358420;s:69:"/www/wwwroot/douyin_xunpang/application/admin/view/common/script.html";i:1629013468;}*/ ?>
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
                                <form id="edit-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">代理名称:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-agent_name" data-rule="required" class="form-control" name="row[agent_name]" type="text" value="<?php echo htmlentities($row['agent_name']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Agent_pid'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-agent_pid" data-rule="required" class="form-control" name="row[agent_pid]" type="number" value="<?php echo htmlentities($row['agent_pid']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Level'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <!-- <input id="c-level" data-rule="required" class="form-control" name="row[level]" type="number" value="<?php echo htmlentities($row['level']); ?>"> -->
            <select class="form-control" id="c-level" name="row[level]">
                <option class="form-control" <?php if($row['level']==1): ?>selected<?php endif; ?> value="1">一级代理</option>
                <option class="form-control" <?php if($row['level']==2): ?>selected<?php endif; ?> value="2">二级代理</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Store_count'); ?>数:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-store_count" data-rule="required" class="form-control" name="row[store_count]" type="number" value="<?php echo htmlentities($row['store_count']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Agent_count'); ?>数:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-agent_count" data-rule="required" class="form-control" name="row[agent_count]" type="number" value="<?php echo htmlentities($row['agent_count']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">剩余点数:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-dianshu"  class="form-control" name="row[dianshu]" type="number" value="<?php echo htmlentities($row['dianshu']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">充值分红(%):</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-rate"  class="form-control" name="row[rate]" type="number" value="<?php echo htmlentities($row['rate']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Username'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-username" data-rule="required" class="form-control" name="row[username]" type="text" value="<?php echo htmlentities($row['username']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Password'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-password"  class="form-control" name="row[password]" type="text" placeholder="留空不修改密码">
        </div>
    </div>
    <!-- <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Addtime'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-addtime" class="form-control datetimepicker" data-date-format="YYYY-MM-DD HH:mm:ss" data-use-current="true" name="row[addtime]" type="text" value="<?php echo $row['addtime']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Status'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-status" data-rule="required" class="form-control" name="row[status]" type="number" value="<?php echo htmlentities($row['status']); ?>">
        </div>
    </div> -->
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Out_date'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-out_date" class="form-control datetimepicker" data-date-format="YYYY-MM-DD" data-use-current="true" name="row[out_date]" type="text" value="<?php echo $row['out_date']; ?>">
        </div>
    </div>
    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
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
