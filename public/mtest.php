<?php
function get_cookie($url_,$params_,$referer_){
    if($url_==null){echo "get_cookie_url_null";exit;}
    $ch = curl_init($url_);//这里是初始化一个访问对话，并且传入url，这要个必须有
    curl_setopt($ch, CURLOPT_HEADER,1);//如果你想把一个头包含在输出中，设置这个选项为一个非零值，我这里是要输出，所以为 1
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,0);//将 curl_exec()获取的信息以文件流的形式返回，而不是直接输出。设置为0是直接输出
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//设置跟踪页面的跳转，有时候你打开一个链接，在它内部又会跳到另外一个，就是这样理解
    curl_setopt($ch,CURLOPT_POST,1);//开启post数据的功能，这个是为了在访问链接的同时向网页发送数据，一般数urlencode码
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36");
    curl_setopt($ch,CURLOPT_POSTFIELDS,$params_); //把你要提交的数据放这
    $rand = date('YmdHis').rand(1111,9999);
    // curl_setopt($ch, CURLOPT_COOKIEJAR, WWWROOT_PATH.'/node/cookie/login_'.$rand.'.txt');//获取的cookie 保存到指定的 文件路径，我这里是相对路径，可以是$变量
    curl_setopt ($ch, CURLOPT_REFERER,$referer_); //在HTTP请求中包含一个'referer'头的字符串。告诉服务器我是从哪个页面链接过来的，服务器籍此可以获得一些信息用于处理。
    $content=curl_exec($ch);     //重点来了，上面的众多设置都是为了这个，进行url访问，带着上面的所有设置
    return $content;
}
get_cookie('https://www.douyin.com','','https://www.douyin.com/');
// var_dump($cookie);


?>
