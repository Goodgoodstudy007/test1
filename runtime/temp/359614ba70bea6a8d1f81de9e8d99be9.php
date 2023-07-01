<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:80:"/www/wwwroot/douyin_xunpang/public/../application/admin/view/command/detail.html";i:1625625958;s:70:"/www/wwwroot/douyin_xunpang/application/admin/view/layout/default.html";i:1617358420;s:67:"/www/wwwroot/douyin_xunpang/application/admin/view/common/meta.html";i:1617358420;s:69:"/www/wwwroot/douyin_xunpang/application/admin/view/common/script.html";i:1629013468;}*/ ?>
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
                                <table class="table table-striped">
    <thead>
    <tr>
        <th><?php echo __('Title'); ?></th>
        <th><?php echo __('Content'); ?></th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><?php echo __('Type'); ?></td>
        <td><?php echo $row['type']; ?>(<?php echo $row['type_text']; ?>)</td>
    </tr>
    <tr>
        <td><?php echo __('Params'); ?></td>
        <td><?php echo $row['params']; ?></td>
    </tr>
    <tr>
        <td><?php echo __('Command'); ?></td>
        <td><?php echo $row['command']; ?></td>
    </tr>
    <tr>
        <td><?php echo __('Content'); ?></td>
        <td>
            <textarea class="form-control" name="" id="" cols="60" rows="10"><?php echo $row['content']; ?></textarea>
        </td>
    </tr>
    <tr>
        <td><?php echo __('Executetime'); ?></td>
        <td><?php echo datetime($row['executetime']); ?></td>
    </tr>
    <tr>
        <td><?php echo __('Status'); ?></td>
        <td><?php echo $row['status_text']; ?></td>
    </tr>
    </tbody>
</table>
<div class="hide layer-footer">
    <label class="control-label col-xs-12 col-sm-2"></label>
    <div class="col-xs-12 col-sm-8">
        <button type="reset" class="btn btn-primary btn-embossed btn-close" onclick="Layer.closeAll();"><?php echo __('Close'); ?></button>
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
