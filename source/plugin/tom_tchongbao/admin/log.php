<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$modBaseUrl = $adminBaseUrl.'&tmod=log&id='.$_GET['id'];
$modListUrl = $adminListUrl.'&tmod=log&id='.$_GET['id'];
$modFromUrl = $adminFromUrl.'&tmod=log&id='.$_GET['id'];

if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'add'){

}else{
    $page       = intval($_GET['page'])>0? intval($_GET['page']):1;
    
    $pagesize = 30;
    $start = ($page-1)*$pagesize;
    $count = C::t('#tom_tchongbao#tom_tchongbao_qiang_log')->fetch_all_count(" AND hongbao_id = {$_GET['id']} ");
    $logList = C::t('#tom_tchongbao#tom_tchongbao_qiang_log')->fetch_all_list(" AND hongbao_id = {$_GET['id']} "," ORDER BY id DESC ",$start,$pagesize);
    $tchongbaoInfo = C::t('#tom_tchongbao#tom_tchongbao')->fetch_by_id($_GET['id']);
    $tongchengInfo = C::t('#tom_tongcheng#tom_tongcheng')->fetch_by_id($tchongbaoInfo['tongcheng_id']);
    
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $tchongbaoInfo['title'] .'&nbsp;'.$Lang['log_title']. '</th></tr>';
    echo '<tr class="header">';
    echo '<th>' . $Lang['log_user'] . '</th>';
    echo '<th>' . $Lang['log_qd_money'] . '</th>';
    echo '<th>' . $Lang['log_time'] . '</th>';
    echo '</tr>';
    
    $i = 1;
    foreach ($logList as $key => $value) {
        
        echo '<tr style="border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #70b4e6;">';
        echo '<td>' . $value['nickname'] . '</td>';
        echo '<td>' . $value['money'] . '</td>';
        echo '<td>' . dgmdate($value['log_time'],"Y-m-d H:i",$tomSysOffset) . '</td>';
        echo '</tr>';
        $i++;
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBaseUrl);
    showsubmit('', '', '', '', $multi, false);
    
    $jsstr = <<<EOF
<script type="text/javascript">
function del_confirm(url){
  var r = confirm("{$Lang['makesure_del_msg']}")
  if (r == true){
    window.location = url;
  }else{
    return false;
  }
}
</script>
EOF;
    echo $jsstr;
    
}

