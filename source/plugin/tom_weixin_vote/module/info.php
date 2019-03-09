<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$tomhash = mt_rand(111111, 999999);
$_SESSION['tomhash'] = $tomhash;

$vid      = isset($_GET['vid'])? intval($_GET['vid']):0;
$tid      = isset($_GET['tid'])? intval($_GET['tid']):0;

$voteInfo = C::t('#tom_weixin_vote#tom_weixin_vote')->fetch_by_id($vid);

# oauth2_check start
if($voteConfig['open_openid'] == 0 && $voteConfig['oauth2_check'] == 1){
    
    $openid = getcookie('tom_wx_vote_vid'.$vid.'_oauth2_openid');
    if(!$openid){
        if($_SESSION['tom_wx_vote_vid'.$vid.'_oauth2_openid']){
            $openid = $_SESSION['tom_wx_vote_vid'.$vid.'_oauth2_openid'];
        }
    }
    if(empty($openid)){
        include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/oauth2.php';
        $subuserfilename = DISCUZ_ROOT.'./source/plugin/tom_weixin/table/table_tom_weixin_subuser.php';
        if(file_exists($subuserfilename)){
            $subuser = C::t('#tom_weixin#tom_weixin_subuser')->fetch_by_openid($openid);
            if(!$subuser){
                $subData = array();
                $subData['open_id'] = $openid;
                $subData['sub_time'] = TIMESTAMP;
                C::t('#tom_weixin#tom_weixin_subuser')->insert($subData);
                
                $lifeTime = 86400*30;
                $_SESSION['tom_wx_vote_vid'.$vid.'_oauth2_openid'] = $openid;
                dsetcookie('tom_wx_vote_vid'.$vid.'_oauth2_openid',$openid,$lifeTime);
            }else{
                $lifeTime = 86400*30;
                $_SESSION['tom_wx_vote_vid'.$vid.'_oauth2_openid'] = $openid;
                dsetcookie('tom_wx_vote_vid'.$vid.'_oauth2_openid',$openid,$lifeTime);
            }
        }
    }
    
    if(!empty($openid)){
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
    }
}
# oauth2_check end

$itemInfo = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_by_id($tid);
if(!$itemInfo){
    $itemList = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_all_list("","ORDER BY id DESC",0,1);
    $itemInfo = $itemList['0'];
    $tid = $itemInfo['id'];
}

