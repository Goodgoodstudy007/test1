<?php

namespace app\store\controller;

use app\common\controller\Frontend;
use think\Db;
use think\Config;

class Index extends Frontend
{
	protected $noNeedLogin = '*';
	protected $noNeedRight = '*';
    protected $layout = '';
    public function _initialize()
    {
        parent::_initialize();
    }


    public function index()
    {
  
        $this->assign('html_name','index');
        if(empty(session('store_id'))){
            header('Location:/store/user/login');exit;
        }
        // 配置了商户号，就获取openid
        $config = Config::get('site');
        $this->assign('dianshu',$config['dianshu']);
        $openid  = session('openid') ? session('openid') : "";
        if($config['pay_mchid'] && empty($openid) && strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')!==false){
            $wechat = new \fast\Wechat();
            $openid = $wechat->GetOpenid();
            if($openid){
                session('openid',$openid);
            }
        }
        $this->assign('openid',$openid);

        $store_id  = session('store_id');
        //商家信息
        $store = Db::name('store')->where(['id'=>$store_id,'status'=>1])->find();
        if(empty($store)){
            header('Location:/store/user/login');exit;
        }
        $this->assign('store',$store);
        // 总充值
        $all_price = Db::name('store_pay')->where(['store_id'=>$store_id,'status'=>1])->sum('dianshu');
        $this->assign('all_price',$all_price);
        // 我的任务
        $run_task = Db::name('store_task')->where(['store_id'=>$store_id,'status'=>1,'show_status'=>1])->count();
        $stop_task = Db::name('store_task')->where(['store_id'=>$store_id,'status'=>0,'show_status'=>1])->count();
        $finish_task = Db::name('store_task')->where(['store_id'=>$store_id,'status'=>2,'show_status'=>1])->count();
        $this->assign('run_task',$run_task);
        $this->assign('stop_task',$stop_task);
        $this->assign('finish_task',$finish_task);
        // 数据统计
        $all_task = $run_task + $stop_task + $finish_task;
        $this->assign('all_task',$all_task);
        $video_count = Db::name('task_video')->alias('tv')
                            ->join('store_task st','st.id = tv.task_id')
                            ->where(['st.store_id'=>$store_id,'tv.is_show'=>1,'st.show_status'=>1])->count();
        $user_count = Db::name('video_comment')->alias('vc')
                            ->join('store_task st','st.id = vc.task_id')
                            ->where(['st.store_id'=>$store_id])->count();
        $comment_count = Db::name('task_video')->alias('tv')
                            ->join('store_task st','st.id = tv.task_id')
                            ->where(['st.store_id'=>$store_id,'tv.is_show'=>1])->sum('script_count');
        $this->assign('video_count',$video_count);
        $this->assign('user_count',$user_count);
        $this->assign('comment_count',$comment_count);

        return $this->view->fetch();
    }

    // 充值
    public function pay(){
        $store_id  = session('store_id');
        if(empty(session('store_id'))){
            header('Location:/store/user/login');exit;
        }
        //商家信息
        $store = Db::name('store')->where(['id'=>$store_id,'status'=>1])->find();
        if(empty($store)){
            header('Location:/store/user/login');exit;
        }
        $num = input('num',0);
        $openid = input('openid','');
        if($num < 1){
            return $this->result( [],  201,'最低充值1元');
        }
        if(!$openid){
            return $this->result( [],  201,'微信授权失败，请刷新或退出重新登录');
        }
        // 防止重复提交
        $last_pay = Db::name('store_pay')->where('store_id='.$store_id)->order('id desc')->find();
        if($last_pay ){
            if(strtotime($last_pay['addtime']) > time()-10){
                return $this->result( [],  400,'操作频繁');
            }
        }
        $wechat = new \fast\Wechat();
        $out_trade_no = date('YmdHis').rand(1000,9999);
        $scheme = $_SERVER['SERVER_PORT']=='443' ? 'https://' : 'http://';
        $baseUrl = $scheme.$_SERVER['HTTP_HOST'].'/store/index/wx_notify';
        // 记录
        Db::name('store_pay')->insert(['store_id'=>$store_id,'price'=>$num,'addtime'=>date('Y-m-d H:i:s'),'status'=>0,'openid'=>$openid,'out_trade_no'=>$out_trade_no]);
        $jsApiParameters = $wechat->createJsBizPackage($openid, $num, $out_trade_no, '商家充值', $baseUrl, time());
        return $this->result(['jsApiParameters'=>json_encode($jsApiParameters),'money'=>$num,'out_trade_no'=>$out_trade_no],  0,'获取成功');
    }

