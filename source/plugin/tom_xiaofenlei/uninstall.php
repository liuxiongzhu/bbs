<?php

/*
   This is NOT a freeware, use is subject to license terms
   ��Ȩ���У�TOM΢�� www.tomwx.net
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$sql = <<<EOF

DROP TABLE IF EXISTS pre_tom_xiaofenlei_user;
DROP TABLE IF EXISTS pre_tom_xiaofenlei_sites;

EOF;

runquery($sql);

$finish = TRUE;