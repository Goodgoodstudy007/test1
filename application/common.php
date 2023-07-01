<?php

// 公共助手函数

use Symfony\Component\VarExporter\VarExporter;
use think\Request;

if (!function_exists('__')) {

    /**
     * 获取语言变量值
     * @param string $name 语言变量名
     * @param array  $vars 动态变量值
     * @param string $lang 语言
     * @return mixed
     */
    function __($name, $vars = [], $lang = '')
    {
        if (is_numeric($name) || !$name) {
            return $name;
        }
        if (!is_array($vars)) {
            $vars = func_get_args();
            array_shift($vars);
            $lang = '';
        }
        return \think\Lang::get($name, $vars, $lang);
    }
}

if (!function_exists('format_bytes')) {

    /**
     * 将字节转换为可读文本
     * @param int    $size      大小
     * @param string $delimiter 分隔符
     * @param int    $precision 小数位数
     * @return string
     */
    function format_bytes($size, $delimiter = '', $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
        for ($i = 0; $size >= 1024 && $i < 6; $i++) {
            $size /= 1024;
        }
        return round($size, $precision) . $delimiter . $units[$i];
    }
}

if (!function_exists('datetime')) {

    /**
     * 将时间戳转换为日期时间
     * @param int    $time   时间戳
     * @param string $format 日期时间格式
     * @return string
     */
    function datetime($time, $format = 'Y-m-d H:i:s')
    {
        $time = is_numeric($time) ? $time : strtotime($time);
        return date($format, $time);
    }
}

if (!function_exists('human_date')) {

    /**
     * 获取语义化时间
     * @param int $time  时间
     * @param int $local 本地时间
     * @return string
     */
    function human_date($time, $local = null)
    {
        return \fast\Date::human($time, $local);
    }
}

if (!function_exists('cdnurl')) {

    /**
     * 获取上传资源的CDN的地址
     * @param string  $url    资源相对地址
     * @param boolean $domain 是否显示域名 或者直接传入域名
     * @return string
     */
    function cdnurl($url, $domain = false)
    {
        $regex = "/^((?:[a-z]+:)?\/\/|data:image\/)(.*)/i";
        $cdnurl = \think\Config::get('upload.cdnurl');
        $url = preg_match($regex, $url) || ($cdnurl && stripos($url, $cdnurl) === 0) ? $url : $cdnurl . $url;
        if ($domain && !preg_match($regex, $url)) {
            $domain = is_bool($domain) ? request()->domain() : $domain;
            $url = $domain . $url;
        }
        return $url;
    }
}


if (!function_exists('is_really_writable')) {

    /**
     * 判断文件或文件夹是否可写
     * @param string $file 文件或目录
     * @return    bool
     */
    function is_really_writable($file)
    {
        if (DIRECTORY_SEPARATOR === '/') {
            return is_writable($file);
        }
        if (is_dir($file)) {
            $file = rtrim($file, '/') . '/' . md5(mt_rand());
            if (($fp = @fopen($file, 'ab')) === false) {
                return false;
            }
            fclose($fp);
            @chmod($file, 0777);
            @unlink($file);
            return true;
        } elseif (!is_file($file) or ($fp = @fopen($file, 'ab')) === false) {
            return false;
        }
        fclose($fp);
        return true;
    }
}

if (!function_exists('rmdirs')) {

    /**
     * 删除文件夹
     * @param string $dirname  目录
     * @param bool   $withself 是否删除自身
     * @return boolean
     */
    function rmdirs($dirname, $withself = true)
    {
        if (!is_dir($dirname)) {
            return false;
        }
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dirname, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $fileinfo) {
            $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
            $todo($fileinfo->getRealPath());
        }
        if ($withself) {
            @rmdir($dirname);
        }
        return true;
    }
}

