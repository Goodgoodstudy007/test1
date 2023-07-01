<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use think\Db;
use think\Config;
use think\Cache;

class Xhs extends Frontend
{
    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    // 输入抖音号，采集视频
    public function index()
    {
        $douyin_url = input('douyin_url','https://v.douyin.com/espdeqQ/');
        $limit = input('limit',10);
        // 获取302后的真实地址，获取sec_uid
        $douyin_header = get_headers($douyin_url);
        // echo '<pre>';
        // var_dump($douyin_header);exit;
        preg_match("/sec_uid=(.*?)&/si", $douyin_header[6], $uid_match);
        $sec_uid = $uid_match[1];
        // 获取用户的视频
        $out_json = exec(PYTHON.' '.WWWROOT_PATH.'/node/run.py user_video '.$sec_uid);
        $res = findThePhoneNumbers('你好这里有手机13267716360。你可以提取出来吗，还有1326777777.哈哈哈');
        echo '<pre>';
        var_dump($res);exit;
    }

    // 获取代理
    public function get_proxy($is_sys=0){
        $config = Config::get('site');
        $proxys_url = $config['agent_ip'];
        if(strpos($proxys_url, 'http') === false){
            // 快代理
            $this_proxys = explode(":", $proxys_url);
            if($is_sys==1){
                return  $this_proxys;
            }else{
                return  json($this_proxys);
            }
        }
        
        // 芝麻代理
        if(Cache::get('proxys_cache_ip')){
            $this_proxys = Cache::get('proxys_cache_ip');
        }else{
            if(Cache::get('proxys_cache_new')){
                $ip_res = Cache::get('proxys_cache_new');
            }else{
                $ip_res = dcurl($proxys_url);
                if(strpos($ip_res, 'code') !== false){
                    Cache::set('proxys_cache_new','');
                    sleep(5);
                    return $this->get_proxy($is_sys);
                }
                if($ip_res){
                    // ip五分钟失效，提前结束
                    Cache::set('proxys_cache_new',$ip_res,280);
                }
            }
            $proxys = explode("\r\n", $ip_res);
            $proxys = array_filter($proxys);
            $key = rand(1,count($proxys))-1;
            $this_proxys = explode(":", @$proxys[$key]);
            // 单独ip的可用
            if(count($this_proxys) > 1){
                Cache::set('proxys_cache_ip',$this_proxys,270);
            }
        }
        if($is_sys==1){
            return  $this_proxys;
        }else{
            return  json($this_proxys);
        }
        
    }

    public function check_proxy($url,$param=[],$store_id=0){
        $proxy_ip = $this->get_proxy(1);
        $param['proxy_ip'] = $proxy_ip[0];
        $param['proxy_port'] = $proxy_ip[1];
        $header = ["User-Agent:  Mozilla/5.0 (Linux; Android 6.0.1; OPPO R9s Build/MMB29M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/86.0.4240.99 XWEB/3100 MMWEBSDK/20210302 Mobile Safari/537.36 MMWEBID/187 MicroMessenger/8.0.3.1880(0x2800033E) Process/appbrand0 WeChat/arm32 Weixin NetType/WIFI Language/zh_CN ABI/arm64 MiniProgramEnv/android",
                        "Referer: https://www.xiaohongshu.com/",
                        "Origin: https://www.xiaohongshu.com/",
                        "Host: www.xiaohongshu.com"];
        array_push($header, 'X-sign:'.'X'.md5($url.'WSUDD'));
        // $authorization = $this->get_authorization();
        $store_cookie = Db::name('store_cookie')->where(['store_id'=>$store_id,'status'=>1,'type'=>2])->orderRaw('rand()')->find();
        if(!$store_cookie){
            echo 'authorization为空'.PHP_EOL;
            return '';
        }
        $authorization = $store_cookie['cookie'];
        if($store_cookie['device']){
            array_push($header, 'device-fingerprint:'.$store_cookie['device']);
        }
        array_push($header, 'authorization:'.$authorization);

        $out_json = dcurl_proxy('https://www.xiaohongshu.com'.$url, $param , $header);
        // var_dump($out_json);exit;
        $out_res = json_decode($out_json,1);
        if($out_res['code']=="-100" || $out_res['code']=="-103"){
            Db::name('store_cookie')->where(['cookie'=>$authorization])->update(['uptime'=>date('Y-m-d H:i:s'),'status'=>0]);
            echo  '登陆失效'.PHP_EOL;
            return '';
        }
        return $out_json;
    }

