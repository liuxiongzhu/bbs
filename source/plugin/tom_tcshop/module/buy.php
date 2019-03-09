<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$act  = isset($_GET['act'])? addslashes($_GET['act']):'top';

$tcshop_id = intval($_GET['tcshop_id'])>0? intval($_GET['tcshop_id']):0;

$tcshopInfo = C::t('#tom_tcshop#tom_tcshop')->fetch_by_id($tcshop_id);

$pay_price_arr = array();
for($i=1;$i<=30;$i++){
    $pay_price_arr[$i] = $tcshopConfig['top_price']*$i;
}

$toptime = dgmdate($tcshopInfo['toptime'],"Y-m-d",$tomSysOffset);

$day_num = 7;

$payTopUrl = "plugin.php?id=tom_tcshop:pay&site={$site_id}&act=top&formhash=".$formhash;

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
include template("tom_tcshop:buy");  




