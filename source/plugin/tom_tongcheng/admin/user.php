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

if($_GET['act'] == 'moneylog'){
    
    $user_id = intval($_GET['user_id'])>0?intval($_GET['user_id']):0;
    
    $userInfo = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($user_id);
    
    tomshownavheader();
    tomshownavli($userInfo['nickname'],"",true);
    tomshownavli(' > '.$Lang['moneylog_list_title'],"",true);
    tomshownavfooter();
    
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $pagesize = 100;
    $start = ($page-1)*$pagesize;
    $count = C::t('#tom_tongcheng#tom_tongcheng_money_log')->fetch_all_count(" AND user_id={$user_id} ");
    $moneyLogList = C::t('#tom_tongcheng#tom_tongcheng_money_log')->fetch_all_list(" AND user_id={$user_id} "," ORDER BY id DESC ",$start,$pagesize);
    
    showtableheader();
    echo '<tr class="header">';
    echo '<th>' . $Lang['moneylog_tag'] . '</th>';
    echo '<th>' . $Lang['moneylog_change_money'] . '</th>';
    echo '<th>' . $Lang['moneylog_old_money'] . '</th>';
    echo '<th>' . $Lang['moneylog_beizu'] . '</th>';
    echo '<th>IP</th>';
    echo '<th>' . $Lang['moneylog_log_time'] . '</th>';
    echo '</tr>';
    
    $i = 1;
    foreach ($moneyLogList as $key => $value) {
        
        echo '<tr>';
        echo '<td>' . $value['tag'] . '</td>';
        if($value['type_id'] == 1){
            echo '<td><font color="#fd0d0d">-' . $value['change_money'] . '</font></td>';
        }else{
            echo '<td><font color="#238206">+' . $value['change_money'] . '</font></td>';
        }
        
        echo '<td><font color="#8e8e8e">' . $value['old_money'] . '</font></td>';
        echo '<td>';
        if($value['type_id'] == 1){
            $tixianInfo = C::t('#tom_tongcheng#tom_tongcheng_money_tixian')->fetch_by_id($value['tixian_id']);
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
    $multi = multi($count, $pagesize, $page, $modBaseUrl."&act=moneylog&user_id=".$user_id);	
    showsubmit('', '', '', '', $multi, false);
    
}else if($act == 'addqunfa'){
    
    $type   = isset($_GET['type'])? intval($_GET['type']):1;
    
    if(submitcheck('submit')){
        
        $title      = isset($_GET['title'])? addslashes($_GET['title']):'';
        $title      = urlencode($title);
        $content    = isset($_GET['content'])? addslashes($_GET['content']):'';
        $content    = urlencode($content);
        $link       = isset($_GET['link'])? addslashes($_GET['link']):'';
        $link       = urlencode($link);
        
        $modQunfaListUrl = $modListUrl.'&act=doqunfa&type='.$type.'&title='.$title.'&content='.$content.'&link='.$link.'&formhash='.FORMHASH;
        cpmsg($Lang['qunfa_add_msg'], $modQunfaListUrl, 'loadingform');
    }else{
        
        showformheader($modFromUrl.'&act=addqunfa&formhash='.FORMHASH);
        showtableheader();
        echo '<tr><th colspan="15" class="partition">' .$Lang['user_doqunfa_title']. '</th></tr>';
        $type_item = array(1=>$Lang['user_addqunfa_type_1'],2=>$Lang['user_addqunfa_type_2'],3=>$Lang['user_addqunfa_type_3']);
        tomshowsetting(true,array('title'=>$Lang['user_addqunfa_type'],'name'=>'type','value'=>$type,'msg'=>$Lang['user_addqunfa_type_msg'],'item'=>$type_item),"radio");
        tomshowsetting(true,array('title'=>$Lang['user_addqunfa_title'],'name'=>'title','value'=>'','msg'=>$Lang['user_addqunfa_title_msg']),"input");
        tomshowsetting(true,array('title'=>$Lang['user_addqunfa_content'],'name'=>'content','value'=>'','msg'=>$Lang['user_addqunfa_content_msg']),"textarea");
        tomshowsetting(true,array('title'=>$Lang['user_addqunfa_link'],'name'=>'link','value'=>'','msg'=>$Lang['user_addqunfa_link_msg']),"input");
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
}else if($formhash == FORMHASH && $act == 'doqunfa'){
    
    $type   = isset($_GET['type'])? intval($_GET['type']):1;
    $page           = isset($_GET['page'])? intval($_GET['page']):1;
    $nextpage = $page + 1;
    
    $title      = isset($_GET['title'])? addslashes($_GET['title']):'';
    $title      = urldecode($title);
    $content    = isset($_GET['content'])? addslashes($_GET['content']):'';
    $content    = urldecode($content);
    $link       = isset($_GET['link'])? addslashes($_GET['link']):'';
    $link       = urldecode($link);
    
    $pagesize = 100;
    $start = ($page-1)*$pagesize;	
    
    $where = " AND status=1 ";
    
    $count = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_all_count($where,"","");
    $allPageNum = ceil($count/$pagesize);
    
    if($type == 1 && $count > 500){
        $allPageNum = 5;
    }
    
    if($type == 2 && $count > 1000){
        $allPageNum = 10;
    }
    
    if($page <= $allPageNum){
        
        $order = ' ORDER BY last_login_time DESC ';
        if($type == 3){
            $order = ' ORDER BY id ASC ';
        }
        
        $userList = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_all_list($where,$order,$start,$pagesize);
        
        $txt = '';
        if(!empty($title)){
            $txt.= '<font color="#238206">'.$title.'</font><br/>';
        }
        $txt.= $content;
        if(!empty($link)){
            $txt.= '<br/><a href="'.$link.'">['.lang("plugin/tom_tongcheng", "template_dianjichakan").']</a>';
        }
        
        if(is_array($userList) && !empty($userList)){
            foreach ($userList as $key => $value){
                
                $insertData = array();
                $insertData['user_id']     = $value['id'];
                $insertData['type']        = 1;
                $insertData['content']     = $txt;
                $insertData['tz_time']     = TIMESTAMP;
                $insertData['is_read']     = 0;
                C::t('#tom_tongcheng#tom_tongcheng_tz')->insert($insertData);
            }
        }
        
        $qunfa_do_msg = str_replace("{PAGES}", $page, $Lang['qunfa_do_msg']);
        $qunfa_do_msg = str_replace("{COUNT}", $allPageNum, $qunfa_do_msg);
        
        $modQunfaListUrl = $modListUrl.'&act=doqunfa&type='.$type.'&title='.$_GET['title'].'&content='.$_GET['content'].'&link='.$_GET['link'].'&page='.$nextpage.'&formhash='.FORMHASH;
        cpmsg($qunfa_do_msg, $modQunfaListUrl, 'loadingform');
        
    }else{
        cpmsg($Lang['qunfa_do_success'], $modListUrl, 'succeed');
    }
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'ok'){
    
    $updateData = array();
    $updateData['status']     = 1;
    C::t('#tom_tongcheng#tom_tongcheng_user')->update($_GET['id'],$updateData);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'fenhao'){
    
    $updateData = array();
    $updateData['status']     = 2;
    C::t('#tom_tongcheng#tom_tongcheng_user')->update($_GET['id'],$updateData);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'add_editor'){
    
    $updateData = array();
    $updateData['editor']     = 1;
    C::t('#tom_tongcheng#tom_tongcheng_user')->update($_GET['id'],$updateData);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'del_editor'){
    
    $updateData = array();
    $updateData['editor']     = 0;
    C::t('#tom_tongcheng#tom_tongcheng_user')->update($_GET['id'],$updateData);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else{
    
    $user_id = !empty($_GET['user_id'])? addslashes($_GET['user_id']):0;
    $nickname = !empty($_GET['nickname'])? addslashes($_GET['nickname']):'';
    $tel = !empty($_GET['tel'])? addslashes($_GET['tel']):'';
    $editor = !empty($_GET['editor'])? intval($_GET['editor']):0;
    $status = !empty($_GET['status'])? intval($_GET['status']):0;
    
    $where = "";
    if(!empty($user_id)){
        $where.= " AND id=$user_id ";
    }
    if(!empty($tel)){
        $where.= " AND tel='$tel' ";
    }
    if(!empty($editor)){
        $where.= " AND editor=1 ";
    }
    if(!empty($status) && $status == 2){
        $where.= " AND status=2 ";
    }
    
    $pagesize = 10;
    if(!empty($nickname)){
		$pagesize = 1000;
	}
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $start = ($page-1)*$pagesize;	
    $count = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_all_like_count($where,$nickname);
    $userList = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_all_like_list($where,"ORDER BY add_time DESC",$start,$pagesize,$nickname);
    
    $modBaseUrl = $modBaseUrl."&editor={$editor}&status={$status}";
    
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['user_help_title'] . '</th></tr>';
    echo '<tr><td  class="tipsblock" s="1"><ul id="tipslis">';
    echo '<li><font color="#fd0d0d">' . $Lang['user_help_1'] . '</font></li>';
    echo '</ul></td></tr>';
    showtablefooter();
    
    showformheader($modFromUrl.'&formhash='.FORMHASH);
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['user_search_list'] . '</th></tr>';
    echo '<tr><td width="100" align="right"><b>' . $Lang['user_id'] . '</b></td><td><input name="user_id" type="text" value="'.$user_id.'" size="40" /></td></tr>';
    echo '<tr><td width="100" align="right"><b>' . $Lang['user_nickname'] . '</b></td><td><input name="nickname" type="text" value="'.$nickname.'" size="40" /></td></tr>';
    echo '<tr><td width="100" align="right"><b>' . $Lang['user_tel'] . '</b></td><td><input name="tel" type="text" value="'.$tel.'" size="40" /></td></tr>';
    
    $editorStr = '<tr><td width="100" align="right"><b>'.$Lang['user_editor'].'</b></td>';
    $editorStr.= '<td><select style="width: 260px;" name="editor" id="editor">';
    $editorStr.=  '<option value="0">'.$Lang['user_editor'].'</option>';
    $editorStr.=  '<option value="1">'.$Lang['user_editor_1'].'</option>';
    $editorStr.= '</select></td></tr>';
    echo $editorStr;
    
    $statusStr = '<tr><td width="100" align="right"><b>'.$Lang['user_status'].'</b></td>';
    $statusStr.= '<td><select style="width: 260px;" name="status" id="status">';
    $statusStr.=  '<option value="0">'.$Lang['user_status'].'</option>';
    $statusStr.=  '<option value="2">'.$Lang['user_status_2'].'</option>';
    $statusStr.= '</select></td></tr>';
    echo $statusStr;
    
    showsubmit('submit', 'submit');
    showtablefooter();
    showformfooter();
    
    tomshownavheader();
    tomshownavli($Lang['user_doqunfa_title'],$modBaseUrl.'&act=addqunfa',false);
    tomshownavfooter();
    
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['user_list_title'] . '</th></tr>';
    echo '<tr class="header">';
    echo '<th>' . $Lang['user_id'] . '</th>';
    echo '<th>' . $Lang['user_picurl'] . '</th>';
    echo '<th>' . $Lang['user_nickname'] . '</th>';
    echo '<th>' . $Lang['user_tel'] . '</th>';
    echo '<th>' . $Lang['user_openid'] . '</th>';
    echo '<th>' . $Lang['user_tj_hehuoren'] . '</th>';
    echo '<th>' . $Lang['user_money'] . '</th>';
    echo '<th>' . $Lang['user_score'] . '</th>';
    echo '<th>' . $Lang['user_counts'] . '</th>';
    echo '<th>' . $Lang['user_editor'] . '</th>';
    echo '<th>' . $Lang['user_majia'] . '</th>';
    echo '<th>' . $Lang['user_status'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    foreach ($userList as $key => $value){
        $userCountTmp        = C::t('#tom_tongcheng#tom_tongcheng')->fetch_all_count(" AND user_id={$value['id']} ");
        $pinglunCountTmp     = C::t('#tom_tongcheng#tom_tongcheng_pinglun')->fetch_all_count(" AND user_id={$value['id']} ");
        $pmCountTmp          = C::t('#tom_tongcheng#tom_tongcheng_pm_message')->fetch_all_count(" AND user_id={$value['id']} ");
        
        if($value['tj_hehuoren_id'] > 0){
            $tchehuorenInfoTmp = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_by_id($value['tj_hehuoren_id']);
            $tjHehuoren = '<font color="#0a9409">'.$tchehuorenInfoTmp['xm'].'('.$tchehuorenInfoTmp['id'].')</font>';
        }else{
            $tjHehuoren = '--';
        }
            
        echo '<tr>';
        echo '<td>'.$value['id'].'</td>';
        echo '<td><img src="'.$value['picurl'].'" width="40" /></td>';
        echo '<td>'.$value['nickname'].'</td>';
        echo '<td>'.$value['tel'].'</td>';
        echo '<td>'.$value['openid'].'</td>';
        echo '<td>'.$tjHehuoren.'</td>';
        echo '<td>'.$value['money'].'</td>';
        echo '<td>'.$value['score'].'</td>';
        echo '<td>';
        echo $Lang['user_num'] .'<font color="#f00">' . $userCountTmp . '</font>&nbsp;<a href="'.$adminBaseUrl.'&tmod=index&user_id='.$value['id'].'"><font color="#928c8c">(' . $Lang['user_chakan'] . ')</font></a><br/>';
        echo $Lang['user_pinglun'] .'<font color="#f00">' . $pinglunCountTmp . '</font>&nbsp;<a href="'.$adminBaseUrl.'&tmod=pinglun&user_id='.$value['id'].'"><font color="#928c8c">(' . $Lang['user_chakan'] . ')</font></a><br/>';
        echo $Lang['user_pm'] .'<font color="#f00">' . $pmCountTmp . '</font>&nbsp;<a href="'.$adminBaseUrl.'&tmod=pmMessage&user_id='.$value['id'].'"><font color="#928c8c">(' . $Lang['user_chakan'] . ')</font></a><br/>';
        echo '</td>';
        if($value['editor'] == 1){
            echo '<td><font color="#0a9409">'.$Lang['user_editor_1'].'</font></td>';
        }else{
            echo '<td><font color="#f00">'.$Lang['user_editor_0'].'</font></td>';
        }
        if($value['is_majia'] == 1){
            echo '<td><font color="#0a9409">'.$Lang['user_majia_1'].'</font></td>';
        }else{
            echo '<td><font color="#f00">'.$Lang['user_majia_0'].'</font></td>';
        }
        if($value['status'] == 1){
            echo '<td><font color="#0a9409">'.$Lang['user_status_1'].'</font></td>';
        }else{
            echo '<td><font color="#f00">'.$Lang['user_status_2'].'</font></td>';
        }
        echo '<td>';
        echo '<a href="'.$modBaseUrl.'&act=moneylog&user_id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['moneylog_list_title']. '</a>&nbsp;|&nbsp;';
        echo '<a href="'.$adminBaseUrl.'&tmod=gold&user_id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['moneylog_edit_gold']. '</a><br/>';
        if($value['editor'] == 1){
            echo '<a href="'.$modBaseUrl.'&act=del_editor&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['user_editor_btn_0']. '</a>&nbsp;|&nbsp;';
        }else{
            echo '<a href="'.$modBaseUrl.'&act=add_editor&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['user_editor_btn_1']. '</a>&nbsp;|&nbsp;';
        }
        if($value['status'] == 1){
            echo '<a href="'.$modBaseUrl.'&act=fenhao&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['user_status_2']. '</a>';
        }else{
            echo '<a href="'.$modBaseUrl.'&act=ok&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['user_status_1']. '</a>';
        }
        
        echo '</td>';
        echo '</tr>';
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBaseUrl);	
    showsubmit('', '', '', '', $multi, false);
}

