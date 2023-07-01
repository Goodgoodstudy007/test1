<?php

namespace app\storeadmin\controller;

use app\common\controller\Backend;
use think\Db;
use think\Cache;
/**
 * 
 *
 * @icon fa fa-circle-o
 */
class XhsFollow extends Backend
{
    protected $noNeedLogin = ['*'];
    /**
     * TaskVideo模型对象
     * @var \app\admin\model\TaskVideo
     */
    protected $model = null;
    public $header = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\storeadmin\model\TaskVideo;
        
        $this->header = ["User-Agent:  Mozilla/5.0 (Linux; Android 6.0.1; OPPO R9s Build/MMB29M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/86.0.4240.99 XWEB/3100 MMWEBSDK/20210302 Mobile Safari/537.36 MMWEBID/187 MicroMessenger/8.0.3.1880(0x2800033E) Process/appbrand0 WeChat/arm32 Weixin NetType/WIFI Language/zh_CN ABI/arm64 MiniProgramEnv/android",
                        "Referer: https://www.xiaohongshu.com/",
                        "Origin: https://www.xiaohongshu.com/",
                        "Host: www.xiaohongshu.com"];
    }

    /**
     * 查看
     */
    public function index()
    {
        
        $store_id = session('store_id');
        
        // 判断是否登录
        $douyin_cookie = Db::name('store_cookie')->where(['store_id'=>$store_id,'type'=>2])->order('status desc')->select();
        $this->assign('douyin_cookie',$douyin_cookie);

        return $this->view->fetch();
    }

    public function get_cookie(){
        $store_id = session('store_id');
        $authorization = input('authorization','');
        $device = input('device','');
        $title = input('title','');
        if(!$title || !$authorization){
            echo json_encode(['code'=>2,'msg'=>'请完善信息']);exit;
        }
        $has_title = Db::name('store_cookie')->where(['cookie'=>$authorization,'store_id'=>$store_id])->count();
        if($has_title){
            echo json_encode(['code'=>2,'msg'=>'authorization已经存在']);exit;
        }
        $res = Db::name('store_cookie')->insert(['store_id'=>$store_id,'cookie'=>$authorization,'title'=>$title,'max_follow'=>200,'addtime'=>date('Y-m-d H:i:s'),'type'=>2,'device'=>$device]);
        if($res){
            echo json_encode(['code'=>0,'msg'=>'添加成功']);exit;
        }
        echo json_encode(['code'=>1,'msg'=>'添加失败，请刷新重试']);exit;

    }

    public function delete_cookie(){
        $id = input('id',0);
        $store_id = session('store_id');
        $res = Db::name('store_cookie')->where(['id'=>$id,'store_id'=>$store_id])->delete();
        if($res){
            echo json_encode(['code'=>0,'msg'=>'删除成功' ]);
        }else{
            echo json_encode(['code'=>1,'msg'=>'删除失败，请重试']);
        }
    }

    public function import()
    {
        parent::import();
    }


    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    

}