if (!function_exists('copydirs')) {

    /**
     * 复制文件夹
     * @param string $source 源文件夹
     * @param string $dest   目标文件夹
     */
    function copydirs($source, $dest)
    {
        if (!is_dir($dest)) {
            mkdir($dest, 0755, true);
        }
        foreach (
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::SELF_FIRST
            ) as $item
        ) {
            if ($item->isDir()) {
                $sontDir = $dest . DS . $iterator->getSubPathName();
                if (!is_dir($sontDir)) {
                    mkdir($sontDir, 0755, true);
                }
            } else {
                copy($item, $dest . DS . $iterator->getSubPathName());
            }
        }
    }
}

if (!function_exists('mb_ucfirst')) {
    function mb_ucfirst($string)
    {
        return mb_strtoupper(mb_substr($string, 0, 1)) . mb_strtolower(mb_substr($string, 1));
    }
}

if (!function_exists('addtion')) {

    /**
     * 附加关联字段数据
     * @param array $items  数据列表
     * @param mixed $fields 渲染的来源字段
     * @return array
     */
    function addtion($items, $fields)
    {
        if (!$items || !$fields) {
            return $items;
        }
        $fieldsArr = [];
        if (!is_array($fields)) {
            $arr = explode(',', $fields);
            foreach ($arr as $k => $v) {
                $fieldsArr[$v] = ['field' => $v];
            }
        } else {
            foreach ($fields as $k => $v) {
                if (is_array($v)) {
                    $v['field'] = isset($v['field']) ? $v['field'] : $k;
                } else {
                    $v = ['field' => $v];
                }
                $fieldsArr[$v['field']] = $v;
            }
        }
        foreach ($fieldsArr as $k => &$v) {
            $v = is_array($v) ? $v : ['field' => $v];
            $v['display'] = isset($v['display']) ? $v['display'] : str_replace(['_ids', '_id'], ['_names', '_name'], $v['field']);
            $v['primary'] = isset($v['primary']) ? $v['primary'] : '';
            $v['column'] = isset($v['column']) ? $v['column'] : 'name';
            $v['model'] = isset($v['model']) ? $v['model'] : '';
            $v['table'] = isset($v['table']) ? $v['table'] : '';
            $v['name'] = isset($v['name']) ? $v['name'] : str_replace(['_ids', '_id'], '', $v['field']);
        }
        unset($v);
        $ids = [];
        $fields = array_keys($fieldsArr);
        foreach ($items as $k => $v) {
            foreach ($fields as $m => $n) {
                if (isset($v[$n])) {
                    $ids[$n] = array_merge(isset($ids[$n]) && is_array($ids[$n]) ? $ids[$n] : [], explode(',', $v[$n]));
                }
            }
        }
        $result = [];
        foreach ($fieldsArr as $k => $v) {
            if ($v['model']) {
                $model = new $v['model'];
            } else {
                $model = $v['name'] ? \think\Db::name($v['name']) : \think\Db::table($v['table']);
            }
            $primary = $v['primary'] ? $v['primary'] : $model->getPk();
            $result[$v['field']] = isset($ids[$v['field']]) ? $model->where($primary, 'in', $ids[$v['field']])->column("{$primary},{$v['column']}") : [];
        }

        foreach ($items as $k => &$v) {
            foreach ($fields as $m => $n) {
                if (isset($v[$n])) {
                    $curr = array_flip(explode(',', $v[$n]));

                    $v[$fieldsArr[$n]['display']] = implode(',', array_intersect_key($result[$n], $curr));
                }
            }
        }
        return $items;
    }
}

