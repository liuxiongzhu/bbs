<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$tomhash = mt_rand(111111, 999999);
$_SESSION['tomhash'] = $tomhash;

$vid      = isset($_GET['vid'])? intval($_GET['vid']):0;
$size     = isset($_GET['size'])? intval($_GET['size']):0;

$voteInfo = C::t('#tom_weixin_vote#tom_weixin_vote')->fetch_by_id($vid);

$cookieItemid = getcookie('tom_wx_vote_vid'.$vid.'_itemid');
if(!$cookieItemid){
    if($_SESSION['tom_wx_vote_vid'.$vid.'_itemid']){
        $cookieItemid = $_SESSION['tom_wx_vote_vid'.$vid.'_itemid'];
    }
}
if($cookieItemid && $cookieItemid > 0){
    $itemInfo = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_by_id($cookieItemid);
    if($itemInfo){
        tomheader('location:'.$_G['siteurl']."plugin.php?id=tom_weixin_vote&mod=edit&vid={$vid}&itemid={$cookieItemid}");
        exit;
    }
}

$uploadUrl = "plugin.php?id=tom_weixin_vote&mod=upload&act=avatar&formhash=".FORMHASH;
$saveUrl = "plugin.php?id=tom_weixin_vote&mod=save";
$loginUrl = "plugin.php?id=tom_weixin_vote&mod=login&vid={$vid}";

$voteBgColor = $bgColorArray[$voteInfo['style_id']]['value'];

if(!empty($voteInfo['pic_err_msg'])){
    $voteInfo['pic_err_msg'] = discuzcode($voteInfo['pic_err_msg'], 0, 0, 0, 1, 1, 1, 0, 0, 0, 0);
}

$formhash = FORMHASH;
$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === false && $voteConfig['open_in_wx'] == 1) {
    include template("tom_weixin_vote:weixin"); 
}else{
    include template("tom_weixin_vote:add");  
}
tomoutput();
