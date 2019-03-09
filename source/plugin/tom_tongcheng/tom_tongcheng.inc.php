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
$tongchengConfig = $_G['cache']['plugin']['tom_tongcheng'];
$tomSysOffset = getglobal('setting/timeoffset');
$nowDayTime = gmmktime(0,0,0,dgmdate($_G['timestamp'], 'n',$tomSysOffset),dgmdate($_G['timestamp'], 'j',$tomSysOffset),dgmdate($_G['timestamp'], 'Y',$tomSysOffset)) - $tomSysOffset*3600;
require_once libfile('function/discuzcode');
$appid = trim($tongchengConfig['wxpay_appid']);  
$appsecret = trim($tongchengConfig['wxpay_appsecret']);
$prand = rand(1, 1000);
$cssJsVersion = "20181019";

include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/class/weixin.class.php';
$weixinClass = new weixinClass($appid,$appsecret);

include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/class/function.core.php';
include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/class/qqface.php';
include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/class/link.func.php';
include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/nofind.php';

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

include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/sitesinfo.php';
if($site_id > 1){
    $shareTitle = $__SitesInfo['share_title'];
    $shareDesc  = $__SitesInfo['share_desc'];
    $shareLogo = $__SitesInfo['share_pic'];
}

## tcadmin start
$tcadminConfig = array();
if(file_exists(DISCUZ_ROOT.'./source/plugin/tom_tcadmin/tom_tcadmin.inc.php')){
    $tcadminConfig = $_G['cache']['plugin']['tom_tcadmin'];
}
## tcadmin end
## tcshop start
$__ShowTcshop = 0;
$tcshopConfig = array();
if(file_exists(DISCUZ_ROOT.'./source/plugin/tom_tcshop/tom_tcshop.inc.php')){
    $tcshopConfig = $_G['cache']['plugin']['tom_tcshop'];
    if($tcshopConfig['open_tcshop'] == 1){
        $__ShowTcshop = 1;
    }
}
## tcshop end
## tcqianggou start
$__ShowTcqianggou = 0;
$tcqianggouConfig = array();
if(file_exists(DISCUZ_ROOT.'./source/plugin/tom_tcqianggou/tom_tcqianggou.inc.php')){
    $tcqianggouConfig = $_G['cache']['plugin']['tom_tcqianggou'];
    if($tcqianggouConfig['open_tcqianggou'] == 1){
        $__ShowTcqianggou = 1;
    }
}
## tcqianggou end
## tchongbao start
$__ShowTchongbao = 0;
$tchongbaoConfig = array();
if(file_exists(DISCUZ_ROOT.'./source/plugin/tom_tchongbao/tom_tchongbao.inc.php')){
    $tchongbaoConfig = $_G['cache']['plugin']['tom_tchongbao'];
    if($tchongbaoConfig['open_tchongbao'] == 1){
        $__ShowTchongbao = 1;
        $tchongbaoConfig['hb_lq_type'] = 1;
    }
}
## tchongbao end
## tcmajia start
$__ShowTcmajia = 0;
$tcmajiaConfig = array();
if(file_exists(DISCUZ_ROOT.'./source/plugin/tom_tcmajia/tom_tcmajia.inc.php')){
    $tcmajiaConfig = $_G['cache']['plugin']['tom_tcmajia'];
    if($tcmajiaConfig['open_tcmajia'] == 1){
        $__ShowTcmajia = 1;
    }
}
## tcmajia end
## tcptuan start
$__ShowTcptuan = 0;
if(file_exists(DISCUZ_ROOT.'./source/plugin/tom_tcptuan/tom_tcptuan.inc.php')){
    $tcptuanConfig = $_G['cache']['plugin']['tom_tcptuan'];
    if($tcptuanConfig['open_tcptuan'] == 1){
        $__ShowTcptuan = 1;
    }
}
## tcptuan end
## tckjia start
$__ShowTckjia = 0;
if(file_exists(DISCUZ_ROOT.'./source/plugin/tom_tckjia/tom_tckjia.inc.php')){
    $tckjiaConfig = $_G['cache']['plugin']['tom_tckjia'];
    if($tckjiaConfig['open_tckjia'] == 1){
        $__ShowTckjia = 1;
    }
}
## tckjia end
## tc114 start
$__ShowTc114 = 0;
if(file_exists(DISCUZ_ROOT.'./source/plugin/tom_tc114/tom_tc114.inc.php')){
    $tc114Config = $_G['cache']['plugin']['tom_tc114'];
    if($tc114Config['open_tc114'] == 1){
        $__ShowTc114 = 1;
    }
}
## tc114 end
## tcyikatong start
$__ShowTcyikatong = 0;
if(file_exists(DISCUZ_ROOT.'./source/plugin/tom_tcyikatong/tom_tcyikatong.inc.php')){
    $tcyikatongConfig = $_G['cache']['plugin']['tom_tcyikatong'];
    if($tcyikatongConfig['open_tcyikatong'] == 1){
        $__ShowTcyikatong = 1;
    }
}
## tcyikatong end
## tchehuoren start
$__ShowTchehuoren = 0;
$tchehuorenConfig = array();
if(file_exists(DISCUZ_ROOT.'./source/plugin/tom_tchehuoren/tom_tchehuoren.inc.php')){
    $tchehuorenConfig = $_G['cache']['plugin']['tom_tchehuoren'];
    if($tchehuorenConfig['open_tchehuoren'] == 1){
        $__ShowTchehuoren = 1;
    }
}
## tchehuoren end
## love start
$__ShowLove = 0;
$jyConfig = array();
if(file_exists(DISCUZ_ROOT.'./source/plugin/tom_love/tom_love.inc.php')){
    $jyConfig = $_G['cache']['plugin']['tom_love'];
    if($jyConfig['open_tongcheng'] == 1){
        $__ShowLove = 1;
    }
}
## love end
## tcmall start
$__ShowTcmall = 0;
if(file_exists(DISCUZ_ROOT.'./source/plugin/tom_tcmall/tom_tcmall.inc.php')){
    $tcmallConfig = $_G['cache']['plugin']['tom_tcmall'];
    if($tcmallConfig['open_tcmall'] == 1){
        $__ShowTcmall = 1;
    }
}
## tcmall end
## xiangqin start
$__ShowXiangqin = 0;
$xiangqinConfig = array();
if(file_exists(DISCUZ_ROOT.'./source/plugin/tom_xiangqin/tom_xiangqin.inc.php')){
    $xiangqinConfig = $_G['cache']['plugin']['tom_xiangqin'];
    if($xiangqinConfig['open_xiangqin'] == 1){
        $__ShowXiangqin = 1;
    }
}
## xiangqin end
## tctoutiao start
$__ShowTctoutiao = 0;
$tctoutiaoConfig = array();
if(file_exists(DISCUZ_ROOT.'./source/plugin/tom_tctoutiao/tom_tctoutiao.inc.php')){
    $tctoutiaoConfig = $_G['cache']['plugin']['tom_tctoutiao'];
    if($tctoutiaoConfig['open_tctoutiao'] == 1){
        $__ShowTctoutiao = 1;
    }
}
## tctoutiao end