    public function wx_notify(){
        $xml = file_get_contents('php://input');
        $data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)),1);
        file_put_contents(WWWROOT_PATH.'/pay_log.txt',PHP_EOL."【".date('Y-m-d H:i:s')."】:".PHP_EOL.json_encode($data).PHP_EOL,FILE_APPEND);
        // $data = json_decode('{"appid":"wxee2fcb10a2882aa1","attach":"pay","bank_type":"OTHERS","cash_fee":"10","fee_type":"CNY","is_subscribe":"Y","mch_id":"1608094119","nonce_str":"RJQeYM4MOX7fznKT","openid":"o-rIT6L6I39m-xdiLON1geTj5_fs","out_trade_no":"202107211822224771","result_code":"SUCCESS","return_code":"SUCCESS","sign":"6F6D5422DD9F2E65E954CCB3881BEDAE","time_end":"20210721182227","total_fee":"10","trade_type":"JSAPI","transaction_id":"4200001173202107218997769973"}',1);
        
        if($data['result_code'] == 'SUCCESS' && $data['return_code']=="SUCCESS"){
            // 查询订单存在不
            $order = Db::name('store_pay')->where(['out_trade_no'=>$data['out_trade_no']])->find();
            if($order){
                if($order['status'] == 0){
                    // 开始处理
                    $res = false;
                    Db::startTrans();
                    try{
                        $config = Config::get('site');
                        // 增加余额
                        $price = $data['total_fee'] * 0.01;
                        $dianshu =  $price * $config['dianshu'];
                        Db::name('store')->where(['id'=>$order['store_id']])->setInc('price',$dianshu);
                        // 更新订单
                        $res = Db::name('store_pay')->where(['id'=>$order['id']])->update(['pay_id'=>$data['transaction_id'],'status'=>1,'is_commission'=>1,'uptime'=>date('Y-m-d H:i:s'),'dianshu'=>$dianshu]);
                        // 归类佣金
                        // 1、查询有没有直属代理商
                        $agent_one = Db::name('store')->alias('s')
                                            ->field('a.id,a.rate,a.level,a.agent_pid')
                                            ->join('agent a','a.id = s.agent_id')
                                            ->where(['a.status'=>1,'s.id'=>$order['store_id']])
                                            ->find();
                        if($agent_one){
                            $one_price = $price * $agent_one['rate'] * 0.01;
                            Db::name('agent')->where(['id'=>$agent_one['id']])->setInc('commission',$one_price);
                            Db::name('agent_commission')->insert(['agent_id'=>$agent_one['id'],'store_pay_id'=>$order['id'],'commission'=>$one_price,'rate'=>$agent_one['rate'],'addtime'=>date('Y-m-d H:i:s'),'status'=>1,'level'=>1]);
                            // 2、查询代理商有没有上一级
                            if($agent_one['level'] == 2){
                                $agent_two = Db::name('agent')->field('id,rate,level,agent_pid')->where(['id'=>$agent_one['agent_pid']])->find();
                                if($agent_two){
                                    $two_rate = $agent_two['rate'] - $agent_one['rate'];
                                    if($two_rate > 0){
                                        $two_price = $price * $two_rate * 0.01;
                                        Db::name('agent')->where(['id'=>$agent_two['id']])->setInc('commission',$two_price);
                                        Db::name('agent_commission')->insert(['agent_id'=>$agent_two['id'],'store_pay_id'=>$order['id'],'commission'=>$two_price,'rate'=>$two_rate,'addtime'=>date('Y-m-d H:i:s'),'status'=>1,'level'=>2]);
                                    }
                                    
                                }
                            }
                        }
                        
                        Db::commit(); 
                    } catch (\Exception $e) {
                        // var_dump($e);exit;
                        Db::rollback();
                    }
                    if($res){
                        echo  "success";
                    }else{
                        echo  "fail";
                    }
                }else{
                    echo  "success";
                }
                
            }else{
                echo  "fail";
            }
        }

    }

}
