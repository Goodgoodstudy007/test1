<?php

namespace app\admin\model;

use think\Model;


class XhsComment extends Model
{

    

    

    // 表名
    protected $name = 'xhs_comment';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [

    ];
    

    

    public function xhstask()
    {
        return $this->belongsTo('XhsTask', 'task_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }

    public function xhsnote()
    {
        return $this->belongsTo('XhsNote', 'note_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }





}
