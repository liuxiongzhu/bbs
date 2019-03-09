<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$tcshop_id = intval($_GET['tcshop_id'])>0? intval($_GET['tcshop_id']):0;

$tcshopInfo = C::t('#tom_tcshop#tom_tcshop')->fetch_by_id($tcshop_id);

if($_GET['act'] == 'add' && $_GET['formhash'] == FORMHASH){
    $outArr = array(
        'status'=> 1,
    );
    
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
    
    $name            = isset($_GET['name'])? addslashes($_GET['name']):'';
    $csort           = isset($_GET['csort'])? intval($_GET['csort']):'';
    
    $insertData = array();
    $insertData['tcshop_id']   = $tcshop_id;
    $insertData['name']        = $name;
    $insertData['csort']       = $csort;
    if(C::t('#tom_tcshop#tom_tcshop_mall_cate')->insert($insertData)){
        $outArr = array(
            'status'=> 200,
        );
        echo json_encode($outArr); exit;
    }else{
        $outArr = array(
            'status'=> 404,
        );
        echo json_encode($outArr); exit;
    }
}else if($_GET['act'] == 'save' && $_GET['formhash'] == FORMHASH){
    
    $outArr = array(
        'status'=> 1,
    );
    
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
    
    $cate_id         = isset($_GET['cate_id'])? intval($_GET['cate_id']):0;
    $name            = isset($_GET['name'])? addslashes($_GET['name']):'';
    $csort           = isset($_GET['csort'])? intval($_GET['csort']):'';
    
    
    $updateData = array();
    $updateData['name']        = $name;
    $updateData['csort']       = $csort;
    if(C::t('#tom_tcshop#tom_tcshop_mall_cate')->update($cate_id,$updateData)){
        
        $outArr = array(
            'status'=> 200,
        );
        echo json_encode($outArr); exit;
        
    }else{
        $outArr = array(
            'status'=> 404,
        );
        echo json_encode($outArr); exit;
    }
}else if($_GET['act'] == 'del' && $_GET['formhash'] == FORMHASH){
    
    $cate_id         = isset($_GET['cate_id'])? intval($_GET['cate_id']):0;
    
    C::t('#tom_tcshop#tom_tcshop_mall_cate')->delete_by_id($cate_id);
    
    echo 200;exit;
    
}else if($_GET['act'] == 'edit'){
    
    $cate_id         = isset($_GET['cate_id'])? intval($_GET['cate_id']):0;
    
    $cateInfo = C::t('#tom_tcshop#tom_tcshop_mall_cate')->fetch_by_id($cate_id);
    
}

$tcshopListTmp = C::t('#tom_tcshop#tom_tcshop')->fetch_all_list("AND user_id={$__UserInfo['id']} AND status=1 AND shenhe_status=1 "," ORDER BY id DESC ",0,100);
$tcshopList = array();
if(is_array($tcshopListTmp) && !empty($tcshopListTmp)){
    foreach($tcshopListTmp as $key => $value){
        $tcshopList[$key] = $value;
    }
}

if($tcshopInfo){
    $mallCateListTmp = C::t('#tom_tcshop#tom_tcshop_mall_cate')->fetch_all_list("AND tcshop_id={$tcshop_id} "," ORDER BY csort ASC,id DESC ",0,100);
    $mallCateList = array();
    if(is_array($mallCateListTmp) && !empty($mallCateListTmp)){
        foreach($mallCateListTmp as $key => $value){
            $mallCateList[$key] = $value;
        }
    } 
}


$addUrl = "plugin.php?id=tom_tcshop&site={$site_id}&mod=mallCate&act=add";
$saveUrl = "plugin.php?id=tom_tcshop&site={$site_id}&mod=mallCate&act=save";
$delUrl = "plugin.php?id=tom_tcshop&site={$site_id}&mod=mallCate&act=del&formhash=".FORMHASH;

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
include template("tom_tcshop:mallCate");