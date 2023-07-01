<?php

namespace app\storeadmin\controller;

use app\common\controller\Backend;
use think\Db;
/**
 * 
 *
 * @icon fa fa-circle-o
 */
class KsComment extends Backend
{
    protected $noNeedLogin = ['*'];   
    /**
     * VideoComment模型对象
     * @var \app\admin\model\KsComment
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\KsComment;

    }

    /**
     * 查看
     */
    public function index()
    {
        $store_id = session('store_id');
        $task_id = input('task_id',0);
        $note_id = input('video_id',0);
        //当前是否为关联查询
        $this->relationSearch = true;
        //设置过滤方法
        $this->request->filter(['strip_tags', 'trim']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $where_str = 'kstask.store_id='.$store_id;
            if($task_id){
                $where_str .= ' and kstask.id='.$task_id;
            }
            if($note_id){
                $where_str .= ' and ksvideo.id='.$note_id;
            }

            $list = $this->model->with(['kstask','ksvideo'])
                    ->where($where)
                    ->where($where_str)
                    ->order($sort, $order)
                    ->paginate($limit);
            foreach ($list as $key=>$row) {
                
            }

            $result = array("total" => $list->total(), "rows" => $list->items());

            return json($result);
        }
        return $this->view->fetch();
    }

    public function import()
    {
        parent::import();
    }

    public function get_qrcode()
    {
        $id = input('id',0);
        if(!$id){
            $this->error('记录不存在');
        }
        $info = Db::name('ks_comment')->where(['id'=>$id])->find();
        if(!$info){
            $this->error('客户记录不存在');
        }
        Db::name('ks_comment')->where(['id'=>$id])->update(['status'=>2]);
        
        $this->success('成功','https://www.kuaishou.com/profile/'.$info['userid']);
    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    

}
