<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once libfile('function/plugin');

if(isset($_G['uid']) && $_G['uid'] > 0 && $_G['groupid'] == 1){
    
    $sql = '';
    
    if (!empty($sql)) {
        runquery($sql);
    }
    
    $sql = <<<EOF
    CREATE TABLE IF NOT EXISTS `pre_tom_xiaofenlei_sites` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(255) DEFAULT NULL,
      `wxpay_appid` varchar(255) DEFAULT NULL,
      `wxpay_appsecret` varchar(255) DEFAULT NULL,
      `wxpay_mchid` varchar(255) DEFAULT NULL,
      `wxpay_key` varchar(255) DEFAULT NULL,
      `add_time` int(11) DEFAULT '0',
      `part1` varchar(255) DEFAULT NULL,
      `part2` varchar(255) DEFAULT NULL,
      `part3` int(11) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM;
EOF;

    runquery($sql);

    echo 'OK';exit;
    
}else{
    exit('Access Denied');
}