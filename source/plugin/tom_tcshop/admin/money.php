<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')){
	exit('Access Denied');
}

$modBaseUrl = $adminBaseUrl.'&tmod=money';
$modListUrl = $adminListUrl.'&tmod=money';
$modFromUrl = $adminFromUrl.'&tmod=money';

$act = $_GET['act'];
$formhash =  $_GET['formhash']? $_GET['formhash']:'';

if($_GET['act'] == 'log'){
    
    $user_id = intval($_GET['user_id'])>0?intval($_GET['user_id']):0;
    
    $userInfo = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($user_id);
    
    tomshownavheader();
    tomshownavli($userInfo['nickname'],"",true);
    tomshownavli(' > '.$Lang['moneylog_list_title'],"",true);
    tomshownavfooter();
    
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $pagesize = 100;
    $start = ($page-1)*$pagesize;
    $count = C::t('#tom_tcshop#tom_tcshop_money_log')->fetch_all_count(" AND user_id={$user_id} ");
    $moneyLogList = C::t('#tom_tcshop#tom_tcshop_money_log')->fetch_all_list(" AND user_id={$user_id} "," ORDER BY id DESC ",$start,$pagesize);
    
    showtableheader();
    echo '<tr class="header">';
    echo '<th>' . $Lang['moneylog_title'] . '</th>';
    echo '<th>' . $Lang['moneylog_change_money'] . '</th>';
    echo '<th>' . $Lang['moneylog_old_money'] . '</th>';
    echo '<th>' . $Lang['moneylog_order_no'] . '</th>';
    echo '<th>' . $Lang['moneylog_beizu'] . '</th>';
    echo '<th>IP</th>';
    echo '<th>' . $Lang['moneylog_log_time'] . '</th>';
    echo '</tr>';
    
    $i = 1;
    foreach ($moneyLogList as $key => $value) {
        
        echo '<tr>';
        echo '<td>';
        if($value['type_id'] == 2){
            if($value['business_id'] == 'tcqianggou'){
                echo '<font color="#238206">' . $Lang['moneylog_business_tcqianggou'] . '</font>';
            }
            if($value['business_id'] == 'tckjia'){
                echo '<font color="#238206">' . $Lang['moneylog_business_tckjia'] . '</font>';
            }
            if($value['business_id'] == 'tcptuan'){
                echo '<font color="#238206">' . $Lang['moneylog_business_tcptuan'] . '</font>';
            }
            if($value['business_id'] == 'tcmall'){
                echo '<font color="#238206">' . $Lang['moneylog_business_tcmall'] . '</font>';
            }
        }
        echo $value['title'];
        echo '</td>';
        if($value['type_id'] == 1){
            echo '<td><font color="#238206">-' . $value['change_money'] . '</font></td>';
        }else{
            echo '<td><font color="#fd0d0d">+' . $value['change_money'] . '</font></td>';
        }
        
        echo '<td><font color="#8e8e8e">' . $value['old_money'] . '</font></td>';
        if(!empty($value['order_no'])){
            echo '<td>' . $value['order_no'] . '</td>';
        }else{
            echo '<td>-</td>';
        }
        echo '<td>';
        if($value['type_id'] == 1){
            $tixianInfo = C::t('#tom_tcshop#tom_tcshop_money_tixian')->fetch_by_id($value['tixian_id']);
            if($tixianInfo['status'] == 1){
                echo '<font color="#fd0d0d">' . $Lang['tixian_status_1'] . '</font>';
            }else if($tixianInfo['status'] == 2){
                echo '<font color="#238206">' . $Lang['tixian_status_2'] . '</font>';
            }
        }else{
            echo '' . $value['beizu'] . '';
        }
        echo '</td>';
        echo '<td>' . $value['log_ip'] . '</td>';
        echo '<td>' . dgmdate($value['log_time'],"Y-m-d H:i",$tomSysOffset) . '</td>';
        echo '</tr>';
        $i++;
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBaseUrl."&act=log&user_id=".$user_id);	
    showsubmit('', '', '', '', $multi, false);
    
}else{
    
    $csstr = <<<EOF
<style type="text/css">
.tcshop_span{padding: 5px 10px;border: 1px solid #aad4f3;display: inline-block;margin-bottom: 5px;margin-right: 5px;}
</style>
EOF;
    echo $csstr;
    
    $user_id    = !empty($_GET['user_id'])? addslashes($_GET['user_id']):0;
    $nickname   = !empty($_GET['nickname'])? addslashes($_GET['nickname']):'';
    
    $user_ids_arr = C::t('#tom_tcshop#tom_tcshop')->fetch_all_user_ids(" AND shenhe_status=1 ");
    $user_ids = array();
    if(is_array($user_ids_arr) && !empty($user_ids_arr)){
        foreach ($user_ids_arr as $key => $value){
            if(!isset($user_ids[$value['user_id']])){
                $user_ids[$value['user_id']] = $value['user_id'];
            }
        }
    }
    $user_ids_str = "999999999";
    if(is_array($user_ids) && !empty($user_ids)){
        $user_ids_str = implode(",", $user_ids);
    }
    
    $where = " AND id IN({$user_ids_str}) ";
    if(!empty($user_id)){
        $where.= " AND id=$user_id ";
    }
    
    $pagesize = 10;
    if(!empty($nickname)){
		$pagesize = 100;
	}
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $start = ($page-1)*$pagesize;	
    $count = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_all_like_count($where,$nickname);
    $userList = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_all_like_list($where,"ORDER BY add_time DESC",$start,$pagesize,$nickname);
    
    showformheader($modFromUrl.'&formhash='.FORMHASH);
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['money_search_list'] . '</th></tr>';
    echo '<tr><td width="100" align="right"><b>' . $Lang['user_id'] . '</b></td><td><input name="user_id" type="text" value="'.$user_id.'" size="40" /></td></tr>';
    echo '<tr><td width="100" align="right"><b>' . $Lang['user_nickname'] . '</b></td><td><input name="nickname" type="text" value="'.$nickname.'" size="40" /></td></tr>';
    
    showsubmit('submit', 'submit');
    showtablefooter();
    showformfooter();
    
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['money_title'] . '</th></tr>';
    echo '<tr class="header">';
    echo '<th>' . $Lang['money_user_id'] . '</th>';
    echo '<th>' . $Lang['money_user_picurl'] . '</th>';
    echo '<th>' . $Lang['money_user_nickname'] . '</th>';
    echo '<th>' . $Lang['money_money'] . '</th>';
    echo '<th>' . $Lang['money_tixian_money'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    foreach ($userList as $key => $value){
        
        $tcshopListTmp = C::t('#tom_tcshop#tom_tcshop')->fetch_all_list(" AND shenhe_status=1 AND user_id={$value['id']} "," ORDER BY id DESC ",0,100,"");
            
        echo '<tr>';
        echo '<td>'.$value['id'].'</td>';
        echo '<td><img src="'.$value['picurl'].'" width="40" /></td>';
        echo '<td>'.$value['nickname'].'</td>';
        echo '<td><font color="#fd0d0d">'.$value['shop_money'].'</font></td>';
        echo '<td><font color="#238206">'.$value['shop_tixian_money'].'</font></td>';
        echo '<td>';
        echo '<a target="_blank" href="'.$adminBaseUrl.'&tmod=index&user_id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['money_tcshop']. '</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
        echo '<a target="_blank" href="'.$modBaseUrl.'&act=log&user_id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['moneylog_list_title']. '</a>';
        echo '</td>';
        echo '</tr>';
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBaseUrl);
    showsubmit('', '', '', '', $multi, false);
}