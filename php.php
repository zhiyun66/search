<?php
// 关闭PHP报错
error_reporting( E_ALL^E_NOTICE^E_WARNING );

//实现使用curl模拟百度蜘蛛进行采集
function Go( $url )
{
    $ch = curl_init();
    //随机生成IP
    $ip = rand(0,255).'.'.rand(0,255).'.'.rand(0,255).'.'.rand(0,255) ; // 百度蜘蛛
    $timeout = 15;
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_TIMEOUT,0);
    //伪造百度蜘蛛IP  
    curl_setopt($ch,CURLOPT_HTTPHEADER,array('X-FORWARDED-FOR:'.$ip.'','CLIENT-IP:'.$ip.'')); 
    //伪造百度蜘蛛头部
    curl_setopt($ch,CURLOPT_USERAGENT,"Mozilla/5.0 (compatible; Baiduspider/2.0; +http://www.baidu.com/search/spider.html)");
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_HEADER,0);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
      curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    $content = curl_exec($ch);
    curl_close($ch);
}

//判断url是否存在  存在进行访问
if ($_GET['url']) {
    $api = $_GET['url'];
    $data = Go($api);
    sleep(10);
    $mydata = ['msg'=>200,'val'=>'提交成功','num'=>1];
    exit(json_encode($mydata, JSON_UNESCAPED_UNICODE));
}else{
    $mydata = ['msg'=>404,'val'=>'提交失败','cause'=>'URL推广链接不能为空'];
    exit(json_encode($mydata, JSON_UNESCAPED_UNICODE));
}


