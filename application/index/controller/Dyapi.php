<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use think\Db;

class Dyapi extends Frontend
{
	protected $noNeedLogin = '*';
	protected $noNeedRight = '*';
    protected $layout = '';
    public $client_key = 'awx7tzvjqvmv9j8a';
    public $client_secret = '5323f90d8941f4db4bd8d2dae8c0b39a';

    // 采集视频
    public function search_video()
    {
        $access_token = 'clt.10d5328bd2303b0e018e78799f23983fi5FEFUfq2Lx60qX7UHH4LVaa59gm';
        $sec_item_id = '@8hxdhauTCMppanGnM4ltGM780mDqPP+KPpR0qQOmLVAXb/T060zdRmYqig357zEBq6CZRp4NVe6qLIJW/V/x1w==';
        $url = 'https://open.douyin.com/video/search/?access_token='.$access_token.'&cursor=0&count=10&hot_sentence=头发';
        $out_json = dcurl($url);
        echo $out_json;
    }

    public function get_comment()
    {
        $access_token = 'clt.10d5328bd2303b0e018e78799f23983fi5FEFUfq2Lx60qX7UHH4LVaa59gm';
        $sec_item_id = '@8hxdhauTCMppanGnM4ltGM780mDqPP+KPpR0qQOmLVAXb/T060zdRmYqig357zEBq6CZRp4NVe6qLIJW/V/x1w==';
        $url = 'https://open.douyin.com/hotsearch/videos/?access_token='.$access_token.'&cursor=0&count=10&hot_sentence=头发';
        echo $url;exit;
        $out_json = dcurl($url);
        echo $out_json;
    }

    public function get_code(){
    	$url = 'https://open.douyin.com/platform/oauth/connect/?client_key='.$this->client_key.'&response_type=code&scope';
    	// dcurl
    }

    public function get_client_token(){
    	$url = 'https://open.douyin.com/oauth/client_token/?client_key='.$this->client_key.'&client_secret='.$this->client_secret.'&grant_type=client_credential';
    	$out_json = dcurl($url);
    	$res = json_decode($out_json,1);
    	$access_token = '';
    	if($res && @$res['data']){
    		$access_token = $res['data']['access_token'];
    	}
    	return  $access_token;
    }

}
