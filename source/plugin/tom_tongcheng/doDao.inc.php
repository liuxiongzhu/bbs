<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$tongchengConfig = $_G['cache']['plugin']['tom_tongcheng'];
$tomSysOffset = getglobal('setting/timeoffset');

$colorArr = array();
$colorArr[1] = 'rgb(236, 75, 10)';
$colorArr[2] = 'rgb(234, 186, 0)';
$colorArr[3] = 'rgb(31, 199, 3)';
$colorArr[4] = 'rgb(3, 199, 137)';
$colorArr[5] = 'rgb(3, 143, 199)';

$page        = isset($_GET['page'])? intval($_GET['page']):1;
$site_id     = isset($_GET['site_id'])? intval($_GET['site_id']):0;
$day_type    = isset($_GET['day_type'])? intval($_GET['day_type']):1;
$days        = isset($_GET['days'])? intval($_GET['days']):0;
$pic         = isset($_GET['pic'])? intval($_GET['pic']):0;

$site_ids   = isset($_GET['site_ids'])? addslashes($_GET['site_ids']):'';
$site_ids_tmp = explode('_', $site_ids);
$site_ids_arr = array();
if(is_array($site_ids_tmp) && !empty($site_ids_tmp)){
    foreach ($site_ids_tmp as $key => $value){
        $value = intval($value);
        if($value > 0){
            $site_ids_arr[] = $value;
        }
    }
}

$model_ids   = isset($_GET['model_ids'])? addslashes($_GET['model_ids']):'';
$model_ids_tmp = explode('_', $model_ids);
$model_ids_arr = array();
if(is_array($model_ids_tmp) && !empty($model_ids_tmp)){
    foreach ($model_ids_tmp as $key => $value){
        $value = intval($value);
        if($value > 0){
            $model_ids_arr[] = $value;
        }
    }
}

$area_ids   = isset($_GET['area_ids'])? addslashes($_GET['area_ids']):'';
$area_ids_tmp = explode('|', $area_ids);
$area_ids_arr = array();
if(is_array($area_ids_tmp) && !empty($area_ids_tmp)){
    foreach ($area_ids_tmp as $key => $value){
        $value = intval($value);
        if($value > 0){
            $area_ids_arr[] = $value;
        }
    }
}

$where = " AND shenhe_status = 1 AND status = 1 AND finish = 0  ";

if(!empty($site_ids_arr)){
    $where.= " AND site_id IN (".implode(',',$site_ids_arr).") ";
}else if($site_id){
    $where.= " AND site_id = {$site_id} ";
}
if(!empty($model_ids_arr)){
    $where.= " AND model_id IN (".implode(',',$model_ids_arr).") ";
}
if(!empty($area_ids_arr)){
    $where.= " AND area_id IN (".implode(',',$area_ids_arr).") ";
}
if($days > 0){
    $minTime = TIMESTAMP - $days * 86400;
    if($day_type == 1){
        $where.= " AND (refresh_time > {$minTime} OR topstatus = 1 ) ";
    }else{
        $where.= " AND (add_time > {$minTime} OR topstatus = 1 ) ";
    }
}

$order = " ORDER BY type_id ASC,refresh_time DESC,id DESC ";
if($day_type == 2){
    $order = " ORDER BY type_id ASC,add_time DESC,id DESC ";
}

$pagesize = 1000;
$start = ($page-1)*$pagesize;
include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/class/function.core.php';