    public function  cookie_to_array($cookie=''){
        $result = [];
        if(preg_match_all('/\s*([^;=]+)=([^;]+)/i',$cookie,$matches) > 0){
            if(isset($matches[1]) && isset($matches[2])){
                if(count($matches[1]) == count($matches[2])){
                    foreach ($matches[1] as $handle => $key) {
                        $result[$key] = $matches[2][$handle];
                    }
                }
            }
        }
        return $result;
    }

    // 自动关注
    public function follow_user(){
        $follow_list  = Db::name('store_task')->alias('st')->field('vc.id,sc.id as cookie_id,vc.uid,st.store_id,vc.username,sc.cookie')
                            ->join('video_comment vc','vc.task_id = st.id and vc.is_follow=0')
                            ->join('store_cookie sc','sc.store_id = st.store_id and sc.status=1 and sc.type=1 and sc.max_follow > sc.today_follow')
                            ->where(['st.auto_follow'=>1])
                            ->group('vc.id')
                            ->limit(1)->select();
        // var_dump($follow_list);exit();
        if($follow_list){
            foreach ($follow_list as $key => $value) {
                $header = ["Accept:application/json, text/plain, */*",
                        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36",
                        "Referer: https://www.douyin.com/",
                        "Accept-Language: zh-CN,zh;q=0.9",
                        "Sec-fetch-dest: empty",
                        "Sec-fetch-mode: cors",
                        "Sec-fetch-site: same-origin",
                        "X-secsdk-csrf-request: 1","X-secsdk-csrf-version: 1.2.7"];
                $cookie = '';
                $output = dcurl_headers('https://www.douyin.com/aweme/v1/web/commit/follow/user/','',$header,$cookie);
                if(strpos($output, 'HTTP/1.1 200 OK')===false){
                    echo '请求失败：'.$output.'<br>'.PHP_EOL;continue;
                }
                preg_match("/X\-Ware\-Csrf\-Token:([^\r\n]*)/i", $output, $matches); 
                $token_arr = explode(',', $matches[1]) ;
                $param['type'] = 1;
                $param['is_post'] = 1;
                $param['user_id'] = $value['uid'];
                $param['user_id'] = '61702612583';
                $param['token'] = '00010000000192fbfaf8b43bacdd41efa5c8c63f43d5bbb7437c4ed1d6b5d4416d8a1a2b355616a6ff2d34b887c4';
                $out_json = $this->check_proxy('follow',$param,0,$value['store_id']);
                // var_dump($param);exit;
            }
            
        }else{
            echo '暂无关注';
        }
        
    }

    public function get_authorization(){
        
        $authorization = dcurl('http://xunpang.hu29.com/index/index/get_xhs_authorization');
        return $authorization;
    }

