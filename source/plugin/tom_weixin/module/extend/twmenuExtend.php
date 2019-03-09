<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

// Install
function moduleInstall(){
    global $_G,$moduleConfig;
    require_once libfile('function/plugin');
    
    $hookData = array();
    $hookData['hook_type'] = '9';
    $hookData['hook_script'] = './source/plugin/tom_weixin/module/hook/twmenuHook.php';
    $hookData['obj_id'] = 'twmenu';
    $hookData['obj_type'] = '1';
    C::t('#tom_weixin#tom_weixin_hook')->insert($hookData);
    
$sql = <<<EOF

DROP TABLE IF EXISTS `pre_tom_weixin_twmenu`;
CREATE TABLE `pre_tom_weixin_twmenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cmd` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `picurl` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `login` tinyint(4) DEFAULT '2',
  `paixu` int(11) DEFAULT NULL,
  `part1` varchar(255) DEFAULT NULL,
  `part2` varchar(255) DEFAULT NULL,
  `part3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

EOF;

    runquery($sql);
    
    return;
}

// Uninstall
function moduleUninstall(){
    global $_G,$moduleConfig;
    require_once libfile('function/plugin');
    
    C::t('#tom_weixin#tom_weixin_hook')->delete_by_obj_id_type("twmenu","1");
    
$sql = <<<EOF

DROP TABLE IF EXISTS pre_tom_weixin_twmenu;

EOF;

    runquery($sql);

    return;
}

// Upgrade
function moduleUpgrade(){
    global $_G,$moduleConfig,$moduleClass;
    require_once libfile('function/plugin');
    return;
}

?>
