<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

session_start();
define('TPL_DEFAULT', true);
$voteConfig = $_G['cache']['plugin']['tom_weixin_vote'];
$tomSysOffset = getglobal('setting/timeoffset');

if (CHARSET == 'gbk') {
    include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/config/config.gbk.php';
}else{
    include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/config/config.utf8.php';
}

if($_GET['mod'] == 'index'){
    include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/pc/index.inc.php';
    
}else if($_GET['mod'] == 'weixin'){
    include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/pc/weixin.inc.php';
    
}else{
    include DISCUZ_ROOT.'./source/plugin/tom_weixin_vote/pc/index.inc.php';
}

