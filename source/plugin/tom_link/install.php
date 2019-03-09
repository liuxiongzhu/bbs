<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$sql = <<<EOF

DROP TABLE IF EXISTS `pre_tom_link_rule`;
CREATE TABLE `pre_tom_link_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plugin_id` varchar(255) DEFAULT NULL,
  `rukou` varchar(255) DEFAULT NULL,
  `biaoshi` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `add_time` int(11) DEFAULT '0',
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;


EOF;

runquery($sql);

$finish = TRUE;
