<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$Lang = $scriptlang['tom_tchongbao'];
$adminBaseUrl = ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=tom_tchongbao&pmod=admin'; 
$adminListUrl = 'action=plugins&operation=config&do='.$pluginid.'&identifier=tom_tchongbao&pmod=admin';
$adminFromUrl = 'plugins&operation=config&do=' . $pluginid . '&identifier=tom_tchongbao&pmod=admin';

$tomSysOffset = getglobal('setting/timeoffset');
include DISCUZ_ROOT.'./source/plugin/tom_tchongbao/class/tom.form.php';
include DISCUZ_ROOT.'./source/plugin/tom_tchongbao/class/function.admin.php';
include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/class/tom.upload.php';
include DISCUZ_ROOT.'./source/plugin/tom_tchongbao/class/function.core.php';

$tchongbaoConfig = get_tchongbao_config($pluginid);

$Lang = formatLang($Lang);

if($_GET['tmod'] == 'index'){
    include DISCUZ_ROOT.'./source/plugin/tom_tchongbao/admin/index.php';
}else if($_GET['tmod'] == 'log'){
    include DISCUZ_ROOT.'./source/plugin/tom_tchongbao/admin/log.php';
}else if($_GET['tmod'] == 'district'){
    include DISCUZ_ROOT.'./source/plugin/tom_tchongbao/admin/district.php';
}else if($_GET['tmod'] == 'addon'){
    include DISCUZ_ROOT.'./source/plugin/tom_tchongbao/admin/addon.php';
}else{
    include DISCUZ_ROOT.'./source/plugin/tom_tchongbao/admin/index.php';
}