if (!function_exists('var_export_short')) {

    /**
     * 使用短标签打印或返回数组结构
     * @param mixed   $data
     * @param boolean $return 是否返回数据
     * @return string
     */
    function var_export_short($data, $return = true)
    {
        return var_export($data, $return);
        $replaced = [];
        $count = 0;

        //判断是否是对象
        if (is_resource($data) || is_object($data)) {
            return var_export($data, $return);
        }

        //判断是否有特殊的键名
        $specialKey = false;
        array_walk_recursive($data, function (&$value, &$key) use (&$specialKey) {
            if (is_string($key) && (stripos($key, "\n") !== false || stripos($key, "array (") !== false)) {
                $specialKey = true;
            }
        });
        if ($specialKey) {
            return var_export($data, $return);
        }
        array_walk_recursive($data, function (&$value, &$key) use (&$replaced, &$count, &$stringcheck) {
            if (is_object($value) || is_resource($value)) {
                $replaced[$count] = var_export($value, true);
                $value = "##<{$count}>##";
            } else {
                if (is_string($value) && (stripos($value, "\n") !== false || stripos($value, "array (") !== false)) {
                    $index = array_search($value, $replaced);
                    if ($index === false) {
                        $replaced[$count] = var_export($value, true);
                        $value = "##<{$count}>##";
                    } else {
                        $value = "##<{$index}>##";
                    }
                }
            }
            $count++;
        });

        $dump = var_export($data, true);

        $dump = preg_replace('#(?:\A|\n)([ ]*)array \(#i', '[', $dump); // Starts
        $dump = preg_replace('#\n([ ]*)\),#', "\n$1],", $dump); // Ends
        $dump = preg_replace('#=> \[\n\s+\],\n#', "=> [],\n", $dump); // Empties
        $dump = preg_replace('#\)$#', "]", $dump); //End

        if ($replaced) {
            $dump = preg_replace_callback("/'##<(\d+)>##'/", function ($matches) use ($replaced) {
                return isset($replaced[$matches[1]]) ? $replaced[$matches[1]] : "''";
            }, $dump);
        }

        if ($return === true) {
            return $dump;
        } else {
            echo $dump;
        }
    }
}

if (!function_exists('letter_avatar')) {
    /**
     * 首字母头像
     * @param $text
     * @return string
     */
    function letter_avatar($text)
    {
        $total = unpack('L', hash('adler32', $text, true))[1];
        $hue = $total % 360;
        list($r, $g, $b) = hsv2rgb($hue / 360, 0.3, 0.9);

        $bg = "rgb({$r},{$g},{$b})";
        $color = "#ffffff";
        $first = mb_strtoupper(mb_substr($text, 0, 1));
        $src = base64_encode('<svg xmlns="http://www.w3.org/2000/svg" version="1.1" height="100" width="100"><rect fill="' . $bg . '" x="0" y="0" width="100" height="100"></rect><text x="50" y="50" font-size="50" text-copy="fast" fill="' . $color . '" text-anchor="middle" text-rights="admin" dominant-baseline="central">' . $first . '</text></svg>');
        $value = 'data:image/svg+xml;base64,' . $src;
        return $value;
    }
}

if (!function_exists('hsv2rgb')) {
    function hsv2rgb($h, $s, $v)
    {
        $r = $g = $b = 0;

        $i = floor($h * 6);
        $f = $h * 6 - $i;
        $p = $v * (1 - $s);
        $q = $v * (1 - $f * $s);
        $t = $v * (1 - (1 - $f) * $s);

        switch ($i % 6) {
            case 0:
                $r = $v;
                $g = $t;
                $b = $p;
                break;
            case 1:
                $r = $q;
                $g = $v;
                $b = $p;
                break;
            case 2:
                $r = $p;
                $g = $v;
                $b = $t;
                break;
            case 3:
                $r = $p;
                $g = $q;
                $b = $v;
                break;
            case 4:
                $r = $t;
                $g = $p;
                $b = $v;
                break;
            case 5:
                $r = $v;
                $g = $p;
                $b = $q;
                break;
        }

        return [
            floor($r * 255),
            floor($g * 255),
            floor($b * 255)
        ];
    }
}

if (!function_exists('check_nav_active')) {
    /**
     * 检测会员中心导航是否高亮
     */
    function check_nav_active($url, $classname = 'active')
    {
        $auth = \app\common\library\Auth::instance();
        $requestUrl = $auth->getRequestUri();
        $url = ltrim($url, '/');
        return $requestUrl === str_replace(".", "/", $url) ? $classname : '';
    }
}

