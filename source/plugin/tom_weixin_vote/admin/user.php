<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$modBaseUrl = $adminBaseUrl.'&tmod=user&vote_id='.$_GET['vote_id']; 
$modListUrl = $adminListUrl.'&tmod=user&vote_id='.$_GET['vote_id'];
$modFromUrl = $adminFromUrl.'&tmod=user&vote_id='.$_GET['vote_id'];

if($_GET['act'] == 'add'){
}else{
    $vote_id = $_GET['vote_id'];
    $voteInfo = C::t('#tom_weixin_vote#tom_weixin_vote')->fetch_by_id($_GET['vote_id']);
    $pagesize = 15;
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $start = ($page-1)*$pagesize;	
    $count = C::t('#tom_weixin_vote#tom_weixin_vote_user')->fetch_all_count(" AND vote_id={$vote_id} ");
    $userList = C::t('#tom_weixin_vote#tom_weixin_vote_user')->fetch_all_list(" AND vote_id={$vote_id} ","ORDER BY add_time DESC",$start,$pagesize);
    __create_nav_html();
    showtableheader();
    echo '<tr class="header">';
    echo '<th>' . $Lang['user_xm'] . '</th>';
    echo '<th>' . $Lang['user_tel'] . '</th>';
    echo '</tr>';
    
    $i = 1;
    foreach ($userList as $key => $value) {
        echo '<tr>';
        echo '<td>' . $value['xm'] . '</td>';
        echo '<td>' . $value['tel'] . '</td>';
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

