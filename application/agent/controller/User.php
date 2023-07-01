<?php

namespace app\agent\controller;

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
        $agent_id  = session('p_agent_id');
        if(empty($agent_id)){
            header('Location:/agent/user/login');exit;
        }
        //商家信息
        $agent = Db::name('agent')->where(['id'=>$agent_id,'status'=>1])->find();
        if(empty($agent)){
            header('Location:/agent/user/login');exit;
        }
        $this->assign('agent',$agent);

        return $this->view->fetch();
    }

    public function edit(){
        $agent_id  = session('p_agent_id');
        if(empty($agent_id)){
            header('Location:/agent/user/login');exit;
        }
        $agent_name = input('agent_name','');
        $password = input('password','');
        $bank_name = input('bank_name','');
        $bank_username = input('bank_username','');
        $bank_number = input('bank_number','');
        if(!$agent_name){
            return $this->result( [],  201,'代理商名称不能为空');
        }
        $data['agent_name'] = $agent_name;
        $data['bank_name'] = $bank_name;
        $data['bank_username'] = $bank_username;
        $data['bank_number'] = $bank_number;
        if($password){
            if(strlen($password) < 6){
                return $this->result( [],  201,'密码要求6位以上');
            }
            $data['password'] = md5($password);
        }
        $res = Db::name('agent')->where(['id'=>$agent_id])->update($data);
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
        $agent = Db::name('agent')->where('status=1 and password="'.$password.'" and username="'.$username.'" and out_date>="'.date('Y-m-d').'"')->find();
        if(!$agent){
            return $this->result( [],  202,'账号密码错误');
        }
        session('p_agent_id',$agent['id']);
        session('level',$agent['level']);
        session('agent_pid',$agent['agent_pid']);
        session('agent_name',$agent['agent_name']);
        session('out_date',$agent['out_date']);
        return $this->result( [],  0,'登录成功');
    }

    public function logout()
    {
        // 清除所有session，跳转到登录页面
        session('p_agent_id',0);
        session('level',0);
        session('agent_pid',0);
        session('agent_name','');
        session('out_date','');
        header('Location:/agent/user/login');exit;
    }

    public function withdrawal(){
        $this->assign('html_name','user');
        $agent_id  = session('p_agent_id');
        $agent = Db::name('agent')->where(['id'=>$agent_id,'status'=>1])->find();
        if(empty($agent)){
            return $this->result( [],  201,'代理不存在');
        }
        $this->assign('agent',$agent);

        // 提现记录
        $withdrawals = Db::name('withdrawal')->field('id,price,addtime,status,reason,case status when 2 then "打款成功" when 3 then "审核失败" else "审核中" end as status_info ')->where(['agent_id'=>$agent_id])->order('id desc')->select();
        $this->assign('withdrawals',$withdrawals);
        return $this->view->fetch();
    }

    public function withdrawal_post(){
        $agent_id  = session('p_agent_id');
        $agent = Db::name('agent')->where(['id'=>$agent_id,'status'=>1])->find();
        if(empty($agent)){
            return $this->result( [],  201,'代理不存在');
        }
        // 检查银行卡是不是空
        if(!$agent['bank_number']){
            return $this->result( [],  201,'请完善个人提现信息');
        }
        $price = input('price',0);
        if($price < 100){
            return $this->result( [],  201,'最低提现金额100元');
        }
        if($agent['commission'] < $price){
            return $this->result( [],  201,'超过最大提现额度');
        }
        
        $res = false;
        Db::startTrans();
        try{
            // 扣除余额
            Db::name('agent')->where(['id'=>$agent_id])->setDec('commission',$price);
            // 开始新建
            $res = Db::name('withdrawal')->insert(['agent_id'=>$agent_id,'status'=>1,'price'=>$price,'addtime'=>date('Y-m-d H:i:s')]);
            Db::commit(); 
        } catch (\Exception $e) {
            Db::rollback();
        }
        if($res){
            return $this->result( [],  0,'提交成功,请等待审核');
        }else{
            return $this->result( [],  201,'提交失败，请重试');
        }
    }

}
