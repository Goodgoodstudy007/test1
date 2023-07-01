<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use think\Db;
use think\Config;
use think\Cache;

class Douyin extends Frontend
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

    // http://xunpang.hu29.com/index/douyin/get_task_video
    // 获取即将开始的任务,填充博主信息
    public function add_task_info(){
        set_time_limit(60);
        // 查询即将开始任务
        $tasks = Db::name('store_task')->field('id,url')->where(['status'=>1,'sec_user_id'=>''])->select();
        if($tasks){
            foreach ($tasks as $key => $value) {
                $douyin_url = trim($value['url']);
                $douyin_header = get_headers($douyin_url);
                preg_match("/sec_uid=(.*?)&/si", $douyin_header[6], $uid_match);
                $sec_uid = $uid_match[1];
                // 获取用户信息
                $out_json = exec(PYTHON.' '.WWWROOT_PATH.'/node/run.py user_info '.$sec_uid);
                if($out_json){
                    // 填充博主信息
                    $out_res = json_decode($out_json,1);
                    $head = empty(@$out_res['avatar_thumb']['url_list'][0]) ? '' : @$out_res['avatar_thumb']['url_list'][0];
                    $fans = empty(@$out_res['follower_count']) ? 0 : @$out_res['follower_count'];
                    $follow = empty(@$out_res['following_count']) ? 0 : @$out_res['following_count'];
                    $zan = empty(@$out_res['total_favorited']) ? 0 : @$out_res['total_favorited'];
                    $userid = empty(@$out_res['uid']) ? '' : @$out_res['uid'];
                    $username = empty(@$out_res['nickname']) ? '' : @$out_res['nickname'];
                    $desc = empty(@$out_res['signature']) ? '' : @$out_res['signature'];
                    $video_count = empty(@$out_res['aweme_count']) ? 0 : @$out_res['aweme_count'];
                    $sec_user_id = empty(@$out_res['sec_uid']) ? '' : @$out_res['sec_uid'];
                    Db::name('store_task')->where(['id'=>$value['id']])->update(['head'=>$head,'fans'=>$fans,'follow'=>$follow,'zan'=>$zan,'userid'=>$userid,'username'=>$username,'desc'=>$desc,'video_count'=>$video_count,'sec_user_id'=>$sec_user_id]);
                }
                
            }
            echo '执行成功';
        }else{
            echo  '暂无任务';
        }
    }

    public function check_proxy($fun,$param,$is_url=0,$store_id=0,$error_count=0){
        $proxy_ip = $this->get_proxy(1);
        $param['proxy_ip'] = $proxy_ip[0];
        $param['proxy_port'] = $proxy_ip[1];
        $param['proxy_ip'] = '47.122.47.69';
        $param['proxy_port']='6003';
        if($is_url==1){
            $url = $fun;
            $out_json = dcurl_proxy($url,$param);
            return $out_json;
        }else{
            $url = 'http://127.0.0.1:8003/'.$fun;
        }
        $header = ["Accept:application/json, text/plain, */*",
                        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36",
                        "Referer: https://www.douyin.com/",
                        "Accept-Language: zh-CN,zh;q=0.9",
                        ];
        if(@$param['token']){
            array_push($header, "X-secsdk-csrf-token:".$param['token']);
        }
       


        // var_dump($url);
        // var_dump($param);

        // var_dump($header);
        // die;
        // echo "<br>";
        // echo "<br>";
        $out_json = dcurl($url,'POST',$param,$header);
        var_dump($out_json);
        die;
        // var_dump($out_json);
        // die;
        // if($fun == 'aweme_post'){
            // echo $out_json;exit;
        //     echo '<br><br>';
        // }
        
        if($out_json && strpos($out_json, 'Error')===false){
            // $getp = shell_exec(PYTHON.' '.WWWROOT_PATH.'/node/test.py');
            // var_dump($getp);          
            // $get_cookie = shell_exec('/www/wwwroot/douyin_xunpang/node/rcd.sh 2>&1');
            // var_dump($get_cookie);
            // Cache::set('cache_cookie_web_status',1,86400);
            // var_dump(Cache::get('cache_cookie_web_status'));
            // Cache::rm('cache_cookie_web');
            // Cache::rm('cache_cookie_web_status');
            // var_dump(Cache::get('cache_cookie_web'));
            // if(Cache::get('cache_cookie_web')){
            //     $get_cookie = Cache::get('cache_cookie_web');
            // }else{
            //     if(Cache::get('cache_cookie_web_status')==1){
            //         $get_cookie = get_cookie('https://www.douyin.com','','https://www.douyin.com');
            //     }else{
            //         Cache::set('cache_cookie_web_status',1,300);
            //         // $get_cookie = shell_exec(PYTHON.' '.WWWROOT_PATH.'/node/douyin_cookie.py');
            //         $output = [];
            //         $get_cookie = shell_exec('sudo /usr/local/bin/python3 /www/wwwroot/douyin_xunpang/node/douyin_cookie.py');
            //         Cache::set('cache_cookie_web',$get_cookie,86400);
            //     }
            // }

            if(Cache::get('cache_cookie_web')){
                $get_cookie = Cache::get('cache_cookie_web');
            }else{
                $cookie_arr  = Db::name('store_cookie')->where(['store_id'=>$store_id,'status'=>1])->order('id desc')->find();
                $get_cookie = $cookie_arr['cookie'];
                Cache::set('cache_cookie_web',$get_cookie,900);                
            }
           
        //    var_dump($get_cookie);
        //    die;
           // $get_cookie = '';
            // $get_cookie = 'MONITOR_DEVICE_ID=16d80e68-28cd-45f1-b1d5-03618afbeb55; MONITOR_WEB_ID=6795e67a-6ef9-471f-96ce-b46ef81eb70d; s_v_web_id=verify_7046bc1d0e3f526e8208eea23810ddc3;';
            // 查询是否有登录抖音
            $store_cookie = [];
            if($store_id){
                $store_cookie = Db::name('store_cookie')->where(['store_id'=>$store_id,'status'=>1])->order('today_follow asc')->find();
                if($store_cookie){
                    $login_param = $param;
                    $login_param['is_post'] = 0;
                    $head_code = dcurl_proxy('https://creator.douyin.com/creator-micro/home', $login_param , $header ,$store_cookie['cookie'], 0,1);
                    if($head_code==301 ||  $head_code==302){
                        // 已经失效。
                        Db::name('store_cookie')->where(['id'=>$store_cookie['id']])->update(['uptime'=>date('Y-m-d H:i:s'),'status'=>0]);
                    }else{
                        $get_cookie = $store_cookie['cookie'];                      
                    }
                }
            }
            // var_dump($get_cookie.'---123');exit;
            // $out_json = exec(PYTHON.' '.WWWROOT_PATH.'/node/run.py proxy_php "'.$out_json.'" '.$param['proxy_ip'].' '.$param['proxy_port']);
            // var_dump(PYTHON.' '.WWWROOT_PATH.'/node/run.py proxy_php "'.$out_json.'" '.$param['proxy_ip'].' '.$param['proxy_port']);exit;
            $out_json = dcurl_proxy($out_json,$param,$header,$get_cookie);
            // var_dump($out_json);
            // die;
            // if($store_id == 1){
                // var_dump($out_json) ;exit;
            // }
            if(empty($out_json)){
                Cache::set('cache_cookie_web','');
                // 已经失效。记录错误次数
                if(@$store_cookie['id']){
                    $cookie_error = Cache::get('cache_cookie_id_'.$store_cookie['id']);
                    $cookie_error = $cookie_error>0 ? $cookie_error : 0;
                    Cache::set('cache_cookie_id_'.$store_cookie['id'],$cookie_error+1,3600);
                    if($cookie_error >= 50){
                        Db::name('store_cookie')->where(['id'=>$store_cookie['id']])->update(['uptime'=>date('Y-m-d H:i:s'),'status'=>0]);
                    }
                }
                
            }
            return $out_json;
        }else{
            if($error_count >= 3){
                return '';
            }
            Cache::set('proxys_cache_ip','');
            $error_count++;
            return $this->check_proxy($fun,$param,$is_url,$store_id,$error_count);
        }
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
                            ->join('store_cookie sc','sc.store_id = st.store_id and sc.status=1 and sc.max_follow > sc.today_follow')
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

    // 采集主页视频内容
    public function  get_task_video(){
        set_time_limit(60);
        // 查询正在开始的任务
        $tasks = Db::name('store_task')->alias('st')
                    ->field('st.id,st.url,st.sec_user_id,st.dcount,st.error_count,st.max_cursor,st.video_count,count(tv.id) as tvcount')
                    ->join('task_video tv','tv.task_id = st.id','left')
                    ->where('st.status=1 and st.sec_user_id!="" and st.mode=1')->group('st.id')->select();     
        if($tasks){
            foreach ($tasks as $key => $value) {
                if($value['tvcount'] >= $value['dcount']){
                    // Db::name('store_task')->where(['id'=>$value['id']])->update(['status'=>2]);
                    continue;
                }
                $video_count = $value['dcount'] - $value['tvcount'];
                $video_count = $video_count > 20 ? 20 : $video_count;

                $max_cursor = empty($value['max_cursor']) ? 0 : $value['max_cursor'];
                $param = ['kw'=>$value['sec_user_id'],'count'=>$video_count,'max_cursor'=>$max_cursor];
                // var_dump($out_json);exit;
                $proxy_ip = $this->get_proxy(1);
                // 获取用户视频
                // echo PYTHON.' '.WWWROOT_PATH.'/node/run_post.py '.$value['sec_user_id'].' 20 '.$max_cursor.' '.$proxy_ip[0].' '.$proxy_ip[1];exit;
                $out_json = exec(PYTHON.' '.WWWROOT_PATH.'/node/run_post.py '.$value['sec_user_id'].' '.$video_count.' '.$max_cursor.' '.$proxy_ip[0].' '.$proxy_ip[1]);
                
                // $out_json = $this->check_proxy('aweme_post',$param);
                $out_res = @json_decode($out_json,1);
                // var_dump($out_res);exit();
                if($out_res){
                    $aweme_list = $out_res['aweme_list'];
                    // echo '<pre>';
                    // var_dump($aweme_list);exit;
                    // 更新下一页
                    Db::name('store_task')->where(['id'=>$value['id']])->update(['max_cursor'=>$out_res['max_cursor']]);
                    foreach ($aweme_list as $out_k => $out_v) {
                        $aweme_id = empty(@$out_v['aweme_id']) ? '' : @$out_v['aweme_id'];
                        $has_video = Db::name('task_video')->where(['task_id'=>$value['id'],'aweme_id'=>$aweme_id])->count();
                        if($has_video){
                            continue;
                        }
                        $create_time = empty(@$out_v['create_time']) ? '' : @$out_v['create_time'];
                        $video_desc = empty(@$out_v['desc']) ? '' : @$out_v['desc'];
                        $video_url = 'https://www.douyin.com/video/'.$aweme_id;
                        Db::name('task_video')->insert(['task_id'=>$value['id'],'aweme_id'=>$aweme_id,'addtime'=>date('Y-m-d H:i:s'),'create_time'=>$create_time,'video_desc'=>$video_desc,'video_url'=>$video_url]);
                    }
                }else{
                    $update_data['error_count'] = $value['error_count'] + 1;
                    if($value['error_count'] >= 100){
                        // 失败则完成
                        $update_data['status'] = 2;
                    }
                    Db::name('store_task')->where(['id'=>$value['id']])->update($update_data);
                }
                
                
            }
            echo '执行成功';
        }else{
            echo  '暂无任务';
        }
    }

    // 采集单视频视频内容
    public function  get_one_video(){
        set_time_limit(60);
        // 查询正在开始的任务
        $tasks = Db::name('store_task')->alias('st')
                    ->field('st.id,st.url,st.sec_user_id,st.dcount,st.error_count')
                    ->join('task_video tv','tv.task_id = st.id','left')
                    ->where('st.status=1 and tv.id is null and st.mode=2')->select();
        if($tasks){
            foreach ($tasks as $key => $value) {
                // 获取用户视频
                $douyin_url = trim($value['url']);
                $douyin_header = @get_headers($douyin_url);
                preg_match("/video\/(.*?)\//si", $douyin_header[6], $aweme_match);
                $aweme_id = @$aweme_match[1];
                if(!$aweme_id){
                    continue;
                }
                // $proxy_ip = $this->get_proxy(1);
                // $out_json = exec(PYTHON.' '.WWWROOT_PATH.'/node/run.py video_info '.$aweme_id.' '.$proxy_ip[0].' '.$proxy_ip[1]);
                $out_json = $this->check_proxy('https://www.iesdouyin.com/web/api/v2/aweme/iteminfo/?item_ids='.$aweme_id,[],1);
                $out_res = @json_decode($out_json,1);
                if($out_res){
                    $out_res = $out_res['item_list'][0];
                    $create_time = empty(@$out_res['create_time']) ? '' : @$out_res['create_time'];
                    $video_desc = empty(@$out_res['desc']) ? '' : @$out_res['desc'];
                    $video_url = empty(@$out_res['share_url']) ? '' : @$out_res['share_url'];
                    $has_video = Db::name('task_video')->where(['task_id'=>$value['id'],'aweme_id'=>$aweme_id])->count();
                    if($has_video){
                        continue;
                    }
                    Db::name('task_video')->insert(['task_id'=>$value['id'],'aweme_id'=>$aweme_id,'addtime'=>date('Y-m-d H:i:s'),'create_time'=>$create_time,'video_desc'=>$video_desc,'video_url'=>$video_url]);
                    // 更新博主信息
                    $res = Db::name('store_task')->where(['id'=>$value['id']])->update(['userid'=>$out_res['author']['uid'],'desc'=>$out_res['author']['signature'],'head'=>$out_res['author']['avatar_thumb']['url_list'][0],'username'=>$out_res['author']['nickname']]);
                }else{
                    $update_data['error_count'] = $value['error_count'] + 1;
                    if($value['error_count'] >= 100){
                        // 失败则完成
                        $update_data['status'] = 2;
                    }
                    Db::name('store_task')->where(['id'=>$value['id']])->update($update_data);
                }
                
            }
            echo '执行成功';
        }else{
            echo  '暂无任务';
        }
    }

    // 关键词采集
    public function get_key_video(){
        set_time_limit(60);
        // 查询正在开始的任务
        $tasks = Db::name('store_task')->alias('st')
                    ->field('st.id,st.url,st.sec_user_id,st.dcount,st.video_count,st.publish_time,st.sort_type,st.error_count,st.max_cursor,st.store_id')
                    ->join('task_video tv','tv.task_id = st.id','left')
                    ->where('st.status=1 and st.mode=3 and st.dcount > st.video_count')->group('st.id')->limit(10)->select();  
        // var_dump($tasks);
        // die;                 
        if($tasks){
            foreach ($tasks as $key => $value) {
                // 本次获取视频最大数
                $video_count = $value['dcount'] - $value['video_count'];
                $dcount = $video_count > 20 ? 20 : $video_count;
                // $out_json = exec(PYTHON.' '.WWWROOT_PATH.'/node/run.py search_item '.$value['url'].' '.$dcount.' '.$value['sort_type'].' '.$value['publish_time'].' '.$proxy_ip[0].' '.$proxy_ip[1]);
                $param = ['kw'=>$value['url'],'count'=>$dcount,'offset'=>$value['max_cursor'],'sort_type'=>$value['sort_type'],'publish_time'=>$value['publish_time']];

                $out_json = $this->check_proxy('search_item',$param,0,$value['store_id']);

                $out_res = @json_decode($out_json,1);
                // var_dump($out_res['data']);
                // die;

                if($out_res && $out_res['data']){
                    $out_res = $out_res['data'];
                    // 更新下一页
                    $new_max_cursor = $value['max_cursor'] + 20;
                    $new_video_count = $value['video_count'];
                    
                    foreach ($out_res as $out_k => $out_v) {
                        $new_video_count++;
                        $aweme_id = empty(@$out_v['aweme_info']['aweme_id']) ? '' : @$out_v['aweme_info']['aweme_id'];
                        $has_video = Db::name('task_video')->where(['task_id'=>$value['id'],'aweme_id'=>$aweme_id])->count();
                        if($has_video){
                            continue;
                        }
                        $create_time = empty(@$out_v['aweme_info']['create_time']) ? '' : @$out_v['aweme_info']['create_time'];
                        $video_desc = empty(@$out_v['aweme_info']['desc']) ? '' : @$out_v['aweme_info']['desc'];
                        $video_url = empty(@$out_v['aweme_info']['video']['play_addr_lowbr']['url_list'][0]) ? '' : @$out_v['aweme_info']['video']['play_addr_lowbr']['url_list'][0];
                        Db::name('task_video')->insert(['task_id'=>$value['id'],'aweme_id'=>$aweme_id,'addtime'=>date('Y-m-d H:i:s'),'create_time'=>$create_time,'video_desc'=>$video_desc,'video_url'=>$video_url]);
                    }
                    Db::name('store_task')->where(['id'=>$value['id']])->update(['max_cursor'=>$new_max_cursor,'video_count'=>$new_video_count]);
                }else{
                    $update_data['error_count'] = $value['error_count'] + 1;
                    if($value['error_count'] >= 50){
                        // 失败则完成
                        $update_data['status'] = 2;
                    }
                    Db::name('store_task')->where(['id'=>$value['id']])->update($update_data);
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
        $tasks = Db::name('task_video')->alias('tv')
                    ->field('tv.id,tv.task_id,tv.aweme_id,tv.cursor,st.keywords,tv.script_count,tv.cursor,s.price,st.store_id,tv.uptime')
                    ->join('store_task st','st.id = tv.task_id')
                    ->join('store s','s.id = st.store_id')
                    ->where('tv.status=1 and st.status=1 and tv.script_count < '.$count_max)->order('tv.script_count asc')->limit(10)->select();
        // var_dump($tasks);
        // die;            
        if($tasks){
            foreach ($tasks as $key => $value) {
                // 查询点数有没有大于0
                if($value['price'] < 1){
                    // 暂停采集
                    Db::name('task_video')->where(['task_id'=>$value['task_id']])->update(['status'=>0]);
                    Db::name('store_task')->where(['id'=>$value['task_id']])->update(['status'=>0]);
                    echo '点数不足';continue;
                }
                // 获取视频评论
                $proxy_ip = $this->get_proxy(1);
                $out_json = exec(PYTHON.' '.WWWROOT_PATH.'/node/run.py video_comment '.$value['aweme_id'].' '.$value['cursor'].' '.$proxy_ip[0].' '.$proxy_ip[1]);
                $param = ['kw'=> $value['aweme_id'],'offset'=>$value['cursor'],'count'=>50];
                $out_json = $this->check_proxy('comment',$param);
                // echo '<pre>';
                // var_dump($out_json);exit;
                $out_res = @json_decode($out_json,1);
                if(!$out_res){
                    continue;
                }
                $out_res = $out_res['comments'];
                $update = [];
                if(empty($out_res)){
                    $update['status'] = 2;
                }
                // 记录采集评论数
                $update['script_count'] = $value['script_count'] + count($out_res);
                $update['cursor'] = $value['cursor'] + 50;
                // 半小时内获取不到新评论
                if($value['uptime']){
                    if(strtotime($value['uptime']) < time()-3600){
                        $update['status'] = 2;
                    }
                }
                if($value['script_count'] >= $script_count_max-50){
                    // 更新视频已经采集完成
                    $update['status'] = 2;
                }
                // echo '<pre>';
                // var_dump($out_res);exit;
                Db::name('task_video')->where(['id'=>$value['id']])->update($update);
                if($out_res){
                    Db::name('task_video')->where(['id'=>$value['id']])->update(['uptime'=>date('Y-m-d H:i:s')]);
                    $keywords = explode(',', $value['keywords']);
                    if(count($keywords) < 1){
                        continue;
                    }
                    $this_dianshu = 0;
                    foreach ($out_res as $out_k => $out_v) {
                        // 不让超出余额点数
                        if($value['price'] < $this_dianshu){
                            continue;
                        }
                        $comment = empty(@$out_v['text']) ? '' : @$out_v['text'];
                        if(!$comment){
                            continue;
                        }
                        $douyin_userid = empty(@$out_v['user']['short_id']) ? '' : @$out_v['user']['short_id'];
                        // 优先取这个unique_id
                        $douyin_userid = empty(@$out_v['user']['unique_id']) ? $douyin_userid : @$out_v['user']['unique_id'];
                        // 判断有没有在关键词中
                        $this_keyword = '';
                        foreach ($keywords as $key_k => $key_v) {
                            if($key_v){
                                if(strpos($comment, $key_v) !== false){
                                    $this_keyword = $key_v;
                                }
                            }
                            
                        }
                        if(empty($this_keyword) || empty($douyin_userid)){
                            continue;
                        }
                        // 查询该用户在本任务没有查询过
                        $this_user_count = Db::name('video_comment')->where(['task_id'=>$value['task_id'],'userid'=>$douyin_userid])->count();
                        if($this_user_count > 0){
                            continue;
                        }

                        $cid = empty(@$out_v['cid']) ? '' : @$out_v['cid'];
                        $username = empty(@$out_v['user']['nickname']) ? '' : @$out_v['user']['nickname'];
                        $desc = empty(@$out_v['user']['signature']) ? '' : @$out_v['user']['signature'];
                        $phone = findThePhoneNumbers($desc);
                        if(empty($phone)){
                            $phone = findThePhoneNumbers($username);
                        }
                        $uid = empty(@$out_v['user']['uid']) ? '' : @$out_v['user']['uid'];
                        $sec_uid = empty(@$out_v['user']['sec_uid']) ? '' : @$out_v['user']['sec_uid'];
                        $head = empty(@$out_v['user']['avatar_thumb']['url_list'][0]) ? '' : @$out_v['user']['avatar_thumb']['url_list'][0];
                        $comment_time = empty(@$out_v['create_time']) ? '' : date('Y-m-d H:i:s',@$out_v['create_time']);
                        $reply_comment_total = empty(@$out_v['reply_comment_total']) ? 0 : @$out_v['reply_comment_total'];
                        $digg_count = empty(@$out_v['digg_count']) ? '' : @$out_v['digg_count'];
                        $aweme_count = empty(@$out_v['user']['aweme_count']) ? 0 : @$out_v['user']['aweme_count'];
                        $following_count = empty(@$out_v['user']['following_count']) ? 0 : @$out_v['user']['following_count'];
                        $follower_count = empty(@$out_v['user']['follower_count']) ? 0 : @$out_v['user']['follower_count'];
                        $total_favorited = empty(@$out_v['user']['total_favorited']) ? 0 : @$out_v['user']['total_favorited'];
                        $res = Db::name('video_comment')->insert(['task_id'=>$value['task_id'],'task_video_id'=>$value['id'],'username'=>$username,'userid'=>$douyin_userid,'desc'=>$desc,'head'=>$head,'comment'=>$comment,'comment_time'=>$comment_time,'reply_comment_total'=>$reply_comment_total,'digg_count'=>$digg_count,'aweme_count'=>$aweme_count,'following_count'=>$following_count,'follower_count'=>$follower_count,'total_favorited'=>$total_favorited,'keyword'=>$this_keyword,'phone'=>$phone,'addtime'=>date('Y-m-d H:i:s'),'cid'=>$cid,'uid'=>$uid,'sec_uid'=>$sec_uid]);
                        if($res){
                            $this_dianshu = $this_dianshu + 1;
                        }
                    }
                    if($this_dianshu){
                        // 扣除点数
                        Db::name('store')->where(['id'=>$value['store_id']])->setDec('price',$this_dianshu);
                        Db::name('store_task')->where(['id'=>$value['task_id']])->setInc('price',$this_dianshu);
                    }
                    
                }
            }
            $time = time()-$start_time;
            echo '执行成功，执行时间：'.$time.'秒';
        }else{
            echo  '暂无任务';
        }
    }

    // 更新任务状态
    public function update_task_status(){
        set_time_limit(60);
        // 查询所有视频都完成的任务
        $tasks = Db::name('store_task')->field('id')->where(['status'=>1])->limit(100)->select();
        if($tasks){
            foreach ($tasks as $key => $value) {
                $videos = Db::name('task_video')->field('id,status')->where(['task_id'=>$value['id']])->select();
                $is_end = 0;
                if($videos){
                    $is_end = 1;
                    foreach ($videos as $v_key => $v_value) {
                        if($v_value['status']==1){
                            $is_end = 0;
                        }
                    }
                }
                // 已经完成的更新
                if($is_end == 1){
                    Db::name('store_task')->where(['id'=>$value['id']])->update(['status'=>2,'uptime'=>date('Y-m-d H:i:s')]);
                }
            }
            
        }

        // 查询已经完成的任务，视频还没更新完成
        $tasks = Db::name('store_task')->alias('st')->field('st.id')
                    ->join('task_video tv','tv.task_id = st.id')
                    ->where(['st.status'=>2,'tv.status'=>1])
                    ->group('st.id')
                    ->select();
        if($tasks){
            foreach ($tasks as $key => $value) {
                Db::name('task_video')->where(['task_id'=>$value['id']])->update(['status'=>2]);
            }
        }

        echo '执行成功';
    }

}
