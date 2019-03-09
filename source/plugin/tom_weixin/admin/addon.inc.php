<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$TOMCLOUDHOST = "http://discuzapi.tomwx.cn";
$urlBaseUrl = $_G['siteurl'].ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=tom_weixin&pmod='; 
dheader('location:'.$TOMCLOUDHOST.'/api/addon.php?ver=60&addonId=tom_weixin&baseUrl='.  urlencode($urlBaseUrl));
