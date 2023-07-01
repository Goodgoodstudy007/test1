<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:84:"/www/wwwroot/douyin_xunpang/public/../application/storeadmin/view/profile/index.html";i:1634822448;s:75:"/www/wwwroot/douyin_xunpang/application/storeadmin/view/layout/default.html";i:1617358420;s:72:"/www/wwwroot/douyin_xunpang/application/storeadmin/view/common/meta.html";i:1617358420;s:74:"/www/wwwroot/douyin_xunpang/application/storeadmin/view/common/script.html";i:1629014048;}*/ ?>
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
    .table {table-layout:fixed;} 
    .table td{text-overflow:ellipsis; overflow:hidden; white-space:nowrap; }
    .douyin_follow_content{text-align: center;font-size: 16px;font-family: "微软雅黑";padding-bottom: 50px;}
    .douyin_form{width: 800px;margin: 0 auto;}
    .douyin_login{margin: 20px auto;width: 150px;line-height: 25px;display: block;}
    .douyin_status{margin-top: 20px;color: #999;}
    .douyin_follow_list{width: 700px;margin:0 auto;display: block;}
    .douyin_follow_list h2{margin-top: 50px;margin-bottom: 20px;font-weight: bold;color: #18bc9c;}
    .douyin_follow_list ul{border-bottom:1px solid #ccc;padding: 0px;}
    .douyin_follow_list ul li{list-style: none;display: inline-block;width: 30%;text-align: center;padding: 10px 0px;color: #888;}
    .douyin_follow_list_head{border-top:1px solid #ccc;}
    .douyin_follow_list_head li{font-weight: bold;color: #000!important;}
    .delete_cookie{cursor: pointer;width: 60px;line-height: 30px;background: #ccc;text-align: center;display: inline-block;border-radius: 5px;color: #fff;}
    .form-group {margin-bottom: 10px;margin-top: 10px;text-align: right;display: block;height: 40px;line-height: 40px;}
    .form-group label{    font-weight: normal;margin-top: 5px;}
    .douyin_follow_notice{width: 800px;margin: 0 auto;}
    .douyin_follow_notice p{color:#999;text-align: left;line-height: 25px;}
    .get_qrcode{display: block;width: 80px;margin: 0 auto;}
    .douyin_form input{height: 40px;line-height: 40px;margin-top: 10px;}
    .get_code_btn{padding:0px;line-height: 40px;background: #18bc9c;color: #fff;margin-top: 10px;text-align: center;cursor: pointer;}
    .douyin_form input{border-radius: 5px;}
</style>
<div class="panel panel-default panel-intro">
    <?php echo build_heading(); ?>

    <div class="panel-body">
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="one">
                <div class="widget-body no-padding">
                    <div id="toolbar" class="toolbar">
                        <a href="javascript:void(0)" οnClick="location.reload()" class="btn btn-primary btn-refresh" title="<?php echo __('Refresh'); ?>" ><i class="fa fa-refresh"></i> </a>
                        
                    </div>
                    <form id="update-form" role="form" data-toggle="validator" method="POST" action="/store.php/profile">
                        <div class="douyin_follow_content">

                            <div class="douyin_form">
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3">账号昵称:</label>
                                    <div class="col-xs-12 col-sm-8" style="padding:0px;">
                                        <input id="c-store_name" data-rule="required" class="form-control" name="row[store_name]" type="text" value="<?php echo $store['store_name']; ?>" placeholder="请输入账号昵称" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3">登陆密码:</label>
                                    <div class="col-xs-12 col-sm-8" style="padding:0px;">
                                        <input id="c-password" class="form-control" name="row[new_password]" type="text" value="" placeholder="******（留空则不修改）" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3">到期时间:</label>
                                    <div class="col-xs-12 col-sm-8" style="padding:0px;">
                                        <input id="c-out_date" data-rule="required" class="form-control" name="row[out_date]" type="text" value="<?php echo $store['out_date']; ?>" disabled readonly="readonly" >
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3">百度地图AK:</label>
                                    <div class="col-xs-12 col-sm-8" style="padding:0px;">
                                        <input id="c-baidu_ak"  class="form-control" name="row[baidu_ak]" type="text" value="<?php echo $store['baidu_ak']; ?>" placeholder="请输入配置的百度地图应用AK" style="display:inline-block;width: 80%;">
                                        <a href="https://www.yuque.com/docs/share/387ce8c0-98f2-400d-8802-fd764ca37606?# 《百度地图应用AK获取教程》" target="_blank" style="font-size:14px;display:inline-block;width: 19%;">如何配置AK？</a>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-success" style="width:100px;line-height:30px;margin-top:20px;">修改</button>

                            </div>

                            
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript" src="/storeadmin/libs/jquery/dist/jquery.min.js?v=1629984200"></script>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/storeadmin/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/storeadmin/js/require-backend.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>
