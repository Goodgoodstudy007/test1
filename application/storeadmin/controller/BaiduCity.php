<?php

namespace app\storeadmin\controller;

use app\common\controller\Backend;
use think\Db;
use think\Config;
/**
 * 
 *
 * @icon fa fa-circle-o
 */
class BaiduCity extends Backend
{
    protected $noNeedLogin = ['*'];
    /**
     * StoreTask模型对象
     * @var \app\admin\model\StoreTask
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\BaiduCity;

    }


    /**
     * 查看
     */
    public function index()
    {
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
            $list = $this->model
                    ->where($where)
                    ->order($sort, $order)
                    ->paginate($limit);

            $result = array("total" => $list->total(), "rows" => $list->items());

            return json($result);
        }
        return $this->view->fetch();
    }


}
