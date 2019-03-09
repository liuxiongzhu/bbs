<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$modBaseUrl = $adminBaseUrl.'&tmod=shenqing';
$modListUrl = $adminListUrl.'&tmod=shenqing';
$modFromUrl = $adminFromUrl.'&tmod=shenqing';

if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'succ'){
    $status = 2;
    
    $updateData = array();
    $updateData['status'] = $status;
    C::t('#tom_tchehuoren#tom_tchehuoren_shenqing')->update($_GET['id'], $updateData);
    
    $shenqingInfo = C::t('#tom_tchehuoren#tom_tchehuoren_shenqing')->fetch_by_id($_GET['id']);
    $tcUserInfo = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($shenqingInfo['user_id']);
    
    $tchehuorenInfo = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_by_user_id($tcUserInfo['id']);

    if(!$tchehuorenInfo){
        $tchehuorenInfoTmp = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_all_list('', 'ORDER BY invite_id DESC,id DESC', 0, 1);
        $dengjiInfo = C::t('#tom_tchehuoren#tom_tchehuoren_dengji')->fetch_all_list(' AND level = 1 ', 'ORDER BY level DESC, id DESC', 0, 1);
        $invite_id = 11111;
        if(is_array($tchehuorenInfoTmp) && !empty($tchehuorenInfoTmp[0])){
            if($tchehuorenInfoTmp[0]['invite_id'] >= 11111){
                $invite_id  = $tchehuorenInfoTmp[0]['invite_id'] + 1;
            }
        }

        $inviteStr = tom_random(1, 'qwertyupasdfghkzxcvbnm');
        $invite_code = $inviteStr.$invite_id;

        $insertData = array();
        $insertData['user_id']              = $tcUserInfo['id'];
        $insertData['tj_hehuoren_id']       = $shenqingInfo['tj_hehuoren_id'];
        $insertData['picurl']               = $tcUserInfo['picurl'];
        $insertData['xm']                   = $shenqingInfo['xm'];
        $insertData['tel']                  = $shenqingInfo['tel'];
        $insertData['openid']               = $tcUserInfo['openid'];
        $insertData['dengji_id']            = $dengjiInfo[0]['id'];
        $insertData['invite_id']            = $invite_id;
        $insertData['invite_code']          = $invite_code;
        $insertData['add_time']             = TIMESTAMP;
        C::t('#tom_tchehuoren#tom_tchehuoren')->insert($insertData);
    }
    
    $shenhe = $Lang['shenqing_hehuoren_template'].$Lang['shenqing_status_2'];
    
    $access_token = $weixinClass->get_access_token();
    if($access_token && !empty($tcUserInfo['openid'])){
        $templateSmsClass = new templateSms($access_token, $_G['siteurl']."plugin.php?id=tom_tchehuoren&mod=inlet&tj_hehuoren_id=".$shenqingInfo['tj_hehuoren_id']);
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
        @$r = $templateSmsClass->sendSms01($tcUserInfo['openid'], $template_id, $smsData);
    }
    
    $insertData = array();
    $insertData['user_id']      = $tcUserInfo['id'];
    $insertData['type']         = 1;
    $insertData['content']      = '<font color="#238206">'.$tchehuorenConfig['plugin_name'].'</font><br/>'.$shenhe.'<br/>'.dgmdate(TIMESTAMP,"Y-m-d H:i:s",$tomSysOffset);
    $insertData['is_read']      = 0;
    $insertData['tz_time']      = TIMESTAMP;
    C::t('#tom_tongcheng#tom_tongcheng_tz')->insert($insertData);
    
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'fail'){
    
    $shenqingInfo = C::t('#tom_tchehuoren#tom_tchehuoren_shenqing')->fetch_by_id($_GET['id']);
    if(submitcheck('submit')){
        $text = isset($_GET['text'])? addslashes($_GET['text']):'';
        
        $tcUserInfo = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($shenqingInfo['user_id']);
        
        $updateData = array();
        $updateData['status'] = 3;
        C::t('#tom_tchehuoren#tom_tchehuoren_shenqing')->update($_GET['id'], $updateData);
        
        $shenhe = lang('plugin/tom_tchehuoren', 'shenqing_hehuoren_template').$Lang['shenqing_status_3'];
        
        $access_token = $weixinClass->get_access_token();
        if($access_token && !empty($tcUserInfo['openid'])){
            $templateSmsClass = new templateSms($access_token, $_G['siteurl']."plugin.php?id=tom_tchehuoren&mod=inlet&tj_hehuoren_id=".$shenqingInfo['tj_hehuoren_id']);
            $smsData = array(
                'first'         => $shenhe,
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
        $insertData['content']      = '<font color="#238206">'.$tchehuorenConfig['plugin_name'].'</font><br/>'.$shenhe.'<br/>'.$Lang['shenqing_fail_title'].$text.'<br/>'.dgmdate(TIMESTAMP,"Y-m-d H:i:s",$tomSysOffset);
        $insertData['is_read']      = 0;
        $insertData['tz_time']      = TIMESTAMP;
        C::t('#tom_tongcheng#tom_tongcheng_tz')->insert($insertData);
        
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        tomloadcalendarjs();
        loadeditorjs();
        __create_nav_html();
        showformheader($modFromUrl.'&act=fail&id='.$_GET['id'],'enctype');
        showtableheader();
        tomshowsetting(true,array('title'=>$Lang['shenqing_fail_title'],'name'=>'text','value'=>'','msg'=>$Lang['shenqing_fail_title_msg']),"textarea");
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
    
}else{
    $status = isset($_GET['status']) ? intval($_GET['status']):1;
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    
    $where = '';
    if($status > 0){
        $where = " AND status = {$status} ";
    }
    
    $pagesize = 100;
    $start = ($page-1)*$pagesize;	
    $count = C::t('#tom_tchehuoren#tom_tchehuoren_shenqing')->fetch_all_count($where);
    $shenqingList = C::t('#tom_tchehuoren#tom_tchehuoren_shenqing')->fetch_all_list($where," ORDER BY add_time DESC,id DESC ",$start,$pagesize);
    
    $modBasePageUrl = $modBaseUrl."&status={$status}";
    
    showformheader($modFromUrl.'&formhash='.FORMHASH);
    showtableheader();
    $status_selected_1 = $status_selected_2 = $status_selected_3 = $status_selected_4 = '';
    if($status == 1){
        $status_selected_1 = 'selected';
    }else if($status == 2){
        $status_selected_2 = 'selected';
    }else if($status == 3){
        $status_selected_3 = 'selected';
    }else if($status == 4){
        $status_selected_4 = 'selected';
    }
    $sitesStr = '<tr><td width="100" align="right"><b>'.$Lang['shenqing_status'].'</b></td>';
    $sitesStr.= '<td><select style="width: 260px;" name="status" id="status">';
    $sitesStr.=  '<option value="0">'.$Lang['shenqing_status_all'].'</option>';
    $sitesStr.=  '<option value="1" '.$status_selected_1.'>'.$Lang['shenqing_status_1'].'</option>';
    $sitesStr.=  '<option value="2" '.$status_selected_2.'>'.$Lang['shenqing_status_2'].'</option>';
    $sitesStr.=  '<option value="3" '.$status_selected_3.'>'.$Lang['shenqing_status_3'].'</option>';
    $sitesStr.=  '<option value="4" '.$status_selected_4.'>'.$Lang['shenqing_status_4'].'</option>';
    echo $sitesStr;
    showsubmit('submit', 'submit');
    showtablefooter();
    showformfooter();
    
    __create_nav_html();
    showtableheader();
    echo '<tr class="header">';
    echo '<th>' . $Lang['shenqing_ucenter_uid'] . '</th>';
    echo '<th>' . $Lang['shenqing_order_no'] . '</th>';
    echo '<th>' . $Lang['shenqing_pay_price'] . '</th>';
    echo '<th> openid </th>';
    echo '<th>' . $Lang['shenqing_tj_hehuoren_id'] . '</th>';
    echo '<th>' . $Lang['shenqing_xm'] . '</th>';
    echo '<th>' . $Lang['shenqing_tel'] . '</th>';
    echo '<th>' . $Lang['shenqing_status'] . '</th>';
    echo '<th>' . $Lang['shenqing_time'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    
    $i = 1;
    foreach ($shenqingList as $key => $value) {
        $tjHehuorenInfo = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_by_id($value['tj_hehuoren_id']);
        $payOrderInfo = C::t('#tom_pay#tom_pay_order')->fetch_by_order_no($value['order_no']);
        
        echo '<tr>';
        echo '<td>' . $value['user_id'] . '</td>';
        if(is_array($payOrderInfo) && !empty($payOrderInfo)){
            echo '<td>' . $value['order_no'] . '</td>';
            if($payOrderInfo['order_status'] == 1){
                echo '<td>' . $payOrderInfo['pay_price'] . '-<font color="#f00">(' . $Lang['shenqing_order_status_1'] . ')</font></td>';
            }else{
                echo '<td>' . $payOrderInfo['pay_price'] . '-<font color="#0a9409">(' . $Lang['shenqing_order_status_2'] . ')</font></td>';
            }
        }else{
            echo '<td> -- </td>';
            echo '<td> -- </td>';
        }
        
        echo '<td>' . $value['openid'] . '</td>';
        if($tjHehuorenInfo){
            echo '<td><font color="#0a9409">' . $tjHehuorenInfo['xm'].'(',$tjHehuorenInfo['id'].')</font></td>';
        }else{
            echo '<td> -- </td>';
        }
        echo '<td>' . $value['xm'] . '</td>';
        echo '<td>' . $value['tel'] . '</td>';
        if($value['status'] == 1){
            echo '<td><font color="#f00">' . $Lang['shenqing_status_1'] . '</font></td>';
        }else if($value['status'] == 2){
            echo '<td><font color="#0a9409">' . $Lang['shenqing_status_2'] . '</font></td>';
        }else if($value['status'] == 3){
            echo '<td><font color="#f00">' . $Lang['shenqing_status_3'] . '</font></td>';
        }else if($value['status'] == 4){
            echo '<td><font color="#f00">--</font></td>';
            //echo '<td><font color="#f00">' . $Lang['shenqing_status_4'] . '</font></td>';
        }
        echo '<td>' . dgmdate($value['add_time'], "Y-m-d H:i", $tomSysOffset) . '</td>';
        echo '<td>';
        echo '<a href="javascript:void(0);" onClick="handle_confirm(\''.$modBaseUrl.'&act=succ&id='.$value['id'].'&formhash='.FORMHASH.'\');">' . $Lang['shenqing_status_2']. '</a>&nbsp;|&nbsp;';
        echo '<a href="'.$modBaseUrl.'&act=fail&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['shenqing_status_3']. '</a>';
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
  var r = confirm("{$Lang['makesure_shenqing_hehuoren_msg']}")
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
    
    tomshownavli($Lang['shenqing_list_title'],$modBaseUrl,true);
    
    tomshownavfooter();
}