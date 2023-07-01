<?php

namespace app\admin\model;

use think\Model;


class MapCustomer extends Model
{

    

    

    // 表名
    protected $name = 'map_customer';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [

    ];
    

    
    public function maptask()
    {
        return $this->belongsTo('MapTask', 'map_task_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }






}
