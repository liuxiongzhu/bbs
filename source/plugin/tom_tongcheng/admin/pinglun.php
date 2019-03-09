<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$modBaseUrl = $adminBaseUrl.'&tmod=pinglun'; 
$modListUrl = $adminListUrl.'&tmod=pinglun';
$modFromUrl = $adminFromUrl.'&tmod=pinglun';

$get_list_url_value = get_list_url("tom_tongcheng_admin_pinglun_list");
if($get_list_url_value){
    $modListUrl = $get_list_url_value;
}

if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'del'){
    
    C::t('#tom_tongcheng#tom_tongcheng_pinglun')->delete($_GET['id']);
    C::t('#tom_tongcheng#tom_tongcheng_pinglun_reply')->delete_pinglun_id($_GET['id']);
    
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'batch_del'){
    
    if(is_array($_GET['ids']) && !empty($_GET['ids'])){
        foreach ($_GET['ids'] as $key => $value){
            C::t('#tom_tongcheng#tom_tongcheng_pinglun')->delete($value);
            C::t('#tom_tongcheng#tom_tongcheng_pinglun_reply')->delete_pinglun_id($value);
        }
    }
    
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
}else{
    
    set_list_url("tom_tongcheng_admin_pinglun_list");
    
    $user_id  = intval($_GET['user_id'])>0? intval($_GET['user_id']):0;
    
    $whereStr = '';
    if(!empty($user_id)){
        $whereStr.= " AND user_id={$user_id} ";
    }
    
    $pagesize = 100;
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $start = ($page-1)*$pagesize;	
    $count = C::t('#tom_tongcheng#tom_tongcheng_pinglun')->fetch_all_count($whereStr);
    $pinglunList = C::t('#tom_tongcheng#tom_tongcheng_pinglun')->fetch_all_list($whereStr,"ORDER BY ping_time DESC",$start,$pagesize);
    
    $modBasePageUrl = $modBaseUrl."&user_id={$user_id}";
    
    echo '<form name="cpform2" id="cpform2" method="post" autocomplete="off" action="'.ADMINSCRIPT.'?action='.$modFromUrl.'&formhash='.FORMHASH.'" onsubmit="return batch_del();">'.
		'<input type="hidden" name="formhash" value="'.FORMHASH.'" />';
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['pinglun_list'] . '</th></tr>';
    echo '<tr class="header">';
    echo '<th> - </th>';
    echo '<th>' . $Lang['order_tongcheng'] . '</th>';
    echo '<th>' . $Lang['user_id'] . '</th>';
    echo '<th>' . $Lang['user_picurl'] . '</th>';
    echo '<th>' . $Lang['user_nickname'] . '</th>';
    echo '<th>' . $Lang['pinglun_content'] . '</th>';
    echo '<th>' . $Lang['pinglun_time'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    foreach ($pinglunList as $key => $value){
        
        $modelUrl = $adminBaseUrl.'&tmod=index';
        $tongchengInfo = C::t('#tom_tongcheng#tom_tongcheng')->fetch_by_id($value['tongcheng_id']);
        $userInfo = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($value['user_id']);

        echo '<tr style="background-color: #FCFAFA;">';
        echo '<td><input class="checkbox" type="checkbox" name="ids[]" value="' . $value['id'] . '" ></td>';
        echo '<td><a target="_blank" href="'.$modelUrl.'&tongcheng_id='.$value['tongcheng_id'].'">'.cutstr(contentFormat($tongchengInfo['content']),20,"...").'</a></td>';
        echo '<td>'.$userInfo['id'].'</td>';
        echo '<td><img src="'.$userInfo['picurl'].'" width="40" /></td>';
        echo '<td>'.$userInfo['nickname'].'</td>';
        echo '<td style="max-width: 400px;">' . $value['content'] . '</td>';
        echo '<td>' . dgmdate($value['ping_time'], 'Y-m-d H:i:s',$tomSysOffset) . '</td>';
        echo '<td>';
        echo '<a href="'.$modBaseUrl.'&act=del&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['del'] . '</a>';
        echo '</td>';
        echo '</tr>';
        
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBasePageUrl);	
    showsubmit('', '', '', '', $multi, false);
    
    $formstr = <<<EOF
        <tr>
            <td class="td25">
                <input type="checkbox" name="chkall" id="chkallFh9R" class="checkbox" onclick="checkAll('prefix', this.form, 'ids')" />
                <label for="chkallFh9R">{$Lang['checkall']}</label>
            </td>
            <td class="td25">
                <select name="act" >
                    <option value="batch_del">{$Lang['batch_del']}</option>
                </select>
            </td>
            <td colspan="15">
                <div class="fixsel"><input type="submit" class="btn" id="submit_announcesubmit" name="announcesubmit" value="{$Lang['batch_btn']}" /></div>
            </td>
        </tr>
        <script type="text/javascript">
        function batch_del(){
          var r = confirm("{$Lang['makesure_del_msg']}")
          if (r == true){
            return true;
          }else{
            return false;
          }
        }
        </script>
EOF;
        echo $formstr;
        showformfooter();
}
