<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$sql = <<<EOF

DROP TABLE IF EXISTS pre_tom_tchongbao;
DROP TABLE IF EXISTS pre_tom_tchongbao_qiang_log;
DROP TABLE IF EXISTS pre_tom_tchongbao_district;
DROP TABLE IF EXISTS pre_tom_tchongbao_qunfa_log;
DROP TABLE IF EXISTS pre_tom_tchongbao_location;
        
EOF;

runquery($sql);

$finish = TRUE;

