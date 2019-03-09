<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


$lat  = !empty($_GET['lat'])? addslashes($_GET['lat']):'';
$lng  = !empty($_GET['lng'])? addslashes($_GET['lng']):'';

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
include template("tom_tongcheng:baidumap");