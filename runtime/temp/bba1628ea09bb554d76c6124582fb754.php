<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:82:"/www/wwwroot/douyin_xunpang/public/../application/storeadmin/view/index/index.html";i:1630589890;s:72:"/www/wwwroot/douyin_xunpang/application/storeadmin/view/common/meta.html";i:1617358420;s:74:"/www/wwwroot/douyin_xunpang/application/storeadmin/view/common/header.html";i:1630589926;s:72:"/www/wwwroot/douyin_xunpang/application/storeadmin/view/common/menu.html";i:1635759598;s:75:"/www/wwwroot/douyin_xunpang/application/storeadmin/view/common/control.html";i:1617358420;s:74:"/www/wwwroot/douyin_xunpang/application/storeadmin/view/common/script.html";i:1629014048;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <!-- 加载样式及META信息 -->
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
    <body class="hold-transition <?php echo (\think\Config::get('fastadmin.adminskin') ?: 'skin-black-green'); ?> sidebar-mini fixed <?php echo \think\Config::get('fastadmin.multipletab')?'multipletab':''; ?> <?php echo \think\Config::get('fastadmin.multiplenav')?'multiplenav':''; ?>" id="tabs">

        <div class="wrapper">

            <!-- 头部区域 -->
            <header id="header" class="main-header">
                <?php if(preg_match('/\/admin\/|\/admin\.php|\/admin_d75KABNWt\.php/i', url())): ?>
                <div class="alert alert-danger-light text-center" style="margin-bottom:0;border:none;">
                    <?php echo __('Security tips'); ?>
                </div>
                <?php endif; ?>

                <!-- Logo -->
<a href="javascript:;" class="logo" style="background-color: #3F51B5;">
    <!-- 迷你模式下Logo的大小为50X50 -->
    <span class="logo-mini"><?php echo htmlentities(mb_strtoupper(mb_substr($site['name'],0,4,'utf-8'),'utf-8')); ?></span>
    <!-- 普通模式下Logo -->
    <span class="logo-lg"><?php echo htmlentities($site['name']); ?></span>
</a>

<!-- 顶部通栏样式 -->
<nav class="navbar navbar-static-top" style="background-color: #000530;">

    <!--第一级菜单-->
    <div id="firstnav">
        
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- 账号信息下拉框 -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs" style="color:#fff;"><?php echo htmlentities($store_name); ?></span>
                    </a>
                        <!-- Menu Footer-->
                        <li class="user-footer" style="margin-top: 10px;margin-right:20px;">
                            <div class="pull-right">
                                <a href="<?php echo url('index/logout'); ?>" class="btn btn-danger"><i class="fa fa-sign-out"></i>
                                    <?php echo __('Logout'); ?></a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

</nav>

            </header>

            <!-- 左侧菜单栏 -->
            <aside class="main-sidebar" style="background-color: #000530;">
                <!-- 左侧菜单栏 -->