    // 关键词采集
    public function get_key_video(){
        set_time_limit(60);
        // 查询正在开始的任务
        $tasks = Db::name('xhs_task')->alias('xt')
                    ->field('xt.*')
                    // ->join('xhs_note xn','xn.task_id = xt.id','left')
                    ->where('xt.status=1 and  xt.dcount > xt.video_count')->group('xt.id,xt.store_id')->order('xt.page asc')->limit(2)->select();
        if($tasks){
            foreach ($tasks as $key => $value) {
                // 本次获取视频最大数
                $video_count = $value['dcount'] - $value['video_count'];
                $out_json = $this->check_proxy('/fe_api/burdock/weixin/v2/search/notes?keyword='.urlencode($value['url']).'&sortBy='.$value['sortBy'].'&page='.$value['page'].'&pageSize=10&prependNoteIds=&needGifCover=true',[],$value['store_id']);
                $out_res = @json_decode($out_json,1);
                // echo '<pre>';
                // var_dump($out_res);

                if($out_res && isset($out_res['data']) ){

                    if($video_count <= 0 || empty($out_res['data'])){
                        // Db::name('xhs_task')->where(['id'=>$value['id']])->update(['status'=>2]);
                        echo '空视频';
                        continue;
                    }
                    $out_res = $out_res['data']['notes'];

                    // 更新下一页
                    $new_page = $value['page'] + 1;
                    $new_video_count = $value['video_count'] + count($out_res);
                    
                    foreach ($out_res as $out_k => $out_v) {
                        $video_count = $video_count - 1;
                        if($video_count < 0){
                            echo '无需采集视频';
                            continue;
                        }
                        $notes_id = empty(@$out_v['id']) ? '' : @$out_v['id'];
                        $has_video = Db::name('xhs_note')->where(['task_id'=>$value['id'],'notes_id'=>$notes_id])->count();
                        if($has_video || empty($notes_id)){
                            echo '已经存在';
                            continue;
                        }
                        $create_time = empty(@$out_v['time']) ? '' : @$out_v['time'];
                        $title = empty(@$out_v['title']) ? '' : @$out_v['title'];
                        $type = empty(@$out_v['type']) ? '' : @$out_v['type'];
                        $likes = empty(@$out_v['likes']) ? '' : @$out_v['likes'];
                        $img_url = empty(@$out_v['cover']['url']) ? '' : @$out_v['cover']['url'];
                        $userid = empty(@$out_v['user']['id']) ? '' : @$out_v['user']['id'];
                        $nickname = empty(@$out_v['user']['nickname']) ? '' : @$out_v['user']['nickname'];

                        // var_dump(['task_id'=>$value['id'],'store_id'=>$value['store_id'],'addtime'=>date('Y-m-d H:i:s'),'create_time'=>$create_time,'notes_id'=>$notes_id,'title'=>$title,'type'=>$type,'likes'=>$likes,'img_url'=>$img_url,'userid'=>$userid,'nickname'=>$nickname]);exit;
                        $id = Db::name('xhs_note')->insertGetId(['task_id'=>$value['id'],'store_id'=>$value['store_id'],'addtime'=>date('Y-m-d H:i:s'),'uptime'=>date('Y-m-d H:i:s'),'create_time'=>$create_time,'notes_id'=>$notes_id,'title'=>$title,'type'=>$type,'likes'=>$likes,'img_url'=>$img_url,'userid'=>$userid,'nickname'=>$nickname]);
                        // var_dump($id);exit;
                    }
                    Db::name('xhs_task')->where(['id'=>$value['id']])->update(['page'=>$new_page,'video_count'=>$new_video_count,'uptime'=>date('Y-m-d H:i:s')]);
                }else{
                    $update_data['uptime'] = date('Y-m-d H:i:s');
                    $update_data['error_count'] = $value['error_count'] + 1;
                    if($value['error_count'] >= 50){
                        // 失败则完成
                        $run_task = Db::name('xhs_note')->where(['task_id'=>$value['id'],'status'=>1])->count();
                        if($run_task <= 0){
                            $update_data['status'] = 2;
                        }
                        
                    }
                    Db::name('xhs_task')->where(['id'=>$value['id']])->update($update_data);
                }
                
            }
            echo '执行成功';
        }else{
            echo  '暂无任务';
        }
    }

