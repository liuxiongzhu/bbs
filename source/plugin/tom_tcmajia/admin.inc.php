<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$Lang = $scriptlang['tom_tcmajia'];
$adminBaseUrl = ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=tom_tcmajia&pmod=admin';
$adminListUrl = 'action=plugins&operation=config&do='.$pluginid.'&identifier=tom_tcmajia&pmod=admin';
$adminFromUrl = 'plugins&operation=config&do=' . $pluginid . '&identifier=tom_tcmajia&pmod=admin';

$tomSysOffset = getglobal('setting/timeoffset');

include DISCUZ_ROOT.'./source/plugin/tom_tcmajia/class/tom.form.php';
include DISCUZ_ROOT.'./source/plugin/tom_tcmajia/class/function.admin.php';
include DISCUZ_ROOT.'./source/plugin/tom_tcmajia/class/tom.upload.php';
$tcmajiaConfig = get_tcmajia_config($pluginid);
$Lang = formatLang($Lang);

if($_GET['tmod'] == 'majia'){
    include DISCUZ_ROOT.'./source/plugin/tom_tcmajia/admin/majia.php';
}else if($_GET['tmod'] == 'addon'){
    include DISCUZ_ROOT.'./source/plugin/tom_tcmajia/admin/addon.php';
}else{
    include DISCUZ_ROOT.'./source/plugin/tom_tcmajia/admin/majia.php';
}