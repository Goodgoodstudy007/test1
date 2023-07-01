<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use think\Db;

class Kuaishou extends Frontend
{
	protected $noNeedLogin = '*';
	protected $noNeedRight = '*';
    protected $layout = '';

    // 输入url，采集
    public function index()
    {
        $url = input('url','https://www.kuaishou.com/profile/3xkww9h2pnrka94');
        $limit = input('limit',10);
        $userid = str_replace('https://www.kuaishou.com/profile/', '', $url);
        $param = '{"operationName": "visionProfilePhotoList",
    	"query": "query visionProfilePhotoList($pcursor: String, $userId: String, $page: String, $webPageArea: String) {  visionProfilePhotoList(pcursor: $pcursor, userId: $userId, page: $page, webPageArea: $webPageArea) {  result  llsid  webPageArea  feeds {  type  author {  id  name  following  headerUrl  headerUrls {  cdn  url  __typename  }  __typename  }  tags {  type  name  __typename  }  photo {  id  duration  caption  likeCount  realLikeCount  coverUrl  coverUrls {  cdn  url  __typename  }  photoUrls {  cdn  url  __typename  }  photoUrl  liked  timestamp  expTag  animatedCoverUrl  stereoType  videoRatio  __typename  }  canAddComment  currentPcursor  llsid  status  __typename  }  hostName  pcursor  __typename  } } ",
		    "variables": {
		        "page": "profile",
		        "pcursor": "",
		        "userId": "3xkww9h2pnrka94"
		    }
		}';
        $header = array("Connection: Keep-Alive","Content-Type: application/json","User-Agent: Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; WOW64; Trident/6.0)",'cookie:did=web_db74d55bb8d6a5c572cd5b996d4f3915');
        $res = curl_json('https://www.kuaishou.com/graphql',$param,$header);
       	if($res){
       		$out_arr = json_decode($res,1);
       		if($out_arr && isset(@$out_arr['data']['visionProfile']['userProfile']['profile'])){
       			
       		}
       	}
        var_dump(json_encode($res));exit;
    }

    // http://xunpang.hu29.com/index/douyin/get_task_video
    // 获取即将开始的任务,填充博主信息
    public function add_task_info(){
    	// 查询即将开始任务
    	$tasks = Db::name('store_task')->field('id,url')->where(['status'=>1,'sec_user_id'=>''])->select();
    	if($tasks){
    		foreach ($tasks as $key => $value) {
    			$douyin_url = trim($value['url']);
    			$douyin_header = get_headers($douyin_url);
		        preg_match("/sec_uid=(.*?)&/si", $douyin_header[6], $uid_match);
		        $sec_uid = $uid_match[1];
		        // 获取用户信息
		        $out_json = exec('python3 /www/wwwroot/xunpang/node/run.py user_info '.$sec_uid);
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

    // 采集视频内容
    public function  get_task_video(){
    	// 查询正在开始的任务
    	$tasks = Db::name('store_task')->alias('st')
    				->field('st.id,st.douyin_url,st.sec_user_id,st.dcount')
    				->join('task_video tv','tv.task_id = st.id','left')
    				->where('st.status=1 and st.sec_user_id!="" and tv.id is null')->select();
    	if($tasks){
    		foreach ($tasks as $key => $value) {
		        // 获取用户视频
		        $out_json = exec('python3 /www/wwwroot/xunpang/node/run.py user_video '.$value['sec_user_id'].' '.$value['dcount']);
		        $out_res = @json_decode($out_json,1);
		        if($out_res){
		        	foreach ($out_res as $out_k => $out_v) {
		        		$aweme_id = empty(@$out_v['aweme_id']) ? '' : @$out_v['aweme_id'];
		        		$create_time = empty(@$out_v['create_time']) ? '' : @$out_v['create_time'];
		        		$video_desc = empty(@$out_v['desc']) ? '' : @$out_v['desc'];
		        		$video_url = empty(@$out_v['share_url']) ? '' : @$out_v['share_url'];
		        		Db::name('task_video')->insert(['task_id'=>$value['id'],'aweme_id'=>$aweme_id,'addtime'=>date('Y-m-d H:i:s'),'create_time'=>$create_time,'video_desc'=>$video_desc,'video_url'=>$video_url]);
		        	}
		        }
		        
    		}
    		echo '执行成功';
    	}else{
    		echo  '暂无任务';
    	}
    }

    // 采集视频评论
    public function  get_video_comment(){
    	// 单个视频最大采集数
    	$script_count_max = 1000;
    	// 查询正在开始的任务
    	$tasks = Db::name('task_video')->alias('tv')
    				->field('tv.id,tv.task_id,tv.aweme_id,tv.cursor,st.keywords,tv.script_count,tv.cursor')
    				->join('store_task st','st.id = tv.task_id')
    				->where('tv.status=1 and st.status=1 and tv.script_count < '.$script_count_max)->limit(1)->select();
    	if($tasks){
    		foreach ($tasks as $key => $value) {
    			// 获取视频评论
		        $out_json = exec('python3 /www/wwwroot/xunpang/node/run.py video_comment '.$value['aweme_id'].' '.$value['cursor']);
		        $out_res = @json_decode($out_json,1);
		        // echo '<pre>';
		        // var_dump($out_res);exit;
		        // 记录采集评论数
		        $update['script_count'] = $value['script_count'] + count($out_res);
		        $update['cursor'] = $value['cursor'] + 50;
		        if($value['script_count'] >= $script_count_max-50 || count($out_res) < 50){
		        	// 更新视频已经采集完成
		        	$update['status'] = 2;
		        }
		        Db::name('task_video')->where(['id'=>$value['id']])->update($update);
		        if($out_res){
		        	$keywords = explode(',', $value['keywords']);
		        	if(count($keywords) < 1){
		        		continue;
		        	}
		        	foreach ($out_res as $out_k => $out_v) {
		        		$comment = empty(@$out_v['text']) ? '' : @$out_v['text'];
		        		$douyin_userid = empty(@$out_v['user']['short_id']) ? '' : @$out_v['user']['short_id'];
			        	// 优先取这个unique_id
			        	$douyin_userid = empty(@$out_v['user']['unique_id']) ? $douyin_userid : @$out_v['user']['unique_id'];
		        		// 判断有没有在关键词中
		        		$this_keyword = '';
		        		foreach ($keywords as $key_k => $key_v) {
		        			if(strpos($comment, $key_v) !== false){
		        				$this_keyword = $key_v;
		        			}
		        		}
		        		if(empty($this_keyword) || empty($douyin_userid)){
		        			continue;
		        		}
		        		// 查询该用户在本任务没有查询过
		        		$this_user_count = Db::name('video_comment')->where(['task_id'=>$value['task_id'],'douyin_userid'=>$douyin_userid])->count();
		        		if($this_user_count > 0){
		        			continue;
		        		}

		        		$cid = empty(@$out_v['cid']) ? '' : @$out_v['cid'];
			        	$username = empty(@$out_v['user']['nickname']) ? '' : @$out_v['user']['nickname'];
			        	$desc = empty(@$out_v['user']['signature']) ? '' : @$out_v['user']['signature'];
			        	$head = empty(@$out_v['user']['avatar_thumb']['url_list'][0]) ? '' : @$out_v['user']['avatar_thumb']['url_list'][0];
			        	$comment_time = empty(@$out_v['create_time']) ? '' : date('Y-m-d H:i:s',@$out_v['create_time']);
			        	$reply_comment_total = empty(@$out_v['reply_comment_total']) ? 0 : @$out_v['reply_comment_total'];
			        	$digg_count = empty(@$out_v['digg_count']) ? '' : @$out_v['digg_count'];
			        	$aweme_count = empty(@$out_v['user']['aweme_count']) ? 0 : @$out_v['user']['aweme_count'];
			        	$following_count = empty(@$out_v['user']['following_count']) ? 0 : @$out_v['user']['following_count'];
			        	$follower_count = empty(@$out_v['user']['follower_count']) ? 0 : @$out_v['user']['follower_count'];
			        	$total_favorited = empty(@$out_v['user']['total_favorited']) ? 0 : @$out_v['user']['total_favorited'];
			        	Db::name('video_comment')->insert(['task_id'=>$value['task_id'],'task_video_id'=>$value['id'],'username'=>$username,'userid'=>$userid,'desc'=>$desc,'head'=>$head,'comment'=>$comment,'comment_time'=>$comment_time,'reply_comment_total'=>$reply_comment_total,'digg_count'=>$digg_count,'aweme_count'=>$aweme_count,'following_count'=>$following_count,'follower_count'=>$follower_count,'total_favorited'=>$total_favorited,'keyword'=>$this_keyword,'addtime'=>date('Y-m-d H:i:s'),'cid'=>$cid]);
		        	}
		        }
    		}
    		echo '执行成功';
    	}else{
    		echo  '暂无任务';
    	}
    }

}
