<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$Lang = $scriptlang['tom_tchehuoren'];
$adminBaseUrl = ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=tom_tchehuoren&pmod=admin';
$adminListUrl = 'action=plugins&operation=config&do='.$pluginid.'&identifier=tom_tchehuoren&pmod=admin';
$adminFromUrl = 'plugins&operation=config&do=' . $pluginid . '&identifier=tom_tchehuoren&pmod=admin';

$tomSysOffset = getglobal('setting/timeoffset');
$nowDayTime = gmmktime(0,0,0,dgmdate($_G['timestamp'], 'n',$tomSysOffset),dgmdate($_G['timestamp'], 'j',$tomSysOffset),dgmdate($_G['timestamp'], 'Y',$tomSysOffset)) - $tomSysOffset*3600;
$nowMonthTime = dgmdate($_G['timestamp'], 'Ym',$tomSysOffset);
$nowWeekTime = dgmdate($_G['timestamp'], 'YW',$tomSysOffset);
include DISCUZ_ROOT.'./source/plugin/tom_tchehuoren/class/tom.form.php';
include DISCUZ_ROOT.'./source/plugin/tom_tchehuoren/class/function.admin.php';
include DISCUZ_ROOT.'./source/plugin/tom_tchehuoren/class/tom.upload.php';

$tchehuorenConfig = get_tchehuoren_config($pluginid);
$Lang = formatLang($Lang);
$tongchengPlugin = C::t('#tom_tchehuoren#common_plugin')->fetch_by_identifier('tom_tongcheng');
$tongchengConfig = get_plugin_config($tongchengPlugin['pluginid']);
$appid = trim($tongchengConfig['wxpay_appid']);
$appsecret = trim($tongchengConfig['wxpay_appsecret']);
include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/class/weixin.class.php';
$weixinClass = new weixinClass($appid,$appsecret);
include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/class/templatesms.class.php';

if($_GET['tmod'] == 'index'){
    include DISCUZ_ROOT.'./source/plugin/tom_tchehuoren/admin/index.php';
}else if($_GET['tmod'] == 'level'){
    include DISCUZ_ROOT.'./source/plugin/tom_tchehuoren/admin/level.php';
}else if($_GET['tmod'] == 'levelkaohe'){
    include DISCUZ_ROOT.'./source/plugin/tom_tchehuoren/admin/levelkaohe.php';
}else if($_GET['tmod'] == 'shenqing'){
    include DISCUZ_ROOT.'./source/plugin/tom_tchehuoren/admin/shenqing.php';
}else if($_GET['tmod'] == 'shouyi'){
    include DISCUZ_ROOT.'./source/plugin/tom_tchehuoren/admin/shouyi.php';
}else if($_GET['tmod'] == 'tixian'){
    include DISCUZ_ROOT.'./source/plugin/tom_tchehuoren/admin/tixian.php';
}else if($_GET['tmod'] == 'sendtemplate'){
    include DISCUZ_ROOT.'./source/plugin/tom_tchehuoren/admin/sendtemplate.php';
}else if($_GET['tmod'] == 'problem'){
    include DISCUZ_ROOT.'./source/plugin/tom_tchehuoren/admin/problem.php';
}else if($_GET['tmod'] == 'addon'){
    include DISCUZ_ROOT.'./source/plugin/tom_tchehuoren/admin/addon.php';
}else{
    include DISCUZ_ROOT.'./source/plugin/tom_tchehuoren/admin/index.php';
}


