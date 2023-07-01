<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:87:"/www/wwwroot/douyin_xunpang/public/../application/storeadmin/view/store_task/index.html";i:1683093991;s:75:"/www/wwwroot/douyin_xunpang/application/storeadmin/view/layout/default.html";i:1617358420;s:72:"/www/wwwroot/douyin_xunpang/application/storeadmin/view/common/meta.html";i:1617358420;s:74:"/www/wwwroot/douyin_xunpang/application/storeadmin/view/common/script.html";i:1629014048;}*/ ?>
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
  .table {
    table-layout: fixed;
  }

  .table td {
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
  }
</style>
<div class="panel panel-default panel-intro">
  <?php echo build_heading(); ?>
  <div class="panel-body">
    <div id="myTabContent" class="tab-content">
      <div class="tab-pane fade active in" id="one">
        <div class="widget-body no-padding">
          <div id="toolbar" class="toolbar">
            <a href="javascript:;" class="btn btn-primary btn-refresh" title="<?php echo __('Refresh'); ?>"><i
                class="fa fa-refresh"></i> </a>
            <a href="javascript:;" class="btn btn-success btn-add " title="<?php echo __('Add'); ?>"><i class="fa fa-plus"></i>
              <?php echo __('Add'); ?></a>

            <a href="/store.php/index?jump_url=store_task&menu_url=store_task<?php echo $mode; ?>&mode=<?php echo $mode; ?>&status=1"
              class="btn btn-success run_task" style="margin-left:20px;" title="运行中" target="_blank">运行中</a>
            <a href="/store.php/index?jump_url=store_task&menu_url=store_task<?php echo $mode; ?>&mode=<?php echo $mode; ?>&status=0"
              class="btn btn-danger run_task" title="已暂停" target="_blank">已暂停</a>
            <a href="/store.php/index?jump_url=store_task&menu_url=store_task<?php echo $mode; ?>&mode=<?php echo $mode; ?>&status=2"
              class="btn btn-success run_task" title="已完成" target="_blank" style="background:#ccc;">已完成</a>

            <a href="javascript:;"
              class="btn btn-danger btn-del btn-disabled disabled <?php echo $auth->check('store_task/del')?'':'hide'; ?>"
              title="<?php echo __('Delete'); ?>"><i class="fa fa-trash"></i> <?php echo __('Delete'); ?></a>
            <a href="javascript:;" class="btn btn-primary btn-save" title="Save"><i
                class="fa fa-save"></i>SaveCookie</a>

          </div>
          <table id="table" class="table table-striped table-bordered table-hover table-nowrap" width="100%">
          </table>
          <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
        </div>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="saveModal" tabindex="-1" role="dialog" aria-labelledby="saveModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="saveModalLabel">Save</h4>
      </div>
      <div class="modal-body">
        <textarea class="form-control" id="saveText" rows="10" placeholder="请输入文字..."></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" id="saveConfirm">确定</button>
      </div>
    </div>
  </div>
</div>

<div id="message-modal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body text-center">
        <p id="message-content"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>


<script>
  document.addEventListener("DOMContentLoaded", function () {
    // 点击 Save 按钮，打开模态框
    document.querySelector('.btn-save').addEventListener('click', function () {
        document.getElementById('saveModal').classList.add('in');
        document.getElementById('saveModal').style.display = 'block';
        document.body.classList.add('modal-open');
        var backdrop = document.createElement('div');
        backdrop.classList.add('modal-backdrop', 'fade', 'in');
        document.body.appendChild(backdrop);
    });

    // 点击取消按钮，关闭模态框
    document.querySelector('#saveModal .btn-default').addEventListener('click', function () {
        closeModal();
    });

    // 点击确定按钮，发送Ajax请求
    document.getElementById('saveConfirm').addEventListener('click', function () {
        var text = document.getElementById('saveText').value.trim();

        if (text === '') {
            alert('请输入内容');
            return;
        }

        // 发送Ajax请求到 StoreTask 控制器的 saveCookie 方法
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/storeadmin/store_task/saveCookie', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                var messageModal = $('#message-modal');
                var messageContent = document.getElementById('message-content');
                if (response.code === 1) {
                    messageContent.textContent = '保存成功';
                } else {
                    messageContent.textContent = '保存失败，请重试';
                }
                messageModal.modal('show');
                setTimeout(function () {
                    messageModal.modal('hide');
                    if (response.code === 1) {
                        closeModal();
                    }
                }, 1500);
            } else {
                alert('请求失败，请检查网络');
            }
        }
      };
        xhr.send('content=' + encodeURIComponent(text));
    });

    function closeModal() {
        document.getElementById('saveModal').classList.remove('in');
        document.getElementById('saveModal').style.display = 'none';
        document.body.classList.remove('modal-open');
        var backdrop = document.querySelector('.modal-backdrop');
        document.body.removeChild(backdrop);
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
