<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$resouListTmp = C::t('#tom_tcshop#tom_tcshop_resou')->fetch_all_list(""," ORDER BY paixu ASC,id DESC ",0,100);

$resouList = array();
if(is_array($resouListTmp) && !empty($resouListTmp)){
    foreach ($resouListTmp as $key => $value){
        $resouList[$key] = $value;
        $resouList[$key]['url'] = $_G['siteurl']."plugin.php?id=tom_tcshop&site={$site_id}&mod=list&keyword=".urlencode(trim($value['keywords']));
    }
}

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
include template("tom_tcshop:search");  




