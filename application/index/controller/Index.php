<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use think\Db;

class Index extends Frontend
{

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function index()
    {
        return $this->view->fetch();
    }

    public function baping()
    {
        return $this->view->fetch();
    }

    public function xunpang()
    {
        return $this->view->fetch();
    }

    public function check_host(){
        $host = input('host','');
        $ip = input('ip','');
        if(!$host && !$ip){
            echo 1;exit;
        }
        $where = ' 1=1 ';
        if($host){
            $where .= ' and host="'.$host.'" ';
        }
        if($ip){
            $where .= ' and ip="'.$ip.'" ';
        }
        $host_info = Db::name('host')->where($where)->find();
        if($host_info){
            echo 1;exit;
        }
        echo 2;exit;
    }

    public function version(){
        header("Access-Control-Allow-Origin: *");
        $new_version = Db::name('version')->field('id,newversion,content,day,date')->order('id desc')->find();
        $version_list = Db::name('version')->field('id,newversion,content,day,date')->order('id desc')->select();
        $data = ['new_version'=>$new_version,'version_list'=>$version_list];
        echo json_encode(['code'=>0,'msg'=>'','data'=>$data]);exit;
    }

    public function update_version(){
        $now_version = input('now_version','');
        $new_version = Db::name('version')->order('id desc')->find();
        if(!$now_version){
            echo json_encode(['code'=>1,'msg'=>'版本获取失败','data'=>[]]);exit;
        }
        if(version_compare($now_version,$new_version['newversion'],'lt')){
            echo json_encode(['code'=>0,'msg'=>'新版本:'.$new_version['newversion'],'data'=>$new_version]);exit;
        }
        echo json_encode(['code'=>1,'msg'=>'已是最新版，无需更新','data'=>[]]);exit;
    }

}
