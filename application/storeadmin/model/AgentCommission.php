<?php

namespace app\admin\model;

use think\Model;


class AgentCommission extends Model
{

    

    

    // 表名
    protected $name = 'agent_commission';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [

    ];
    

    







    public function agent()
    {
        return $this->belongsTo('Agent', 'agent_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function storepay()
    {
        return $this->belongsTo('StorePay', 'store_pay_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
