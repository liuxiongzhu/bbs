<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$sql = <<<EOF

DROP TABLE IF EXISTS pre_tom_tchehuoren;
DROP TABLE IF EXISTS pre_tom_tchehuoren_common_problem;
DROP TABLE IF EXISTS pre_tom_tchehuoren_dengji;
DROP TABLE IF EXISTS pre_tom_tchehuoren_dengji_shenqing;
DROP TABLE IF EXISTS pre_tom_tchehuoren_kaohe_log;
DROP TABLE IF EXISTS pre_tom_tchehuoren_shenqing;
DROP TABLE IF EXISTS pre_tom_tchehuoren_shouyi;
DROP TABLE IF EXISTS pre_tom_tchehuoren_tz;
DROP TABLE IF EXISTS pre_tom_tchehuoren_tz_log;
DROP TABLE IF EXISTS pre_tom_tchehuoren_yushouyi;

EOF;

runquery($sql);

$finish = TRUE;