include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/login.php';

$ajaxLoadListUrl = 'plugin.php?id=tom_tongcheng:ajax&site='.$site_id.'&act=list&&formhash='.$formhash;
$ajaxCollectUrl = 'plugin.php?id=tom_tongcheng:ajax&site='.$site_id.'&act=collect&&formhash='.$formhash;
$ajaxClicksUrl = 'plugin.php?id=tom_tongcheng:ajax&site='.$site_id.'&act=clicks&&formhash='.$formhash.'&tongcheng_id=';
$searchUrl = 'plugin.php?id=tom_tongcheng:ajax&site='.$site_id.'&act=get_search_url';
$ajaxCommonClicksUrl = 'plugin.php?id=tom_tongcheng:ajax&site='.$site_id.'&act=commonClicks&&formhash='.$formhash;
$ajaxUpdateTopstatusUrl = 'plugin.php?id=tom_tongcheng:ajax&site='.$site_id.'&act=updateTopstatus&&formhash='.$formhash;
$ajaxUpdateToprandUrl = 'plugin.php?id=tom_tongcheng:ajax&site='.$site_id.'&act=updateToprand&&formhash='.$formhash;
$ajaxAutoClickUrl = 'plugin.php?id=tom_tongcheng:ajax&site='.$site_id.'&act=auto_click&&formhash='.$formhash;
$ajaxAutoZhuanfaUrl = 'plugin.php?id=tom_tongcheng:ajax&site='.$site_id.'&act=auto_zhuanfa&&formhash='.$formhash;
$ajaxShenheSmsUrl = 'plugin.php?id=tom_tongcheng:ajax&site='.$site_id.'&act=shenhe_sms&&formhash='.$formhash;
$ajaxZhuanfaScoreUrl = 'plugin.php?id=tom_tongcheng:ajax&site='.$site_id.'&act=zhuanfaScore&&formhash='.$formhash;
$ajaxLoadPopupUrl = 'plugin.php?id=tom_tongcheng:ajax&site='.$site_id.'&act=load_popup&&formhash='.$formhash;
$ajaxClosePopupUrl = 'plugin.php?id=tom_tongcheng:ajax&site='.$site_id.'&act=close_popup&&formhash='.$formhash;
$addPinglunUrl = "plugin.php?id=tom_tongcheng:ajax&site={$site_id}&act=pinglun&formhash=".FORMHASH;
$ajaxUpdateLbsUrl = 'plugin.php?id=tom_tongcheng:ajax&site='.$site_id.'&act=update_lbs&formhash='.$formhash;

