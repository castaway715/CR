<?php
header("Content-type:text/html; Charset=utf-8");
$id = $_GET['id'];
//定义需要提交的链接
$host = 'http://mpp.liveapi.mgtv.com/v1/epg/turnplay/getLivePlayUrlMPP?version=PCweb_1.0&platform=4&buss_id=2000001&channel_id='.$id.'&definition=std';
		//定义协议头，下面的2个重要，如果网站没判断的也可以不设置
	    $headers = array(
		  'Host: mpp.liveapi.mgtv.com',
		  'Referer: http://player.hunantv.com/mgtv_v5_live/live.swf',
        );
//通过PHP的curl以GET方式提交请求
$json_response = curl_get($headers, $host);
//提取返回的直播源地址
$flv = getNeedBetween($json_response,'url":"','"},"');
 
 
//然后设置返回头，让网页重转向至直播源地址
header('location:'.$flv);
 
function curl_get($headers, $url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_sEtopt($ch, CURLOPT_RETURNTRANSFER, 1);
 
	$data = curl_exec($ch);
	curl_close($ch);
	//echo $data;
	return $data;
}
function getNeedBetween($input,$start,$end){
$substr = substr($input, strlen($start)+strpos($input, $start),
 (strlen($input) - strpos($input, $end))*(-1));
  return $substr;
}
?>
