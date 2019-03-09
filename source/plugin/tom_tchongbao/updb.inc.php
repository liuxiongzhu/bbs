<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once libfile('function/plugin');

if(isset($_G['uid']) && $_G['uid'] > 0 && $_G['groupid'] == 1){
    
    $sql = <<<EOF
    CREATE TABLE IF NOT EXISTS `pre_tom_tchongbao_district` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `district_id` int(11) unsigned DEFAULT '0',
        `latitude` varchar(255) DEFAULT NULL,
        `longitude` varchar(255) DEFAULT NULL,
        `max_distance_km` int(11) DEFAULT '0',
        `is_show` tinyint(4) DEFAULT '0',
        `add_time` int(11) DEFAULT '0',
        `part1` varchar(255) DEFAULT NULL,
        `part2` varchar(255) DEFAULT NULL,
        `part3` int(11) DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=MyISAM;
     CREATE TABLE IF NOT EXISTS `pre_tom_tchongbao_qunfa_log` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `hongbao_id` int(11) DEFAULT '0',
        `user_id` int(11) DEFAULT '0',
        `log_time` int(11) DEFAULT '0',
        `part1` varchar(255) DEFAULT NULL,
        `part2` varchar(255) DEFAULT NULL,
        `part3` int(11) DEFAULT NULL,
        PRIMARY KEY (`id`),
        KEY `idx_hb_id` (`hongbao_id`),
        KEY `idex_user_id` (`user_id`)
    ) ENGINE=MyISAM;
     CREATE TABLE IF NOT EXISTS `pre_tom_tchongbao_location` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) unsigned DEFAULT '0',
        `location_status` tinyint(4) DEFAULT '0',
        `last_time` int(11) DEFAULT '0',
        `add_time` int(11) DEFAULT '0',
        `part1` varchar(255) DEFAULT NULL,
        `part2` varchar(255) DEFAULT NULL,
        `part3` int(11) DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=MyISAM;
EOF;
    
    runquery($sql);
    
    $sql = '';

    $tom_tchongbao_field = C::t('#tom_tchongbao#tom_tchongbao')->fetch_all_field();
    if (!isset($tom_tchongbao_field['tcshop_id'])) {
        $sql .= "ALTER TABLE `pre_tom_tchongbao` ADD `tcshop_id` int(11) DEFAULT '0';\n";
    }
    
    if (!empty($sql)) {
        runquery($sql);
    }
    
    echo 'OK';exit;
    
}else{
    exit('Access Denied');
}



