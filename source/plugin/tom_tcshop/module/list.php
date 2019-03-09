<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$city_id        = intval($_GET['city_id'])>0? intval($_GET['city_id']):0;
$area_id        = intval($_GET['area_id'])>0? intval($_GET['area_id']):0;
$street_id      = intval($_GET['street_id'])>0? intval($_GET['street_id']):0;
$cate_id        = intval($_GET['cate_id'])>0? intval($_GET['cate_id']):0;
$cate_child_id  = intval($_GET['cate_child_id'])>0? intval($_GET['cate_child_id']):0;
$keyword        = isset($_GET['keyword'])? addslashes(urldecode($_GET['keyword'])):'';
$ordertype      = !empty($_GET['ordertype'])? addslashes($_GET['ordertype']):'';

$areaInfo = array();
if(!empty($area_id)){
    $areaInfo = C::t('#tom_tongcheng#tom_tongcheng_district')->fetch_by_id($area_id);
}

$streetInfo = array();
if(!empty($street_id)){
    $streetInfo = C::t('#tom_tongcheng#tom_tongcheng_district')->fetch_by_id($street_id);
}

$cateInfo = array();
if(!empty($cate_id)){
    $cateInfo = C::t('#tom_tcshop#tom_tcshop_cate')->fetch_by_id($cate_id);
}

$cateChildInfo = array();
if(!empty($cate_child_id)){
    $cateChildInfo = C::t('#tom_tcshop#tom_tcshop_cate')->fetch_by_id($cate_child_id);
}

$areaListTmp = C::t('#tom_tongcheng#tom_tongcheng_district')->fetch_all_by_upid($__CityInfo['id']);
$areaList = array();
if(is_array($areaListTmp) && !empty($areaListTmp)){
    $areaList = $areaListTmp;
}

$cateList = C::t('#tom_tcshop#tom_tcshop_cate')->fetch_all_list(" AND parent_id=0 "," ORDER BY csort ASC,id DESC ",0,500);

$ajaxGetStreetUrl = "plugin.php?id=tom_tongcheng:ajax&site={$site_id}&act=list_get_street&&formhash=".$formhash;
$ajaxGetCateChildUrl = "plugin.php?id=tom_tcshop:ajax&site={$site_id}&act=list_get_cate_child&&formhash=".$formhash;

$shareUrl   = $_G['siteurl']."plugin.php?id=tom_tcshop&site={$site_id}&mod=list&cate_id={$cate_id}&cate_child_id={$cate_child_id}";

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
include template("tom_tcshop:list");  




