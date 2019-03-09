<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$vid      = isset($_GET['vid'])? intval($_GET['vid']):0;
$page     = isset($_GET['page'])? intval($_GET['page']):1;
$keywords     = isset($_GET['keywords'])? addslashes(urldecode($_GET['keywords'])):"";
$openid     = isset($_GET['openid'])? addslashes($_GET['openid']):"";

$voteInfo = C::t('#tom_weixin_vote#tom_weixin_vote')->fetch_by_id($vid);
if(!$voteInfo){
    $voteList = C::t('#tom_weixin_vote#tom_weixin_vote')->fetch_all_list("","ORDER BY id DESC",0,1);
    $voteInfo = $voteList['0'];
    $vid = $voteInfo['id'];
}

$openidCheck = false;
if($voteConfig['open_openid'] == 1 && !empty($openid) && $openid != '{openid}'){
    $subuserfilename = DISCUZ_ROOT.'./source/plugin/tom_weixin/table/table_tom_weixin_subuser.php';
    if(file_exists($subuserfilename)){
        $subuser = C::t('#tom_weixin#tom_weixin_subuser')->fetch_by_openid($openid);
        if($subuser){
            $openidCheck = true;
        }
    }
}

if($voteConfig['open_openid'] == 1 && $openidCheck ){
    $userInfoTmp = C::t('#tom_weixin_vote#tom_weixin_vote_user')->fetch_by_vid_openid($vid,$openid);
    if($userInfoTmp){
        $lifeTime = 86400*30;
        $_SESSION['tom_wx_vote_vid'.$vid.'_userid'] = $userInfoTmp['id'];
        dsetcookie('tom_wx_vote_vid'.$vid.'_userid',$userInfoTmp['id'],$lifeTime);
    }else if($voteInfo['must_tel'] == 0){
        $insertData = array();
        $insertData['vote_id']      = $vid;
        $insertData['xm']           = $openid;
        $insertData['tel']          = '0';
        $insertData['part1']        = $openid;
        $insertData['add_time']     = TIMESTAMP;
        if(C::t('#tom_weixin_vote#tom_weixin_vote_user')->insert($insertData)){
            $userid = C::t('#tom_weixin_vote#tom_weixin_vote_user')->insert_id();
            $lifeTime = 86400*30;
            $_SESSION['tom_wx_vote_vid'.$vid.'_userid'] = $userid;
            dsetcookie('tom_wx_vote_vid'.$vid.'_userid',$userid,$lifeTime);
        }
    }
    $lifeTime = 86400*30;
    $_SESSION['tom_wx_vote_vid'.$vid.'_openid'] = $openid;
    dsetcookie('tom_wx_vote_vid'.$vid.'_openid',$openid,$lifeTime);
    tomheader('location:'.$_G['siteurl']."plugin.php?id=tom_weixin_vote&vid={$vid}");exit;
}



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

if(!preg_match('/^http:/', $voteInfo['share_logo']) ){
    $share_logo_url = (preg_match('/^http:/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$voteInfo['share_logo'];
}else{
    $share_logo_url = $voteInfo['share_logo'];
}

$itemCount = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_all_count(" AND vote_id={$vid} AND status!=1 ");
$allNum = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_all_sun(" AND vote_id={$vid} AND status!=1 ");

$start_time = dgmdate($voteInfo['start_time'],"Y-m-d",$tomSysOffset);
$end_time = dgmdate($voteInfo['end_time'],"Y-m-d",$tomSysOffset);
$prize_txt = stripslashes($voteInfo['prize_txt']);
$content = stripslashes($voteInfo['content']);
$adsText = stripslashes($voteInfo['ads_text']);
$daojishiTimes = $voteInfo['end_time']-TIMESTAMP;

$pagesize = $voteConfig['wx_index_num'];
$start = ($page-1)*$pagesize;	
$where = " AND vote_id={$vid} AND status!=1 ";
$isLike = false;
if(!empty($keywords)){
    if(is_numeric($keywords)){
        $keywords = (int)$keywords;
        $where.=" AND no={$keywords} ";
    }else{
        $isLike = true;
    }
}
if($isLike){
    $itemListCount = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_all_like_count($where,$keywords);
    $itemListTmp = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_all_like_list($where,$keywords,"ORDER BY add_time DESC",$start,$pagesize);
}else{
    $itemListCount = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_all_count($where);
    $itemListTmp = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_all_list($where,"ORDER BY add_time DESC",$start,$pagesize);
}

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
        $itemList[$key]['url'] = "plugin.php?id=tom_weixin_vote&mod=info&vid={$vid}&tid={$value['id']}";
    }
}
$showNextPage = 1;
if(($start + $pagesize) >= $itemListCount){
    $showNextPage = 0;
}
$allPageNum = ceil($itemListCount/$pagesize);
$prePage = $page - 1;
$nextPage = $page + 1;
$prePageUrl = "plugin.php?id=tom_weixin_vote&mod=index&vid={$vid}&page={$prePage}";
$nextPageUrl = "plugin.php?id=tom_weixin_vote&mod=index&vid={$vid}&page={$nextPage}";

$show_add_link = 1;
if(isset($_GET['from']) && !empty($_GET['from'])){
    //$show_add_link = 0;
    $_SESSION['must_gz'] = 1;
}else{
    if(!isset($_GET['nav'])){
        $_SESSION['must_gz'] = 0;
    }
}
if(isset($_SESSION['must_gz']) && $_SESSION['must_gz'] == 1){
    //$show_add_link = 0;
}
if($voteInfo['bm_status'] == 0){
    $show_add_link = 0;
}

$ajaxClicksUrl = "plugin.php?id=tom_weixin_vote&mod=save&act=clicks&formhash=".FORMHASH."&vid={$vid}";

$voteInfo['clicks'] = $voteInfo['clicks'] + $voteInfo['xuni_clicks'];

$shareTitle = $voteInfo['title'];
$shareDesc = $voteInfo['share_desc'];
$shareLogo = $share_logo_url;
$shareUrl = $_G['siteshareurl']."plugin.php?id=tom_weixin_vote&vid={$vid}";

$voteBgColor = $bgColorArray[$voteInfo['style_id']]['value'];

$formhash = FORMHASH;
$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === false && $voteConfig['open_in_wx'] == 1) {
    include template("tom_weixin_vote:weixin");
}else{
    include template("tom_weixin_vote:index");
}

tomoutput();
