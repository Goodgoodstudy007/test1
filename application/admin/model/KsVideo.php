<?php

namespace app\admin\model;

use think\Model;


class KsVideo extends Model
{

    

    

    // 表名
    protected $name = 'ks_video';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'create_time_text'
    ];
    

    public function kstask()
    {
        return $this->belongsTo('KsTask', 'task_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
    

    public function getCreateTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['create_time']) ? $data['create_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setCreateTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }


}
