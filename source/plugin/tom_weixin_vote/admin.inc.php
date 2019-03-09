<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$Lang = $scriptlang['tom_weixin_vote'];
$adminBaseUrl = ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=tom_weixin_vote&pmod=admin'; 
$adminListUrl = 'action=plugins&operation=config&do='.$pluginid.'&identifier=tom_weixin_vote&pmod=admin';
$adminFromUrl = 'plugins&operation=config&do=' . $pluginid . '&identifier=tom_weixin_vote&pmod=admin';
$uSiteUrl = urlencode($_G['siteurl']);
$tomSysOffset = getglobal('setting/timeoffset');

if (CHARSET == 'gbk') {
    include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/config/config.gbk.php';
}else{
    include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/config/config.utf8.php';
}

include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/tom.func.php';
include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/class/vote.core.php';
include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/link.func.php';

$Lang = formatLang($Lang);

if($_GET['tmod'] == 'vote'){
    include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/admin/vote.php';
    
}else if($_GET['tmod'] == 'item'){
    include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/admin/item.php';
    
}else if($_GET['tmod'] == 'user'){
    include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/admin/user.php';
    
}else if($_GET['tmod'] == 'addon'){
    include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/admin/addon.php';
    
}else if($_GET['tmod'] == 'log'){
    include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/admin/log.php';
    
}else{
    include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/admin/vote.php';
}

