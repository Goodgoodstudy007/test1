<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use think\Db;
use think\Config;
use think\Cache;

class Map extends Frontend
{
    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function get_customer(){
        $config = Config::get('site');
        $script_count_max = $config['max_map_count'];
        $tasks = Db::name('map_task')->alias('mt')
                    ->field('mt.*,count(mc.id) as mcount,s.price as sprice')
                    ->join('store s','s.id = mt.store_id')
                    ->join('map_customer mc','mc.map_task_id = mt.id','left')
                    ->where(['mt.status'=>1])
                    ->group('mt.id')->order('mt.xunpang_count asc')
                    ->limit(5)->select();
        if($tasks){
            $api = new \app\index\controller\Douyin();
            $proxy_ip = $api->get_proxy(1);
            $param['proxy_ip'] = $proxy_ip[0];
            $param['proxy_port'] = $proxy_ip[1];
            // $header = ["Accept:application/json, text/plain, */*",
            //             "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36",
            //             "Referer: https://map.baidu.com/",
            //             "Accept-Language: zh-CN,zh;q=0.9",
            //             ];
            foreach ($tasks as $key => $value) {
                // 判断长时间无更新
                $time_wait = time() - strtotime($value['uptime']);
                if($time_wait > 1800 ){
                    Db::name('map_task')->where(['id'=>$value['id']])->update(['status'=>2,'uptime'=>date('Y-m-d H:i:s')]);continue;
                }
                // 查询点数有没有大于0
                if($value['sprice'] < 1){
                    // 暂停采集
                    Db::name('map_task')->where(['id'=>$value['id']])->update(['status'=>0]);
                    echo '点数不足';continue;
                }
                $nn = ($value['cursor'] - 1) * 10;
                $nn = $nn > 0 ? $nn : 0;
                $url = 'https://map.baidu.com/?newmap=1&reqflag=pcmap&biz=1&from=webmap&da_par=direct&pcevaname=pc4.1&qt=con&from=webmap&c='.$value['city_id'].'&wd='.$value['keyword'].'&wd2=&pn='.$value['cursor'].'&nn='.$nn.'&db=0&sug=0&addr=0&da_src=pcmappg.poi.page&on_gel=1&src=7&gr=3&l=12&tn=B_NORMAL_MAP&ie=utf-8&t='.time()."000";
                $out_json = dcurl_proxy($url,$param);
                $out_res = @json_decode($out_json,1);
                if($out_res && isset($out_res['result']) && isset($out_res['result']['auth'])){
                    // $url = 'https://map.baidu.com/?newmap=1&reqflag=pcmap&biz=1&from=webmap&da_par=direct&pcevaname=pc4.1&qt=spot&from=webmap&c='.$value['city_id'].'&wd='.$value['keyword'].'&wd2=&pn='.$value['cursor'].'&nn='.$nn.'&db=0&sug=0&addr=0&pl_data_type=shopping&pl_sub_type=&pl_price_section=0%2C%2B&pl_sort_type=&pl_sort_rule=0&pl_discount2_section=0%2C%2B&pl_groupon_section=0%2C%2B&pl_cater_book_pc_section=0%2C%2B&pl_hotel_book_pc_section=0%2C%2B&pl_ticket_book_flag_section=0%2C%2B&pl_movie_book_section=0%2C%2B&pl_business_type=shopping&pl_business_id=&da_src=pcmappg.poi.page&on_gel=1&src=7&gr=3&l=14&rn=50&tn=B_NORMAL_MAP&u_loc=12599892,2629885&ie=utf-8&b=(12597571.55,2621589.15;12615235.55,2636069.15)&t=1632726861837&newfrom=zhuzhan_webmap&auth='.$out_res['result']['auth'];
                    // $out_json = dcurl_proxy($url,$param);
                    // $out_res = @json_decode($out_json,1);
                }
                // echo "<pre>";
                // var_dump($out_res['result']['auth']);exit;
                if($out_res && isset($out_res['content'])){
                    $content = $out_res['content'];
                    
                    if(empty($content)){
                        Db::name('map_task')->where(['id'=>$value['id']])->update(['status'=>2,'uptime'=>date('Y-m-d H:i:s')]);continue;
                    }
                    // 有数据插入
                    $this_dianshu = 0;
                    $xunpang_count = $value['xunpang_count'] + count($content);
                    // echo "<pre>";
                    // var_dump($content);exit;
                    $cursor = $value['cursor']+1;
                    Db::name('map_task')->where(['id'=>$value['id']])->update(['xunpang_count'=>$xunpang_count,'cursor'=>$cursor]);
                    foreach ($content as $c_key => $c_value) {
                        // 不让超出余额点数
                        if($value['sprice'] < $this_dianshu){
                            echo '超出点数';
                            continue;
                        }
                        // 不让超出客户数
                        if($script_count_max <= $this_dianshu+$value['mcount']){
                            Db::name('map_task')->where(['id'=>$value['id']])->update(['status'=>2,'uptime'=>date('Y-m-d H:i:s')]);
                            continue;
                        }
                        $area_id = @$c_value['admin_info']['area_id'] ? $c_value['admin_info']['area_id'] : 0;
                        $area_name = @$c_value['admin_info']['area_name'] ? $c_value['admin_info']['area_name'] : "";
                        $city_id = @$c_value['admin_info']['city_id'] ? $c_value['admin_info']['city_id'] : 0;
                        $city_name = @$c_value['admin_info']['city_name'] ? $c_value['admin_info']['city_name'] : "";
                        $address = @$c_value['addr'] ? $c_value['addr'] : "";
                        $di_tag = @$c_value['di_tag'] ? $c_value['di_tag'] : "";
                        $name = @$c_value['name'] ? $c_value['name'] : "";
                        $phone = @$c_value['tel'] ? $c_value['tel'] : "";
                        $lng = @$c_value['x'] ? $c_value['x'] : "";
                        $lat = @$c_value['y'] ? $c_value['y'] : "";
                        if(empty($phone)){
                            continue;
                        }
                        // 查询该用户在本任务没有查询过
                        $this_user_count = Db::name('map_customer')->where(['map_task_id'=>$value['id'],'phone'=>$phone])->count();
                        if($this_user_count > 0){
                            continue;
                        }

                        $insert_data = ['map_task_id'=>$value['id'],'area_id'=>$area_id,'area_name'=>$area_name,'address'=>$address,'di_tag'=>$di_tag,'name'=>$name,'city_id'=>$city_id,'city_name'=>$city_name,'lng'=>$lng,'lat'=>$lat,'phone'=>$phone,'addtime'=>date('Y-m-d H:i:s'),'status'=>1];
                        $res = Db::name('map_customer')->insert($insert_data);
                        if($res){
                            $this_dianshu = $this_dianshu + 1;
                        }
                        
                    }
                    if($this_dianshu){
                        // 扣除点数
                        Db::name('store')->where(['id'=>$value['store_id']])->setDec('price',$this_dianshu);
                        Db::name('map_task')->where(['id'=>$value['id']])->update(['uptime'=>date('Y-m-d H:i:s'),'price'=>$this_dianshu+$value['price']]);
                    }
                    echo '执行成功';
                }else{
                    echo '解析失败：'.$url;
                }
                
            }
            
        }else{
            echo '暂无任务';
        }
    }
}
