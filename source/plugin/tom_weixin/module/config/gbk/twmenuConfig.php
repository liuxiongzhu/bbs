<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$moduleConfig = array(
    'module_cmd'       => "twmenu",
    'module_desc'      => "多功能图文菜单",
	'power_id'         => '0',
	'module_ver'       => '2.0',
    'admin'            => '1',
    'admin_name'       => '添加图文菜单',
    'is_menu'          => '1',
);

$moduleLang = array(
    'twmenu_help_title' => '图文菜单设置帮助',
    'twmenu_help_1'     => "1、<b>多功能图文菜单特点：支持多指令、多图文</b>",
    'twmenu_help_2'     => "2、图文菜单，第一条图片地址需要为大图；每一条图文菜单指令对应图文列表最多显示8条内容",
    'twmenu_help_3'     => '3、',
    'twmeun_search_title'=> '指令列表搜索',
    'twmeun_search_cmd' => '搜索指令：',
    'twmenu_list_title' => '图文菜单列表',
    'twmenu_list'       => '图文菜单列表管理',
    'twmenu_list_back'  => '<<< 返回列表管理',
    'twmenu_add'        => '添加图文菜单链接',
    'twmenu_edit'       => '编辑',
    'cmd'               => '菜单指令',
    'cmd_msg'           => '关联的菜单指令，可以填写多个，如:菜单指令1|菜单指令2|菜单指令3 （多个用“|”隔开，最多5个）',
    'title'             => '标题',
    'title_msg'         => '标题必须填写',
    'description'       => '描述',
    'description_msg'   => '菜单描述，当指令只有一条图文链接时必须填写',
    'picurl'            => '图片地址',
    'picurl_msg'        => '图文菜单第一条，图片需要为大图',
    'url'               => '链接',
    'url_msg'           => '链接里面不能包含：<font color="#FF0000">%</font>',
    'login'             => '自动登录',
    'login_ok'          => '是',
    'login_no'          => '否',
    'login_msg'         => '历史功能已经不用',
    'paixu'             => '排序',
    
);

$moduleSettingExt = array(
);

?>