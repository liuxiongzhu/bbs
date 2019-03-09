<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
   微信支付回调接口文件
*/

if(!defined('IN_DISCUZ') || !defined('IN_TOM_PAY')) {
	exit('Access Denied');
}

$tchehuorenConfig = $_G['cache']['plugin']['tom_tchehuoren'];
$tongchengConfig = $_G['cache']['plugin']['tom_tongcheng'];

$tomSysOffset = getglobal('setting/timeoffset');
$appid = trim($tongchengConfig['wxpay_appid']);  
$appsecret = trim($tongchengConfig['wxpay_appsecret']); 
include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/class/weixin.class.php';
$weixinClass = new weixinClass($appid,$appsecret);
include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/class/templatesms.class.php';

$shenqingInfo = C::t('#tom_tchehuoren#tom_tchehuoren_shenqing')->fetch_by_order_no($order_no);

if($shenqingInfo && $shenqingInfo['status'] == 4){

    $tcUserInfo = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($shenqingInfo['user_id']);
    Log::DEBUG("update user:" . json_encode(iconv_to_utf8($tcUserInfo['id'])));
    if($tchehuorenConfig['open_not_shenhe'] == 1){
        $updateData = array();
        $updateData['status'] = 2;
        C::t('#tom_tchehuoren#tom_tchehuoren_shenqing')->update($shenqingInfo['id'],$updateData);
        
        $tchehuorenInfo = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_by_user_id($tcUserInfo['id']);

        if(!$tchehuorenInfo){
            $tchehuorenInfoTmp = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_all_list('', 'ORDER BY invite_id DESC,id DESC', 0, 1);
            $dengjiInfo = C::t('#tom_tchehuoren#tom_tchehuoren_dengji')->fetch_all_list(' AND level = 1 ', 'ORDER BY level DESC, id DESC', 0, 1);
            $invite_id = 11111;
            if(is_array($tchehuorenInfoTmp) && !empty($tchehuorenInfoTmp[0])){
                if($tchehuorenInfoTmp[0]['invite_id'] >= 11111){
                    $invite_id  = $tchehuorenInfoTmp[0]['invite_id'] + 1;
                }
            }
            
            $inviteStr = tom_random(1, 'qwertyupasdfghkzxcvbnm');
            $invite_code = $inviteStr.$invite_id;

            $insertData = array();
            $insertData['user_id']              = $tcUserInfo['id'];
            $insertData['tj_hehuoren_id']       = $shenqingInfo['tj_hehuoren_id'];
            $insertData['picurl']               = $tcUserInfo['picurl'];
            $insertData['xm']                   = $shenqingInfo['xm'];
            $insertData['tel']                  = $shenqingInfo['tel'];
            $insertData['openid']               = $tcUserInfo['openid'];
            $insertData['dengji_id']            = $dengjiInfo[0]['id'];
            $insertData['invite_id']            = $invite_id;
            $insertData['invite_code']          = $invite_code;
            $insertData['add_time']             = TIMESTAMP;
            C::t('#tom_tchehuoren#tom_tchehuoren')->insert($insertData);
        }

        $shenhe = lang('plugin/tom_tchehuoren', 'shenqing_hehuoren_template').lang('plugin/tom_tchehuoren', 'shenqing_status_2');

        $access_token = $weixinClass->get_access_token();
        if($access_token && !empty($tcUserInfo['openid'])){
            $templateSmsClass = new templateSms($access_token, $_G['siteurl']."plugin.php?id=tom_tchehuoren&mod=inlet&tj_hehuoren_id=".$shenqingInfo['tj_hehuoren_id']);
            $smsData = array(
                'first'         => $shenhe,
                'keyword1'      => $tchehuorenConfig['plugin_name'],
                'keyword2'      => dgmdate(TIMESTAMP,"Y-m-d H:i:s",$tomSysOffset),
                'remark'        => ''
            );
            if(!empty($tchehuorenConfig['template_id'])){
                $template_id = $tchehuorenConfig['template_id'];
            }else{
                $template_id = $tongchengConfig['template_id'];
            }
            @$r = $templateSmsClass->sendSms01($tcUserInfo['openid'], $template_id, $smsData);
        }
        if($access_token && !empty($tchehuorenConfig['manage_user_id'])){
            $userInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($tchehuorenConfig['manage_user_id']);
            if(!empty($userInfoTmp['openid'])){
                $templateSmsClass = new templateSms($access_token, $_G['siteurl']."plugin.php?id=tom_tchehuoren&mod=index");
                $smsData = array(
                    'first'         => lang('plugin/tom_tchehuoren', 'pay_template_new_hehuoren'),
                    'keyword1'      => $tchehuorenConfig['plugin_name'],
                    'keyword2'      => dgmdate(TIMESTAMP,"Y-m-d H:i:s",$tomSysOffset),
                    'remark'        => ''
                );
                if(!empty($tchehuorenConfig['template_id'])){
                    $template_id = $tchehuorenConfig['template_id'];
                }else{
                    $template_id = $tongchengConfig['template_id'];
                }
                @$r = $templateSmsClass->sendSms01($userInfoTmp['openid'], $template_id, $smsData);
            }
        }

        $insertData = array();
        $insertData['user_id']      = $tcUserInfo['id'];
        $insertData['type']         = 1;
        $insertData['content']      = '<font color="#238206">'.$tchehuorenConfig['plugin_name'].'</font><br/>'.$shenhe.'<br/>'.dgmdate(TIMESTAMP,"Y-m-d H:i:s",$tomSysOffset);
        $insertData['is_read']      = 0;
        $insertData['tz_time']      = TIMESTAMP;
        C::t('#tom_tongcheng#tom_tongcheng_tz')->insert($insertData);
        
    }else{
        $updateData = array();
        $updateData['status'] = 1;
        C::t('#tom_tchehuoren#tom_tchehuoren_shenqing')->update($shenqingInfo['id'],$updateData);
        
        $access_token = $weixinClass->get_access_token();
        if($access_token && !empty($tchehuorenConfig['manage_user_id'])){
            $userInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($tchehuorenConfig['manage_user_id']);
            if(!empty($userInfoTmp['openid'])){
                $templateSmsClass = new templateSms($access_token, $_G['siteurl']."plugin.php?id=tom_tchehuoren&mod=index");
                $smsData = array(
                    'first'         => lang('plugin/tom_tchehuoren', 'ajax_template_shenhe'),
                    'keyword1'      => $tchehuorenConfig['plugin_name'],
                    'keyword2'      => dgmdate(TIMESTAMP,"Y-m-d H:i:s",$tomSysOffset),
                    'remark'        => ''
                );
                if(!empty($tchehuorenConfig['template_id'])){
                    $template_id = $tchehuorenConfig['template_id'];
                }else{
                    $template_id = $tongchengConfig['template_id'];
                }
                @$r = $templateSmsClass->sendSms01($userInfoTmp['openid'], $template_id, $smsData);
            }
        }
    }

}

function tom_random($length, $chars = '0123456789') {
	$hash = '';
	$max = strlen($chars) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $chars[mt_rand(0, $max)];
	}
	return $hash;
}