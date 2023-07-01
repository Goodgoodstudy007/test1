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
class StoreTask extends Backend
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
        $this->model = new \app\admin\model\StoreTask;

    }


    /**
     * 查看
     */
    public function index()
    {
        //当前是否为关联查询
        $this->relationSearch = true;
        $mode = input('mode',0);
        $store_id = session('store_id');

        //设置过滤方法
        $this->request->filter(['strip_tags', 'trim']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            $status = input('status',-1);
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $where_str = 'store_task.status>=0 and store_task.show_status=1 and store.id='.$store_id;
            if($mode){
                $where_str .= ' and mode='.$mode;
            }
            if($status >= 0){
                $where_str .= ' and store_task.status='.$status;
            }
            $list = $this->model
                    ->with(['store'])
                    ->where($where)
                    ->where($where_str)
                    ->order($sort, $order)
                    ->paginate($limit);

            foreach ($list as $key=>$value) {
                $list[$key]['video_count'] = Db::name('task_video')->where(['task_id'=>$value['id'],'is_show'=>1])->count();
            }

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
        $mode = input('mode',1);
        $this->assign('mode',$mode);
        $store_id = session('store_id');
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                $params = $this->preExcludeFields($params);

                if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
                    $params[$this->dataLimitField] = $this->auth->id;
                }
                if(empty($params['keywords'])){
                    return $this->error('请添加筛选评论的关键词');
                }
                // 查询有没有存在
                $this_title = Db::name('store_task')->where(['title'=>$params['title'],'store_id'=>$store_id,'status'=>1])->count();
                if($this_title){
                    return $this->error('该任务已经添加过了');
                }
                if(strlen($params['url']) > 40){
                    return $this->error('请检查采集源是否有误，格式按下方给的参考链接');
                }
                // 判断余额够不够
                $price = 0;
                $store_price = Db::name('store')->where(['id'=>$store_id])->value('price');
                if( $store_price < 1){
                    return $this->error('点数不足1点，请先充值');
                }
                // 最大任务
                $config = Config::get('site');
                $run_task = Db::name('store_task')->where(['status'=>1,'store_id'=>$store_id])->count();
                $map_task = Db::name('map_task')->where(['status'=>1,'store_id'=>$store_id])->count();
                $ks_task = Db::name('ks_task')->where(['status'=>1,'store_id'=>$store_id])->count();
                $xhs_task = Db::name('xhs_task')->where(['status'=>1,'store_id'=>$store_id])->count();
                $run_task = $map_task + $run_task + $ks_task + $xhs_task;
                $task_count = Db::name('store')->where(['id'=>$store_id])->value('task_count');
                if(!$task_count){
                    $task_count = $config['max_task'];
                }
                if($task_count <= $run_task){
                    return $this->error('已达到最大运行任务');
                }

                $params['dcount'] = $config['max_video'];
                $dy_count = Db::name('store')->where(['id'=>$store_id])->value('dy_count');
                if($dy_count > 0){
                    $params['dcount'] = $dy_count;
                }

                $result = false;
                Db::startTrans();
                try {
                    $params['keywords'] = str_replace('，', ',', $params['keywords']);
                    $params['keywords'] = str_replace(';', ',', $params['keywords']);
                    $params['keywords'] = str_replace('；', ',', $params['keywords']);
                    $params['keywords'] = str_replace('、', ',', $params['keywords']);
                    $params['keywords'] = str_replace('\r\n', ',', $params['keywords']);

                    $params['no_keywords'] = str_replace('，', ',', $params['no_keywords']);
                    $params['no_keywords'] = str_replace(';', ',', $params['no_keywords']);
                    $params['no_keywords'] = str_replace('；', ',', $params['no_keywords']);
                    $params['no_keywords'] = str_replace('、', ',', $params['no_keywords']);
                    $params['no_keywords'] = str_replace('\r\n', ',', $params['no_keywords']);

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
                    $params['keywords'] = str_replace('，', ',', $params['keywords']);
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


    public function saveCookie()
    {
        $store_id = session('store_id');
        $addtime = date('Y-m-d H:i:s', time());
        $content = $this->request->post('content');
        if (empty($content)) {
            return json(['code' => 0, 'msg' => '内容不能为空']);
        }
    
        try {
            $existingRecord = Db::name('store_cookie')->where('store_id', $store_id)->find();
            if ($existingRecord) {
                // Update existing record
                Db::name('store_cookie')->where('store_id', $store_id)->update(['cookie' => $content, 'addtime' => $addtime]);
            } else {
                // Insert new record
                Db::name('store_cookie')->insert(['store_id' => $store_id, 'cookie' => $content, 'addtime' => $addtime]);
            }
            return json(['code' => 1, 'msg' => '保存成功']);
        } catch (\Exception $e) {
            return json(['code' => 0, 'msg' => '保存失败']);
        }
    }
    

}
