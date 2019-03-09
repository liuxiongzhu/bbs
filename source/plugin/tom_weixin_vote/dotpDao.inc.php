<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
set_time_limit(0);
$tomSysOffset = getglobal('setting/timeoffset');

$page     = isset($_GET['page'])? intval($_GET['page']):1;
$vid = isset($_GET['vid'])? intval($_GET['vid']):0;
$item_id = isset($_GET['item_id'])? intval($_GET['item_id']):0;

$pagesize = 10000;
$start = ($page-1)*$pagesize;	

$voteInfo = C::t('#tom_weixin_vote#tom_weixin_vote')->fetch_by_id($vid);

if(isset($_G['uid']) && $_G['uid'] > 0 && $_G['groupid'] == 1){
    
    $logListTmp = C::t('#tom_weixin_vote#tom_weixin_vote_log')->fetch_all_list(" AND vote_id={$vid} AND item_id={$item_id} ","ORDER BY log_time DESC",$start,$pagesize);
    $logList = array();
    foreach ($logListTmp as $key => $value) {
        $userInfo = C::t('#tom_weixin_vote#tom_weixin_vote_user')->fetch_by_id($value['user_id']);
        $logList[$key]['xm'] = $userInfo['xm'];
        $logList[$key]['tel'] = $userInfo['tel'];
        $logList[$key]['ip'] = long2ip($value['part1']);
        $logList[$key]['log_time'] = dgmdate($value['log_time'],"Y-m-d H:i:s",$tomSysOffset);
    }
    
    $user_xm = lang('plugin/tom_weixin_vote','user_xm');
    $user_tel = lang('plugin/tom_weixin_vote','user_tel');
    $item_ip = 'IP';
    $log_time = lang('plugin/tom_weixin_vote','log_time');

    $listData[] = array($user_xm,$user_tel,$item_ip,$log_time); 
    $i = 1;
    foreach ($logList as $v){
        $lineData = array();
        $lineData[] = $v['xm'];
        $lineData[] = $v['tel'];
        $lineData[] = $v['ip'];
        $lineData[] = $v['log_time'];
        $listData[] = $lineData;
        $i++;
    }
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition:filename=exportVoteLog.xls");

    foreach ($listData as $fields){
        foreach ($fields as $k=> $v){
            $str = @diconv("$v",CHARSET,"GB2312");
            echo $str ."\t";
        }
        echo "\n";
    }
    exit;
}else{
    exit('Access Denied');
}