if(isset($_G['uid']) && $_G['uid'] > 0 && $_G['groupid'] == 1){
    
    $tonchengListTmp = C::t('#tom_tongcheng#tom_tongcheng')->fetch_all_list($where,$order,$start,$pagesize);
    $topList = array();
    $tonchengList = array();
    foreach ($tonchengListTmp as $key => $value) {
        
        $modelInfo = C::t('#tom_tongcheng#tom_tongcheng_model')->fetch_by_id($value['model_id']);
        $typeInfo = C::t('#tom_tongcheng#tom_tongcheng_model_type')->fetch_by_id($value['type_id']);
        $tongchengTagList = C::t('#tom_tongcheng#tom_tongcheng_tag')->fetch_all_list(" AND tongcheng_id={$value['id']} "," ORDER BY id DESC ",0,50);
        $tongchengAttrList = C::t('#tom_tongcheng#tom_tongcheng_attr')->fetch_all_list(" AND tongcheng_id={$value['id']} "," ORDER BY paixu ASC,id DESC ",0,50);
        
        $tongchengPhotoListTmpTmp = C::t('#tom_tongcheng#tom_tongcheng_photo')->fetch_all_list(" AND tongcheng_id={$value['id']} "," ORDER BY id ASC ",0,1);
        $tongchengPhotoFirstPicurl = '';
        if(is_array($tongchengPhotoListTmpTmp) && !empty($tongchengPhotoListTmpTmp) && $pic == 1){
            foreach ($tongchengPhotoListTmpTmp as $kk => $vv){
                if(!preg_match('/^http/', $vv['picurl']) ){
                    if(strpos($vv['picurl'], 'source/plugin/tom_tongcheng/data/') === false){
                        $picurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'tomwx/'.$vv['picurl'];
                    }else{
                        $picurl = $_G['siteurl'].$vv['picurl'];
                    }
                }else{
                    $picurl = $vv['picurl'];
                }
                $tongchengPhotoFirstPicurl = $picurl;
            }
        }
        
        $content = "";
        $cateInfoTmp = array();
        if($value['cate_id'] > 0){
            $cateInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_model_cate')->fetch_by_id($value['cate_id']);
            if($cateInfoTmp){
                $content.= $typeInfo['cate_title'].':'.$cateInfoTmp['name'].'&nbsp;&nbsp;';
            }
        }
        if(is_array($tongchengTagList) && !empty($tongchengTagList)){
            foreach ($tongchengTagList as $tagk => $tagv){
                $content.= '['.$tagv['tag_name'].']';
            }
            $content.= '&nbsp;&nbsp;';
        }
        if(is_array($tongchengAttrList) && !empty($tongchengAttrList)){
            foreach ($tongchengAttrList as $attrk => $attrv){
                $content.= $attrv['attr_name'].':'.$attrv['value'].'';
                if(!empty($attrv['unit'])){
                    $content.= ''.$attrv['unit'];
                }
                $content.= '&nbsp;&nbsp;';
            }
        }
        $content.= contentFormat($value['content']);
        $content = str_replace("\r\n","",$content);
        $content = str_replace("\n","",$content);
        $content = str_replace("\r","",$content);
        
        if($value['topstatus'] == 1){
            $topList[$key]['type'] = lang('plugin/tom_tongcheng', 'doDao_left').$typeInfo['name'].lang('plugin/tom_tongcheng', 'doDao_right');
            $topList[$key]['content'] = $content;
            $topList[$key]['tel'] = $value['tel'];
            $topList[$key]['picurl'] = $tongchengPhotoFirstPicurl;
        }else{
            $tonchengList[$modelInfo['id']]['name'] = $modelInfo['name'];
            $tonchengList[$modelInfo['id']]['data'][$key]['type'] = lang('plugin/tom_tongcheng', 'doDao_left').$typeInfo['name'].lang('plugin/tom_tongcheng', 'doDao_right');
            $tonchengList[$modelInfo['id']]['data'][$key]['content'] = $content;
            $tonchengList[$modelInfo['id']]['data'][$key]['tel'] = $value['tel'];
            $tonchengList[$modelInfo['id']]['data'][$key]['picurl'] = $tongchengPhotoFirstPicurl;
        }
    }
    
    $newList = array();
    if(is_array($model_ids_arr) && !empty($model_ids_arr)){
        foreach ($model_ids_arr as $key => $value){
            if(isset($tonchengList[$value])){
                $newList[$value] = $tonchengList[$value];
            }
        }
    }
    
    if (CHARSET == 'gbk'){
        $outStr = '<meta charset="gbk" /> ';
    }else{
        $outStr = '<meta charset="utf-8" /> ';
    }
    $outStr.= '<section style="font-family: '.lang('plugin/tom_tongcheng', 'doDao_font_family').'; font-size: 16px;">';
         $outStr.= '<p style="white-space: normal;"><br /></p> ';
         $outStr.= '<p style="max-width: 100%; min-height: 1em; color: rgb(62, 62, 62); font-family: '.lang('plugin/tom_tongcheng', 'doDao_font_family').'; font-size: 16px; letter-spacing: 1px; line-height: 25.6px; white-space: normal; text-align: center; box-sizing: border-box !important; word-wrap: break-word !important; background-color: rgb(255, 255, 255);">';
           $outStr.= '<span style="max-width: 100%; color: rgb(255, 255, 255); box-sizing: border-box !important; word-wrap: break-word !important; background-color: rgb(236, 101, 5);">'.lang('plugin/tom_tongcheng', 'doDao_msg1').'</span>';
         $outStr.= '</p> ';
         $outStr.= '<p style="max-width: 100%; min-height: 1em; color: rgb(62, 62, 62); font-family: '.lang('plugin/tom_tongcheng', 'doDao_font_family').'; font-size: 16px; letter-spacing: 1px; line-height: 25.6px; white-space: normal; text-align: center; box-sizing: border-box !important; word-wrap: break-word !important; background-color: rgb(255, 255, 255);"> ';
           $outStr.= '<span style="max-width: 100%; color: rgb(255, 255, 255); box-sizing: border-box !important; word-wrap: break-word !important; background-color: rgb(236, 101, 5);">'.lang('plugin/tom_tongcheng', 'doDao_msg2').'</span> ';
         $outStr.= '</p> ';
         $outStr.= '<p style="max-width: 100%; min-height: 1em; color: rgb(62, 62, 62); font-family: '.lang('plugin/tom_tongcheng', 'doDao_font_family').'; font-size: 16px; letter-spacing: 1px; line-height: 25.6px; white-space: normal; text-align: center; box-sizing: border-box !important; word-wrap: break-word !important; background-color: rgb(255, 255, 255);">'; 
           $outStr.= '<span style="max-width: 100%; color: rgb(236, 101, 5); font-size: 12px; line-height: 19.2px; box-sizing: border-box !important; word-wrap: break-word !important;">'.lang('plugin/tom_tongcheng', 'doDao_jian').'</span> ';
         $outStr.= '</p> ';
         $outStr.= '<p style="margin: 0px;max-width: 100%; min-height: 1em; color: rgb(62, 62, 62); font-family: '.lang('plugin/tom_tongcheng', 'doDao_font_family').'; font-size: 16px; letter-spacing: 1px; line-height: 25.6px; white-space: normal; text-align: center; box-sizing: border-box !important; word-wrap: break-word !important; background-color: rgb(255, 255, 255);">';
           $outStr.= '<img style="max-width: 60%;" src="'.$tongchengConfig['fwh_qrcode'].'"/>';
         $outStr.= '</p> <br /> ';
    $outStr.= '</section> ';
    
    if(is_array($topList) && !empty($topList)){
        $outStr.= '<section style="margin: 2em 0em; padding: 0.5em 0.8em; white-space: normal; border: 1px solid '.$colorArr[1].';border-radius: 6px; font-size: 1em; font-family: inherit; font-weight: inherit; text-decoration: inherit; color: rgb(166, 166, 166); background-color: rgb(255, 255, 255);"> ';
           $outStr.= '<section style="margin-top: -1.4em; text-align: center; border: none; line-height: 1.4;"> ';
              $outStr.= '<section style="padding-right: 24px; padding-left: 24px; color: '.$colorArr[1].'; font-size: 30px; font-family: inherit; text-decoration: inherit; border-color: rgb(255, 255, 255); display: inline-block; background-color: rgb(254, 255, 255); "> ';
                 $outStr.= '<section>'.lang('plugin/tom_tongcheng', 'doDao_top_title').'</section> ';
              $outStr.= '</section> ';
           $outStr.= '</section> ';
           $outStr.= '<section style="padding: 16px 0px; color: rgb(32, 32, 32); line-height: 2; font-family: inherit;"> ';
           foreach ($topList as $kk => $vv){
               $outStr.= '<p style="word-break:break-all;word-wrap:break-word;border-bottom: 1px dashed rgb(225, 225, 225);margin: 5px 0px;padding-bottom: 5px;"> ';
                  $outStr.= '<span style="color: rgb(32, 32, 32); font-family: '.lang('plugin/tom_tongcheng', 'doDao_font_family').'; font-size: 16px; line-height: 1.5; background-color: rgb(255, 255, 255); word-wrap: break-word; text-decoration: inherit;"><span style="color: '.$colorArr[1].';">'.lang('plugin/tom_tongcheng', 'doDao_jian').$vv['type'].'</span>'.$vv['content'].'<b style="color:#222">'.lang('plugin/tom_tongcheng', 'doDao_msg_lianxi_1').$vv['tel'].lang('plugin/tom_tongcheng', 'doDao_msg_lianxi_2').'</b></span> ';
                  if(!empty($vv['picurl'])){
                      $outStr.= '<span style="display: block;text-align: center;"><img style="max-width: 100%;" src="'.$vv['picurl'].'"/></span> ';
                  }
                $outStr.= '</p> ';
           }
           $outStr.= '</section>';
        $outStr.= '</section>';
    }
    
    $color_i = 2;
    if(is_array($newList) && !empty($newList)){
        foreach ($newList as $key => $value){
            $outStr.= '<section style="margin: 2em 0em; padding: 0.5em 0.8em; white-space: normal; border: 1px solid '.$colorArr[$color_i].';border-radius: 6px; font-size: 1em; font-family: inherit; font-weight: inherit; text-decoration: inherit; color: rgb(166, 166, 166); background-color: rgb(255, 255, 255);"> ';
               $outStr.= '<section style="margin-top: -1.4em; text-align: center; border: none; line-height: 1.4;"> ';
                  $outStr.= '<section style="padding-right: 24px; padding-left: 24px; color: '.$colorArr[$color_i].'; font-size: 30px; font-family: inherit; text-decoration: inherit; border-color: rgb(255, 255, 255); display: inline-block; background-color: rgb(254, 255, 255); "> ';
                     $outStr.= '<section>'.$value['name'].'</section> ';
                  $outStr.= '</section> ';
               $outStr.= '</section> ';
               $outStr.= '<section style="padding: 16px 0px; color: rgb(32, 32, 32); line-height: 2; font-family: inherit;"> ';
               foreach ($value['data'] as $kk => $vv){
                   $outStr.= '<p style="word-break:break-all;word-wrap:break-word;border-bottom: 1px dashed rgb(225, 225, 225);margin: 5px 0px;padding-bottom: 5px;"> ';
                      $outStr.= '<span style="color: rgb(32, 32, 32); font-family: '.lang('plugin/tom_tongcheng', 'doDao_font_family').'; font-size: 16px; line-height: 1.5; background-color: rgb(255, 255, 255); word-wrap: break-word; text-decoration: inherit;"><span style="color: '.$colorArr[$color_i].';">'.lang('plugin/tom_tongcheng', 'doDao_jian').$vv['type'].'</span>'.$vv['content'].'<b style="color:#222">'.lang('plugin/tom_tongcheng', 'doDao_msg_lianxi_1').$vv['tel'].lang('plugin/tom_tongcheng', 'doDao_msg_lianxi_2').'</b></span> ';
                      if(!empty($vv['picurl'])){
                          $outStr.= '<span style="display: block;text-align: center;"><img style="max-width: 100%;" src="'.$vv['picurl'].'"/></span> ';
                      }
                    $outStr.= '</p> ';
               }
               $outStr.= '</section>';
            $outStr.= '</section>';
            $color_i++;
            if($color_i == 6){
                $color_i = 1;
            }
        }
    }
    
    $doDao_msg3 = lang('plugin/tom_tongcheng', 'doDao_msg3');
    $doDao_msg3 = str_replace('{SITENAME}', $tongchengConfig['plugin_name'], $doDao_msg3);
    $outStr.= '<span style="color:#999;font-size: 14px;"><span style="color:red"> '.lang('plugin/tom_tongcheng', 'doDao_msg_mz').'</span><br /> '.$doDao_msg3.'</span><br /><br />';
    
    echo $outStr;
    exit;
}else{
    exit('Access Denied');
}