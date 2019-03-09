<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$moduleConfig = array(
    'module_cmd'       => "help",
    'module_desc'      => "help指令菜单自定义",
	'power_id'         => '0',
	'module_ver'       => '1.0',
    'is_menu'          => '2',
);

$moduleLang = array();

$moduleSettingExt = array(
    array(
        'type'   => 'radio',
        'title'  => '指令菜单修改方式',
        'name'   => 'is_type',
        'value'  => '1',
        'desc'   => '选择自定义指令内容修改方式',
        'item'   => array(
            '1' => "追加",
            '2' => "替换",
        ),
    ),
    array(
        'type'   => 'textarea',
        'title'  => '指令菜单',
        'name'   => 'helpcontent',
        'value'  => "指令1：指令1描述\n指令2：指令2描述\n",
        'desc'   => '自定义help主菜单',
        'rows'   => 10,
        'cols'   => 25,
    ),
);

?>