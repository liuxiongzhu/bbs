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


if($_GET['act'] == 'get'){
    
    $outArr = array(
        'code'  => 100,
        'title'   => '',
    );
    
    $link = isset($_GET['link'])? daddslashes(diconv($_GET['link'],'utf-8')):'';
    if(strpos($link, "&") !== FALSE ){
        $link.= "&miniprogram_get_title=1";
    }
    $content = get_html($link);
    
    if($content){
        preg_match('#<title>([^<]*)</title>#', $content, $matches);
        if(is_array($matches) && isset($matches['1']) && !empty($matches['1'])){
            $outArr = array(
                'code'  => 1,
                'title'   => $matches['1']
            );
        }
    }
    
    echo tom_json_encode($outArr);exit;

}else{
    $outArr = array(
        'code'  => 0,
    );
    echo tom_json_encode($outArr);exit;
}


function get_html($url){
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