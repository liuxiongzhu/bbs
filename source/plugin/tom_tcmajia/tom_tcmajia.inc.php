<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$site_id = intval($_GET['site'])>0? intval($_GET['site']):1;

session_start();
define('TPL_DEFAULT', true);
$formhash = FORMHASH;
$tcmajiaConfig = $_G['cache']['plugin']['tom_tcmajia'];
$tomSysOffset = getglobal('setting/timeoffset');
require_once libfile('function/discuzcode');
$prand = rand(1, 1000);
$cssJsVersion = "20170424";

# tongcheng start
$tongchengConfig = $_G['cache']['plugin']['tom_tongcheng'];

$appid = trim($tongchengConfig['wxpay_appid']);  
$appsecret = trim($tongchengConfig['wxpay_appsecret']);

include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/class/weixin.class.php';
$weixinClass = new weixinClass($appid,$appsecret);

include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/class/function.core.php';

$wxJssdkConfig = array();
$wxJssdkConfig["appId"]     = "";
$wxJssdkConfig["timestamp"] = time();
$wxJssdkConfig["nonceStr"]  = "";
$wxJssdkConfig["signature"] = "";
$wxJssdkConfig = $weixinClass->get_jssdk_config();
$shareTitle = $tongchengConfig['wx_share_title'];
$shareDesc  = $tongchengConfig['wx_share_desc'];
$shareUrl   = $_G['siteurl']."plugin.php?id=tom_tongcheng&site={$site_id}&mod=index";
$shareLogo  = $tongchengConfig['wx_share_pic'];

$__SitesInfo = array('id'=>1,'name'=>$tongchengConfig['plugin_name']);
$__CityInfo = array('id'=>0,'name'=>'');
if($site_id > 1){
    $sitesInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_sites')->fetch_by_id($site_id);
    if($sitesInfoTmp){
        $__SitesInfo = $sitesInfoTmp;
        if($__SitesInfo['status'] == 2){
            dheader('location:'.$_G['siteurl']."plugin.php?id=tom_tongcheng&site=1&mod=index");exit;
        }
        if(!empty($__SitesInfo['city_id'])){
            $cityInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_district')->fetch_by_id($__SitesInfo['city_id']);
            if($cityInfoTmp){
                $__CityInfo = $cityInfoTmp;
            }
        }
        $shareTitle = $__SitesInfo['share_title'];
        $shareDesc  = $__SitesInfo['share_desc'];
        if(!preg_match('/^(http|https):/', $__SitesInfo['share_pic']) ){
            $shareLogo = (preg_match('/^(http|https):/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'tomwx/'.$__SitesInfo['share_pic'];
        }else{
            $shareLogo = $__SitesInfo['share_pic'];
        }
    }else{
        $site_id = 1;
    }
}
if($site_id == 1){
    $cityInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_district')->fetch_by_level1_name($tongchengConfig['city_name']);
    if($cityInfoTmp){
        $__CityInfo = $cityInfoTmp;
    }
}

include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/login.php';

# tongcheng end



exit('ok');