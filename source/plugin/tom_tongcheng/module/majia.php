<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

## tcmajia start
$openMajiaStatus = 0;
if($__ShowTcmajia == 1){
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
    if($__UserInfo['is_majia'] == 1){
        $openMajiaStatus = 1;
    }
}
## tcmajia end

if($openMajiaStatus == 0){
    tomheader('location:'.$_G['siteurl']."plugin.php?id=tom_tongcheng&site={$site_id}&mod=index");exit;
}

if($_GET['act'] == 'login' && $_GET['formhash'] == FORMHASH){
    
    $outArr = array(
        'status'=> 1,
    );
    
    $majia_user_id = intval($_GET['majia_user_id'])>0? intval($_GET['majia_user_id']):0;
    
    $majiaUserInfo = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($majia_user_id);
    
    if($majiaUserInfo['member_id']){
        $memberInfoTmp = C::t('#tom_ucenter#tom_ucenter_member')->fetch_by_uid($majiaUserInfo['member_id']);
        if($memberInfoTmp){
            $lifeTime = 86400;
            dsetcookie('tom_ucenter_member_uid',$memberInfoTmp['uid'],$lifeTime);
            dsetcookie('tom_ucenter_member_key',md5($memberInfoTmp['uid'].'|||'.$memberInfoTmp['mykey']),$lifeTime);
            $outArr = array(
                'status'=> 200,
            );
            echo json_encode($outArr); exit;
        }
    }
    
    $mykey = substr(str_shuffle("012345678901234567890123456789"), 0, 6);
    $insertData = array();
    $insertData['openid']               = '';
    $insertData['unionid']              = '';
    $insertData['nickname']             = $majiaUserInfo['nickname'];
    $insertData['picurl']               = $majiaUserInfo['picurl'];
    $insertData['mykey']                = $mykey;
    $insertData['last_login_type']      = 'majia';
    $insertData['last_login_time']      = TIMESTAMP;
    $insertData['add_time']             = TIMESTAMP;
    if(C::t('#tom_ucenter#tom_ucenter_member')->insert($insertData)){
        $member_id = C::t('#tom_ucenter#tom_ucenter_member')->insert_id();
        
        $updateData                 = array();
        $updateData['member_id']    = $member_id;
        C::t('#tom_tongcheng#tom_tongcheng_user')->update($majiaUserInfo['id'],$updateData);
        
        $memberInfoTmp = C::t('#tom_ucenter#tom_ucenter_member')->fetch_by_uid($member_id);
        $lifeTime = 86400;
        dsetcookie('tom_ucenter_member_uid',$memberInfoTmp['uid'],$lifeTime);
        dsetcookie('tom_ucenter_member_key',md5($memberInfoTmp['uid'].'|||'.$memberInfoTmp['mykey']),$lifeTime);
        $outArr = array(
            'status'=> 200,
        );
        echo json_encode($outArr); exit;
    }
    
    echo json_encode($outArr); exit;
}else if($_GET['act'] == 'login_out' && $_GET['formhash'] == FORMHASH){
    $lifeTime = 86400;
    dsetcookie('tom_ucenter_member_uid',0,$lifeTime);
    dsetcookie('tom_ucenter_member_key','',$lifeTime);
    $outArr = array(
        'status'=> 200,
    );
    echo json_encode($outArr); exit;
}

$tcmajiaList = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_all_list(' AND is_majia = 1 ', 'ORDER BY id DESC', 0, 500);

$do_uid = $__MemberInfo['uid'];
$do_key = md5($__MemberInfo['uid'].'___'.$__MemberInfo['mykey']);

$showHongbaoIframe = 0;
if($__ShowTchongbao == 1){
    if($tchongbaoConfig['open_only_hosts'] == 1){
        $showHongbaoIframe = 1;
        $hongbaoUrl   = $_G['siteurl']."plugin.php?id=tom_tongcheng:majia&site={$site_id}";
        $hongbaoUrl = str_replace($tchongbaoConfig['tongcheng_hosts'], $tchongbaoConfig['hongbao_hosts'], $hongbaoUrl);
        if($tchongbaoConfig['must_http'] == 1){
            $hongbaoUrl = str_replace("https", "http", $hongbaoUrl);
        }
        $hongbaoLoginUrl    = $hongbaoUrl."&act=login&do_uid={$do_uid}&do_key={$do_key}&majia_user_id=";
        $hongbaoLoginOutUrl = $hongbaoUrl."&act=login_out&do_uid={$do_uid}&do_key={$do_key}";
    }
}

$showKjiaIframe = 0;
if($__ShowTckjia == 1){
    if($tckjiaConfig['open_only_hosts'] == 1){
        $showKjiaIframe = 1;
        $kjiaUrl   = $_G['siteurl']."plugin.php?id=tom_tongcheng:majia&site={$site_id}";
        $kjiaUrl = str_replace($tckjiaConfig['tongcheng_hosts'], $tckjiaConfig['kjia_hosts'], $kjiaUrl);
        if($tckjiaConfig['must_http'] == 1){
            $kjiaUrl = str_replace("https", "http", $kjiaUrl);
        }
        $kjiaLoginUrl    = $kjiaUrl."&act=login&do_uid={$do_uid}&do_key={$do_key}&majia_user_id=";
        $kjiaLoginOutUrl = $kjiaUrl."&act=login_out&do_uid={$do_uid}&do_key={$do_key}";
    }
}

$showPtuanIframe = 0;
if($__ShowTcptuan == 1){
    if($tcptuanConfig['open_only_hosts'] == 1){
        $showPtuanIframe = 1;
        $ptuanUrl   = $_G['siteurl']."plugin.php?id=tom_tongcheng:majia&site={$site_id}";
        $ptuanUrl = str_replace($tcptuanConfig['tongcheng_hosts'], $tcptuanConfig['ptuan_hosts'], $ptuanUrl);
        if($tcptuanConfig['must_http'] == 1){
            $ptuanUrl = str_replace("https", "http", $ptuanUrl);
        }
        $ptuanLoginUrl    = $ptuanUrl."&act=login&do_uid={$do_uid}&do_key={$do_key}&majia_user_id=";
        $ptuanLoginOutUrl = $ptuanUrl."&act=login_out&do_uid={$do_uid}&do_key={$do_key}";
    }
}

$loginUrl = "plugin.php?id=tom_tongcheng&site={$site_id}&mod=majia&act=login&formhash=".FORMHASH;
$loginOutUrl = "plugin.php?id=tom_tongcheng&site={$site_id}&mod=majia&act=login_out&formhash=".FORMHASH;

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
include template("tom_tongcheng:majia");  




