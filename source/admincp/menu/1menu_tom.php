<?php

/*
 * TOMн╒пе
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$topmenu['tom'] = '';
$_G['lang']['admincp']['header_tom'] = diconv('TOMн╒пе', 'GBK', CHARSET);

loadcache('adminmenu');

if(is_array($_G['cache']['adminmenu'])) {
	foreach($_G['cache']['adminmenu'] as $thismenu) {
        
        if(strpos($thismenu['action'], 'plugins_config_') !== false) {
            $tompluginid = str_replace("plugins_config_", "", $thismenu['action']);
            $tompluginid = intval($tompluginid);
            $tomplugininfo = DB::fetch_first('SELECT * FROM %t WHERE pluginid=%d', array('common_plugin',$tompluginid));
            if($tomplugininfo && !empty($tomplugininfo['identifier'])){
                if($tomplugininfo['identifier'] == 'tom') {
                    $menu['tom'][] = array($thismenu['name'], $thismenu['action']);
                }
            }
        }
	}
}

if(is_array($_G['cache']['adminmenu'])) {
	foreach($_G['cache']['adminmenu'] as $thismenu) {
        
        if(strpos($thismenu['action'], 'plugins_config_') !== false) {
            $tompluginid = str_replace("plugins_config_", "", $thismenu['action']);
            $tompluginid = intval($tompluginid);
            $tomplugininfo = DB::fetch_first('SELECT * FROM %t WHERE pluginid=%d', array('common_plugin',$tompluginid));
            if($tomplugininfo && !empty($tomplugininfo['identifier'])){
                if(strpos($tomplugininfo['identifier'], 'tom_') !== false) {
                    $menu['tom'][] = array($thismenu['name'], $thismenu['action']);
                }
            }
        }
	}
}

?>