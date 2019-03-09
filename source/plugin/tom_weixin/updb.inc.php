<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once libfile('function/plugin');

if(isset($_G['uid']) && $_G['uid'] > 0 && $_G['groupid'] == 1){
    
    
$sql = <<<EOF

CREATE TABLE IF NOT EXISTS `pre_tom_weixin_subuser` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `open_id` varchar(255) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `headimgurl` varchar(255) DEFAULT NULL,
  `sex` int(11) DEFAULT '0',
  `country` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `up_time` int(11) DEFAULT '0',
  `sub_time` int(11) DEFAULT NULL,
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

EOF;

    runquery($sql);

    $sql = '';

    $tom_weixin_subuser_field = C::t('#tom_weixin#tom_weixin_subuser')->fetch_all_field();
    if (!isset($tom_weixin_subuser_field['nickname'])) {
        $sql .= "ALTER TABLE ".DB::table('tom_weixin_subuser')." ADD `nickname` varchar(255) DEFAULT NULL;\n";
    }
    if (!isset($tom_weixin_subuser_field['headimgurl'])) {
        $sql .= "ALTER TABLE ".DB::table('tom_weixin_subuser')." ADD `headimgurl` varchar(255) DEFAULT NULL;\n";
    }
    if (!isset($tom_weixin_subuser_field['sex'])) {
        $sql .= "ALTER TABLE ".DB::table('tom_weixin_subuser')." ADD `sex` int(11) DEFAULT '0';\n";
    }
    if (!isset($tom_weixin_subuser_field['country'])) {
        $sql .= "ALTER TABLE ".DB::table('tom_weixin_subuser')." ADD `country` varchar(255) DEFAULT NULL;\n";
    }
    if (!isset($tom_weixin_subuser_field['province'])) {
        $sql .= "ALTER TABLE ".DB::table('tom_weixin_subuser')." ADD `province` varchar(255) DEFAULT NULL;\n";
    }
    if (!isset($tom_weixin_subuser_field['city'])) {
        $sql .= "ALTER TABLE ".DB::table('tom_weixin_subuser')." ADD `city` varchar(255) DEFAULT NULL;\n";
    }
    if (!isset($tom_weixin_subuser_field['up_time'])) {
        $sql .= "ALTER TABLE ".DB::table('tom_weixin_subuser')." ADD `up_time` int(11) DEFAULT '0';\n";
    }

    if (!empty($sql)) {
        runquery($sql);
    }

    echo 'OK';exit;
    
}else{
    exit('Access Denied');
}
