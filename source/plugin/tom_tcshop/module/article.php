<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}



$act  = isset($_GET['act'])? addslashes($_GET['act']):'xieyi';

$title = "";
$content = "";

$commonInfo = C::t('#tom_tcshop#tom_tcshop_common')->fetch_by_id(1);
if(!$commonInfo){
    $insertData = array();
    $insertData['id']      = 1;
    C::t('#tom_tcshop#tom_tcshop_common')->insert($insertData);
}

if($act == 'xieyi'){
    $title = lang("plugin/tom_tcshop", "xieyi_title");
    $content = stripslashes($commonInfo['xieyi_txt']);
}else if($act == 'vip'){
    $title = lang("plugin/tom_tcshop", "vip_title");
    $content = stripslashes($commonInfo['vip_txt']);
}
$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
include template("tom_tcshop:article");  




