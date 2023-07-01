<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:87:"/www/wwwroot/douyin_xunpang/public/../application/storeadmin/view/ks_comment/index.html";i:1635176400;s:75:"/www/wwwroot/douyin_xunpang/application/storeadmin/view/layout/default.html";i:1617358420;s:72:"/www/wwwroot/douyin_xunpang/application/storeadmin/view/common/meta.html";i:1617358420;s:74:"/www/wwwroot/douyin_xunpang/application/storeadmin/view/common/script.html";i:1629014048;}*/ ?>
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
    <?php echo build_heading(); ?>

    <div class="panel-body">
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="one">
                <div class="widget-body no-padding">
                    <div id="toolbar" class="toolbar">
                        <a href="javascript:;" class="btn btn-primary btn-refresh" title="<?php echo __('Refresh'); ?>" ><i class="fa fa-refresh"></i> </a>
             
                        
                    </div>
                    <table id="table" class="table table-striped table-bordered table-hover"
                           data-operate-edit="<?php echo $auth->check('ks_comment/edit'); ?>" 
                           data-operate-del="<?php echo $auth->check('ks_comment/del'); ?>" 
                           width="100%">
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript" src='/storeadmin/libs/jquery/dist/jquery.min.js?v=162913148'></script>
<script type="text/javascript" src="/storeadmin/js/jquery.qrcode.min.js"></script>

<style type="text/css">
    .qrcode-popul{position: fixed;top: 0;left: 0;width: 100%;height: 100%;background: rgba(0,0,0,.6);z-index: 9999;}
    .qrcode-populBox{width: 400px;border: 2px solid #fff;margin: 10% auto 0;background: #fff;position: relative;height: 400px;}
    .qrcode-populBox h6{    text-align: center;height: 50px;width: 95%;margin: 0 auto;line-height: 50px;font-size: 18px;color: #007cc3;border-bottom: 1px solid #e8e8e8;}
    .qrcode-populText{padding: 30px 20px;line-height: 23px;font-size: 14px;}
    .closeQrcode{    position: absolute;top: 5px;right: 5px;font-size: 30px;color: #c3c3c3;font-weight: 700;cursor: pointer;}
    .qrcode-img{    display: block;width: 260px;height: 260px;margin: 0 auto;padding: 30px 0;}
    .erweima-main p{text-align: center;font-size: 16px;padding: 3px;}
    #doctor_name{color: #007cc3;font-size: 18px;font-weight: 600;}
</style>
<!-- <div id="qrcode" ></div> -->
<div class="qrcode-popul" style="display: none;">
    <div class="qrcode-populBox">
        <h6 class="qrcode-title">扫码私信</h6>
        <div class="erweima-main">
            <p style="height: 50px; line-height: 50px; display: none;" class="qrcode-default-img">正在加载二维码...</p>
            <div id="qrcode" class="qrcode-img"></div>
        </div>
        <span class="closeQrcode">×</span>
    </div>
</div>

<script>

$(function(){
    

    $('.closeQrcode').click(function(){
        $('.qrcode-popul').hide();
    });
    $('.service_btn_hdf').click(function(){
        $('.qrcode-popul').show();
    });
});
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