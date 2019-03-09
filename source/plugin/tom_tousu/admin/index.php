<?php
/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/  
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
$modBaseUrl = $adminBaseUrl.'&tmod=index';
$modListUrl = $adminListUrl.'&tmod=index';
$modFromUrl = $adminFromUrl.'&tmod=index';

if($_GET['act'] == 'add'){
    
}else{
    $ip = isset($_GET['ip'])? daddslashes($_GET['ip']):'';
    
    $where = '';
    if(!empty($ip)){
        $ip2 = ip2long($ip);
        $where.= " AND ip = '{$ip2}'";
    }
    
    $pagesize = 20;
    $page = intval($_GET['page'])>0 ? intval($_GET['page']):1;
    $start = ($page-1)*$pagesize;
    $count = C::t('#tom_tousu#tom_tousu')->fetch_all_count("$where");
    $tousuList = C::t('#tom_tousu#tom_tousu')->fetch_all_list("$where", "ORDER BY add_time DESC", $start, $pagesize);
    $modBaseUrl.= "&ip={$ip}";
    showtableheader();
    $Lang['tousu_help_1'] = str_replace("{SITEURL}", $_G['siteurl'], $Lang['tousu_help_1']);
    echo '<tr><th colspan="15" class="partition">'.$Lang['tousu_help_title'].'</th></tr>';
    echo '<tr><td class="tipsblock" s="1"><ul id="tipslis">';
    echo '<li>'.$Lang['tousu_help_1'].'</li>';
    echo '</ul></td></tr>';
    showtablefooter();
    showformheader($modFromUrl.'&formhash='.FORMHASH);
    showtableheader();
    echo '<tr><th colspan="15" class="partition">'.$Lang['tousu_search_title'].'</th></tr>';
    echo '<tr><td width="100" align="right"><b>'.$Lang['tousu_ip_search'].'</b></td><td><input name="ip" type="text" value="'.$ip.'" size="40" /></td></tr>';
    showsubmit('submit', 'submit');
    showtablefooter();
    showformfooter();
    __create_nav_html();
    showtableheader();
    echo '<tr class="header">';
    echo '<th width="10%"> ID </th>';
    echo '<th>'.$Lang['tousu_type'].'</th>';
    echo '<th>'.$Lang['tousu_link'].'</th>';
    echo '<th> ip </th>';
    echo '<th>'.$Lang['tousu_time'].'</th>';
    echo '</tr>';
    $i = 1;
    foreach ($tousuList as $key => $value){
        $tousu_type = '';
        if($value['type'] == 1){
            $tousu_type = $Lang['tousu_type_1'];
        }else if($value['type'] == 2){
            $tousu_type = $Lang['tousu_type_2'];
        }else if($value['type'] == 3){
            $tousu_type = $Lang['tousu_type_3'];
        }else if($value['type'] == 4){
            $tousu_type = $Lang['tousu_type_4'];
        }else if($value['type'] == 5){
            $tousu_type = $Lang['tousu_type_5'];
        }else if($value['type'] == 6){
            $tousu_type = $Lang['tousu_type_6'];
        }else if($value['type'] == 7){
            $tousu_type = $Lang['tousu_type_7'];
        }
        
        echo '<tr>';
        echo '<td>'.$value['id'].'</td>';
        echo '<td>'.$tousu_type.'</td>';
        echo '<td>'.$value['link'].'</td>';
        echo '<td>'.long2ip($value['ip']).'</td>';
        echo '<td>'.dgmdate($value['add_time'], "Y-m-d H:i", $tomSysOffset).'</td>';
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
    
    tomshownavli($Lang['tousu_list_title'],$modBaseUrl,true);
    
    tomshownavfooter();
}
