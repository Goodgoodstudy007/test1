<?php

namespace app\storeadmin\model;

use think\Model;


class VideoComment extends Model
{

    

    

    // 表名
    protected $name = 'video_comment';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [

    ];
    

    public function storetask()
    {
        return $this->belongsTo('StoreTask', 'task_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }

    public function taskvideo()
    {
        return $this->belongsTo('TaskVideo', 'task_video_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }






}
