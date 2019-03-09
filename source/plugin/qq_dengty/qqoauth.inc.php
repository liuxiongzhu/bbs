<?php

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

//提示需要安装一些扩展。避免问题。mb_str扩展。

global $_G;

loadcache('plugin');
$var = $_G['cache']['plugin'];
$appid = $var['qq_dengty']['appid'];
$appkey = $var['qq_dengty']['key'];
$referer = dreferer();
dsetcookie('con_request_uri', $referer);

$callback = $_G['siteurl'] . 'plugin.php?id=qq_dengty:qqoauth_callback' . '&referer=' . urlencode($referer) . (!empty($_GET['isqqshow']) ? '&isqqshow=yes' : '');

if (defined('IN_MOBILE') || $_GET['oauth_style'] == 'mobile') {
    $callback .= '&display=mobile';
}


require_once("source/plugin/qq_dengty/API/qqConnectAPI.php");

$qc = new QC();
$qc->set_config($appid, $appkey, $callback);
$qc->qq_login();
