<?php

namespace app\agent\controller;

use app\common\controller\Frontend;
use think\Db;

class Index extends Frontend
{
	protected $noNeedLogin = '*';
	protected $noNeedRight = '*';
    protected $layout = '';
    public function _initialize()
    {
        parent::_initialize();
        if(empty(session('p_agent_id'))){
            header('Location:/agent/user/login');exit;
        }
    }


    public function index()
    {
        $this->assign('html_name','index');
        $agent_id  = session('p_agent_id');
        //商家信息
        $agent = Db::name('agent')->where(['id'=>$agent_id,'status'=>1])->find();
        if(empty($agent)){
            header('Location:/agent/user/login');exit;
        }
        $this->assign('agent',$agent);
        // 商家数
        $store_count = Db::name('store')->where(['agent_id'=>$agent_id,'status'=>1])->count();
        $agent_count = Db::name('agent')->where(['agent_pid'=>$agent_id,'status'=>1])->count();
        $agent_store_count = Db::name('store')->alias('s')
                                ->join('agent a','a.id = s.agent_id')
                                ->where(['a.agent_pid'=>$agent_id,'s.status'=>1])
                                ->count();
        $this->assign('store_count',$store_count);
        $this->assign('agent_count',$agent_count);
        $this->assign('agent_store_count',$agent_store_count);
        // 佣金统计
        $all_commission = Db::name('agent_commission')->where(['agent_id'=>$agent_id,'status'=>1])->sum('commission');
        $this->assign('all_commission',$all_commission);
        // 商家总充值
        $all_price = Db::name('store_pay')->alias('sp')
                        ->join('store s','s.id = sp.store_id')
                        ->where(['s.agent_id'=>$agent_id,'sp.status'=>1])
                        ->sum('sp.price');
        $this->assign('all_price',$all_price);
        $today_price = Db::name('store_pay')->alias('sp')
                        ->join('store s','s.id = sp.store_id')
                        ->where(['s.agent_id'=>$agent_id,'sp.status'=>1])
                        ->where('DATE_FORMAT(sp.addtime,"%Y-%m-%d")="'.date('Y-m-d').'"')
                        ->sum('sp.price');
        $this->assign('today_price',$today_price);
        //下级商家总充值
        $agent_all_price = Db::name('store_pay')->alias('sp')
                        ->join('store s','s.id = sp.store_id')
                        ->join('agent a','a.id = s.agent_id')
                        ->where(['a.agent_pid'=>$agent_id,'sp.status'=>1])
                        ->sum('sp.price');
        $this->assign('agent_all_price',$agent_all_price);
        $agent_today_price = Db::name('store_pay')->alias('sp')
                        ->join('store s','s.id = sp.store_id')
                        ->join('agent a','a.id = s.agent_id')
                        ->where(['a.agent_pid'=>$agent_id,'sp.status'=>1])
                        ->where('DATE_FORMAT(sp.addtime,"%Y-%m-%d")="'.date('Y-m-d').'"')
                        ->sum('sp.price');
        $this->assign('agent_today_price',$agent_today_price);
        // 商家运行任务
        $run_task = Db::name('store_task')->alias('st')
                            ->join('store s','s.id = st.store_id')
                            ->where(['s.agent_id'=>$agent_id,'st.status'=>1])->count();
        $this->assign('run_task',$run_task);


        return $this->view->fetch();
    }


}
