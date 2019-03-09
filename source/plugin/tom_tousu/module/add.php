<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$type = isset($_GET['type'])? intval($_GET['type']):0;

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
include template("tom_tousu:add");


