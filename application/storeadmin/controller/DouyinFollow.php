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
class DouyinFollow extends Backend
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
        
        $this->header = ["Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8",
                        "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 UBrowser/6.2.3964.2 Safari/537.36",
                        "Referer: https://www.douyin.com/",
                        "Origin: https://www.douyin.com/",
                        "Accept-Language: zh-CN,zh;q=0.9"];
    }

    /**
     * 查看
     */
    public function index()
    {
        $store_id = session('store_id');
        
        // 判断是否登录
        $douyin_cookie = Db::name('store_cookie')->where(['store_id'=>$store_id,'type'=>1])->order('status desc')->select();
        $this->assign('douyin_cookie',$douyin_cookie);

        return $this->view->fetch();
    }

    public function get_qrcode(){
        $api = new \app\index\controller\Douyin();
        $proxy_ip = $api->get_proxy(1);
        $param['proxy_ip'] = $proxy_ip[0];
        $param['proxy_port'] = $proxy_ip[1];
        $res_json = [];
        $res_json = dcurl_proxy('https://sso.douyin.com/get_qrcode/?service=https%3A%2F%2Fwww.douyin.com%2F&need_logo=false&aid=6383',$param,$this->header);
        $qrcode = '';
        $token = '';
        if($res_json){
            $res_json = json_decode($res_json,1);
            $qrcode = $res_json['data']['qrcode'];
            $token =  $res_json['data']['token'];
            echo json_encode(['code'=>0,'msg'=>'获取成功','data'=>['qrcode'=>$qrcode,'token'=>$token]]);exit;
        }else{
            echo json_encode(['code'=>1,'msg'=>'获取失败，请重试']);exit;
        }   
    }

    public function get_cookie(){
        $store_id = session('store_id');
        $cookie = input('cookie',0);
        $max_follow = input('max_follow',0);
        $title = input('title',0);
        if(!$title){
            echo json_encode(['code'=>2,'msg'=>'请填写标识']);exit;
        }
        if(!$cookie){
            echo json_encode(['code'=>2,'msg'=>'请填写登录cookie']);exit;
        }
        if($max_follow<=0 || $max_follow > 200){
            echo json_encode(['code'=>2,'msg'=>'最大关注限制为0-200']);exit;
        }
        $has_title = Db::name('store_cookie')->where(['title'=>$title,'store_id'=>$store_id])->count();
        if($has_title){
            echo json_encode(['code'=>2,'msg'=>'标识已经存在']);exit;
        }
        $res = Db::name('store_cookie')->insert(['store_id'=>$store_id,'cookie'=>$cookie,'title'=>$title,'max_follow'=>$max_follow,'addtime'=>date('Y-m-d H:i:s')]);
        if($res){
            echo json_encode(['code'=>0,'msg'=>'添加成功']);exit;
        }
        echo json_encode(['code'=>2,'msg'=>'添加失败']);exit;
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
