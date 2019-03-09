<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$LangTmp = $scriptlang['tom_xiaofenlei'];
$adminBaseUrl = ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=tom_xiaofenlei&pmod=admin'; 
$adminListUrl = 'action=plugins&operation=config&do='.$pluginid.'&identifier=tom_xiaofenlei&pmod=admin';
$adminFromUrl = 'plugins&operation=config&do=' . $pluginid . '&identifier=tom_xiaofenlei&pmod=admin';

$tomSysOffset = getglobal('setting/timeoffset');

$pluginVarList = C::t('common_pluginvar')->fetch_all_by_pluginid($pluginid);
$xiaofenleiConfig = array();
foreach ($pluginVarList as $vark => $varv){
    $xiaofenleiConfig[$varv['variable']] = $varv['value'];
}

$Lang  = array();
if(is_array($LangTmp) && !empty($LangTmp)){
    foreach ($LangTmp as $key => $value){
        $Lang[$key] = htmlspecialchars_decode($value);
    }
}

include DISCUZ_ROOT.'./source/plugin/tom_xiaofenlei/class/tom.form.php';
include DISCUZ_ROOT.'./source/plugin/tom_xiaofenlei/class/function.admin.php';

if($_GET['tmod'] == 'index'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_xiaofenlei/admin/user.php';
    
}else if($_GET['tmod'] == 'sites'){
    
    if(file_exists(DISCUZ_ROOT.'./source/plugin/tom_xiaofenlei/admin/sites1000.php')){
        include DISCUZ_ROOT.'./source/plugin/tom_xiaofenlei/admin/sites1000.php';
    }else if(file_exists(DISCUZ_ROOT.'./source/plugin/tom_xiaofenlei/admin/sites100.php')){
        include DISCUZ_ROOT.'./source/plugin/tom_xiaofenlei/admin/sites100.php';
    }else if(file_exists(DISCUZ_ROOT.'./source/plugin/tom_xiaofenlei/admin/sites50.php')){
        include DISCUZ_ROOT.'./source/plugin/tom_xiaofenlei/admin/sites50.php';
    }else if(file_exists(DISCUZ_ROOT.'./source/plugin/tom_xiaofenlei/admin/sites30.php')){
        include DISCUZ_ROOT.'./source/plugin/tom_xiaofenlei/admin/sites30.php';
    }else if(file_exists(DISCUZ_ROOT.'./source/plugin/tom_xiaofenlei/admin/sites10.php')){
        include DISCUZ_ROOT.'./source/plugin/tom_xiaofenlei/admin/sites10.php';
    }else{
        include DISCUZ_ROOT.'./source/plugin/tom_xiaofenlei/admin/nosites.php';
    }
    
}else{
    
    include DISCUZ_ROOT.'./source/plugin/tom_xiaofenlei/admin/user.php';
    
}