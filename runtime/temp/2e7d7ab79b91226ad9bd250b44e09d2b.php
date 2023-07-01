<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:86:"/www/wwwroot/douyin_xunpang/public/../application/storeadmin/view/dashboard/index.html";i:1635759844;s:75:"/www/wwwroot/douyin_xunpang/application/storeadmin/view/layout/default.html";i:1617358420;s:72:"/www/wwwroot/douyin_xunpang/application/storeadmin/view/common/meta.html";i:1617358420;s:74:"/www/wwwroot/douyin_xunpang/application/storeadmin/view/common/script.html";i:1629014048;}*/ ?>
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
                                <script type="text/javascript" src="/storeadmin/echarts/dist/echarts.min.js"></script>
<script type="text/javascript" src="/storeadmin/js/china.js"></script>
<style type="text/css">
  

    body{overflow-x:hidden;font-family:Helvetica Neue,Helvetica,PingFang SC,Hiragino Sans GB,Microsoft YaHei,"\5FAE\8F6F\96C5\9ED1",Arial,sans-serif}
    @font-face {
        font-family:LcdD;src:url(/storeadmin/font/LcdD.773ee676.ttf);font-weight:700;font-style:normal
    }
    .main{float:left;width:48%;height:400px;margin-right:1%;border:3px solid #060e41;margin-top: 20px;}
    .main_content{background:#000530;display:inline-block;background-size:contain;padding:0px 20px 20px 20px;width:100%}
    .main_top{background:url(/storeadmin/img/top_03.png) no-repeat;color:#fff;text-align:center;background-size:100%;height:40px;margin-bottom:30px}
    .main_top h1{background-image:-webkit-linear-gradient(bottom,#000530,#d4d5dc,#fff);-webkit-background-clip:text;-webkit-text-fill-color:transparent;font-family:"微软雅黑";letter-spacing:5px;font-weight:700;font-size:28px;line-height:30px;height:40px}
    .igs-flex.igs-flex11{-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column}
    .current{text-align:center;width:97%;height:170px;color:#97a8f7;background:url(/storeadmin/img/top_01.png) no-repeat;background-size:100% 100%;padding:15px 10px 45px 10px;position:relative;display:inline-block;}
    .current .current_cont{padding-top:10px;height:100%}
    .igs-flex.igs-flex4{-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;-webkit-justify-content:space-between;-webkit-box-align:center;-ms-flex-align:center;align-items:center}
    .current .current_cont .cont{height:100%;width:14.28%;background:#060e41;float:left}
    .current .current_cont .cont p{text-align:left;font-size:16px;font-family:Source Han Sans CN;font-weight:700;color:#a9b8ff;line-height:40px;padding-left: 15px;}
    .flex-start{-webkit-box-pack:start!important;-ms-flex-pack:start!important;justify-content:flex-start!important}
    .wrapers{display:-webkit-box;height:auto;line-height:40px;border:none!important;padding:0;margin:0;background:0 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .white-color{color:#fff}
    .box-item{width:auto;height:40px;list-style:none;font-size:30px;font-family:LcdD;font-weight:700;margin:0 0 0 -25px;color:#fff}
    .unit-span{margin-left:5px;}
    .current_title{position: relative;z-index: 2;top: -10px;text-align: center;font-weight: bold;font-size: 20px;letter-spacing: 3px;}
    .xunpang_comment_content{background: #5357a9;width: 250px;height: 35px;line-height: 35px;text-align: center;display: block;margin:0 auto;font-size: 20px;font-weight: bold;letter-spacing: 3px;color: #97a8f2;margin-bottom: 10px;}
    #main_4{color: #97a8f2;}
    #main_1,#main_2{padding-top: 20px}
    .table-header{list-style: none;border-bottom: 1px solid #5470c6;height: 40px;line-height: 40px;padding: 0px 10px;}
    .table-header li{display: inline-block;text-align: center;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;}
    .xunpang_index{width: 30%}
    .xunpang_comment{width: 30%}
    .xunpang_nickname{width: 18%}
    .xunpang_time{width: 17%}
    .table-top li{font-size: 16px;color: #fff;}
     .content {min-height: 250px;padding: 0px;margin-right: auto;margin-left: auto;padding-left: 0px;padding-right: 0px;}
</style>
    <div class="main_content">
        <div class="main_top">
            <h1><?php echo htmlentities(mb_strtoupper(mb_substr($site['name'],0,8,'utf-8'),'utf-8')); ?></h1>
        </div>
        <div  class="current">
            <div class="current_title">数据统计</div>
            <div class="current_cont igs-flex igs-flex4">
                <div class="cont">
                    <p>当前运行任务</p>
                    <div class="wrapers flex-start">
                        <ul class="box-item white-color">
                            <?php echo $run_task; ?>
                        </ul>
                        <div class="unit-span"></div>
                    </div>
                </div>
                <div class="cont">
                    <p>获取客户档案</p>
                    <div class="wrapers flex-start">
                        <ul class="box-item white-color">
                            <?php echo $all_comment; ?>
                        </ul>
                        <div class="unit-span">人</div>
                    </div>
                </div>               
                
                <div class="cont">
                    <p>总监控任务</p>
                    <div class="wrapers flex-start">
                        <ul class="box-item white-color">
                            <?php echo $all_task; ?>
                        </ul>
                        <div class="unit-span"></div>
                    </div>
                </div>
                <div class="cont">
                    <p>总视频数</p>
                    <div class="wrapers flex-start">
                        <ul class="box-item white-color">
                            <?php echo $all_video; ?>
                        </ul>
                        <div class="unit-span"></div>
                    </div>
                </div>
                <div class="cont">
                    <p>剩余点数</p>
                    <div class="wrapers flex-start">
                        <ul class="box-item white-color">
                            <?php echo $store_info['price']; ?>
                        </ul>
                        <div class="unit-span"></div>
                    </div>
                </div>
                <div class="cont">
                    <p>消耗点数</p>
                    <div class="wrapers flex-start">
                        <ul class="box-item white-color">
                            <?php echo $use_price; ?>
                        </ul>
                        <div class="unit-span"></div>
                    </div>
                </div>
                <div class="cont">
                    <p>总充值</p>
                    <div class="wrapers flex-start">
                        <ul class="box-item white-color">
                            <?php echo $all_price; ?>
                        </ul>
                        <div class="unit-span">元</div>
                    </div>
                </div>
            </div>
        </div>
        <div id="main_1" class="main"></div>
        <div id="main_2" class="main"></div>
        <div id="main_3" class="main" style="height:600px;"></div>
        <div id="main_4" class="main" style="height:600px;">
            <div class="xunpang_comment_content">D音线索用户</div>
            <ul  class="table-header table-top" >
                <li  class="xunpang_index">线索</li>
                <li  class="xunpang_comment li-flex">线索分析</li>
                <li  class="xunpang_nickname li-width">D音号</li>
                <li  class="xunpang_time">分析时间</li>
            </ul>
            <div id="xunpang_comment" style="position:relative;overflow:hidden;height:500px;">
            <?php if($user_list): ?>
                <div id="xunpang_comment_id" style="height:auto;">
                    <?php foreach($user_list as $k=>$v): ?>
                    <ul  class="table-header">
                        <li  class="xunpang_index"><?php echo $v['title']; ?></li>
                        <li  class="xunpang_comment li-flex"><?php echo $v['comment']; ?></li>
                        <li  class="xunpang_nickname li-width"><?php echo $v['userid']; ?></li>
                        <li  class="xunpang_time"><?php echo $v['addtime']; ?></li>
                    </ul>
                    <?php endforeach; ?> 
                </div>
                <div id="xunpang_comment_id2" style="height:auto;"></div>
            <?php endif; ?>
            </div>
        </div>
    </div>
<script type="text/javascript">
    <?php if($user_list): ?>
    var speed=70
      // 向上滚动
      var demo=document.getElementById("xunpang_comment");
      var demo2=document.getElementById("xunpang_comment_id2");
      var demo1=document.getElementById("xunpang_comment_id");
      demo2.innerHTML=demo1.innerHTML
      function Marquee(){
       if(demo.scrollTop>=demo1.offsetHeight){
        demo.scrollTop=0;
       }
       else{
        demo.scrollTop=demo.scrollTop+1;
       }
      }
      var MyMar=setInterval(Marquee,speed)
      demo.onmouseover=function(){clearInterval(MyMar)}
      demo.onmouseout=function(){MyMar=setInterval(Marquee,speed)}
    <?php endif; ?>

        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('main_1'));
        // 指定图表的配置项和数据
        var option = {
            title: {
                text: '任务获客量统计',
                textStyle:{
                    color:'#fff'
                },
                left: 'center',
            },
            tooltip: {},
            legend: {
                show:false
            },
            xAxis: {
                data: [<?php echo $index_task_date; ?>],
                axisLabel:{
                    textStyle:{
                        color:'#fff'
                    },
                }

            },
            yAxis: {
                axisLabel:{
                    textStyle:{
                        color:'#fff'
                    },
                }
            },
            series: [{
                name: '获客量',
                type: 'bar',
                data: [<?php echo $index_task_count; ?>],

            }],
        };
        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);

        var myChart = echarts.init(document.getElementById('main_2'));
        option = {
            title: {
                text: '历史监控统计',
                subtext: '',
                left: 'center',
                textStyle:{
                    color:'#fff'
                },
            },
            tooltip: {
                trigger: 'item'
            },
            legend: {
                orient: 'vertical',
                left: 'left',
                show:false
            },
            series: [
                {
                    name: '访问来源',
                    type: 'pie',
                    radius: '50%',
                    data: [
                        {value: <?php echo $index_task; ?>, name: '同行主页监控'},
                        {value: <?php echo $video_task; ?>, name: '单视频任务'},
                        {value: <?php echo $key_task; ?>, name: '关键词监控'},
                    ],
                    label: {  
                        normal: {  
                            show: true , //省份名称 
                            textStyle: {
                              color: "#fff",
                              fontSize: 14,
                            },
                        },  
                        emphasis: {  
                            show: false  
                        } , 
                    }, 
                }
            ]
        };
        myChart.setOption(option);


        function randomData() {  
             return Math.round(Math.random()*500);  
        } 
        var mydata = [  
                // {name: '北京',value: '100' },{name: '天津',value: randomData() },   
            ]; 
        var optionMap = {  
                title: {  
                    text: '用户地域分布图',  
                    subtext: '', 
                    textStyle:{
                        color:'#fff'
                    },
                    x:'center' ,
                    top: 70
                    // y: 'bottom', 
                },  
                tooltip : {  
                    trigger: 'item'  
                },  
                
                //左侧小导航图标
                visualMap: {  
                    show : false,   
                    label: {  
                        color: '#000',
                    },
                },  
                //配置属性
                series: [{  
                    name: '数据',  
                    type: 'map',  
                    mapType: 'china',   
                    roam: true,  
                    label: {  
                        normal: {  
                            show: true , //省份名称 
                            textStyle: {
                              color: "#fff",
                              fontSize: 12,
                            },
                        },  
                        emphasis: {  
                            show: false  
                        } , 
                    }, 
                    itemStyle: {
                        normal: {
                        borderWidth: .5, //区域边框宽度
                            areaColor: "rgba(255, 255, 255, 0)", //区域颜色
                        },
                        emphasis: {
                            borderWidth: .5,
                            areaColor: "#5e6eff",
                        }
                    }, 

                    data:mydata  //数据
                }]  
            };  
        //初始化echarts实例
        var myChart = echarts.init(document.getElementById('main_3'));

        //使用制定的配置项和数据显示图表
        myChart.setOption(optionMap);
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
