<?php

namespace app\storeadmin\controller;

use app\common\controller\Backend;
use think\Db;
/**
 * 
 *
 * @icon fa fa-circle-o
 */
class StorePay extends Backend
{
    protected $noNeedLogin = ['*'];
    /**
     * StorePay模型对象
     * @var \app\admin\model\StorePay
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\StorePay;

    }

    public function import()
    {
        parent::import();
    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    

    /**
     * 查看
     */
    public function index()
    {
     
        $store_id = session('store_id');
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
                    ->with(['store'])
                    ->where($where)
                    ->where('store_pay.status=1 and store_pay.dianshu>0 and store_pay.store_id='.$store_id)
                    ->order($sort, $order)
                    ->paginate($limit);

            foreach ($list as $row) {
                
                
            }

            $result = array("total" => $list->total(), "rows" => $list->items());

            return json($result);
        }
        return $this->view->fetch();
    }

}
