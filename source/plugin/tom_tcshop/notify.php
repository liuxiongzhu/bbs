<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
   微信支付回调接口文件
*/

define('APPTYPEID', 127);
define('CURSCRIPT', 'plugin');
define('DISABLEXSSCHECK', true); 

$_GET['id'] = 'tom_tcshop';

require substr(dirname(__FILE__), 0, -25).'/source/class/class_core.php';

$discuz = C::app();
$cachelist = array('plugin', 'diytemplatename');

$discuz->cachelist = $cachelist;
$discuz->init();

define('CURMODULE', 'tom_tcshop');

$_G['siteurl'] = substr($_G['siteurl'], 0, -25);
$_G['siteroot'] = substr( $_G['siteroot'], 0, - 25);

$tcshopConfig = $_G['cache']['plugin']['tom_tcshop'];
$tongchengConfig = $_G['cache']['plugin']['tom_tongcheng'];

$wxpay_appid        = trim($tongchengConfig['wxpay_appid']);
$wxpay_mchid        = trim($tongchengConfig['wxpay_mchid']);
$wxpay_key          = trim($tongchengConfig['wxpay_key']);
$wxpay_appsecret    = trim($tongchengConfig['wxpay_appsecret']);

define("TOM_WXPAY_APPID", $wxpay_appid);
define("TOM_WXPAY_MCHID", $wxpay_mchid);
define("TOM_WXPAY_KEY", $wxpay_key);
define("TOM_WXPAY_APPSECRET", $wxpay_appsecret);

include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/class/wxpay/lib/WxPay.Api.php';
include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/class/wxpay/lib/WxPay.Notify.php';
include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/class/wxpay/log.php';

include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/class/function.core.php';

$logDir = DISCUZ_ROOT."./source/plugin/tom_tongcheng/logs/";
if(!is_dir($logDir)){
    mkdir($logDir, 0777,true);
}else{
    chmod($logDir, 0777); 
}
$logHandler= new CLogFileHandler(DISCUZ_ROOT."./source/plugin/tom_tongcheng/logs/".date("Y-m-d").".log");
$log = Log::Init($logHandler, 15);

class PayNotifyCallBack extends WxPayNotify{
    
