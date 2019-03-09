<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$tomhash = mt_rand(111111, 999999);
$_SESSION['tomhash'] = $tomhash;

$vid      = isset($_GET['vid'])? intval($_GET['vid']):0;
$itemid      = isset($_GET['itemid'])? intval($_GET['itemid']):0;
$size     = isset($_GET['size'])? intval($_GET['size']):0;
$psize     = isset($_GET['psize'])? intval($_GET['psize']):0;

$cookieItemid = getcookie('tom_wx_vote_vid'.$vid.'_itemid');
if(!$cookieItemid){
    if($_SESSION['tom_wx_vote_vid'.$vid.'_itemid']){
        $cookieItemid = $_SESSION['tom_wx_vote_vid'.$vid.'_itemid'];
    }
}
if(!$cookieItemid){
    tomheader('location:'.$_G['siteurl']."plugin.php?id=tom_weixin_vote&mod=add&vid={$vid}");
    exit;
}
if($cookieItemid && $cookieItemid > 0 && $cookieItemid != $itemid){
    tomheader('location:'.$_G['siteurl']."plugin.php?id=tom_weixin_vote&mod=edit&vid={$vid}&itemid={$cookieItemid}");
    exit;
}

$voteInfo = C::t('#tom_weixin_vote#tom_weixin_vote')->fetch_by_id($vid);
$itemInfo = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_by_id($itemid);

if(!preg_match('/^http:/', $itemInfo['pic_url']) ){
    $item_pic_url = (preg_match('/^http:/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$itemInfo['pic_url'];
}else{
    $item_pic_url = $itemInfo['pic_url'];
}

$photoListTmp = C::t('#tom_weixin_vote#tom_weixin_vote_photo')->fetch_all_list(" AND vote_id={$vid} AND item_id={$itemid} ","ORDER BY add_time DESC",0,20);
$photoCount = C::t('#tom_weixin_vote#tom_weixin_vote_photo')->fetch_all_count(" AND vote_id={$vid} AND item_id={$itemid} ");
$photoList = array();
if(is_array($photoListTmp) && !empty($photoListTmp)){
    foreach ($photoListTmp as $key => $value){
        $photoList[$key] = $value;
        if(!preg_match('/^http:/', $value['pic_url']) ){
            $pic_url = (preg_match('/^http:/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$value['pic_url'];
        }else{
            $pic_url = $value['pic_url'];
        }
        $photoList[$key]['pic_url'] = $pic_url;
        $photoList[$key]['delurl'] = $_G['siteurl']."plugin.php?id=tom_weixin_vote&mod=save&act=delphoto&vid={$vid}&itemid={$itemid}&photoid={$value['id']}&formhash=".FORMHASH."&tomhash={$tomhash}";
    }
}

$over_pic_num = 0;
if($photoCount >= $voteConfig['pic_num']){
    $over_pic_num = 1;
}

$saveUrl = "plugin.php?id=tom_weixin_vote&mod=save";
$uploadUrl1 = "plugin.php?id=tom_weixin_vote&mod=upload&act=avatar&formhash=".FORMHASH;
$uploadUrl2 = "plugin.php?id=tom_weixin_vote&mod=upload&act=photo&vid={$vid}&itemid={$itemid}&formhash=".FORMHASH;

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
    include template("tom_weixin_vote:edit");  
}
tomoutput();
