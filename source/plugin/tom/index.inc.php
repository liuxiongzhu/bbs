<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$urlBaseUrl = $_G['siteurl'].ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=tom&pmod='; 
dheader('location:http://discuzapi.tomwx.cn/api/tom_index.php?ver=60&addonId=tom&baseUrl='.urlencode($urlBaseUrl));
?>