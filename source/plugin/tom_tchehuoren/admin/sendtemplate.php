<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$modBaseUrl = $adminBaseUrl.'&tmod=sendtemplate';
$modListUrl = $adminListUrl.'&tmod=sendtemplate';
$modFromUrl = $adminFromUrl.'&tmod=sendtemplate';

if($_GET['act'] == 'send' && $_GET['formhash'] == FORMHASH){
    $content = isset($_GET['content'])? addslashes($_GET['content']):'';
    $link    = isset($_GET['link'])? addslashes($_GET['link']):'';
    
    $insertData = array();
    $insertData['content']  = $content;
    $insertData['link']     = $link;
    $insertData['add_time'] = TIMESTAMP;
    C::t('#tom_tchehuoren#tom_tchehuoren_tz')->insert($insertData);
    $tz_id = C::t('#tom_tchehuoren#tom_tchehuoren_tz')->insert_id();
    
    $tchehuorenList = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_all_list(' AND status=1 ', 'ORDER BY id ASC', 0, 10000);
    
    if(is_array($tchehuorenList) && !empty($tchehuorenList)){
        foreach($tchehuorenList as $key => $value){
            if(!empty($value['openid'])){
                $access_token = $weixinClass->get_access_token();
                if($access_token){
                    $templateSmsClass = new templateSms($access_token, $link);
                    $smsData = array(
                        'first'         => $content,
                        'keyword1'      => $tchehuorenConfig['plugin_name'],
                        'keyword2'      => dgmdate(TIMESTAMP,"Y-m-d H:i:s",$tomSysOffset),
                        'remark'        => ''
                    );
                    if(!empty($tchehuorenConfig['template_id'])){
                        $template_id = $tchehuorenConfig['template_id'];
                    }else{
                        $template_id = $tongchengConfig['template_id'];
                    }
                    @$r = $templateSmsClass->sendSms01($value['openid'], $template_id, $smsData);

                    if($r){
                        $insertData = array();
                        $insertData['tz_id']        = $tz_id;
                        $insertData['hehuoren_id']  = $value['id'];
                        $insertData['log_status']   = 2;
                        $insertData['log_time']     = TIMESTAMP;
                        C::t('#tom_tchehuoren#tom_tchehuoren_tz_log')->insert($insertData);

                    }else{
                        $insertData = array();
                        $insertData['tz_id']        = $tz_id;
                        $insertData['hehuoren_id']  = $value['id'];
                        $insertData['log_status']   = 1;
                        $insertData['log_time']     = TIMESTAMP;
                        C::t('#tom_tchehuoren#tom_tchehuoren_tz_log')->insert($insertData);
                    }
                }
                
            }else{
                $insertData = array();
                $insertData['tz_id']        = $tz_id;
                $insertData['hehuoren_id']  = $value['id'];
                $insertData['log_status']   = 1;
                $insertData['log_time']     = TIMESTAMP;
                C::t('#tom_tchehuoren#tom_tchehuoren_tz_log')->insert($insertData);
            }
            
            if(empty($link)){
                $linkHtm = '';
            }else{
                $linkHtm = '<br/><a href="'.$link.'">'.$Lang['click_look'].'</a>';
            }
            
            $insertData = array();
            $insertData['user_id']      = $value['user_id'];
            $insertData['type']         = 1;
            $insertData['content']      = '<font color="#238206">'.$tchehuorenConfig['plugin_name'].'</font><br/>'.$content.'<br/>'.dgmdate(TIMESTAMP,"Y-m-d H:i:s",$tomSysOffset).$linkHtm;
            $insertData['is_read']      = 0;
            $insertData['tz_time']      = TIMESTAMP;
            C::t('#tom_tongcheng#tom_tongcheng_tz')->insert($insertData);
        }
    }
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
}else if($_GET['act'] == 'sendDetails' && $_GET['formhash'] == FORMHASH){
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $tz_id = isset($_GET['id'])? intval($_GET['id']):0;
    
    $pagesize = 30;
    $start = ($page-1)*$pagesize;
    $count = C::t('#tom_tchehuoren#tom_tchehuoren_tz_log')->fetch_all_count("AND tz_id = {$tz_id}");
    $tzlogList = C::t('#tom_tchehuoren#tom_tchehuoren_tz_log')->fetch_all_list("AND tz_id = {$tz_id}"," ORDER BY log_time DESC,id DESC ",$start,$pagesize);
    
    __create_nav_html();
    showtableheader();
    echo '<tr class="header">';
    echo '<th> ID </th>';
    echo '<th>' . $Lang['sendtemplate_log_hehuoren'] . '</th>';
    echo '<th>' . $Lang['sendtemplate_log_status'] . '</th>';
    echo '<th>' . $Lang['sendtemplate_log_time'] . '</th>';
    echo '</tr>';
    
    $i = 1;
    foreach ($tzlogList as $key => $value) {
        $tchehuorenInfo = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_by_id($value['hehuoren_id']);
        
        echo '<tr>';
        echo '<td>' . $value['id'] . '</td>';
        echo '<td>'. $tchehuorenInfo['xm'] .'</td>';
        if($value['log_status'] == 1){
            echo '<td><font color="#f00">' . $Lang['sendtemplate_log_status_1'] . '</font></td>';
        }else if($value['log_status'] == 2){
            echo '<td><font color="#0a9409">' . $Lang['sendtemplate_log_status_2'] . '</font></td>';
        }else{
            echo '<td> -- </td>';
        }
        echo '<td>' . dgmdate($value['log_time'], "Y-m-d H:i", $tomSysOffset). '</td>';
        echo '</tr>';
        $i++;
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBaseUrl.'&act=sendDetails&id='.$tz_id.'&formhash='.FORMHASH);
    showsubmit('', '', '', '', $multi, false);
    
}else{
    
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    
    $pagesize = 30;
    $start = ($page-1)*$pagesize;
    $count = C::t('#tom_tchehuoren#tom_tchehuoren_tz')->fetch_all_count("");
    $tzList = C::t('#tom_tchehuoren#tom_tchehuoren_tz')->fetch_all_list(""," ORDER BY add_time DESC,id DESC ",$start,$pagesize);
    
    showformheader($modFromUrl.'&act=send&formhash='.FORMHASH);
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['sendtemplate_send_title'] . '</th></tr>';
    tomshowsetting(true,array('title'=>$Lang['sendtemplate_template_text'],'name'=>'content','value'=>'','msg'=>$Lang['sendtemplate_template_text_msg']),"textarea");
    tomshowsetting(true,array('title'=>$Lang['sendtemplate_template_link'],'name'=>'link','value'=>'','msg'=>$Lang['sendtemplate_template_link_msg']),"input");
    showsubmit('submit', 'submit');
    showtablefooter();
    showformfooter();
    
    __create_nav_html();
    showtableheader();
    echo '<tr class="header">';
    echo '<th> ID </th>';
    echo '<th>' . $Lang['sendtemplate_content'] . '</th>';
    echo '<th>' . $Lang['sendtemplate_link'] . '</th>';
    echo '<th>' . $Lang['sendtemplate_add_time'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    
    $i = 1;
    foreach ($tzList as $key => $value) {
        
        echo '<tr>';
        echo '<td>' . $value['id'] . '</td>';
        echo '<td>' . $value['content'] . '</td>';
        echo '<td>' . $value['link'] . '</td>';
        echo '<td>' . dgmdate($value['add_time'], "Y-m-d H:i", $tomSysOffset). '</td>';
        echo '<td>';
        echo '<a href="'.$modBaseUrl.'&act=sendDetails&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['sendtemplate_log_list_title']. '</a>';
        echo '</td>';
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
    if($_GET['act'] == 'sendDetails'){
        tomshownavli($Lang['sendtemplate_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['sendtemplate_log_list_title'],"",true);
    }else{
        tomshownavli($Lang['sendtemplate_list_title'],$modBaseUrl,true);
    }
    tomshownavfooter();
}
