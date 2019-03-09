<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$tab = intval($_GET['tab'])>0? intval($_GET['tab']):1;

$cateListTmp = C::t('#tom_tcshop#tom_tcshop_cate')->fetch_all_list(" AND parent_id=0 "," ORDER BY csort ASC,id DESC ",0,50);
$navList = array();
$cateList = array();
$i = 1;
$navCount = 0;
if(is_array($cateListTmp) && !empty($cateListTmp)){
    foreach ($cateListTmp as $key => $value){
        if(!preg_match('/^http/', $value['picurl']) ){
            if(strpos($value['picurl'], 'source/plugin/tom_tcshop/') === FALSE){
                $picurl = (preg_match('/^http:/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'tomwx/'.$value['picurl'];
            }else{
                $picurl = $value['picurl'];
            }
        }else{
            $picurl = $value['picurl'];
        }
        
        $navList[$value['id']]['i'] = $i;
        $navList[$value['id']]['title']     = $value['name'];
        $navList[$value['id']]['picurl']    = $picurl;
        $navList[$value['id']]['link']      = "plugin.php?id=tom_tcshop&site={$site_id}&mod=list&cate_id={$value['id']}";
        
        $i++;
        $navCount++;
    }
}

$focuspicListTmp = C::t('#tom_tcshop#tom_tcshop_focuspic')->fetch_all_list(" AND site_id={$site_id} "," ORDER BY fsort ASC,id DESC ",0,6);
if(is_array($focuspicListTmp) && !empty($focuspicListTmp)){
}else{
    $focuspicListTmp = C::t('#tom_tcshop#tom_tcshop_focuspic')->fetch_all_list(" AND site_id=1 "," ORDER BY fsort ASC,id DESC ",0,6);
}
$focuspicList = array();
foreach ($focuspicListTmp as $key => $value) {
    $focuspicList[$key] = $value;    
    if(!preg_match('/^http/', $value['picurl']) ){
        $picurl = (preg_match('/^http:/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'tomwx/'.$value['picurl'];
    }else{
        $picurl = $value['picurl'];
    }
    $focuspicList[$key]['picurl'] = $picurl;
}

$oneCityInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_district')->fetch_by_level1_name($tongchengConfig['city_name']);

$citySitesArr = array();
if($__CityInfo['id'] > 0){
    $citySitesListTmp = C::t('#tom_tongcheng#tom_tongcheng_sites')->fetch_all_list(" AND city_id={$__CityInfo['id']} AND status=1 "," ORDER BY id DESC ",0,100);
    if(is_array($citySitesListTmp) && !empty($citySitesListTmp)){
        foreach ($citySitesListTmp as $key => $value){
            $citySitesArr[] = $value['id'];
        }
    }
}
if(is_array($citySitesArr) && !empty($citySitesArr)){
    if($oneCityInfoTmp['id'] == $__CityInfo['id']){
        $citySitesArr[] = 1;
    }
}else{
    $citySitesArr = array($site_id);
}
$citySitesStr = implode(',', $citySitesArr);

$newTcshopList = C::t('#tom_tcshop#tom_tcshop')->fetch_all_list(" AND status=1 AND shenhe_status=1 AND site_id IN({$citySitesStr}) "," ORDER BY id DESC ",0,10);

$ajaxIndexLoadListUrl = 'plugin.php?id=tom_tcshop:ajax&site='.$site_id.'&act=list&formhash='.$formhash;
if($tab == 1){
    $ajaxIndexLoadListUrl = 'plugin.php?id=tom_tcshop:ajax&site='.$site_id.'&act=list&formhash='.$formhash;
}else if($tab == 2){
    $ajaxIndexLoadListUrl = 'plugin.php?id=tom_tcshop:ajax&site='.$site_id.'&act=list&ordertype=new&formhash='.$formhash;
}else if($tab == 3){
    $ajaxIndexLoadListUrl = 'plugin.php?id=tom_tcshop:ajax&site='.$site_id.'&act=list&ordertype=lbs&formhash='.$formhash;
}

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
include template("tom_tcshop:index");  




