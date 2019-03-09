<?php
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


if($_GET['act'] == 'login'){
    
    $outArr = array(
        'code'  => 100,
        'msg'   => 'ERROR',
    );

    if('utf-8' != CHARSET) {
        if(defined('IN_MOBILE')){
        }else{
            foreach($_POST AS $pk => $pv) {
                if(!is_numeric($pv)) {
                    $_GET[$pk] = $_POST[$pk] = xiao_iconv_recurrence($pv);	
                }
            }
        }
    }

    $utoken         = !empty($_GET['utoken'])? addslashes($_GET['utoken']):'';
    $code           = !empty($_GET['code'])? addslashes($_GET['code']):'';
    $nickName       = !empty($_GET['nickName'])? addslashes($_GET['nickName']):'';
    $avatarUrl      = !empty($_GET['avatarUrl'])? addslashes($_GET['avatarUrl']):'';
    $gender         = !empty($_GET['gender'])? addslashes($_GET['gender']):'';
    $province       = !empty($_GET['province'])? addslashes($_GET['province']):'';
    $city           = !empty($_GET['city'])? addslashes($_GET['city']):'';
    $country        = !empty($_GET['country'])? addslashes($_GET['country']):'';
    $token          = !empty($_GET['token'])? addslashes($_GET['token']):'';
    $encryptedData  = !empty($_GET['encryptedData'])? addslashes($_GET['encryptedData']):'';
    $iv             = !empty($_GET['iv'])? addslashes($_GET['iv']):'';

    $openid = '';
    $unionid = '';
    $session_key = '';
    $getOpenidUrl = "https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$appsecret}&js_code={$code}&grant_type=authorization_code";
    $return = getHtml($getOpenidUrl);
    if(!empty($return)){
        $content = json_decode($return,true);
        if(is_array($content) && !empty($content) && isset($content['openid']) && !empty($content['openid'])){
            $openid = $content['openid'];
            $session_key = $content['session_key'];
        }
    }

    if(empty($openid)){
        $outArr = array(
            'code'  => 301,
            'msg'   => $content['errcode'].':'.$content['errmsg'],
        );
        echo tom_json_encode($outArr);exit;
    }
    
    include DISCUZ_ROOT.'./source/plugin/tom_xiaofenlei/class/wxBizDataCrypt.php';
    
    $pc         = new WXBizDataCrypt($appid, $session_key);
    $errCode    = $pc->decryptData($encryptedData, $iv, $data );
    if($errCode == 0) {
        $content2 = json_decode($data,true);
        if(is_array($content2) && !empty($content2) && isset($content2['unionId']) && !empty($content2['unionId'])){
            $unionid = $content2['unionId'];
        }
    }else{
        $outArr = array(
            'code'  => 302,
            'utoken'   => 'ERROR:'.$errCode,
        );
        echo tom_json_encode($outArr);exit;
    }

    $userInfo = C::t('#tom_xiaofenlei#tom_xiaofenlei_user')->fetch_by_openid($openid);
    if($userInfo){
        
        if(!empty($unionid) && empty($userInfo['unionid'])){
            $updateData               = array();
            $updateData['unionid']    = $unionid;
            C::t('#tom_xiaofenlei#tom_xiaofenlei_user')->update($userInfo['id'],$updateData);
        }
        
        $outArr = array(
            'code'  => 1,
            'utoken'   => $userInfo['utoken'],
        );
        echo tom_json_encode($outArr);exit;
    }else{
        
        $userId = 0;
        if(!empty($unionid)){
            $userInfoTmpUnionid = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_unionid($unionid);
            if($userInfoTmpUnionid && $userInfoTmpUnionid['id']){
                $userId = $userInfoTmpUnionid['id'];
            }
        }
        
        if($userId == 0){
            $insertData = array();
            $insertData['openid']      = 'XIAO';
            $insertData['unionid']     = $unionid;
            $insertData['nickname']    = $nickName;
            $insertData['picurl']      = $avatarUrl;
            $insertData['add_time']    = TIMESTAMP;
            if(C::t('#tom_tongcheng#tom_tongcheng_user')->insert($insertData)){
                $userId = C::t('#tom_tongcheng#tom_tongcheng_user')->insert_id();
            }
        }
        
        if($userId > 0){
            $insertData = array();
            $insertData['utoken']      = md5($openid);
            $insertData['user_id']     = $userId;
            $insertData['openid']      = $openid;
            $insertData['unionid']      = $unionid;
            $insertData['nickname']    = $nickName;
            $insertData['picurl']      = $avatarUrl;
            $insertData['add_time']    = TIMESTAMP;
            if(C::t('#tom_xiaofenlei#tom_xiaofenlei_user')->insert($insertData)){
                $userInfo = C::t('#tom_xiaofenlei#tom_xiaofenlei_user')->fetch_by_openid($openid);
                $outArr = array(
                    'code'  => 1,
                    'utoken'   => $userInfo['utoken'],
                );
                echo tom_json_encode($outArr);exit;
            }
        }
    }

    echo tom_json_encode($outArr);exit;
    
}else if($_GET['act'] == 'token'){
    
    $outArr = array(
        'code'  => 100,
        'msg'   => 'ERROR',
    );

    $utoken         = !empty($_GET['utoken'])? addslashes($_GET['utoken']):'';
    $code           = !empty($_GET['code'])? addslashes($_GET['code']):'';

    $openid = '';
    $getOpenidUrl = "https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$appsecret}&js_code={$code}&grant_type=authorization_code";
    $return = getHtml($getOpenidUrl);
    if(!empty($return)){
        $content = json_decode($return,true);
        if(is_array($content) && !empty($content) && isset($content['openid']) && !empty($content['openid'])){
            $openid = $content['openid'];
        }
    }

    if(empty($openid)){
        $outArr = array(
            'code'  => 301,
            'msg'   => $content['errcode'].':'.$content['errmsg'],
        );
        echo tom_json_encode($outArr);exit;
    }

    $userInfo = C::t('#tom_xiaofenlei#tom_xiaofenlei_user')->fetch_by_openid($openid);
    if($userInfo){
        $outArr = array(
            'code'  => 1,
            'utoken'   => $userInfo['utoken'],
        );
        echo tom_json_encode($outArr);exit;
    }else{
        $outArr = array(
            'code'  => 100,
            'msg'   => lang("plugin/tom_xiaofenlei", "login_token_error"),
        );
        echo tom_json_encode($outArr);exit;
    }

}else if($_GET['act'] == 'check_union'){
    $outArr = array(
        'code'  => 1,
        'msg'   => '',
        'data'  => array('showUnion' => 0),
    );
    
    $utoken         = !empty($_GET['utoken'])? addslashes($_GET['utoken']):'';
    
    $__XiaoUserInfo = C::t('#tom_xiaofenlei#tom_xiaofenlei_user')->fetch_by_utoken($utoken);
    
    if(!empty($__XiaoUserInfo['unionid'])){
        $userInfoTmpUnionid = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_unionid($__XiaoUserInfo['unionid']);
    
        if($userInfoTmpUnionid){
            if($userInfoTmpUnionid['id'] != $__XiaoUserInfo['user_id']){
                $outArr['data']['showUnion'] = 1;
            }
        }
    }
    
    echo tom_json_encode($outArr);exit;
    
}else if($_GET['act'] == 'union'){
    
    $outArr = array(
        'code'  => 1,
        'msg'   => '',
    );
    
    $utoken         = !empty($_GET['utoken'])? addslashes($_GET['utoken']):'';
    
    $__XiaoUserInfo = C::t('#tom_xiaofenlei#tom_xiaofenlei_user')->fetch_by_utoken($utoken);
    
    if(!empty($__XiaoUserInfo['unionid'])){
        $userInfoTmpUnionid = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_unionid($__XiaoUserInfo['unionid']);
    
        if($userInfoTmpUnionid){
            $updateData               = array();
            $updateData['user_id']    = $userInfoTmpUnionid['id'];
            C::t('#tom_xiaofenlei#tom_xiaofenlei_user')->update($__XiaoUserInfo['id'],$updateData);
        }
    }
    
    echo tom_json_encode($outArr);exit;
    
}else if($_GET['act'] == 'check_phone'){
    
    $outArr = array(
        'code'  => 1,
        'msg'   => '',
        'data'  => array('showPhoneBind' => 1),
    );
    
    $utoken         = !empty($_GET['utoken'])? addslashes($_GET['utoken']):'';
    
    $xiaoUserInfo = C::t('#tom_xiaofenlei#tom_xiaofenlei_user')->fetch_by_utoken($utoken);
    
    if(!empty($xiaoUserInfo['tel'])){
        $outArr['data']['showPhoneBind'] = 0;
        $outArr['data']['bindTel'] = substr($xiaoUserInfo['tel'], 0, 3)."****".substr($xiaoUserInfo['tel'], -4);
        echo tom_json_encode($outArr);exit;
    }else if($xiaoUserInfo && !empty($xiaoUserInfo['user_id'])){
        $userInfo = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($xiaoUserInfo['user_id']);
        if(!empty($userInfo['tel'])){
            $updateData           = array();
            $updateData['tel']    = $userInfo['tel'];
            C::t('#tom_xiaofenlei#tom_xiaofenlei_user')->update($xiaoUserInfo['id'],$updateData);
            $outArr['data']['showPhoneBind'] = 0;
            $outArr['data']['bindTel'] = substr($userInfo['tel'], 0, 3)."****".substr($userInfo['tel'], -4);
            echo tom_json_encode($outArr);exit;
        }
    }
    
    echo tom_json_encode($outArr);exit;
    
}else if($_GET['act'] == 'phone'){
    
    $outArr = array(
        'code'  => 100,
        'msg'   => 'ERROR',
    );

    $utoken         = !empty($_GET['utoken'])? addslashes($_GET['utoken']):'';
    $code           = !empty($_GET['code'])? addslashes($_GET['code']):'';
    $iv             = !empty($_GET['iv'])? addslashes($_GET['iv']):'';
    $encryptedData  = !empty($_GET['encryptedData'])? addslashes($_GET['encryptedData']):'';

    $openid = '';
    $session_key = '';
    $getOpenidUrl = "https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$appsecret}&js_code={$code}&grant_type=authorization_code";
    $return = getHtml($getOpenidUrl);
    if(!empty($return)){
        $content = json_decode($return,true);
        if(is_array($content) && !empty($content) && isset($content['openid']) && !empty($content['openid'])){
            $openid = $content['openid'];
            $session_key = $content['session_key'];
        }
    }

    if(empty($openid)){
        $outArr = array(
            'code'  => 301,
            'msg'   => $content['errcode'].':'.lang("plugin/tom_xiaofenlei", "get_phone_error_301"),
        );
        echo tom_json_encode($outArr);exit;
    }
    
    include DISCUZ_ROOT.'./source/plugin/tom_xiaofenlei/class/wxBizDataCrypt.php';

    $userInfo = C::t('#tom_xiaofenlei#tom_xiaofenlei_user')->fetch_by_openid($openid);
    if($userInfo){
        $pc = new WXBizDataCrypt($appid, $session_key);
        $errCode = $pc->decryptData($encryptedData, $iv, $data );
        if ($errCode == 0) {
            $content = json_decode($data,true);
            if(is_array($content) && !empty($content) && isset($content['phoneNumber']) && !empty($content['phoneNumber'])){
                $updateData           = array();
                $updateData['tel']    = $content['phoneNumber'];
                C::t('#tom_xiaofenlei#tom_xiaofenlei_user')->update($userInfo['id'],$updateData);
                
                $outArr = array(
                    'code'  => 1,
                );
                $outArr['data']['showPhoneBind'] = 0;
                $outArr['data']['bindTel'] = substr($updateData['tel'], 0, 3)."****".substr($updateData['tel'], -4);
                echo tom_json_encode($outArr);exit;
            }
        }else{
            $outArr = array(
                'code'  => 302,
                'utoken'   => lang("plugin/tom_xiaofenlei", "get_phone_error").$errCode,
            );
            echo tom_json_encode($outArr);exit;
        }
    }else{
        $outArr = array(
            'code'  => 100,
            'msg'   => lang("plugin/tom_xiaofenlei", "login_token_error"),
        );
        echo tom_json_encode($outArr);exit;
    }
}else{
    $outArr = array(
        'code'  => 0,
        'msg'   => 'no login act',
    );
    echo tom_json_encode($outArr);exit;
}


    

