<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if($__UserInfo['editor']==1){
    $tongchengConfig['free_refresh_times'] = 9999;
}

## VIP start
$_isVipTequan = 0;
if($__ShowTcyikatong == 1 && $tcyikatongConfig['open_fenlei_tequan'] == 1){
    $cardInfoTmp = C::t('#tom_tcyikatong#tom_tcyikatong_card')->fetch_by_user_id($__UserInfo['id']);
    if(is_array($cardInfoTmp) && !empty($cardInfoTmp) && $cardInfoTmp['status'] == 1){
        $_isVipTequan = 1;
    }
}
## VIP end

$page  = intval($_GET['page'])>0? intval($_GET['page']):1;
$type  = intval($_GET['type'])>0? intval($_GET['type']):0;

$where = " AND user_id={$__UserInfo['id']} ";
$order = " ORDER BY refresh_time DESC,id DESC ";
if($type == 1){
    $where.= " AND status=1 ";
}
if($type == 2){
    $where.= " AND pay_status=1 ";
}
if($type == 3){
    $where.= " AND finish=1 ";
}
if($type == 4){
    $where.= " AND (shenhe_status=2 OR shenhe_status=3) AND (pay_status=0 OR pay_status=2) ";
    $order = " ORDER BY shenhe_status ASC,id DESC ";
}

$pagesize = 8;
$start = ($page - 1)*$pagesize;

$count = C::t('#tom_tongcheng#tom_tongcheng')->fetch_all_count(" {$where} ");
$tongchengListTmp = C::t('#tom_tongcheng#tom_tongcheng')->fetch_all_list(" {$where} "," {$order} ",$start,$pagesize);