if (!function_exists('check_cors_request')) {
    /**
     * 跨域检测
     */
    function check_cors_request()
    {
        if (isset($_SERVER['HTTP_ORIGIN']) && $_SERVER['HTTP_ORIGIN']) {
            $info = parse_url($_SERVER['HTTP_ORIGIN']);
            $domainArr = explode(',', config('fastadmin.cors_request_domain'));
            $domainArr[] = request()->host(true);
            if (in_array("*", $domainArr) || in_array($_SERVER['HTTP_ORIGIN'], $domainArr) || (isset($info['host']) && in_array($info['host'], $domainArr))) {
                header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
            } else {
                header('HTTP/1.1 403 Forbidden');
                exit;
            }

            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');

            if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
                if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
                }
                if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
                    header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
                }
                exit;
            }
        }
    }
}

if (!function_exists('xss_clean')) {
    /**
     * 清理XSS
     */
    function xss_clean($content, $is_image = false)
    {
        return \app\common\library\Security::instance()->xss_clean($content, $is_image);
    }
}

if (!function_exists('check_ip_allowed')) {
    /**
     * 检测IP是否允许
     * @param string $ip IP地址
     */
    function check_ip_allowed($ip = null)
    {
        $ip = is_null($ip) ? request()->ip() : $ip;
        $forbiddenipArr = config('site.forbiddenip');
        $forbiddenipArr = !$forbiddenipArr ? [] : $forbiddenipArr;
        $forbiddenipArr = is_array($forbiddenipArr) ? $forbiddenipArr : array_filter(explode("\n", str_replace("\r\n", "\n", $forbiddenipArr)));
        if ($forbiddenipArr && \Symfony\Component\HttpFoundation\IpUtils::checkIp($ip, $forbiddenipArr)) {
            header('HTTP/1.1 403 Forbidden');
            exit;
        }
    }
}

function dcurl($url, $method = 'GET', $postFields = null, $header = null,$isjson=0) {
    $ch = curl_init();
    // curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
    curl_setopt($ch, CURLOPT_FAILONERROR, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

    if (strlen($url) > 5 && strtolower(substr($url, 0, 5)) == "https") {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        // curl_setopt($ch, CURLOPT_SSLVERSION, 3);
    }

    switch ($method) {
        case 'POST':
            curl_setopt($ch, CURLOPT_POST, true);
            if (!empty($postFields)) {
                if (is_array($postFields) || is_object($postFields)) {
                    if (is_object($postFields)) {
                        $postFields = object2array($postFields);
                    }
                    $postBodyString = "";
                    $postMultipart = false;
                    foreach ($postFields as $k => $v) {
                        if ("@" != substr($v, 0, 1)) { //判断是不是文件上传
                            $postBodyString .= "$k=" . urlencode($v) . "&";
                        } else { //文件上传用multipart/form-data，否则用www-form-urlencoded
                            $postMultipart = true;
                        }
                    }
                    unset($k, $v);
                    if ($postMultipart) {
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
                    } else {
                        curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString, 0, -1));
                    }
                } else {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
                }
            }
            break;
        default:
            if (!empty($postFields) && is_array($postFields)) {
                $url .= (strpos($url, '?') === false ? '?' : '&') . http_build_query($postFields);
            }
            break;
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    if($isjson){
        array_push($header, 'Content-Length:'.strlen($postFields));
        array_push($header, 'Content-Type: application/json; charset=utf-8');
    }
    if (!empty($header) && is_array($header)) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    }
    $response = curl_exec($ch);
    // if (curl_errno($ch)) {
    //     throw new Exception(curl_error($ch), 0);
    // }
    curl_close($ch);

    return $response;
}