    // 采集视频评论
    public function  get_video_comment(){
        set_time_limit(60);
        $start_time = time();
        // 单个视频最大采集数
        $config = Config::get('site');
        $script_count_max = $config['max_comment'];
        // 防止过量查不到
        $count_max = $script_count_max + 100;
        // 查询正在开始的任务
        $tasks = Db::name('xhs_note')->alias('xn')
                    ->field('xn.id,xn.store_id,xn.task_id,xn.notes_id,xn.script_count,s.price,s.is_repeat,xn.endId,xt.keywords,xn.uptime,xt.no_keywords')
                    ->join('xhs_task xt','xt.id = xn.task_id')
                    ->join('store s','s.id = xt.store_id')
                    ->join(' (select min(s_sort) as s_sort,store_id,task_id from fa_xhs_note where status = 1 AND script_count < '.$count_max.' group by task_id)  d2',' d2.task_id=xn.task_id and xn.s_sort=d2.s_sort')
                    ->where('xn.status=1 and xt.status=1 and xn.script_count < '.$count_max)
                    ->group('xt.store_id')
                    ->order('xn.s_sort asc')->limit(10)->select();
        if($tasks){
            foreach ($tasks as $key => $value) {
                Db::name('xhs_note')->where(['id'=>$value['id']])->setInc('s_sort');
                // 查询点数有没有大于0
                if($value['price'] < 1){
                    // 暂停采集
                    Db::name('xhs_note')->where(['task_id'=>$value['task_id']])->update(['status'=>0]);
                    Db::name('xhs_task')->where(['id'=>$value['task_id']])->update(['status'=>0]);
                    echo '点数不足';continue;
                }
                // 获取视频评论
                $url = '/fe_api/burdock/weixin/v2/notes/'.$value['notes_id'].'/comments?pageSize=10';
                if($value['endId']){
                    $url .= '&endId='.$value['endId']; 
                }
                $out_json = $this->check_proxy($url,[],$value['store_id']);
                $out_res = @json_decode($out_json,1);
                // echo '<pre>';
                // var_dump($out_res);
                if(!$out_res || !$out_json){
                    echo '空内容';
                    continue;
                }
                $out_res = @$out_res['data']['comments'];
                $update = [];
                if(empty($out_res)){
                    echo '空评论内容';
                    continue;
                    // $update['status'] = 2;
                }
                // 记录采集评论数
                $update['script_count'] = $value['script_count'] + count($out_res);
                // 半小时内获取不到新评论
                if($value['uptime']){
                    if(strtotime($value['uptime']) < time()-10800){
                        $update['status'] = 2;
                    }
                }
                if($value['script_count'] >= $script_count_max-10){
                    // 更新视频已经采集完成
                    $update['status'] = 2;
                }
                // echo '<pre>';
                // var_dump($out_res);exit;
                Db::name('xhs_note')->where(['id'=>$value['id']])->update($update);
                if($out_res){
                    
                    $keywords = explode(',', $value['keywords']);
                    $no_keywords = explode(',', $value['no_keywords']);
                    if(count($keywords) < 1){
                        echo '无关键词';
                        continue;
                    }
                    $this_dianshu = 0;

                    foreach ($out_res as $out_k => $out_v) {
                        $comment_id = empty(@$out_v['id']) ? '' : @$out_v['id'];
                        $update_data = ['uptime'=>date('Y-m-d H:i:s')];
                        // if($out_k+1 == count($out_res)){
                            // 记录最后的值
                            $update_data['endId'] = $comment_id;
                        // }
                        Db::name('xhs_note')->where(['id'=>$value['id']])->update($update_data);
                        // 不让超出余额点数
                        if($value['price'] < $this_dianshu){
                            echo '无点数';
                            continue;
                        }
                        $content = empty(@$out_v['content']) ? '' : @$out_v['content'];
                        if(!$content){
                            echo '无回复';
                            continue;
                        }
                        $userid = empty(@$out_v['user']['id']) ? '' : @$out_v['user']['id'];
                        $this_keyword = '';
                        foreach ($keywords as $key_k => $key_v) {
                            if($key_v){
                                if(strpos($content, $key_v) !== false){
                                    $this_keyword = $key_v;
                                }
                            }
                            
                        }
                        if(empty($this_keyword) || empty($userid)){
                            echo '无匹配';
                            continue;
                        }
                        // 屏蔽关键词
                        $is_next = 1;
                        if($no_keywords){
                            foreach ($no_keywords as $key_k => $key_v) {
                                if($key_v){
                                    if(strpos($content, $key_v) !== false){
                                        $is_next = 0;
                                    }
                                }
                                
                            }
                        }
                        if($is_next == 0){
                            echo '屏蔽关键词匹配';
                            continue;
                        }
                        // 查询该用户在商户没有
                        if($value['is_repeat']==0){
                            $this_user_count = Db::name('xhs_comment')->where(['task_id'=>$value['task_id'],'userid'=>$userid])->count();
                        }else{
                            $this_user_count = Db::name('xhs_comment')->alias('xc')
                                                ->join('xhs_task st','st.id = xc.task_id')
                                                ->where(['st.store_id'=>$value['store_id'],'xc.userid'=>$userid])
                                                ->count();
                        }
                        
                        if($this_user_count > 0){
                            echo '重复数据';
                            continue;
                        }

                        
                        $nickname = empty(@$out_v['user']['nickname']) ? '' : @$out_v['user']['nickname'];
                        $phone = findThePhoneNumbers($nickname);
                        $head = empty(@$out_v['user']['image']) ? '' : @$out_v['user']['image'];
                        $comment_time = empty(@$out_v['time']) ? '' : @$out_v['time'];
                        $likes = empty(@$out_v['likes']) ? 0 : @$out_v['likes'];
                        $content = mb_substr($content,0,100,'utf-8');
                        $res = Db::name('xhs_comment')->insert(['task_id'=>$value['task_id'],'store_id'=>$value['store_id'],'note_id'=>$value['id'],'nickname'=>$nickname,'userid'=>$userid,'head'=>$head,'content'=>$content,'comment_time'=>$comment_time,'likes'=>$likes,'keyword'=>$this_keyword,'phone'=>$phone,'addtime'=>date('Y-m-d H:i:s'),'comment_id'=>$comment_id,'targetCommentId'=>'']);
                        if($res){
                            $this_dianshu = $this_dianshu + 1;
                        }
                        
                    }
                    if($this_dianshu){
                        // 扣除点数
                        Db::name('store')->where(['id'=>$value['store_id']])->setDec('price',$this_dianshu);
                        Db::name('xhs_task')->where(['id'=>$value['task_id']])->setInc('price',$this_dianshu);
                    }
                    
                }
            }
            $time = time()-$start_time;
            echo '执行成功，执行时间：'.$time.'秒';
        }else{
            echo  '暂无任务';
        }
    }


}
