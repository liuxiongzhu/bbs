<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$modBaseUrl = $adminBaseUrl.'&tmod=majia';
$modListUrl = $adminListUrl.'&tmod=majia';
$modFromUrl = $adminFromUrl.'&tmod=majia';

$act = $_GET['act'];
$formhash =  $_GET['formhash']? $_GET['formhash']:'';

if($_GET['act'] == 'add'){
    if(submitcheck('submit')){
        for($i=1; $i<=10;$i++){
            $nickname = isset($_GET['nickname_'.$i])? addslashes($_GET['nickname_'.$i]):'';
            $picurl = tomuploadFile("picurl_".$i);
            if(!empty($nickname) && !empty($picurl)){
                $picurl = $_G['setting']['attachurl'].'tomwx/'.$picurl;
                $insertData = array();
                $insertData['nickname']     = $nickname;
                $insertData['picurl']       = $picurl;
                $insertData['is_majia']     = 1;
                $insertData['add_time']     = TIMESTAMP;
                C::t('#tom_tongcheng#tom_tongcheng_user')->insert($insertData);
            }
        }
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        __create_nav_html();
        showformheader($modFromUrl.'&act=add'.'&formhash='.FORMHASH ,'enctype');
        showtableheader();
        echo '<tr class="header">';
        echo '<th>' . $Lang['tcmajia_majia_nickname'] . '</th>';
        echo '<th>' . $Lang['tcmajia_majia_picurl'] . '</th>';
        echo '</tr>';
        for($i=1; $i<=10;$i++){
            echo '<tr id="td_'.$i.'">';
            echo '<td><input type="text" name="nickname_'.$i.'" ></td>';
            echo '<td><input type="file" name="picurl_'.$i.'" ></td>';
            echo '</tr>';
        }
        
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
    
}else if($_GET['act'] == 'edit'){
    $tcmajiaInfo = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($_GET['id']);
    if(submitcheck('submit')){
        $nickname = isset($_GET['nickname'])? addslashes($_GET['nickname']):'';
        $picurl = tomuploadFile("picurl");
        $picurl = $_G['setting']['attachurl'].'tomwx/'.$picurl;

        if(file_exists($tcmajiaInfo['picurl'])){
            @unlink($tcmajiaInfo['picurl']);
        }

        $updateData = array();
        $updateData['nickname']     = $nickname;
        $updateData['picurl']       = $picurl;
        $updateData['is_majia']     = 1;
        C::t('#tom_tongcheng#tom_tongcheng_user')->update($_GET['id'], $updateData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        __create_nav_html();
        showformheader($modFromUrl.'&act=edit&id='.$_GET['id'].'&formhash='.FORMHASH ,'enctype');
        showtableheader();
        tomshowsetting(true,array('title'=>$Lang['edit_majia_nickname'],'name'=>'nickname','value'=>$tcmajiaInfo['nickname'],'msg'=>$Lang['edit_majia_nickname_msg']),"input");
        $options['msg'] = $Lang['edit_majia_picurl_msg'].'<br/><a target="_blank" href="'.$tcmajiaInfo['picurl'].'"><img src="'.$tcmajiaInfo['picurl'].'" width="100" /></a>';
        showsetting($Lang['edit_majia_picurl'], 'picurl', $tcmajiaInfo['picurl'], 'filetext', 0, 0, $options['msg']);
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }

}else if($_GET['act'] == 'del' && $_GET['formhash'] == FORMHASH){
    C::t('#tom_tongcheng#tom_tongcheng_user')->delete_by_id($_GET['id']);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else{
    
    $pagesize = 20;
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $start = ($page-1)*$pagesize;	
    $count = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_all_like_count(' AND is_majia = 1 ','');
    $userList = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_all_like_list(' AND is_majia = 1 ',"ORDER BY add_time DESC",$start,$pagesize,'');
    
    showtableheader();
    $Lang['tcmajia_help_1']  = str_replace("{SITEURL}", $_G['siteurl'], $Lang['tcmajia_help_1']);
    echo '<tr><th colspan="15" class="partition">' . $Lang['tcmajia_help_title'] . '</th></tr>';
    echo '<tr><td  class="tipsblock" s="1"><ul id="tipslis">';
    echo '<li>' . $Lang['tcmajia_help_1'] . '</li>';
    echo '<li>' . $Lang['tcmajia_help_2_a'] . '<a target="_blank" href="http://www.tomwx.cn/index.php?m=help&t=plugin&pluginid=tom_tcmajia"><font color="#FF0000"><b>' . $Lang['tcmajia_help_2_b'] . '</b></font></a></li>';
    echo '</ul></td></tr>';
    showtablefooter();
    
    __create_nav_html();
    showtableheader();
    echo '<tr class="header">';
    echo '<th>' . $Lang['tcmajia_majia_id'] . '</th>';
    echo '<th>' . $Lang['tcmajia_majia_picurl'] . '</th>';
    echo '<th>' . $Lang['tcmajia_majia_nickname'] . '</th>';
    echo '<th>' . $Lang['tcmajia_majia_tel'] . '</th>';
    echo '<th>' . $Lang['tcmajia_majia_openid'] . '</th>';
    echo '<th>' . $Lang['tcmajia_majia_num'] . '</th>';
    echo '<th>' . $Lang['tcmajia_majia_status'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    foreach ($userList as $key => $value){
        
        $userCountTmp = C::t('#tom_tongcheng#tom_tongcheng')->fetch_all_count(" AND user_id={$value['id']} ");
        $tongchengPluginInfo = C::t('#tom_tcmajia#common_plugin')->fetch_by_identifier('tom_tongcheng');
        $tcadminBaseUrl = ADMINSCRIPT.'?action=plugins&operation=config&do='.$tongchengPluginInfo['id'].'&identifier=tom_tongcheng&pmod=admin'; 
        $modelUrl = $tcadminBaseUrl.'&tmod=index';
        echo '<tr>';
        echo '<td>'.$value['id'].'</td>';
        echo '<td><img src="'.$value['picurl'].'" width="40" /></td>';
        echo '<td>'.$value['nickname'].'</td>';
        echo '<td>'.$value['tel'].'</td>';
        echo '<td>'.$value['openid'].'</td>';
        echo '<td><font color="#f00">' . $userCountTmp . '</font>&nbsp;<a href="'.$modelUrl.'&user_id='.$value['id'].'" target="_blank"><font color="#928c8c">(' . $Lang['majia_num_chakan'] . ')</font></a></td>';
        if($value['status'] == 1){
            echo '<td><font color="#0a9409">'.$Lang['majia_status_1'].'</font></td>';
        }else{
            echo '<td><font color="#f00">'.$Lang['majia_status_2'].'</font></td>';
        }
        echo '<td>';
        echo '<a href="'.$modBaseUrl.'&act=edit&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['edit']. '</a>&nbsp;|&nbsp;';
        if($userCountTmp > 0){
            echo '<a href="javascript:;" onclick="confirm(\''.$Lang['make_no_del_msg'].'\');">' . $Lang['delete']. '</a>';
        }else{
            echo '<a href="javascript:;" onclick="del_confirm(\''.$modBaseUrl.'&act=del&id='.$value['id'].'&formhash='.FORMHASH.'\');">' . $Lang['delete']. '</a>';
        }
        echo '</td>';
        echo '</tr>';
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

function __create_nav_html($infoArr = array()){
    global $Lang,$modBaseUrl,$adminBaseUrl;
    tomshownavheader();
    if($_GET['act'] == 'add'){
        tomshownavli($Lang['tcmajia_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['tcmajia_add'],"",true);
    }else if($_GET['act'] == 'edit'){
        tomshownavli($Lang['tcmajia_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['tcmajia_add'],$modBaseUrl."&act=add",false);
        tomshownavli($Lang['tcmajia_edit'],"",true);
    }else{
        tomshownavli($Lang['tcmajia_list_title'],$modBaseUrl,true);
        tomshownavli($Lang['tcmajia_add'],$modBaseUrl."&act=add",false);
    }
    tomshownavfooter();
}