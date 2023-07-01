<?php

namespace app\admin\model;

use think\Model;


class MapTask extends Model
{

    

    

    // 表名
    protected $name = 'map_task';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [

    ];
    

    



    public function city()
    {
        return $this->belongsTo('BaiduCity', 'city_id', 'code', [], 'LEFT')->setEagerlyType(0);
    }

    public function store()
    {
        return $this->belongsTo('Store', 'store_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
