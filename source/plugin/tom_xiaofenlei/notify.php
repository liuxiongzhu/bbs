<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
   微信支付回调接口文件
*/

define('APPTYPEID', 127);
define('CURSCRIPT', 'plugin');
define('DISABLEXSSCHECK', true); 

$_GET['id'] = 'tom_xiaofenlei';

require substr(dirname(__FILE__), 0, -29).'/source/class/class_core.php';

$discuz = C::app();
$cachelist = array('plugin', 'diytemplatename');

$discuz->cachelist = $cachelist;
$discuz->init();

define('CURMODULE', 'tom_xiaofenlei');

$_G['siteurl'] = substr($_G['siteurl'], 0, -29);
$_G['siteroot'] = substr( $_G['siteroot'], 0, - 29);

$xiaofenleiConfig = $_G['cache']['plugin']['tom_xiaofenlei'];

$wxpay_appid        = trim($xiaofenleiConfig['wxpay_appid']);
$wxpay_mchid        = trim($xiaofenleiConfig['wxpay_mchid']);
$wxpay_key          = trim($xiaofenleiConfig['wxpay_key']);
$wxpay_appsecret    = trim($xiaofenleiConfig['wxpay_appsecret']);

define("TOM_WXPAY_APPID", $wxpay_appid);
define("TOM_WXPAY_MCHID", $wxpay_mchid);
define("TOM_WXPAY_KEY", $wxpay_key);
define("TOM_WXPAY_APPSECRET", $wxpay_appsecret);

include DISCUZ_ROOT.'./source/plugin/tom_xiaofenlei/class/wxpay/lib/WxPay.Api.php';
include DISCUZ_ROOT.'./source/plugin/tom_xiaofenlei/class/wxpay/lib/WxPay.Notify.php';
include DISCUZ_ROOT.'./source/plugin/tom_xiaofenlei/class/wxpay/log.php';

include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/class/function.core.php';

$logDir = DISCUZ_ROOT."./source/plugin/tom_xiaofenlei/logs/";
if(!is_dir($logDir)){
    mkdir($logDir, 0777,true);
}else{
    chmod($logDir, 0777); 
}
$logHandler= new CLogFileHandler(DISCUZ_ROOT."./source/plugin/tom_xiaofenlei/logs/".date("Y-m-d").".log");
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
            
            $tongchengInfo = C::t('#tom_tongcheng#tom_tongcheng')->fetch_by_id($orderInfo['tongcheng_id']);
            
            if($orderInfo['order_type'] == 1){
                
                $updateData = array();
                $updateData['status'] = 1;
                $updateData['pay_status'] = 2;
                $updateData['refresh_time'] = TIMESTAMP;
                C::t('#tom_tongcheng#tom_tongcheng')->update($orderInfo['tongcheng_id'],$updateData);
                
            }
            
        }
        
		return true;
	}
    
}

Log::DEBUG("begin notify3");
$notify = new PayNotifyCallBack();
$notify->Handle(false);

