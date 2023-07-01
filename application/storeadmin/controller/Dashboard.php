<?php

namespace app\storeadmin\controller;

use app\admin\model\Admin;
use app\admin\model\User;
use app\common\controller\Backend;
use app\common\model\Attachment;
use fast\Date;
use think\Db;

/**
 * 控制台
 *
 * @icon   fa fa-dashboard
 * @remark 用于展示当前系统中的统计数据、统计报表及重要实时数据
 */
class Dashboard extends Backend
{
    protected $noNeedLogin = ['*'];
    /**
     * 查看
     */
    public function index()
    {

        $store_id = session('store_id');
        try {
            \think\Db::execute("SET @@sql_mode='';");
        } catch (\Exception $e) {

        }
        $starttime = Date::unixtime('day', -10);
        $endtime = Date::unixtime('day', 0, 'end');
        $dates = [];
        for ($i=0; $i<=10; $i++){
          $dates[$i] = date('Y-m-d' ,strtotime( '+' . $i-10 .' days', time()));
        }
        foreach ($dates as $k => $v) {
            $index_task_date[] =  '"'.date('m-d',strtotime($v)).'"';
            $index_task_num = Db::name("video_comment")->alias('vc')
                                            ->join('store_task st','st.id = vc.task_id')
                                            ->where('DATE_FORMAT(vc.addtime, "%Y-%m-%d")="'.$v.'" and st.store_id='.$store_id)->count();
            $map_task_num = Db::name('map_customer')->alias('c')
                                        ->join('map_task st','st.id = c.map_task_id')
                                        ->where('DATE_FORMAT(c.addtime, "%Y-%m-%d")="'.$v.'" and st.store_id='.$store_id)->count();
            $xhs_task_num = Db::name("xhs_comment")->alias('vc')
                                            ->join('xhs_task st','st.id = vc.task_id')
                                            ->where('DATE_FORMAT(vc.addtime, "%Y-%m-%d")="'.$v.'" and st.store_id='.$store_id)->count();
            $ks_task_num = Db::name("ks_comment")->alias('vc')
                                            ->join('ks_task st','st.id = vc.task_id')
                                            ->where('DATE_FORMAT(vc.addtime, "%Y-%m-%d")="'.$v.'" and st.store_id='.$store_id)->count();
            $index_task_count[] =  $index_task_num + $map_task_num + $xhs_task_num + $ks_task_num;
        }
        $index_task_date = implode(',', $index_task_date);
        $index_task_count = implode(',', $index_task_count);
        // 客户提取列表
        $user_list = Db::name('video_comment')->alias('vc')->field('vc.id,st.url,vc.comment,vc.addtime,vc.userid,st.title')
                                        ->join('store_task st','st.id = vc.task_id')
                                        ->where(['st.store_id'=>$store_id])
                                        ->order('vc.id desc')->limit(100)
                                        ->select();
        if($user_list){
            foreach ($user_list as $key => $value) {
                $user_list[$key]['userid'] =  mb_substr($value['userid'], 0, 3, 'utf-8').'****'.mb_substr($value['userid'], -1, 3, 'utf-8');
            }
        }
        // 充值统计
        $store_info = Db::name('store')->where(['id'=>$store_id])->find();
        $all_price = Db::name("store_pay")->where(['store_id'=>$store_id,'status'=>1])->sum('price');
        $use_price = Db::name('video_comment')->alias('vc')
                                        ->join('store_task st','st.id = vc.task_id')
                                        ->where(['st.store_id'=>$store_id])
                                        ->count()
                                         + Db::name('map_customer')->alias('c')
                                        ->join('map_task st','st.id = c.map_task_id')
                                        ->where(['st.store_id'=>$store_id])->count()
                                         + Db::name('xhs_comment')->alias('vc')
                                        ->join('xhs_task st','st.id = vc.task_id')
                                        ->where(['st.store_id'=>$store_id])
                                        ->count()
                                         + Db::name('ks_comment')->alias('vc')
                                        ->join('ks_task st','st.id = vc.task_id')
                                        ->where(['st.store_id'=>$store_id])
                                        ->count();

        $today = date('Y-m-d');
        $dbTableList = Db::query("SHOW TABLE STATUS");
        $this->view->assign([
            'index_task'      => Db::name('store_task')->where(['mode'=>1,'show_status'=>1,'store_id'=>$store_id])->count(),
            'video_task'      => Db::name('store_task')->where(['mode'=>2,'show_status'=>1,'store_id'=>$store_id])->count(),
            'key_task'      => Db::name('store_task')->where(['mode'=>3,'show_status'=>1,'store_id'=>$store_id])->count() + Db::name('xhs_task')->where(['store_id'=>$store_id])->count() + Db::name('ks_task')->where(['store_id'=>$store_id])->count(),
            'run_task'      => Db::name('store_task')->where(['status'=>1,'show_status'=>1,'store_id'=>$store_id])->count() + Db::name('map_task')->where(['status'=>1,'store_id'=>$store_id])->count() + Db::name('xhs_task')->where(['status'=>1,'store_id'=>$store_id])->count() + Db::name('ks_task')->where(['status'=>1,'store_id'=>$store_id])->count(),
            'all_task'      => Db::name('store_task')->where(['store_id'=>$store_id,'show_status'=>1])->count() + Db::name('map_task')->where(['store_id'=>$store_id])->count() + Db::name('xhs_task')->where(['store_id'=>$store_id])->count() + Db::name('ks_task')->where(['store_id'=>$store_id])->count(),
            'all_video'      => Db::name('task_video')->alias('tc')
                                        ->join('store_task st','st.id = tc.task_id')
                                        ->where(['st.store_id'=>$store_id,'tc.is_show'=>1,'st.show_status'=>1])->count()
                                        + Db::name('xhs_note')->alias('tc')
                                        ->join('xhs_task st','st.id = tc.task_id')
                                        ->where(['st.store_id'=>$store_id])->count()
                                        + Db::name('ks_video')->alias('tc')
                                        ->join('ks_task st','st.id = tc.task_id')
                                        ->where(['st.store_id'=>$store_id])->count(),
            'all_comment'      => Db::name('video_comment')->alias('vc')
                                        ->join('store_task st','st.id = vc.task_id')
                                        ->where(['st.store_id'=>$store_id])->count()
                                         + Db::name('map_customer')->alias('c')
                                        ->join('map_task st','st.id = c.map_task_id')
                                        ->where(['st.store_id'=>$store_id])->count()
                                        + Db::name('xhs_comment')->alias('vc')
                                        ->join('xhs_task st','st.id = vc.task_id')
                                        ->where(['st.store_id'=>$store_id])->count()
                                        + Db::name('ks_comment')->alias('vc')
                                        ->join('ks_task st','st.id = vc.task_id')
                                        ->where(['st.store_id'=>$store_id])->count(),
            'user_list'     =>  $user_list,
            'store_info'    =>  $store_info,
            'use_price'     =>  $use_price,
            'all_price'     =>  $all_price, 
            'index_task_date'     =>  $index_task_date, 
            'index_task_count'     =>  $index_task_count, 
        ]);

        return $this->view->fetch();
    }

}
