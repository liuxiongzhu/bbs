<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

session_start();
define('TPL_DEFAULT', true);
$formhash = FORMHASH;
$touConfig = $_G['cache']['plugin']['tom_tousu'];
$tomSysOffset = getglobal('setting/timeoffset');
$nowDayTime = gmmktime(0,0,0,dgmdate($_G['timestamp'], 'n',$tomSysOffset),dgmdate($_G['timestamp'], 'j',$tomSysOffset),dgmdate($_G['timestamp'], 'Y',$tomSysOffset)) - $tomSysOffset*3600;
require_once libfile('function/discuzcode');
$prand = rand(1, 1000);

if($_GET['mod'] == 'index'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_tousu/module/index.php';
}else if($_GET['mod'] == 'add'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_tousu/module/add.php';
}else if($_GET['mod'] == 'notice'){

    include DISCUZ_ROOT.'./source/plugin/tom_tousu/module/notice.php';
}else{
    
    include DISCUZ_ROOT.'./source/plugin/tom_tousu/module/index.php';
}

