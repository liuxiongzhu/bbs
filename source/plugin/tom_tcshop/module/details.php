<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$tcshop_id = intval($_GET['tcshop_id'])>0? intval($_GET['tcshop_id']):0;
$tab = intval($_GET['tab'])>0? intval($_GET['tab']):1;

$tcshopInfo = C::t('#tom_tcshop#tom_tcshop')->fetch_by_id($tcshop_id);
$cateInfo = C::t('#tom_tcshop#tom_tcshop_cate')->fetch_by_id($tcshopInfo['cate_id']);

$photoListTmp = C::t('#tom_tcshop#tom_tcshop_photo')->fetch_all_list(" AND tcshop_id={$tcshop_id} ","ORDER BY id ASC",0,10);
$photoList = $photoThumbList = array();
if(is_array($photoListTmp) && !empty($photoListTmp)){
    foreach ($photoListTmp as $key => $value){
        if(!preg_match('/^http/', $value['picurl']) ){
            if(strpos($value['picurl'], 'source/plugin/tom_tcshop/') === FALSE){
                $picurlTmp = (preg_match('/^http:/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'tomwx/'.$value['picurl'];
            }else{
                $picurlTmp = $value['picurl'];
            }
        }else{
            $picurlTmp = $value['picurl'];
        }
        
        $photoList[$key] = $value;
        $photoList[$key]['picurl'] = $picurlTmp;
        
        if(file_exists(DISCUZ_ROOT.'./'.$value['thumb'])){
            $photoThumbList[$key] = $value;
        }
    }
}

$gonggao = $tcshopInfo['gonggao'];
$content = stripslashes($tcshopInfo['content']);

$contentTmp = strip_tags($content);
$contentTmp = str_replace("\r\n","",$contentTmp);
$contentTmp = str_replace("\n","",$contentTmp);
$contentTmp = str_replace("\r","",$contentTmp);

//$content = str_replace("\r\n","<br/>",$content);
//$content = str_replace("\n","<br/>",$content);
//$content = str_replace("\r","<br/>",$content);

if(!preg_match('/^http/', $tcshopInfo['picurl']) ){
    if(strpos($tcshopInfo['picurl'], 'source/plugin/tom_tcshop/') === FALSE){
        $picurl = (preg_match('/^http:/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'tomwx/'.$tcshopInfo['picurl'];
    }else{
        $picurl = $tcshopInfo['picurl'];
    }
}else{
    $picurl = $tcshopInfo['picurl'];
}

if(!preg_match('/^http/', $tcshopInfo['kefu_qrcode']) ){
    if(strpos($tcshopInfo['kefu_qrcode'], 'source/plugin/tom_tcshop/') === FALSE){
        $kefu_qrcode = (preg_match('/^http:/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'tomwx/'.$tcshopInfo['kefu_qrcode'];
    }else{
        $kefu_qrcode = $tcshopInfo['kefu_qrcode'];
    }
}else{
    $kefu_qrcode = $tcshopInfo['kefu_qrcode'];
}

## video_url start
$video_type = '';
$video_id = '';
$video_url = $tcshopInfo['video_url'];
if(strpos($video_url, 'youku.com') !== FALSE){
    preg_match("#sid/(.*)/v.swf#", $video_url, $matches);
    if(is_array($matches) && !empty($matches['1'])){
        $video_type = 'youku';
        $video_id = trim($matches['1']);
    }
}else if(strpos($video_url, 'qq.com') !== FALSE){
    preg_match("#vid=([0-9a-zA-Z]*)#", $video_url, $matches);
    if(is_array($matches) && !empty($matches['1'])){
        $video_type = 'qq';
        $video_id = trim($matches['1']);
    }
}
## video_url end

$topShowBox = 0;
if($tcshopInfo['vip_level'] > 0){
    if($video_type == 'youku'){
        $topShowBox = 2;
    }else if($video_type == 'qq'){
        $topShowBox = 3;
    }else if(!empty ($tcshopInfo['video_url'])){
        $topShowBox = 4;
    }
}

## pinglun start
if($tab == 4){
    
    $open_edit_pinglun = 0;
    if($tcshopInfo['user_id'] == $__UserInfo['id'] && $tongchengConfig['open_fbr_remove_pinglun'] == 1){
        $open_edit_pinglun = 1;
    }else if($__UserInfo['groupid'] == 1 && $site_id == 1){
        $open_edit_pinglun = 1;
    }else if($__UserInfo['groupid'] == 2 && $site_id == $__UserInfo['groupsiteid']){
        $open_edit_pinglun = 1;
    }
    
    $pinglunListTmp = C::t('#tom_tcshop#tom_tcshop_pinglun')->fetch_all_list(" AND tcshop_id = {$tcshopInfo['id']} ", 'ORDER BY ping_time DESC,id DESC', 0, 5);
    $pinglunList = array();
    if(is_array($pinglunListTmp) && !empty($pinglunListTmp)){
        foreach($pinglunListTmp as $key => $value){
            $pinglunList[$key] = $value;
            $pinglunList[$key]['content'] = qqface_replace(dhtmlspecialchars($value['content']));
            $pinglunList[$key]['userInfo'] = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($value['user_id']);
            $pinglunList[$key]['reply_list'] = '';
            $replyListTmp = C::t('#tom_tcshop#tom_tcshop_pinglun_reply')->fetch_all_list(" AND tcshop_id = {$tcshopInfo['id']} AND ping_id = {$value['id']} ", "ORDER BY reply_time ASC,id ASC", 0, 1000);
            if(is_array($replyListTmp) && !empty($replyListTmp)){
                foreach($replyListTmp as $k => $v){
                    if($tcshopInfo['user_id'] == $v['reply_user_id']){
                        $pinglunList[$key]['reply_list'].= '<div class="comment-item-content-text" id="comment-item-content-text_'.$v['id'].'"><span>'.$v['reply_user_nickname'].'&nbsp;<span class="floor_main">'.lang('plugin/tom_tcshop', 'info_pinglun_floor_main').'</span>'.lang('plugin/tom_tcshop','pinglun_hueifu_dian').'&nbsp;</span>'.qqface_replace(dhtmlspecialchars($v['content'])).'&nbsp;&nbsp;<span class="remove" onClick="removeReply('.$v['id'].');">'.lang('plugin/tom_tcshop','info_comment_del').'</span></div>'; 
                    }else{
                        $pinglunList[$key]['reply_list'].= '<div class="comment-item-content-text" id="comment-item-content-text_'.$v['id'].'"><span>'.$v['reply_user_nickname'].lang('plugin/tom_tcshop','pinglun_hueifu_dian').'&nbsp;</span>'.qqface_replace(dhtmlspecialchars($v['content'])).'&nbsp;&nbsp;<span class="remove" onClick="removeReply('.$v['id'].');">'.lang('plugin/tom_tcshop','info_comment_del').'</span></div>'; 
                    }
                }  
            }
        }
    }
    
    $addPinglunUrl = "plugin.php?id=tom_tcshop:ajax&act=pinglun&formhash=".FORMHASH;
    $showPinglunUrl = "plugin.php?id=tom_tcshop:ajax&act=loadPinglun&tcshop_id={$tcshopInfo['id']}&formhash=".FORMHASH;
    $removePinglunUrl = "plugin.php?id=tom_tcshop:ajax&act=removePinglun&tcshop_id={$tcshopInfo['id']}&formhash=".FORMHASH;
    $removeReplyUrl = "plugin.php?id=tom_tcshop:ajax&act=removeReplyPinglun&tcshop_id={$tcshopInfo['id']}&formhash=".FORMHASH;

}
## pinglun end


$latitude = getcookie('tom_tongcheng_user_latitude');
$longitude = getcookie('tom_tongcheng_user_longitude');
$ajaxDistanceUrl = '';
if(!empty($latitude) && !empty($longitude)){
    $ajaxDistanceUrl = "plugin.php?id=tom_tcshop:ajax&site={$site_id}&act=get_distance&longitude1={$longitude}&latitude1={$latitude}&longitude2={$tcshopInfo['longitude']}&latitude2={$tcshopInfo['latitude']}&formhash=".$formhash;
}

if($tab == 1){
    DB::query("UPDATE ".DB::table('tom_tcshop')." SET clicks=clicks+1 WHERE id='$tcshop_id' ", 'UNBUFFERED');
}

$isGuanzu = 0;
if($__UserInfo){
    $guanzuListTmp = C::t('#tom_tcshop#tom_tcshop_guanzu')->fetch_all_list(" AND user_id={$__UserInfo['id']} AND tcshop_id={$tcshop_id} "," ORDER BY id DESC ",0,1);
    if(is_array($guanzuListTmp) && !empty($guanzuListTmp)){
        $isGuanzu = 1;
    }
}

$baiduMapFromName = lang('plugin/tom_tcshop', 'wodeweizhi');
//$baiduMapFromName = diconv($baiduMapFromName, CHARSET, 'utf-8');
$baiduMapFromName = urlencode($baiduMapFromName);
$baiduMapToName = $tcshopInfo['name'];
$baiduMapToName = diconv($baiduMapToName, CHARSET, 'utf-8');
$baiduMapToName = urlencode($baiduMapToName);
$baiduMapRegion = lang('plugin/tom_tcshop', 'china');
//$baiduMapRegion = diconv($baiduMapRegion, CHARSET, 'utf-8');
$baiduMapRegion = urlencode($baiduMapRegion);
//$baiduMapUrl = "https://api.map.baidu.com/direction?origin=latlng:{$latitude},{$longitude}|name:{$baiduMapFromName}&destination=latlng:{$tcshopInfo['latitude']},{$tcshopInfo['longitude']}|name:{$baiduMapToName}&mode=driving&output=html&region={$baiduMapRegion}&src=tomwx|tongcheng";
$baiduMapUrl = "http://api.map.baidu.com/marker?location={$tcshopInfo['latitude']},{$tcshopInfo['longitude']}&title={$baiduMapToName}&content=&output=html";

$ajaxDetailsLoadListUrl = "plugin.php?id=tom_tcshop:ajax&site={$site_id}&act=list&no_tcshop_id={$tcshopInfo['id']}&cate_id={$tcshopInfo['cate_id']}&ordertype=lbs&formhash=".$formhash;

$fabuFlUrl = "plugin.php?id=tom_tongcheng&site={$site_id}&mod=fabu&model_id=";
$ajaxLoadFlListUrl = 'plugin.php?id=tom_tongcheng:ajax&site='.$site_id.'&user_id='.$tcshopInfo['user_id'].'&act=list&formhash='.$formhash;
$ajaxCollectFlUrl = 'plugin.php?id=tom_tongcheng:ajax&site='.$site_id.'&act=collect&formhash='.$formhash;
$ajaxClicksFlUrl = 'plugin.php?id=tom_tongcheng:ajax&site='.$site_id.'&act=clicks&formhash='.$formhash.'&tongcheng_id=';

$ajaxGuanzuUrl = 'plugin.php?id=tom_tcshop:ajax&site='.$site_id.'&act=guanzu&formhash='.$formhash;
$ajaxZhuanfaUrl = 'plugin.php?id=tom_tcshop:ajax&site='.$site_id.'&act=zhuanfa&tcshop_id='.$tcshop_id.'&formhash='.FORMHASH;


$shareTitle = str_replace("{TITLE}",$tcshopInfo['name'], $tcshopConfig['details_share_title']);
$shareTitle = str_replace("{SITENAME}",$__SitesInfo['name'], $shareTitle);
$shareLogo = $picurl;
$shareDesc = cutstr($contentTmp,80,"...");
$shareUrl   = $_G['siteurl']."plugin.php?id=tom_tcshop&site={$site_id}&mod=details&tcshop_id=".$tcshop_id;

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
include template("tom_tcshop:details");




