<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function xiaoGetwxacodeunlimit($page,$scene,$width){
    global $_G;
    
    $r = array(
        'code' => 0,
        'src' => '',
    );
    
    $xiaofenleiConfig   = $_G['cache']['plugin']['tom_xiaofenlei'];
    $appid              = trim($xiaofenleiConfig['wxpay_appid']);  
    $appsecret          = trim($xiaofenleiConfig['wxpay_appsecret']);
    
    $postData  = '{"page":"'.$page.'","scene":"'.$scene.'","width":'.$width.'}';
    $imageDir  = "/source/plugin/tom_xiaofenlei/data/qrcode/".date("Ym")."/".date("d")."/";
    $imageName = "source/plugin/tom_xiaofenlei/data/qrcode/".date("Ym")."/".date("d")."/".md5($postData).".png";
    $imageImg  = DISCUZ_ROOT."./".$imageName;
    
    if(file_exists($imageImg)){
        $r = array(
            'code' => 0,
            'src' => $imageName,
        );
        return $r;
    }
    
    include DISCUZ_ROOT.'./source/plugin/tom_xiaofenlei/class/xiao.class.php';
    $xiaoClass = new xiaoClass($appid,$appsecret);
    $access_token = $xiaoClass->get_access_token();
    
    $getwxacode_url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token={$access_token}";
    $return = xiaoHttpPost($getwxacode_url, $postData);
    
    $content = json_decode($return,true);
    if(is_array($content) && !empty($content) && isset($content['errcode']) && !empty($content['errcode'])){
        
        $r = array(
            'code' => $content['errcode'],
            'msg'  => $content['errmsg'],
        );
        return $r;
        
    }else{
        
        $tomDir = DISCUZ_ROOT.'.'.$imageDir;
        if(!is_dir($tomDir)){
            mkdir($tomDir, 0777,true);
        }else{
            chmod($tomDir, 0777);
        }
        if(false !== file_put_contents(DISCUZ_ROOT.'./'.$imageName, $return)){
            $r = array(
                'code' => 0,
                'src' => $imageName,
            );
            return $r;
        }else{
            $r = array(
                'code' => 301,
            );
            return $r;
        }
    }
}