<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$vid      = isset($_GET['vid'])? intval($_GET['vid']):0;

$voteInfo = C::t('#tom_weixin_vote#tom_weixin_vote')->fetch_by_id($vid);

if(!preg_match('/^http:/', $voteInfo['pic_url']) ){
    $vote_pic_url = (preg_match('/^http:/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$voteInfo['pic_url'];
}else{
    $vote_pic_url = $voteInfo['pic_url'];
}

if(!preg_match('/^http:/', $voteInfo['focus_pic1']) ){
    $vote_focus_pic1 = (preg_match('/^http:/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$voteInfo['focus_pic1'];
}else{
    $vote_focus_pic1 = $voteInfo['focus_pic1'];
}

if(!preg_match('/^http:/', $voteInfo['focus_pic2']) ){
    $vote_focus_pic2 = (preg_match('/^http:/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$voteInfo['focus_pic2'];
}else{
    $vote_focus_pic2 = $voteInfo['focus_pic2'];
}

if(!preg_match('/^http:/', $voteInfo['focus_pic3']) ){
    $vote_focus_pic3 = (preg_match('/^http:/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$voteInfo['focus_pic3'];
}else{
    $vote_focus_pic3 = $voteInfo['focus_pic3'];
}

$phb_num = 100;
if($voteConfig['phb_num'] > 0){
    $phb_num = $voteConfig['phb_num'];
}

$itemListTmp = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_all_list(" AND vote_id={$vid} AND status!=1 ","ORDER BY num DESC,id ASC ",0,$phb_num);

$itemList = array();
$i = 1;
if(is_array($itemListTmp) && !empty($itemListTmp)){
    foreach ($itemListTmp as $key => $value){
        $itemList[$key] = $value;
        $itemList[$key]['ph'] = $i;
        $itemList[$key]['class'] = "";
        $itemList[$key]['url'] = "plugin.php?id=tom_weixin_vote&mod=info&vid={$vid}&tid={$value['id']}";
        if($i%2 == 0){
            $itemList[$key]['class'] = "two";
        }
        if($i<11){
            $itemList[$key]['class'] = $itemList[$key]['class']." top";
        }
        $i++;
    }
}

if(isset($_GET['from']) && !empty($_GET['from'])){
    $_SESSION['must_gz'] = 1;
}else{
    if(!isset($_GET['nav'])){
        $_SESSION['must_gz'] = 0;
    }
}

$ajaxClicksUrl = "plugin.php?id=tom_weixin_vote&mod=save&act=clicks&formhash=".FORMHASH."&vid={$vid}";

$voteBgColor = $bgColorArray[$voteInfo['style_id']]['value'];

$formhash = FORMHASH;
$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === false && $voteConfig['open_in_wx'] == 1) {
    include template("tom_weixin_vote:weixin"); 
}else{
    include template("tom_weixin_vote:phb");  
}
tomoutput();
