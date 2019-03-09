<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/sitesids.php';

# lbs start
if($tcadminConfig['open_sites_lbs'] > 1){
    $tcadminConfig['open_sites'] = 1;
}
if(empty($tongchengConfig['baidu_js_ak'])){
    $tcadminConfig['open_sites_lbs'] = 1;
}
if($site_id > 1 && $__SitesInfo['open_sites'] == 0){
    $tcadminConfig['open_sites'] = 0;
    $tcadminConfig['open_sites_lbs'] = 1;
}
$hotSitesList = $cateSitesList = array();
if($tcadminConfig['open_sites'] == 1){
    $hotSitesList = C::t('#tom_tongcheng#tom_tongcheng_sites')->fetch_all_list(" AND status=1 AND is_hot=1 AND open_sites=1 "," ORDER BY paixu ASC,id DESC ",0,1000);
    $cateSitesListTmp = C::t('#tom_tongcheng#tom_tongcheng_sites_cate')->fetch_all_list(" "," ORDER BY paixu ASC,id DESC ",0,100);
    if(is_array($cateSitesListTmp) && !empty($cateSitesListTmp)){
        foreach ($cateSitesListTmp as $key => $value){
            $cateSitesList[$key] = $value;
            $sitesListTmp = C::t('#tom_tongcheng#tom_tongcheng_sites')->fetch_all_list(" AND status=1 AND cate_id={$value['id']} AND open_sites=1 "," ORDER BY paixu ASC,id DESC ",0,1000);
            $cateSitesList[$key]['sites'] = $sitesListTmp;
        }
    }
}
$ajaxLbsCheckUrl = 'plugin.php?id=tom_tongcheng:ajax&site='.$site_id.'&act=lbs_check';
$ajaxLbsCloseUrl = 'plugin.php?id=tom_tongcheng:ajax&site='.$site_id.'&act=lbs_close&formhash='.$formhash;
if($_GET['lbs_must'] == 1){}else{
    $cookie_lbs = getcookie('tom_tongcheng_sites_lbs');
    if($cookie_lbs && $cookie_lbs == 1){
        $tcadminConfig['open_sites_lbs'] = 1;
    }
}
if($_GET['lbs_no'] == 1){
    $lifeTime = $tcadminConfig['sites_lbs_time'];
    dsetcookie('tom_tongcheng_sites_lbs', 1, $lifeTime);
    $tcadminConfig['open_sites_lbs'] = 1;
    if($__UserInfo['id'] > 0){
        $__UserInfo['site_id']  = $site_id;
        $updateData             = array();
        $updateData['site_id']  = $site_id;
        C::t('#tom_tongcheng#tom_tongcheng_user')->update($__UserInfo['id'],$updateData);
    }
}
$lbs_show = 0;
if($_GET['lbs_show'] == 1){
    $lbs_show = 1;
}
if($_GET['lbs_must'] == 1 || $_GET['lbs_show'] == 1){}else{
    if($site_id == 1 && $tcadminConfig['open_memory'] == 1 && $__UserInfo['id'] > 0 && $__UserInfo['site_id'] > 1){
        $memorySitesInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_sites')->fetch_by_id($__UserInfo['site_id']);
        if($memorySitesInfoTmp['status'] == 1 && $memorySitesInfoTmp['open_sites'] == 1 ){
            tomheader('location:'.$_G['siteurl']."plugin.php?id=tom_tongcheng&site={$__UserInfo['site_id']}&mod=index");exit;
        }
    }
}
# lbs end

$haveModelDingwei = 0;
$openDingweiModelCount = C::t('#tom_tongcheng#tom_tongcheng_model')->fetch_all_count(" AND is_show=1 AND open_dingwei=1 ");
if($openDingweiModelCount > 0){
    $haveModelDingwei = 1;
}

