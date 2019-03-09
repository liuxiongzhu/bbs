<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$TOMCLOUDHOST = "http://discuzapi.tomwx.cn";
$urlBaseUrl = $_G['siteurl'].ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=tom_weixin_vote&pmod='; 
dheader('location:'.$TOMCLOUDHOST.'/api/addon.php?ver=10&addonId=tom_weixin_vote&baseUrl='.urlencode($urlBaseUrl));
