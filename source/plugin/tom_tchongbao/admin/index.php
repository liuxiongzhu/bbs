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

if($_GET['act'] == 'edit'){
    $tchongbaoInfo = C::t('#tom_tchongbao#tom_tchongbao')->fetch_by_id($_GET['id']);
    if(submitcheck('submit')){
        $updateData = array();
        $updateData = __get_post_data($tchongbaoInfo);
        C::t('#tom_tchongbao#tom_tchongbao')->update($tchongbaoInfo['id'],$updateData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        __create_nav_html();
        showformheader($modFromUrl.'&act=edit&id='.$_GET['id'],'enctype');
        showtableheader();
        __create_info_html($tchongbaoInfo);
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'del'){
    
    C::t('#tom_tchongbao#tom_tchongbao')->delete_by_id($_GET['id']);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');

}else{
    
    $csstr = <<<EOF
<style type="text/css">
.tc_content_box_handle li{ list-style-type: none; height: 25px; line-height: 25px;}
.tc_content_box_handle li a{ border: 1px solid #d6d4d3;padding: 3px 10px;color: #6a6d6a; }
.tc_content_box_handle li a:hover{color: #F75000;border: 1px solid #F75000;}
</style>
EOF;
    echo $csstr;
    
    $site_id    = isset($_GET['site_id'])? intval($_GET['site_id']):0;
    $page       = intval($_GET['page'])>0? intval($_GET['page']):1;
    
    $where = " AND pay_status = 2 ";
    if(!empty($site_id)){
        $where.= " AND site_id={$site_id} ";
    }
    
    $pagesize = 15;
    $start = ($page-1)*$pagesize;
    $count      = C::t('#tom_tchongbao#tom_tchongbao')->fetch_all_count("{$where}");
    $tchongbaoList = C::t('#tom_tchongbao#tom_tchongbao')->fetch_all_list("{$where}"," ORDER BY id DESC ",$start,$pagesize);
    
    showtableheader();
    $Lang['tchongbao_help_1']  = str_replace("{SITEURL}", $_G['siteurl'], $Lang['tchongbao_help_1']);
    $Lang['tchongbao_help_2']  = str_replace("{SITEURL}", $_G['siteurl'], $Lang['tchongbao_help_2']);
    echo '<tr><th colspan="15" class="partition">' . $Lang['tchongbao_help_title'] . '</th></tr>';
    echo '<tr><td  class="tipsblock" s="1"><ul id="tipslis">';
    echo '<li>' . $Lang['tchongbao_help_1'] . '</li>';
    echo '<li>' . $Lang['tchongbao_help_2'] . '</li>';
    echo '</ul></td></tr>';
    showtablefooter();
    
    $modBasePageUrl = $modBaseUrl."&site_id={$site_id}";
    
    $site_one_selected = '';
    if($site_id == 1){
        $site_one_selected = 'selected';
    }
    
    showformheader($modFromUrl.'&formhash='.FORMHASH);
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['index_search_list'] . '</th></tr>';
    $sitesList = C::t('#tom_tongcheng#tom_tongcheng_sites')->fetch_all_list(" "," ORDER BY id DESC ",0,100);
    $sitesStr = '<tr><td width="100" align="right"><b>'.$Lang['sites_title'].'</b></td>';
    $sitesStr.= '<td><select style="width: 260px;" name="site_id" id="site_id">';
    $sitesStr.=  '<option value="0">'.$Lang['sites_all'].'</option>';
    $sitesStr.=  '<option value="1" '.$site_one_selected.'>'.$Lang['sites_one'].'</option>';
    foreach ($sitesList as $key => $value){
        if($value['id'] == $site_id){
            $sitesStr.=  '<option value="'.$value['id'].'" selected>'.$value['name'].'</option>';
        }else{
            $sitesStr.=  '<option value="'.$value['id'].'">'.$value['name'].'</option>';
        }
    }
    $sitesStr.= '</select></td></tr>';
    echo $sitesStr;
    showsubmit('submit', 'submit');
    showtablefooter();
    showformfooter();

    __create_nav_html();
    showtableheader();
    echo '<tr class="header">';
    echo '<th> ID </th>';
    echo '<th>' . $Lang['tchongbao_site'] . ' </th>';
    echo '<th>' . $Lang['tchongbao_tongcheng'] . ' </th>';
    echo '<th>' . $Lang['tchongbao_tcshop'] . ' </th>';
    echo '<th>' . $Lang['tchongbao_user_name'] . '</th>';
    echo '<th>' . $Lang['tchongbao_user_avatar'] . '</th>';
    echo '<th>' . $Lang['tchongbao_all_money'] . '</th>';
    echo '<th>' . $Lang['tchongbao_sx_money'] . '</th>';
    echo '<th>' . $Lang['tchongbao_money'] . '</th>';
    echo '<th>' . $Lang['tchongbao_hb_count'] . '</th>';
    echo '<th>' . $Lang['tchongbao_fenpei_status'] . '</th>';
    echo '<th>' . $Lang['tchongbao_open_kouling'] . '</th>';
    echo '<th>' . $Lang['tchongbao_kouling'] . '</th>';
    echo '<th>' . $Lang['tchongbao_pay_status'] . '</th>';
    echo '<th>' . $Lang['tchongbao_only_show'] . '</th>';
    echo '<th>' . $Lang['tchongbao_stauts'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    
    $i = 1;
    foreach ($tchongbaoList as $key => $value) {
        $tongchengInfoTmp = C::t('#tom_tongcheng#tom_tongcheng')->fetch_by_id($value['tongcheng_id']);
        $siteInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_sites')->fetch_by_id($value['site_id']);
        $userInfoTmp = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($value['user_id']);
        
        echo '<tr style="border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #70b4e6;">';
        echo '<td>'.$value['id'].'</td>';
        if($value['site_id'] == 1){
            echo '<td><font color="#0a9409">' . $Lang['tchongbao_site_1']. '</font></td>';
        }else{
            echo '<td><font color="#0a9409">' . $siteInfoTmp['name']. '</font></td>';
        }
        echo '<td>' . $value['tongcheng_id'] . '</td>';
        echo '<td>' . $value['tcshop_id'] . '</td>';
        echo '<td>' . $userInfoTmp['nickname'] . '</td>';
        echo '<td><img width="40" height="40" src="' . $userInfoTmp['picurl'] . '"/></td>';
        echo '<td>' . $value['all_money'] . '</td>';
        echo '<td>' . $value['sx_money'] . '</td>';
        echo '<td>' . $value['money'] . '</td>';
        echo '<td>' . $value['hb_count'] . '</td>';
        if($value['fenpei_status'] == 1){
            echo '<td><font color="#0a9409">' . $Lang['tchongbao_fenpei_status_1'] . '</font></td>';
        }else if($value['fenpei_status'] == 2){
            echo '<td><font color="#0a9409">' . $Lang['tchongbao_fenpei_status_2'] . '</font></td>';
        }else{
            echo '<td><font color="#0a9409"> -- </font></td>';
        }
        if($value['open_kouling'] == 1){
            echo '<td><font color="#238206">' . $Lang['tchongbao_open_kouling_1'] . '</font></td>';
        }else if($value['open_kouling'] == 2){
            echo '<td><font color="#fd0d0d">' . $Lang['tchongbao_open_kouling_2'] . '</font></td>';
        }else{
            echo '<td><font color="#fd0d0d"> -- </font></td>';
        }
        echo '<td><font color="#0a9409">' . $value['kouling'] . '</font></td>';
        if($value['pay_status'] == 2){
            echo '<td><font color="0a9409">' . $Lang['tchongbao_pay_status_2']. '</font></td>';
        }else{
            echo '<td><font color="#f00">' . $Lang['tchongbao_pay_status_1']. '</font></td>';
        }
        if($value['only_show'] == 1){
            echo '<td><font color="0a9409">' . $Lang['tchongbao_only_show_1']. '</font></td>';
        }else{
            echo '<td><font color="#f00">' . $Lang['tchongbao_only_show_2']. '</font></td>';
        }
        if($value['status'] == 1){
            echo '<td><font color="#0a9409">' . $Lang['tchongbao_status_1']. '</font></td>';
        }else{
            echo '<td><font color="#f00">' . $Lang['tchongbao_status_2']. '</font></td>';
        }
        echo '<td width="120"><div class="tc_content_box_handle"><ul>';
        echo '<li><a href="'.$adminBaseUrl.'&tmod=log&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['tchongbao_log']. '</a></li>';
        echo '<li><a href="javascript:void(0);" onclick="del_confirm(\''.$modBaseUrl.'&act=del&id='.$value['id'].'&formhash='.FORMHASH.'\');">' . $Lang['delete'] . '</a></li>';
        
        if($value['tongcheng_id'] > 0){
            echo '<li><a target="_blank" href="'.$_G['siteurl'].'plugin.php?id=tom_tchongbao:ajax&act=nitice_sms_hb_run&site='.$value['site_id'].'&do_admin=1&tongcheng_id='.$value['tongcheng_id'].'&hongbao_id='.$value['id'].'">' . $Lang['send_do'] . '</a></li>';
        }
        if($value['tcshop_id'] > 0){
            echo '<li><a target="_blank" href="'.$_G['siteurl'].'plugin.php?id=tom_tchongbao:ajax&act=nitice_sms_tcshop_hb_run&site='.$value['site_id'].'&do_admin=1&tcshop_id='.$value['tcshop_id'].'&hongbao_id='.$value['id'].'">' . $Lang['send_do'] . '</a></li>';
        }
        echo '<li><a href="'.$modBaseUrl.'&act=edit&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['tchongbao_edit']. '</a></li>';
        echo '</ul></div></td>';
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
    
    $open_kouling       = isset($_GET['open_kouling'])? intval($_GET['open_kouling']):2;
    $kouling            = isset($_GET['kouling'])? addslashes($_GET['kouling']):'';
    $kouling_pormpt     = isset($_GET['kouling_pormpt'])? addslashes($_GET['kouling_pormpt']):'';

    
    $data['open_kouling']         = $open_kouling;
    $data['kouling']              = $kouling;
    $data['kouling_pormpt']       = $kouling_pormpt;
    
    return $data;
}

function __create_info_html($infoArr = array()){
    global $Lang;
    $options = array(
        'open_kouling'    => 2,
        'kouling'         => '',
        'kouling_pormpt'  => '',
    );
    $options = array_merge($options, $infoArr);
    
    $open_koulingitem = array(1=>$Lang['tchongbao_open_kouling_1'],2=>$Lang['tchongbao_open_kouling_2']);
    tomshowsetting(true,array('title'=>$Lang['tchongbao_open_kouling'],'name'=>'open_kouling','value'=>$options['open_kouling'],'msg'=>$Lang['tchongbao_open_kouling_msg'],'item'=>$open_koulingitem),"radio");
    tomshowsetting(true,array('title'=>$Lang['tchongbao_kouling'],'name'=>'kouling','value'=>$options['kouling'],'msg'=>$Lang['tchongbao_kouling_msg']),"input");
    tomshowsetting(true,array('title'=>$Lang['tchongbao_kouling_pormpt'],'name'=>'kouling_pormpt','value'=>$options['kouling_pormpt'],'msg'=>$Lang['tchongbao_kouling_pormpt_msg']),"textarea");
    
    return;
}

function __create_nav_html($infoArr = array()){
    global $Lang,$modBaseUrl,$adminBaseUrl;
    tomshownavheader();
    if($_GET['act'] == 'edit'){
        tomshownavli($Lang['tchongbao_list_title'],$modBaseUrl,true);
        tomshownavli($Lang['tchongbao_edit'],'',false);
    }else{
        tomshownavli($Lang['tchongbao_list_title'],$modBaseUrl,true);
    }
    tomshownavfooter();
}