<section class="sidebar">
    <!-- 管理员信息 -->
    <div class="user-panel hidden-xs" style="height: 60px;">
        <div class="pull-left image">
           <img src="<?php echo htmlentities(cdnurl($admin_avatar)); ?>" class="img-circle" />
        </div>
        <div class="pull-left info" style="padding:0px;text-align: left;    margin-top: 5px;left: 65px;">
            <p><?php echo htmlentities($store_name); ?></p>
            <i class="fa fa-circle text-success"></i> 到期:<?php echo $out_date; ?>
        </div>
    </div>

    <!-- 菜单搜索 -->
 <!--    <form action="" method="get" class="sidebar-form" onsubmit="return false;">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="<?php echo __('Search menu'); ?>">
            <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
            </span>
            <div class="menuresult list-group sidebar-form hide">
            </div>
        </div>
    </form> -->

    <!-- 移动端一级菜单 -->
    <div class="mobilenav visible-xs">

    </div>
    <style type="text/css">
        .treeview-menu li{padding-left:30px;}
        .treeview-menu{display: none;}
        .skin-black-green .treeview-menu > li.active > a {background-color: #3f51b5;}
        .skin-black-green .sidebar-menu > li.active > a {color: #fff;background: #3f51b5;border-left-color: #18bc9c;}
        .sidebar-menu .treeview-menu > li > a {padding: 10px 5px 10px 15px;display: block;font-size: 12px;}
        a{cursor: pointer;}
    </style>
    <!--如果想始终显示子菜单,则给ul加上show-submenu类即可,当multiplenav开启的情况下默认为展开-->
    <ul class="sidebar-menu <?php if(\think\Config::get('fastadmin.multiplenav')): ?>show-submenu<?php endif; ?>" style="margin-top:20px;">
        <li <?php if($menu_url==''): ?>class="active"<?php endif; ?>><a href="/store.php/index" py="kzt" pinyin="kongzhitai" title="控制台"><i class="fa fa-dashboard fa-fw"></i> <span>控制台</span> <span class="pull-right-container"> <small class="label pull-right bg-blue">hot</small></span></a> </li>

        <li  class="treeview-menu-douyin"><a ><i class="fa fa-handshake-o fa-fw"></i> M音获客<i style="float:right" class="fa fa-angle-left"></i></a> </li>
        <ul class="treeview-menu menu-open treeview-menu-douyin-content" <?php if(in_array($menu_url,["store_task1","store_task2","store_task3","task_video","video_comment","douyin_follow"])): ?>style="display: block;"<?php endif; ?>>
            <li <?php if($menu_url=='store_task1'): ?>class="active"<?php endif; ?>><a href="/store.php/index?jump_url=store_task&menu_url=store_task1&mode=1"  py="dlgl" pinyin="dailiguanli" title="同行主页监控"><i class="fa fa-handshake-o fa-fw"></i> <span>同行监控</span> <span class="pull-right-container"> </span></a> </li>

            <li <?php if($menu_url=='store_task3'): ?>class="active"<?php endif; ?>><a href="/store.php/index?jump_url=store_task&menu_url=store_task3&mode=3"  py="dlgl" pinyin="dailiguanli" title="关键词监控"><i class="fa fa-search fa-fw"></i> <span>关键词监控</span> <span class="pull-right-container"> </span></a> </li>

            <li <?php if($menu_url=='store_task2'): ?>class="active"<?php endif; ?>><a href="/store.php/index?jump_url=store_task&menu_url=store_task2&mode=2"  py="dlgl" pinyin="dailiguanli" title="单视频监控"><i class="fa fa-video-camera fa-fw"></i> <span>单视频监控</span> <span class="pull-right-container"> </span></a> </li>

            <li <?php if($menu_url=='task_video'): ?>class="active"<?php endif; ?>><a href="/store.php/index?jump_url=task_video&menu_url=task_video"  py="dlgl" pinyin="dailiguanli" title="全部视频"><i class="fa fa-file-video-o fa-fw"></i> <span>视频库</span> <span class="pull-right-container"> </span></a> </li>

            <li <?php if($menu_url=='video_comment'): ?>class="active"<?php endif; ?>><a href="/store.php/index?jump_url=video_comment&menu_url=video_comment"  py="dlgl" pinyin="dailiguanli" title="客户管理"><i class="fa fa-address-book-o fa-fw"></i> <span>客户库</span> <span class="pull-right-container"> </span></a> </li>

            <!-- <li <?php if($menu_url=='douyin_follow'): ?>class="active"<?php endif; ?>><a href="/store.php/index?jump_url=douyin_follow&menu_url=douyin_follow"  py="dlgl" pinyin="dailiguanli" title="抖音账号配置"><i class="fa fa-commenting-o fa-fw"></i> <span>M音账号配置</span> <span class="pull-right-container"> </span></a> </li> -->
        </ul>

        <li class="treeview-menu-xhs"><a  ><i class="fa fa-address-book fa-fw"></i> 小红薯获客<i style="float:right" class="fa fa-angle-left"></i></a> </li>
            <ul class="treeview-menu menu-open treeview-menu-xhs-content" <?php if(in_array($menu_url,["xhs_task","xhs_note","xhs_comment","xhs_follow"])): ?>style="display: block;"<?php endif; ?>>
                <li <?php if($menu_url=='xhs_task'): ?>class="active"<?php endif; ?>><a href="/store.php/index?jump_url=xhs_task&menu_url=xhs_task"  py="dlgl" pinyin="dailiguanli" title="关键词监控"><i class="fa fa-video-camera fa-fw"></i> <span>关键词监控</span> <span class="pull-right-container"> </span></a> </li>

                <li <?php if($menu_url=='xhs_note'): ?>class="active"<?php endif; ?>><a href="/store.php/index?jump_url=xhs_note&menu_url=xhs_note"  py="dlgl" pinyin="dailiguanli" title="全部视频"><i class="fa fa-file-video-o fa-fw"></i> <span>笔记库</span> <span class="pull-right-container"> </span></a> </li>

                <li <?php if($menu_url=='xhs_comment'): ?>class="active"<?php endif; ?>><a href="/store.php/index?jump_url=xhs_comment&menu_url=xhs_comment"  py="dlgl" pinyin="dailiguanli" title="客户管理"><i class="fa fa-address-book-o fa-fw"></i> <span>客户库</span> <span class="pull-right-container"> </span></a> </li>

                <li <?php if($menu_url=='xhs_follow'): ?>class="active"<?php endif; ?>><a href="/store.php/index?jump_url=xhs_follow&menu_url=xhs_follow"  py="dlgl" pinyin="dailiguanli" title="小红书账号配置"><i class="fa fa-commenting-o fa-fw"></i> <span>小红薯账号配置</span> <span class="pull-right-container"> </span></a> </li>
            </ul>

        <li class="treeview-menu-ks"><a  ><i class="fa fa-play-circle fa-fw"></i> K手获客<i style="float:right" class="fa fa-angle-left"></i></a> </li>
            <ul class="treeview-menu menu-open treeview-menu-ks-content" <?php if(in_array($menu_url,["ks_task","ks_video","ks_comment","ks_follow"])): ?>style="display: block;"<?php endif; ?>>
                <li <?php if($menu_url=='ks_task'): ?>class="active"<?php endif; ?>><a href="/store.php/index?jump_url=ks_task&menu_url=ks_task"  py="dlgl" pinyin="dailiguanli" title="关键词监控"><i class="fa fa-video-camera fa-fw"></i> <span>关键词监控</span> <span class="pull-right-container"> </span></a> </li>

                <li <?php if($menu_url=='ks_video'): ?>class="active"<?php endif; ?>><a href="/store.php/index?jump_url=ks_video&menu_url=ks_video"  py="dlgl" pinyin="dailiguanli" title="全部视频"><i class="fa fa-file-video-o fa-fw"></i> <span>视频库</span> <span class="pull-right-container"> </span></a> </li>

                <li <?php if($menu_url=='ks_comment'): ?>class="active"<?php endif; ?>><a href="/store.php/index?jump_url=ks_comment&menu_url=ks_comment"  py="dlgl" pinyin="dailiguanli" title="客户管理"><i class="fa fa-address-book-o fa-fw"></i> <span>客户库</span> <span class="pull-right-container"> </span></a> </li>

                <li <?php if($menu_url=='ks_follow'): ?>class="active"<?php endif; ?>><a href="/store.php/index?jump_url=ks_follow&menu_url=ks_follow"  py="dlgl" pinyin="dailiguanli" title="K手配置"><i class="fa fa-commenting-o fa-fw"></i> <span>K手cookie配置</span> <span class="pull-right-container"> </span></a> </li>
            </ul>

        <!-- onclick="alert('正在快马加鞭赶来中，请耐心等候');" -->
        <li  class="treeview-menu-map"><a  ><i class="fa fa-map-marker fa-fw"></i> 地图获客 <i style="float:right" class="fa fa-angle-left"></i></a> </li>
            <ul class="treeview-menu menu-open treeview-menu-map-content" <?php if(in_array($menu_url,["map_task","map_customer"])): ?>style="display: block;"<?php endif; ?>>
                <li  <?php if($menu_url=='map_task'): ?>class="active"<?php endif; ?>><a href="/store.php/index?jump_url=map_task&menu_url=map_task"  py="cdgz" pinyin="caidanguize"><i class="fa fa-circle-o fa-fw"></i> <span>地图任务</span> </a> </li>
                <li <?php if($menu_url=='map_customer'): ?>class="active"<?php endif; ?>><a href="/store.php/index?jump_url=map_customer&menu_url=map_customer"  py="cdgz" pinyin="caidanguize"><i class="fa fa-circle-o fa-fw"></i> <span>地图客户</span> </a> </li>
            </ul>
        <li <?php if($menu_url=='store_pay'): ?>class="active"<?php endif; ?>><a href="/store.php/index?jump_url=store_pay&menu_url=store_pay"  py="dlgl" pinyin="dailiguanli" title="充值记录"><i class="fa fa-yen fa-fw"></i> <span>充值记录</span> <span class="pull-right-container"> </span></a> </li>

        <li <?php if($menu_url=='profile'): ?>class="active"<?php endif; ?>><a href="/store.php/index?jump_url=profile&menu_url=profile"  py="dlgl" pinyin="dailiguanli" title="个人信息"><i class="fa fa-user fa-fw"></i> <span>个人信息</span> <span class="pull-right-container"> </span></a> </li>

        <li  ><a  onclick="alert('正在快马加鞭赶来中，请耐心等候');"><i class="fa fa-address-book fa-fw"></i> D音定时监控(更新预告) </a> </li>
        

    </ul>
</section>
<script type="text/javascript" src="/storeadmin/libs/jquery/dist/jquery.min.js?v=1629984200"></script>
<script type="text/javascript">
    $('.treeview-menu-douyin').click(function(){
        $(".treeview-menu-douyin-content").slideToggle(300);
    });
    $('.treeview-menu-xhs').click(function(){
        $(".treeview-menu-xhs-content").slideToggle(300);
    });
    $('.treeview-menu-map').click(function(){
        $(".treeview-menu-map-content").slideToggle(300);
    });
    $('.treeview-menu-ks').click(function(){
        $(".treeview-menu-ks-content").slideToggle(300);
    });
</script>
            </aside>

            <!-- 主体内容区域 -->
            <div class="content-wrapper tab-content tab-addtabs">
                <div role="tabpanel" class="tab-pane active" >
                    <iframe src="<?php echo $iframe_url; ?>" width="100%" height="100%" frameborder="no" border="0" marginwidth="0" marginheight="0" scrolling-x="no" scrolling-y="auto" allowtransparency="yes"></iframe>
                </div>
            </div>

            <!-- 底部链接,默认隐藏 -->
            <footer class="main-footer hide">
                <div class="pull-right hidden-xs">
                </div>
                <strong>Copyright &copy; 2017-2020 <a href="/"><?php echo $site['name']; ?></a>.</strong> All rights reserved.
            </footer>

            <!-- 右侧控制栏 -->
            <div class="control-sidebar-bg"></div>
            <style>
    .skin-list li{
        float:left; width: 33.33333%; padding: 5px;
    }
    .skin-list li a{
        display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4);
    }
    .skin-list li a span{
        display: block;
        float:left;
    }
</style>
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li class="active"><a href="#control-sidebar-setting-tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-wrench"></i></a></li>
        <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane active" id="control-sidebar-setting-tab">
            <h4 class="control-sidebar-heading"><?php echo __('Layout Options'); ?></h4>
            <div class="form-group"><label class="control-sidebar-subheading"><input type="checkbox" data-layout="fixed" class="pull-right"> <?php echo __('Fixed Layout'); ?></label><p><?php echo __("You can't use fixed and boxed layouts together"); ?></p></div>
            <div class="form-group"><label class="control-sidebar-subheading"><input type="checkbox" data-layout="layout-boxed" class="pull-right"> <?php echo __('Boxed Layout'); ?></label><p><?php echo __('Activate the boxed layout'); ?></p></div>
            <div class="form-group"><label class="control-sidebar-subheading"><input type="checkbox" data-layout="sidebar-collapse" class="pull-right"> <?php echo __('Toggle Sidebar'); ?></label><p><?php echo __("Toggle the left sidebar's state (open or collapse)"); ?></p></div>
            <div class="form-group"><label class="control-sidebar-subheading"><input type="checkbox" data-enable="expandOnHover" class="pull-right"> <?php echo __('Sidebar Expand on Hover'); ?></label><p><?php echo __('Let the sidebar mini expand on hover'); ?></p></div>
            <div class="form-group"><label class="control-sidebar-subheading"><input type="checkbox" data-menu="show-submenu" class="pull-right"> <?php echo __('Show sub menu'); ?></label><p><?php echo __('Always show sub menu'); ?></p></div>
            <div class="form-group"><label class="control-sidebar-subheading"><input type="checkbox" data-menu="disable-top-badge" class="pull-right"> <?php echo __('Disable top menu badge'); ?></label><p><?php echo __('Disable top menu badge without left menu'); ?></p></div>
            <div class="form-group"><label class="control-sidebar-subheading"><input type="checkbox" data-controlsidebar="control-sidebar-open" class="pull-right"> <?php echo __('Toggle Right Sidebar Slide'); ?></label><p><?php echo __('Toggle between slide over content and push content effects'); ?></p></div>
            <div class="form-group"><label class="control-sidebar-subheading"><input type="checkbox" data-sidebarskin="toggle" class="pull-right"> <?php echo __('Toggle Right Sidebar Skin'); ?></label><p><?php echo __('Toggle between dark and light skins for the right sidebar'); ?></p></div>
            <h4 class="control-sidebar-heading"><?php echo __('Skins'); ?></h4>
            <ul class="list-unstyled clearfix skin-list">
                <li><a href="javascript:;" data-skin="skin-blue" class="clearfix full-opacity-hover"><div><span style="width: 20%; height: 27px; background: #4e73df;"></span><span style="width: 80%; height: 27px; background: #f4f5f7;"></span></div></a><p class="text-center no-margin">Blue</p></li>
                <li><a href="javascript:;" data-skin="skin-black" class="clearfix full-opacity-hover"><div><span style="width: 20%; height: 27px; background: #000;"></span><span style="width: 80%; height: 27px; background: #f4f5f7;"></span></div></a><p class="text-center no-margin">Black</p></li>
                <li><a href="javascript:;" data-skin="skin-purple" class="clearfix full-opacity-hover"><div><span style="width: 20%; height: 27px; background: #605ca8;"></span><span style="width: 80%; height: 27px; background: #f4f5f7;"></span></div></a><p class="text-center no-margin">Purple</p></li>
                <li><a href="javascript:;" data-skin="skin-green" class="clearfix full-opacity-hover"><div><span style="width: 20%; height: 7px;" class="bg-green-active"></span><span class="bg-green" style="width: 80%; height: 7px;"></span></div><div><span style="width: 20%; height: 20px; background: #000;"></span><span style="width: 80%; height: 20px; background: #f4f5f7;"></span></div></a><p class="text-center no-margin">Green</p></li>
                <li><a href="javascript:;" data-skin="skin-red" class="clearfix full-opacity-hover"><div><span style="width: 20%; height: 7px;" class="bg-red-active"></span><span class="bg-red" style="width: 80%; height: 7px;"></span></div><div><span style="width: 20%; height: 20px; background: #000;"></span><span style="width: 80%; height: 20px; background: #f4f5f7;"></span></div></a><p class="text-center no-margin">Red</p></li>
                <li><a href="javascript:;" data-skin="skin-yellow" class="clearfix full-opacity-hover"><div><span style="width: 20%; height: 7px;" class="bg-yellow-active"></span><span class="bg-yellow" style="width: 80%; height: 7px;"></span></div><div><span style="width: 20%; height: 20px; background: #000;"></span><span style="width: 80%; height: 20px; background: #f4f5f7;"></span></div></a><p class="text-center no-margin">Yellow</p></li>

                <li><a href="javascript:;" data-skin="skin-blue-light" class="clearfix full-opacity-hover"><div><span style="width: 100%; height: 7px; background: #4e73df;"></span></div><div><span style="width: 100%; height: 20px; background: #f9fafc;"></span></div></a><p class="text-center no-margin" style="font-size: 12px">Blue Light</p></li>
                <li><a href="javascript:;" data-skin="skin-black-light" class="clearfix full-opacity-hover"><div><span style="width: 100%; height: 7px; background: #000;"></span></div><div><span style="width: 100%; height: 20px; background: #f9fafc;"></span></div></a><p class="text-center no-margin" style="font-size: 12px">Black Light</p></li>
                <li><a href="javascript:;" data-skin="skin-purple-light" class="clearfix full-opacity-hover"><div><span style="width: 100%; height: 7px; background: #605ca8;"></span></div><div><span style="width: 100%; height: 20px; background: #f9fafc;"></span></div></a><p class="text-center no-margin" style="font-size: 12px">Purple Light</p></li>
                <li><a href="javascript:;" data-skin="skin-green-light" class="clearfix full-opacity-hover"><div><span style="width: 100%; height: 7px;" class="bg-green"></span></div><div><span style="width: 100%; height: 20px; background: #f9fafc;"></span></div></a><p class="text-center no-margin" style="font-size: 12px">Green Light</p></li>
                <li><a href="javascript:;" data-skin="skin-red-light" class="clearfix full-opacity-hover"><div><span style="width: 100%; height: 7px;" class="bg-red"></span></div><div><span style="width: 100%; height: 20px; background: #f9fafc;"></span></div></a><p class="text-center no-margin" style="font-size: 12px">Red Light</p></li>
                <li><a href="javascript:;" data-skin="skin-yellow-light" class="clearfix full-opacity-hover"><div><span style="width: 100%; height: 7px;" class="bg-yellow"></span></div><div><span style="width: 100%; height: 20px; background: #f9fafc;"></span></div></a><p class="text-center no-margin" style="font-size: 12px">Yellow Light</p></li>

                <li><a href="javascript:;" data-skin="skin-black-blue" class="clearfix full-opacity-hover"><div><span style="width: 20%; height: 27px; background: #000;"><span style="width: 100%; height: 3px; margin-top:10px; background: #4e73df;"></span></span><span style="width: 80%; height: 27px; background: #f4f5f7;"></span></div></a><p class="text-center no-margin">Black Blue</p></li>
                <li><a href="javascript:;" data-skin="skin-black-purple" class="clearfix full-opacity-hover"><div><span style="width: 20%; height: 27px; background: #000;"><span style="width: 100%; height: 3px; margin-top:10px; background: #605ca8;"></span></span><span style="width: 80%; height: 27px; background: #f4f5f7;"></span></div></a><p class="text-center no-margin">Black Purple</p></li>
                <li><a href="javascript:;" data-skin="skin-black-green" class="clearfix full-opacity-hover"><div><span style="width: 20%; height: 27px; background: #000;"><span style="width: 100%; height: 3px; margin-top:10px;" class="bg-green"></span></span><span style="width: 80%; height: 27px; background: #f4f5f7;"></span></div></a><p class="text-center no-margin">Black Green</p></li>
                <li><a href="javascript:;" data-skin="skin-black-red" class="clearfix full-opacity-hover"><div><span style="width: 20%; height: 27px; background: #000;"><span style="width: 100%; height: 3px; margin-top:10px;" class="bg-red"></span></span><span style="width: 80%; height: 27px; background: #f4f5f7;"></span></div></a><p class="text-center no-margin">Black Red</p></li>
                <li><a href="javascript:;" data-skin="skin-black-yellow" class="clearfix full-opacity-hover"><div><span style="width: 20%; height: 27px; background: #000;"><span style="width: 100%; height: 3px; margin-top:10px;" class="bg-yellow"></span></span><span style="width: 80%; height: 27px; background: #f4f5f7;"></span></div></a><p class="text-center no-margin">Black Yellow</p></li>
                <li><a href="javascript:;" data-skin="skin-black-pink" class="clearfix full-opacity-hover"><div><span style="width: 20%; height: 27px; background: #000;"><span style="width: 100%; height: 3px; margin-top:10px; background: #f5549f;"></span></span><span style="width: 80%; height: 27px; background: #f4f5f7;"></span></div></a><p class="text-center no-margin">Black Pink</p></li>
            </ul>
        </div>
        <!-- /.tab-pane -->
        <!-- Home tab content -->
        <div class="tab-pane" id="control-sidebar-home-tab">
            <h4 class="control-sidebar-heading"><?php echo __('Home'); ?></h4>
        </div>
        <!-- /.tab-pane -->
        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">
            <h4 class="control-sidebar-heading"><?php echo __('Setting'); ?></h4>
        </div>
        <!-- /.tab-pane -->
    </div>
</aside>
<!-- /.control-sidebar -->

        </div>

        <!-- 加载JS脚本 -->
        <script src="/storeadmin/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/storeadmin/js/require-backend.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>
