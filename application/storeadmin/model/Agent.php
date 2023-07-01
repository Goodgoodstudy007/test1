<?php

namespace app\admin\model;

use think\Model;


class Agent extends Model
{

    

    

    // 表名
    protected $name = 'agent';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [

    ];
    
    public function ap()
    {
        return $this->belongsTo('Agent', 'agent_pid', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
