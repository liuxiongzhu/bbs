<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$Lang = $scriptlang['tom_tousu'];
$adminBaseUrl = ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=tom_tousu&pmod=admin'; 
$adminListUrl = 'action=plugins&operation=config&do='.$pluginid.'&identifier=tom_tousu&pmod=admin';
$adminFromUrl = 'plugins&operation=config&do=' . $pluginid . '&identifier=tom_tousu&pmod=admin';

$tomSysOffset = getglobal('setting/timeoffset');
include DISCUZ_ROOT.'./source/plugin/tom_tousu/tom.func.php';

if($_GET['tmod'] == 'index'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_tousu/admin/index.php';
}else if($_GET['tmod'] == 'addon'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_tousu/admin/addon.php';
}else{
    
    include DISCUZ_ROOT.'./source/plugin/tom_tousu/admin/index.php';
}

