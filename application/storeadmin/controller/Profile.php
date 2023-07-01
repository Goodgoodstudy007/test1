<?php

namespace app\storeadmin\controller;

use app\common\controller\Backend;
use think\Db;

/**
 * 个人配置
 *
 * @icon fa fa-user
 */
class Profile extends Backend
{
    protected $noNeedLogin = '*';

    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\XhsTask;

    }

    /**
     * 查看
     */
    public function index()
    {
        //设置过滤方法
        $store_id = session('store_id');
        $this->request->filter(['strip_tags', 'trim']);
        $store = Db::name('store')->where(['id'=>$store_id])->find();
        $this->assign('store',$store);
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if(!$store_id){
                $this->error('登录失效');
            }
            
            $result = false;
            Db::startTrans();
            $update['store_name'] = $params['store_name'];
            $update['baidu_ak'] = $params['baidu_ak'];
            try {
                if($params['new_password']){
                    if(strlen($params['new_password']) < 6){
                        $this->error('密码不能小于6位');
                    }
                    $update['password'] = md5($params['new_password']);
                }
                
                $result = Db::name('store')->where(['id'=>$store_id])->update($update);
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
                $this->success('修改成功');
            } else {
                $this->error(__('No rows were inserted'));
            }
        }
        return $this->view->fetch();
    }

}
