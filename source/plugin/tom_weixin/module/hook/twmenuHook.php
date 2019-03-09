<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
} 

if(empty($outArr['type']) || empty($outArr['content'])){
    $twmenuList = C::t('#tom_weixin#tom_weixin_twmenu')->fetch_all_by_cmd($keyword,10);
    if(is_array($twmenuList) && !empty($twmenuList)){
        $outArr = array(
                'type'      => 'news',
                'content'   => '',
            );
        foreach ($twmenuList as $key => $value) {
            if(strpos($value['url'], "{openid}") !== false){
                $value['url'] = str_replace("{openid}", $openid, $value['url']);
            }else{
               if(strpos($value['url'], "?") !== false){
                   $value['url'] = $value['url']."&openid=".$openid;
                } 
            }
            if($value['login'] == 1){
                $value['url'] = wx_forum_login($openid, $value['url']);
            }

            $newsItem = array(
                'title' => $value['title'],
                'description' => $value['description'],
                'picUrl' => $value['picurl'],
                'url' => $value['url'],
            );
            $outArr['content'][] = $newsItem;
            $isDoHookContent = true;
            $exitHookScript = true;
        }
    }
}
?>
