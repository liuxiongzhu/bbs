<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$modBaseUrl = $adminBaseUrl.'&tmod=log&vote_id='.$_GET['vote_id'].'&item_id='.$_GET['item_id']; 
$modListUrl = $adminListUrl.'&tmod=log&vote_id='.$_GET['vote_id'].'&item_id='.$_GET['item_id']; 
$modFromUrl = $adminFromUrl.'&tmod=log&vote_id='.$_GET['vote_id'].'&item_id='.$_GET['item_id']; 

if($_GET['act'] == 'add'){
}else{
    $vote_id = $_GET['vote_id'];
    $item_id = $_GET['item_id'];
    $voteInfo = C::t('#tom_weixin_vote#tom_weixin_vote')->fetch_by_id($_GET['vote_id']);
    $pagesize = 50;
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $start = ($page-1)*$pagesize;	
    $count = C::t('#tom_weixin_vote#tom_weixin_vote_log')->fetch_all_count(" AND vote_id={$vote_id} AND item_id={$item_id} ");
    $logList = C::t('#tom_weixin_vote#tom_weixin_vote_log')->fetch_all_list(" AND vote_id={$vote_id} AND item_id={$item_id} ","ORDER BY log_time DESC",$start,$pagesize);
    __create_nav_html();
    showtableheader();
    echo '<tr><th colspan="15">';
    echo '&nbsp;&nbsp;<a class="addtr" target="_blank" href="'.$_G['siteurl'].'plugin.php?id=tom_weixin_vote:dotpDao&vid='.$vote_id.'&item_id='.$item_id.'">' . $Lang['daochu_tp'] . '(0-10000)</a>';
    if($count > 10000){
        echo '&nbsp;&nbsp;<a class="addtr" target="_blank" href="'.$_G['siteurl'].'plugin.php?id=tom_weixin_vote:dotpDao&vid='.$vote_id.'&item_id='.$item_id.'&page=2">' . $Lang['daochu_tp'] . '(10000-20000)</a>';
    }
    if($count > 20000){
        echo '&nbsp;&nbsp;<a class="addtr" target="_blank" href="'.$_G['siteurl'].'plugin.php?id=tom_weixin_vote:dotpDao&vid='.$vote_id.'&item_id='.$item_id.'&page=3">' . $Lang['daochu_tp'] . '(20000-30000)</a>';
    }
    if($count > 30000){
        echo '&nbsp;&nbsp;<a class="addtr" target="_blank" href="'.$_G['siteurl'].'plugin.php?id=tom_weixin_vote:dotpDao&vid='.$vote_id.'&item_id='.$item_id.'&page=4">' . $Lang['daochu_tp'] . '(30000-40000)</a>';
    }
    if($count > 40000){
        echo '&nbsp;&nbsp;<a class="addtr" target="_blank" href="'.$_G['siteurl'].'plugin.php?id=tom_weixin_vote:dotpDao&vid='.$vote_id.'&item_id='.$item_id.'&page=5">' . $Lang['daochu_tp'] . '(40000-50000)</a>';
    }
    echo '</th></tr>';
    echo '<tr class="header">';
    echo '<th>' . $Lang['user_xm'] . '</th>';
    echo '<th>' . $Lang['user_tel'] . '</th>';
    echo '<th>IP</th>';
    echo '<th>' . $Lang['log_time'] . '</th>';
    echo '</tr>';
    
    $i = 1;
    foreach ($logList as $key => $value) {
        $userInfo = C::t('#tom_weixin_vote#tom_weixin_vote_user')->fetch_by_id($value['user_id']);
        echo '<tr>';
        echo '<td>' . $userInfo['xm'] . '</td>';
        echo '<td>' . $userInfo['tel'] . '</td>';
        echo '<td>' . long2ip($value['part1']) . '</td>';
        echo '<td>' . dgmdate($value['log_time'],"Y-m-d H:i:s",$tomSysOffset) . '</td>';
        echo '</tr>';
        $i++;
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBaseUrl);	
    showsubmit('', '', '', '', $multi, false);
}

function __create_nav_html($infoArr = array()){
    global $Lang,$modBaseUrl,$adminBaseUrl;
    tomshownavheader();
    if($_GET['act'] == 'add'){
    }else{
        tomshownavli($Lang['user_list_title'],$modBaseUrl,true);
    }
    tomshownavfooter();
}

