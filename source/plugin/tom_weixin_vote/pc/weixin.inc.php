<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$tid      = isset($_GET['tid'])? intval($_GET['tid']):0;

require_once libfile('function/discuzcode');
$add_weixin_msg = discuzcode($voteConfig['add_weixin_msg'], 0, 0, 0, 1, 1, 1, 0, 0, 0, 0);

$itemInfo = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_by_id($tid);

$voteInfo = C::t('#tom_weixin_vote#tom_weixin_vote')->fetch_by_id($itemInfo['vote_id']);

$add_weixin_msg = str_replace("{NAME}", $itemInfo['name'], $add_weixin_msg);
$add_weixin_msg = str_replace("{NO}", $itemInfo['no'], $add_weixin_msg);

$voteBgColor = $bgColorArray[$voteInfo['style_id']]['value'];

include template("tom_weixin_vote:pc/weixin");

