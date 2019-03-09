<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$site_id = intval($_GET['site'])>0? intval($_GET['site']):1;

session_start();
loaducenter();
$formhash = FORMHASH;
$tongchengConfig = $_G['cache']['plugin']['tom_tongcheng'];
$tomSysOffset = getglobal('setting/timeoffset');
$nowYear = dgmdate($_G['timestamp'], 'Y',$tomSysOffset);
$nowDayTime = gmmktime(0,0,0,dgmdate($_G['timestamp'], 'n',$tomSysOffset),dgmdate($_G['timestamp'], 'j',$tomSysOffset),dgmdate($_G['timestamp'], 'Y',$tomSysOffset)) - $tomSysOffset*3600;
$appid = trim($tongchengConfig['wxpay_appid']);
$appsecret = trim($tongchengConfig['wxpay_appsecret']);

include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/login_ajax.php';

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
## tcyikatong start
$__ShowTcyikatong = 0;
$tcyikatongConfig = array();
if(file_exists(DISCUZ_ROOT.'./source/plugin/tom_tcyikatong/tom_tcyikatong.inc.php')){
    $tcyikatongConfig = $_G['cache']['plugin']['tom_tcyikatong'];
    if($tcyikatongConfig['open_tcyikatong'] == 1){
        $__ShowTcyikatong = 1;
    }
}
## tcyikatong end
## tchongbao start
$__ShowTchongbao = 0;
$__TchongbaoHost = '';
if(file_exists(DISCUZ_ROOT.'./source/plugin/tom_tchongbao/tom_tchongbao.inc.php')){
    $tchongbaoConfig = $_G['cache']['plugin']['tom_tchongbao'];
    if($tchongbaoConfig['open_tchongbao'] == 1){
        $__ShowTchongbao = 1;
        if($tchongbaoConfig['open_only_hosts'] == 1 && !empty($tchongbaoConfig['tongcheng_hosts']) && !empty($tchongbaoConfig['hongbao_hosts'])){
            $__TchongbaoHost = str_replace($tchongbaoConfig['tongcheng_hosts'], $tchongbaoConfig['hongbao_hosts'], $_G['siteurl']);
            if($tchongbaoConfig['must_http'] == 1){
                $__TchongbaoHost = str_replace("https", "http", $__TchongbaoHost);
            }
        }
    }
}
## tchongbao end

include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/class/function.core.php';
include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/class/qqface.php';
include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/class/link.func.php';

$latitude = getcookie('tom_tongcheng_user_latitude');
$longitude = getcookie('tom_tongcheng_user_longitude');

