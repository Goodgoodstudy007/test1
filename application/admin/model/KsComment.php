<?php

namespace app\admin\model;

use think\Model;


class KsComment extends Model
{

    

    

    // 表名
    protected $name = 'ks_comment';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [

    ];
    

    

    public function kstask()
    {
        return $this->belongsTo('KsTask', 'task_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }

    public function ksvideo()
    {
        return $this->belongsTo('KsVideo', 'video_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }





}