$modelWhereStr = " AND is_show=1 ";
if($site_id > 1){
    if(!empty($__SitesInfo['model_ids'])){
        $modelWhereStr.= " AND id IN({$__SitesInfo['model_ids']}) ";
    }
}else{
    $modelWhereStr.= " AND sites_show=0 ";
}
$modelListTmp = C::t('#tom_tongcheng#tom_tongcheng_model')->fetch_all_list(" {$modelWhereStr} "," ORDER BY paixu ASC,id DESC ",0,50);

$navList = array();
$modelList = array();
$i = 1;
$navCount = 0;
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
        
        $navList[$value['id']]['i'] = $i;
        $navList[$value['id']]['title']     = $value['name'];
        $navList[$value['id']]['picurl']    = $picurl;
        $navList[$value['id']]['link']      = "plugin.php?id=tom_tongcheng&site={$site_id}&mod=list&model_id={$value['id']}";
        
        $i++;
        $navCount++;
    }
}

if($__ShowTcqianggou == 1){
    $showQianggouArr = unserialize($tongchengConfig['index_choose_show']);
    
    $showQianggouBtn = 0;
    if(array_search('1',$showQianggouArr) !== false){
        $showQianggouBtn = 1;
        $ajaxLoadQianggouListUrl = 'plugin.php?id=tom_tcqianggou:ajax&site='.$site_id.'&act=list&tongcheng_show=1&formhash='.$formhash;
    }
    
    $showCouponBtn = 0;
    if(array_search('2',$showQianggouArr) !== false){
        $showCouponBtn = 1;
        $ajaxLoadCouponListUrl = 'plugin.php?id=tom_tcqianggou:ajax&site='.$site_id.'&act=list&tongcheng_show=2&formhash='.$formhash;
    }
}

$navListTmpTmp = C::t('#tom_tongcheng#tom_tongcheng_nav')->fetch_all_list(" AND site_id={$site_id} "," ORDER BY nsort ASC,id DESC ",0,100);
if(is_array($navListTmpTmp) && !empty($navListTmpTmp)){
}else{
    $navListTmpTmp = C::t('#tom_tongcheng#tom_tongcheng_nav')->fetch_all_list(" AND site_id=1 "," ORDER BY nsort ASC,id DESC ",0,100);
}
if(is_array($navListTmpTmp) && !empty($navListTmpTmp)){
    $i = 1;
    $navCount = 0;
    $navListTmp = $navList;
    $navList = array();
    foreach ($navListTmpTmp as $key => $value){
        
        if($__IsMiniprogram == 1 && !empty($jyConfig) && $jyConfig['closed_xiao'] == 1){
            if(strpos($value['link'], 'tom_love') !== FALSE || strpos($value['link'], 'tom_xiangqin') !== FALSE){
                continue;
            }
        }
        
        $navList[$key] = $value;
        $navList[$key]['i'] = $i;
        
        if(!preg_match('/^http/', $value['picurl']) ){
            if(strpos($value['picurl'], 'source/plugin/tom_tongcheng/') === FALSE){
                $picurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'tomwx/'.$value['picurl'];
            }else{
                $picurl = $value['picurl'];
            }
        }else{
            $picurl = $value['picurl'];
        }
        $navList[$key]['picurl'] = $picurl;
        
        if($value['type'] == 1 && $value['model_id'] > 0 && isset($navListTmp[$value['model_id']])){
            $navList[$key]['title']     = $navListTmp[$value['model_id']]['title'];
            $navList[$key]['picurl']    = $navListTmp[$value['model_id']]['picurl'];
            $navList[$key]['link']      = $navListTmp[$value['model_id']]['link'];
        }

		$navList[$key]['link'] = str_replace("{site}",$site_id, $navList[$key]['link']);
        
        $i++;
        $navCount++;
    }
}

$topnewsList = C::t('#tom_tongcheng#tom_tongcheng_topnews')->fetch_all_list(" AND site_id={$site_id} "," ORDER BY paixu ASC,id DESC ",0,10);
if(is_array($topnewsList) && !empty($topnewsList)){
}else{
    $topnewsList = C::t('#tom_tongcheng#tom_tongcheng_topnews')->fetch_all_list(" AND site_id=1 "," ORDER BY paixu ASC,id DESC ",0,10);
}

