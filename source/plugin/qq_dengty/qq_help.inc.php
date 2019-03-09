<?php


if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
showtips(lang('plugin/qq_dengty', 'qq_help'));

include_once template('qq_dengty:qq_help');
?>
