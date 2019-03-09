<?php

/*
   This is NOT a freeware, use is subject to license terms
   ��Ȩ���У�TOM΢�� www.tomwx.cn
   �ļ�˵�������ļ���TOM΢�Ų���Զ�����ڵ��ô����ļ�
*/

if(!defined('IN_TOM_LINK')) {
	exit('Access Denied Link');
}

include substr(dirname(__FILE__), 0, -22)."source/plugin/tom_link/config/map.php";
include substr(dirname(__FILE__), 0, -22)."source/plugin/tom_link/data/map.php";

if(!empty($_GET['id'])){
	if(strpos($_GET['id'],":") !== false){
		list($tom_link_identifier, $tom_link_module) = explode(':', $_GET['id']);
		$tom_link_identifier = trim($tom_link_identifier);
	}else{
		$tom_link_identifier = trim($_GET['id']);
	}
	if(isset($tom_link_map[$tom_link_identifier])) {
		$_GET['id'] = str_replace($tom_link_identifier, $tom_link_map[$tom_link_identifier], $_GET['id']);
        define('TOM_LINK_BIAOSHI', $tom_link_map[$tom_link_identifier]);
	}else{
        $tom_link_suffix = substr($tom_link_identifier, -2);
        if(isset($tom_link_config_mapArray[$tom_link_suffix]) && !empty($tom_link_config_mapArray[$tom_link_suffix])){
            $_GET['id'] = str_replace($tom_link_identifier, $tom_link_config_mapArray[$tom_link_suffix], $_GET['id']);
            define('TOM_LINK_BIAOSHI', $tom_link_config_mapArray[$tom_link_suffix]);
        }
    }
}

?>