<?php

namespace app\store\controller;

use app\common\controller\Frontend;
use think\Db;
use think\Config;

class Task extends Frontend
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
        $store_id  = session('store_id');
        if(empty(session('store_id'))){
            header('Location:/store/user/login');exit;
        }
        $status = input('status',-1);
        $mode = input('mode',1);
        $this->assign('html_name','task_mode'.$mode);
        $this->assign('mode',$mode);
        $where['store_id'] = $store_id;
        $where['st.mode'] = $mode;
        $where['st.show_status'] = 1;
        if($status > -1){
            $where['status'] = $status;
        }
        // 查询所有任务
        $tasks = Db::name('store_task')->alias('st')
                        ->field('st.id,st.title,st.dcount,st.status,case st.status when 1 then "运行中" when 2 then "已完成" else "已暂停" end as status_info,st.price')
                        ->where($where)
                        ->where('status >= 0')
                        ->order('st.id desc')
                        ->select();
        if($tasks){
            foreach ($tasks as $key => $value) {
                $tasks[$key]['vcount'] = Db::name('task_video')->where(['task_id'=>$value['id']])->count();
                $tasks[$key]['ccount'] = Db::name('video_comment')->where(['task_id'=>$value['id']])->count();
            }
        }
        $this->assign('tasks',$tasks);
        $config = Config::get('site');
        $is_add = 1;
        $run_task = Db::name('store_task')->where(['status'=>1,'store_id'=>$store_id,'show_status'=>1])->count();
        if($config['max_task'] <= count($run_task)){
            $is_add = 0;
        }
        $this->assign('is_add',$is_add);
        return $this->view->fetch();
    }

    // 解析任务链接
    public function jiexi(){
        $douyin_url = input('douyin_url','');
        if(!$douyin_url){
            return $this->result( [],  201,'抖音链接不能为空');
        }
        $douyin_url = trim($douyin_url);
        $douyin_header = get_headers($douyin_url);
        preg_match("/sec_uid=(.*?)&/si", $douyin_header[6], $uid_match);
        $sec_uid = $uid_match[1];
        // 获取用户信息
        // $out_json = exec(PYTHON.' '.WWWROOT_PATH.'/node/run.py user_info '.$sec_uid);
        $param = ['kw'=>$sec_uid];
        $api = new \app\index\controller\Douyin();
        $out_json = $api->check_proxy('https://www.iesdouyin.com/web/api/v2/user/info/?sec_uid='.$sec_uid,$param,1);
        // var_dump($out_json);exit;
        if($out_json){
            // 填充博主信息
            $out_res = json_decode($out_json,1);
            $out_res = $out_res['user_info'];
            $head = empty(@$out_res['avatar_thumb']['url_list'][0]) ? '' : @$out_res['avatar_thumb']['url_list'][0];
            $fans = empty(@$out_res['follower_count']) ? 0 : @$out_res['follower_count'];
            $follow = empty(@$out_res['following_count']) ? 0 : @$out_res['following_count'];
            $zan = empty(@$out_res['total_favorited']) ? 0 : @$out_res['total_favorited'];
            $userid = empty(@$out_res['uid']) ? '' : @$out_res['uid'];
            $username = empty(@$out_res['nickname']) ? '' : @$out_res['nickname'];
            $desc = empty(@$out_res['signature']) ? '' : @$out_res['signature'];
            $video_count = empty(@$out_res['aweme_count']) ? 0 : @$out_res['aweme_count'];
            $sec_user_id = $sec_uid;
            return $this->result( ['head'=>$head,'fans'=>$fans,'follow'=>$follow,'zan'=>$zan,'userid'=>$userid,'username'=>$username,'desc'=>$desc,'video_count'=>$video_count,'sec_user_id'=>$sec_user_id],  0,'解析成功');
        }else{
            return $this->result( [],  201,'解析失败');
        }
    }

    // 新增任务
    public function add(){
        if(empty(session('store_id'))){
            header('Location:/store/user/login');exit;
        }
        $mode = input('mode',1);
        $this->assign('html_name','task_mode'.$mode);
        $mode = input('mode',1);
        $this->assign('mode',$mode);
        return $this->view->fetch();
    }
    public function add_post(){
        if(empty(session('store_id'))){
            header('Location:/store/user/login');exit;
        }
        $store_id  = session('store_id');
        $title = input('title','');
        $douyin_url = input('douyin_url','');
        $keywords = input('keywords','');
        $config = Config::get('site');
        $dcount = input('dcount',$config['max_video']);
        $sec_user_id = input('sec_user_id','');
        $desc = input('desc','');
        $fans = input('fans',0);
        $follow = input('follow',0);
        $head = input('head','');
        $userid = input('userid','');
        $username = input('username','');
        $zan = input('zan',0);
        $mode = input('mode',1);
        $sort_type = input('sort_type',0);
        $publish_time = input('publish_time',0);
        $video_count = input('video_count',0);
        if(!$title){return $this->result( [],  201,'标题不能为空');}
        if(!$douyin_url){return $this->result( [],  201,'链接错误');}
        if(!$keywords){return $this->result( [],  201,'关键词不能为空');}
        // if($dcount < 1){return $this->result( [],  201,'请填写最大询盘个数');}
        if($store_id < 6){
            // 测试商家，只能一个视频
            $dcount = 3;
        }
        // 查询有没有存在
        $this_title = Db::name('store_task')->where(['title'=>$title,'store_id'=>$store_id,'status'=>1])->count();
        if($this_title){
            return $this->result( [],  201,'该任务已经添加过了');
        }
        // 判断余额够不够
        $price = 0;
        $store_price = Db::name('store')->where(['id'=>$store_id])->value('price');
        if( $store_price < 1){
            return $this->result( [],  201,'点数不足1点，请先充值');
        }
        // 最大任务
        $config = Config::get('site');
        $run_task = Db::name('store_task')->where(['status'=>1,'store_id'=>$store_id])->count();
        $map_task = Db::name('map_task')->where(['status'=>1,'store_id'=>$store_id])->count();
        $ks_task = Db::name('ks_task')->where(['status'=>1,'store_id'=>$store_id])->count();
        $xhs_task = Db::name('xhs_task')->where(['status'=>1,'store_id'=>$store_id])->count();
        $run_task = $map_task + $run_task + $xhs_task + $ks_task;
        $task_count = Db::name('store')->where(['id'=>$store_id])->value('task_count');
        if(!$task_count){
            $task_count = $config['max_task'];
        }
        if($task_count <= $run_task){
            return $this->error('已达到最大运行任务');
        }
        $dy_count = Db::name('store')->where(['id'=>$store_id])->value('dy_count');
        if($dy_count > 0){
            $dcount = $dy_count;
        }
        $res = false;
        Db::startTrans();
        try{
            // 扣除余额
            // Db::name('store')->where(['id'=>$store_id])->setDec('price',$price);
            // 开始新建
            $res = Db::name('store_task')->insert(['title'=>$title,'store_id'=>$store_id,'url'=>$douyin_url,'keywords'=>$keywords,'dcount'=>$dcount,'sec_user_id'=>$sec_user_id,'desc'=>$desc,'fans'=>$fans,'follow'=>$follow,'head'=>$head,'userid'=>$userid,'username'=>$username,'zan'=>$zan,'video_count'=>$video_count,'price'=>$price,'mode'=>$mode,'addtime'=>date('Y-m-d H:i:s'),'sort_type'=>$sort_type,'publish_time'=>$publish_time]);
            Db::commit(); 
        } catch (\Exception $e) {
            Db::rollback();
        }
        if($res){
            return $this->result( [],  0,'创建成功');
        }else{
            return $this->result( [],  201,'新建失败，请检查格式');
        }
    }

    // 任务详情
    public function info(){
        if(empty(session('store_id'))){
            header('Location:/store/user/login');exit;
        }
        $store_id  = session('store_id');
        $task_id = input('task_id',0);
        $task = Db::name('store_task')->where('status>=0  and store_id='.$store_id.' and id='.$task_id)->find();
        if(!$task){
            header('Location:/store/task/index');exit;
        }
        $this->assign('html_name','task_mode'.$task['mode']);
        $task['status_info'] = $task['status']==1 ? '<span style="color:#3dc34a;font-size:16px;font-weight:bold">运行中</span>' : '<span style="color:#f44336;font-size:16px;font-weight:bold">已暂停</span>';
        $task['status_info'] = $task['status']==2 ? '<span style="color:#9d9ca4;font-size:16px;font-weight:bold">已完成</span>' : $task['status_info'];
        $this->assign('task',$task);
        // 查询统计
        $vcount = Db::name('task_video')->where(['task_id'=>$task_id,'is_show'=>1])->count();
        $ccount = Db::name('video_comment')->where(['task_id'=>$task_id])->count();
        $pcount = Db::name('video_comment')->where('phone!="" and task_id='.$task_id)->count();
        $scount = Db::name('task_video')->where(['task_id'=>$task_id])->sum('script_count');
        $this->assign('vcount',$vcount);
        $this->assign('ccount',$ccount);
        $this->assign('pcount',$pcount);
        $this->assign('scount',$scount);
        return $this->view->fetch();
    }

    // 删除
    public function delete(){
        if(empty(session('store_id'))){
            header('Location:/store/user/login');exit;
        }
        $task_id = input('task_id',0);
        $store_id  = session('store_id');
        $res = Db::name('store_task')->where(['id'=>$task_id,'store_id'=>$store_id])->update(['uptime'=>date('Y-m-d H:i:s'),'status'=>-1]);
        if($res || $res===0){
            return $this->result( [],  0,'删除成功');
        }else{
            return $this->result( [],  201,'删除失败，请检查格式');
        }
    }

    // 编辑
    public function edit(){
        if(empty(session('store_id'))){
            header('Location:/store/user/login');exit;
        }
        $this->assign('html_name','task');
        $store_id  = session('store_id');
        $task_id = input('task_id',0);
        $store_task = Db::name('store_task')->where('status>=0 and store_id='.$store_id.' and id='.$task_id)->find();
        if(!$store_task){
            header('Location:/store/task/index');exit;
        }
        $this->assign('html_name','task_mode'.$store_task['mode']);
        $keywords = explode(',', $store_task['keywords']);
        $this->assign('store_task',$store_task);
        $this->assign('keywords',$keywords);
        return $this->view->fetch();
    }

    // 更新任务
    public function edit_post(){
        if(empty(session('store_id'))){
            header('Location:/store/user/login');exit;
        }
        $store_id  = session('store_id');
        $title = input('title','');
        $task_id = input('task_id',0);
        $keywords = input('keywords','');
        if(!$task_id){return $this->result( [],  201,'任务不存在');}
        if(!$title){return $this->result( [],  201,'标题不能为空');}
        if(!$keywords){return $this->result( [],  201,'关键词不能为空');}
        $store_task = Db::name('store_task')->where('status>=0 and store_id='.$store_id.' and id='.$task_id)->find();
        if(!$store_task){
            return $this->result( [],  201,'任务不存在');
        }
        // 更新任务
        $res = Db::name('store_task')->where('status>=0 and id='.$task_id)->update(['title'=>$title,'keywords'=>$keywords]);
        if($res || $res===0){
            return $this->result( [],  0,'编辑成功');
        }else{
            return $this->result( [],  201,'编辑失败，请检查格式');
        }
    }
    // 更新任务状态
    public function update_status(){
        if(empty(session('store_id'))){
            header('Location:/store/user/login');exit;
        }
        $store_id  = session('store_id');
        $status = input('status',1);
        $task_id = input('task_id',0);
        $store_task = Db::name('store_task')->where('status>=0 and store_id='.$store_id.' and id='.$task_id)->find();
        if(!$store_task){
            return $this->result( [],  201,'任务不存在');
        }
        // 更新任务
        $res = Db::name('store_task')->where('status>=0 and status!=2 and id='.$task_id)->update(['status'=>$status]);
        Db::name('task_video')->where('status>=0 and status!=2 and task_id='.$task_id)->update(['status'=>$status]);
        if($res || $res===0){
            return $this->result( [],  0,'更新成功');
        }else{
            return $this->result( [],  201,'更新失败，请检查格式');
        }
    }
    // 视频列表
    public function videos(){
        if(empty(session('store_id'))){
            header('Location:/store/user/login');exit;
        }
        $this->assign('html_name','task');
        $store_id  = session('store_id');
        $task_id = input('task_id',0);
        $store_task = Db::name('store_task')->where('status>=0 and store_id='.$store_id.' and id='.$task_id)->find();
        if(!$store_task){
            return $this->result( [],  201,'任务不存在');
        }
        $this->assign('html_name','task_mode'.$store_task['mode']);
        $videos = Db::name('task_video')->alias('tv')
                            ->field('tv.task_id,tv.id,tv.status,case tv.status when 1 then "运行中" when 2 then "已完成" else "已暂停" end as status_info,tv.addtime,tv.video_desc,tv.video_url,tv.cursor,tv.script_count,count(vc.id) as ccount')
                            ->join('video_comment vc','vc.task_video_id = tv.id','left')
                            ->where(['tv.task_id'=>$task_id,'tv.is_show'=>1])
                            ->group('tv.id')
                            ->select();
        $this->assign('videos',$videos);
        return $this->view->fetch();
    }

    // 客户列表
    public function users(){
        if(empty(session('store_id'))){
            header('Location:/store/user/login');exit;
        }
        $this->assign('html_name','task');
        $store_id  = session('store_id');
        $task_id = input('task_id',0);
        $task_video_id = input('task_video_id',0);
        $store_task = Db::name('store_task')->where('status>=0 and store_id='.$store_id.' and id='.$task_id)->find();
        if(!$store_task){
            return $this->result( [],  201,'任务不存在');
        }
        $this->assign('html_name','task_mode'.$store_task['mode']);
        $where['tv.task_id'] = $task_id;
        if($task_video_id){
            $where['tv.id'] = $task_video_id;
        }
        $users = Db::name('task_video')->alias('tv')
                            ->field('vc.id,vc.username,vc.userid,vc.desc,vc.head,vc.comment,vc.comment_time,vc.addtime,tv.video_desc,vc.phone,vc.other,vc.uid,vc.sec_uid')
                            ->join('video_comment vc','vc.task_video_id = tv.id','left')
                            ->where($where)
                            ->where('vc.userid != ""')
                            ->select();
        $this->assign('users',$users);
        return $this->view->fetch();
    }

    //批量导出数据
    public function output(){
        if(empty(session('store_id'))){
            header('Location:/store/user/login');exit;
        }
        $store_id  = session('store_id');
        if(!$store_id){
            echo '导出错误';exit;
        }
        if($store_id < 10){
            echo '测试账号禁止导出';exit;
        }
        $task_id = input('task_id',0);
        // 查询任务是否属于商家
        $task = Db::name('store_task')->where(['id'=>$task_id,'store_id'=>$store_id])->find();
        if(!$task){
            echo '任务不存在';exit;
        }
        $store_task = Db::name('video_comment')->field($task['id'].' as task_id,"'.$task['title'].'" as title,username,userid,phone,head,`desc`,comment,keyword,comment_time,addtime')->where('status>=0 and task_id='.$task_id)->order('id desc')->select();
        // 清空（擦除）缓冲区并关闭输出缓冲
        ob_end_clean();
        vendor("phpoffice.PHPExcel");
        vendor("phpoffice.PHPExcel.Writer.Excel2007");
        //创建对象
        $excel = new \PHPExcel();
        $excel->getActiveSheet()->setTitle('意向客户');
        // 设置单元格高度
        // 所有单元格默认高度
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(25);
        // 第一行的默认高度
        $excel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
        // 垂直居中
        $excel->getActiveSheet()->getDefaultStyle()->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        // 设置水平居中
        $excel->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //Excel表格式
        $letter = array('A','B','C','D','E','F','F','G','H','I','J','K');
        //设置表头
        $tableheader = array('任务id','任务名','抖音昵称','抖音号','手机','头像','简介','评论内容','线索关键词','评论时间','采集时间');
        //设置表头表格宽度
        $tablestyle = array(
            array('width'=>'5'),
            array('width'=>'20'),
            array('width'=>'20'),
            array('width'=>'20'),
            array('width'=>'20'),
            array('width'=>'40'),
            array('width'=>'40'),
            array('width'=>'40'),
            array('width'=>'10'),
            array('width'=>'20'),
            array('width'=>'20'),
        );
        //填充表头信息
        for($i = 0;$i < count($tableheader);$i++) {
            $excel->getActiveSheet()->setCellValue("$letter[$i]1","$tableheader[$i]");
            $excel->getActiveSheet()->getColumnDimension($letter[$i])->setWidth($tablestyle[$i]['width']);
        }
        //填充表格信息
        for ($i = 2;$i <= count($store_task) + 1;$i++) {
            $j = 0;
            foreach ($store_task[$i - 2] as $key=>$value) {
                $excel->getActiveSheet()->setCellValue("$letter[$j]$i","$value");
                $j++;
            }
        }
        $filename = "./xunpang-".date('Y-m-d',time())."-".rand(1111,9999).".xls";
        //直接下载的代码
        $write = new \PHPExcel_Writer_Excel2007($excel);
        //$write->save($filename);
        header("Pragma: public");
        header("Expires: 0");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl;charset=utf-8");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header('Content-Disposition:attachment;filename='.$filename);
        header("Content-Transfer-Encoding:binary");
        $write->save('php://output');
    }
}
