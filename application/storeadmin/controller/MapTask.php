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
class MapTask extends Backend
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
        $this->model = new \app\admin\model\MapTask;

    }


    /**
     * 查看
     */
    public function index()
    {

        //当前是否为关联查询
        $this->relationSearch = true;
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
            $where_str = 'map_task.status>=0 and  store.id='.$store_id;
            if($status >= 0){
                $where_str .= ' and map_task.status='.$status;
            }
            $list = $this->model
                    ->with(['store','city'])
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

            
                if(empty($params['keyword'])){
                    return $this->error('请添加关键词');
                }
                // 查询有没有存在
                $this_title = Db::name('map_task')->where(['keyword'=>$params['keyword'],'city_id'=>$params['city_id'],'store_id'=>$store_id,'status'=>1])->count();
                if($this_title){
                    return $this->error('该任务已经添加过了');
                }
                // 判断余额够不够
                $price = 0;
                $store_price = Db::name('store')->where(['id'=>$store_id])->value('price');
                if( $store_price < 1){
                    return $this->error('点数不足1点，请先充值');
                }
                $baidu_ak = Db::name('store')->where(['id'=>$store_id])->value('baidu_ak');
                if(!$baidu_ak){
                    return $this->error('请配置个人信息中的 百度地图AK账号');
                }
                // 最大任务
                $config = Config::get('site');
                $run_task = Db::name('store_task')->where(['status'=>1,'store_id'=>$store_id])->count();
                $map_task = Db::name('map_task')->where(['status'=>1,'store_id'=>$store_id])->count();
                $ks_task = Db::name('ks_task')->where(['status'=>1,'store_id'=>$store_id])->count();
                $xhs_task = Db::name('xhs_task')->where(['status'=>1,'store_id'=>$store_id])->count();
                $run_task = $map_task + $run_task + $xhs_task + $ks_task;
                $task_count = Db::name('store')->where(['id'=>$store_id])->value('task_count');
                if(!$task_count){
                    $task_count = $config['max_task'];
                }
                if($task_count <= $run_task){
                    return $this->error('已达到最大运行任务');
                }

                $result = false;
                Db::startTrans();
                try {
                    $params['keyword'] = str_replace('，', '', $params['keyword']);
                    $params['keyword'] = str_replace(';', '', $params['keyword']);
                    $params['keyword'] = str_replace('；', '', $params['keyword']);
                    $params['keyword'] = str_replace('、', '', $params['keyword']);
                    $params['keyword'] = str_replace('\r\n', '', $params['keyword']);
                    $params['addtime'] = date('Y-m-d H:i:s');
                    $params['uptime'] = date('Y-m-d H:i:s');
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
