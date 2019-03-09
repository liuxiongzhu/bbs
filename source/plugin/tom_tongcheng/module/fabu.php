<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


if($_GET['act'] == 'step2'){
    
    if($_GET['lbs_no'] == 1){
        $lifeTime = $tcadminConfig['sites_lbs_time'];
        dsetcookie('tom_tongcheng_sites_lbs', 1, $lifeTime);

        if($__UserInfo['id'] > 0){
            $__UserInfo['site_id']  = $site_id;
            $updateData             = array();
            $updateData['site_id']  = $site_id;
            C::t('#tom_tongcheng#tom_tongcheng_user')->update($__UserInfo['id'],$updateData);
        }

    }
    
    $tongcheng_id = isset($_GET['tongcheng_id'])? intval($_GET['tongcheng_id']):0;
    $pay_ok = isset($_GET['pay_ok'])? intval($_GET['pay_ok']):0;
    $type_id = intval($_GET['type_id'])>0? intval($_GET['type_id']):0;
    $test = intval($_GET['test'])>0? intval($_GET['test']):0;

    $tongchengInfo = C::t('#tom_tongcheng#tom_tongcheng')->fetch_by_id($tongcheng_id);
    $typeInfo = C::t('#tom_tongcheng#tom_tongcheng_model_type')->fetch_by_id($type_id);
    $modelInfo = C::t('#tom_tongcheng#tom_tongcheng_model')->fetch_by_id($typeInfo['model_id']);
    $cateList = C::t('#tom_tongcheng#tom_tongcheng_model_cate')->fetch_all_list(" AND type_id={$type_id}  "," ORDER BY paixu ASC,id DESC ",0,50);
    $tagList = C::t('#tom_tongcheng#tom_tongcheng_model_tag')->fetch_all_list(" AND type_id={$type_id} "," ORDER BY paixu ASC,id DESC ",0,50);
    $attrListTmp = C::t('#tom_tongcheng#tom_tongcheng_model_attr')->fetch_all_list(" AND type_id={$type_id} "," ORDER BY paixu ASC,id DESC ",0,50);
    
     $sites_priceTmp = C::t('#tom_tongcheng#tom_tongcheng_sites_price')->fetch_all_list(" AND site_id={$site_id} AND type_id={$type_id} "," ORDER BY id DESC ",0,1);
     if(is_array($sites_priceTmp) && !empty($sites_priceTmp) && $sites_priceTmp[0]['id']>0){
         $typeInfo['free_status'] = $sites_priceTmp[0]['free_status'];
         $typeInfo['fabu_price'] = $sites_priceTmp[0]['fabu_price'];
         $typeInfo['fabu_price_str']  = $sites_priceTmp[0]['fabu_price_str'];
     }
     
    $over_days_item = array();
    if(!empty($typeInfo['fabu_price_str'])){
        $fabu_price_str = str_replace("\r\n","{n}",$typeInfo['fabu_price_str']); 
        $fabu_price_str = str_replace("\n","{n}",$fabu_price_str);
        $fabu_price_list = explode("{n}", $fabu_price_str);
        if(is_array($fabu_price_list) && !empty($fabu_price_list)){
            foreach ($fabu_price_list as $key => $value){
                $fabu_price_list_item = explode("|", $value);
                $fabu_price_list_item_days = intval($fabu_price_list_item[0]);
                $fabu_price_list_item_price = floatval($fabu_price_list_item[1]);
                if(isset($fabu_price_list_item[2]) && !empty($fabu_price_list_item[2])){
                    $fabu_price_list_item_msg = trim($fabu_price_list_item[2]);
                }else{
                    $fabu_price_list_item_msg = 'NULL';
                }
                if($fabu_price_list_item_days > 0 && $fabu_price_list_item_price > 0){
                    $over_days_item[$fabu_price_list_item_days]['days'] = $fabu_price_list_item_days;
                    $over_days_item[$fabu_price_list_item_days]['price'] = $fabu_price_list_item_price;
                    $over_days_item[$fabu_price_list_item_days]['vipprice'] = $fabu_price_list_item_price/2;
                    $over_days_item[$fabu_price_list_item_days]['msg'] = $fabu_price_list_item_msg;
                }
            }
        }
    }
    
    $attrList = array();
    if(is_array($attrListTmp) && !empty($attrListTmp)){
        foreach ($attrListTmp as $key => $value){
            $attrList[$key] = $value;
            if($value['type'] == 2 || $value['type'] == 4){
                $value_listStr = str_replace("\r\n","{n}",$value['value']); 
                $value_listStr = str_replace("\n","{n}",$value_listStr);
                $attrList[$key]['list'] = explode("{n}", $value_listStr);
            }
        }
    }
    
    $fabuPayStatus = 0;
    $isVipFabu = 0;
    if($typeInfo['free_status'] == 2 && $typeInfo['fabu_price'] > 0 && $__UserInfo['editor']==0){
        $fabuPayStatus = 1;
        ## VIP start
        $shengyuVipTimes = 0;
        if($__ShowTcyikatong == 1 && $tcyikatongConfig['open_fenlei_tequan'] == 1 && $tcyikatongConfig['fenlei_tequan_type'] == 1){
            $cardInfoTmp = C::t('#tom_tcyikatong#tom_tcyikatong_card')->fetch_by_user_id($__UserInfo['id']);
            if(is_array($cardInfoTmp) && !empty($cardInfoTmp) && $cardInfoTmp['status'] == 1){
                $isVipFabu = 1;
                $typeInfo['fabu_price'] = $typeInfo['fabu_price']/2;
            }else{
                $isVipFabu = 3;
            }
        }
        if($__ShowTcyikatong == 1 && $tcyikatongConfig['open_fenlei_tequan'] == 1 && $tcyikatongConfig['fenlei_tequan_type'] == 2){
            $cardInfoTmp = C::t('#tom_tcyikatong#tom_tcyikatong_card')->fetch_by_user_id($__UserInfo['id']);
            if(is_array($cardInfoTmp) && !empty($cardInfoTmp) && $cardInfoTmp['status'] == 1){
                $vip_fabu_log_count = C::t('#tom_tcyikatong#tom_tcyikatong_fabu_log')->fetch_all_count(" AND user_id={$__UserInfo['id']} AND time_key={$nowDayTime} ");
                if($vip_fabu_log_count < $tcyikatongConfig['fenlei_tequan_times']){
                    $fabuPayStatus      = 0;
                    $isVipFabu          = 2;
                    $shengyuVipTimes    = $tcyikatongConfig['fenlei_tequan_times'] - $vip_fabu_log_count;
                }
            }else{
                $isVipFabu = 4;
            }
        }
        ## VIP end
        
        $shengyuFreeFabuTimes = 0;
        if($tongchengConfig['free_fabu_times'] > 0 && $fabuPayStatus == 1 && $typeInfo['jifei_type'] == 1){
            $fabu_log_count = C::t('#tom_tongcheng#tom_tongcheng_fabu_log')->fetch_all_count(" AND user_id={$__UserInfo['id']} AND time_key={$nowDayTime} ");
            if($tongchengConfig['free_fabu_times'] > $fabu_log_count){
                $fabuPayStatus = 3;
                $shengyuFreeFabuTimes = $tongchengConfig['free_fabu_times'] - $fabu_log_count;
            }
        }
        
        if($tongchengConfig['pay_score_yuan'] > 0 && $fabuPayStatus == 1 && $typeInfo['jifei_type'] == 1){
            $useScore = $tongchengConfig['pay_score_yuan']*$typeInfo['fabu_price'];
            $useScore = ceil($useScore);
            if($__UserInfo['score'] >= $useScore){
                $fabuPayStatus = 2;
            }
        }
    }
    
    ## tcmajia start
    $openMajiaStatus = 0;
    if($__ShowTcmajia == 1 && $__UserInfo['editor']==1){
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
        
        $tcmajiaCount = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_all_count(" AND is_majia = 1");
        if($tcmajiaCount <= 0){
            $openMajiaStatus = 0;
        }
    }
    ## tcmajia end
    
    if($site_id > 1 && $__SitesInfo['open_sites'] == 0){
        $tcadminConfig['open_fabu_sites'] = 0;
    }
    $sitesList = array();
    if($tcadminConfig['open_fabu_sites'] == 1){
        $sitesList = C::t('#tom_tongcheng#tom_tongcheng_sites')->fetch_all_list(" AND status=1 AND open_sites=1 "," ORDER BY paixu ASC,id DESC ",0,1000);
    }
    
    $typeInfo['warning_msg'] = discuzcode($typeInfo['warning_msg'], 0, 0, 0, 1, 1, 1, 0, 0, 0, 0);
    
    $minDateTime = TIMESTAMP-60;
    if($modelInfo['is_sfc'] == 1){
        $minDateTime = TIMESTAMP+3600;
    }
    $minDateTime = dgmdate($minDateTime,"Y-m-d H:i:s",$tomSysOffset);
    $maxDateTime = TIMESTAMP + 365*86400;
    $maxDateTime = dgmdate($maxDateTime,"Y-m-d H:i:s",$tomSysOffset);
    
    $areaList = C::t('#tom_tongcheng#tom_tongcheng_district')->fetch_all_by_upid($__CityInfo['id']);
    $cityList = array();
    $i = 0;
    if(is_array($areaList) && !empty($areaList)){
        foreach ($areaList as $key => $value){
            $cityList[$i]['id'] = $value['id'];
            $cityList[$i]['name'] = diconv($value['name'],CHARSET,'utf-8');
            $streetListTmp = C::t('#tom_tongcheng#tom_tongcheng_district')->fetch_all_by_upid($value['id']);
            $j = 0;
            if(is_array($streetListTmp) && !empty($streetListTmp)){
                foreach ($streetListTmp as $kk => $vv){
                    $cityList[$i]['sub'][$j]['id'] = $vv['id'];
                    $cityList[$i]['sub'][$j]['name'] = diconv($vv['name'],CHARSET,'utf-8');
                    $j++;
                }
            }
            $i++;
        }
    }
    $cityData = urlencode(json_encode($cityList));
    
    
    $showPhoneDialog = 0;
    if($tongchengConfig['fabu_must_phone']==1 && $__UserInfo['editor']==0){
        if(empty($__UserInfo['tel'])){
            $showPhoneDialog = 1;
        }
    }
    $phone_back_url = $weixinClass->get_url();
    $phone_back_url = urlencode($phone_back_url);
    
    $defaultXm = '';
    $defaultTel = '';
    $lastTongchengListTmp = C::t('#tom_tongcheng#tom_tongcheng')->fetch_all_list(" AND user_id={$__UserInfo['id']} "," ORDER BY id DESC ",0,1);
    if($lastTongchengListTmp && $lastTongchengListTmp[0]['add_time'] > 0){
        $defaultXm =  $lastTongchengListTmp[0]['xm'];
        $defaultTel =  $lastTongchengListTmp[0]['tel'];
    }else{
        $defaultXm =  $__UserInfo['nickname'];
    }
    
    if($__ShowTcshop == 1){
        $tcshopListTmp = C::t('#tom_tcshop#tom_tcshop')->fetch_all_list(" AND status=1 AND shenhe_status=1 AND vip_level=1 AND user_id={$__UserInfo['id']} "," ORDER BY id DESC ",0,10);
        $tcshopList = array();
        if(is_array($tcshopListTmp) && !empty($tcshopListTmp)){
            foreach ($tcshopListTmp as $key => $value){
                $tcshopList[$key] = $value;
            }
        }
    }
    
    $is_weixin = 0;
    if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false){
        $is_weixin = 1;
    }

    $wxUploadUrl = "plugin.php?id=tom_tongcheng:wxMediaDowmload&site={$site_id}&act=photo&formhash=".FORMHASH;
    $uploadUrl = "plugin.php?id=tom_tongcheng&site={$site_id}&mod=upload&act=photo&formhash=".FORMHASH;
    $payUrl = "plugin.php?id=tom_tongcheng:pay&site={$site_id}";
    $shareLinkUrl = "plugin.php?id=tom_tongcheng&site={$site_id}&mod=info&tongcheng_id=";
    $buyLinkUrl = "plugin.php?id=tom_tongcheng&site={$site_id}&mod=buy&tongcheng_id=";
    $myListUrl = "plugin.php?id=tom_tongcheng&site={$site_id}&mod=mylist&type=2";
    $myListAllUrl = "plugin.php?id=tom_tongcheng&site={$site_id}&mod=mylist";
    $hbLinkUrl = "plugin.php?id=tom_tchongbao&mod=add&site={$site_id}&tongcheng_id=";
    $ossBatchUrl = 'plugin.php?id=tom_tongcheng:ossBatch';
    $qiniuBatchUrl = 'plugin.php?id=tom_tongcheng:qiniuBatch';
    $succLinkUrl = "plugin.php?id=tom_tongcheng&site={$site_id}&mod=fabu&act=succ&tongcheng_id=";
    
    $isGbk = false;
    if (CHARSET == 'gbk') $isGbk = true;
    include template("tom_tongcheng:fabu_step2");  

}else if($_GET['act'] == 'succ'){
    
    
    $tongcheng_id   = intval($_GET['tongcheng_id'])>0? intval($_GET['tongcheng_id']):0;
    
    $tongchengInfo = C::t('#tom_tongcheng#tom_tongcheng')->fetch_by_id($tongcheng_id);

    $modelInfo = C::t('#tom_tongcheng#tom_tongcheng_model')->fetch_by_id($tongchengInfo['model_id']);
    $typeInfo = C::t('#tom_tongcheng#tom_tongcheng_model_type')->fetch_by_id($tongchengInfo['type_id']);

    $sites_priceTmp = C::t('#tom_tongcheng#tom_tongcheng_sites_price')->fetch_all_list(" AND site_id={$tongchengInfo['site_id']} AND type_id={$tongchengInfo['type_id']} "," ORDER BY id DESC ",0,1);
    if(is_array($sites_priceTmp) && !empty($sites_priceTmp) && $sites_priceTmp[0]['id']>0){
        $typeInfo['top_price']      = $sites_priceTmp[0]['top_price'];
        $typeInfo['top_price_str']  = $sites_priceTmp[0]['top_price_str'];
    }

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
    $i = 1;
    foreach ($buy_item as $key => $value){
        $buy_days_item[$key]['i'] = $i;
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
        $i++;
    }
    $buy_days_count = count($buy_days_item);
    $chose_item = 1;
    if($buy_days_count > 4){
        $chose_item = 4;
    }else{
        $chose_item = $buy_days_count;
    }
    
    

    $payTopUrl = "plugin.php?id=tom_tongcheng:pay&site={$site_id}&act=top&from=fabu&formhash=".$formhash;
    $ossBatchUrl = 'plugin.php?id=tom_tongcheng:ossBatch';
    $qiniuBatchUrl = 'plugin.php?id=tom_tongcheng:qiniuBatch';
    
    $isGbk = false;
    if (CHARSET == 'gbk') $isGbk = true;
    include template("tom_tongcheng:fabu_succ");  
    
}else{
    
    if($site_id == 1 && $tcadminConfig['open_memory'] == 1 && $__UserInfo['id'] > 0 && $__UserInfo['site_id'] > 1){
        $memorySitesInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_sites')->fetch_by_id($__UserInfo['site_id']);
        if($memorySitesInfoTmp['status'] == 1 && $memorySitesInfoTmp['open_sites'] == 1 ){
            tomheader('location:'.$_G['siteurl']."plugin.php?id=tom_tongcheng&site={$__UserInfo['site_id']}&mod=fabu");exit;
        }
    }
    
    $model_id = intval($_GET['model_id'])>0? intval($_GET['model_id']):0;
    
    if(!empty($model_id)){
        $typeListTmp = C::t('#tom_tongcheng#tom_tongcheng_model_type')->fetch_all_list(" AND model_id={$model_id} "," ORDER BY paixu ASC,id DESC ",0,50);
        if(count($typeListTmp) == 1){
            tomheader('location:'.$_G['siteurl']."plugin.php?id=tom_tongcheng&site={$site_id}&mod=fabu&act=step2&type_id=".$typeListTmp[0]['id']);exit;
        }
    }
    
    if($__UserInfo['editor'] == 1){
        $modelWhereStr = " AND is_show=1 ";
    }else{
        $modelWhereStr = " AND is_show=1 AND only_editor=0 ";
    }
    if($site_id > 1){
        if(!empty($__SitesInfo['model_ids'])){
            $modelWhereStr.= " AND id IN({$__SitesInfo['model_ids']}) ";
        }
    }else{
        $modelWhereStr.= " AND sites_show=0 ";
    }
    $modelListTmp = C::t('#tom_tongcheng#tom_tongcheng_model')->fetch_all_list(" {$modelWhereStr} "," ORDER BY paixu ASC,id DESC ",0,50);
    
    $modelList = array();
    if(is_array($modelListTmp) && !empty($modelListTmp)){
        foreach ($modelListTmp as $key => $value){
            $modelList[$key] = $value;
            if(!preg_match('/^http/', $value['picurl']) ){
                if(strpos($value['picurl'], 'source/plugin/tom_tongcheng/') === FALSE){
                    $picurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'tomwx/'.$value['picurl'];
                }else{
                    $picurl = $value['picurl'];
                }
            }else{
                $picurl = $value['picurl'];
            }
            $modelList[$key]['picurl'] = $picurl;
            
            $typeListTmp = C::t('#tom_tongcheng#tom_tongcheng_model_type')->fetch_all_list(" AND model_id={$value['id']} "," ORDER BY paixu ASC,id DESC ",0,50);
            $modelList[$key]['showType'] = 0;
            if(count($typeListTmp) > 1){
                $modelList[$key]['showType'] = 1;
            }
            $modelList[$key]['typeList'] = $typeListTmp;
        }
    }
    
    $fabu_warning_msg = discuzcode($tongchengConfig['fabu_warning_msg'], 0, 0, 0, 1, 1, 1, 0, 0, 0, 0);
    
    if($__ShowTcshop == 1){
        $tcshopListTmp = C::t('#tom_tcshop#tom_tcshop')->fetch_all_list(" AND status=1 AND shenhe_status=1 "," ORDER BY id DESC ",0,100);
        $tcshopList = array();
        if(is_array($tcshopListTmp) && !empty($tcshopListTmp)){
            foreach ($tcshopListTmp as $key => $value){
                $tcshopList[$key] = $value;
            }
        }
    }
    
    $isGbk = false;
    if (CHARSET == 'gbk') $isGbk = true;
    include template("tom_tongcheng:fabu_step1");  
    
}