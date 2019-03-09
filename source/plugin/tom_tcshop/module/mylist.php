<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$page  = intval($_GET['page'])>0? intval($_GET['page']):1;
$type  = intval($_GET['type'])>0? intval($_GET['type']):0;

$pagesize = 8;
$start = ($page - 1)*$pagesize;

$where = " AND user_id={$__UserInfo['id']} ";
$order = " ORDER BY id DESC ";
if($type == 1){
    $where.= " AND status=1 ";
}
if($type == 2){
    $where.= " AND pay_status=1 ";
}
if($type == 4){
    $where.= " AND (shenhe_status=2 OR shenhe_status=3) AND (pay_status=0 OR pay_status=2) ";
    $order = " ORDER BY shenhe_status ASC,id DESC ";
}

$count = C::t('#tom_tcshop#tom_tcshop')->fetch_all_count(" {$where} ");
$tcshopListTmp = C::t('#tom_tcshop#tom_tcshop')->fetch_all_list(" {$where} "," {$order} ",$start,$pagesize);
$tcshopList = array();
if(is_array($tcshopListTmp) && !empty($tcshopListTmp)){
    foreach ($tcshopListTmp as $key => $value){
        $tcshopList[$key] = $value;
        if(!preg_match('/^http/', $value['picurl']) ){
            $picurl = (preg_match('/^http:/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'tomwx/'.$value['picurl'];
        }else{
            $picurl = $value['picurl'];
        }
        $tcshopList[$key]['picurl'] = $picurl;
    }
}

$showNextPage = 1;
if(($start + $pagesize) >= $count){
    $showNextPage = 0;
}
$allPageNum = ceil($count/$pagesize);
$prePage = $page - 1;
$nextPage = $page + 1;
$prePageUrl = "plugin.php?id=tom_tcshop&site={$site_id}&mod=mylist&type={$type}&page={$prePage}";
$nextPageUrl = "plugin.php?id=tom_tcshop&site={$site_id}&mod=mylist&type={$type}&page={$nextPage}";

$upgradeVipBackScore = $tcshopConfig['vip_upgrade_price']*100;

$payUrl = "plugin.php?id=tom_tcshop:pay&site={$site_id}&act=pay&formhash=".$formhash;
$vipUrl = "plugin.php?id=tom_tcshop:pay&site={$site_id}&act=vip&formhash=".$formhash;
$ajaxUpdateStatusUrl = "plugin.php?id=tom_tcshop:ajax&site={$site_id}&act=updateStatus&&formhash=".$formhash;

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
include template("tom_tcshop:mylist");