$focuspicListTmp = C::t('#tom_tongcheng#tom_tongcheng_focuspic')->fetch_all_list(" AND site_id={$site_id} AND type_id=1 "," ORDER BY fsort ASC,id DESC ",0,10);
if(is_array($focuspicListTmp) && !empty($focuspicListTmp)){
}else{
    $focuspicListTmp = C::t('#tom_tongcheng#tom_tongcheng_focuspic')->fetch_all_list(" AND site_id=1 AND type_id=1 "," ORDER BY fsort ASC,id DESC ",0,10);
}
$focuspicList = array();
foreach ($focuspicListTmp as $key => $value) {
    $focuspicList[$key] = $value;    
    if(!preg_match('/^http/', $value['picurl']) ){
        $picurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'tomwx/'.$value['picurl'];
    }else{
        $picurl = $value['picurl'];
    }
    $focuspicList[$key]['picurl'] = $picurl;
}


$commonClicks = C::t('#tom_tongcheng#tom_tongcheng_common')->fetch_all_sun_clicks(" AND id IN({$sql_in_site_ids}) ");
if($site_id == 1){
    $clicksNum = $commonClicks + $tongchengConfig['virtual_clicks'];
}else{
    $clicksNum = $commonClicks + $__SitesInfo['virtual_clicks'];
}

$clicksNumTxt = $clicksNum;
if($clicksNum>1000000){
    $clicksNumTmp = $clicksNum/10000;
    $clicksNumTxt = number_format($clicksNumTmp,0);
}else if($clicksNum>10000){
    $clicksNumTmp = $clicksNum/10000;
    $clicksNumTxt = number_format($clicksNumTmp,2); 
} 

$fabuNum = C::t('#tom_tongcheng#tom_tongcheng')->fetch_all_count("  AND status=1 AND site_id IN({$sql_in_site_ids}) ");
if($site_id == 1){
    $fabuNum = $fabuNum + $tongchengConfig['virtual_fabunum'];
}else{
    $fabuNum = $fabuNum + $__SitesInfo['virtual_fabunum'];
}
$fabuNumTxt = $fabuNum;
if($fabuNum>1000000){
    $fabuNumTmp = $fabuNum/10000;
    $fabuNumTxt = number_format($fabuNumTmp,0);
}else if($fabuNum>10000){
    $fabuNumTmp = $fabuNum/10000;
    $fabuNumTxt = number_format($fabuNumTmp,2); 
} 

$userNum = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_all_count("");
$userNum = $userNum + $tongchengConfig['virtual_users'];
$userNumTxt = $userNum;
if($userNum>1000000){
    $userNumTmp = $userNum/10000;
    $userNumTxt = number_format($userNumTmp,0);
}else if($userNum>10000){
    $userNumTmp = $userNum/10000;
    $userNumTxt = number_format($userNumTmp,2); 
}

if($__ShowTcshop == 1){
    $ruzhuNum = C::t('#tom_tcshop#tom_tcshop')->fetch_all_count("  AND status=1 AND site_id IN({$sql_in_site_ids}) ");
    if($site_id == 1){
        $ruzhuNum = $ruzhuNum + $tongchengConfig['virtual_rznum'];
    }else{
        $ruzhuNum = $ruzhuNum + $__SitesInfo['virtual_rznum'];
    }
    $ruzhuNumTxt = $ruzhuNum;
    if($ruzhuNum>10000){
        $ruzhuNumTmp = $ruzhuNum/10000;
        $ruzhuNumTxt = number_format($ruzhuNumTmp,2); 
    }else if($ruzhuNum>1000000){
        $ruzhuNumTmp = $ruzhuNum/10000;
        $ruzhuNumTxt = number_format($ruzhuNumTmp,0);
    }
}