if(!preg_match('/^http:/', $itemInfo['pic_url']) ){
    $item_pic_url = (preg_match('/^http:/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$itemInfo['pic_url'];
}else{
    $item_pic_url = $itemInfo['pic_url'];
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

if(!preg_match('/^http:/', $voteInfo['pic_url']) ){
    $vote_pic_url = (preg_match('/^http:/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$voteInfo['pic_url'];
}else{
    $vote_pic_url = $voteInfo['pic_url'];
}
if(!preg_match('/^http:/', $voteInfo['guanzu_qrcode']) && !empty($voteInfo['guanzu_qrcode']) ){
    $vote_guanzu_qrcode = (preg_match('/^http:/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$voteInfo['guanzu_qrcode'];
}else{
    $vote_guanzu_qrcode = $voteInfo['guanzu_qrcode'];
}

$itemdesc = stripslashes($itemInfo['desc']);
$prize_txt = stripslashes($voteInfo['prize_txt']);
$content = stripslashes($voteInfo['content']);
$adsText = stripslashes($voteInfo['ads_text']);
$guanzu_desc = discuzcode($voteInfo['guanzu_desc'], 0, 0, 0, 1, 1, 1, 0, 0, 0, 0);

$photoListTmp = C::t('#tom_weixin_vote#tom_weixin_vote_photo')->fetch_all_list(" AND vote_id={$vid} AND item_id={$tid} ","ORDER BY add_time DESC",0,20);
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
    }
}else{
    $photoList[1]['pic_url'] = $item_pic_url;
}

$ajaxUrl = "plugin.php?id=tom_weixin_vote&mod=save";

$cookieUserid = getcookie('tom_wx_vote_vid'.$vid.'_userid');
if(!$cookieUserid){
    if($_SESSION['tom_wx_vote_vid'.$vid.'_userid']){
        $cookieUserid = $_SESSION['tom_wx_vote_vid'.$vid.'_userid'];
    }
}
$showBtnBox = 1;
$showUserId = 0;
$ajaxTpUrl = "";
if($cookieUserid && $cookieUserid > 0){
    $cookieUserInfo = C::t('#tom_weixin_vote#tom_weixin_vote_user')->fetch_by_id($cookieUserid);
    if($cookieUserInfo){
        $showBtnBox = 2;
        $ajaxTpUrl = "plugin.php?id=tom_weixin_vote&mod=save&act=tp&formhash=".FORMHASH."&tomhash={$tomhash}&vid={$vid}&tid={$tid}&userid={$cookieUserid}";
        
        if($voteInfo['cj_status'] == 1 && $voteInfo['must_tel'] == 1 && $cookieUserInfo['tel'] == 0 ){
            $showBtnBox = 1;
            $showUserId = 1;
        }
        
    }
    
}

$ajaxCjUrl = "plugin.php?id=tom_weixin_vote&mod=save&act=cj&formhash=".FORMHASH."&vid={$vid}";

$subuserfilename = DISCUZ_ROOT.'./source/plugin/tom_weixin/table/table_tom_weixin_subuser.php';
if(file_exists($subuserfilename) && ($voteInfo['must_tel'] == 0 || $voteConfig['open_openid'] == 1)){
    $cookieOpenid = getcookie('tom_wx_vote_vid'.$vid.'_openid');
    if($cookieOpenid){
        $subuser = C::t('#tom_weixin#tom_weixin_subuser')->fetch_by_openid($cookieOpenid);
        if($subuser){
            if(isset($_GET['from'])){
                unset($_GET['from']);
            }
            $_SESSION['must_gz'] = 0;
        }else{
            $_GET['from'] = 'share';
            $_SESSION['must_gz'] = 1;
        }
    }
}

$show_add_link = 1;
if(isset($_GET['from']) && !empty($_GET['from'])){
    //$show_add_link = 0;
    $_SESSION['must_gz'] = 1;
    if($voteInfo['must_gz'] == 1){
        $showBtnBox = 3;
    }
}
if($_SESSION['must_gz'] == 1){
    //$show_add_link = 0;
    if($voteInfo['must_gz'] == 1){
        $showBtnBox = 3;
    }
}

if($voteInfo['must_tel'] == 0 || $voteConfig['open_openid'] == 1){
    $cookieOpenid = getcookie('tom_wx_vote_vid'.$vid.'_openid');
    if(!$cookieOpenid){
        $showBtnBox = 3;
    }
}

if($voteInfo['bm_status'] == 0){
    $show_add_link = 0;
}

if(TIMESTAMP < $voteInfo['start_time']){
    $showBtnBox = 4;
}

if(TIMESTAMP > $voteInfo['end_time']){
    $showBtnBox = 5;
}

if($itemInfo['status'] == 1){
    $voteInfo['close_webtp'] = 0;
}

$shareTitle = str_replace("{NAME}",$itemInfo['name'],$voteInfo['share_title']);
$shareTitle = str_replace("{NO}",$itemInfo['no'],$shareTitle);
$shareDesc = $voteInfo['share_desc'];
$share_logo = $item_pic_url;
$shareLogo = $item_pic_url;
$shareUrl = $_G['siteshareurl']."plugin.php?id=tom_weixin_vote&mod=info&vid=$vid&tid=$tid";

$ajaxClicksUrl = "plugin.php?id=tom_weixin_vote&mod=save&act=clicks&formhash=".FORMHASH."&vid={$vid}";

$bianhao_desc = str_replace("{NAME}",$itemInfo['name'],$voteConfig['bianhao_desc']);
$bianhao_desc = str_replace("{NUM}",$itemInfo['no'],$bianhao_desc);
require_once libfile('function/discuzcode');
$bianhao_desc = discuzcode($bianhao_desc, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0);

$voteBgColor = $bgColorArray[$voteInfo['style_id']]['value'];

$formhash = FORMHASH;
$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === false && $voteConfig['open_in_wx'] == 1) {
    include template("tom_weixin_vote:weixin"); 
}else{
    include template("tom_weixin_vote:info");  
}
tomoutput();