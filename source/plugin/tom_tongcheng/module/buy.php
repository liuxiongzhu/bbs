<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$act  = isset($_GET['act'])? addslashes($_GET['act']):'top';

$tongcheng_id   = intval($_GET['tongcheng_id'])>0? intval($_GET['tongcheng_id']):0;
    
$tongchengInfo = C::t('#tom_tongcheng#tom_tongcheng')->fetch_by_id($tongcheng_id);

$modelInfo = C::t('#tom_tongcheng#tom_tongcheng_model')->fetch_by_id($tongchengInfo['model_id']);
$typeInfo = C::t('#tom_tongcheng#tom_tongcheng_model_type')->fetch_by_id($tongchengInfo['type_id']);

$sites_priceTmp = C::t('#tom_tongcheng#tom_tongcheng_sites_price')->fetch_all_list(" AND site_id={$tongchengInfo['site_id']} AND type_id={$tongchengInfo['type_id']} "," ORDER BY id DESC ",0,1);
if(is_array($sites_priceTmp) && !empty($sites_priceTmp) && $sites_priceTmp[0]['id']>0){
    $typeInfo['top_price']      = $sites_priceTmp[0]['top_price'];
    $typeInfo['top_price_str']  = $sites_priceTmp[0]['top_price_str'];
}

$toptime = dgmdate($tongchengInfo['toptime'],"Y-m-d",$tomSysOffset);

$buy_item = array();
if(!empty($typeInfo['top_price_str'])){
    $top_price_str = str_replace("\r\n","{n}",$typeInfo['top_price_str']); 
    $top_price_str = str_replace("\n","{n}",$top_price_str);
    $top_price_list = explode("{n}", $top_price_str);
    if(is_array($top_price_list) && !empty($top_price_list)){
        foreach ($top_price_list as $key => $value){
            $top_price_list_item = explode("|", $value);
            $top_price_list_item_days = intval($top_price_list_item[0]);
            $top_price_list_item_price = floatval($top_price_list_item[1]);
            if($top_price_list_item_days > 0 && $top_price_list_item_price > 0){
                $buy_item[$top_price_list_item_days] = $top_price_list_item_price;
            }
        }
    }
}
if(empty($buy_item)){
    $buy_item_days = array(1,3,5,7,15,30);
    if($typeInfo['top_price'] == 0.00){
        $typeInfo['top_price'] = 1;
    }
    foreach ($buy_item_days as $key => $value){
        $buy_item[$value] = $typeInfo['top_price']*$value;
    }
}

$buy_days_item = array();
foreach ($buy_item as $key => $value){
    $buy_days_item[$key]['days'] = $key;
    $buy_days_item[$key]['price'] = $value;
    $buy_days_item[$key]['score_pay'] = 0;
    if($tongchengConfig['open_top_score_pay'] == 1){
        $useScoreTmp = $tongchengConfig['pay_score_yuan']*$value;
        $useScoreTmp = ceil($useScoreTmp);
        if($__UserInfo['score'] >= $useScoreTmp){
            $buy_days_item[$key]['score_pay'] = 1;
            $buy_days_item[$key]['score'] = $useScoreTmp;
        }
    }
}

$payTopUrl = "plugin.php?id=tom_tongcheng:pay&site={$site_id}&act=top&formhash=".$formhash;

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
include template("tom_tongcheng:buy");