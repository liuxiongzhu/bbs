<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
   微信支付回调接口文件
*/

if(!defined('IN_DISCUZ') || !defined('IN_TOM_PAY')) {
	exit('Access Denied');
}

$tchongbaoConfig = $_G['cache']['plugin']['tom_tchongbao'];
$tongchengConfig = $_G['cache']['plugin']['tom_tongcheng'];

## tcadmin start
$__ShowTcadmin = 0;
$tcadminConfig = array();
if(file_exists(DISCUZ_ROOT.'./source/plugin/tom_tcadmin/tom_tcadmin.inc.php')){
    $tcadminConfig = $_G['cache']['plugin']['tom_tcadmin'];
    if($tcadminConfig['open_fc'] == 1){
        $__ShowTcadmin = 1;
    }
}
## tcadmin end

$orderInfo = C::t('#tom_tchongbao#tom_tchongbao')->fetch_by_order_no($order_no);

if($orderInfo && $orderInfo['pay_status'] == 1){
    
    $tchongbaoListTmp = array();
    if($orderInfo['tongcheng_id'] > 0){
        $tchongbaoListTmp = C::t('#tom_tchongbao#tom_tchongbao')->fetch_all_list(" AND tongcheng_id = {$orderInfo['tongcheng_id']} AND pay_status = 2 AND only_show = 1  ", 'ORDER BY id DESC', 0, 100);
    }else if($orderInfo['tcshop_id'] > 0){
        $tchongbaoListTmp = C::t('#tom_tchongbao#tom_tchongbao')->fetch_all_list(" AND tcshop_id = {$orderInfo['tcshop_id']} AND pay_status = 2 AND only_show = 1  ", 'ORDER BY id DESC', 0, 100);
    }
    
    if(is_array($tchongbaoListTmp) && !empty($tchongbaoListTmp)){
        foreach($tchongbaoListTmp as $key => $value){
            $updateData = array();
            $updateData['only_show'] = 2;
            C::t('#tom_tchongbao#tom_tchongbao')->update($value['id'], $updateData);
        }
    }
    
    $updateData = array();
    $updateData['pay_status'] = 2;
    C::t('#tom_tchongbao#tom_tchongbao')->update($orderInfo['id'],$updateData);

    if($__ShowTcadmin == 1 && $orderInfo['site_id'] > 0 && $tchongbaoConfig['child_site_fc_open'] == 1){
        $admin_fc_money = 0;
        if($tchongbaoConfig['child_site_fc_scale'] > 0 && $tchongbaoConfig['child_site_fc_scale'] < 100){
            $admin_fc_money = $orderInfo['sx_money'] * ($tchongbaoConfig['child_site_fc_scale']/100);
            $admin_fc_money = number_format($admin_fc_money,2);
        }
        
        Log::DEBUG("update admin_fc_money:" . $admin_fc_money);
        
        if($admin_fc_money > 0){
            $walletInfo = C::t('#tom_tcadmin#tom_tcadmin_wallet')->fetch_by_site_id($orderInfo['site_id']);

            $old_money = 0;
            if($walletInfo){
                $old_money = $walletInfo['account_balance'];

                $updateData = array();
                $updateData['account_balance']   = $walletInfo['account_balance'] + $admin_fc_money;
                $updateData['total_income']   = $walletInfo['total_income'] + $admin_fc_money;
                C::t('#tom_tcadmin#tom_tcadmin_wallet')->update($walletInfo['id'],$updateData);
            }else{
                $insertData = array();
                $insertData['site_id']              = $orderInfo['site_id'];
                $insertData['account_balance']      = $admin_fc_money;
                $insertData['total_income']         = $admin_fc_money;
                $insertData['add_time']             = TIMESTAMP;
                C::t('#tom_tcadmin#tom_tcadmin_wallet')->insert($insertData);
            }

            $insertData = array();
            $insertData['site_id']      = $orderInfo['site_id'];
            $insertData['log_type']     = 1;
            $insertData['change_money'] = $admin_fc_money;
            $insertData['old_money']    = $old_money;
            $insertData['beizu']        = lang('plugin/tom_tchongbao','site_fc_text');
            $insertData['order_no']     = $orderInfo['order_no'];
            $insertData['order_type']   = 1;
            $insertData['log_ip']       = $_G['clientip'];
            $insertData['log_time']     = TIMESTAMP;
            C::t('#tom_tcadmin#tom_tcadmin_wallet_log')->insert($insertData);
        }
        
    }
    
    Log::DEBUG("update order:" . json_encode(iconv_to_utf8($orderInfo)));

}
