<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Db;

/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Update extends Backend
{
    
    /**
     * Store模型对象
     * @var \app\admin\model\Store
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Store;

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
  
        $this->assign('version',VERSION);
        return $this->view->fetch();
    }

    public function update_version(){
        $document_root = str_replace('/public', '', $_SERVER['DOCUMENT_ROOT']);
        $root_name = str_replace('C://wwwroot/', '', $document_root);
        $root_name = str_replace('/www/wwwroot/', '', $root_name);
        // 网站根目录上一级
        $site_root = str_replace($root_name, '', $document_root);
        $now_version = input('now_version','');
        $update_version = dcurl('http://xunpang.hu29.com/index/index/update_version?now_version='.$now_version);

        if($update_version){
            $update_data = json_decode($update_version,1);
            if($update_data['code']==0){
                // $arr=parse_url($update_data['data']['downloadurl']);
                // $fileName = basename($arr['path']);
                $fileName = $root_name.'.zip';
                // 成功，开始更新
                $download_res = $this->getDownload($update_data['data']['downloadurl'], $site_root,$fileName);
                if($download_res){
                    // 解压
                    $res = $this->unzip($site_root.$fileName,$site_root);
                    if(!$res){
                        echo json_encode(['code'=>1,'msg'=>'解压资源包失败，请重试','data'=>[]]);exit; 
                    }else{
                        // 执行sql
                        dcurl('http://'.$_SERVER['SERVER_NAME'].'/index/Updatesql/index');
                    }
                }else{
                    echo json_encode(['code'=>1,'msg'=>'下载资源包失败，请重试','data'=>[]]);exit; 
                }
            }
        }
        echo $update_version;exit;
    }

    /**
     * @param $url 下载地址
     * @param string $publicDir 文件存放地址
     * @param string $filename  文件名称
     * @param int $type
     * @return array|bool
     */
    public function getDownload($url, $path,$fileName) {
        $file=file_get_contents($url);
        return file_put_contents($path.$fileName,$file);
    }

    /**
    * 解压文件到指定目录
    *
    * @param   string   zip压缩文件的路径
    * @param   string   解压文件的目的路径
    * @param   boolean  是否以压缩文件的名字创建目标文件夹
    * @param   boolean  是否重写已经存在的文件
    *
    * @return  boolean  返回成功 或失败
    */
   public function unzip($src_file, $dest_dir=false, $create_zip_name_dir=true, $overwrite=true){
 
    if ($zip = zip_open($src_file)){
        if ($zip){
            $splitter = ($create_zip_name_dir === true) ? "." : "/";
            if($dest_dir === false){
                $dest_dir = substr($src_file, 0, strrpos($src_file, $splitter))."/";
            }
 
            // 如果不存在 创建目标解压目录
            $this->create_dirs($dest_dir);
 
             // 对每个文件进行解压
             while ($zip_entry = zip_read($zip)){
                    // 文件不在根目录
                    $pos_last_slash = strrpos(zip_entry_name($zip_entry), "/");
                    if ($pos_last_slash !== false){
                        // 创建目录 在末尾带 /
                        $this->create_dirs($dest_dir.substr(zip_entry_name($zip_entry), 0, $pos_last_slash+1));
                    }
 
                    // 打开包
                    if (zip_entry_open($zip,$zip_entry,"r")){
 
                        // 文件名保存在磁盘上
                        $file_name = $dest_dir.zip_entry_name($zip_entry);
 
                        // 检查文件是否需要重写
                        if ($overwrite === true || $overwrite === false && !is_file($file_name)){
                            // 读取压缩文件的内容
                            $fstream = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
 
                            @file_put_contents($file_name, $fstream);
                            // 设置权限
                            chmod($file_name, 0777);
                            // echo "save: ".$file_name."<br />";
                        }
 
                        // 关闭入口
                        zip_entry_close($zip_entry);
                    }
                }
                // 关闭压缩包
                zip_close($zip);
            }
        }else{
            return false;
        }
        return true;
    }
 
    /**
    * 创建目录
    */
    public function create_dirs($path){
        if (!is_dir($path)){
          $directory_path = "";
          $directories = explode("/",$path);
          array_pop($directories);
 
          foreach($directories as $directory){
              $directory_path .= $directory."/";
              if (!is_dir($directory_path)){
                  mkdir($directory_path);
                  chmod($directory_path, 0777);
              }
          }
        }
    }

}