function curl_json($url,$data, $header = null,$cookie=''){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    if(isset($data['proxy_ip']) && !empty($data['proxy_ip'])){
        $http_proxy = $data['proxy_ip'].":".$data['proxy_port'];
        curl_setopt($curl, CURLOPT_HTTPPROXYTUNNEL, false );  
        curl_setopt($curl, CURLOPT_PROXYTYPE, 1); //http
        curl_setopt($curl, CURLOPT_PROXY, "http://$http_proxy"); //代理服务器地址
        // curl_setopt($ch, CURLOPT_PROXYPORT, $postFields['proxy_port']); //代理服务器端口
    }
    if($cookie){
        curl_setopt ($curl, CURLOPT_COOKIE , $cookie );
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    // curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

    if (!empty($data)) {
        if(isset($data['proxy_ip'])){
            unset($data['proxy_ip']);
        }
        if(isset($data['proxy_port'])){
            unset($data['proxy_port']);
        }
        if (is_array($data) || is_object($data)) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        } else {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
    }
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //抓HTTPS可以把此项设置为false
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); //抓HTTPS可以把此项设置为false
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    if (!empty($header) && is_array($header)) {
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    }
    $response = curl_exec($curl);
    $error_info = curl_error($curl);
    curl_close($curl);
    if($response){
        return $response;
    }else{
        return $error_info;
    }
    
}

function get_cookie($url_,$params_,$referer_){
    if($url_==null){echo "get_cookie_url_null";exit;}
    $ch = curl_init($url_);//这里是初始化一个访问对话，并且传入url，这要个必须有
    curl_setopt($ch, CURLOPT_HEADER,1);//如果你想把一个头包含在输出中，设置这个选项为一个非零值，我这里是要输出，所以为 1
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);//将 curl_exec()获取的信息以文件流的形式返回，而不是直接输出。设置为0是直接输出
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//设置跟踪页面的跳转，有时候你打开一个链接，在它内部又会跳到另外一个，就是这样理解
    curl_setopt($ch,CURLOPT_POST,1);//开启post数据的功能，这个是为了在访问链接的同时向网页发送数据，一般数urlencode码
    curl_setopt($ch,CURLOPT_POSTFIELDS,$params_); //把你要提交的数据放这
    $rand = date('YmdHis').rand(1111,9999);
    curl_setopt($ch, CURLOPT_COOKIEJAR, WWWROOT_PATH.'/node/cookie/login_'.$rand.'.txt');//获取的cookie 保存到指定的 文件路径，我这里是相对路径，可以是$变量
    curl_setopt ($ch, CURLOPT_REFERER,$referer_); //在HTTP请求中包含一个'referer'头的字符串。告诉服务器我是从哪个页面链接过来的，服务器籍此可以获得一些信息用于处理。
    $content=curl_exec($ch);     //重点来了，上面的众多设置都是为了这个，进行url访问，带着上面的所有设置
    if(curl_errno($ch)){
     echo 'Curl error: '.curl_error($ch);exit(); //这里是设置个错误信息的反馈
    }    
    if($content==false){
     echo "get_content_null";exit();
    }
    preg_match('/Set-Cookie:(.*);/iU',$content,$str); //这里采用正则匹配来获取cookie并且保存它到变量$str里，这就是为什么上面可以发送cookie变量的原因
    $cookie = @$str[1]; //获得COOKIE（SESSIONID）
    curl_close($ch);//关闭会话
    // unlink(WWWROOT_PATH.'node/cookie/login_'.$rand.'.txt');
    return     $cookie;//返回cookie  
}

