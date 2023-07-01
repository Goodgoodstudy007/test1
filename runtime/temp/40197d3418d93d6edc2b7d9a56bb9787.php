<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:87:"/www/wwwroot/douyin_xunpang/public/../application/storeadmin/view/xhs_follow/index.html";i:1635692720;s:75:"/www/wwwroot/douyin_xunpang/application/storeadmin/view/layout/default.html";i:1617358420;s:72:"/www/wwwroot/douyin_xunpang/application/storeadmin/view/common/meta.html";i:1617358420;s:74:"/www/wwwroot/douyin_xunpang/application/storeadmin/view/common/script.html";i:1629014048;}*/ ?>
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
</style>
<div class="panel panel-default panel-intro">
    <?php echo build_heading(); ?>

    <div class="panel-body">
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="one">
                <div class="widget-body no-padding">
                    <div id="toolbar" class="toolbar">
                        <a href="javascript:;" class="btn btn-primary btn-refresh" title="<?php echo __('Refresh'); ?>" ><i class="fa fa-refresh"></i> </a>
                        
                    </div>
                    <input type="hidden" name="token" class="token"  value="">
                    <div class="douyin_follow_content">
                        <div class="douyin_follow_notice">
                            <p>1、本系统不会记住您的账号信息，仅获取登录权限,用于采集数据 </p>
                            <p>2、小红书账号可绑定多个，为防止意外，<span style="color:red;">强烈建议用小号操作</span></p>
                            <p>3、获取authorization方法： <a href="https://www.yuque.com/docs/share/48faa3f7-e018-40bf-99d1-2a539cf1718d?# 《获取小红书登录账号authorization》" style="color:blue;" target="_blank"> 点我获取教程</a> </p>
                            <p>4、device-fingerprint是选填，填了会采集更加稳定</p>
                        </div>
                        
                        <div class="douyin_form">
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3">authorization:</label>
                                <div class="col-xs-12 col-sm-8" style="padding:0px;">
                                    <input id="c-authorization" data-rule="required" class="form-control" name="row[authorization]" type="text" value="" placeholder="请输入工具获取的authorization" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3">device-fingerprint:</label>
                                <div class="col-xs-12 col-sm-8" style="padding:0px;">
                                    <input id="c-device" class="form-control" name="row[device]" type="text" value="" placeholder="请输入工具获取的device-fingerprint" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3">账号名称:</label>
                                <div class="col-xs-12 col-sm-8" style="padding:0px;">
                                    <input id="c-title" data-rule="required" class="form-control" name="row[title]" type="text" value="" placeholder="随便写一个名称，最好是账号名/手机号，方便区分" >
                                </div>
                            </div>
                            
                            <p class="btn btn-success douyin_login">添加</p>

                            
                        </div>

                        <div class="douyin_follow_list">
                            <h2>登录账号列表</h2>
                            <ul class="douyin_follow_list_head">
                                <li>账号</li>
                                <li>状态</li>
                                <li>操作</li>
                            </ul>
                            <?php if($douyin_cookie): foreach($douyin_cookie as $k=>$v): ?>
                                    <ul>
                                        <li><?php echo $v['title']; ?></li>

                                        <li><?php if($v['status']==1): ?><span style="color:green;">生效</span><?php else: ?><span style="color:red;">已过期</span><?php endif; ?></li>
                                        <li>
                                            <span class="delete_cookie" data-id="<?php echo $v['id']; ?>">删除</span>
                                        </li>
                                    </ul>
                                <?php endforeach; else: ?>
                                <p style="margin-top:20px;color:#999;">暂无登录账号</p>
                            <?php endif; ?>
                        </div>
                        
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript" src="/storeadmin/libs/jquery/dist/jquery.min.js?v=1629984200"></script>
<script type="text/javascript">
    $('.douyin_login').click(function(){
        $('.douyin_login').attr('disabled','disabled');
        $('.douyin_login').css('background','#ccc');
        $('.douyin_login').html('添加中，请稍后...');
        $.post('/store.php/xhs_follow/get_cookie',{authorization:$('#c-authorization').val(),title:$('#c-title').val(),device:$('#c-device').val()},function(data){
            alert(data.msg);
            if(data.code != 2){
                window.location.reload();
            }
            
            $('.douyin_login').removeAttr('disabled');
            $('.douyin_login').css('background','#18bc9c');
            $('.douyin_login').html('添加');
        },'json');
    });

    $('.delete_cookie').click(function(){
        var flag=window.confirm("请确认是否删除该账号？");
        id = $(this).attr('data-id');
        if(flag==true){
            $.post('/store.php/ks_follow/delete_cookie',{id:id},function(data){
                alert(data.msg);
                window.location.reload();
            },'json');
        }else{ 
            return false;
        }
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
