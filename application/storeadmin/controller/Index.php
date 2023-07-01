<?php

namespace app\storeadmin\controller;

use app\admin\model\AdminLog;
use app\common\controller\Backend;
use think\Config;
use think\Hook;
use think\Validate;
use think\Db;

/**
 * 后台首页
 * @internal
 */
class Index extends Backend
{

    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['index', 'logout'];
    protected $layout = '';

    public function _initialize()
    {
        parent::_initialize();
        //移除HTML标签
        $this->request->filter('trim,strip_tags,htmlspecialchars');
    }

    /**
     * 后台首页
     */
    public function index()
    {
        if(isMobile()){
            header("HTTP/1.1 301 Moved Permanently");
            Header("Location:/store/");exit;
        }
        if(empty(session('store_id'))){
            $this->redirect('index/login');
        }

        
        $this->assign('store_name',session('store_name'));
        $this->assign('out_date',session('out_date'));

        $iframe_url = input('jump_url','/store.php/dashboard');
        $menu_url = input('menu_url','');
        $this->assign('menu_url',$menu_url);
        $param = $this->request->param();
        $request_param = '';
        if($param){
            foreach ($param as $key => $value) {
                if($key != 'jump_url'){
                    $request_param .=  $key.'='.$value.'&';
                }
            }
        }
        // var_dump($iframe_url.'?'.$request_param);
        // die;
        $this->assign('iframe_url',$iframe_url.'?'.$request_param);
        $this->view->assign('title', __('Home'));
        return $this->view->fetch();
    }


    /**
     * 管理员登录
     */
    public function login()
    {
        $url = $this->request->get('url', 'index/index');
        if ($this->request->isPost()) {
            $username = $this->request->post('username');
            $password = $this->request->post('password');
            $token = $this->request->post('__token__');
            $rule = [
                'username'  => 'require|length:3,30',
                'password'  => 'require|length:3,30',
                '__token__' => 'require|token',
            ];
            $data = [
                'username'  => $username,
                'password'  => $password,
                '__token__' => $token,
            ];
            if (Config::get('fastadmin.login_captcha')) {
                $rule['captcha'] = 'require|captcha';
                $data['captcha'] = $this->request->post('captcha');
            }
            $validate = new Validate($rule, [], ['username' => __('Username'), 'password' => __('Password'), 'captcha' => __('Captcha')]);
            $result = $validate->check($data);
            if (!$result) {
                $this->error($validate->getError(), $url, ['token' => $this->request->token()]);
            }
            $password = md5($password);
            $store = Db::name('store')->where('status=1 and password="'.$password.'" and username="'.$username.'" and out_date>="'.date('Y-m-d').'"')->find();
            if(!$store){
                $this->error('账号密码错误', $url, ['token' => $this->request->token()]);
            }
            session('store_id',$store['id']);
            session('agent_id',$store['agent_id']);
            session('store_name',$store['store_name']);
            session('out_date',$store['out_date']);
            $this->success(__('Login successful'), $url, ['url' => $url, 'id' => $store['id'], 'username' => $username, 'avatar' => '']);
        }

        // 根据客户端的cookie,判断是否可以自动登录
        // if (session('store_id')) {
        //     $this->redirect($url);
        // }
        $background = Config::get('fastadmin.login_background');
        $background = $background ? (stripos($background, 'http') === 0 ? $background : config('site.cdnurl') . $background) : '';
        $this->view->assign('background', $background);
        $site = Config::get("site");
        $this->view->assign('title', $site['name'].'-登录');
        Hook::listen("admin_login_init", $this->request);
        return $this->view->fetch();
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        session('store_id',0);
        session('agent_id',0);
        session('store_name','');
        session('out_date','');
        $this->success(__('Logout successful'), 'index/login');
    }

}
