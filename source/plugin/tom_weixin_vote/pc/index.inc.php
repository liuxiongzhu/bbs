<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$_G['setting']['switchwidthauto']=0;
$_G['setting']['allowwidthauto']=1;

$vid      = isset($_GET['vid'])? intval($_GET['vid']):0;
$page     = isset($_GET['page'])? intval($_GET['page']):1;
$hotid     = isset($_GET['hotid'])? intval($_GET['hotid']):0;

$voteInfo = C::t('#tom_weixin_vote#tom_weixin_vote')->fetch_by_id($vid);
if(!$voteInfo){
    $voteList = C::t('#tom_weixin_vote#tom_weixin_vote')->fetch_all_list("","ORDER BY id DESC",0,1);
    $voteInfo = $voteList['0'];
    $vid = $voteInfo['id'];
}

$start_time = dgmdate($voteInfo['start_time'],"Y-m-d",$tomSysOffset);
$end_time = dgmdate($voteInfo['end_time'],"Y-m-d",$tomSysOffset);

$pagesize = 15;
$start = ($page-1)*$pagesize;

$orderStr = "ORDER BY add_time DESC";
if($hotid){
    $orderStr = "ORDER BY num DESC";
}

$where = " AND vote_id={$vid} AND status!=1 ";

$itemListTmp = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_all_list($where,$orderStr,$start,$pagesize);
$itemListCount = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_all_count($where);

$itemList = array();
if(is_array($itemListTmp) && !empty($itemListTmp)){
    foreach ($itemListTmp as $key => $value){
        $itemList[$key] = $value;
        if(!preg_match('/^http:/', $value['pic_url']) ){
            $item_pic_url = (preg_match('/^http:/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$value['pic_url'];
        }else{
            $item_pic_url = $value['pic_url'];
        }
        $itemList[$key]['pic_url'] = $item_pic_url;
    }
}
$paging = helper_page :: multi($itemListCount, $pagesize, $page, "plugin.php?id=tom_weixin_vote:pc&mod=index&vid={$vid}&hotid={$hotid}", 0, 11, false, false);

$navtitle = $voteInfo['title'];
$metakeywords =  $voteInfo['title'];
$metadescription = $voteInfo['title'];

$voteBgColor = $bgColorArray[$voteInfo['style_id']]['value'];

include template("tom_weixin_vote:pc/index");

