<?php

/*
   This is NOT a freeware, use is subject to license terms
   ��Ȩ���У�TOM΢�� www.tomwx.cn
   �ƴ���״̬���ýű�
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once libfile('function/plugin');

if(isset($_G['uid']) && $_G['uid'] > 0 && $_G['groupid'] == 1){
    
    DB::query("UPDATE ".DB::table('tom_tcshop_photo')." SET qiniu_status=0,oss_status=0 WHERE qiniu_status=1 OR oss_status=1 ", 'UNBUFFERED');

    echo 'oss reset OK';exit;
    
}else{
    exit('Access Denied');
}