<?php

/**
  *@author: caoshanqiang@zuoyebang.com
  *@brief : 钉钉通知
  *@data  : 2018-10-18
  *
  **/


//curl
class ding{

    //post curl
static function request_by_curl($remote_server, $post_string) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $remote_server);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array ('Content-Type: application/json;charset=utf-8'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // 线下环境不用开启curl证书验证, 未调通情况可尝试添加该代码
    // curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
    // curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

//当前时间点距离未来时间差:时间戳格式
static function getDay($time){
    $now = time();
    $lastTime = $time - $now; 
    return self::time2string($lastTime);
}

//时间戳转化时长,很愚蠢
static function time2string($second){
	$day = floor($second/(3600*24));
	$second = $second%(3600*24);
	$hour = floor($second/3600);
	$second = $second%3600;
	$minute = floor($second/60);
	$second = $second%60;
	return $day.'天'.$hour.'小时'.$minute.'分'.$second.'秒';
}
//$webhook = "https://oapi.dingtalk.com/robot/send?access_token=xxxxxx";
public static function execute(){
    $yuandan = strtotime('2019-01-01 00:00:00');
    $newYear = strtotime('2019-02-05 00:00:00');
    $jlYuandan = self::getDay($yuandan);
    $jlNewYear = self::getDay($newYear);
//    $message="距离19年元旦还有 $jlYuandan,
//    距离19年新年还有 $jlNewYear,
//    ";
$message = '高倩傻x';
//	$atMobiles = '15600367801';//csq
	$atMobiles = '13255661500';//高倩
		$data = [
            'msgtype' => 'text',
            'text'    => [
                'content' => (string)$message,
            ],
            'at' => [
                'atMobiles' => isset($atMobiles) ? (array)$atMobiles : [],
                'isAtAll'   => $isAtAll,
            ],
		];

    $webhook = "https://oapi.dingtalk.com/robot/send?access_token=e3b81945150fbbf476c1955301c2760745d41938cfcf7ecbe2d134bdb7ae04d8";
    //$data = array ('msgtype' => 'text','text' => array ('content' => $message));
    $data_string = json_encode($data);
    $result = self::request_by_curl($webhook, $data_string);
    echo $result;
    }
}

$obj = new ding();
$obj->execute();
