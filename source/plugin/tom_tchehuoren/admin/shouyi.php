<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.net
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$modBaseUrl = $adminBaseUrl.'&tmod=shouyi';
$modListUrl = $adminListUrl.'&tmod=shouyi';
$modFromUrl = $adminFromUrl.'&tmod=shouyi';

$get_list_url_value = get_list_url("tom_admin_tchehuoren_shouyi");
if($get_list_url_value){
    $modListUrl = $get_list_url_value;
}

if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'shouyi_status'){
    
    $shouyiStatus = intval($_GET['shouyi_status']>0) ?intval($_GET['shouyi_status']):1;
    $id = intval($_GET['id']);
    $shouyiInfoTmp = C::t('#tom_tchehuoren#tom_tchehuoren_shouyi')->fetch_by_id($id);
    if($shouyiInfoTmp['shouyi_status'] == 1){
        if($shouyiStatus == 2){
            
            $tchehuorenInfo = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_by_id($shouyiInfoTmp['hehuoren_id']);
            $tcUserInfo = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($tchehuorenInfo['user_id']);

            $updateData = array();
            $updateData['shouyi_status']    = 2;
            $updateData['shouyi_time']      = TIMESTAMP;
            C::t('#tom_tchehuoren#tom_tchehuoren_shouyi')->update($id, $updateData);

            DB::query("UPDATE ".DB::table('tom_tongcheng_user')." SET money = money + {$shouyiInfoTmp['shouyi_price']} WHERE id='{$tcUserInfo['id']}'", 'UNBUFFERED');

            $insertData = array();
            $insertData['user_id']          = $tcUserInfo['id'];
            $insertData['type_id']          = 2;
            $insertData['change_money']     = $shouyiInfoTmp['shouyi_price'];
            $insertData['old_money']        = $tcUserInfo['money'];
            $insertData['tag']              = lang('plugin/tom_tongcheng', 'hehuoren_tag');
            $insertData['beizu']            = $shouyiInfoTmp['content'];
            $insertData['log_time']         = TIMESTAMP;
            C::t('#tom_tongcheng#tom_tongcheng_money_log')->insert($insertData);
        }else if($shouyiStatus == 3){
            $updateData = array();
            $updateData['shouyi_status']    = 3;
            $updateData['shouyi_time']      = TIMESTAMP;
            C::t('#tom_tchehuoren#tom_tchehuoren_shouyi')->update($id, $updateData);
        }
    }
    
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');

}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'batch_shouyi_2'){
    
    if(is_array($_GET['ids']) && !empty($_GET['ids'])){
        foreach ($_GET['ids'] as $key => $value){
            
            $id = intval($value);
            $shouyiInfoTmp = C::t('#tom_tchehuoren#tom_tchehuoren_shouyi')->fetch_by_id($id);
            if($shouyiInfoTmp['shouyi_status'] == 1){
                
                $tchehuorenInfo = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_by_id($shouyiInfoTmp['hehuoren_id']);
                $tcUserInfo = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($tchehuorenInfo['user_id']);
                
                $updateData = array();
                $updateData['shouyi_status']    = 2;
                $updateData['shouyi_time']      = TIMESTAMP;
                C::t('#tom_tchehuoren#tom_tchehuoren_shouyi')->update($id, $updateData);
                
                DB::query("UPDATE ".DB::table('tom_tongcheng_user')." SET money = money + {$shouyiInfoTmp['shouyi_price']} WHERE id='{$tcUserInfo['id']}'", 'UNBUFFERED');
    
                $insertData = array();
                $insertData['user_id']          = $tcUserInfo['id'];
                $insertData['type_id']          = 2;
                $insertData['change_money']     = $shouyiInfoTmp['shouyi_price'];
                $insertData['old_money']        = $tcUserInfo['money'];
                $insertData['tag']              = lang('plugin/tom_tongcheng', 'hehuoren_tag');
                $insertData['beizu']            = $shouyiInfoTmp['content'];
                $insertData['log_time']         = TIMESTAMP;
                C::t('#tom_tongcheng#tom_tongcheng_money_log')->insert($insertData);
            }
        }
    }
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'batch_shouyi_3'){
    
    if(is_array($_GET['ids']) && !empty($_GET['ids'])){
        foreach ($_GET['ids'] as $key => $value){
            
            $id = intval($value);
            $shouyiInfoTmp = C::t('#tom_tchehuoren#tom_tchehuoren_shouyi')->fetch_by_id($id);
            if($shouyiInfoTmp['shouyi_status'] == 1){
                
                $updateData = array();
                $updateData['shouyi_status']    = 3;
                $updateData['shouyi_time']      = TIMESTAMP;
                C::t('#tom_tchehuoren#tom_tchehuoren_shouyi')->update($id, $updateData);
            }
        }
    }
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else{
    
    set_list_url("tom_admin_tchehuoren_shouyi");
    
    $page           = intval($_GET['page'])>0? intval($_GET['page']):1;
    $shouyi_status  = isset($_GET['shouyi_status'])? intval($_GET['shouyi_status']):1;
    $hehuoren_id    = intval($_GET['hehuoren_id'])>0? intval($_GET['hehuoren_id']):0;
    $order_no       = isset($_GET['order_no'])? addslashes($_GET['order_no']):'';
    
    $shouyi_num_day = 3;
    if($tchehuorenConfig['shouyi_num_day'] > 0){
        $shouyi_num_day = $tchehuorenConfig['shouyi_num_day'];
    }
    $shouyiTime = TIMESTAMP - ($shouyi_num_day * 86400);
    
    $where = "";
    if($shouyi_status > 0){
        $where.= "AND add_time <= {$shouyiTime} AND shouyi_status={$shouyi_status} ";
    }
    if($hehuoren_id > 0){
        $where.= " AND hehuoren_id={$hehuoren_id} ";
    }
    if(!empty($order_no)){
        $where.= " AND order_no='{$order_no}' ";
    }

    $modBasePageUrl = $modBaseUrl."&shouyi_status={$shouyi_status}&hehuoren_id={$hehuoren_id}&order_no={$order_no}";
    
    $pagesize = 100;
    $start = ($page-1)*$pagesize;
    $count = C::t('#tom_tchehuoren#tom_tchehuoren_shouyi')->fetch_all_count($where);
    $shouyiList = C::t('#tom_tchehuoren#tom_tchehuoren_shouyi')->fetch_all_list($where,'ORDER BY id DESC',$start,$pagesize);
    
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['hehuoren_help_title'] . '</th></tr>';
    echo '<tr><td  class="tipsblock" s="1"><ul id="tipslis">';
    echo '<li>' . $Lang['shouyi_help_1'] . '</li>';
    echo '</ul></td></tr>';
    showtablefooter();
    
    showformheader($modFromUrl.'&formhash='.FORMHASH);
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['hehuoren_search_title'] . '</th></tr>';
    echo '<tr><td width="100" align="right"><b>' . $Lang['shouyi_order_no'] . '</b></td><td><input name="order_no" type="text" value="'.$order_no.'" size="40" /></td></tr>';
    echo '<tr><td width="100" align="right"><b>' . $Lang['shouyi_hehuoren_id'] . '</b></td><td><input name="hehuoren_id" type="text" value="'.$hehuoren_id.'" size="40" /></td></tr>';

    $status_selected_1 = $status_selected_2 = $status_selected_3 = '';
    if($shouyi_status == 1){
        $status_selected_1 = 'selected';
    }else if($shouyi_status == 2){
        $status_selected_2 = 'selected';
    }else if($shouyi_status == 3){
        $status_selected_3 = 'selected';
    }
    echo '<tr><td width="100" align="right"><b>'.$Lang['shouyi_status'].'</b></td>';
    echo '<td><select style="width: 260px;" name="shouyi_status" id="shouyi_status">';
    echo '<option value="0">'.$Lang['shouyi_all_status'].'</option>';
    echo '<option value="1" '.$status_selected_1.'>'.$Lang['shouyi_status_1'].'</option>';
    echo '<option value="2" '.$status_selected_2.'>'.$Lang['shouyi_status_2'].'</option>';
    echo '<option value="3" '.$status_selected_3.'>'.$Lang['shouyi_status_3'].'</option>';
    
    showsubmit('submit', 'submit');
    showtablefooter();
    showformfooter();
    __create_nav_html();
    
    echo '<form name="cpform2" id="cpform2" method="post" autocomplete="off" action="'.ADMINSCRIPT.'?action='.$modFromUrl.'&formhash='.FORMHASH.'" onsubmit="return shouyi_form();">'.
		'<input type="hidden" name="formhash" value="'.FORMHASH.'" />';
    showtableheader();
    echo '<tr class="header">';
    echo '<th> - </th>';
    echo '<th>' . $Lang['shouyi_order_no'] . '</th>';
    echo '<th>' . $Lang['shouyi_hehuoren_name'] . '</th>';
    echo '<th>' . $Lang['shouyi_child_hehuore_name'] . '</th>';
    echo '<th>' . $Lang['shouyi_type'] . '</th>';
    echo '<th width="25%">' . $Lang['shouyi_content'] . '</th>';
    echo '<th>' . $Lang['shouyi_price'] . '</th>';
    echo '<th>' . $Lang['shouyi_status'] . '</th>';
    echo '<th>' . $Lang['shouyi_time'] . '</th>';
    echo '<th>' . $Lang['shouyi_add_time'] . '</th>';
    echo '<th width="80px">' . $Lang['handle'] . '</th>';
    echo '</tr>';
    
    $i = 1;
    foreach ($shouyiList as $key => $value) {
        $tchehuorenInfo = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_by_id($value['hehuoren_id']);
        $xiaodiInfo = C::t('#tom_tchehuoren#tom_tchehuoren')->fetch_by_id($value['child_hehuoren_id']);
        
        echo '<tr>';
        echo '<td><input class="checkbox" type="checkbox" name="ids[]" value="' . $value['id'] . '" ></td>';
        echo '<td>' . $value['order_no'] . '</td>';
        echo '<td>' . $tchehuorenInfo['xm'] .'(' .$tchehuorenInfo['id'] . ')</td>';
        if($xiaodiInfo){
            echo '<td>'.$xiaodiInfo['xm'].'('.$value['id'].')</td>';
        }else{
            echo '<td> -- </td>';
        }
        echo '<td>' . $value['type'] . '</td>';
        echo '<td>' . $value['content'] . '</td>';
        echo '<td>' . $value['shouyi_price'] . '</td>';
        if($value['shouyi_status'] == 1){
            echo '<td><font color="#f00">' . $Lang['shouyi_status_1'] . '</font></td>';
        }else if($value['shouyi_status'] == 2){
            echo '<td><font color="#238206">' . $Lang['shouyi_status_2'] . '</font></td>';
        }else if($value['shouyi_status'] == 3){
            echo '<td><font color="#f00">' . $Lang['shouyi_status_3'] . '</font></td>';
        }else{
            echo '<td> -- </td>';
        }
        if($value['shouyi_time'] > 0){
            echo '<td>' . dgmdate($value['shouyi_time'], "Y-m-d H:i", $tomSysOffset) . '</td>';
        }else{
            echo '<td> -- </td>';
        }
        echo '<td>' . dgmdate($value['add_time'], "Y-m-d H:i", $tomSysOffset) . '</td>';
        echo '</td>';
        if($value['shouyi_status'] == 1){
            echo '<td style="line-height: 22px;">';
            echo '<a href="javascript:void(0);" onclick="handle_confirm(\''.$modBaseUrl.'&act=shouyi_status&shouyi_status=2&id='.$value['id'].'&formhash='.FORMHASH.'\');">' . $Lang['shouyi_handle_status_2'] . '</a>&nbsp;|&nbsp;';
            echo '<a href="javascript:void(0);" onclick="handle_confirm(\''.$modBaseUrl.'&act=shouyi_status&shouyi_status=3&id='.$value['id'].'&formhash='.FORMHASH.'\');">' . $Lang['shouyi_handle_status_3'] . '</a>';
            echo '</td>';
        }
        echo '</tr>';
        $i++;
    }
       $formstr = <<<EOF
        <tr>
            <td class="td25">
                <input type="checkbox" name="chkall" id="chkallFh9R" class="checkbox" onclick="checkAll('prefix', this.form, 'ids')" />
                <label for="chkallFh9R">{$Lang['checkall']}</label>
            </td>
            <td class="td25">
                <select name="act" >
                    <option value="batch_shouyi_2">{$Lang['shouyi_handle_status_2']}</option>
                    <option value="batch_shouyi_3">{$Lang['shouyi_handle_status_3']}</option>
                </select>
            </td>
            <td colspan="15">
                <div class="fixsel"><input type="submit" class="btn" id="submit_announcesubmit" name="announcesubmit" value="{$Lang['batch_btn']}" /></div>
            </td>
        </tr>
        <script type="text/javascript">
        function shouyi_form(){
          var r = confirm("{$Lang['batch_make_sure']}")
          if (r == true){
            return true;
          }else{
            return false;
          }
        }
        </script>
EOF;
    if($shouyi_status == 1){
        echo $formstr;
    }
    
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBasePageUrl);
    showsubmit('', '', '', '', $multi, false);
    
    $jsstr = <<<EOF
<script type="text/javascript">
function handle_confirm(url){
  var r = confirm("{$Lang['makesure_shouyi_status_msg']}")
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
    tomshownavli($Lang['shouyi_list_title'],$modBaseUrl,true);
    tomshownavfooter();
}


