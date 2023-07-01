<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Db;
use think\Config;
/**
 * 
 *
 * @icon fa fa-circle-o
 */
class StoreAdv extends Backend
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
        $this->model = new \app\admin\model\StoreAdv;

    }


    /**
     * 查看
     */
    public function index()
    {
        //当前是否为关联查询
        $this->relationSearch = true;
        $mode = input('mode',0);
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
                    ->order($sort, $order)
                    ->paginate($limit);

            $result = array("total" => $list->total(), "rows" => $list->items());

            return json($result);
        }
        $this->assign('mode',$mode);
        return $this->view->fetch();
    }

    /**
     * 添加
     */
    public function add()
    {
        $store_id = session('store_id');
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                $params = $this->preExcludeFields($params);

                if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
                    $params[$this->dataLimitField] = $this->auth->id;
                }
                // 查询有没有存在
                $this_title = Db::name('store_adv')->where(['title'=>$params['title'],'store_id'=>$store_id])->count();
                if($this_title){
                    return $this->error('该计划已经添加过了');
                }

                $result = false;
                Db::startTrans();
                try {
                    $params['device'] = implode(',', $this->request->post('device/a'));
                    $params['sex'] = implode(',', $this->request->post('sex/a'));
                    $params['age'] = implode(',', $this->request->post('age/a'));
                    $params['income'] = implode(',', $this->request->post('income/a'));
                    $params['people'] = implode(',', $this->request->post('people/a'));
                    $params['plike'] = implode(',', $this->request->post('plike/a'));
                    $params['mobile'] = implode(',', $this->request->post('mobile/a'));
                    $params['network'] = implode(',', $this->request->post('network/a'));
                    $params['browser'] = implode(',', $this->request->post('browser/a'));

                    $params['addtime'] = date('Y-m-d H:i:s');
                    $params['store_id'] = $store_id;
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : $name) : $this->modelValidate;
                        $this->model->validateFailException(true)->validate($validate);
                    }
                    $result = $this->model->allowField(true)->save($params);
                    Db::commit();
                } catch (ValidateException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (PDOException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (Exception $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                }
                if ($result !== false) {
                    $this->success();
                } else {
                    $this->error(__('No rows were inserted'));
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        return $this->view->fetch();
    }

    /**
     * 编辑
     */
    public function edit($ids = null)
    {
        $row = $this->model->get($ids);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds)) {
            if (!in_array($row[$this->dataLimitField], $adminIds)) {
                $this->error(__('You have no permission'));
            }
        }
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                $params = $this->preExcludeFields($params);
                $result = false;
                Db::startTrans();
                try {
                    $params['device'] = implode(',', $this->request->post('device/a'));
                    $params['sex'] = implode(',', $this->request->post('sex/a'));
                    $params['age'] = implode(',', $this->request->post('age/a'));
                    $params['income'] = implode(',', $this->request->post('income/a'));
                    $params['people'] = implode(',', $this->request->post('people/a'));
                    $params['plike'] = implode(',', $this->request->post('plike/a'));
                    $params['mobile'] = implode(',', $this->request->post('mobile/a'));
                    $params['network'] = implode(',', $this->request->post('network/a'));
                    $params['browser'] = implode(',', $this->request->post('browser/a'));
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : $name) : $this->modelValidate;
                        $row->validateFailException(true)->validate($validate);
                    }
                    $result = $row->allowField(true)->save($params);
                    Db::commit();
                } catch (ValidateException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (PDOException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (Exception $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                }
                if ($result !== false) {
                    $this->success();
                } else {
                    $this->error(__('No rows were updated'));
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        $row['device'] = explode(',', $row['device']);
        $row['sex'] = explode(',', $row['sex']);
        $row['age'] = explode(',', $row['age']);
        $row['income'] = explode(',', $row['income']);
        $row['people'] = explode(',', $row['people']);
        $row['plike'] = explode(',', $row['plike']);
        $row['mobile'] = explode(',', $row['mobile']);
        $row['network'] = explode(',', $row['network']);
        $row['browser'] = explode(',', $row['browser']);
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }

    /**
     * 删除
     */
    public function del($ids = "")
    {
        if (!$this->request->isPost()) {
            $this->error(__("Invalid parameters"));
        }
        $ids = $ids ? $ids : $this->request->post("ids");
        if ($ids) {
            $pk = $this->model->getPk();
            $adminIds = $this->getDataLimitAdminIds();
            if (is_array($adminIds)) {
                $this->model->where($this->dataLimitField, 'in', $adminIds);
            }
            $list = $this->model->where($pk, 'in', $ids)->select();

            $count = 0;
            Db::startTrans();
            try {
                foreach ($list as $k => $v) {
                    $count += $v->delete();
                }
                Db::commit();
            } catch (PDOException $e) {
                Db::rollback();
                $this->error($e->getMessage());
            } catch (Exception $e) {
                Db::rollback();
                $this->error($e->getMessage());
            }
            if ($count) {
                $this->success();
            } else {
                $this->error(__('No rows were deleted'));
            }
        }
        $this->error(__('Parameter %s can not be empty', 'ids'));
    }

}