if($_GET['act'] == 'list' && $_GET['formhash'] == FORMHASH){
    
    $outStr = '';
    
    $tcshop_id  = intval($_GET['tcshop_id'])>0? intval($_GET['tcshop_id']):0;
    $model_id   = intval($_GET['model_id'])>0? intval($_GET['model_id']):0;
    $model_ids  = isset($_GET['model_ids'])? daddslashes($_GET['model_ids']):'';
    $type_id    = intval($_GET['type_id'])>0? intval($_GET['type_id']):0;
    $cate_id    = intval($_GET['cate_id'])>0? intval($_GET['cate_id']):0;
    $user_id    = intval($_GET['user_id'])>0? intval($_GET['user_id']):0;
    $city_id    = intval($_GET['city_id'])>0? intval($_GET['city_id']):0;
    $area_id    = intval($_GET['area_id'])>0? intval($_GET['area_id']):0;
    $street_id  = intval($_GET['street_id'])>0? intval($_GET['street_id']):0;
    $keyword    = isset($_GET['keyword'])? daddslashes(diconv(urldecode($_GET['keyword']),'utf-8')):'';
    $page       = intval($_GET['page'])>0? intval($_GET['page']):1;
    $pagesize   = intval($_GET['pagesize'])>0? intval($_GET['pagesize']):6;
    $ordertype  = !empty($_GET['ordertype'])? addslashes($_GET['ordertype']):'new';
    $sfcChufa   = isset($_GET['chufa'])? daddslashes(diconv(urldecode($_GET['chufa']),'utf-8')):'';
    $sfcMude    = isset($_GET['mude'])? daddslashes(diconv(urldecode($_GET['mude']),'utf-8')):'';

    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/sitesids.php';
    
    $nearby = 0;
    if($model_id == 999999){
        $model_id = 0;
        $nearby = 1;
    }

    $whereStr = ' AND status=1 AND shenhe_status=1 ';
    $sfcWhere = "";
    if(!empty($sql_in_site_ids)){
        $whereStr.= " AND site_id IN({$sql_in_site_ids}) ";
        $sfcWhere .= " AND site_id IN({$sql_in_site_ids}) ";
    }
    if(!empty($tcshop_id)){
        $whereStr.= " AND tcshop_id={$tcshop_id} ";
    }
    if(!empty($model_id)){
        $whereStr.= " AND model_id={$model_id} ";
    }
    if(!empty($model_ids)){
        $model_ids_arr = explode('|', $model_ids);
        $modelIdsArr = array();
        if(is_array($model_ids_arr) && !empty($model_ids_arr)){
            foreach ($model_ids_arr as $key => $value){
                $value = (int)$value;
                if(!empty($value)){
                    $modelIdsArr[] = $value;
                }
            }
        }
        if(!empty($modelIdsArr)){
            $whereStr.= " AND model_id in(".  implode(',', $modelIdsArr).") ";
        }
    }
    if(!empty($type_id)){
        $whereStr.= " AND type_id={$type_id} ";
    }
    if(!empty($cate_id)){
        $whereStr.= " AND cate_id={$cate_id} ";
    }
    if(!empty($user_id)){
        $whereStr.= " AND user_id={$user_id} ";
    }
    if(!empty($city_id)){
        $whereStr.= " AND city_id={$city_id} ";
    }
    if(!empty($area_id)){
        $whereStr.= " AND area_id={$area_id} ";
    }
    if(!empty($street_id)){
        $whereStr.= " AND street_id={$street_id} ";
    }

    $orderStr = " ORDER BY refresh_time DESC,id DESC ";
    $showTop = 0;
    if(!empty($model_id) || !empty($model_ids) || !empty($type_id) || !empty($cate_id) || !empty($keyword)){
        $showTop = 1;
        $orderStr = " ORDER BY topstatus DESC, toprand DESC, refresh_time DESC,id DESC ";
    }
    if($tongchengConfig['new_show_top'] == 1){
        $showTop = 1;
        $orderStr = " ORDER BY topstatus DESC,toprand DESC, refresh_time DESC,id DESC ";
    }
    
    $sfcModelInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_model')->fetch_all_list(' AND is_sfc = 1 ', 'ORDER BY id DESC', 0, 1);
    $sfcModel_id = 0;
    if(is_array($sfcModelInfoTmp) && !empty($sfcModelInfoTmp[0])){
        $sfcModel_id = $sfcModelInfoTmp['0']['id'];
    }
    if($tongchengConfig['new_show_sfc'] == 0 && $model_id == 0 && $sfcModel_id > 0){
        $whereStr .= " AND model_id != {$sfcModel_id} ";
    }

    if($sfcModel_id > 0 && $sfcModel_id == $model_id && (!empty($sfcChufa) || !empty($sfcMude))){
        
        $maxSearchTime = TIMESTAMP - (12 * 30 * 86400);
        
        $sfcWhere .= " AND chufa_int_time > {$maxSearchTime}";
        
        $sfcCacheIds = array();
        if(!empty($sfcChufa) && !empty($sfcMude)){
            $sfcCacheInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_sfc_cache')->fetch_search_list($sfcWhere, 'ORDER BY add_time DESC,id DESC', 0, 10000, $sfcChufa, $sfcMude);
        }else if(!empty($sfcChufa)){
            $sfcCacheInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_sfc_cache')->fetch_search_list($sfcWhere, 'ORDER BY add_time DESC,id DESC', 0, 10000, $sfcChufa);
        }else if(!empty($sfcMude)){
            $sfcCacheInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_sfc_cache')->fetch_search_list($sfcWhere, 'ORDER BY add_time DESC,id DESC', 0, 10000, '', $sfcMude);
        }
        
        if(is_array($sfcCacheInfoTmp) && !empty($sfcCacheInfoTmp)){
            foreach($sfcCacheInfoTmp as $key => $value){
                $sfcCacheIds[] = $value['tongcheng_id'];
            }
        }
        $sfc_cache_ids = implode(',', $sfcCacheIds);
        if(!empty($sfc_cache_ids)){
            $whereStr = " AND id IN({$sfc_cache_ids}) ";
        }else{
            $outStr = '205';
            $outStr = diconv($outStr,CHARSET,'utf-8');
            echo json_encode($outStr); exit;
        }
    }
    
    if($sfcModel_id > 0 && $sfcModel_id == $model_id){
        $orderStr = " ORDER BY topstatus DESC,toprand DESC, finish ASC,id DESC ";
    }

    $pagesize = $pagesize;
    $start = ($page - 1)*$pagesize;
    if($nearby == 1 && !empty($latitude) && !empty($longitude)){
        $tongchengListTmp = C::t('#tom_tongcheng#tom_tongcheng')->fetch_all_nearby_list($whereStr,$start,$pagesize,$latitude,$longitude);
    }else{
        $tongchengListTmp = C::t('#tom_tongcheng#tom_tongcheng')->fetch_all_list($whereStr,$orderStr,$start,$pagesize,$keyword);
    }
    
    $tongchengList = array();
    foreach ($tongchengListTmp as $key => $value) {
        
        $modelInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_model')->fetch_by_id($value['model_id']);
        $typeInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_model_type')->fetch_by_id($value['type_id']);
        
        if($modelInfoTmp['is_show'] != 1){
            continue;
        }
        
        if($value['topstatus'] == 0 && $typeInfoTmp['over_time_attr_id'] > 0 && $typeInfoTmp['over_time_do'] > 0){
            $tongchengAttrInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_attr')->fetch_all_list(" AND tongcheng_id={$value['id']} AND attr_id={$typeInfoTmp['over_time_attr_id']} "," ORDER BY id DESC ",0,1);
            if(is_array($tongchengAttrInfoTmp) && !empty($tongchengAttrInfoTmp) && $tongchengAttrInfoTmp[0] && $tongchengAttrInfoTmp[0]['time_value'] > 0){
                if($tongchengAttrInfoTmp[0]['time_value'] < TIMESTAMP){
                    if($typeInfoTmp['over_time_do'] == 1){
                        $value['finish'] = 1;
                        DB::query("UPDATE ".DB::table('tom_tongcheng')." SET status=2,finish=1 WHERE id='{$value['id']}' ", 'UNBUFFERED');
                    }else if($typeInfoTmp['over_time_do'] == 2){
                        $value['finish'] = 1;
                        DB::query("UPDATE ".DB::table('tom_tongcheng')." SET finish=1 WHERE id='{$value['id']}' ", 'UNBUFFERED');
                    }
                }
            }
        }
        
        if($typeInfoTmp['jifei_type'] == 2 && $value['over_days'] > 0){
            if($value['topstatus'] == 0 && $value['finish'] == 0){
                if($value['over_time'] < TIMESTAMP){
                    if($tongchengConfig['over_time_do'] == 1){
                        $value['finish'] = 1;
                        DB::query("UPDATE ".DB::table('tom_tongcheng')." SET finish=1 WHERE id='{$value['id']}' ", 'UNBUFFERED');
                    }else if($tongchengConfig['over_time_do'] == 2){
                        $value['finish'] = 1;
                        DB::query("UPDATE ".DB::table('tom_tongcheng')." SET status=2,finish=1 WHERE id='{$value['id']}' ", 'UNBUFFERED');
                    }else if($tongchengConfig['over_time_do'] == 4){
                        DB::query("UPDATE ".DB::table('tom_tongcheng')." SET status=2 WHERE id='{$value['id']}' ", 'UNBUFFERED');
                    }
                }
            }
        }else{
            if($value['topstatus'] == 0 && $value['finish'] == 0 && $tongchengConfig['over_time_limit'] > 0){
                if(($value['refresh_time']+$tongchengConfig['over_time_limit']*86400) < TIMESTAMP){
                    if($tongchengConfig['over_time_do'] == 1){
                        $value['finish'] = 1;
                        DB::query("UPDATE ".DB::table('tom_tongcheng')." SET finish=1 WHERE id='{$value['id']}' ", 'UNBUFFERED');
                    }else if($tongchengConfig['over_time_do'] == 2){
                        $value['finish'] = 1;
                        DB::query("UPDATE ".DB::table('tom_tongcheng')." SET status=2,finish=1 WHERE id='{$value['id']}' ", 'UNBUFFERED');
                    }else if($tongchengConfig['over_time_do'] == 4){
                        DB::query("UPDATE ".DB::table('tom_tongcheng')." SET status=2 WHERE id='{$value['id']}' ", 'UNBUFFERED');
                    }
                }
            }
        }
        
        $tongchengList[$key] = $value;
        $tongchengList[$key]['content'] = contentFormat($value['content']);
        
        $userInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($value['user_id']); 
        $siteInfoTmp = array('id'=>1,'name'=>$tongchengConfig['plugin_name']);
        if($value['site_id'] > 1){
            $siteInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_sites')->fetch_by_id($value['site_id']);
        }
        
        $cateInfoTmp = array();
        if($value['cate_id'] > 0){
            $cateInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_model_cate')->fetch_by_id($value['cate_id']);
        }
        
        $tongchengList[$key]['area_street'] = '';
        $areaNameTmp = '';
        if(!empty($value['area_id'])){
            $areaInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_district')->fetch_by_id($value['area_id']);
            $areaNameTmp = $areaInfoTmp['name'];
        }
        $streetNameTmp = '';
        if(!empty($value['street_id'])){
            $streetInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_district')->fetch_by_id($value['street_id']);
            $streetNameTmp = $streetInfoTmp['name'];
        }
        if(!empty($areaNameTmp) && !empty($streetNameTmp)){
            $tongchengList[$key]['area_street'] = $areaNameTmp." ".$streetNameTmp;
        }
        
        $tchongbaoInfo = array();
        if($__ShowTchongbao == 1){
            $tchongbaoInfoTmp = C::t('#tom_tchongbao#tom_tchongbao')->fetch_all_list(" AND tongcheng_id = {$value['id']} AND pay_status = 2 AND only_show = 1 ", 'ORDER BY add_time DESC,id DESC', 0, 1);
            if(is_array($tchongbaoInfoTmp) && !empty($tchongbaoInfoTmp[0])){
                $tchongbaoInfo = $tchongbaoInfoTmp[0];
            }
        }
        
        $tongchengAttrListTmp = C::t('#tom_tongcheng#tom_tongcheng_attr')->fetch_all_list(" AND tongcheng_id={$value['id']} "," ORDER BY paixu ASC,id DESC ",0,50);
        $tongchengTagListTmp = C::t('#tom_tongcheng#tom_tongcheng_tag')->fetch_all_list(" AND tongcheng_id={$value['id']} "," ORDER BY id DESC ",0,50);
        $tongchengPhotoListTmpTmp = C::t('#tom_tongcheng#tom_tongcheng_photo')->fetch_all_list(" AND tongcheng_id={$value['id']} "," ORDER BY id ASC ",0,50);
        $tongchengPhotoListTmp = array();
        $tongchengAlbumListTmp = array();
        if(is_array($tongchengPhotoListTmpTmp) && !empty($tongchengPhotoListTmpTmp)){
            foreach ($tongchengPhotoListTmpTmp as $kk => $vv){
                if($tongchengConfig['open_yun'] == 2 && !empty($vv['oss_picurl']) && $vv['oss_status'] == 1){
                    $picurl = $vv['oss_picurl'];
                    //$picurl = $vv['oss_picurl'].'?x-oss-process=image/resize,m_fill,h_120,w_120';
                    $albumurl = $vv['oss_picurl'];
                }else if($tongchengConfig['open_yun'] == 3 && !empty($vv['qiniu_picurl']) && $vv['qiniu_status'] == 1){
                    $picurl = $vv['qiniu_picurl'];
                    //$picurl = $vv['qiniu_picurl'].'?imageView2/1/w/120/h/120';
                    $albumurl = $vv['qiniu_picurl'];
                }else{
                    if(!preg_match('/^http/', $vv['picurl']) ){
                        if(strpos($vv['picurl'], 'source/plugin/tom_tongcheng/data/') === false){
                            $picurl = $albumurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'tomwx/'.$vv['picurl'];
                        }else{
                            $picurl = $albumurl = $_G['siteurl'].$vv['picurl'];
                        }
                    }else{
                        $picurl = $albumurl = $vv['picurl'];
                    }
                }
                $tongchengPhotoListTmp[$kk]['picurl'] = $picurl;
                $tongchengPhotoListTmp[$kk]['albumurl'] = $albumurl;
                $tongchengAlbumListTmp[$kk] = $albumurl;
            }
        }
        
        $pinglunListTmp = C::t('#tom_tongcheng#tom_tongcheng_pinglun')->fetch_all_list(" AND tongcheng_id = {$value['id']} ", 'ORDER BY ping_time DESC,id DESC', 0, 5);
        $pinglunCount = C::t('#tom_tongcheng#tom_tongcheng_pinglun')->fetch_all_count(" AND tongcheng_id = {$value['id']} ");
        
        $tongchengList[$key]['userInfo'] = $userInfoTmp;
        $tongchengList[$key]['modelInfo'] = $modelInfoTmp;
        $tongchengList[$key]['typeInfo'] = $typeInfoTmp;
        $tongchengList[$key]['cateInfo'] = $cateInfoTmp;
        $tongchengList[$key]['attrList'] = $tongchengAttrListTmp;
        $tongchengList[$key]['tagList']  = $tongchengTagListTmp;
        $tongchengList[$key]['photoList'] = $tongchengPhotoListTmp;
        $tongchengList[$key]['albumList'] = $tongchengAlbumListTmp;
        $tongchengList[$key]['siteInfo'] = $siteInfoTmp;
        $tongchengList[$key]['tchongbaoInfo'] = $tchongbaoInfo;
        $tongchengList[$key]['pinglunList'] = $pinglunListTmp;
        $tongchengList[$key]['pinglunCount'] = $pinglunCount;
        
        $tongchengList[$key]['tcshopInfo'] = array();
        if($__ShowTcshop == 1 && $value['tcshop_id'] > 0){
            $tcshopInfo = C::t('#tom_tcshop#tom_tcshop')->fetch_by_id($value['tcshop_id']);
            if($tcshopInfo){
                if(!preg_match('/^http/', $tcshopInfo['picurl']) ){
                    if(strpos($tcshopInfo['picurl'], 'source/plugin/tom_tcshop/') === FALSE){
                        $picurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'tomwx/'.$tcshopInfo['picurl'];
                    }else{
                        $picurl = $tcshopInfo['picurl'];
                    }
                }else{
                    $picurl = $tcshopInfo['picurl'];
                }
                $tcshopInfo['picurl'] = $picurl;
                $tongchengList[$key]['tcshopInfo'] = $tcshopInfo;
            }
        }
    }

    if(is_array($tongchengList) && !empty($tongchengList)){
        $i = 0;
        foreach ($tongchengList as $key => $val){
            $i++;
            if($tongchengConfig['open_load_list_clicks'] == 1){
                DB::query("UPDATE ".DB::table('tom_tongcheng')." SET clicks=clicks+1 WHERE id='{$val['id']}' ", 'UNBUFFERED');
            }
            $messageUrl = 'plugin.php?id=tom_tongcheng&site='.$site_id.'&mod=message&act=create&tongcheng_id='.$val['id'].'&to_user_id='.$val['userInfo']['id'].'&formhash='.FORMHASH;
            $tousuUrl = 'plugin.php?id=tom_tongcheng&site='.$site_id.'&mod=tousu&tongcheng_id='.$val['id'];
            
            if(!empty($val['tchongbaoInfo'])){
                $infoUrl = $__TchongbaoHost.'plugin.php?id=tom_tongcheng&site='.$site_id.'&mod=hbao&xxid='.$val['id'];
            }else{
                $infoUrl = 'plugin.php?id=tom_tongcheng&site='.$site_id.'&mod=view&xxid='.$val['id'];
            }
            
            if($sfcModel_id > 0 && $sfcModel_id == $model_id){
                $sfcCacheInfo = C::t('#tom_tongcheng#tom_tongcheng_sfc_cache')->fetch_by_tongcheng_id($val['id']);
                
                $sfcCacheInfo['chufa'] = cutstr($sfcCacheInfo['chufa'], 8, '..');
                $sfcCacheInfo['mude'] = cutstr($sfcCacheInfo['mude'], 8, '..');
                
                if(is_array($sfcCacheInfo) && !empty($sfcCacheInfo)){}else{continue;}
                
                $outStr .= '<div class="sfcline-item">';
                    $outStr .= '<div class="sfcline-item__hd">';
                        $outStr .= '<div class="sfc-hd__lt">';
                            if($showTop == 1 && $val['topstatus'] == 1){
                                $outStr .= '<span><a style="background-color: #f15555;">'.lang("plugin/tom_tongcheng", "top").'</a></span>&nbsp; ';
                            }
                            $outStr.= '<span class="tc-template__bg"><a class="tc-template__bg" href="plugin.php?id=tom_tongcheng&site='.$site_id.'&mod=list&type_id='.$val['typeInfo']['id'].'">'.$val['typeInfo']['name'].'</a></span>&nbsp; ';
                            $outStr .= '<a href="'.$infoUrl.'">'.$sfcCacheInfo['chufa'].'<span class="goin"></span>'.$sfcCacheInfo['mude'];
                            if(!empty($val['tchongbaoInfo'])){
                                $outStr .= '&nbsp;<span style="background:#fb3939;padding: 0 5px;">'.lang("plugin/tom_tongcheng", "template_sfc_hongbao").'</span>&nbsp; ';
                            }
                            $outStr .= '</a></div>';
                        //if(($val['refresh_time'] - $val['add_time']) > 3600){
                            //$outStr .= '<div class="sfc-hd__rt">'.lang("plugin/tom_tongcheng", "template_refresh_title").dgmdate($val['refresh_time'], 'u','9999','m-d H:i').'</div>';
                        //}else{
                            $sfc_refresh_time = dgmdate($val['refresh_time'], 'u','9999','m-d H:i');
                            if(strpos($sfc_refresh_time, '201') !== FALSE || strpos($sfc_refresh_time, '202') !== FALSE){
                                $outStr .= '<div class="sfc-hd__rt">'.dgmdate($val['refresh_time'],"m-d H:i",$tomSysOffset).'</div>';
                            }else{
                                $outStr .= '<div class="sfc-hd__rt">'.$sfc_refresh_time.'</div>';
                            }
                        //}
                    $outStr .= '</div>';
                    $outStr .= '<div class="sfcline-item__times sfcline-item__renshu">';
                        $outStr .= '<a class="sfc-times__lt" href="'.$infoUrl.'">'.lang('plugin/tom_tongcheng', 'template_sfc_chufa_renshu').$sfcCacheInfo['renshu'].'</a>';
                    $outStr .= '</div>';
                    $outStr .= '<div class="sfcline-item__times sfcline-item__time">';
                        $outStr .= '<a class="sfc-times__lt" href="'.$infoUrl.'">'.lang('plugin/tom_tongcheng', 'template_sfc_chufa_time').$sfcCacheInfo['chufa_time'].'</a>';
                    $outStr .= '</div>';
                    $outStr .= '<div class="sfcline-item__tags">';
                        foreach ($val['tagList'] as $k1 => $v1){
                            $outStr.= '<span class="sfcline-tags__area span'.$k1.'">'.$v1['tag_name'].'</span>';
                        }
                    $outStr .= '</div>';
                    if(!empty($val['content'])){
                        $outStr .= '<a class="sfcline-item__bd" href="'.$infoUrl.'">'.$val['content'].'</a>';
                    }
                    if($val['finish'] == 1){
                        $outStr .= '<a class="sfcline-item__tel" style="background: #dedede;" href="javascript:void(0);"><i></i>'.lang('plugin/tom_tongcheng', 'template_sfc_tel').'</a>';
                        $outStr .= '<div class="sfcline-complete"></div>';
                    }else{
                        if($val['typeInfo']['open_tel_price'] == 1){
                            $outStr .= '<a class="sfcline-item__tel tc-template__bg" href="'.$infoUrl.'"><i></i>'.lang('plugin/tom_tongcheng', 'template_sfc_tel').'</a>';
                        }else{
                            $outStr .= '<a class="sfcline-item__tel tc-template__bg" href="tel:'.$val['tel'].'"><i></i>'.lang('plugin/tom_tongcheng', 'template_sfc_tel').'</a>';
                        }
                    }
                $outStr .= '</div>';
                
            }else{
            
                $outStr.= '<div class="tcline-item">';
                       $outStr.= '<div class="avatar-label">';
                            $outStr.= '<a href="plugin.php?id=tom_tongcheng&site='.$site_id.'&mod=home&uid='.$val['userInfo']['id'].'"><img src="'.$val['userInfo']['picurl'].'" class="avatar" /></a>';
                            if(!empty($val['tchongbaoInfo']) && $val['tchongbaoInfo']['status'] == 1){
                                $outStr.= '<a class="hb-label" href="'.$infoUrl.'">';
                                    $outStr.= '<img src="source/plugin/tom_tchongbao/images/list-hongbao.png">';
                                $outStr.= '</a>';
                            }
                       $outStr.= '</div>';
                       $outStr.= '<div class="tcline-detail" data-id='.$val['id'].'>';
                            if($showTop == 1 && $val['topstatus'] == 1){
                                $outStr.= '<span><a style="background-color: #f15555;">'.lang("plugin/tom_tongcheng", "top").'</a></span>&nbsp; ';
                            }
                            $outStr.= '<span class="tc-template__bg"><a class="tc-template__bg" href="plugin.php?id=tom_tongcheng&site='.$site_id.'&mod=list&type_id='.$val['typeInfo']['id'].'">'.$val['typeInfo']['name'].'</a></span>&nbsp; ';
                            if($tongchengConfig['list_title_type'] == 1){
                                $outStr.= '<a class="username" href="plugin.php?id=tom_tongcheng&site='.$site_id.'&mod=home&uid='.$val['userInfo']['id'].'">'.$val['userInfo']['nickname'].'</a>';
                            }else if($tongchengConfig['list_title_type'] == 2){
                                $outStr.= '<a class="username" href="plugin.php?id=tom_tongcheng&site='.$site_id.'&mod=home&uid='.$val['userInfo']['id'].'">'.$val['xm'].'</a>';
                            }else if($tongchengConfig['list_title_type'] == 3 && !empty ($val['title'])){
                                $outStr.= '<a class="username" href="'.$infoUrl.'">'.$val['title'].'</a>';
                            }else{
                                $outStr.= '<a class="username" href="plugin.php?id=tom_tongcheng&site='.$site_id.'&mod=home&uid='.$val['userInfo']['id'].'">'.$val['userInfo']['nickname'].'</a>';
                            }
                            if ($val['tchongbaoInfo']['status'] == 1){
                                $outStr.= '<a href="'.$infoUrl.'" class="ext-act tchongbao"><i class="tciconfont tcicon-hongbao"></i> '.lang('plugin/tom_tongcheng', 'ajax_qiang_hb').' </a>';
                            }else{
                                $outStr.= '<a href="'.$infoUrl.'" class="ext-act"><i class="tciconfont tcicon-yanjing"></i>'.lang("plugin/tom_tongcheng", "template_xiangqing").' </a>';
                            }
                            if(is_array($val['tagList']) && !empty($val['tagList'])){
                                $outStr.= '<article style="max-height: 90px;">';
                            }else{
                                $outStr.= '<article>';
                            }
                            if($tongchengConfig['open_list_quanwen'] == 0){
                                $outStr.= '<a href="'.$infoUrl.'">';
                            }
                                if(is_array($val['tagList']) && !empty($val['tagList'])){
                                 $outStr.= '<div class="detail-tags">';
                                     foreach ($val['tagList'] as $k1 => $v1){
                                      $outStr.= '<span class="span'.$k1.'">'.$v1['tag_name'].'</span>';
                                     }
                                      $outStr.= '<div class="clear"></div>';
                                 $outStr.= '</div>';
                                }
                                $val['content'] = str_replace("\r\n","<br/>",$val['content']);
                                $val['content'] = str_replace("\n","<br/>",$val['content']);
                                $val['content'] = str_replace("\r","<br/>",$val['content']);
                                if(is_array($val['cateInfo']) && !empty($val['cateInfo'])){
                                    $outStr.= '<p><font class="tc-template__color" color="#f60">'.$val['typeInfo']['cate_title'].'&nbsp;:&nbsp;</font>'.$val['cateInfo']['name'].'</p>';
                                }
                                if(is_array($val['attrList']) && !empty($val['attrList'])){
                                     foreach ($val['attrList'] as $k2 => $v2){
                                        if(!empty($v2['value'])){
                                            $outStr.= '<p><font class="tc-template__color" color="#f60">'.$v2['attr_name'].'&nbsp;:&nbsp;</font></b>'.$v2['value'];
                                            if($v2['unit']){
                                                $outStr.= ''.$v2['unit'];
                                            }
                                            $outStr.= '</p>';
                                        }
                                     }
                                 }
                                 if(!empty($val['area_street'])){
                                    $outStr.= '<p><font class="tc-template__color" color="#F60">'.lang("plugin/tom_tongcheng", "template_address").'&nbsp;:&nbsp;</font></b>'.$val['area_street'].'</p>';
                                 }
                                 if($val['typeInfo']['open_tel_price'] == 1){
                                     $val['content'] = preg_replace("/\d{7}/", '*****', $val['content']);
                                 }
                                 $outStr.= '<p>'.$val['content'].'</p>';
                             if($tongchengConfig['open_list_quanwen'] == 0){
                                 $outStr.= '</a>';
                             }
                            $outStr.= '</article>';
                            $outStr.= '<div class="act-bar">';
                                 if($val['finish'] == 0){
                                     if($val['typeInfo']['open_tel_price'] == 1){
                                         $outStr.= '<a href="'.$infoUrl.'" class="act blue"><img src="source/plugin/tom_tongcheng/images/icon-tel.png" style="width: 13px;">&nbsp;'.lang("plugin/tom_tongcheng", "template_tel").'</a>';
                                     }else{
                                         $outStr.= '<a href="tel:'.$val['tel'].'" class="act blue"><img src="source/plugin/tom_tongcheng/images/icon-tel.png" style="width: 13px;">&nbsp;'.lang("plugin/tom_tongcheng", "template_tel").'</a>';
                                     }
                                 }
                                 $outStr.= '<a href="'.$messageUrl.'" class="act"><img src="source/plugin/tom_tongcheng/images/icon-email.png" style="width: 13px;">&nbsp;'.lang("plugin/tom_tongcheng", "template_sms").'</a>';
                            $outStr.= '</div>';
                            $outStr.= '<div class="detail-toggle">'.lang("plugin/tom_tongcheng", "template_quanwen").'</div>';
                            $outStr.= '<div class="detail-toggle2" style="display:none;">'.lang("plugin/tom_tongcheng", "template_shouqi").'</div>';
                            if(is_array($val['photoList']) && !empty($val['photoList'])){
                                $photoListCount = count($val['photoList']);
                                $outStr.= '<div class="detail-pics clearfix"><input type="hidden" name="photo_list" class="photo_list" value="'.implode('|', $val['albumList']).'">';
                                $i_photo = 0;
                                foreach ($val['photoList'] as $k3 => $v3){
                                    $i_photo++;
                                    if($tongchengConfig['open_list_xz_pic'] == 1){
                                        if($i_photo == 3 && $photoListCount > 3){
                                            $outStr.= '<a href="javascript:void(0);" onclick="showPicList($(this),'.($i_photo - 1).');"><img src="'.$v3['picurl'].'"><span class="more-pic">'.lang("plugin/tom_tongcheng", 'template_more_pic_1').'<br/>'.lang("plugin/tom_tongcheng", 'template_more_pic_2').'</span></a>';
                                        }else if($i_photo >= 4){
                                            continue;
                                        }else{
                                            $outStr.= '<a href="javascript:void(0);" onclick="showPicList($(this),'.($i_photo - 1).');"><img src="'.$v3['picurl'].'"></a>';
                                        }
                                    }else{
                                        $outStr.= '<a href="javascript:void(0);" onclick="showPicList($(this),'.($i_photo - 1).');"><img src="'.$v3['picurl'].'"></a>';
                                    }
                                }
                                $outStr.= '</div>';
                            }

                            //if(is_array($val['photoList']) && !empty($val['photoList'])){
                            //    if(is_array($val['tcshopInfo']) && !empty($val['tcshopInfo'])){
                            //        $outStr.= '<a href="plugin.php?id=tom_tcshop&site='.$site_id.'&mod=details&dpid='.$val['tcshopInfo']['id'].'" class="detail-shoplink"><img src="source/plugin/tom_tongcheng/images/detail-shoplink-ico.png" style="width: 13px;">'.$val['tcshopInfo']['name'].'</a>';
                            //    }
                            //}else{
                                if(is_array($val['tcshopInfo']) && !empty($val['tcshopInfo'])){
                                    $outStr.= '<a class="detail-link" href="plugin.php?id=tom_tcshop&site='.$val['tcshopInfo']['site_id'].'&mod=details&dpid='.$val['tcshopInfo']['id'].'" target="_blank"><img src="'.$val['tcshopInfo']['picurl'].'"><b>'.$val['tcshopInfo']['name'].'</b><br><img src="source/plugin/tom_tongcheng/images/detail-link-ico.png" style="width: 12px;height: 17px;margin-right: 0px;">&nbsp;&nbsp;'.$val['tcshopInfo']['address'].'</a>';
                                }
                            //}
                            if($val['modelInfo']['open_dingwei'] == 1 && $val['is_dingwei'] == 1 && !empty($val['address'])){
                                $outStr.= '<div class="detail-dingwei">';
                                    $outStr.= '<i class="tciconfont tcicon-dingwei_shi"></i>'.$val['address'];
                                    if(!empty($longitude) && !empty($latitude)){
                                        $juli = tomGetDistance($longitude, $latitude, $val['longitude'], $val['latitude']);
                                        $outStr.= '<span>'.lang("plugin/tom_tongcheng", "template_juli").$juli.'km</span>';
                                    }
                                $outStr.= '</div>';
                            }
                            $outStr.= '<div class="detail-time">';
                                 $outStr.= '<a>';
                                 //$refresh_log_count = C::t('#tom_tongcheng#tom_tongcheng_refresh_log')->fetch_all_count(" AND tongcheng_id={$val['id']} ");
                                 $outStr.= '<span>'.$val['clicks'].lang("plugin/tom_tongcheng", "template_clicks").'</span>';
                                 //$outStr.= '<span >'.$val['zhuanfa'].lang("plugin/tom_tongcheng", "template_zhuanfa").' </span>';
                                 if(($val['refresh_time'] - $val['add_time']) > 3600){
                                     $outStr.= '<span>'.lang("plugin/tom_tongcheng", "template_refresh_title").dgmdate($val['refresh_time'], 'u','9999','m-d H:i').'</span>';
                                 }else{
                                     $outStr.= '<span>'.dgmdate($val['refresh_time'], 'u','9999','m-d H:i').'</span>';
                                 }

                                 if($tongchengConfig['show_site_name'] == 1){
                                     //$outStr.= '<span>&nbsp;'.lang("plugin/tom_tongcheng", "template_laiyuan").$val['siteInfo']['name'].'</span>';
                                 }
                                 $outStr.= '</a>';
                                 $outStr.= '<div class="detail-time-icon" data-id="'.$val['id'].'" data-message="'.$messageUrl.'" data-tousu="'.$tousuUrl.'" data-tel="tel:'.$val['tel'].'" data-user-id="'.$__UserInfo['id'].'"></div>';

                                 $outStr.= '<div class="detail-toolbar">';
                                    if($tongchengConfig['open_list_pinglun'] == 1){
                                        $outStr.= '<a href="javascript:void(0);" rel="nofolow" class="list-plugin__btn" data-id="'.$val['id'].'"><img src="source/plugin/tom_tongcheng/images/icon_replay.png">'.lang("plugin/tom_tongcheng", "list_tousu_plugin").'</a>';
                                    }
                                    $outStr.= '<a href="javascript:void(0);" onclick="collect('.$__UserInfo['id'].','.$val['id'].');" class="ajax-post"><img src="source/plugin/tom_tongcheng/images/list_zan.png">'.lang("plugin/tom_tongcheng", "list_collect_btn").'</a>';
                                    $outStr.= '<a href="'.$messageUrl.'"><img src="source/plugin/tom_tongcheng/images/icon-message.png">'.lang("plugin/tom_tongcheng", "list_sms_btn").'</a>';
                                    if($val['finish'] == 0){
                                        if($val['typeInfo']['open_tel_price'] == 1){
                                            $outStr.= '<a href="'.$infoUrl.'" class="ajax-get"><img src="source/plugin/tom_tongcheng/images/icon-tel.png">'.lang("plugin/tom_tongcheng", "list_tel_btn").'</a>';
                                        }else{
                                            $outStr.= '<a href="tel:'.$val['tel'].'" class="ajax-get"><img src="source/plugin/tom_tongcheng/images/icon-tel.png">'.lang("plugin/tom_tongcheng", "list_tel_btn").'</a>';
                                        }
                                    }
                                 $outStr.= '</div>';
                                 
                            $outStr.= '</div>';
                            if($val['finish'] == 1){
                                $outStr.= '<section class="mark-img succ"></section>';
                            }
                            
                            if($tongchengConfig['open_list_pinglun'] == 1){
                                if($val['collect'] > 0 || $val['pinglunCount'] > 0){
                                    $outStr.= '<div class="detail-cmt-wrap detail-list__'.$val['id'].'">';
                                }else{
                                    $outStr.= '<div class="detail-cmt-wrap box_hide detail-list__'.$val['id'].'">';
                                }
                                    $outStr.= '<i class="detail-cmtr"></i>';
                                    $outStr.= '<div class="detail-cmt">';
                                        $outStr.= '<div class="like-list detail-collect__'.$val['id'].'">';
                                            $outStr.= '<span class="num">'.$val['collect'].'</span> '.lang("plugin/tom_tongcheng", "template_collect");
                                            if($val['collect'] > 0){
                                                $collectList = C::t('#tom_tongcheng#tom_tongcheng_collect')->fetch_all_list(" AND tongcheng_id={$val['id']} ", 'ORDER BY id DESC', 0, 5);
                                                if(is_array($collectList) && !empty($collectList)){
                                                    foreach($collectList as $kc => $vc){
                                                        $collectUserInfo = C::t("#tom_tongcheng#tom_tongcheng_user")->fetch_by_id($vc['user_id']);
                                                        $outStr.= '<span><img src="'.$collectUserInfo['picurl'].'"></span>';
                                                    }
                                                }
                                            }
                                            
                                        $outStr.= '</div>';
                                    $outStr.= '</div>';
                                    
                                    if($val['pinglunCount'] > 0){
                                        $outStr.= '<div class="detail-cmt detail-plugin__'.$val['id'].'">';
                                    }else{
                                        $outStr.= '<div class="detail-cmt box_hide detail-plugin__'.$val['id'].'">';
                                    }
                                            $outStr.= '<div class="plugin-item">';
                                            if(is_array($val['pinglunList']) && !empty($val['pinglunList'])){
                                                foreach($val['pinglunList'] as $kp => $vp){
                                                    $vp['content'] = cutstr($vp['content'], 60, '..');
                                                    $pinglunUserInfo = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($vp['user_id']);
                                                    $replyListTmp = C::t('#tom_tongcheng#tom_tongcheng_pinglun_reply')->fetch_all_list(" AND tongcheng_id = {$val['id']} AND ping_id = {$vp['id']} ", "ORDER BY reply_time ASC,id ASC", 0, 1000);
                                                    if($vp['touser_id'] > 0){
                                                        $outStr.= '<a href="javascript:void(0);" class="replay-plugin__btn" data-id="'.$val['id'].'" data-touserid="'.$pinglunUserInfo['id'].'" data-tonickname="'.$pinglunUserInfo['nickname'].'"><span class="nick">'.$pinglunUserInfo['nickname'].'</span>&nbsp;'.lang("plugin/tom_tongcheng", "pinglun_hueifu").'&nbsp;<span class="nick">'.$vp['touser_nickname'].lang("plugin/tom_tongcheng", "pinglun_hueifu_dian").'</span>&nbsp;'.$vp['content'].'</a>';
                                                    }else{
                                                        $outStr.= '<a href="javascript:void(0);" class="replay-plugin__btn" data-id="'.$val['id'].'" data-touserid="'.$pinglunUserInfo['id'].'" data-tonickname="'.$pinglunUserInfo['nickname'].'"><span class="nick">'.$pinglunUserInfo['nickname'].lang("plugin/tom_tongcheng", "pinglun_hueifu_dian").'</span>&nbsp;'.$vp['content'].'</a>';
                                                    }
                                                }
                                                
                                                if($val['pinglunCount'] > 5){
                                                    $outStr.= '<a href="'.$infoUrl.'">'.lang("plugin/tom_tongcheng", "ajax_look_more_plugin_1").$val['pinglunCount'].lang("plugin/tom_tongcheng", "ajax_look_more_plugin_2").'</a>';
                                                }
                                            }
                                            $outStr.= '</div>';
                                        $outStr.= '</div>';
                                    
                                $outStr.= '</div>';
                            }
                       $outStr.= '</div>';
                  $outStr.= '</div>';
            }
        }
        
        if($tongchengConfig['open_load_list_clicks'] == 1 && $tongchengConfig['open_tj_commonclicks'] == 1){
            DB::query("UPDATE ".DB::table('tom_tongcheng_common')." SET clicks=clicks+{$i} WHERE id='$site_id' ", 'UNBUFFERED');
        }
    }else{
        $outStr = '205';
    }
    $outStr = tom_link_replace($outStr);
    $outStr = diconv($outStr,CHARSET,'utf-8');
    echo json_encode($outStr); exit;
    
}else if($_GET['act'] == 'collect' && $_GET['formhash'] == FORMHASH  && $userStatus){
    
    $tongcheng_id   = intval($_GET['tongcheng_id'])>0? intval($_GET['tongcheng_id']):0;
    
    $collectListTmp = C::t('#tom_tongcheng#tom_tongcheng_collect')->fetch_all_list(" AND user_id={$__UserInfo['id']} AND tongcheng_id={$tongcheng_id} "," ORDER BY id DESC ",0,1);
    
    if(is_array($collectListTmp) && !empty($collectListTmp)){
        echo 100;exit;
    }
    
    $insertData = array();
    $insertData['user_id']      = $__UserInfo['id'];
    $insertData['tongcheng_id'] = $tongcheng_id;
    $insertData['add_time']     = TIMESTAMP;
    if(C::t('#tom_tongcheng#tom_tongcheng_collect')->insert($insertData)){
        DB::query("UPDATE ".DB::table('tom_tongcheng')." SET collect=collect+1 WHERE id='$tongcheng_id' ", 'UNBUFFERED');
        echo 200;exit;
    }
    
    echo 404;exit;
    
}else if($_GET['act'] == 'clicks' && $_GET['formhash'] == FORMHASH){
    
    $tongcheng_id   = intval($_GET['tongcheng_id'])>0? intval($_GET['tongcheng_id']):0;
    
    DB::query("UPDATE ".DB::table('tom_tongcheng')." SET clicks=clicks+1 WHERE id='$tongcheng_id' ", 'UNBUFFERED');
    if($tongchengConfig['open_tj_commonclicks'] == 1){
        DB::query("UPDATE ".DB::table('tom_tongcheng_common')." SET clicks=clicks+1 WHERE id='$site_id' ", 'UNBUFFERED');
    }
    echo 200;exit;
    
}else if($_GET['act'] == 'commonClicks' && $_GET['formhash'] == FORMHASH){
    
    DB::query("UPDATE ".DB::table('tom_tongcheng_common')." SET clicks=clicks+1 WHERE id='$site_id' ", 'UNBUFFERED');
    echo 200;exit;
    
}else if($_GET['act'] == 'zhuanfa' && $_GET['formhash'] == FORMHASH){
    
    $tongcheng_id   = intval($_GET['tongcheng_id'])>0? intval($_GET['tongcheng_id']):0;
    
    DB::query("UPDATE ".DB::table('tom_tongcheng')." SET zhuanfa=zhuanfa+1 WHERE id='$tongcheng_id' ", 'UNBUFFERED');
    echo 200;exit;
    
}else if($_GET['act'] == 'updateTopstatus' && $_GET['formhash'] == FORMHASH){
    
    $cookiesTopstatus = getcookie('tom_tongcheng_update_topstatus');
    if(!empty($cookiesTopstatus) && $cookiesTopstatus==1){
    }else{
        $tongchengListTmp = C::t('#tom_tongcheng#tom_tongcheng')->fetch_all_list(" AND topstatus=1 AND toptime<".TIMESTAMP." "," ORDER BY toptime ASC,id DESC ",0,10);
        if(is_array($tongchengListTmp) && !empty($tongchengListTmp)){
            foreach ($tongchengListTmp as $key => $value){
                $updateData = array();
                $updateData['topstatus']     = 0;
                $updateData['toprand']       = 1;
                C::t('#tom_tongcheng#tom_tongcheng')->update($value['id'],$updateData);
            }
        }
        dsetcookie('tom_tongcheng_update_topstatus',1,300);
    }
    echo 200;exit;
    
}else if($_GET['act'] == 'updateToprand' && $_GET['formhash'] == FORMHASH){
    
    $cookiesToprand = getcookie('tom_tongcheng_update_toprand');
    if(!empty($cookiesToprand) && $cookiesToprand==1){
    }else{
        $m = dgmdate(TIMESTAMP,'i',$tomSysOffset);
        $m = $m * 1;
        if($m > 0 && $m < 10){
            $tongchengListTmp = C::t('#tom_tongcheng#tom_tongcheng')->fetch_all_list(" AND topstatus=1 "," ORDER BY toprand DESC,id DESC ",0,50);
            if(is_array($tongchengListTmp) && !empty($tongchengListTmp)){
                foreach ($tongchengListTmp as $key => $value){
                    if($value['topstatus'] == 1 && (TIMESTAMP - $value['refresh_time']) > 1800){
                        $toprand = mt_rand(111, 999);
                        DB::query("UPDATE ".DB::table('tom_tongcheng')." SET toprand=".$toprand." WHERE id='{$value['id']}' ", 'UNBUFFERED');
                    }
                }
            }
            dsetcookie('tom_tongcheng_update_toprand',1,300);
        }
    }
    echo 200;exit;
    
}else if($_GET['act'] == 'get_search_url' && $_GET['formhash'] == FORMHASH){
    
    $keyword = isset($_GET['keyword'])? daddslashes(diconv(urldecode($_GET['keyword']),'utf-8')):'';
    
    $url = $_G['siteurl']."plugin.php?id=tom_tongcheng&site={$site_id}&mod=list&keyword=".urlencode(trim($keyword));
    $url = tom_link_replace($url);
    echo $url;exit;
    
}else if($_GET['act'] == 'get_sfc_search_url' && $_GET['formhash'] == FORMHASH){
    
    $model_id = intval($_GET['model_id'])>0? intval($_GET['model_id']):0;
    $type_id  = intval($_GET['type_id'])>0? intval($_GET['type_id']):0;
    $cate_id  = intval($_GET['cate_id'])>0? intval($_GET['cate_id']):0;
    $city_id  = intval($_GET['city_id'])>0? intval($_GET['city_id']):0;
    $area_id  = intval($_GET['area_id'])>0? intval($_GET['area_id']):0;
    $street_id = intval($_GET['street_id'])>0? intval($_GET['street_id']):0;
    $sfcChufa = isset($_GET['chufa'])? daddslashes(diconv(urldecode($_GET['chufa']),'utf-8')):'';
    $sfcMude = isset($_GET['mude'])? daddslashes(diconv(urldecode($_GET['mude']),'utf-8')):'';

    $url = $_G['siteurl']."plugin.php?id=tom_tongcheng&site={$site_id}&mod=list&model_id={$model_id}&type_id={$type_id}&cate_id={$cate_id}&city_id={$city_id}&area_id={$area_id}&street_id={$street_id}&chufa=".urlencode(trim($sfcChufa))."&mude=".urlencode(trim($sfcMude));
    $url = tom_link_replace($url);
    echo $url;exit;
    
}else if($_GET['act'] == 'updateStatus' && $_GET['formhash'] == FORMHASH && $userStatus){
    
    $tongcheng_id   = intval($_GET['tongcheng_id'])>0? intval($_GET['tongcheng_id']):0;
    
    $tongchengInfo = C::t('#tom_tongcheng#tom_tongcheng')->fetch_by_id($tongcheng_id);
    
    if($tongchengInfo['user_id'] != $__UserInfo['id']){
        echo '404';exit;
    }
    
    if($_GET['status'] == 1){
        $updateData = array();
        $updateData['status'] = 1;
        C::t('#tom_tongcheng#tom_tongcheng')->update($tongcheng_id,$updateData);
    }else if($_GET['status'] == 2){
        $updateData = array();
        $updateData['status'] = 2;
        C::t('#tom_tongcheng#tom_tongcheng')->update($tongcheng_id,$updateData);
    }
    
    echo 200;exit;
}else if($_GET['act'] == 'updateFinish' && $_GET['formhash'] == FORMHASH && $userStatus){
    
    $tongcheng_id   = intval($_GET['tongcheng_id'])>0? intval($_GET['tongcheng_id']):0;
    
    $tongchengInfo = C::t('#tom_tongcheng#tom_tongcheng')->fetch_by_id($tongcheng_id);
    
    if($tongchengInfo['user_id'] != $__UserInfo['id']){
        echo '404';exit;
    }
    
    $updateData = array();
    $updateData['finish'] = 1;
    C::t('#tom_tongcheng#tom_tongcheng')->update($tongcheng_id,$updateData);
    
    echo 200;exit;
    
}else if($_GET['act'] == 'refresh' && $_GET['formhash'] == FORMHASH && $userStatus){
    
    $tongcheng_id   = intval($_GET['tongcheng_id'])>0? intval($_GET['tongcheng_id']):0;
    
    $tongchengInfo = C::t('#tom_tongcheng#tom_tongcheng')->fetch_by_id($tongcheng_id);
    
    if($tongchengInfo['user_id'] != $__UserInfo['id']){
        echo '404';exit;
    }
    
    $updateData = array();
    $updateData['refresh_time'] = TIMESTAMP;
    C::t('#tom_tongcheng#tom_tongcheng')->update($tongcheng_id,$updateData);
    
    $insertData = array();
    $insertData['user_id']      = $tongchengInfo['user_id'];
    $insertData['tongcheng_id'] = $tongcheng_id;
    $insertData['time_key']     = $nowDayTime;
    $insertData['add_time']     = TIMESTAMP;
    C::t('#tom_tongcheng#tom_tongcheng_refresh_log')->insert($insertData);
    
    echo 200;exit;
}else if($_GET['act'] == 'refresh3' && $_GET['formhash'] == FORMHASH && $userStatus){
    
    $tongcheng_id   = intval($_GET['tongcheng_id'])>0? intval($_GET['tongcheng_id']):0;
    
    $tongchengInfo = C::t('#tom_tongcheng#tom_tongcheng')->fetch_by_id($tongcheng_id);
    $typeInfo = C::t('#tom_tongcheng#tom_tongcheng_model_type')->fetch_by_id($tongchengInfo['type_id']);
    
    if($tongchengInfo['user_id'] != $__UserInfo['id']){
        echo '404';exit;
    }
    
    $updateData = array();
    $updateData['refresh_time'] = TIMESTAMP;
    C::t('#tom_tongcheng#tom_tongcheng')->update($tongcheng_id,$updateData);
    
    $useScore = $tongchengConfig['pay_score_yuan']*$typeInfo['refresh_price'];
    $useScore = ceil($useScore);
    
    $updateData = array();
    $updateData['score'] = $__UserInfo['score'] - $useScore;
    C::t('#tom_tongcheng#tom_tongcheng_user')->update($__UserInfo['id'],$updateData);

    $insertData = array();
    $insertData['user_id']          = $__UserInfo['id'];
    $insertData['score_value']      = $useScore;
    $insertData['old_value']        = $__UserInfo['score'];
    $insertData['log_type']         = 5;
    $insertData['log_time']         = TIMESTAMP;
    C::t('#tom_tongcheng#tom_tongcheng_score_log')->insert($insertData);
    
    echo 200;exit;
}else if($_GET['act'] == 'refresh4' && $_GET['formhash'] == FORMHASH && $userStatus){
    
    $tongcheng_id   = intval($_GET['tongcheng_id'])>0? intval($_GET['tongcheng_id']):0;
    
    $tongchengInfo = C::t('#tom_tongcheng#tom_tongcheng')->fetch_by_id($tongcheng_id);
    
    if($tongchengInfo['user_id'] != $__UserInfo['id']){
        echo '404';exit;
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
    
    if($_isVipTequan == 1){
        $updateData = array();
        $updateData['refresh_time'] = TIMESTAMP;
        C::t('#tom_tongcheng#tom_tongcheng')->update($tongcheng_id,$updateData);
    }
    
    echo 200;exit;
}else if($_GET['act'] == 'list_get_street' && $_GET['formhash'] == FORMHASH){
    
    $outStr = '';
    
    $area_id   = intval($_GET['area_id'])>0? intval($_GET['area_id']):0;
    
    $streetList = C::t('#tom_tongcheng#tom_tongcheng_district')->fetch_all_by_upid($area_id);
    
    if($area_id > 0 && is_array($streetList) && !empty($streetList)){
        $outStr = '<li class="item" data-id="0" data-name="'.lang("plugin/tom_tongcheng", "template_list_all").'">'.lang("plugin/tom_tongcheng", "template_list_all").'</li>';
        foreach ($streetList as $key => $value){
           $outStr.= '<li class="item" data-id="'.$value['id'].'" data-name="'.$value['name'].'">'.$value['name'].'</li>';
        }
    }else{
       $outStr = '100';
    }
    
    $outStr = diconv($outStr,CHARSET,'utf-8');
    echo json_encode($outStr); exit;
    
}else if($_GET['act'] == 'list_get_cate' && $_GET['formhash'] == FORMHASH){
    
    $outStr = '';
    
    $type_id   = intval($_GET['type_id'])>0? intval($_GET['type_id']):0;
    
    $cateList = C::t('#tom_tongcheng#tom_tongcheng_model_cate')->fetch_all_list(" AND type_id={$type_id}  "," ORDER BY paixu ASC,id DESC ",0,50);
    
    if(is_array($cateList) && !empty($cateList)){
        $outStr = '<li class="item" data-id="0" data-name="'.lang("plugin/tom_tongcheng", "template_list_all").'">'.lang("plugin/tom_tongcheng", "template_list_all").'</li>';
        foreach ($cateList as $key => $value){
           $outStr.= '<li class="item" data-id="'.$value['id'].'" data-name="'.$value['name'].'">'.$value['name'].'</li>';
        }
    }else{
       $outStr = '100';
    }
    
    $outStr = diconv($outStr,CHARSET,'utf-8');
    echo json_encode($outStr); exit;
    
}else if($_GET['act'] == 'auto_click' && $_GET['formhash'] == FORMHASH){
    
    $cookies_auto_click_status = getcookie('tom_tongcheng_auto_click_status');
    $halfhour = TIMESTAMP - 1800;
    $threedays = TIMESTAMP - 86400*3;
    if($tongchengConfig['open_auto_click'] == 1){
        
        $auto_min_num = 5;
        $auto_max_num = 10;
        if($tongchengConfig['auto_min_num'] < $tongchengConfig['auto_max_num']){
            $auto_min_num = $tongchengConfig['auto_min_num'];
            $auto_max_num = $tongchengConfig['auto_max_num'];
        }
        
        if(!empty($cookies_auto_click_status) && $cookies_auto_click_status==1){
        }else{
            $tongchengListTmp = C::t('#tom_tongcheng#tom_tongcheng')->fetch_all_list(" AND status=1 AND shenhe_status=1 AND add_time<".$halfhour." AND auto_click_time<".$nowDayTime." AND ( refresh_time>".$threedays." OR topstatus=1 ) "," ORDER BY refresh_time DESC ",0,20);
            if(is_array($tongchengListTmp) && !empty($tongchengListTmp)){
                $i = 0;
                foreach ($tongchengListTmp as $key => $value){
                    if($value['topstatus'] == 1){
                        $auto_click_num = mt_rand($auto_min_num*2, $auto_max_num*2);
                    }else{
                        $auto_click_num = mt_rand($auto_min_num, $auto_max_num);
                    }
                    $i = $i + $auto_click_num;
                    $updateData = array();
                    $updateData['clicks']     = $value['clicks'] + $auto_click_num;
                    $updateData['auto_click_time']     = $nowDayTime;
                    C::t('#tom_tongcheng#tom_tongcheng')->update($value['id'],$updateData);
                }
                if($tongchengConfig['open_tj_commonclicks'] == 1){
                    DB::query("UPDATE ".DB::table('tom_tongcheng_common')." SET clicks=clicks+{$i} WHERE id='$site_id' ", 'UNBUFFERED');
                }
            }
            dsetcookie('tom_tongcheng_auto_click_status',1,300);
        }
    }
    
    echo 200;exit;

}else if($_GET['act'] == 'auto_zhuanfa' && $_GET['formhash'] == FORMHASH){
    
    $cookies_auto_zhuanfa_status = getcookie('tom_tongcheng_auto_zhuanfa_status');
    $halfhour = TIMESTAMP - 1800;
    $threedays = TIMESTAMP - 86400*3;
    if($tongchengConfig['open_auto_zhuanfa'] == 1){
        
        $auto_min_num = 1;
        $auto_max_num = 10;
        if($tongchengConfig['min_zhuanfa_num'] < $tongchengConfig['max_zhuanfa_num']){
            $auto_min_num = $tongchengConfig['min_zhuanfa_num'];
            $auto_max_num = $tongchengConfig['max_zhuanfa_num'];
        }

        if(!empty($cookies_auto_zhuanfa_status) && $cookies_auto_zhuanfa_status==1){
        }else{
            $tongchengListTmp = C::t('#tom_tongcheng#tom_tongcheng')->fetch_all_list(" AND status=1 AND shenhe_status=1 AND add_time<".$halfhour." AND auto_zhuanfa_time<".$nowDayTime." AND refresh_time>".$threedays." "," ORDER BY refresh_time DESC ",0,20);
            if(is_array($tongchengListTmp) && !empty($tongchengListTmp)){
                foreach ($tongchengListTmp as $key => $value){
                    
                    $auto_zhuanfa_num = mt_rand($auto_min_num, $auto_max_num);
                    
                    if(($value['zhuanfa'] + $auto_zhuanfa_num) < $value['clicks']){
                        $updateData = array();
                        $updateData['zhuanfa']     = $value['zhuanfa'] + $auto_zhuanfa_num;
                        $updateData['auto_zhuanfa_time']     = $nowDayTime;
                        C::t('#tom_tongcheng#tom_tongcheng')->update($value['id'],$updateData);
                        echo $value['id'].'---';
                    }
                }
            }
            dsetcookie('tom_tongcheng_auto_zhuanfa_status',1,300);
        }
    }
    
    echo 200;exit;
    
}else if($_GET['act'] == 'shenhe_sms' && $_GET['formhash'] == FORMHASH){
    
    $cookies_shenhe_sms_status = getcookie('tom_tongcheng_shenhe_sms_status');
    
    if(!empty($cookies_shenhe_sms_status) && $cookies_shenhe_sms_status==1){
        echo 404;exit;
    }else{
        $noShenheCount = C::t('#tom_tongcheng#tom_tongcheng')->fetch_all_count(" AND site_id={$site_id} AND pay_status!=1 AND shenhe_status=2 ");
    
        if($noShenheCount >0){
        }else{
            echo 0;exit;
        }

        $sitesInfo = C::t('#tom_tongcheng#tom_tongcheng_sites')->fetch_by_id($site_id);

        $toUser = array();
        $toUserId = 0;
        if(!empty($sitesInfo['manage_user_id'])){
            $toUserId = $sitesInfo['manage_user_id'];
        }else if(!empty($tongchengConfig['manage_user_id'])){
            $toUserId = $tongchengConfig['manage_user_id'];
        }

        if(empty($toUserId)){
            echo 1;exit;
        }

        $toUserTmp = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($toUserId);
        if($toUserTmp && !empty($toUserTmp['openid'])){
            $toUser = $toUserTmp;
        }else{
            echo 2;exit;
        }
        
        $appid = trim($tongchengConfig['wxpay_appid']);  
        $appsecret = trim($tongchengConfig['wxpay_appsecret']);
        include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/class/weixin.class.php';
        $weixinClass = new weixinClass($appid,$appsecret);

        include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/class/templatesms.class.php';
        $access_token = $weixinClass->get_access_token();
        $nextSmsTime = $toUser['last_smstp_time'] + 300;

        if($access_token && !empty($toUser['openid']) && TIMESTAMP > $nextSmsTime ){
            $templateSmsClass = new templateSms($access_token, $_G['siteurl']."plugin.php?id=tom_tongcheng&site={$site_id}&mod=managerList&type=1");
            $shenhe_template_first = str_replace("{NUM}",$noShenheCount, lang('plugin/tom_tongcheng','shenhe_template_first'));
            $smsData = array(
                'first'         => $shenhe_template_first,
                'keyword1'      => '',
                'keyword2'      => '',
                'remark'        => ''
            );
            $r = $templateSmsClass->sendSms01($toUser['openid'],$tongchengConfig['template_id'],$smsData);

            if($r){
                $updateData = array();
                $updateData['last_smstp_time'] = TIMESTAMP;
                C::t('#tom_tongcheng#tom_tongcheng_user')->update($toUser['id'],$updateData);
            }

        }

        dsetcookie('tom_tongcheng_shenhe_sms_status',1,300);
    }
    
    echo 200;exit;

}else if($_GET['act'] == 'pinglun' && $_GET['formhash'] == FORMHASH  && $userStatus){
    if('utf-8' != CHARSET) {
        if(defined('IN_MOBILE')){
        }else{
            foreach($_POST AS $pk => $pv) {
                if(!is_numeric($pv)) {
                    $_GET[$pk] = $_POST[$pk] = wx_iconv_recurrence($pv);	
                }
            }
        }
    }
    
    $user_id = isset($_GET['user_id'])? intval($_GET['user_id']):0;
    $touser_id = isset($_GET['touser_id'])? intval($_GET['touser_id']):0;
    $content = isset($_GET['content'])? daddslashes($_GET['content']):'';
    $tongcheng_id = isset($_GET['tongcheng_id'])? intval($_GET['tongcheng_id']):0;
    $tongchengInfo = C::t('#tom_tongcheng#tom_tongcheng')->fetch_by_id($tongcheng_id);
    $userInfo = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($user_id);
    
    $__CommonInfo = C::t('#tom_tongcheng#tom_tongcheng_common')->fetch_by_id(1);
    if(!empty($__CommonInfo['forbid_word'])){
        $forbid_word = preg_quote(trim($__CommonInfo['forbid_word']), '/');
        $forbid_word = str_replace(array("\\*"), array('.*'), $forbid_word);
        $forbid_word = '.*('.$forbid_word.').*';
        $forbid_word = '/^('.str_replace(array("\r\n", ' '), array(').*|.*(', ''), $forbid_word).')$/i';
        if(@preg_match($forbid_word, $content,$matches)) {
            $i = count($matches)-1;
            $word = '';
            if(isset($matches[$i]) && !empty($matches[$i])){
                $word = diconv($matches[$i],CHARSET,'utf-8');
            }
            $outArr = array(
                'status'=> 505,
                'word'=> $word,
            );
            echo json_encode($outArr); exit;
        }
                
    }
    
    $lastPinglunListTmp = C::t('#tom_tongcheng#tom_tongcheng_pinglun')->fetch_all_list(" AND user_id={$user_id} "," ORDER BY id DESC ",0,1);
    if($lastPinglunListTmp && $lastPinglunListTmp[0]['ping_time'] > 0 && $userInfo['editor']==0){
        $nextPingTime = $lastPinglunListTmp[0]['ping_time'] + $tongchengConfig['pinglun_next_minute']*60;
        if($nextPingTime > TIMESTAMP){
            $outArr = array(
                'status'=> 401,
            );
            echo json_encode($outArr); exit;
        }
    }
    
    if($tongchengInfo['site_id'] == 1){
        $sitename = $tongchengConfig['plugin_name'];
    }else{
        $siteInfo = C::t('#tom_tongcheng#tom_tongcheng_sites')->fetch_by_id($tongchengInfo['site_id']);
        $sitename = $siteInfo['name'];
    }
    
    if(empty($tongchengInfo['title'])){
        $tongchengInfo['title'] = cutstr(contentFormat($tongchengInfo['content']),20,"...");
    }
    
    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/class/weixin.class.php';
    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/class/templatesms.class.php';
    $appid = trim($tongchengConfig['wxpay_appid']);  
    $appsecret = trim($tongchengConfig['wxpay_appsecret']);
    $weixinClass = new weixinClass($appid,$appsecret);
    $access_token = $weixinClass->get_access_token();
    $nextSmsTime = $userInfo['last_smstp_time'] + 0;
    $smsContent = strip_tags($content);
    $templateSmsClass = new templateSms($access_token, $_G['siteurl']."plugin.php?id=tom_tongcheng&site={$site_id}&mod=message");
    
    if($touser_id > 0){
        $toUser = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($touser_id);
        
        $insertData = array();
        $insertData['tongcheng_id']     = $tongcheng_id;
        $insertData['user_id']          = $user_id;
        $insertData['touser_id']        = $touser_id;
        $insertData['touser_nickname']  = $toUser['nickname'];
        $insertData['touser_avatar']    = $toUser['picurl'];
        $insertData['content']          = $content;
        $insertData['ping_time']        = TIMESTAMP;
        C::t('#tom_tongcheng#tom_tongcheng_pinglun')->insert($insertData);
        $pinglunId = C::t('#tom_tongcheng#tom_tongcheng_pinglun')->insert_id();
        
        if($tongchengInfo){
            $message = strip_tags($content);
            $message = contentFormat($message);
            $message = $message.'<br/><a href="plugin.php?id=tom_tongcheng&site='.$tongchengInfo['site_id'].'&mod=info&xxid='.$tongchengInfo['id'].'">['.lang("plugin/tom_tongcheng", "template_dianjichakan").']</a>';

            $insertData = array();
            $insertData['user_id']      = $toUser['id'];
            $insertData['type']         = 1;
            $insertData['content']      = '<font color="#238206">'.lang('plugin/tom_tongcheng', 'ajax_pinglun_title').'</font><br/>'.$userInfo['nickname'].lang('plugin/tom_tongcheng', 'ajax_touser_1_reply').$tongchengInfo['title'].lang('plugin/tom_tongcheng', 'ajax_touser_2_reply').dhtmlspecialchars($pinglunInfo['content']).';<br/>'.lang('plugin/tom_tongcheng', 'ajax_touser_reply_pinglun').$message;
            $insertData['is_read']      = 0;
            $insertData['tz_time']      = TIMESTAMP;
            C::t('#tom_tongcheng#tom_tongcheng_tz')->insert($insertData);
        }
        
        if($access_token && !empty($toUser['openid']) && TIMESTAMP > $nextSmsTime ){
            $smsData = array(
                'first'         => $userInfo['nickname'].lang('plugin/tom_tongcheng', 'ajax_pinglun_reply_hueifu'),
                'keyword1'      => $sitename,
                'keyword2'      => $smsContent,
                'remark'        => ''
            );
            $r = $templateSmsClass->sendSms01($toUser['openid'],$tongchengConfig['template_id'],$smsData);

            if($r){
                $updateData = array();
                $updateData['last_smstp_time'] = TIMESTAMP;
                C::t('#tom_tongcheng#tom_tongcheng_user')->update($toUser['id'],$updateData);
            }
        }
        $outArr = array(
            'status'=> 200200,
            'pinglun_id'=> $pinglunId,
        );
        echo json_encode($outArr); exit;
    }else{
        $toUser = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($tongchengInfo['user_id']);
        
        $insertData = array();
        $insertData['tongcheng_id'] = $tongcheng_id;
        $insertData['content'] = $content;
        $insertData['user_id'] = $user_id;
        $insertData['ping_time'] = TIMESTAMP;
        C::t('#tom_tongcheng#tom_tongcheng_pinglun')->insert($insertData);
        $pinglunId = C::t('#tom_tongcheng#tom_tongcheng_pinglun')->insert_id();
        
        if($tongchengInfo){
            $message = strip_tags($content);
            $message = contentFormat($message);
            $message = $message.'<br/><a href="plugin.php?id=tom_tongcheng&site='.$tongchengInfo['site_id'].'&mod=info&xxid='.$tongchengInfo['id'].'">['.lang("plugin/tom_tongcheng", "template_dianjichakan").']</a>';

            $insertData = array();
            $insertData['user_id']      = $toUser['id'];
            $insertData['type']     = 1;
            $insertData['content']      = '<font color="#238206">'.lang('plugin/tom_tongcheng', 'ajax_pinglun_title').'</font><br/>'.$userInfo['nickname'].lang('plugin/tom_tongcheng', 'ajax_touser_1').$tongchengInfo['title'].lang('plugin/tom_tongcheng', 'ajax_touser_2').'<br/>'.lang('plugin/tom_tongcheng', 'ajax_touser_pinglun_content').$message;
            $insertData['is_read']     = 0;
            $insertData['tz_time']     = TIMESTAMP;
            C::t('#tom_tongcheng#tom_tongcheng_tz')->insert($insertData);
        }
        
        if($access_token && !empty($toUser['openid']) && TIMESTAMP > $nextSmsTime ){
            $smsData = array(
                'first'         => $userInfo['nickname'].lang('plugin/tom_tongcheng', 'ajax_pinglun_reply_hueifu'),
                'keyword1'      => $sitename,
                'keyword2'      => $smsContent,
                'remark'        => ''
            );
            $r = $templateSmsClass->sendSms01($toUser['openid'],$tongchengConfig['template_id'],$smsData);

            if($r){
                $updateData = array();
                $updateData['last_smstp_time'] = TIMESTAMP;
                C::t('#tom_tongcheng#tom_tongcheng_user')->update($toUser['id'],$updateData);
            }
        }
        $outArr = array(
            'status'=> 200,
            'pinglun_id'=> $pinglunId,
        );
        echo json_encode($outArr); exit;
    }
    $outArr = array(
        'status'=> 1
    );
    echo json_encode($outArr); exit;
    
}else if($_GET['act'] == 'loadPinglun' && $_GET['formhash'] == FORMHASH){
    $outStr = '';
    
    $tongcheng_id = isset($_GET['tongcheng_id'])? intval($_GET['tongcheng_id']):0;
    $loadPage   = intval($_GET['loadPage'])>0? intval($_GET['loadPage']):1;
    $pinglun_num   = intval($_GET['pinglun_num'])>0? intval($_GET['pinglun_num']):0;
    $pagesize = 5;
    $start = ($loadPage - 1) * $pagesize;
    $start = $start - $pinglun_num;
    
    $tongchengInfo = C::t('#tom_tongcheng#tom_tongcheng')->fetch_by_id($tongcheng_id);
    $pinglunListTmp = C::t('#tom_tongcheng#tom_tongcheng_pinglun')->fetch_all_list(" AND tongcheng_id = {$tongcheng_id} ", 'ORDER BY ping_time DESC,id DESC', $start, $pagesize);

    if(is_array($pinglunListTmp) && !empty($pinglunListTmp)){
        foreach($pinglunListTmp as $key => $value){
            $value['content'] = cutstr($value['content'], 260, '..');
            $userInfo = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($value['user_id']);
            if($value['touser_id'] > 0){
                $userInfo['nickname'] = cutstr($userInfo['nickname'], 10, '...');
            }
            $outStr.= '<div class="comment-item clearfix" id="comment-item_'.$value['id'].'" data-id="'.$tongchengInfo['id'].'" data-touserid="'.$userInfo['id'].'" data-tonickname="'.$userInfo['nickname'].'">';
                $outStr.= '<div class="comment-item-avatar"><img src="'.$userInfo['picurl'].'"></div>';
                $outStr.= '<div class="comment-item-content">';
                
                $outStr.='<h5>';
                    $outStr.='<span onClick="comment_reply(this);">'.$userInfo['nickname'].'</span>';
                    if($value['touser_id'] > 0){
                        $touser_nickname = cutstr($value['touser_nickname'], 10, '...');
                        $outStr.='<span class="hf">&nbsp;'.lang('plugin/tom_tongcheng', 'pinglun_hueifu').lang('plugin/tom_tongcheng', 'pinglun_hueifu_dian').'&nbsp;</span><span onClick="comment_reply(this);">'.$touser_nickname.'</span>';
                    }
                    $outStr.='<span class="right remove" onClick="removePinglun('.$value['id'].');">'.lang('plugin/tom_tongcheng', 'info_comment_del').'</span>';
                    $outStr.='<span class="right" onClick="comment_reply(this);">'.dgmdate($value['ping_time'],"Y-m-d",$tomSysOffset).'</span>';
                $outStr.='</h5>';
                
                $outStr.= '<div class="comment-item-content-text" onClick="comment_reply(this);">'.qqface_replace(dhtmlspecialchars($value['content'])).'</div>';
                $replyListTmp = C::t('#tom_tongcheng#tom_tongcheng_pinglun_reply')->fetch_all_list(" AND tongcheng_id = {$tongcheng_id} AND ping_id = {$value['id']} ", "ORDER BY reply_time ASC,id ASC", 0, 1000);
                if(is_array($replyListTmp) && !empty($replyListTmp)){
                    $outStr .= '<div class="comment_reply_pinglun_box" style="display:none;">';
                    foreach($replyListTmp as $k => $v){
                        if($tongchengInfo['user_id'] == $v['reply_user_id']){
                            $outStr.= '<div id="comment-item-content-text_'.$v['id'].'" class="comment-item-content-text"><span>'.$v['reply_user_nickname'].'&nbsp;<span class="floor_main">'.lang('plugin/tom_tongcheng', 'info_pinglun_floor_main').'</span>'.lang('plugin/tom_tongcheng','pinglun_hueifu_dian').'&nbsp;</span>'.qqface_replace(dhtmlspecialchars($v['content'])).'&nbsp;&nbsp;<span class="remove" onClick="removeReply('.$v['id'].');">'.lang('plugin/tom_tongcheng','info_comment_del').'</span></div>';
                        }else{
                            $outStr.= '<div id="comment-item-content-text_'.$v['id'].'" class="comment-item-content-text"><span>'.$v['reply_user_nickname'].lang('plugin/tom_tongcheng','pinglun_hueifu_dian').'&nbsp;</span>'.qqface_replace(dhtmlspecialchars($v['content'])).'&nbsp;&nbsp;<span class="remove" onClick="removeReply('.$v['id'].');">'.lang('plugin/tom_tongcheng','info_comment_del').'</span></div>';
                        }
                    }
                    $outStr .= '</div>';
                }
                    
                $outStr.= '</div>';
            $outStr.= '</div>';        
        }
        
    }else{
        $outStr = '201';
    }
    
    $outStr = diconv($outStr,CHARSET,'utf-8');
    echo json_encode($outStr); exit;
    
}else if($_GET['act'] == 'removePinglun' && $_GET['formhash'] == FORMHASH  && $userStatus){
    $ping_id = isset($_GET['ping_id'])? intval($_GET['ping_id']): 0;
    if(C::t('#tom_tongcheng#tom_tongcheng_pinglun')->delete_by_id($ping_id)){
        C::t('#tom_tongcheng#tom_tongcheng_pinglun_reply')->delete_pinglun_id($ping_id);
        echo 200;exit;
    }
    echo 1;exit;
    
}else if($_GET['act'] == 'removeReplyPinglun' && $_GET['formhash'] == FORMHASH  && $userStatus){
    $reply_id = isset($_GET['reply_id'])? intval($_GET['reply_id']): 0;
    C::t('#tom_tongcheng#tom_tongcheng_pinglun_reply')->delete_by_id($reply_id);
    echo 200;exit;
    
}else if($_GET['act'] == 'browser_shouchang' && $_GET['formhash'] == FORMHASH){
    $user_id = isset($_GET['user_id'])? intval($_GET['user_id']): 0;
    
    $lifeTime = 86400*3;
    dsetcookie('tom_tongcheng_browser_shouchang_'.$user_id, $user_id, $lifeTime);
    echo '200';exit;
    
}else if($_GET['act'] == 'zhuanfaScore' && $_GET['formhash'] == FORMHASH && $userStatus){
    
    echo 100;exit;
    
    $score_log_count = C::t('#tom_tongcheng#tom_tongcheng_score_log')->fetch_all_count(" AND user_id={$__UserInfo['id']} AND log_type=6 AND time_key={$nowDayTime} ");
    
    if($tongchengConfig['score_share_time'] > $score_log_count){
        $updateData = array();
        $updateData['score'] = $__UserInfo['score'] + $tongchengConfig['score_share_num'];
        C::t('#tom_tongcheng#tom_tongcheng_user')->update($__UserInfo['id'],$updateData);

        $insertData = array();
        $insertData['user_id']          = $__UserInfo['id'];
        $insertData['score_value']      = $tongchengConfig['score_share_num'];
        $insertData['old_value']        = $__UserInfo['score'];
        $insertData['log_type']         = 6;
        $insertData['log_time']         = TIMESTAMP;
        $insertData['time_key']         = $nowDayTime;
        C::t('#tom_tongcheng#tom_tongcheng_score_log')->insert($insertData);
        
        echo 200;exit;
    }
    echo 201;exit;
    
}else if($_GET['act'] == 'load_popup' && $_GET['formhash'] == FORMHASH){
    
    $outStr = '';
    
    $popupTmp = C::t('#tom_tongcheng#tom_tongcheng_popup')->fetch_all_by_site_ids(" AND status=1 " ," ORDER BY id DESC ",0,1,'['.$site_id.']' );
    if($popupTmp && !empty($popupTmp[0])){
        $cookies_popup = getcookie('tom_tongcheng_popup_'.$popupTmp[0]['id']);
        if(!empty($cookies_popup) && $cookies_popup==1){
            echo 201;exit;
        }else{
            
            DB::query("UPDATE ".DB::table('tom_tongcheng_popup')." SET clicks=clicks+1 WHERE id='{$popupTmp[0]['id']}' ", 'UNBUFFERED');
            
            $popupTmp[0]['link'] = str_replace("{site}",$site_id, $popupTmp[0]['link']);
            
            $outStr.= '<div id="popup_ads_animation" class="popup_ads_box">';
                $outStr.= '<h5>'.$popupTmp[0]['title'].'</h5>';
                $outStr.= '<div class="content">'.stripslashes($popupTmp[0]['content']).'</div>';
                $outStr.= '<div class="btn">';
                    $outStr.= '<a href="javascript:void(0);" class="no" onclick="closePopup('.$popupTmp[0]['id'].');">'.lang("plugin/tom_tongcheng", "popup_no_btn").'</a>';
                    $outStr.= '<a href="javascript:void(0);" class="ok" onclick="likePopup('.$popupTmp[0]['id'].',\''.$popupTmp[0]['link'].'\')" >'.lang("plugin/tom_tongcheng", "popup_ok_btn").'</a>';
                $outStr.= '</div>';
                $outStr.= '<div class="close" onclick="closePopup('.$popupTmp[0]['id'].');"></div>';
            $outStr.= '</div>';
            
            $outStr = diconv($outStr,CHARSET,'utf-8');
            echo json_encode($outStr); exit;
        }
    }
    
    
    echo 201;exit;
    
}else if($_GET['act'] == 'close_popup' && $_GET['formhash'] == FORMHASH){
    
    $popup_id = isset($_GET['popup_id'])? intval($_GET['popup_id']): 0;
    dsetcookie('tom_tongcheng_popup_'.$popup_id,1,86400);
    
    echo 201;exit;
    
}else if($_GET['act'] == 'hongbao_tz' && $_GET['formhash'] == FORMHASH && $userStatus){
    
    $new_hongbao_tz = 0;
    if($__UserInfo['hongbao_tz'] == 1){
        $new_hongbao_tz = 0;
    }else{
        $new_hongbao_tz = 1;
    }
    
    $updateData = array();
    $updateData['hongbao_tz'] = $new_hongbao_tz;
    C::t('#tom_tongcheng#tom_tongcheng_user')->update($__UserInfo['id'],$updateData);
    
    if($new_hongbao_tz == 1){
        echo 200;exit;
    }else{
        echo 100;exit;
    }
    
}else if($_GET['act'] == 'loadPmlist' && $_GET['formhash'] == FORMHASH && $userStatus){
    
    $outStr = '';
    
    $page           = intval($_GET['page'])>0? intval($_GET['page']):1;

    $pagesize       = 8;
    $start          = ($page - 1)*$pagesize;
    $pmListTmp = C::t('#tom_tongcheng#tom_tongcheng_pm')->fetch_all_list(" AND user_id={$__UserInfo['id']} "," ORDER BY last_time DESC,id DESC ",$start,$pagesize);
    $pmList = array();
    if(is_array($pmListTmp) && !empty($pmListTmp)){
        foreach ($pmListTmp as $key => $value){
            $pmListsTmp = C::t('#tom_tongcheng#tom_tongcheng_pm_lists')->fetch_by_id($value['pm_lists_id']);
            if($pmListsTmp['min_use_id'] == $__UserInfo['id']){
                $toUserInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($pmListsTmp['max_use_id']);
            }else{
                $toUserInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($pmListsTmp['min_use_id']);
            }
            if('NULL-NULL-NULL-NULL-NULL-NULL' != $pmListsTmp['last_content']){
                $pmList[$key] = $value;
                $pmList[$key]['last_content'] = dhtmlspecialchars($pmListsTmp['last_content']);
                $pmList[$key]['toUserInfo'] = $toUserInfoTmp;
            }else if($value['new_num']>0){
                DB::query("UPDATE ".DB::table('tom_tongcheng_pm')." SET new_num=0 WHERE user_id='{$__UserInfo['id']}' AND pm_lists_id='{$value['pm_lists_id']}' ", 'UNBUFFERED');
            }
        }
    }
    
    if(is_array($pmList) && !empty($pmList)){
        foreach ($pmList as $key => $val){
            $outStr.= '<section class="msg-list">';
               $outStr.= '<a href="plugin.php?id=tom_tongcheng&site='.$site_id.'&mod=message&act=sms&pm_lists_id='.$val['pm_lists_id'].'">';
                    $outStr.= '<section class="msg-list-pic">';
                         $outStr.= '<img src="'.$val['toUserInfo']['picurl'].'" />';
                    $outStr.= '</section>';
                    $outStr.= '<section class="msg-list-web">';
                         $outStr.= '<h3><span>'.dgmdate($val['last_time'], 'u','9999','m-d H:i').'</span>'.$val['toUserInfo']['nickname'].'&nbsp;</h3>';
                         $outStr.= '<p>';
                         if($val['new_num']>0){
                             $outStr.= '<i>'.$val['new_num'].'</i>';
                         }
                         $outStr.= ''.$val['last_content'];
                         $outStr.= '</p>';
                    $outStr.= '</section>';
               $outStr.= '</a>';
               $outStr.= '<section class="clear"></section>';
            $outStr.= '</section>';
        }
    }else{
        $outStr = '205';
    }
    $outStr = tom_link_replace($outStr);
    $outStr = diconv($outStr,CHARSET,'utf-8');
    echo json_encode($outStr); exit;
    
}else if($_GET['act'] == 'lbs_check' && $_GET['formhash'] == FORMHASH){
    
    $outStr = '';
    
    $city = isset($_GET['city'])? daddslashes(diconv(urldecode($_GET['city']),'utf-8')):'';
    $district = isset($_GET['district'])? daddslashes(diconv(urldecode($_GET['district']),'utf-8')):'';
    
    if(!empty($city) && !empty($district)){
        
        $sitesListTmp = array();
        $areaStr = '';
        if($tcadminConfig['open_sites_lbs'] == 2){
            $areaStr = $city;
            $sitesListTmp = C::t('#tom_tongcheng#tom_tongcheng_sites')->fetch_all_lbs_keywords(" AND status=1 "," ORDER BY id DESC ",0,1,$city);
        }else if($tcadminConfig['open_sites_lbs'] == 3){
            $areaStr = $district;
            $sitesListTmp = C::t('#tom_tongcheng#tom_tongcheng_sites')->fetch_all_lbs_keywords(" AND status=1 "," ORDER BY id DESC ",0,1,$district);
        }
        
        if(!empty($sitesListTmp) && isset($sitesListTmp[0]) && $sitesListTmp[0]['id'] > 0){
            if($sitesListTmp[0]['id'] != $site_id){
                
                $msg = lang("plugin/tom_tongcheng", "index_lbs_msg2");
                $msg = str_replace("{AREA}",$areaStr,$msg);
                $msg = str_replace("{SITE}",$sitesListTmp[0]['lbs_name'],$msg);
                
                $outStr.= '<div class="tcui-dialog__bd" style="padding: 2em 20px 1.7em;">'.$msg.'</div>';
                $outStr.= '<div class="tcui-dialog__ft" style="line-height: 40px;">';
                    $outStr.= '<a href="javascript:;" onclick="closeLbs();" class="tcui-btn tcui-dialog__btn tcui-dialog__btn_default">'.lang("plugin/tom_tongcheng", "index_lbs_no").'</a>';
                    $outStr.= '<a href="plugin.php?id=tom_tongcheng&site='.$sitesListTmp[0]['id'].'&mod=index&lbs_no=1" class="tcui-dialog__btn tcui-dialog__btn_primary">'.lang("plugin/tom_tongcheng", "index_lbs_ok").'</a>';
                $outStr.= '</div>';
            }else{
                $outStr = '100';
            }
        }else if($tcadminConfig['open_sites_lbs'] > 1){
            if(1 != $site_id){
                $outStr.= '<div class="tcui-dialog__bd" style="padding: 2em 20px 1.7em;">'.lang("plugin/tom_tongcheng", "index_lbs_msg").''.$tongchengConfig['lbs_name'].'</div>';
                $outStr.= '<div class="tcui-dialog__ft" style="line-height: 40px;">';
                    $outStr.= '<a href="javascript:;" onclick="closeLbs();" class="tcui-btn tcui-dialog__btn tcui-dialog__btn_default">'.lang("plugin/tom_tongcheng", "index_lbs_no").'</a>';
                    $outStr.= '<a href="plugin.php?id=tom_tongcheng&site=1&mod=index&lbs_no=1" class="tcui-dialog__btn tcui-dialog__btn_primary">'.lang("plugin/tom_tongcheng", "index_lbs_ok").'</a>';
                $outStr.= '</div>';
            }else{
                $outStr = '100';
            }
        }else{
            $outStr = '100';
        }
        
    }else{
        $outStr = '100';
    }
    
    $outStr = diconv($outStr,CHARSET,'utf-8');
    echo json_encode($outStr); exit;
    
}else if($_GET['act'] == 'lbs_close' && $_GET['formhash'] == FORMHASH){
    
    $lifeTime = $tcadminConfig['sites_lbs_time'];
    dsetcookie('tom_tongcheng_sites_lbs', 1, $lifeTime);
    echo '200';exit;
    
}else if($_GET['act'] == 'miniprogram'){
    
    if($_GET['ok'] == 1){
        $lifeTime = 300;
        dsetcookie('tom_miniprogram', 1, $lifeTime);
    }else{
        $lifeTime = 1;
        dsetcookie('tom_miniprogram', 0, $lifeTime);
    }
    
    echo '200';exit;
    
}else if($_GET['act'] == 'update_lbs' && $_GET['formhash'] == FORMHASH){
    
    $latitude    = isset($_GET['latitude'])? addslashes($_GET['latitude']):'';
    $longitude   = isset($_GET['longitude'])? addslashes($_GET['longitude']):'';
    
    $cookieTime = 86400*3;
    
    dsetcookie('tom_tongcheng_user_latitude',$latitude,$cookieTime);
    dsetcookie('tom_tongcheng_user_longitude',$longitude,$cookieTime);
    
    echo 200;exit;
    
}else if($_GET['act'] == 'sfc_cache' && $_GET['formhash'] == FORMHASH){
    
    $modelInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_model')->fetch_all_list(' AND is_sfc = 1 ', 'ORDER BY id DESC', 0, 1);
    if(is_array($modelInfoTmp) && !empty($modelInfoTmp[0])){
        
        $typeListTmp = C::t('#tom_tongcheng#tom_tongcheng_model_type')->fetch_all_list(" AND model_id = {$modelInfoTmp[0]['id']} ", 'ORDER BY id DESC', 0, 10);
        $typeList= array();
        if(is_array($typeListTmp) && !empty($typeListTmp[0])){
            foreach($typeListTmp as $key => $value){
                $typeList[] = $value['id'];
            }
            $maxRefreshTime = TIMESTAMP - (12 * 30 * 86400);
            $tongchengListTmp = C::t('#tom_tongcheng#tom_tongcheng')->fetch_all_list(" AND model_id={$modelInfoTmp[0]['id']} AND type_id IN(".implode(',', $typeList).")  AND status=1 AND shenhe_status=1 AND refresh_time > {$maxRefreshTime} ", 'ORDER BY refresh_time DESC,id DESC', 0, 20);
            if(is_array($tongchengListTmp) && !empty($tongchengListTmp[0])){
                foreach($tongchengListTmp as $key => $value){
                    $typeInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_model_type')->fetch_by_id($value['type_id']);
                    if(!empty($typeInfoTmp['sfc_chufa_attr_id']) && !empty($typeInfoTmp['sfc_mude_attr_id']) && !empty($typeInfoTmp['sfc_time_attr_id']) && !empty($typeInfoTmp['sfc_renshu_attr_id'])){
                        $sfcChufaAttrInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_attr')->fetch_all_list(" AND attr_id = {$typeInfoTmp['sfc_chufa_attr_id']} AND tongcheng_id = {$value['id']}", 'ORDER BY id DESC', 0, 1);
                        $sfcMudeAttrInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_attr')->fetch_all_list(" AND attr_id = {$typeInfoTmp['sfc_mude_attr_id']} AND tongcheng_id = {$value['id']}", 'ORDER BY id DESC', 0, 1);
                        $sfcTimeAttrInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_attr')->fetch_all_list(" AND attr_id = {$typeInfoTmp['sfc_time_attr_id']} AND tongcheng_id = {$value['id']}", 'ORDER BY id DESC', 0, 1);
                        $sfcRenshuAttrInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_attr')->fetch_all_list(" AND attr_id = {$typeInfoTmp['sfc_renshu_attr_id']} AND tongcheng_id = {$value['id']}", 'ORDER BY id DESC', 0, 1);

                        if(is_array($sfcChufaAttrInfoTmp) && !empty($sfcChufaAttrInfoTmp[0]) && is_array($sfcMudeAttrInfoTmp) && !empty($sfcMudeAttrInfoTmp[0])){
                            $sfcCacheInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_sfc_cache')->fetch_all_list(" AND tongcheng_id = {$value['id']} ", 'ORDER BY id DESC', 0, 1);
                            if(is_array($sfcCacheInfoTmp) && !empty($sfcCacheInfoTmp[0])){
                            }else{
                                $insertData = array();
                                $insertData['site_id']      = $value['site_id'];
                                $insertData['tongcheng_id'] = $value['id'];
                                $insertData['model_id']     = $modelInfoTmp[0]['id'];
                                $insertData['type_id']      = $value['type_id'];
                                $insertData['chufa']        = $sfcChufaAttrInfoTmp[0]['value'];
                                $insertData['mude']         = $sfcMudeAttrInfoTmp[0]['value'];
                                $insertData['chufa_time']   = $sfcTimeAttrInfoTmp[0]['value'];
                                $insertData['chufa_int_time']  = $sfcTimeAttrInfoTmp[0]['time_value'];
                                $insertData['renshu']       = $sfcRenshuAttrInfoTmp[0]['value'];
                                $insertData['add_time']     = TIMESTAMP;
                                C::t('#tom_tongcheng#tom_tongcheng_sfc_cache')->insert($insertData);
                            }
                        }
                    }
                }
            }
            
        }
    }
    echo '200';exit;
}else{
    echo 'error';exit;
}

