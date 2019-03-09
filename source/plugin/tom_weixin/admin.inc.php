<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$tomScriptLang = $scriptlang['tom_weixin'];
$tomSysOffset = getglobal('setting/timeoffset');
$nowYear = dgmdate($_G['timestamp'], 'Y',$tomSysOffset);

$adminBaseUrl = ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=tom_weixin&pmod=admin'; 
$adminListUrl = 'action=plugins&operation=config&do='.$pluginid.'&identifier=tom_weixin&pmod=admin';
$adminFromUrl = 'plugins&operation=config&do=' . $pluginid . '&identifier=tom_weixin&pmod=admin';

$pluginVarList = C::t('common_pluginvar')->fetch_all_by_pluginid($pluginid);
$tomConfig = array();
foreach ($pluginVarList as $vark => $varv){
    $tomConfig[$varv['variable']] = $varv['value'];
}

$tomScriptLangTmp  = array();
if(is_array($tomScriptLang) && !empty($tomScriptLang)){
    foreach ($tomScriptLang as $key => $value){
        $tomScriptLangTmp[$key] = htmlspecialchars_decode($value);
    }
}
$tomScriptLang = $tomScriptLangTmp;


if($_GET['tmod'] == 'api'){
    include DISCUZ_ROOT.'./source/plugin/tom_weixin/admin/api.inc.php';
    
}else if($_GET['tmod'] == 'module'){
    include DISCUZ_ROOT.'./source/plugin/tom_weixin/admin/module.inc.php';
    
}else if($_GET['tmod'] == 'user'){
    include DISCUZ_ROOT.'./source/plugin/tom_weixin/admin/user.inc.php';
    
}else if($_GET['tmod'] == 'subuser'){
    include DISCUZ_ROOT.'./source/plugin/tom_weixin/admin/subuser.inc.php';
    
}else if($_GET['tmod'] == 'menu'){
    include DISCUZ_ROOT.'./source/plugin/tom_weixin/admin/menu.inc.php';
    
}else if($_GET['tmod'] == 'plugin'){
    include DISCUZ_ROOT.'./source/plugin/tom_weixin/admin/plugin.inc.php';
    
}else if($_GET['tmod'] == 'addon'){
    include DISCUZ_ROOT.'./source/plugin/tom_weixin/admin/addon.inc.php';
    
}else{
    include DISCUZ_ROOT.'./source/plugin/tom_weixin/admin/api.inc.php';
}

