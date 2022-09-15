<?php
$id = isset($_GET['id'])?$_GET['id']:'';
$channel=array(
    '41'=>'我们的歌',
    '84'=>'谜案大世界',
    '59'=>'完美的夏天',
    '27'=>'极限挑战',
    '213'=>'汤妈妈',
    '222'=>'完美的夏天2',
    '193'=>'王牌对王牌',
    '146'=>'东方风云榜',
    '128'=>'最好的舞台',
    '229'=>'粤语好声音',
    '228'=>'美好生活家',
    '96'=>'金曲青春',
    '144'=>'人气美食',
    '218'=>'漫游记',
    '124'=>'两个人的世界',
    '76'=>'高能脱口秀',
    '126'=>'也平凡',
    '201'=>'奔跑吧兄弟',
    '37'=>'童年国漫',
    '186'=>'童年神剧',
    '119'=>'城市真英雄',
    '226'=>'荒野求生',
    '216'=>'整容级妆教',
    '192'=>'一路唱响',
    '156'=>'天籁之战',
    '40'=>'宅家瘦全身',
    '120'=>'居家云打卡',
    '38'=>'海派滑稽戏',
    '134'=>'领航',
    '52'=>'带娃小妙招',
  );
 $tv=array(
    '22'=>'东方卫视',
    '20'=>'新闻综合',
    '17'=>'外语频道',
    '18'=>'都市频道',
    '19'=>'哈哈炫动',
    '28'=>'纪实人文',
    '21'=>'第一财经',
    '26'=>'东方财经',
    );
$url='https://bp-api.bestv.com.cn/cms/api/caster/channels';
if(!empty($tv[$id])){    
  $url='https://bp-api.bestv.com.cn/cms/api/live/channels';
}
$post='{
    "userId":"0",
    "devid": "1899999",
    "curModel": 0,
    "modelType": "1",
    "platform": "android",
    "deviceToken": "An7l8jq0heNj_ol099rmJpVLg_li-QkR239SQngingxD",
    "roleId": "",
    "roleType": "1",
    "version": 4808,
    "osVersion": 23,
    "channelid": "199999",
    "udid": "e4cd46952b2b2159"
  }';
$header=array(
    "cookie:acw_tc=",
    'Content-Type: application/json; charset=utf-8',
  );
$info=json_decode(get_data($url,$header,$post));
$weekarray=array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
$nowday=date('m-d ').$weekarray[date('w')];
foreach ($info->dt as $quity){
    if($id==''||$id=='list'){
        $cid= $quity->channelId;
        $name=$quity->channelName;
        echo $name.',http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?id='.$cid.'</a><br>';
      }
    if($quity->channelId==$id||$quity->channelName==$channel[$id]){
        $sid=$quity->aliChannelId;
        if($sid){
           $playurl='https://bp-caster.bestv.com.cn/'.$sid.'/3/video.m3u8';
           break;
        }
      }
    if($quity->dateShow==$nowday){
        foreach ($quity->liveChannelList as $out){
            if($out->id==$id||$out->channelName==$tv[$id]){
            $playurl=$out->channelUrl;
            break;
            }
        }
    }  
}
if($playurl){
    //print_r($playurl);
    header('location:'.$playurl);
  }
function get_data($url,$header,$post=null){
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
if(!empty($post)){
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
  }
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
$data = curl_exec($ch);
curl_close($ch);
return $data;
}