<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$moduleConfig = array(
    'module_cmd'       => "help",
    'module_desc'      => "helpָ��˵��Զ���",
	'power_id'         => '0',
	'module_ver'       => '1.0',
    'is_menu'          => '2',
);

$moduleLang = array();

$moduleSettingExt = array(
    array(
        'type'   => 'radio',
        'title'  => 'ָ��˵��޸ķ�ʽ',
        'name'   => 'is_type',
        'value'  => '1',
        'desc'   => 'ѡ���Զ���ָ�������޸ķ�ʽ',
        'item'   => array(
            '1' => "׷��",
            '2' => "�滻",
        ),
    ),
    array(
        'type'   => 'textarea',
        'title'  => 'ָ��˵�',
        'name'   => 'helpcontent',
        'value'  => "ָ��1��ָ��1����\nָ��2��ָ��2����\n",
        'desc'   => '�Զ���help���˵�',
        'rows'   => 10,
        'cols'   => 25,
    ),
);

?>