function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = true) {
    $str = preg_replace("/<([a-zA-Z]+)[^>]*>/", "", $str);
    if (function_exists("mb_substr")) {
        if ($suffix && ceil(strlen($str) / 2) > $length)
            return mb_substr($str, $start, $length, $charset) . "...";
        else
            return mb_substr($str, $start, $length, $charset);
    } elseif (function_exists('iconv_substr')) {
        if ($suffix && ceil(strlen($str) / 2) > $length)
            return iconv_substr($str, $start, $length, $charset) . "...";
        else
            return iconv_substr($str, $start, $length, $charset);
    }
    $re ['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
    $re ['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
    $re ['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
    $re ['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
    preg_match_all($re [$charset], $str, $match);
    $slice = join("", array_slice($match [0], $start, $length));
    if ($suffix) {
        return $slice . "…";
    } else {
        return $slice;
    }
}

function findThePhoneNumbers($oldStr = ""){
  // 检测字符串是否为空
  $oldStr=trim($oldStr);
  $numbers = "";
  if(empty($oldStr)){
     return "";
  }
  // 删除86-180640741122，0997-8611222之类的号码中间的减号（-）
  $strArr = explode("-", $oldStr);
  $newStr = $strArr[0];
  for ($i=1; $i < count($strArr); $i++) { 
    if (preg_match("/\d{2}$/", $newStr) && preg_match("/^\d{11}/", $strArr[$i])){
      $newStr .= $strArr[$i]; 
    } elseif (preg_match("/\d{3,4}$/", $newStr) && preg_match("/^\d{7,8}/", $strArr[$i])) {
      $newStr .= $strArr[$i]; 
    } else {
      $newStr .= "-".$strArr[$i]; 
    } 
  }

  // 手机号的获取
  $reg='/\D(?:86)?(\d{11})\D/is';//匹配数字的正则表达式
  preg_match_all($reg,$newStr,$result);
  $nums = array();
  // * 中国移动：China Mobile
  // * 134[0-8],135,136,137,138,139,150,151,157,158,159,182,187,188
  $cm = "/^1(34[0-8]|(3[5-9]|5[017-9]|8[278])\d)\d{7}$/";
  // * 中国联通：China Unicom
  // * 130,131,132,152,155,156,185,186
  $cu = "/^1(3[0-2]|5[256]|8[56])\d{8}$/";
  // * 中国电信：China Telecom
  // * 133,1349,153,180,189
  $ct = "/^1((33|53|8[09])[0-9]|349)\d{7}$/";
  //
  foreach ($result[1] as $key => $value) {
    if(preg_match("/^1[3456789]{1}\d{9}$/",$value)){  
        $nums = $value; 
    }
  }
  $numbers = $nums;
  $numbers = empty($numbers) ? '' : $numbers;
  // 返回最终数组
  return $numbers;
}

function cookie_proxy($url, $postFields = null, $header = null,$cookie="",$error_count = 0) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url); //请求url地址
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //设置获取页面内容
    if (!empty($header) && is_array($header)) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    }
    if(isset($postFields['proxy_ip']) && !empty($postFields['proxy_ip'])){
        $http_proxy = $postFields['proxy_ip'].":".$postFields['proxy_port'];
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, false );  
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); //http
        curl_setopt($ch, CURLOPT_PROXY, "http://$http_proxy"); //代理服务器地址
        // curl_setopt($ch, CURLOPT_PROXYPORT, $postFields['proxy_port']); //代理服务器端口
    }
    if($cookie){
        curl_setopt ($ch, CURLOPT_COOKIE , $cookie );
    }
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //抓HTTPS可以把此项设置为false
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //抓HTTPS可以把此项设置为false
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_HEADER,1);
    $output = curl_exec($ch); //请求返回值
    $errorinfo = curl_error($ch); //请求返回错误信息
    if (curl_errno($ch)) {
        $error_count++;
        if($error_count < 2){
            unset($postFields['proxy_ip']);
            return cookie_proxy($url,$postFields,$header,$cookie,$error_count);
        }else{
            return '';
            // throw new Exception(curl_error($ch), 0);
        }
        
    }
            
    curl_close($ch);
    if($output){
        // list($header, $body) = explode("\r\n\r\n", $output); 
        preg_match("/Set\-Cookie:([^\r\n]*)/i", $output, $matches); 
        $cookie = @$matches[1]; //获得COOKIE（SESSIONID）
        return $cookie;
    }
    return '';
    
}