$logoSrc = "source/plugin/tom_tongcheng/images/logo.png";
if(!empty($tongchengConfig['logo_src'])){
    $logoSrc = $tongchengConfig['logo_src'];
}
$kefuQrcodeSrc = $tongchengConfig['kefu_qrcode'];
if($__SitesInfo['id'] > 1){
    if(!preg_match('/^http/', $__SitesInfo['logo'])){
        if(strpos($__SitesInfo['logo'], 'source/plugin/tom_tongcheng/') === FALSE){
            $logoSrc = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'tomwx/'.$__SitesInfo['logo'];
        }else{
            $logoSrc = $__SitesInfo['logo'];
        }
    }else{
        $logoSrc = $__SitesInfo['logo'];
    }
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

if($__ShowTctoutiao == 1 && $tctoutiaoConfig['tongcheng_index_num'] > 0){
    $tctoutiaoListTmp = C::t('#tom_tctoutiao#tom_tctoutiao')->fetch_all_list(" AND status=1 AND shenhe_status=1 AND site_id IN({$sql_in_site_ids}) "," ORDER BY is_recom DESC,paixu ASC,add_time DESC,id DESC ",0,$tctoutiaoConfig['tongcheng_index_num']);
    $tctoutiaoList = array();
    if(is_array($tctoutiaoListTmp) && !empty($tctoutiaoListTmp)){
        foreach($tctoutiaoListTmp as $key => $value){
            $coverArr = array();
            if($value['type'] == 1){
                $photoListTmp = C::t('#tom_tctoutiao#tom_tctoutiao_photo')->fetch_all_front_list(" AND tctoutiao_id = {$value['id']} AND type = 1 ",'ORDER BY psort ASC,id DESC', 0, 3);
                if(is_array($photoListTmp) && !empty($photoListTmp)){
                    $photoListArr = array();
                    if(count($photoListTmp) < 3){
                        $photoListArr[] = $photoListTmp[0];
                    }else{
                        $photoListArr = $photoListTmp;
                    }
                    foreach($photoListArr as $pk => $pv){
                        $coverArr[] = $pv['picurlTmp'];
                    }
                }
            }else if($value['type'] == 2){
                if($value['tuji_listpic_type'] == 1){
                    $photoListTmp = C::t('#tom_tctoutiao#tom_tctoutiao_photo')->fetch_all_front_list(" AND tctoutiao_id = {$value['id']} AND type = 2 ",'ORDER BY psort ASC,id DESC', 0, 3);
                    if(is_array($photoListTmp) && !empty($photoListTmp)){
                        $photoListArr = array();
                        if(count($photoListTmp) < 3){
                            $photoListArr[] = $photoListTmp[0];
                        }else{
                            $photoListArr = $photoListTmp;
                        }
                        foreach($photoListArr as $tk => $tv){
                            $coverArr[] = $tv['picurlTmp'];
                        }
                    }
                }else{
                    $photoListTmp = C::t('#tom_tctoutiao#tom_tctoutiao_photo')->fetch_all_front_list(" AND tctoutiao_id = {$value['id']} AND type = 1 ",'ORDER BY psort ASC,id DESC', 0, 3);
                    if(is_array($photoListTmp) && !empty($photoListTmp)){
                        $photoListArr = array();
                        if(count($photoListTmp) < 3){
                            $photoListArr[] = $photoListTmp[0];
                        }else{
                            $photoListArr = $photoListTmp;
                        }
                        foreach($photoListArr as $pk => $pv){
                            $coverArr[] = $pv['picurlTmp'];
                        }
                    }
                }
            }else if($value['type'] == 3){
                $photoListTmp = C::t('#tom_tctoutiao#tom_tctoutiao_photo')->fetch_all_front_list(" AND tctoutiao_id = {$value['id']} AND type = 3 ", 'ORDER BY psort ASC, id ASC', 0, 1);
                if(!empty($photoListTmp[0])){
                    $videoPicInfoTmp = $photoListTmp[0];
                    if(!empty($videoPicInfoTmp)){
                       $coverArr[] = $videoPicInfoTmp['picurlTmp'];
                    }
                }
            }
            $template_type = 0;
            if(count($coverArr) == 0){
                $template_type = 3;
            }else if(count($coverArr) == 1){
                $template_type = 1;
            }else if(count($coverArr) == 3){
                $template_type = 2;
            }
            $zuozheInfo = C::t("#tom_tctoutiao#tom_tctoutiao_zuozhe")->fetch_by_id($value['zuozhe_id']);
            $photoCount = 0;
            if($value['type'] == 2){
                $photoCount = C::t('#tom_tctoutiao#tom_tctoutiao_photo')->fetch_all_count(" AND tctoutiao_id = {$value['id']} AND type = 2 ");
            }

            $tctoutiaoList[$key] = $value;
            $tctoutiaoList[$key]['clicks']          = $value['clicks'] + $value['virtual_clicks'];
            $tctoutiaoList[$key]['template_type']   = $template_type;
            $tctoutiaoList[$key]['coverList']       = $coverArr;
            $tctoutiaoList[$key]['zuozheInfo']      = $zuozheInfo;
            $tctoutiaoList[$key]['photoCount']      = $photoCount;
        }
    }
}

if($__ShowTcshop == 1){
    $tcshopOrderByStr = 'ORDER BY id DESC';
    if($tcshopConfig['index_shop_paixu'] == 1){
        $tcshopOrderByStr = "ORDER BY topstatus DESC, vip_level DESC,clicks DESC,id DESC";
    }else if($tcshopConfig['index_shop_paixu'] == 2){
        $tcshopOrderByStr = 'ORDER BY id DESC';
    }
    $tcshopListTmp = C::t('#tom_tcshop#tom_tcshop')->fetch_all_list(" AND status=1 AND shenhe_status=1 AND site_id IN({$sql_in_site_ids}) ",$tcshopOrderByStr,0,intval($tcshopConfig['index_shop_num']));
    $tcshopList = array();
    if(is_array($tcshopListTmp) && !empty($tcshopListTmp)){
        foreach ($tcshopListTmp as $key => $value){
            $tcshopList[$key] = $value;
            if(!preg_match('/^http/', $value['picurl']) ){
                if(strpos($value['picurl'], 'source/plugin/tom_tcshop/') === FALSE){
                    $picurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'tomwx/'.$value['picurl'];
                }else{
                    $picurl = $value['picurl'];
                }
            }else{
                $picurl = $value['picurl'];
            }
            $tcshopList[$key]['picurl'] = $picurl;
            
            if($value['vip_level'] > 0 && !empty($value['video_url'])){
                if(strpos($value['video_url'], 'youku.com') !== FALSE){
                    $video_type = 1;
                }else if(strpos($value['video_url'], 'qq.com') !== FALSE){
                    $video_type = 1;
                }else{
                    $video_type = 2;
                }
            }else{
                $video_type = 0;
            }

            $tcshopList[$key]['video_type'] = $video_type;
            
            if($tcshopConfig['open_list_area'] == 2){
                $areaInfo = C::t('#tom_tongcheng#tom_tongcheng_district')->fetch_by_id($value['area_id']);
                $streetInfo = C::t('#tom_tongcheng#tom_tongcheng_district')->fetch_by_id($value['street_id']);
                $tcshopList[$key]['address'] = $areaInfo['name'].'&nbsp;'.$streetInfo['name'];
            }
            
        }
    }

    $newTcshopList = C::t('#tom_tcshop#tom_tcshop')->fetch_all_list(" AND status=1 AND shenhe_status=1 AND site_id IN({$sql_in_site_ids}) "," ORDER BY id DESC ",0,10);
}

$str_replace_search_array   = array('{LOVE}','{YIKATONG}','{114}','{KANJIA}','{PINTUAN}','{HONGBAO}','{QIANGGOU}','{HAODIAN}','{HEHUOREN}','{RUZHU}','{FABU}','{MALL}','{XIANGQIN}','{TOUTIAO}');
$str_replace_search_replace = array(
    "plugin.php?id=tom_love&mod=index",
    "plugin.php?id=tom_tcyikatong&site={$site_id}&mod=index",
    "plugin.php?id=tom_tc114&site={$site_id}&mod=index",
    "plugin.php?id=tom_tckjia&site={$site_id}&mod=index",
    "plugin.php?id=tom_tcptuan&site={$site_id}&mod=index",
    "plugin.php?id=tom_tchongbao&site={$site_id}&mod=index",
    "plugin.php?id=tom_tcqianggou&site={$site_id}&mod=index",
    "plugin.php?id=tom_tcshop&site={$site_id}&mod=index",
    "plugin.php?id=tom_tchehuoren&site={$site_id}&mod=inlet",
    "plugin.php?id=tom_tcshop&site={$site_id}&mod=ruzhu",
    "plugin.php?id=tom_tongcheng&site={$site_id}&mod=fabu",
    "plugin.php?id=tom_tcmall&site={$site_id}&mod=index",
    "plugin.php?id=tom_xiangqin&mod=index",
    "plugin.php?id=tom_tctoutiao&site={$site_id}&mod=index",
);
if($site_id > 1){
    $__SitesInfo['index_color_menu'] = trim($__SitesInfo['index_color_menu']);
    $__SitesInfo['index_white_menu'] = trim($__SitesInfo['index_white_menu']);
    if(!empty($__SitesInfo['index_color_menu'])){
        $tongchengConfig['index_color_menu'] = $__SitesInfo['index_color_menu'];
    }
    if(!empty($__SitesInfo['index_white_menu'])){
        $tongchengConfig['index_white_menu'] = $__SitesInfo['index_white_menu'];
    }
}
$colorMenuList = $whiteMenuList = array();
if(!empty($tongchengConfig['index_color_menu'])){
    $index_color_menu_str = str_replace($str_replace_search_array, $str_replace_search_replace, $tongchengConfig['index_color_menu']);
    $index_color_menu_str = str_replace("\r\n","{n}",$index_color_menu_str); 
    $index_color_menu_str = str_replace("\n","{n}",$index_color_menu_str);
    $index_color_menu_arr = explode("{n}", $index_color_menu_str);
    if(is_array($index_color_menu_arr) && !empty($index_color_menu_arr)){
        foreach ($index_color_menu_arr as $key => $value){
            if($__IsMiniprogram == 1 && !empty($jyConfig) && $jyConfig['closed_xiao'] == 1){
                if(strpos($value, 'tom_love') !== FALSE || strpos($value, 'tom_xiangqin') !== FALSE){}else{
                    $colorMenuList[$key] = explode("|", $value);
                }
            }else{
                $colorMenuList[$key] = explode("|", $value);
            }
        }
    }
}
if(!empty($tongchengConfig['index_white_menu'])){
    $index_white_menu_str = str_replace($str_replace_search_array, $str_replace_search_replace, $tongchengConfig['index_white_menu']);
    $index_white_menu_str = str_replace("\r\n","{n}",$index_white_menu_str); 
    $index_white_menu_str = str_replace("\n","{n}",$index_white_menu_str);
    $index_white_menu_arr = explode("{n}", $index_white_menu_str);
    if(is_array($index_white_menu_arr) && !empty($index_white_menu_arr)){
        foreach ($index_white_menu_arr as $key => $value){
            if($__IsMiniprogram == 1 && !empty($jyConfig) && $jyConfig['closed_xiao'] == 1){
                if(strpos($value, 'tom_love') !== FALSE || strpos($value, 'tom_xiangqin') !== FALSE){}else{
                    $whiteMenuList[$key] = explode("|", $value);
                }
            }else{
                $whiteMenuList[$key] = explode("|", $value);
            }
        }
    }
}

$md5HostUrl = md5($_G['siteurl']."plugin.php?id=tom_tongcheng&site={$site_id}&mod=index");

$fabuUrl = "plugin.php?id=tom_tongcheng&site={$site_id}&mod=fabu&model_id=";

if($__ShowTchehuoren == 1){
    $tchehuorenInfoTmp = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_by_user_id($__UserInfo['id']);
    if($tchehuorenInfoTmp && $tchehuorenInfoTmp['status'] == 1){
        $shareUrl   = $shareUrl."&tjid={$tchehuorenInfoTmp['id']}";
    }
}

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
include template("tom_tongcheng:index");