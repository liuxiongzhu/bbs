<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

set_time_limit(0);

loadcache('plugin');
if(!defined('DEBUG_MODE')) define('DEBUG_MODE', $_G['cache']['plugin']['dxc_api']['show_error']);
if(DEBUG_MODE){
	ini_set("display_errors", "On");
	error_reporting(E_ALL);
}

if($_GET['inajax']) ob_start();
ob_implicit_flush();
if($_GET['inajax']) ob_end_flush();
define('GBK', strtoupper(CHARSET) == 'GBK');
define('PLUGIN_DIR', DISCUZ_ROOT.'source/plugin/dxc_api');
define('PLUGIN_CACHE', PLUGIN_DIR.'/data/cache');
define('PLUGIN_ATTACH_CACHE_DIR', PLUGIN_DIR.'/data/attach_temp/');
define('PLUGIN_URL', $_G['siteurl'].'source/plugin/dxc_api/');
define('PLUGIN_PATH', DISCUZ_ROOT.'source/plugin/dxc_api');
define('WRAP', PHP_EOL);

loadcache('dxc_api');
if( (!$pluin_info = $_G['cache']['dxc_api'] ) || ( $_G['cache']['dxc_api']['version'] != $_G['setting']['plugins']['version']['dxc_api'] ) || $milu_seotool_config != $_G['cache']['dxc_api']['config']){
    $pluin_info = DB::fetch_first("SELECT * FROM ".DB::table('common_plugin')." WHERE identifier='dxc_api'");
    $pluin_info['config'] = $milu_seotool_config;
    save_syscache('dxc_api', $pluin_info);
}




define('PLUGIN_ID', $pluin_info['pluginid']);
define('PLUGIN_VERSION', $pluin_info['version']);//∞Ê±æ∫≈
define('PLUGIN_GO', 'action=plugins&operation=config&do='.PLUGIN_ID.'&identifier=dxc_api&pmod=');

define('PLUGIN_ENABLE_CACHE', FALSE);

if(!defined('DISCUZ_VERSION')) require_once(DISCUZ_ROOT.'/source/discuz_version.php');
require_once(PLUGIN_DIR.'/lib/function.global.php');
require_once(PLUGIN_DIR.'/lib/dxcShowHelper.class.php');


$field_tpl_forum = array(

	'title' => array(
		'key' => 'title',
		'name' => stlang('title'),
	),
	'content' => array(
		'key' => 'content',
		'name' => stlang('content'),
	),

	'thumb' => array(
		'key' => 'thumb',
		'name' => stlang('thumb'),
	),

	'public_username' => array(
		'key' => 'public_username',
		'name' => stlang('public_username'),
	),
	'public_avatar' => array(
		'key' => 'public_avatar',
		'name' => stlang('public_avatar'),
	),
	'public_dateline' => array(
		'key' => 'public_dateline',
		'name' => stlang('public_dateline'),
	),
	'reply' => array(
		'key' => 'reply',
		'name' => stlang('reply'),
	),
	'reply_username' => array(
		'key' => 'reply_username',
		'name' => stlang('reply_username'),
	),
	'reply_avatar' => array(
		'key' => 'reply_avatar',
		'name' => stlang('reply_avatar'),
	),
	'reply_dateline' => array(
		'key' => 'reply_dateline',
		'name' => stlang('reply_dateline_field'),
	),


);



$field_tpl_portal = array(

	'title' => array(
		'key' => 'title',
		'name' => stlang('title'),
	),
	'content' => array(
		'key' => 'content',
		'name' => stlang('content'),
	),

	'thumb' => array(
		'key' => 'thumb',
		'name' => stlang('thumb'),
	),

	'dateline' => array(
		'key' => 'dateline',
		'name' => stlang('public_dateline'),
	),

	'from' => array(
		'key' => 'from',
		'name' => stlang('article_from'),
	),

	'fromurl' => array(
		'key' => 'fromurl',
		'name' => stlang('fromurl'),
	),



	'author' => array(
		'key' => 'author',
		'name' => stlang('ori_author'),
	),

	'thumb' => array(
		'key' => 'thumb',
		'name' => stlang('thumb'),
	),

);







?>