function dcurl_proxy($url, $postFields = null, $header = null,$cookie="",$error_count = 0,$head_code=0) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url); //请求url地址
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //设置获取页面内容
    if(strpos($url,'xiaohongshu')!==false){
        // 小红书传json
        $param = $postFields;
        if(isset($param['proxy_ip'])){
            unset($param['proxy_ip']);
        }
        if(isset($param['proxy_port'])){
            unset($param['proxy_port']);
        }
        $param = empty($param) ? '' : json_encode($param);
        if(!empty($param)){
            array_push($header, 'Content-Length:'.strlen($param));
        }
        array_push($header, 'Content-Type: application/json; charset=utf-8');
    }
    if (!empty($header) && is_array($header)) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    }
    if(isset($postFields['proxy_ip']) && !empty($postFields['proxy_ip'])){
        $http_proxy = $postFields['proxy_ip'].":".$postFields['proxy_port'];
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, false );  
        curl_setopt($ch, CURLOPT_PROXYTYPE, 1); //http
        curl_setopt($ch, CURLOPT_PROXY, "http://$http_proxy"); //代理服务器地址
        // curl_setopt($ch, CURLOPT_PROXYPORT, $postFields['proxy_port']); //代理服务器端口
    }
    if($cookie){
        curl_setopt ($ch, CURLOPT_COOKIE , $cookie );
    }   
    if(@$postFields['is_post'] == 1){
        curl_setopt($ch, CURLOPT_POST, true);
        if (!empty($postFields)) {
            if (is_array($postFields) || is_object($postFields)) {
                if (is_object($postFields)) {
                    $postFields = object2array($postFields);
                }
                $postBodyString = "";
                $postMultipart = false;
                foreach ($postFields as $k => $v) {
                    if ("@" != substr($v, 0, 1)) { //判断是不是文件上传
                        $postBodyString .= "$k=" . urlencode($v) . "&";
                    } else { //文件上传用multipart/form-data，否则用www-form-urlencoded
                        $postMultipart = true;
                    }
                }
                unset($k, $v);
                if ($postMultipart) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
                } else {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString, 0, -1));
                }
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
            }
        }
    }
    
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //抓HTTPS可以把此项设置为false
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //抓HTTPS可以把此项设置为false
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $output = curl_exec($ch); //请求返回值
    $errorinfo = curl_error($ch); //请求返回错误信息
    $httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
    if(strpos($url, 'follow')!==false){
        var_dump($url.'---<br><br>'.$cookie.'---<br><br>'.$errorinfo.'---<br><br>'.$output.'---<br><br>'.$httpCode.'---<br><br>'.json_encode($header));exit;
    }

    if (curl_errno($ch)) {
        $error_count++;
        if($error_count < 2){
            unset($postFields['proxy_ip']);
            return dcurl_proxy($url,$postFields,$header,$cookie,$error_count);
        }else{
            return '';
        }
        
        // throw new Exception(curl_error($ch), 0);
    }
    

    if($head_code){
        return $httpCode;
    }
    curl_close($ch);
    if($output){
        return $output;
    }
    return '';

    
}

function dcurl_headers($url,$postFields=null,$header = null,$cookie="") {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url); //请求url地址
    if (!empty($header) && is_array($header)) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    }
    if(isset($postFields['proxy_ip']) && !empty($postFields['proxy_ip'])){
        $http_proxy = $postFields['proxy_ip'].":".$postFields['proxy_port'];
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, false );  
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); //http
        curl_setopt($ch, CURLOPT_PROXY, "http://$http_proxy"); //代理服务器地址
        // curl_setopt($ch, CURLOPT_PROXYPORT, $postFields['proxy_port']); //代理服务器端口
    }
    if($cookie){
        curl_setopt ($ch, CURLOPT_COOKIE , $cookie );
    }
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //抓HTTPS可以把此项设置为false
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //抓HTTPS可以把此项设置为false
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_HEADER,1);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'HEAD');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
    $output = curl_exec($ch); //请求返回值
    $errorinfo = curl_error($ch); //请求返回错误信息
    // $request_header = curl_getinfo( $ch);
    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $header = substr($output, 0, $headerSize);
    curl_close($ch);
    
    return $header;
    
}

// 判断手机
function isMobile() {
    $result = Request::instance()->isMobile();
    return $result;
}