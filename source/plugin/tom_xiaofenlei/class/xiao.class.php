<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class xiaoClass{
    
    private $appId;
    private $appSecret;
    private $accessTokenCachename;

    public function __construct($appId, $appSecret) {
        
        $this->appId = trim($appId);
        $this->appSecret = trim($appSecret);
        $key = md5($this->appId."-".$this->appSecret);
        $this->accessTokenCachename = 'tom_weixin_access_token_'.$key;
    }
    
    public function get_url(){
        global $_G;
        
        $protocol = "http://";
        if(strpos($_G['siteurl'], 'https:') !== FALSE){
            $protocol = "https://";
        }
        
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        
        return $url;
    }


    public function get_access_token(){
        $appid = $this->appId;
        $appsecret = $this->appSecret;
        $cachename = $this->accessTokenCachename;

        $access_token = '';
        $cache_time = 0;

        require_once libfile('function/cache');

        @include(DISCUZ_ROOT.'./data/sysdata/cache_'.$cachename.'.php');
        if(!file_exists(DISCUZ_ROOT.'./data/sysdata/cache_'.$cachename.'.php') || ($cache_time + 600 < TIMESTAMP)){
            $get_access_token_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
            $return = xiaoGetHtml($get_access_token_url);
            if(!empty($return)){
                $content = json_decode($return,true);
                if(is_array($content) && !empty($content) && isset($content['access_token']) && !empty($content['access_token'])){
                    $access_token = $content['access_token'];
                }
            }

            $cachedata = "\$access_token='".$access_token."';\n\$cache_time='".TIMESTAMP."';\n";
            writetocache($cachename, $cachedata);
            @include(DISCUZ_ROOT.'./data/sysdata/cache_'.$cachename.'.php');
        }
        return $access_token;

    }
    
}


function xiaoGetHtml($url){
    if(function_exists('curl_init')){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $return = curl_exec($ch);
        curl_close($ch); 
        return $return;
    }
    return false;
}

function xiaoHttpPost($url,$data){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");  
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);  

    $return = curl_exec($curl);  
    curl_close($curl);  
    return $return; 
}  
