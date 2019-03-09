<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$sql = <<<EOF

DROP TABLE IF EXISTS pre_tom_weixin_vote;
DROP TABLE IF EXISTS pre_tom_weixin_vote_cj;
DROP TABLE IF EXISTS pre_tom_weixin_vote_item;
DROP TABLE IF EXISTS pre_tom_weixin_vote_log;
DROP TABLE IF EXISTS pre_tom_weixin_vote_photo;
DROP TABLE IF EXISTS pre_tom_weixin_vote_user;

EOF;

runquery($sql);

$finish = TRUE;