	public function Queryorder($transaction_id){
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
        Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result) && array_key_exists("result_code", $result) && $result["return_code"] == "SUCCESS" && $result["result_code"] == "SUCCESS"){
			return true;
		}
		return false;
	}
	
	public function NotifyProcess($data, &$msg){
        global $_G;
        
        Log::DEBUG("call back:" . json_encode($data));
        
		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id", $data)){
            Log::DEBUG("error:can shu cuo wu");
            $msg = "can shu cuo wu";
			return false;
		}
		if(!$this->Queryorder($data["transaction_id"])){
            Log::DEBUG("error:ding dan cha xu shi bai");
            $msg = "ding dan cha xu shi bai";
			return false;
		}
        
        if(isset($data['result_code']) && $data['result_code']=='SUCCESS'){
        }else{
            Log::DEBUG("error:result_code error");
            $msg = "result_code error";
            return false;
        }
        
        if(isset($data['out_trade_no']) && !empty($data['out_trade_no'])){
        }else{
            Log::DEBUG("error:out_trade_no error");
            $msg = "out_trade_no error";
            return false;
        }
        
        $orderInfo = C::t('#tom_tongcheng#tom_tongcheng_order')->fetch_by_order_no($data['out_trade_no']);
        if($orderInfo && $orderInfo['order_status'] == 1){
            $updateData = array();
            $updateData['order_status'] = 2;
            $updateData['pay_time'] = TIMESTAMP;
            C::t('#tom_tongcheng#tom_tongcheng_order')->update($orderInfo['id'],$updateData);
            
            Log::DEBUG("update order:" . json_encode($orderInfo));
            
            $tcshopInfo = C::t('#tom_tcshop#tom_tcshop')->fetch_by_id($orderInfo['tcshop_id']);
            
            if($orderInfo['order_type'] == 4){
                
                $updateData = array();
                $updateData['status'] = 1;
                $updateData['pay_status'] = 2;
                if($tcshopInfo['vip_level'] == 1){
                    if($tcshopInfo['ruzhu_level'] == 3){
                        $updateData['vip_time'] = TIMESTAMP + 365*86400*2;
                    }else{
                        $updateData['vip_time'] = TIMESTAMP + 365*86400;
                    }
                }
                C::t('#tom_tcshop#tom_tcshop')->update($orderInfo['tcshop_id'],$updateData);
                
            }else if($orderInfo['order_type'] == 5){
                
                $toptime = TIMESTAMP;
                if($tcshopInfo['toptime'] > TIMESTAMP){
                    $toptime = $tcshopInfo['toptime'] + $orderInfo['time_value']*86400;
                }else{
                    $toptime = TIMESTAMP + $orderInfo['time_value']*86400;
                }
                $updateData = array();
                $updateData['topstatus'] = 1;
                $updateData['toptime'] = $toptime;
                C::t('#tom_tcshop#tom_tcshop')->update($tcshopInfo['id'],$updateData);
                
            }else if($orderInfo['order_type'] == 6){
                
                $updateData = array();
                $updateData['vip_level'] = 1;
                $updateData['vip_time']  = TIMESTAMP + 365*86400;
                C::t('#tom_tcshop#tom_tcshop')->update($tcshopInfo['id'],$updateData);
            }
            
            $tcshopConfig = $_G['cache']['plugin']['tom_tcshop'];
            $tongchengConfig = $_G['cache']['plugin']['tom_tongcheng'];
            if($tcshopConfig['open_back_score'] == 1){
                $userInfo = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($tcshopInfo['user_id']); 
                $updateData = array();
                $updateData['score'] = $userInfo['score'] + $orderInfo['pay_price']*$tongchengConfig['score_yuan'];
                C::t('#tom_tongcheng#tom_tongcheng_user')->update($userInfo['id'],$updateData);
                
                $insertData = array();
                $insertData['user_id']          = $tcshopInfo['user_id'];
                $insertData['score_value']      = $orderInfo['pay_price']*$tongchengConfig['score_yuan'];
                $insertData['old_value']        = $userInfo['score'];
                if($orderInfo['order_type'] == 4){
                    $insertData['log_type']         = 1;
                }else if($orderInfo['order_type'] == 5){
                    $insertData['log_type']         = 2;
                }else if($orderInfo['order_type'] == 6){
                    $insertData['log_type']         = 3;
                }
                $insertData['log_time']             = TIMESTAMP;
                C::t('#tom_tongcheng#tom_tongcheng_score_log')->insert($insertData);
                        
            }
            
            # fc start
            $tcadminfilename = DISCUZ_ROOT.'./source/plugin/tom_tcadmin/tom_tcadmin.inc.php';
            if(file_exists($tcadminfilename)){
                
                $sitesInfo = C::t('#tom_tongcheng#tom_tongcheng_sites')->fetch_by_id($orderInfo['site_id']);
                $tcadminConfig = $_G['cache']['plugin']['tom_tcadmin'];
                $fc_scale = $tcadminConfig['fc_scale'];
                if($sitesInfo['shop_fc_scale'] > 0){
                    $fc_scale = $sitesInfo['shop_fc_scale'];
                }
                $fc_money = $orderInfo['pay_price']*($fc_scale/100);
                $fc_money = number_format($fc_money,2);
                
                if($tcadminConfig['open_fc'] == 1){
                    
                    Log::DEBUG("update fc_money:" . $fc_money);
                    
                    $walletInfo = C::t('#tom_tcadmin#tom_tcadmin_wallet')->fetch_by_site_id($orderInfo['site_id']);
                
                    $old_money = 0;
                    if($walletInfo){
                        $old_money = $walletInfo['account_balance'];

                        $updateData = array();
                        $updateData['account_balance']   = $walletInfo['account_balance'] + $fc_money;
                        $updateData['total_income']   = $walletInfo['total_income'] + $fc_money;
                        C::t('#tom_tcadmin#tom_tcadmin_wallet')->update($walletInfo['id'],$updateData);
                    }else{
                        $insertData = array();
                        $insertData['site_id']              = $orderInfo['site_id'];
                        $insertData['account_balance']      = $fc_money;
                        $insertData['total_income']         = $fc_money;
                        $insertData['add_time']             = TIMESTAMP;
                        C::t('#tom_tcadmin#tom_tcadmin_wallet')->insert($insertData);
                    }

                    $insertData = array();
                    $insertData['site_id']      = $orderInfo['site_id'];
                    $insertData['log_type']     = 1;
                    $insertData['change_money'] = $fc_money;
                    $insertData['old_money']    = $old_money;
                    $insertData['beizu']        = $tcshopInfo['name'];
                    $insertData['order_no']     = $orderInfo['order_no'];
                    $insertData['order_type']   = $orderInfo['order_type'];
                    $insertData['log_ip']       = $_G['clientip'];
                    $insertData['log_time']     = TIMESTAMP;
                    C::t('#tom_tcadmin#tom_tcadmin_wallet_log')->insert($insertData);
                }
            }
            # fc end
            
        }
        
		return true;
	}
    
}

Log::DEBUG("begin notify3");
$notify = new PayNotifyCallBack();
$notify->Handle(false);

