<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once libfile('function/plugin');

if(isset($_G['uid']) && $_G['uid'] > 0 && $_G['groupid'] == 1){
    
    $sql = '';

    $tom_tchehuoren_dengji_field = C::t('#tom_tchehuoren#tom_tchehuoren_dengji')->fetch_all_field();
    if (!isset($tom_tchehuoren_dengji_field['pt_fc_open'])) {
        $sql .= "ALTER TABLE `pre_tom_tchehuoren_dengji` ADD `pt_fc_open` int(11) DEFAULT '1';\n";
    }
    if (!isset($tom_tchehuoren_dengji_field['114_fc_open'])) {
        $sql .= "ALTER TABLE `pre_tom_tchehuoren_dengji` ADD `114_fc_open` int(11) DEFAULT '0';\n";
    }
    if (!isset($tom_tchehuoren_dengji_field['114_fc_scale'])) {
        $sql .= "ALTER TABLE `pre_tom_tchehuoren_dengji` ADD `114_fc_scale` int(11) DEFAULT '0';\n";
    }
    if (!isset($tom_tchehuoren_dengji_field['vip_fc_open'])) {
        $sql .= "ALTER TABLE `pre_tom_tchehuoren_dengji` ADD `vip_fc_open` int(11) DEFAULT '0';\n";
    }
    if (!isset($tom_tchehuoren_dengji_field['vip_fc_scale'])) {
        $sql .= "ALTER TABLE `pre_tom_tchehuoren_dengji` ADD `vip_fc_scale` int(11) DEFAULT '0';\n";
    }
    if (!isset($tom_tchehuoren_dengji_field['mall_fc_open'])) {
        $sql .= "ALTER TABLE `pre_tom_tchehuoren_dengji` ADD `mall_fc_open` int(11) DEFAULT '0';\n";
    }
    
    if (!empty($sql)) {
        runquery($sql);
    }
    
    $sql = <<<EOF
    CREATE TABLE IF NOT EXISTS `pre_tom_tchehuoren_yushouyi` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `order_no` varchar(255) DEFAULT NULL,
      `hehuoren_id` int(11) DEFAULT '0',
      `ly_user_id` int(11) DEFAULT '0',
      `child_hehuoren_id` int(11) DEFAULT '0',
      `today_time` int(11) DEFAULT '0',
      `week_time` int(11) DEFAULT '0',
      `month_time` int(11) DEFAULT '0',
      `type` varchar(255) DEFAULT NULL,
      `shouyi_price` decimal(10,2) DEFAULT '0.00',
      `content` text,
      `shouyi_status` tinyint(11) DEFAULT '0',
      `shouyi_time` int(11) DEFAULT '0',
      `status` int(11) DEFAULT '0',
      `add_time` int(11) DEFAULT '0',
      `part1` varchar(255) DEFAULT NULL,
      `part2` varchar(255) DEFAULT NULL,
      `part3` int(11) DEFAULT NULL,
      PRIMARY KEY (`id`),
      KEY `sy_order_no` (`order_no`)
    ) ENGINE=MyISAM;
EOF;

    runquery($sql);
    
    echo 'OK';exit;
    
}else{
    exit('Access Denied');
}



