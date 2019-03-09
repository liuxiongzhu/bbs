<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
   
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


$do_uid = intval($_GET['do_uid'])>0? intval($_GET['do_uid']):0;
$do_key = !empty($_GET['do_key'])? addslashes($_GET['do_key']):'';

if($do_uid > 0){
    $checkMemberInfoTmp = C::t('#tom_ucenter#tom_ucenter_member')->fetch_by_uid($do_uid);
    $check_do_key = md5($checkMemberInfoTmp['uid'].'___'.$checkMemberInfoTmp['mykey']);
    if($check_do_key == $do_key){
    }else{
        echo 'do_key error';exit;
    }
}else{
    echo 'do_uid error';exit;
}


if($_GET['act'] == 'login'){
    
    $majia_user_id = intval($_GET['majia_user_id'])>0? intval($_GET['majia_user_id']):0;
    $majiaUserInfo = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($majia_user_id);
    
    if($majiaUserInfo['is_majia'] == 1){
        if($majiaUserInfo['member_id']){
            $memberInfoTmp = C::t('#tom_ucenter#tom_ucenter_member')->fetch_by_uid($majiaUserInfo['member_id']);
            if($memberInfoTmp){
                $lifeTime = 86400;
                dsetcookie('tom_ucenter_member_uid',$memberInfoTmp['uid'],$lifeTime);
                dsetcookie('tom_ucenter_member_key',md5($memberInfoTmp['uid'].'|||'.$memberInfoTmp['mykey']),$lifeTime);
                exit;
            }
        }
    }
    
}else if($_GET['act'] == 'login_out'){
    
    $lifeTime = 86400;
    dsetcookie('tom_ucenter_member_uid',0,$lifeTime);
    dsetcookie('tom_ucenter_member_key','',$lifeTime);
    
    exit;
}