$tongchengList = array();
foreach ($tongchengListTmp as $key => $value) {
    $tongchengList[$key] = $value;
    $tongchengList[$key]['content'] = contentFormat($value['content']);

    $modelInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_model')->fetch_by_id($value['model_id']);
    $userInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($value['user_id']); 
    $typeInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_model_type')->fetch_by_id($value['type_id']);
    
    $sites_priceTmp = C::t('#tom_tongcheng#tom_tongcheng_sites_price')->fetch_all_list(" AND site_id={$value['site_id']} AND type_id={$value['type_id']} "," ORDER BY id DESC ",0,1);
    if(is_array($sites_priceTmp) && !empty($sites_priceTmp) && $sites_priceTmp[0]['id']>0){
        $typeInfoTmp['refresh_price'] = $sites_priceTmp[0]['refresh_price'];
    }

    $tongchengAttrListTmp = C::t('#tom_tongcheng#tom_tongcheng_attr')->fetch_all_list(" AND tongcheng_id={$value['id']} "," ORDER BY paixu ASC,id DESC ",0,50);
    $tongchengTagListTmp = C::t('#tom_tongcheng#tom_tongcheng_tag')->fetch_all_list(" AND tongcheng_id={$value['id']} "," ORDER BY id DESC ",0,50);
    $tongchengPhotoListTmpTmp = C::t('#tom_tongcheng#tom_tongcheng_photo')->fetch_all_list(" AND tongcheng_id={$value['id']} "," ORDER BY id ASC ",0,50);
    $tongchengPhotoListTmp = array();
    if(is_array($tongchengPhotoListTmpTmp) && !empty($tongchengPhotoListTmpTmp)){
        foreach ($tongchengPhotoListTmpTmp as $kk => $vv){
            if(!preg_match('/^http/', $vv['picurl']) ){
                if(strpos($vv['picurl'], 'source/plugin/tom_tongcheng/data/') === false){
                    $picurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'tomwx/'.$vv['picurl'];
                }else{
                    $picurl = $vv['picurl'];
                }
            }else{
                $picurl = $vv['picurl'];
            }
            $tongchengPhotoListTmp[$kk] = $picurl;
        }
    }
    
    $tchongbaoInfo = array();
    if($__ShowTchongbao == 1){
        $tchongbaoInfoTmp = C::t('#tom_tchongbao#tom_tchongbao')->fetch_all_list(" AND tongcheng_id = {$value['id']} AND pay_status = 2 AND only_show = 1 ", 'ORDER BY add_time DESC,id DESC', 0, 1);
        if(is_array($tchongbaoInfoTmp) && !empty($tchongbaoInfoTmp[0])){
            $tchongbaoInfo = $tchongbaoInfoTmp[0];
        }
    }
    
    $tongchengList[$key]['userInfo'] = $userInfoTmp;
    $tongchengList[$key]['modelInfo'] = $modelInfoTmp;
    $tongchengList[$key]['typeInfo'] = $typeInfoTmp;
    $tongchengList[$key]['attrList'] = $tongchengAttrListTmp;
    $tongchengList[$key]['tagList'] = $tongchengTagListTmp;
    $tongchengList[$key]['photoList'] = $tongchengPhotoListTmp;
    $tongchengList[$key]['tchongbaoInfo'] = $tchongbaoInfo;
    
    $payRefreshStatus = 0;
    $shengyuRefreshTimes = 0;
    if($tongchengConfig['free_refresh_times'] > 0){
        $refresh_log_count = C::t('#tom_tongcheng#tom_tongcheng_refresh_log')->fetch_all_count(" AND user_id={$value['user_id']} AND time_key={$nowDayTime} ");
        if($tongchengConfig['free_refresh_times'] > $refresh_log_count){
            $shengyuRefreshTimes = $tongchengConfig['free_refresh_times'] - $refresh_log_count;
        }else{
            $payRefreshStatus = 1;
        }
    }else{
        $payRefreshStatus = 1;
    }
    
    $useScoreTmp = 0;
    if($payRefreshStatus == 1){
        if($tongchengConfig['pay_score_yuan'] > 0){
            $useScoreTmp = $tongchengConfig['pay_score_yuan']*$typeInfoTmp['refresh_price'];
            $useScoreTmp = ceil($useScoreTmp);
            if($__UserInfo['score'] > $useScoreTmp){
                $payRefreshStatus = 2;
            }
        }
    }
    
    if($_isVipTequan == 1){
        $payRefreshStatus = 3;
    }
    
    $tongchengList[$key]['payRefreshStatus'] = $payRefreshStatus;
    $tongchengList[$key]['refreshUseScore'] = $useScoreTmp;
    $tongchengList[$key]['shengyuRefreshTimes'] = $shengyuRefreshTimes;
    
    $tongchengList[$key]['over_status'] = 0;
    if($typeInfoTmp['jifei_type'] == 2 && $value['over_days'] > 0){
        if($value['over_time'] > 0){
            $tongchengList[$key]['over_time'] = dgmdate($value['over_time'],"Y-m-d",$tomSysOffset);
        }else{
            $tongchengList[$key]['over_time'] = '-';
        }
        if($value['over_time'] > 0 && $value['over_time'] < TIMESTAMP){
            $tongchengList[$key]['over_status'] = 1;
        }
    }
    
}

$showNextPage = 1;
if(($start + $pagesize) >= $count){
    $showNextPage = 0;
}
$allPageNum = ceil($count/$pagesize);
$prePage = $page - 1;
$nextPage = $page + 1;
$prePageUrl = "plugin.php?id=tom_tongcheng&site={$site_id}&mod=mylist&type={$type}&page={$prePage}";
$nextPageUrl = "plugin.php?id=tom_tongcheng&site={$site_id}&mod=mylist&type={$type}&page={$nextPage}";


$ajaxUpdateStatusUrl = "plugin.php?id=tom_tongcheng:ajax&site={$site_id}&act=updateStatus&&formhash=".$formhash;
$ajaxFinishStatusUrl = "plugin.php?id=tom_tongcheng:ajax&site={$site_id}&act=updateFinish&&formhash=".$formhash;
$ajaxrefreshUrl = "plugin.php?id=tom_tongcheng:ajax&site={$site_id}&act=refresh&&formhash=".$formhash;
$ajaxrefresh3Url = "plugin.php?id=tom_tongcheng:ajax&site={$site_id}&act=refresh3&&formhash=".$formhash;
$ajaxrefresh4Url = "plugin.php?id=tom_tongcheng:ajax&site={$site_id}&act=refresh4&&formhash=".$formhash;
$payUrl = "plugin.php?id=tom_tongcheng:pay&site={$site_id}&act=pay&formhash=".$formhash;
$payRefreshUrl = "plugin.php?id=tom_tongcheng:pay&site={$site_id}&act=refresh&formhash=".$formhash;

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
include template("tom_tongcheng:mylist");