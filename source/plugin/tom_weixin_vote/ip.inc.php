<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

define('TPL_DEFAULT', true);
$voteConfig = $_G['cache']['plugin']['tom_weixin_vote'];
$tomSysOffset = getglobal('setting/timeoffset');

$vid      = isset($_GET['vid'])? intval($_GET['vid']):0;

$ipStr = ip2long($_GET['ip']);
$ips = C::t('#tom_weixin_vote#tom_weixin_vote_log')->fetch_all_list(" AND vote_id=$vid AND part1='$ipStr' ",'',0,1000);

echo 'start<br/>';
foreach ($ips as $key => $value){
    $userInfo = C::t('#tom_weixin_vote#tom_weixin_vote_user')->fetch_by_id($value['user_id']);
    echo long2ip($value['part1']).'---------'.$userInfo['xm'].'-----'.dgmdate($value['log_time'],"Y-m-d H:i:s",$tomSysOffset).'<br/>';
}
echo 'end<br/>';