$__CommonInfo = C::t('#tom_tongcheng#tom_tongcheng_common')->fetch_by_id(1);
if(!$__CommonInfo){
    $insertData = array();
    $insertData['id']      = 1;
    C::t('#tom_tongcheng#tom_tongcheng_common')->insert($insertData);
}
if($site_id > 1){
    $__siteCommonInfo = C::t('#tom_tongcheng#tom_tongcheng_common')->fetch_by_id($site_id);
    if(!$__siteCommonInfo){
        $insertData = array();
        $insertData['id']      = $site_id;
        C::t('#tom_tongcheng#tom_tongcheng_common')->insert($insertData);
    }
}

$browser_shouchang_show = 1;
$browser_uid = getcookie('tom_tongcheng_browser_shouchang_'.$__UserInfo['id']);
if($browser_uid || $__IsWeixin == 0){
    $browser_shouchang_show = 0;
}
if($tongchengConfig['open_shouchang'] == 0 || $__IsMiniprogram == 1){
    $browser_shouchang_show = 0;
}

$ajaxShouchangUrl = "plugin.php?id=tom_tongcheng:ajax&act=browser_shouchang&formhash=".FORMHASH;

$footer_nav_content_name = $footer_nav_content_link = '';
if($tongchengConfig['footer_nav_mod'] == 1){
    if(!empty($tongchengConfig['footer_nav_content'])){
        $footer_nav_content = explode("|", $tongchengConfig['footer_nav_content']);
        $footer_nav_content_name = $footer_nav_content[0];
        $footer_nav_content_link = $footer_nav_content[1];
    }
}

$must_phone_projectArr = unserialize($tongchengConfig['must_phone_project']);
$showMustPhoneBtn = 0;
if(array_search('2',$must_phone_projectArr) !== false && empty($__UserInfo['tel']) && $__UserInfo['editor']==0 && $__UserInfo['is_majia']==0){
    $showMustPhoneBtn = 1;
}

//dsetcookie('tom_tongcheng_user_latitude','31.244819',86400);
//dsetcookie('tom_tongcheng_user_longitude','120.68515',86400);

$latitude = getcookie('tom_tongcheng_user_latitude');
$longitude = getcookie('tom_tongcheng_user_longitude');

if($_GET['mod'] == 'index'){

    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/index.php';
    
}else if($_GET['mod'] == 'fabu'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/fabu.php';
    
}else if($_GET['mod'] == 'search'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/search.php';
    
}else if($_GET['mod'] == 'list'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/list.php';
    
}else if($_GET['mod'] == 'info'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/info.php';
    
}else if($_GET['mod'] == 'view'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/info.php';
    
}else if($_GET['mod'] == 'hbao'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/info.php';
    
}else if($_GET['mod'] == 'home'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/home.php';
    
}else if($_GET['mod'] == 'personal'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/personal.php';
    
}else if($_GET['mod'] == 'message'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/message.php';
    
}else if($_GET['mod'] == 'mycollect'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/mycollect.php';
    
}else if($_GET['mod'] == 'mylist'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/mylist.php';
    
}else if($_GET['mod'] == 'tousu'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/tousu.php';
    
}else if($_GET['mod'] == 'buy'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/buy.php';
    
}else if($_GET['mod'] == 'article'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/article.php';
    
}else if($_GET['mod'] == 'myorder'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/myorder.php';
    
}else if($_GET['mod'] == 'phone'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/phone.php';
    
}else if($_GET['mod'] == 'edit'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/edit.php';
    
}else if($_GET['mod'] == 'editcate'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/editcate.php';
    
}else if($_GET['mod'] == 'managerList'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/managerList.php';
    
}else if($_GET['mod'] == 'upload'){
    
    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/upload.php';
    
}else if($_GET['mod'] == 'myedit'){

    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/myedit.php';
    
}else if($_GET['mod'] == 'templatesmsTest'){

    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/templatesmsTest.php';
    
}else if($_GET['mod'] == 'scorelog'){

    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/scorelog.php';
    
}else if($_GET['mod'] == 'money'){

    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/money.php';
    
}else if($_GET['mod'] == 'moneylog'){

    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/moneylog.php';
    
}else if($_GET['mod'] == 'moneytixian'){

    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/moneytixian.php';
    
}else if($_GET['mod'] == 'address'){

    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/address.php';
    
}else if($_GET['mod'] == 'majia'){

    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/majia.php';
    
}else if($_GET['mod'] == 'help'){

    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/help.php';
    
}else if($_GET['mod'] == 'baidumap'){

    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/baidumap.php';
    
}else{
    
    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/module/index.php';
}
tomoutput();