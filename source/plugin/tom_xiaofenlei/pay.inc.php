<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$site_id = intval($_GET['site'])>0? intval($_GET['site']):1;

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
include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/class/function.core.php';
include DISCUZ_ROOT.'./source/plugin/tom_xiaofenlei/class/function.core.php';
$act = isset($_GET['act'])? addslashes($_GET['act']):"pay";

$utoken         = !empty($_GET['utoken'])? addslashes($_GET['utoken']):'';

$__XiaoUserInfo = C::t('#tom_xiaofenlei#tom_xiaofenlei_user')->fetch_by_utoken($utoken);
if($__XiaoUserInfo){
    $__UserInfo = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($__XiaoUserInfo['user_id']); 
}else{
    $outArr = array(
        'code'  => 2,
    );
    echo tom_json_encode($outArr);exit;
}

if($act == "pay"){
    
    $outArr = array(
        'code'  => 1,
        'msg'   => '',
        'data'  => array(),
    );
    
    $tongcheng_id   = isset($_GET['tongcheng_id'])? intval($_GET['tongcheng_id']):0;
    
    $tongchengInfo = C::t('#tom_tongcheng#tom_tongcheng')->fetch_by_id($tongcheng_id);
    $userInfo = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($tongchengInfo['user_id']); 
    $typeInfo = C::t('#tom_tongcheng#tom_tongcheng_model_type')->fetch_by_id($tongchengInfo['type_id']);
    
    if($tongchengInfo['pay_status'] == 2){
        $outArr = array(
            'code'  => 1,
            'data'  => 1,
        );
        echo tom_json_encode($outArr);exit;
    }
    
    $orderListTmp = C::t('#tom_tongcheng#tom_tongcheng_order')->fetch_all_list(" AND tongcheng_id={$tongcheng_id} AND user_id={$userInfo['id']} AND order_type=1 AND order_status=1 ","ORDER BY id DESC",0,10);
    if(is_array($orderListTmp) && !empty($orderListTmp)){
        foreach ($orderListTmp as $key => $value){
            $updateData = array();
            $updateData['order_status'] = 3;
            C::t('#tom_tongcheng#tom_tongcheng_order')->update($value['id'],$updateData);
        }
    }
    
    if($typeInfo['free_status'] == 2 && $typeInfo['fabu_price'] > 0){
            
        $order_no = "TC".date("YmdHis")."-".mt_rand(111111, 666666);
        $order_name = lang('plugin/tom_tongcheng','order_type_1');
        $order_name = diconv($order_name,CHARSET,'utf-8');
        $notifyUrl = $_G['siteurl']."source/plugin/tom_xiaofenlei/notify.php";
        $order_price = $typeInfo['fabu_price']*100;
        $openid = $__XiaoUserInfo['openid'];

        $orderInput = new WxPayUnifiedOrder();
        $orderInput->SetBody($order_name);		
        $orderInput->SetAttach("tom_tongcheng");		
        $orderInput->SetOut_trade_no($order_no);	
        $orderInput->SetTotal_fee($order_price);	
        $orderInput->SetGoods_tag("null");	
        $orderInput->SetNotify_url($notifyUrl);	
        $orderInput->SetTrade_type("JSAPI");
        $orderInput->SetOpenid($openid);
        $orderInfo = WxPayApi::unifiedOrder($orderInput,300);

        if(is_array($orderInfo) && $orderInfo['result_code']=='SUCCESS' && $orderInfo['return_code']=='SUCCESS'){

            $insertData = array();
            $insertData['site_id']          = $tongchengInfo['site_id'];
            $insertData['order_no']         = $order_no;
            $insertData['order_type']       = 1;
            $insertData['user_id']          = $userInfo['id'];
            $insertData['openid']           = $userInfo['openid'];
            $insertData['tongcheng_id']     = $tongcheng_id;
            $insertData['pay_price']        = $typeInfo['fabu_price'];
            $insertData['order_status']     = 1;
            $insertData['order_time']       = TIMESTAMP;
            if(C::t('#tom_tongcheng#tom_tongcheng_order')->insert($insertData)){
                $order_id = C::t('#tom_tongcheng#tom_tongcheng_order')->insert_id();

                $jsapi = new WxPayJsApiPay();
                $jsapi->SetAppid($orderInfo["appid"]);
                $timeStamp = time();
                $timeStamp = "$timeStamp";
                $jsapi->SetTimeStamp($timeStamp);
                $jsapi->SetNonceStr(WxPayApi::getNonceStr());
                $jsapi->SetPackage("prepay_id=" . $orderInfo['prepay_id']);
                $jsapi->SetSignType("MD5");
                $jsapi->SetPaySign($jsapi->MakeSign());
                $parameters = $jsapi->GetValues();

                $outArr = array(
                    'code'  => 1,
                    'data' => $parameters,
                );
                echo tom_json_encode($outArr);exit;
            }else{
                $outArr = array(
                    'code'  => 301,
                    'msg'   => lang("plugin/tom_xiaofenlei", "pay_error301"),
                );
                echo tom_json_encode($outArr);exit;
            }

        }else{
            $outArr = array(
                'code'  => 500,
                'msg'   => lang("plugin/tom_xiaofenlei", "pay_error500"),
            );
            echo tom_json_encode($outArr);exit;
        }
    }else{
        $outArr = array(
            'code'  => 400,
            'msg'   => lang("plugin/tom_xiaofenlei", "pay_error400"),
        );
        echo tom_json_encode($outArr);exit;
    }
    
}else{
    $outArr = array(
        'code'  => 0,
        'msg'   => 'no act',
    );
    echo tom_json_encode($outArr);exit;
}


    

