<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$act  = isset($_GET['act'])? addslashes($_GET['act']):'';

$ajaxHongbaoTzUrl = 'plugin.php?id=tom_tongcheng:ajax&site='.$site_id.'&act=hongbao_tz&&formhash='.$formhash;


$kefuQrcodeSrc = $tongchengConfig['kefu_qrcode'];
if($__SitesInfo['id'] > 1){
    if(!preg_match('/^http/', $__SitesInfo['kefu_qrcode'])){
        if(strpos($__SitesInfo['kefu_qrcode'], 'source/plugin/tom_tongcheng/') === FALSE){
            $kefuQrcodeSrc = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'tomwx/'.$__SitesInfo['kefu_qrcode'];
        }else{
            $kefuQrcodeSrc = $__SitesInfo['kefu_qrcode'];
        }
    }else{
        $kefuQrcodeSrc = $__SitesInfo['kefu_qrcode'];
    }
}

$hehuorenFcOpen = 0;
if($site_id > 1 && $__SitesInfo['hehuoren_fc_open'] == 1){
    $hehuorenFcOpen = 1;
}else if($site_id == 1){
    $hehuorenFcOpen = 1;
}

$showHehuorenBtn = 0;
if($__ShowTchehuoren == 1){
    $tchehuorenInfoTmp = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_by_user_id($__UserInfo['id']);
    if($tchehuorenInfoTmp){
        $showHehuorenBtn = 1;
    }
}

$showTcshopBtn = 0;
if($__ShowTcshop == 1){
    $tcshopListTmp = C::t('#tom_tcshop#tom_tcshop')->fetch_all_list(" AND user_id={$__UserInfo['id']} "," ORDER BY id DESC ",0,10);
    if(is_array($tcshopListTmp) && !empty($tcshopListTmp)){
        $showTcshopBtn = 1;
    }
}

$__CardInfo = array();
$isVip = 0;
if($__ShowTcyikatong == 1){
    $cardInfoTmp = C::t('#tom_tcyikatong#tom_tcyikatong_card')->fetch_by_user_id($__UserInfo['id']);
    if(is_array($cardInfoTmp) && !empty($cardInfoTmp) && $cardInfoTmp['status'] == 1){
        $isVip = 1;
        $__CardInfo = $cardInfoTmp;
    }
}

## tcmajia start
$openMajiaStatus = 0;
if($__ShowTcmajia == 1 && $tongchengConfig['open_mobile'] == 1 && $ucenterfilenameExists){
    if($tcmajiaConfig['use_majia_admin_1'] == $__UserInfo['id']){
        $openMajiaStatus = 1;
    }
    if($tcmajiaConfig['use_majia_admin_2'] == $__UserInfo['id']){
        $openMajiaStatus = 1;
    }
    if($tcmajiaConfig['use_majia_admin_3'] == $__UserInfo['id']){
        $openMajiaStatus = 1;
    }
    if($tcmajiaConfig['use_majia_admin_4'] == $__UserInfo['id']){
        $openMajiaStatus = 1;
    }
    if($tcmajiaConfig['use_majia_admin_5'] == $__UserInfo['id']){
        $openMajiaStatus = 1;
    }
    if($__UserInfo['is_majia'] == 1){
        $openMajiaStatus = 1;
    }
}
## tcmajia end

$address_back_url = $weixinClass->get_url();
$address_back_url = urlencode($address_back_url);

$ajaxLoginOutUrl = 'plugin.php?id=tom_ucenter:ajax&site='.$site_id.'&act=loginout&&formhash='.$formhash;
$bbsLoginOutBackUrl = urlencode("plugin.php?id=tom_tongcheng&site={$site_id}&mod=index");
$bbsLoginOut = "member.php?mod=logging&action=logout&referer={$bbsLoginOutBackUrl}&formhash={$formhash}&handlekey=logout";

$subscribeFlag = 0;
$open_subscribe = 0;
$access_token = $weixinClass->get_access_token();
if($tongchengConfig['open_subscribe']==1 && $tongchengConfig['open_child_subscribe_sites']==1){
    $open_subscribe = 1;
}else if($tongchengConfig['open_subscribe']==1 && $site_id==1){
    $open_subscribe = 1;
}
if($open_subscribe==1 && !empty($__UserInfo['openid']) && !empty($access_token)){
    $get_user_info_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$__UserInfo['openid']}&lang=zh_CN";
    $return = get_html($get_user_info_url);
    if(!empty($return)){
        $tcContent = json_decode($return,true);
        if(is_array($tcContent) && !empty($tcContent) && isset($tcContent['subscribe'])){
            if($tcContent['subscribe'] == 1){
                $subscribeFlag = 1;
            }else{
                $subscribeFlag = 2;
            }
        }
    }
}

if($act == 'shop'){
    
    tomheader('location:'.$_G['siteurl']."plugin.php?id=tom_tcshop&site={$site_id}&mod=store");exit;
    
}else if($act == 'set'){
    $isGbk = false;
    if (CHARSET == 'gbk') $isGbk = true;
    include template("tom_tongcheng:personal_set");
}else{
    if($__ShowTcmall == 1){
        $daiFuKuanCount = C::t('#tom_tcmall#tom_tcmall_order')->fetch_all_count(" AND user_id = {$__UserInfo['id']} AND order_status = 1 ");
        $daiFaHuoCount = C::t('#tom_tcmall#tom_tcmall_order')->fetch_all_count(" AND user_id = {$__UserInfo['id']} AND order_status = 2 ");
        $daiShouHuoCount = C::t('#tom_tcmall#tom_tcmall_order')->fetch_all_count(" AND user_id = {$__UserInfo['id']} AND order_status = 3 ");
        $daiPinglunCount = C::t('#tom_tcmall#tom_tcmall_order')->fetch_all_count(" AND user_id = {$__UserInfo['id']} AND order_status = 4 AND pinglun_status = 0 ");
    }
    
    $isGbk = false;
    if (CHARSET == 'gbk') $isGbk = true;
    include template("tom_tongcheng:personal");
}




