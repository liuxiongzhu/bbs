<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$modBaseUrl = $adminBaseUrl.'&tmod=user';
$modListUrl = $adminListUrl.'&tmod=user';
$modFromUrl = $adminFromUrl.'&tmod=user';

$act = $_GET['act'];
$formhash =  $_GET['formhash']? $_GET['formhash']:'';

if($_GET['act'] == 'add'){
}else{
    
    $user_id = !empty($_GET['user_id'])? addslashes($_GET['user_id']):0;
    $nickname = !empty($_GET['nickname'])? addslashes($_GET['nickname']):'';
    
    $where = "";
    if(!empty($user_id)){
        $where.= " AND user_id=$user_id ";
    }
    
    $pagesize = 10;
    if(!empty($nickname)){
		$pagesize = 100;
	}
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $start = ($page-1)*$pagesize;	
    $count = C::t('#tom_xiaofenlei#tom_xiaofenlei_user')->fetch_all_like_count($where,$nickname);
    $userList = C::t('#tom_xiaofenlei#tom_xiaofenlei_user')->fetch_all_like_list($where,"ORDER BY add_time DESC",$start,$pagesize,$nickname);
    
    showtableheader();
    $Lang['xiao_help_3']  = str_replace("{SITEURL}", $_G['siteurl'], $Lang['xiao_help_3']);
    echo '<tr><th colspan="15" class="partition">' . $Lang['xiao_help_title'] . '</th></tr>';
    echo '<tr><td  class="tipsblock" s="1"><ul id="tipslis">';
    echo '<li>' . $Lang['xiao_help_3'] . '</li>';
    echo '</ul></td></tr>';
    showtablefooter();
    
    $modBaseUrl = $modBaseUrl."&editor={$editor}&status={$status}";
    
    showformheader($modFromUrl.'&formhash='.FORMHASH);
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['user_search_list'] . '</th></tr>';
    echo '<tr><td width="100" align="right"><b>' . $Lang['user_id'] . '</b></td><td><input name="user_id" type="text" value="'.$user_id.'" size="40" /></td></tr>';
    echo '<tr><td width="100" align="right"><b>' . $Lang['user_nickname'] . '</b></td><td><input name="nickname" type="text" value="'.$nickname.'" size="40" /></td></tr>';
    
    showsubmit('submit', 'submit');
    showtablefooter();
    showformfooter();
    
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['user_list_title'] . '</th></tr>';
    echo '<tr class="header">';
    echo '<th>' . $Lang['user_id'] . '</th>';
    echo '<th>' . $Lang['user_picurl'] . '</th>';
    echo '<th>' . $Lang['user_nickname'] . '</th>';
    echo '<th>' . $Lang['user_tel'] . '</th>';
    echo '</tr>';
    foreach ($userList as $key => $value){
        echo '<tr>';
        echo '<td>'.$value['user_id'].'</td>';
        echo '<td><img src="'.$value['picurl'].'" width="40" /></td>';
        echo '<td>'.$value['nickname'].'</td>';
        echo '<td>'.$value['tel'].'</td>';
        echo '</tr>';
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBaseUrl);	
    showsubmit('', '', '', '', $multi, false);
}

