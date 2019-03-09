<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$type = isset($_GET['type'])? intval($_GET['type']):0;
$formhash = isset($_GET['formhash'])? daddslashes($_GET['formhash']):0;

$url = getcookie('tomwx_tousu_url');
if(!$cookieUserid){
    if($_SESSION['tomwx_tousu_url']){
        $url = $_SESSION['tomwx_tousu_url'];
    }
}

$jump_url = "WeixinJSBridge.call('closeWindow');";
$showBth = 0;
if(!empty($url) && $formhash == FORMHASH){
    $showBth = 1;
    $backurl = urldecode($url);
    $jump_url = "document.location='{$backurl}';";
    $insertData = array();
    $insertData['ip'] = bindec(decbin(ip2long($_G['clientip'])));
    $insertData['type'] = $type;
    $insertData['link'] = $backurl;
    $insertData['add_time'] = TIMESTAMP;
    C::t("#tom_tousu#tom_tousu")->insert($insertData);
}

$ip = urlencode($_G['clientip']);
$ajaxUrl = "http://track.tomwx.net/index.php?mod=tousu_log&callback=?&tousu_ip={$ip}&tousu_url={$url}&tousu_type={$type}";

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
include template("tom_tousu:notice");


