<?php

namespace app\admin\model;

use think\Model;


class Withdrawal extends Model
{

    

    

    // 表名
    protected $name = 'withdrawal';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'status_text'
    ];
    

    
    public function getStatusList()
    {
        return ['1' => '审核中', '2' => '已打款', '3' => '审核失败'];
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function agent()
    {
        return $this->belongsTo('Agent', 'agent_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function store()
    {
        return $this->belongsTo('Store', 'store_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
