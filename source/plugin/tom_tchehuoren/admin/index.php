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

$get_list_url_value = get_list_url("tom_tchehuoren_admin_user_list");
if($get_list_url_value){
    $modListUrl = $get_list_url_value;
}

if($_GET['act'] == 'edit'){
    
    $hehuorenInfo = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_by_id($_GET['id']);
    if(submitcheck('submit')){
        $updateData = array();
        $updateData = __get_post_data($hehuorenInfo);
        C::t('#tom_tchehuoren#tom_tchehuoren')->update($hehuorenInfo['id'],$updateData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        tomloadcalendarjs();
        loadeditorjs();
        __create_nav_html();
        showformheader($modFromUrl.'&act=edit&id='.$_GET['id'],'enctype');
        showtableheader();
        __create_info_html($hehuorenInfo);
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
    
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'jiefeng'){
    
    $updateData = array();
    $updateData['status'] = 1;
    C::t('#tom_tchehuoren#tom_tchehuoren')->update($_GET['id'], $updateData);
    
    $hehuorenInfo = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_by_id($_GET['id']);
    $tcUserInfo = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($hehuorenInfo['user_id']);

    $jiefeng = $Lang['index_jiefeng'];

    $access_token = $weixinClass->get_access_token();
    if($access_token && !empty($tcUserInfo['openid'])){
        $templateSmsClass = new templateSms($access_token, $_G['siteurl']."plugin.php?id=tom_tchehuoren&mod=index");
        $smsData = array(
            'first'         => $jiefeng,
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
    $insertData['content']      = '<font color="#238206">'.$tchehuorenConfig['plugin_name'].'</font><br/>'.$jiefeng.'<br/>'.dgmdate(TIMESTAMP,"Y-m-d H:i:s",$tomSysOffset);
    $insertData['is_read']      = 0;
    $insertData['tz_time']      = TIMESTAMP;
    C::t('#tom_tongcheng#tom_tongcheng_tz')->insert($insertData);
    
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'fenghao'){
    
    $hehuorenInfo = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_by_id($_GET['id']);
    if(submitcheck('submit')){
        $text = isset($_GET['text'])? addslashes($_GET['text']):'';
        
        $tcUserInfo = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($hehuorenInfo['user_id']);
        
        $updateData = array();
        $updateData['status'] = 2;
        C::t('#tom_tchehuoren#tom_tchehuoren')->update($_GET['id'], $updateData);
        
        $fenghao = $Lang['index_fenghao'];
        
        $access_token = $weixinClass->get_access_token();
        if($access_token && !empty($tcUserInfo['openid'])){
            $templateSmsClass = new templateSms($access_token, $_G['siteurl']."plugin.php?id=tom_tchehuoren&mod=index");
            $smsData = array(
                'first'         => $fenghao,
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
        $insertData['content']      = '<font color="#238206">'.$tchehuorenConfig['plugin_name'].'</font><br/>'.$fenghao.'<br/>'.$Lang['index_status_2_yuanying'].$text.'<br/>'.dgmdate(TIMESTAMP,"Y-m-d H:i:s",$tomSysOffset);
        $insertData['is_read']      = 0;
        $insertData['tz_time']      = TIMESTAMP;
        C::t('#tom_tongcheng#tom_tongcheng_tz')->insert($insertData);
        
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        tomloadcalendarjs();
        loadeditorjs();
        __create_nav_html();
        showformheader($modFromUrl.'&act=fenghao&id='.$_GET['id'],'enctype');
        showtableheader();
        tomshowsetting(true,array('title'=>$Lang['index_status_2_yuanying'],'name'=>'text','value'=>'','msg'=>$Lang['index_status_2_yuanying_msg']),"textarea");
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
    
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'del'){
    
    $tchehuorenInfo = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_by_id($_GET['id']);
    
    C::t('#tom_tchehuoren#tom_tchehuoren')->delete_by_id($_GET['id']);
    C::t('#tom_tchehuoren#tom_tchehuoren_shenqing')->delete_by_user_id($tchehuorenInfo['user_id']);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'shouyi'){
    
    $page           = intval($_GET['page'])>0? intval($_GET['page']):1;
    
    $pagesize = 30;
    $start = ($page-1)*$pagesize;
    $count = C::t('#tom_tchehuoren#tom_tchehuoren_shouyi')->fetch_all_count("AND hehuoren_id = {$_GET['id']} AND shouyi_status in(1,2) ");
    $shouyiList = C::t('#tom_tchehuoren#tom_tchehuoren_shouyi')->fetch_all_list("AND hehuoren_id = {$_GET['id']} AND shouyi_status in(1,2) "," ORDER BY add_time DESC,id DESC ",$start,$pagesize);
    $tchehuorenInfo = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_by_id($_GET['id']);
    
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' .$tchehuorenInfo['xm'] .'&nbsp;&gt;&nbsp;'. $Lang['index_shouyi'] . '</th></tr>';
    echo '<tr class="header">';
    echo '<th> ID </th>';
    echo '<th>' . $Lang['index_shouyi_type'] . '</th>';
    echo '<th>' . $Lang['index_shouyi_shouyi_price'] . '</th>';
    echo '<th>' . $Lang['index_shouyi_xiaodi'] . '</th>';
    echo '<th>' . $Lang['index_shouyi_add_time'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    
    $i = 1;
    foreach ($shouyiList as $key => $value) {
        
        $xiaodiInfo = C::t("#tom_tchehuoren#tom_tchehuoren")->fetch_by_id($value['child_hehuoren_id']);
        
        echo '<tr>';
        echo '<td>' . $value['id'] . '</td>';
        echo '<td>' . $value['type'] . '</td>';
        echo '<td>' . $value['shouyi_price'] . '</td>';
        if($xiaodiInfo){
            echo '<td><a href="javascript:;">' . $xiaodiInfo['xm'].'(' .$xiaodiInfo['id']. ')</a></td>';
        }else{
            echo '<td> -- </td>';
        }
        echo '<td>' . dgmdate($value['add_time'], "Y-m-d H:i", $tomSysOffset) . '</td>';
        echo '<td>';
        echo '<a href="'.$modBaseUrl.'&act=shouyiDetails&id='.$value['id'].'&formhash='.FORMHASH.'" target="_blank">' . $Lang['details']. '</a>';
        echo '</td>';
        echo '</tr>';
        $i++;
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBaseUrl.'&id='.$_GET['id'].'&act=shouyi&formhash='.FORMHASH);
    showsubmit('', '', '', '', $multi, false);
    
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'shouyiDetails'){
    
    $shouyiInfo = C::t('#tom_tchehuoren#tom_tchehuoren_shouyi')->fetch_by_id($_GET['id']);
    $tchehuorenInfo = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_by_id($shouyiInfo['hehuoren_id']);
    $lyUserInfo = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($shouyiInfo['ly_user_id']);
    $xiaodiInfo = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_by_id($shouyiInfo['child_hehuoren_id']);
    
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' .$tchehuorenInfo['xm'] .'&nbsp;&gt;&nbsp;'. $Lang['index_shouyi'] . '</th></tr>';
    echo '<tr>';
    echo '<th width="20%"><b>' . $Lang['index_shouyi_laiyuan_d'] . '</b></th><td>' . $lyUserInfo['nickname'] .'(' .$lyUserInfo['id']. ')</td>';
    echo '</tr>';
    echo '<tr>';
    if($shouyiInfo['child_hehuoren_id'] > 0){
        echo '<th><b>' . $Lang['index_shouyi_child_d'] . '</b></th><td>' . $xiaodiInfo['xm'] .'(' .$xiaodiInfo['id']. ')</td>';
    }else{
        echo '<th><b>' . $Lang['index_shouyi_child_d'] . '</b></th><td> -- </td>';
    }
    echo '</tr>';
    echo '<tr>';
    echo '<th><b>' . $Lang['index_shouyi_type_d'] . '</b></th><td>' . $shouyiInfo['type'] .'</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><b>' . $Lang['index_shouyi_shouyi_price_d'] . '</b></th><td>' . $shouyiInfo['shouyi_price'] .'</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><b>' . $Lang['index_shouyi_add_time_d'] . '</b></th><td>' . dgmdate($shouyiInfo['add_time'], "Y-m-d H:i", $tomSysOffset) .'</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><b>' . $Lang['index_shouyi_content_d'] . '</b></th><td>' . $shouyiInfo['content'] .'</td>';
    echo '</tr>';
    echo '</tr>';
    
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'kaohe'){
    
    $page           = intval($_GET['page'])>0? intval($_GET['page']):1;
    
    $pagesize = 30;
    $start = ($page-1)*$pagesize;	
    $count = C::t('#tom_tchehuoren#tom_tchehuoren_kaohe_log')->fetch_all_count("AND hehuoren_id = {$_GET['id']}");
    $kaoheList = C::t('#tom_tchehuoren#tom_tchehuoren_kaohe_log')->fetch_all_list("AND hehuoren_id = {$_GET['id']}"," ORDER BY log_time DESC,id DESC ",$start,$pagesize);
    $tchehuorenInfo = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_by_id($_GET['id']);
    
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' .$tchehuorenInfo['xm'] .'&nbsp;&gt;&nbsp;'. $Lang['index_kaohe'] . '</th></tr>';
    echo '<tr class="header">';
    echo '<th> ID </th>';
    echo '<th>' . $Lang['index_kaohe_text'] . '</th>';
    echo '<th>' . $Lang['index_kaohe_status'] . '</th>';
    echo '<th>' . $Lang['index_kaohe_log_time'] . '</th>';
    echo '</tr>';
    
    $i = 1;
    foreach ($kaoheList as $key => $value) {
        
        echo '<tr>';
        echo '<td>' . $value['id'] . '</td>';
        echo '<td width="50%">' . $value['text'] . '</td>';
        if($value['log_status'] == 1){
            echo '<td><font color="#0a9409">' . $Lang['index_kaohe_status_1'] . '</font></td>';
        }else if($value['log_status'] == 2){
            echo '<td><font color="#f00">' . $Lang['index_kaohe_status_2'] . '</font></td>';
        }else{
            echo '<td> -- </td>';
        }
        echo '<td>' . dgmdate($value['log_time'], "Y-m-d H:i", $tomSysOffset) . '</td>';
        echo '</tr>';
        $i++;
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBaseUrl.'&id='.$_GET['id'].'&act=kaohe&formhash='.FORMHASH);
    showsubmit('', '', '', '', $multi, false);
    
}else{
    set_list_url("tom_tchehuoren_admin_user_list");
    
    $page           = intval($_GET['page'])>0? intval($_GET['page']):1;
    $hehuoren_id    = isset($_GET['hehuoren_id']) ? intval($_GET['hehuoren_id']):0;
    $xm             = isset($_GET['xm'])? addslashes($_GET['xm']):'';
    $tel            = isset($_GET['tel'])? addslashes($_GET['tel']):'';
    
    $where = '';
    if($hehuoren_id > 0){
        $where .= " AND id = {$hehuoren_id} ";
    }
    if(!empty($xm)){
        $where .= " AND xm = '{$xm}' ";
    }
    if(!empty($tel)){
        $where .= " AND tel = '{$tel}' ";
    }
    
    $pagesize = 30;
    $start = ($page-1)*$pagesize;
    $count = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_all_count("{$where}");
    $tchehuorenList = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_all_list("{$where}"," ORDER BY add_time DESC,id DESC ",$start,$pagesize);
    
    $modBasePageUrl = $modBaseUrl."&hehuoren_id={$hehuoren_id}&xm={$xm}&tel={$tel}";
    
    showtableheader();
    $Lang['hehuoren_help_1']  = str_replace("{SITEURL}", $_G['siteurl'], $Lang['hehuoren_help_1']);
    echo '<tr><th colspan="15" class="partition">' . $Lang['hehuoren_help_title'] . '</th></tr>';
    echo '<tr><td  class="tipsblock" s="1"><ul id="tipslis">';
    echo '<li>' . $Lang['hehuoren_help_1'] . '</li>';
    echo '</ul></td></tr>';
    showtablefooter();
    
    showformheader($modFromUrl.'&formhash='.FORMHASH);
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['hehuoren_search_title'] . '</th></tr>';
    echo '<tr><td width="100" align="right"><b>'.$Lang['index_search_id'].'</b></td><td><input type="text" name="hehuoren_id" value="'.$hehuoren_id.'"></td></tr>';
    echo '<tr><td width="100" align="right"><b>'.$Lang['index_search_xm'].'</b></td><td><input type="text" name="xm" value="'.$xm.'"></td></tr>';
    echo '<tr><td width="100" align="right"><b>'.$Lang['index_search_tel'].'</b></td><td><input type="text" name="tel" value="'.$tel.'"></td></tr>';
    showsubmit('submit', 'submit');
    showtablefooter();
    showformfooter();
    
    __create_nav_html();
    showtableheader();
    echo '<tr class="header">';
    echo '<th> ID </th>';
    echo '<th>' . $Lang['index_xm'] . '</th>';
    echo '<th>' . $Lang['index_tel'] . '</th>';
    echo '<th>' . $Lang['index_tj_hehuoren'] . '</th>';
    echo '<th>' . $Lang['index_dengji'] . '</th>';
    echo '<th>' . $Lang['index_invite_code'] . '</th>';
    echo '<th>' . $Lang['index_all_money'] . '</th>';
    echo '<th>' . $Lang['index_month_money'] . '</th>';
    echo '<th>' . $Lang['index_week_money'] . '</th>';
    echo '<th>' . $Lang['index_fensi_num'] . '</th>';
    echo '<th>' . $Lang['index_status'] . '</th>';
    echo '<th>' . $Lang['index_time'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    
    $i = 1;
    foreach ($tchehuorenList as $key => $value) {
        
        $fensiUserCount = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_all_count("AND tj_hehuoren_id = {$value['id']}");
        
        $allMoney   = C::t('#tom_tchehuoren#tom_tchehuoren_shouyi')->fetch_shouyi_sum(" AND hehuoren_id = {$value['id']} ");
        $monthMoney = C::t('#tom_tchehuoren#tom_tchehuoren_shouyi')->fetch_shouyi_sum(" AND hehuoren_id = {$value['id']} AND month_time = {$nowMonthTime} ");
        $weekMoney  = C::t('#tom_tchehuoren#tom_tchehuoren_shouyi')->fetch_shouyi_sum(" AND hehuoren_id = {$value['id']} AND week_time = {$nowWeekTime} ");
        $allMoney   = number_format(floatval($allMoney), 2, '.', '');
        $monthMoney = number_format(floatval($monthMoney), 2, '.', '');
        $weekMoney  = number_format(floatval($weekMoney), 2, '.', '');
        
        if(!preg_match('/^http/', $value['picurl']) ){
            $picurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'tomwx/'.$value['picurl'];
        }else{
            $picurl = $value['picurl'];
        }
        $tjHehuorenInfo = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_by_id($value['tj_hehuoren_id']);
        $dengjiInfo = C::t("#tom_tchehuoren#tom_tchehuoren_dengji")->fetch_by_id($value['dengji_id']);
        echo '<tr>';
        echo '<td>' . $value['id'] . '</td>';
        echo '<td>' . $value['xm'] . '</td>';
        echo '<td>' . $value['tel'] . '</td>';
        if($tjHehuorenInfo){
            echo '<td><font color="#0a9409">' . $tjHehuorenInfo['xm'].'(',$tjHehuorenInfo['id'].')</font></td>';
        }else{
            echo '<td> -- </td>';
        }
        echo '<td>' . $dengjiInfo['name'] . '</td>';
        echo '<td>' . $value['invite_code'] . '</td>';
        echo '<td>' . $allMoney . '</td>';
        echo '<td>' . $monthMoney . '</td>';
        echo '<td>' . $weekMoney . '</td>';
        echo '<td><font color="#fd0d0d">' . $fensiUserCount . '</font></td>';
        if($value['status'] == 1){
            echo '<td><font color="#0a9409">'.$Lang['index_status_1'].'</font><a style="color:#f00;" href="'.$modBaseUrl.'&act=fenghao&id='.$value['id'].'&formhash='.FORMHASH.'">('.$Lang['index_status_2'].')</a></td>';
        }else{
            echo '<td><font color="#f00">'.$Lang['index_status_2'].'</font><a style="color:#0a9409;" href="'.$modBaseUrl.'&act=jiefeng&id='.$value['id'].'&formhash='.FORMHASH.'">('.$Lang['index_status_1'].')</a></td>';
        }
        echo '<td>' . dgmdate($value['add_time'], "Y-m-d H:i", $tomSysOffset) . '</td>';
        echo '<td>';
        echo '<a href="'.$modBaseUrl.'&act=edit&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['edit']. '</a>&nbsp;|&nbsp;';
        echo '<a href="'.$modBaseUrl.'&act=kaohe&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['index_kaohe']. '</a><br/>';
        echo '<a href="'.$modBaseUrl.'&act=shouyi&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['index_shouyi']. '</a>&nbsp;|&nbsp;';
        echo '<a href="javascript:void(0);" onclick="del_confirm(\''.$modBaseUrl.'&act=del&id='.$value['id'].'&formhash='.FORMHASH.'\');">' . $Lang['delete'] . '</a>';
        echo '</td>';
        echo '</tr>';
        $i++;
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBasePageUrl);
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

function __get_post_data($infoArr = array()){
    $data = array();
    
    $xm           = isset($_GET['xm'])? addslashes($_GET['xm']):'';
    $tel          = isset($_GET['tel'])? addslashes($_GET['tel']):'';
    $dengji_id    = isset($_GET['dengji_id'])? intval($_GET['dengji_id']):0;
    $kaohe_time   = isset($_GET['kaohe_time'])? strtotime($_GET['kaohe_time']):'';
    
    $data['xm']             = $xm;
    $data['tel']            = $tel;
    $data['dengji_id']      = $dengji_id;
    $data['kaohe_time']     = $kaohe_time;

    return $data;
}

function __create_info_html($infoArr = array()){
    global $Lang;
    $options = array(
        'xm'            => '',
        'tel'           => '',
        'dengji_id'     => '',
        'kaohe_time'    => time(),
    );
    $options = array_merge($options, $infoArr);
    
    $dengjiList = C::t('#tom_tchehuoren#tom_tchehuoren_dengji')->fetch_all_list(" "," ORDER BY level ASC,id ASC ", 0,3 );
    $dengjiStr = '<tr class="header"><th>'.$Lang['index_dengji_title'].'</th><th></th></tr>';
    $dengjiStr.= '<tr><td width="300"><select style="width: 260px;" name="dengji_id" id="dengji_id">';
    foreach ($dengjiList as $key => $value){
        if($value['id'] == $options['dengji_id']){
            $dengjiStr.=  '<option value="'.$value['id'].'" selected>'.$value['name'].'</option>';
        }else{
            $dengjiStr.=  '<option value="'.$value['id'].'">'.$value['name'].'</option>';
        }
    }
    $dengjiStr.= '</select></td><td></td></tr>';
    echo $dengjiStr;
    $open_item = array(1=>$Lang['open'],0=>$Lang['close']);
    tomshowsetting(true,array('title'=>$Lang['index_kaohe_time'],'name'=>'kaohe_time','value'=>$options['kaohe_time'],'msg'=>$Lang['index_kaohe_time_msg']),"calendar");
    tomshowsetting(true,array('title'=>$Lang['index_xm'],'name'=>'xm','value'=>$options['xm'],'msg'=>$Lang['index_xm_msg']),"input");
    tomshowsetting(true,array('title'=>$Lang['index_tel'],'name'=>'tel','value'=>$options['tel'],'msg'=>$Lang['index_tel_msg']),"input");
    
    return;
}

function __create_nav_html($infoArr = array()){
    global $Lang,$modBaseUrl,$adminBaseUrl;
    tomshownavheader();
    if($_GET['act'] == 'add'){
    }else if($_GET['act'] == 'edit'){
        tomshownavli($Lang['index_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['index_edit'],"",true);
    }else{
        tomshownavli($Lang['index_list_title'],$modBaseUrl,true);
        tomshownavli($Lang['problem_list_title'],$adminBaseUrl."&tmod=problem",false);
    }
    tomshownavfooter();
}