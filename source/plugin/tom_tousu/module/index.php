<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$url = $_SERVER['HTTP_REFERER'];
$url = daddslashes(urlencode($url));
$lifeTime = 86400*30;
$_SESSION['tomwx_tousu_url'] = $url;
dsetcookie('tomwx_tousu_url',$url,$lifeTime);

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
include template("tom_tousu:index");


