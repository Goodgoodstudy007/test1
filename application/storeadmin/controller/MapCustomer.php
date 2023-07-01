<?php

namespace app\storeadmin\controller;

use app\common\controller\Backend;
use think\Db;
/**
 * 
 *
 * @icon fa fa-circle-o
 */
class MapCustomer extends Backend
{
    protected $noNeedLogin = ['*'];   
    /**
     * VideoComment模型对象
     * @var \app\admin\model\MapCustomer
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\MapCustomer;

    }

    /**
     * 查看
     */
    public function index()
    {
        $store_id = session('store_id');
        $map_task_id = input('map_task_id',0);
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
            $where_str = 'maptask.store_id='.$store_id;
            if($map_task_id){
                $where_str .= ' and maptask.id='.$map_task_id;
            }
            $list = $this->model->with(['maptask'])
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


}
