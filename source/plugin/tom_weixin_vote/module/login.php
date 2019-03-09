<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$tomhash = mt_rand(111111, 999999);
$_SESSION['tomhash'] = $tomhash;

$vid      = isset($_GET['vid'])? intval($_GET['vid']):0;
$err      = isset($_GET['err'])? intval($_GET['err']):0;

$voteInfo = C::t('#tom_weixin_vote#tom_weixin_vote')->fetch_by_id($vid);

$voteBgColor = $bgColorArray[$voteInfo['style_id']]['value'];

$formhash = FORMHASH;
$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === false && $voteConfig['open_in_wx'] == 1) {
    include template("tom_weixin_vote:weixin"); 
}else{
    include template("tom_weixin_vote:login");  
}

