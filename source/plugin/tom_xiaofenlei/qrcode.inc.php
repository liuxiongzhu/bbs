<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$test = intval($_GET['test'])>0? intval($_GET['test']):0;

session_start();
define('TPL_DEFAULT', true);
$formhash = FORMHASH;
$tongchengConfig = $_G['cache']['plugin']['tom_tongcheng'];
$xiaofenleiConfig = $_G['cache']['plugin']['tom_xiaofenlei'];
$tomSysOffset = getglobal('setting/timeoffset');
$appid = trim($xiaofenleiConfig['wxpay_appid']);  
$appsecret = trim($xiaofenleiConfig['wxpay_appsecret']);

include DISCUZ_ROOT.'./source/plugin/tom_xiaofenlei/qrcode.func.php';

$r = xiaoGetwxacodeunlimit("pages/index/tcshop",'1_1',640);

if(isset($r['code']) && $r['code'] == 0 && !empty($r['src']) && $test == 0){
    echo '<img src="'.$r['src'].'">';exit;
}else{
    var_dump($r);exit;
}