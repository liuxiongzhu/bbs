<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

session_start();
define('TPL_DEFAULT', true);
$voteConfig = $_G['cache']['plugin']['tom_weixin_vote'];
$tomSysOffset = getglobal('setting/timeoffset');
$uSiteUrl = urlencode($_G['siteurl']);
$appid = trim($voteConfig['vote_appid']);  
$appsecret = trim($voteConfig['vote_appsecret']);
require_once libfile('function/discuzcode');
$cssJsVersion = "20160815";

$_G['siteshareurl'] = $_G['siteurl'];

if(file_exists(DISCUZ_ROOT.'./source/plugin/tom_hosts/hosts.php') && $voteConfig['open_hosts'] == 1){
    include DISCUZ_ROOT.'./source/plugin/tom_hosts/hosts.php';
}

$open_tousu = 0;
$tousuUrl = 'javascript:void(0);';
if(file_exists(DISCUZ_ROOT.'./source/plugin/tom_tousu/tom_tousu.inc.php') && $voteConfig['open_tousu'] == 1){
    $open_tousu = 1;
    $tousuUrl = $_G['siteurl']."plugin.php?id=tom_tousu";
}

$searchUrl = "plugin.php?id=tom_weixin_vote&mod=save&act=get_search_url";

$voteConfig['check_code_id'] = trim($voteConfig['check_code_id']);

if (CHARSET == 'gbk') {
    include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/config/config.gbk.php';
}else{
    include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/config/config.utf8.php';
}

include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/link.func.php';

if($_GET['mod'] == 'index'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/weixin.class.php';
    $weixinClass = new weixinClass($appid,$appsecret);
    $wxJssdkConfig = $weixinClass->get_jssdk_config();
    
    include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/module/index.php';
    
}else if($_GET['mod'] == 'info'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/weixin.class.php';
    $weixinClass = new weixinClass($appid,$appsecret);
    $wxJssdkConfig = $weixinClass->get_jssdk_config();
    
    include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/module/info.php';
    
}else if($_GET['mod'] == 'phb'){
    include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/module/phb.php';
    
}else if($_GET['mod'] == 'add'){
    include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/module/add.php';
    
}else if($_GET['mod'] == 'edit'){
    include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/module/edit.php';
    
}else if($_GET['mod'] == 'login'){
    include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/module/login.php';
    
}else if($_GET['mod'] == 'save'){
    include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/module/save.php';
}else if($_GET['mod'] == 'upload'){
    include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/module/upload.php';
}else{
    
    include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/weixin.class.php';
    $weixinClass = new weixinClass($appid,$appsecret);
    $wxJssdkConfig = $weixinClass->get_jssdk_config();
    
    include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/module/index.php';
}
