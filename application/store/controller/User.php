<?php

namespace app\store\controller;

use app\common\controller\Frontend;
use think\Db;
use think\Config;

class User extends Frontend
{
	protected $noNeedLogin = '*';
	protected $noNeedRight = '*';
    protected $layout = '';


    public function login()
    {
        $config = Config::get('site');
        $this->assign('site_name',$config['name']);
        return $this->view->fetch();
    }

    public function info()
    {
  
        $this->assign('html_name','user');
        $store_id  = session('store_id');
        if(empty($store_id)){
            header('Location:/store/user/login');exit;
        }
        //商家信息
        $store = Db::name('store')->where(['id'=>$store_id,'status'=>1])->find();
        if(empty($store)){
            header('Location:/store/user/login');exit;
        }
        $this->assign('store',$store);

        return $this->view->fetch();
    }

    public function edit(){
        $store_id  = session('store_id');
        if(empty($store_id)){
            header('Location:/store/user/login');exit;
        }
        $store_name = input('store_name','');
        $password = input('password','');
        if(!$store_name){
            return $this->result( [],  201,'商户名称不能为空');
        }
        $data['store_name'] = $store_name;
        if($password){
            if(strlen($password) < 6){return $this->result( [],  201,'密码要求6位以上');}
            $data['password'] = md5($password);
        }
        $res = Db::name('store')->where(['id'=>$store_id])->update($data);
        if($res || $res===0){
            return $this->result( [],  0,'更新成功');
        }else{
            return $this->result( [],  201,'更新失败，请重试');
        }
    }

    public function login_post(){
        $username = input('username','');
        $password = input('password','');
        if(!$username || !$password){
            return $this->result( [],  201,'账号密码不能为空');
        }
        $password = md5($password);
        $store = Db::name('store')->where('status=1 and password="'.$password.'" and username="'.$username.'" and out_date>="'.date('Y-m-d').'"')->find();
        if(!$store){
            return $this->result( [],  202,'账号密码错误');
        }
        session('store_id',$store['id']);
        session('agent_id',$store['agent_id']);
        session('store_name',$store['store_name']);
        session('out_date',$store['out_date']);
        return $this->result( [],  0,'登录成功');
    }

    public function logout()
    {
        // 清除所有session，跳转到登录页面
        session('store_id',0);
        session('agent_id',0);
        session('store_name','');
        session('openid','');
        session('out_date','');
        header('Location:/store/user/login');exit;
    }

}
