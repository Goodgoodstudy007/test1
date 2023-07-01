<?php

namespace app\agent\controller;

use app\common\controller\Frontend;
use think\Db;
use think\Config;

class Store extends Frontend
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

    // 查询所有直属商家
    public function index()
    {
        $this->assign('html_name','store');
        $agent_id  = session('p_agent_id');
        $agent = Db::name('agent')->where(['id'=>$agent_id,'status'=>1])->find();
        if(empty($agent)){
            return $this->result( [],  201,'代理不存在');
        }
        $this->assign('agent',$agent);

        $where['s.agent_id'] = $agent_id;
        $where['s.status'] = 1;
        // 查询所有直属商家
        $stores = Db::name('store')->alias('s')
                        ->field('s.id,s.price,s.username,s.store_name,s.out_date,s.addtime')
                        ->where($where)
                        ->order('s.id desc')
                        ->select();
        if($stores){
            foreach ($stores as $key => $value) {
                $stores[$key]['run_task'] = Db::name('store_task')->where(['store_id'=>$value['id'],'status'=>1])->count();
                $stores[$key]['all_price'] = Db::name('store_pay')->where(['store_id'=>$value['id'],'status'=>1])->sum('price');
            }
        }
        $this->assign('stores',$stores);
        return $this->view->fetch();
    }

    // 查询所有直属代理
    public function agent_list()
    {
        $this->assign('html_name','store');
        $agent_id  = session('p_agent_id');
        $agent = Db::name('agent')->where(['id'=>$agent_id,'status'=>1])->find();
        if(empty($agent)){
            return $this->result( [],  201,'代理不存在');
        }
        $this->assign('agent',$agent);
        
        $where['agent_pid'] = $agent_id;
        $where['status'] = 1;
        // 查询所有直属商家
        $agent_list = Db::name('agent')
                        ->where($where)
                        ->order('id desc')
                        ->select();
        if($agent_list){
            foreach ($agent_list as $key => $value) {
                $agent_list[$key]['store_sum'] = Db::name('store')->where(['agent_id'=>$value['id'],'status'=>1])->count();
            }
        }
        $this->assign('agent_list',$agent_list);
        return $this->view->fetch();
    }

    // 查询所有下级商家
    public function sub_store()
    {
        $this->assign('html_name','store');
        $agent_id  = session('p_agent_id');
        $agent = Db::name('agent')->where(['id'=>$agent_id,'status'=>1])->find();
        if(empty($agent)){
            return $this->result( [],  201,'代理不存在');
        }
        $this->assign('agent',$agent);

        $where['a.agent_pid'] = $agent_id;
        $where['s.status'] = 1;
        // 查询所有直属商家
        $stores = Db::name('store')->alias('s')
                        ->field('s.id,s.price,s.username,s.store_name,s.out_date,s.addtime')
                        ->join('agent a','a.id = s.agent_id')
                        ->where($where)
                        ->order('s.id desc')
                        ->select();
        if($stores){
            foreach ($stores as $key => $value) {
                $stores[$key]['run_task'] = Db::name('store_task')->where(['store_id'=>$value['id'],'status'=>1])->count();
                $stores[$key]['all_price'] = Db::name('store_pay')->where(['store_id'=>$value['id'],'status'=>1])->sum('price');
            }
        }
        $this->assign('stores',$stores);
        return $this->view->fetch();
    }

    // 新增
    public function add_store(){
        $this->assign('html_name','store');
        return $this->view->fetch();
    }
    public function add_store_post(){
        $agent_id  = session('p_agent_id');
        $agent = Db::name('agent')->where(['id'=>$agent_id,'status'=>1])->find();
        if(empty($agent)){
            return $this->result( [],  201,'代理不存在');
        }
        $store_name = input('store_name','');
        $username = input('username','');
        $password = input('password','');
        $out_date = input('out_date','');
        if(!$store_name){return $this->result( [],  201,'商家名称不能为空');}
        if(!$username){return $this->result( [],  201,'账号不能为空');}
        if(strlen($password) < 6){return $this->result( [],  201,'密码要求6位以上');}
        if($out_date < date('Y-m-d')){return $this->result( [],  201,'过期时间选择有误');}
        // 查询有没有存在
        $this_store = Db::name('store')->where(['username'=>$username])->count();
        if($this_store){
            return $this->result( [],  201,'该商家登录账号已经添加过了');
        }
        // 判断该代理的商家总数
        $store_count = Db::name('store')->where(['status'=>1,'agent_id'=>$agent_id])->count();
        if($agent['store_count'] <= $store_count){
            return $this->result( [],  201,'添加商家已上限');
        }
        $password = md5($password);
        $res = Db::name('store')->insert(['store_name'=>$store_name,'agent_id'=>$agent_id,'username'=>$username,'password'=>$password,'out_date'=>$out_date,'addtime'=>date('Y-m-d H:i:s')]);
        if($res){
            return $this->result( [],  0,'创建成功');
        }else{
            return $this->result( [],  201,'新建失败，请检查格式');
        }
    }
    // 删除
    public function delete_store(){
        $store_id = input('store_id',0);
        $agent_id  = session('p_agent_id');
        $res = Db::name('store')->where(['id'=>$store_id,'agent_id'=>$agent_id])->update(['uptime'=>date('Y-m-d H:i:s'),'status'=>-1]);
        if($res || $res===0){
            return $this->result( [],  0,'删除成功');
        }else{
            return $this->result( [],  201,'删除失败，请检查格式');
        }
    }

    // 编辑
    public function edit_store(){
        $this->assign('html_name','store');
        $agent_id  = session('p_agent_id');
        $store_id = input('store_id',0);
        $store = Db::name('store')->where('status>=0 and agent_id='.$agent_id.' and id='.$store_id)->find();
        if(!$store){
            header('Location:/agent/store/index');exit;
        }
        $this->assign('store',$store);
        return $this->view->fetch();
    }

    // 更新
    public function edit_store_post(){
        $agent_id  = session('p_agent_id');
        $store_id = input('store_id','');
        $store_name = input('store_name','');
        $out_date = input('out_date','');
        if(!$store_id){return $this->result( [],  201,'商家不存在');}
        if(!$store_name){return $this->result( [],  201,'商家名称不能为空');}
        if($out_date < date('Y-m-d')){return $this->result( [],  201,'过期时间选择有误');}
        // 更新任务
        $res = Db::name('store')->where('status>=0 and agent_id='.$agent_id.' and  id='.$store_id)->update(['store_name'=>$store_name,'out_date'=>$out_date]);
        if($res || $res===0){
            return $this->result( [],  0,'编辑成功');
        }else{
            return $this->result( [],  201,'编辑失败，请检查格式');
        }
    }

    // 新增代理
    public function add_agent(){
        $this->assign('html_name','store');
        return $this->view->fetch();
    }

    public function add_agent_post(){
        $agent_id  = session('p_agent_id');
        $agent = Db::name('agent')->where(['id'=>$agent_id,'status'=>1])->find();
        if(empty($agent)){
            return $this->result( [],  201,'代理不存在');
        }
        $agent_name = input('agent_name','');
        $username = input('username','');
        $password = input('password','');
        $out_date = input('out_date','');
        $store_count = input('store_count',0);
        $rate = input('rate',0);
        if(!$agent_name){return $this->result( [],  201,'代理名称不能为空');}
        if(!$username){return $this->result( [],  201,'账号不能为空');}
        if(strlen($password) < 6){return $this->result( [],  201,'密码要求6位以上');}
        if($out_date < date('Y-m-d')){return $this->result( [],  201,'过期时间选择有误');}
        // 判断商家数
        if($agent['store_count'] <= $store_count){
            return $this->result( [],  201,'商家数不能超过一级代理的商家数');
        }
        // 判断分红比例
        if($agent['rate'] <= $rate  && $rate!=0){
            return $this->result( [],  201,'分红比例不能超过一级代理的比例');
        }
        // 查询有没有存在
        $this_agent = Db::name('agent')->where(['username'=>$username])->count();
        if($this_agent){
            return $this->result( [],  201,'该代理商登录账号已经添加过了');
        }
        // 判断该代理的下级总数
        $agent_count = Db::name('agent')->where(['status'=>1,'agent_pid'=>$agent_id])->count();
        if($agent['agent_count'] <= $agent_count){
            return $this->result( [],  201,'添加代理已上限');
        }
        $password = md5($password);
        $res = Db::name('agent')->insert(['agent_name'=>$agent_name,'agent_pid'=>$agent_id,'username'=>$username,'password'=>$password,'out_date'=>$out_date,'addtime'=>date('Y-m-d H:i:s'),'store_count'=>$store_count,'rate'=>$rate,'level'=>2]);
        if($res){
            return $this->result( [],  0,'创建成功');
        }else{
            return $this->result( [],  201,'新建失败，请检查格式');
        }
    }

    // 编辑
    public function edit_agent(){
        $this->assign('html_name','store');
        $agent_pid  = session('p_agent_id');
        $agent_id = input('agent_id',0);
        $agent = Db::name('agent')->where('status>=0 and agent_pid='.$agent_pid.' and id='.$agent_id)->find();
        if(!$agent){
            header('Location:/agent/store/agent_list');exit;
        }
        $this->assign('agent',$agent);
        return $this->view->fetch();
    }

    // 更新
    public function edit_agent_post(){
        $agent_pid  = session('p_agent_id');
        $agent = Db::name('agent')->where(['id'=>$agent_pid,'status'=>1])->find();
        if(empty($agent)){
            return $this->result( [],  201,'代理不存在');
        }
        $agent_id = input('agent_id','');
        $agent_name = input('agent_name','');
        $out_date = input('out_date','');
        $store_count = input('store_count',0);
        $rate = input('rate',0);
        if(!$agent_id){return $this->result( [],  201,'代理不存在');}
        if(!$agent_name){return $this->result( [],  201,'代理名称不能为空');}
        if($out_date < date('Y-m-d')){return $this->result( [],  201,'过期时间选择有误');}
        // 判断商家数
        if($agent['store_count'] <= $store_count){
            return $this->result( [],  201,'商家数不能超过一级代理的商家数');
        }
        // 判断分红比例
        if($agent['rate'] <= $rate){
            return $this->result( [],  201,'分红比例不能超过一级代理的比例');
        }
        // 更新任务
        $res = Db::name('agent')->where('status>=0 and agent_pid='.$agent_pid.' and  id='.$agent_id)->update(['agent_name'=>$agent_name,'out_date'=>$out_date,'store_count'=>$store_count,'rate'=>$rate]);
        if($res || $res===0){
            return $this->result( [],  0,'编辑成功');
        }else{
            return $this->result( [],  201,'编辑失败，请检查格式');
        }
    }
    // 删除
    public function delete_agent(){
        $agent_id = input('agent_id',0);
        $agent_pid  = session('p_agent_id');
        $res = Db::name('agent')->where(['id'=>$agent_id,'agent_pid'=>$agent_pid])->update(['uptime'=>date('Y-m-d H:i:s'),'status'=>-1]);
        if($res || $res===0){
            return $this->result( [],  0,'删除成功');
        }else{
            return $this->result( [],  201,'删除失败，请检查格式');
        }
    }

    // 手动充值商家点数
    public function pay_store(){
        $agent_id  = session('p_agent_id');
        $agent = Db::name('agent')->where(['id'=>$agent_id,'status'=>1])->find();
        if(empty($agent)){
            return $this->result( [],  201,'代理不存在');
        }
        $store_id = input('store_id',0);
        if(!$store_id){
            return $this->result( [],  201,'请选择充值的商家');
        }
        $dianshu = input('dianshu',0);
        if($dianshu < 1){
            return $this->result( [],  201,'请输入充值的点数');
        }
        if($agent['dianshu'] < $dianshu){
            return $this->result( [],  201,'你的自身点数不足，请先充值');
        }
        // 防止重复提交
        $last_pay = Db::name('store_pay')->where('agent_id='.$agent_id)->order('id desc')->find();
        if($last_pay ){
            if(strtotime($last_pay['addtime']) > time()-30){
                return $this->result( [],  400,'操作频繁');
            }
        }
        $res = false;
        Db::startTrans();
        try{
            // 扣除点数
            Db::name('agent')->where(['id'=>$agent_id])->setDec('dianshu',$dianshu);
            // 增加商家
            Db::name('store')->where(['id'=>$store_id])->setInc('price',$dianshu);
            // 查询一个点数等于多少钱
            $config = Config::get('site');
            $dianshu_base =  1/$config['dianshu'];
            $price  = $dianshu * $dianshu_base;
            // 开始新建
            $res = Db::name('store_pay')->insert(['store_id'=>$store_id,'price'=>$price,'addtime'=>date('Y-m-d H:i:s'),'uptime'=>date('Y-m-d H:i:s'),'status'=>1,'agent_id'=>$agent_id,'dianshu'=>$dianshu]);
            Db::commit(); 
        } catch (\Exception $e) {
            Db::rollback();
        }
        if($res){
            return $this->result( [],  0,'充值成功');
        }else{
            return $this->result( [],  201,'充值失败');
        }
    }

    // 手动充值商家点数
    public function pay_agent(){
        $agent_pid  = session('p_agent_id');
        $agent = Db::name('agent')->where(['id'=>$agent_pid,'status'=>1])->find();
        if(empty($agent)){
            return $this->result( [],  201,'代理不存在');
        }
        $agent_id = input('agent_id',0);
        if(!$agent_id){
            return $this->result( [],  201,'请选择充值的代理');
        }
        $dianshu = input('dianshu',0);
        if($dianshu < 1){
            return $this->result( [],  201,'请输入充值的点数');
        }
        if($agent['dianshu'] < $dianshu){
            return $this->result( [],  201,'你的自身点数不足，请先充值');
        }
        // 防止重复提交
        $last_pay = Db::name('agent_pay')->where('agent_pid='.$agent_pid)->order('id desc')->find();
        if($last_pay ){
            if(strtotime($last_pay['addtime']) > time()-30){
                return $this->result( [],  400,'操作频繁');
            }
        }
        $res = false;
        Db::startTrans();
        try{
            // 扣除点数
            Db::name('agent')->where(['id'=>$agent_pid])->setDec('dianshu',$dianshu);
            // 增加商家
            Db::name('agent')->where(['id'=>$agent_id])->setInc('dianshu',$dianshu);
            // 开始新建
            $res = Db::name('agent_pay')->insert(['agent_id'=>$agent_id,'agent_pid'=>$agent_pid,'addtime'=>date('Y-m-d H:i:s'),'status'=>1,'dianshu'=>$dianshu]);
            Db::commit(); 
        } catch (\Exception $e) {
            Db::rollback();
        }
        if($res){
            return $this->result( [],  0,'充值成功');
        }else{
            return $this->result( [],  201,'充值失败');
        }
    }
}
