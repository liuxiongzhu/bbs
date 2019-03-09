<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$site_id = intval($_GET['site'])>0? intval($_GET['site']):1;

session_start();
define('TPL_DEFAULT', true);
$formhash = FORMHASH;
$tongchengConfig = $_G['cache']['plugin']['tom_tongcheng'];
$xiaofenleiConfig = $_G['cache']['plugin']['tom_xiaofenlei'];
$tomSysOffset = getglobal('setting/timeoffset');
$appid = trim($xiaofenleiConfig['wxpay_appid']);  
$appsecret = trim($xiaofenleiConfig['wxpay_appsecret']);

include DISCUZ_ROOT.'./source/plugin/tom_xiaofenlei/class/function.core.php';

if(isset($_G['uid']) && $_G['uid'] > 0 && $_G['groupid'] == 1){
    
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    
    $pagesize = 100;
    $start = ($page-1)*$pagesize;	
    $userListTmp = C::t('#tom_xiaofenlei#tom_xiaofenlei_user')->fetch_all_list("","ORDER BY id DESC",$start,$pagesize);
    $overStatus = 0;
    $delNum = 0;
    if(is_array($userListTmp) && !empty($userListTmp)){
        foreach ($userListTmp as $key => $value){
            if(empty($value['unionid'])){
                $userInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($value['user_id']);
                if($userInfoTmp && $userInfoTmp['nickname'] != $value['nickname']){
                    $delNum++;
                    C::t('#tom_xiaofenlei#tom_xiaofenlei_user')->delete_by_id($value['id']);
                }
            }
        }
    }else{
        $overStatus = 1;
    }
    
    if($overStatus == 1){
        echo 'do over !!!!';exit;
    }else{
        echo 'DEL '.$delNum.'<br/><br/>';
        echo 'please open next page !!!';exit;
    }
    
}else{
    exit('Access Denied');
}

