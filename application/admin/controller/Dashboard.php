<?php

namespace app\admin\controller;

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

    /**
     * 查看
     */
    public function index()
    {

        try {
            \think\Db::execute("SET @@sql_mode='';");
        } catch (\Exception $e) {

        }
        $column = [];
        $starttime = Date::unixtime('day', -6);
        $endtime = Date::unixtime('day', 0, 'end');
        $joinlist = Db::name("store_pay")->where('addtime', 'between time', [$starttime, $endtime])
            ->field('addtime, status, sum(price) AS nums, DATE_FORMAT(addtime, "%Y-%m-%d") AS join_date')
            ->where(['status'=>1])
            ->group('join_date')
            ->select();
        for ($time = $starttime; $time <= $endtime;) {
            $column[] = date("Y-m-d", $time);
            $time += 86400;
        }
        $userlist = array_fill_keys($column, 0);
        foreach ($joinlist as $k => $v) {
            $userlist[$v['join_date']] = $v['nums'];
        }

        $today = date('Y-m-d');
        $dbTableList = Db::query("SHOW TABLE STATUS");
        $this->view->assign([
            'store_count'       => Db::name('store')->where(['status'=>1])->count(),
            'agent_one_count'      => Db::name('agent')->where(['status'=>1,'level'=>1])->count(),
            'agent_sub_count'      => Db::name('agent')->where(['status'=>1,'level'=>2])->count(),
            'today_store_count' => Db::name('store')->where(['status'=>1])->whereTime('addtime', 'today')->count(),
            'today_agent_one'  => Db::name('agent')->where(['status'=>1,'level'=>1])->whereTime('addtime', 'today')->count(),
            'today_agent_sub'  => Db::name('agent')->where(['status'=>1,'level'=>2])->whereTime('addtime', 'today')->count(),
            'today_store_pay'  => Db::name('store_pay')->where(['status'=>1])->whereTime('addtime', 'today')->sum('price'),
            'agent_commission'  => Db::name('agent_commission')->where(['status'=>1])->whereTime('addtime', 'today')->sum('commission'),
            'thirty_pay'       => Db::name('store_pay')->where(['status'=>1])->whereTime('addtime', '-30 days')->sum('price'),
            'run_task'      => Db::name('store_task')->where(['status'=>1])->count(),
            'all_task'      => Db::name('store_task')->count(),
            'all_video'      => Db::name('task_video')->count(),
            'all_comment'      => Db::name('video_comment')->count(),
        ]);

        $this->assignconfig('column', array_keys($userlist));
        $this->assignconfig('userdata', array_values($userlist));

        return $this->view->fetch();
    }

}
