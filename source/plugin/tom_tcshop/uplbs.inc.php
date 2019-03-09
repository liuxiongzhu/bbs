<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
   百度LBS云重置脚本
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once libfile('function/plugin');

if(isset($_G['uid']) && $_G['uid'] > 0 && $_G['groupid'] == 1){
    
    DB::query("UPDATE ".DB::table('tom_tcshop')." SET lbs_status=0,lbs_id=0 WHERE lbs_status=1 ", 'UNBUFFERED');
    
    // 删除生成的配置缓存
    $LbsDataCache = DISCUZ_ROOT."./source/plugin/tom_tcshop/config/baidulbs.php";
    
    @unlink($LbsDataCache);

    echo 'lbs reset OK';exit;
    
}else{
    exit('Access Denied');
}