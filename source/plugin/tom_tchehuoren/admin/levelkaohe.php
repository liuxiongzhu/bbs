<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$modBaseUrl = $adminBaseUrl.'&tmod=levelkaohe';
$modListUrl = $adminListUrl.'&tmod=levelkaohe';
$modFromUrl = $adminFromUrl.'&tmod=levelkaohe';

if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'kaohe_succ'){
    $kaoheUserInfo = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_by_id($_GET['id']);
    $tcUserInfo = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_openid($kaoheUserInfo['openid']);
    
    $zhouqiTime = $tchehuorenConfig['kaohe_cycle'] * 86400;
    
    $updateData = array();
    $updateData['kaohe_time'] = TIMESTAMP + $zhouqiTime;
    C::t('#tom_tchehuoren#tom_tchehuoren')->update($_GET['id'], $updateData);
    
    $kaohe_template_sms = lang('plugin/tom_tchehuoren', 'kaohe_template_succ');
    
    $access_token = $weixinClass->get_access_token();
    if($access_token && !empty($tcUserInfo['openid'])){
        $templateSmsClass = new templateSms($access_token, $_G['siteurl']."plugin.php?id=tom_tchehuoren&mod=level");
        $smsData = array(
            'first'         => $kaohe_template_sms,
            'keyword1'      => $tchehuorenConfig['plugin_name'],
            'keyword2'      => dgmdate(TIMESTAMP,"Y-m-d H:i:s",$tomSysOffset),
            'remark'        => ''
        );
        if(!empty($tchehuorenConfig['template_id'])){
            $template_id = $tchehuorenConfig['template_id'];
        }else{
            $template_id = $tongchengConfig['template_id'];
        }
        @$r = $templateSmsClass->sendSms01($tcUserInfo['openid'], $template_id, $smsData);
    }
    
    $insertData = array();
    $insertData['user_id']      = $tcUserInfo['id'];
    $insertData['type']         = 1;
    $insertData['content']      = '<font color="#238206">'.$tchehuorenConfig['plugin_name'].'</font><br/>'.$kaohe_template_sms.'<br/>'.dgmdate(TIMESTAMP,"Y-m-d H:i:s",$tomSysOffset);
    $insertData['is_read']      = 0;
    $insertData['tz_time']      = TIMESTAMP;
    C::t('#tom_tongcheng#tom_tongcheng_tz')->insert($insertData);
    
    $insertData = array();
    $insertData['hehuoren_id']  = $kaoheUserInfo['id'];
    $insertData['old_dengji']   = $kaoheUserInfo['dengji_id'];
    $insertData['new_dengji']   = $kaoheUserInfo['dengji_id'];
    $insertData['text']         = '';
    $insertData['log_status']   = 1;
    $insertData['log_time']     = TIMESTAMP;
    C::t('#tom_tchehuoren#tom_tchehuoren_kaohe_log')->insert($insertData);
    
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else if($_GET['act'] == 'kaohe_fail' && $_GET['formhash'] == FORMHASH){
    
    $kaoheUserInfo = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_by_id($_GET['id']);
    
    if(submitcheck('submit')){
        $text = isset($_GET['text'])? addslashes($_GET['text']):'';
        
        $tcUserInfo = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($kaoheUserInfo['user_id']);
        $dengjiInfo = C::t('#tom_tchehuoren#tom_tchehuoren_dengji')->fetch_by_id($kaoheUserInfo['dengji_id']);
        
        $zhouqiTime = $tchehuorenConfig['kaohe_cycle'] * 86400;
        
        if(($dengjiInfo['level'] - 1) <= 1){
            $level = 1;
            $kaohe_time = 0;
        }else{
            $level = $dengjiInfo['level'] - 1;
            $kaohe_time = TIMESTAMP + $zhouqiTime;
        }
        $levelInfo = C::t('#tom_tchehuorne#tom_tchehuoren_dengji')->fetch_by_level($level);
        
        $updateData = array();
        $updateData['dengji_id'] = $levelInfo['id'];
        $updateData['kaohe_time'] = $kaohe_time;
        C::t('#tom_tchehuoren#tom_tchehuoren')->update($_GET['id'], $updateData);
        
        $kaohe_template_sms = lang('plugin/tom_tchehuoren', 'kaohe_template_fail');
        
        $access_token = $weixinClass->get_access_token();
        if($access_token && !empty($tcUserInfo['openid'])){
            $templateSmsClass = new templateSms($access_token, $_G['siteurl']."plugin.php?id=tom_tchehuoren&mod=level");
            $smsData = array(
                'first'         => $kaohe_template_sms,
                'keyword1'      => $tchehuorenConfig['plugin_name'],
                'keyword2'      => dgmdate(TIMESTAMP,"Y-m-d H:i:s",$tomSysOffset),
                'remark'        => $text
            );
            if(!empty($tchehuorenConfig['template_id'])){
                $template_id = $tchehuorenConfig['template_id'];
            }else{
                $template_id = $tongchengConfig['template_id'];
            }
            @$r = $templateSmsClass->sendSms01($tcUserInfo['openid'], $template_id, $smsData);
        }

        $insertData = array();
        $insertData['user_id']      = $tcUserInfo['id'];
        $insertData['type']         = 1;
        $insertData['content']      = '<font color="#238206">'.$tchehuorenConfig['plugin_name'].'</font><br/>'.$kaohe_template_sms.'<br/>'.$Lang['kaohe_template_fail_yuanying'].$text.'<br/>'.dgmdate(TIMESTAMP,"Y-m-d H:i:s",$tomSysOffset);
        $insertData['is_read']      = 0;
        $insertData['tz_time']      = TIMESTAMP;
        C::t('#tom_tongcheng#tom_tongcheng_tz')->insert($insertData);
        
        $insertData = array();
        $insertData['hehuoren_id']  = $kaoheUserInfo['id'];
        $insertData['old_dengji']   = $kaoheUserInfo['dengji_id'];
        $insertData['new_dengji']   = $levelInfo['id'];
        $insertData['text']         = $text;
        $insertData['log_status']   = 2;
        $insertData['log_time']     = TIMESTAMP;
        C::t('#tom_tchehuoren#tom_tchehuoren_kaohe_log')->insert($insertData);
        
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        tomloadcalendarjs();
        loadeditorjs();
        __create_nav_html();
        showformheader($modFromUrl.'&act=kaohe_fail&id='.$_GET['id'],'enctype');
        showtableheader();
        tomshowsetting(true,array('title'=>$Lang['kaohe_template_fail_yuanying'],'name'=>'text','value'=>'','msg'=>$Lang['kaohe_template_fail_yuanying_msg']),"textarea");
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
}else if($_GET['act'] == 'month_shouyi'){
    
    $tchehuorenInfo = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_by_id($_GET['id']);
    
    $year = dgmdate($_G['timestamp'], 'Y',$tomSysOffset);
    $month = dgmdate($_G['timestamp'], 'm',$tomSysOffset);
    
    $shouyiList = array();
    for($i=0; $i<6;$i++) {
        $monthTime = $year.$month;
        $monthMoney = C::t('#tom_tchehuoren#tom_tchehuoren_shouyi')->fetch_shouyi_sum(" AND hehuoren_id = {$tchehuorenInfo['id']} AND month_time = {$monthTime} ");
        
        if(!empty($monthMoney)){ 
            $shouyiList[$monthTime]['month_time'] = $year.'-'.$month;
            $shouyiList[$monthTime]['month_money'] = $monthMoney;
        }
        
        $month = intval($month) - 1;
        if($month == 0){
            $month = 12;
            $year = intval($year) - 1;
        }else if($month < 10){
            $month = '0'.$month;
        }
    }

    showtableheader();
    echo '<tr><th colspan="15" class="partition">' .$tchehuorenInfo['xm'] .'&nbsp;&gt;&nbsp;'. $Lang['kaohe_month_shouyi'] . '</th></tr>';
    echo '<tr class="header">';
    echo '<th>' . $Lang['kaohe_month_shouyi_month'] . '</th>';
    echo '<th>' . $Lang['kaohe_month_shouyi_price'] . '</th>';
    echo '</tr>';
    
    $i = 0;
    foreach($shouyiList as $key => $value) {
        
        echo '<tr>';
        echo '<td>' . $value['month_time'] . '</td>';
        echo '<td>' . $value['month_money'] . '</td>';
        echo '</tr>';
    }
    showtablefooter();
    
}else if($_GET['act'] == 'shenheList'){
    
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $status = isset($_GET['status'])? intval($_GET['status']):1;
    
    $where = '';
    if($status > 0){
        $where .= " AND status = {$status} ";
    }

    $pagesize = 100;
    $start = ($page-1)*$pagesize;
    $count = C::t('#tom_tchehuoren#tom_tchehuoren_dengji_shenqing')->fetch_all_count($where);
    $shenqingList = C::t('#tom_tchehuoren#tom_tchehuoren_dengji_shenqing')->fetch_all_list($where," ORDER BY add_time DESC,id DESC ",$start,$pagesize);
    
    $modBasePageUrl = $modBaseUrl."&act=shenheList&status={$status}";
    
    showformheader($modFromUrl.'&act=shenheList&formhash='.FORMHASH);
    showtableheader();
    $status_selected_1 = $status_selected_2 = $status_selected_3 = '';
    if($status == 1){
        $status_selected_1 = 'selected';
    }else if($status == 2){
        $status_selected_2 = 'selected';
    }else if($status == 3){
        $status_selected_3 = 'selected';
    }
    $sitesStr = '<tr><td width="100" align="right"><b>'.$Lang['shenqing_status'].'</b></td>';
    $sitesStr.= '<td><select style="width: 260px;" name="status" id="status">';
    $sitesStr.=  '<option value="0">'.$Lang['shenqing_status_all'].'</option>';
    $sitesStr.=  '<option value="1" '.$status_selected_1.'>'.$Lang['shenqing_status_1'].'</option>';
    $sitesStr.=  '<option value="2" '.$status_selected_2.'>'.$Lang['shenqing_status_2'].'</option>';
    $sitesStr.=  '<option value="3" '.$status_selected_3.'>'.$Lang['shenqing_status_3'].'</option>';
    echo $sitesStr;
    showsubmit('submit', 'submit');
    showtablefooter();
    showformfooter();
    
    __create_nav_html();
    showtableheader();
    echo '<tr class="header">';
    echo '<th> ID </th>';
    echo '<th> '. $Lang['dengji_shenqing_hehuoren'] .' </th>';
    echo '<th>' . $Lang['dengji_shenqing_dengji'] . '</th>';
    echo '<th>' . $Lang['dengji_shenqing_status'] . '</th>';
    echo '<th>' . $Lang['dengji_shenqing_time'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    
    $i = 1;
    foreach ($shenqingList as $key => $value) {
        $hehuorenInfo = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_by_id($value['hehuoren_id']);
        $dengjiInfo = C::t('#tom_tchehuoren#tom_tchehuoren_dengji')->fetch_by_id($value['dengji_id']);
        
        echo '<tr>';
        echo '<td>' . $value['id'] . '</td>';
        echo '<td><a href="'.$adminBaseUrl.'&mod=index&hehuoren_id='.$hehuorenInfo['id'].'" target="_blank">' . $hehuorenInfo['xm'] . '</a></td>';
        echo '<td> '.$dengjiInfo['name'].' </td>';
        if($value['status'] == 1){
            echo '<td><font color="#f00">' . $Lang['shenqing_status_1'] . '</font></td>';
        }else if($value['status'] == 2){
            echo '<td><font color="#0a9409">' . $Lang['shenqing_status_2'] . '</font></td>';
        }else if($value['status'] == 3){
            echo '<td><font color="#f00">' . $Lang['shenqing_status_3'] . '</font></td>';
        }
        echo '<td> '.dgmdate($value['add_time'],"Y-m-d H:i:s",$tomSysOffset).' </td>';
        echo '<td>';
        echo '<a href="javascript:void(0);" onClick="handle_confirm(\''.$modBaseUrl.'&act=shenhe_succ&id='.$value['id'].'&formhash='.FORMHASH.'\');">' . $Lang['shenqing_status_2']. '</a>&nbsp;|&nbsp;';
        echo '<a href="'.$modBaseUrl.'&act=shenhe_fail&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['shenqing_status_3']. '</a>';
        echo '</td>';
        echo '</tr>';
        $i++;
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBasePageUrl);
    showsubmit('', '', '', '', $multi, false);
    
    $jsstr = <<<EOF
<script type="text/javascript">
function handle_confirm(url){
  var r = confirm("{$Lang['makesure_shenqing_hehuoren_dengji_msg']}")
  if (r == true){
    window.location = url;
  }else{
    return false;
  }
}
</script>
EOF;
    echo $jsstr;

}else if($_GET['act'] == 'shenhe_succ' && $_GET['formhash'] == FORMHASH){
    
    $status = 2;
    
    $shenqingInfo = C::t('#tom_tchehuoren#tom_tchehuoren_dengji_shenqing')->fetch_by_id($_GET['id']);
    
    $updateData = array();
    $updateData['status'] = $status;
    C::t('#tom_tchehuoren#tom_tchehuoren_dengji_shenqing')->update($shenqingInfo['id'], $updateData);
    
    $hehuorenInfo = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_by_id($shenqingInfo['hehuoren_id']);
    $tcUserInfo = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($hehuorenInfo['user_id']);
    
    $kaohe_cycle_second = $tchehuorenConfig['kaohe_cycle'] * 86400;
    
    $updateData = array();
    $updateData['dengji_id'] = $shenqingInfo['dengji_id'];
    $updateData['kaohe_time'] = TIMESTAMP + $kaohe_cycle_second;
    C::t('#tom_tchehuoren#tom_tchehuoren')->update($hehuorenInfo['id'], $updateData);
    
    $shenhe = lang('plugin/tom_tchehuoren', 'shenqing_hehuoren_dengji_template').$Lang['shenqing_status_2'];
    
    $access_token = $weixinClass->get_access_token();
    if($access_token && !empty($hehuorenInfo['openid'])){
        $templateSmsClass = new templateSms($access_token, $_G['siteurl']."plugin.php?id=tom_tchehuoren&mod=level");
        $smsData = array(
            'first'         => $shenhe,
            'keyword1'      => $tchehuorenConfig['plugin_name'],
            'keyword2'      => dgmdate(TIMESTAMP,"Y-m-d H:i:s",$tomSysOffset),
            'remark'        => ''
        );
        if(!empty($tchehuorenConfig['template_id'])){
            $template_id = $tchehuorenConfig['template_id'];
        }else{
            $template_id = $tongchengConfig['template_id'];
        }
        @$r = $templateSmsClass->sendSms01($hehuorenInfo['openid'], $template_id, $smsData);
    }
    
    $insertData = array();
    $insertData['user_id']      = $tcUserInfo['id'];
    $insertData['type']         = 1;
    $insertData['content']      = '<font color="#238206">'.$tchehuorenConfig['plugin_name'].'</font><br/>'.$shenhe.'<br/>'.dgmdate(TIMESTAMP,"Y-m-d H:i:s",$tomSysOffset);
    $insertData['is_read']      = 0;
    $insertData['tz_time']      = TIMESTAMP;
    C::t('#tom_tongcheng#tom_tongcheng_tz')->insert($insertData);
    
    cpmsg($Lang['act_success'], $modListUrl.'&act=shenheList', 'succeed');
    
}else if($_GET['act'] == 'shenhe_fail' && $_GET['formhash'] == FORMHASH){

    $shenqingInfo = C::t('#tom_tchehuoren#tom_tchehuoren_dengji_shenqing')->fetch_by_id($_GET['id']);
    $hehuorenInfo = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_by_id($shenqingInfo['hehuoren_id']);
    if(submitcheck('submit')){
        $text = isset($_GET['text'])? addslashes($_GET['text']):'';
        
        $tcUserInfo = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($hehuorenInfo['user_id']);
        
        $updateData = array();
        $updateData['status'] = 3;
        C::t('#tom_tchehuoren#tom_tchehuoren_dengji_shenqing')->update($shenqingInfo['id'], $updateData);
        
        $shenhe = lang('plugin/tom_tchehuoren', 'shenqing_hehuoren_dengji_template').$Lang['shenqing_status_3'];
        
        $access_token = $weixinClass->get_access_token();
        if($access_token && !empty($tcUserInfo['openid'])){
            $templateSmsClass = new templateSms($access_token, $_G['siteurl']."plugin.php?id=tom_tchehuoren&mod=level");
            $smsData = array(
                'first'         => $shenhe,
                'keyword1'      => $tchehuorenConfig['plugin_name'],
                'keyword2'      => $text,
                'remark'        => dgmdate(TIMESTAMP,"Y-m-d H:i:s",$tomSysOffset)
            );
            if(!empty($tchehuorenConfig['template_id'])){
                $template_id = $tchehuorenConfig['template_id'];
            }else{
                $template_id = $tongchengConfig['template_id'];
            }
            @$r = $templateSmsClass->sendSms01($tcUserInfo['openid'], $template_id, $smsData);
        }

        $insertData = array();
        $insertData['user_id']      = $tcUserInfo['id'];
        $insertData['type']         = 1;
        $insertData['content']      = '<font color="#238206">'.$tchehuorenConfig['plugin_name'].'</font><br/>'.$shenhe.'<br/>'.$Lang['shenqing_fail_title'].$text.'<br/>'.dgmdate(TIMESTAMP,"Y-m-d H:i:s",$tomSysOffset);
        $insertData['is_read']      = 0;
        $insertData['tz_time']      = TIMESTAMP;
        C::t('#tom_tongcheng#tom_tongcheng_tz')->insert($insertData);
        
        cpmsg($Lang['act_success'], $modListUrl.'&act=shenheList', 'succeed');
    }else{
        tomloadcalendarjs();
        loadeditorjs();
        __create_nav_html();
        showformheader($modFromUrl.'&act=shenhe_fail&id='.$_GET['id'],'enctype');
        showtableheader();
        tomshowsetting(true,array('title'=>$Lang['shenqing_fail_title'],'name'=>'text','value'=>'','msg'=>$Lang['shenqing_fail_title_msg']),"textarea");
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
    
}else{
    
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    
    $endKaoheTime = TIMESTAMP;
    $pagesize = 30;
    $start = ($page-1)*$pagesize;
    $count = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_all_count(" AND kaohe_time <= {$endKaoheTime} AND kaohe_time > 0 ");
    $kaoheList = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_all_list(" AND kaohe_time <= {$endKaoheTime} AND kaohe_time > 0  ",'ORDER BY kaohe_time ASC,id ASC',$start,$pagesize);
    
    $modBasePageUrl = $modBaseUrl."&status={$status}";
    
    showtableheader();
    $Lang['index_help_1']  = str_replace("{SITEURL}", $_G['siteurl'], $Lang['index_help_1']);
    $Lang['index_help_2']  = str_replace("{SITEURL}", $_G['siteurl'], $Lang['index_help_2']);
    echo '<tr><th colspan="15" class="partition">' . $Lang['hehuoren_help_title'] . '</th></tr>';
    echo '<tr><td  class="tipsblock" s="1"><ul id="tipslis">';
    echo '<li>' . $Lang['kaohe_help_1'] . '</li>';
    echo '</ul></td></tr>';
    showtablefooter();
    
    __create_nav_html();
    showtableheader();
    echo '<tr class="header">';
    echo '<th> '. $Lang['kaohe_hehuoren_name'] .' </th>';
    echo '<th>' . $Lang['kaohe_now_dengji'] . '</th>';
    echo '<th>' . $Lang['kaohe_end_time'] . '</th>';
    echo '<th>' . $Lang['kaohe_status'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    
    $i = 1;
    foreach ($kaoheList as $key => $value) {
        $dengjiInfo = C::t('#tom_tchehuoren#tom_tchehuoren_dengji')->fetch_by_id($value['dengji_id']);
        
        echo '<tr>';
        echo '<td><a href="'.$adminBaseUrl.'&hehuoren_id='.$value['id'].'&formhash='.FORMHASH.'" target="_blank">' . $value['xm'].'&nbsp;('.$value['id'] . ')</a></td>';
        echo '<td>' . $dengjiInfo['name'] . '</td>';
        echo '<td>' . dgmdate($value['kaohe_time'], "Y-m-d H:i", $tomSysOffset) . '</td>';
        echo '<td><font color="#f00">'.$Lang['kaohe_status_1'].'</font></td>';
        echo '<td>';
        echo '<a href="'.$modBaseUrl.'&act=month_shouyi&id='.$value['id'].'&formhash='.FORMHASH.'" target="_blank">' . $Lang['kaohe_month_shouyi']. '</a>&nbsp;|&nbsp;';
        echo '<a href="javascript:void(0);" onclick="del_confirm(\''.$modBaseUrl.'&act=kaohe_succ&id='.$value['id'].'&formhash='.FORMHASH.'\');">' . $Lang['kaohe_succ'] . '</a>&nbsp;|&nbsp;';
        echo '<a href="javascript:void(0);" onclick="del_confirm(\''.$modBaseUrl.'&act=kaohe_fail&id='.$value['id'].'&formhash='.FORMHASH.'\');">' . $Lang['kaohe_fail'] . '</a>';
        echo '</td>';
        echo '</tr>';
        $i++;
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBaseUrl);
    showsubmit('', '', '', '', $multi, false);
    
    $jsstr = <<<EOF
<script>
function del_confirm(url){
  var r = confirm("{$Lang['makesure_kaohe_msg']}")
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

function __create_nav_html($infoArr = array()){
    global $Lang,$modBaseUrl,$adminBaseUrl;
    tomshownavheader();
    if($_GET['act'] == 'shenheList'){
        tomshownavli($Lang['kaohe_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['dengji_shenhe_list'],"",true);
    }else if($_GET['act'] == 'shenhe_succ'){
        tomshownavli($Lang['dengji_shenhe_list'],"",true);
    }else if($_GET['act'] == 'shenhe_fail'){
        tomshownavli($Lang['dengji_shenhe_list'],"",true);
    }else{
        tomshownavli($Lang['kaohe_list_title'],$modBaseUrl,true);
        tomshownavli($Lang['dengji_shenhe_list'],$modBaseUrl."&act=shenheList",false);
    }
    tomshownavfooter();
}