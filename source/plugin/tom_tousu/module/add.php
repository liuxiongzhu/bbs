<?php

/*
   This is NOT a freeware, use is subject to license terms
   ��Ȩ���У�TOM΢�� www.tomwx.cn
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$type = isset($_GET['type'])? intval($_GET['type']):0;

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
include template("tom_tousu:add");


