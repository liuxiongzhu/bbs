<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$moduleClass = new tom_module();
$helpInfo = $moduleClass->getOneByModuleId("help");
$helpSetting = array();
if(!empty($helpInfo['module_setting'])){
    $helpSetting = $moduleClass->decodeSetting($helpInfo['module_setting']);
}
if(isset($helpSetting['helpcontent']) && !empty($helpSetting['helpcontent'])){
    if(isset($helpSetting['is_type']) && $helpSetting['is_type'] == 1){
        $outArr['content'] = $outArr['content']."\n".$helpSetting['helpcontent'];
        $isDoHookContent = true;
        $exitHookScript = true;
    }else if(isset($helpSetting['is_type']) && $helpSetting['is_type'] == 2){
        $outArr['content'] = $helpSetting['helpcontent'];
        $isDoHookContent = true;
        $exitHookScript = true;
    }
}


?>
