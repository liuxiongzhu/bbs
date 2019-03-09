<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

// Install
function moduleInstall(){
    global $_G,$moduleConfig;
    require_once libfile('function/plugin');
    
    $hookData = array();
    $hookData['hook_type'] = '3';
    $hookData['hook_script'] = './source/plugin/tom_weixin/module/hook/helpHook.php';
    $hookData['obj_id'] = 'help';
    $hookData['obj_type'] = '1';
    C::t('#tom_weixin#tom_weixin_hook')->insert($hookData);

    return;
}

// Uninstall
function moduleUninstall(){
    global $_G,$moduleConfig;
    require_once libfile('function/plugin');
    
    C::t('#tom_weixin#tom_weixin_hook')->delete_by_obj_id_type("help","1");
    

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
