<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$Lang = $scriptlang['tom'];
require_once libfile('class/xml');

if($_GET['act'] == 'edit_script'){
    
	loadcache('pluginlanguage_script', 1);
	$langList = $_G['cache']['pluginlanguage_script'][$_GET['pluginid']];
    
    $pluginInfo = DB::fetch_first("SELECT * FROM ".DB::table('common_plugin')." WHERE identifier='".$_GET['pluginid']."'");
    
    showformheader('plugins&operation=config&do='.$pluginid.'&identifier=tom&pmod=language&act=save_script&pluginid='.$_GET['pluginid'],'enctype');
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['edit_script_lang'] .'>>'. $pluginInfo['name'].'</th></tr>';
    if(is_array($langList) && !empty($langList)){
        foreach ($langList as $key => $value){
            echo '<tr class="header"><th>'.$key.':</th><th></th></tr>';
            echo '<tr><td><textarea rows="6" name="langset['.$key.']" cols="30" class="tarea">'.$value.'</textarea></td><td></td></tr>';
        }
    }
    showsubmit('submit', 'submit');
    showtablefooter();
    showtableheader();
    echo '<tr><td  class="tipsblock" s="1"><ul id="tipslis">';
    echo '<li>' . $Lang['language_help_3'] . '</li>';
    echo '</ul></td></tr>';
    showtablefooter();
    showformfooter();
    
}else if($_GET['act'] == 'save_script'){
    if(submitcheck('submit')){
        
        $plugin_data = dhtmlspecialchars($_GET['langset']);
        
        $pluginInfo = DB::fetch_first("SELECT * FROM ".DB::table('common_plugin')." WHERE identifier='".$_GET['pluginid']."'");
        $dir = substr($pluginInfo['directory'], 0, -1);
		$modules = dunserialize($pluginInfo['modules']);
        
        loadcache('pluginlanguage_script', 1);
        $_G['cache']['pluginlanguage_script'][$_GET['pluginid']] = $plugin_data;
		savecache('pluginlanguage_script', $_G['cache']['pluginlanguage_script']);
        
		$xmlfile = DISCUZ_ROOT.'./source/plugin/'.$dir.'/discuz_plugin_'.$dir.($modules['extra']['installtype'] ? '_'.$modules['extra']['installtype'] : '').'.xml';
        if(file_exists($xmlfile)){
			$importtxt = @implode('', file($xmlfile));
			$data = $GLOBALS['importtxt'];
			$pluginxmldata = xml2array($data);
			$pluginxmldata['Data']['language']['scriptlang'] = $plugin_data;
			$handle = fopen($xmlfile,"w");
			if(!$handle){
					cpmsg($Lang['error301'], 'action=plugins&operation=config&do='.$pluginid.'&identifier=tom&pmod=language', 'error');
			}
			if(fwrite($handle,array2xml($pluginxmldata,1))){
			}else{
                cpmsg($Lang['error301'], 'action=plugins&operation=config&do='.$pluginid.'&identifier=tom&pmod=language', 'error');
            }
			fclose($handle);
		}
        updatecache(array('plugin'));
		cleartemplatecache();
        cpmsg($Lang['act_success'], 'action=plugins&operation=config&do='.$pluginid.'&identifier=tom&pmod=language', 'succeed');
        
    }
}else if($_GET['act'] == 'edit_template'){
    
    loadcache('pluginlanguage_template', 1);
	$langList = $_G['cache']['pluginlanguage_template'][$_GET['pluginid']];
    
    $pluginInfo = DB::fetch_first("SELECT * FROM ".DB::table('common_plugin')." WHERE identifier='".$_GET['pluginid']."'");
    
    showformheader('plugins&operation=config&do='.$pluginid.'&identifier=tom&pmod=language&act=save_template&pluginid='.$_GET['pluginid'],'enctype');
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['edit_template_lang']  .'>>'. $pluginInfo['name'].'</th></tr>';
    if(is_array($langList) && !empty($langList)){
        foreach ($langList as $key => $value){
            echo '<tr class="header"><th>'.$key.':</th><th></th></tr>';
            echo '<tr><td><textarea rows="6" name="langset['.$key.']" cols="30" class="tarea">'.$value.'</textarea></td><td></td></tr>';
        }
    }
    showsubmit('submit', 'submit');
    showtablefooter();
    showtableheader();
    echo '<tr><td  class="tipsblock" s="1"><ul id="tipslis">';
    echo '<li>' . $Lang['language_help_3'] . '</li>';
    echo '</ul></td></tr>';
    showtablefooter();
    showformfooter();
}else if($_GET['act'] == 'save_template'){
    if(submitcheck('submit')){
        
        $plugin_data = dhtmlspecialchars($_GET['langset']);
        
        $pluginInfo = DB::fetch_first("SELECT * FROM ".DB::table('common_plugin')." WHERE identifier='".$_GET['pluginid']."'");
        $dir = substr($pluginInfo['directory'], 0, -1);
		$modules = dunserialize($pluginInfo['modules']);
        
        loadcache('pluginlanguage_template', 1);
        $_G['cache']['pluginlanguage_template'][$_GET['pluginid']] = $plugin_data;
		savecache('pluginlanguage_template', $_G['cache']['pluginlanguage_template']);
        
		$xmlfile = DISCUZ_ROOT.'./source/plugin/'.$dir.'/discuz_plugin_'.$dir.($modules['extra']['installtype'] ? '_'.$modules['extra']['installtype'] : '').'.xml';
		if(file_exists($xmlfile)){
			$importtxt = @implode('', file($xmlfile));
			$data = $GLOBALS['importtxt'];
			$pluginxmldata = xml2array($data);
			$pluginxmldata['Data']['language']['templatelang'] = $plugin_data;
			$handle = fopen($xmlfile,"w");
			if(!$handle){
					cpmsg($Lang['error301'], 'action=plugins&operation=config&do='.$pluginid.'&identifier=tom&pmod=language', 'error');
			}
			if(fwrite($handle,array2xml($pluginxmldata,1))){
			}else{
                cpmsg($Lang['error301'], 'action=plugins&operation=config&do='.$pluginid.'&identifier=tom&pmod=language', 'error');
            }
			fclose($handle);
		}
        updatecache(array('plugin'));
		cleartemplatecache();
        cpmsg($Lang['act_success'], 'action=plugins&operation=config&do='.$pluginid.'&identifier=tom&pmod=language', 'succeed');
        
    }
}else{
    
    $pluginListTmp = DB::fetch_all('SELECT * FROM %t', array('common_plugin'),'identifier');
    $pluginList = array();
    if(is_array($pluginListTmp) && !empty($pluginListTmp)){
        foreach ($pluginListTmp as $key => $value){
            if(strpos($key, "tom_") !== false){
                $pluginList[$key] = $value;
            }
        }
    }
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['language_help_title'] . '</th></tr>';
    echo '<tr><td  class="tipsblock" s="1"><ul id="tipslis">';
    echo '<li>' . $Lang['language_help_1'] . '</li>';
    echo '<li>' . $Lang['language_help_2'] . '</li>';
    echo '<li>' . $Lang['language_help_3'] . '</li>';
    echo '<li>' . $Lang['language_help_4'] . '</li>';
    echo '</ul></td></tr>';
    showtablefooter();
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['plugin_list_title'] . '</th></tr>';
    echo '<tr class="header">';
    echo '<th>' . $Lang['name'] . '</th>';
    echo '<th>' . $Lang['directory'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    
    $i = 1;
    foreach ($pluginList as $key => $value) {
        echo '<tr>';
        echo '<td>' . $value['name'] . '</td>';
        echo '<td>' . $value['directory'] . '</td>';
        echo '<td>';
        echo '<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=tom&pmod=language&pluginid='.$value['identifier'].'&act=edit_script&formhash='.FORMHASH.'">' . $Lang['edit_script_lang']. '</a>&nbsp;|&nbsp;';
        echo '<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=tom&pmod=language&pluginid='.$value['identifier'].'&act=edit_template&formhash='.FORMHASH.'">' . $Lang['edit_template_lang']. '</a>';
        echo '</td>';
        echo '</tr>';
        $i++;
    }
    showtablefooter();
    
    
    
}

?>
