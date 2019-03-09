<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$modBaseUrl = $adminBaseUrl.'&tmod=item&vote_id='.$_GET['vote_id']; 
$modListUrl = $adminListUrl.'&tmod=item&vote_id='.$_GET['vote_id'];
$modFromUrl = $adminFromUrl.'&tmod=item&vote_id='.$_GET['vote_id'];

$get_list_url_value = get_list_url("tom_weixin_vote_admin_item_list");
if($get_list_url_value){
    $modListUrl = $get_list_url_value;
}

if($_GET['act'] == 'add'){
    $voteInfo = C::t('#tom_weixin_vote#tom_weixin_vote')->fetch_by_id($_GET['vote_id']);
    if(submitcheck('submit')){
        
        $itemList = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_all_list(" AND vote_id={$_GET['vote_id']} ","ORDER BY no DESC",0,1);
        $itemNo = 1;
        if(is_array($itemList) && !empty($itemList) && isset($itemList['0']) && $itemList['0']['no']>0){
            $itemNo = $itemList['0']['no']+1;
        }
        
        $insertData = array();
        $insertData = __get_post_data();
        $insertData['no']     = $itemNo;
        $insertData['add_time']     = TIMESTAMP;
        C::t('#tom_weixin_vote#tom_weixin_vote_item')->insert($insertData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        echo '<script type="text/javascript" src="static/js/calendar.js"></script>';
        loadeditorjs("tom_weixin_vote");
        __create_nav_html();
        showformheader($modFromUrl.'&act=add','enctype');
        showtableheader();
        __create_info_html();
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
    
}else if($_GET['act'] == 'edit'){
    $voteInfo = C::t('#tom_weixin_vote#tom_weixin_vote')->fetch_by_id($_GET['vote_id']);
    $itemInfo = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_by_id($_GET['id']);
    if(submitcheck('submit')){
        $updateData = array();
        $updateData = __get_post_data($itemInfo);
        C::t('#tom_weixin_vote#tom_weixin_vote_item')->update($itemInfo['id'],$updateData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        echo '<script type="text/javascript" src="static/js/calendar.js"></script>';
        loadeditorjs("tom_weixin_vote");
        __create_nav_html();
        showformheader($modFromUrl.'&act=edit&id='.$_GET['id'],'enctype');
        showtableheader();
        __create_info_html($itemInfo);
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'del'){
    C::t('#tom_weixin_vote#tom_weixin_vote_item')->delete_by_id($_GET['id']);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'delete'){
    $updateData = array();
    $updateData['status'] = 1;
    C::t('#tom_weixin_vote#tom_weixin_vote_item')->update($_GET['id'],$updateData);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'locking'){
    $updateData = array();
    $updateData['status'] = 2;
    C::t('#tom_weixin_vote#tom_weixin_vote_item')->update($_GET['id'],$updateData);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'recover'){
    $updateData = array();
    $updateData['status'] = 0;
    C::t('#tom_weixin_vote#tom_weixin_vote_item')->update($_GET['id'],$updateData);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'delphoto'){
    C::t('#tom_weixin_vote#tom_weixin_vote_photo')->delete_by_id($_GET['id']);
    cpmsg($Lang['act_success'], $modListUrl."&act=photo&item_id=".$_GET['item_id'], 'succeed');
    
}else if($_GET['act'] == 'photo'){
    $vote_id = $_GET['vote_id'];
    $item_id = $_GET['item_id'];
    if(submitcheck('submit')){
        $pic_url        = tomuploadFile("pic_url");
        $insertData = array();
        $insertData['vote_id'] = $vote_id;
        $insertData['item_id'] = $item_id;
        $insertData['pic_url'] = $pic_url;
        $insertData['add_time']     = TIMESTAMP;
        C::t('#tom_weixin_vote#tom_weixin_vote_photo')->insert($insertData);
        cpmsg($Lang['act_success'], $modListUrl."&act=photo&item_id=".$_GET['item_id'], 'succeed');
    }
    
    $voteInfo = C::t('#tom_weixin_vote#tom_weixin_vote')->fetch_by_id($_GET['vote_id']);
    $itemInfo = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_by_id($_GET['item_id']);
    $pagesize = 15;
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $start = ($page-1)*$pagesize;	
    $count = C::t('#tom_weixin_vote#tom_weixin_vote_photo')->fetch_all_count(" AND vote_id={$vote_id} AND item_id={$item_id}  ");
    $photoList = C::t('#tom_weixin_vote#tom_weixin_vote_photo')->fetch_all_list(" AND vote_id={$vote_id} AND item_id={$item_id} ","ORDER BY add_time DESC",$start,$pagesize);
    __create_nav_html();
    
    showformheader($modFromUrl.'&act=photo&item_id='.$item_id,'enctype');
    showtableheader();
    tomshowsetting(array('title'=>$Lang['item_pic_url'],'name'=>'pic_url','value'=>$options['pic_url'],'msg'=>$Lang['item_pic_url_msg']),"file");
    showsubmit('submit', 'submit');
    showtablefooter();
    showformfooter();
    
    showtableheader();
    echo '<tr class="header">';
    echo '<th>' . $Lang['item_pic_url'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    foreach ($photoList as $key => $value) {
        echo '<tr>';
        echo '<td><img src="' . tomgetfileurl($value['pic_url']) . '" width="60" /></td>';
        echo '<td>';
        echo '<a href="'.$modBaseUrl.'&act=delphoto&id='.$value['id'].'&item_id='.$item_id.'&vote_id='.$vote_id.'&formhash='.FORMHASH.'">' . $Lang['delete'] . '</a>';
        echo '</td>';
        echo '</tr>';
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBaseUrl);	
    showsubmit('', '', '', '', $multi, false);
}else{
    
    set_list_url("tom_weixin_vote_admin_item_list");
    
    $item_no = isset($_GET['item_no'])? intval($_GET['item_no']):0;
    $status = isset($_GET['status'])? intval($_GET['status']):0;

    $vote_id = $_GET['vote_id'];
    $voteInfo = C::t('#tom_weixin_vote#tom_weixin_vote')->fetch_by_id($_GET['vote_id']);
    $pagesize = 15;
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $start = ($page-1)*$pagesize;	
    if($item_no > 0){
        $count = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_all_count(" AND vote_id={$vote_id} AND no={$item_no} ");
        $itemList = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_all_list(" AND vote_id={$vote_id} AND no={$item_no}  ","ORDER BY add_time DESC",$start,$pagesize);
    }else{
        $whereStr = " AND vote_id={$vote_id} ";
        if($status > 0){
            $whereStr.= " AND status={$status} ";
        }
        $count = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_all_count($whereStr);
        $itemList = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_all_list($whereStr,"ORDER BY add_time DESC",$start,$pagesize);
    }
    __create_nav_html();
    showformheader($modFromUrl.'&formhash='.FORMHASH);
    showtableheader();
    echo '<tr><td width="100" align="right"><b>'.$Lang['search_item_no'].'</b></td><td><input name="item_no" type="text" value="'.$item_no.'" size="40" /></td></tr>';
    showsubmit('submit', 'submit');
    showtablefooter();
    showformfooter();
    showtableheader();
    echo '<tr><th colspan="15">';
    echo '&nbsp;&nbsp;<a class="addtr" target="_blank" href="'.$_G['siteurl'].'plugin.php?id=tom_weixin_vote:doDao&vid='.$vote_id.'">' . $Lang['daochu_user'] . '</a>';
    echo '</th></tr>';
    echo '<tr class="header">';
    echo '<th width="10%">' . $Lang['item_id'] . '</th>';
    echo '<th>' . $Lang['item_name'] . '</th>';
    echo '<th>' . $Lang['item_tel'] . '</th>';
    echo '<th>' . $Lang['item_pic_url'] . '</th>';
    echo '<th>' . $Lang['item_num'] . '</th>';
    echo '<th>' . $Lang['status'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    
    $i = 1;
    foreach ($itemList as $key => $value) {
        echo '<tr>';
        echo '<td>' . $value['no'] . '</td>';
        echo '<td>' . $value['name'] . '</td>';
        echo '<td>' . $value['tel'] . '</td>';
        echo '<td><img src="' . tomgetfileurl($value['pic_url']) . '" width="40" /></td>';
        echo '<td>' . $value['num'] . '</td>';
        if($value['status'] == 0){
            echo '<td>' . $Lang['status_normal'] . '</td>';
        }else if($value['status'] == 1){
            echo '<td>' . $Lang['status_delete'] . '</td>';
        }else if($value['status'] == 2){
            echo '<td>' . $Lang['status_locking'] . '</td>';
        }
        echo '<td>';
        echo '<a href="'.$adminBaseUrl.'&tmod=log&item_id='.$value['id'].'&vote_id='.$vote_id.'&formhash='.FORMHASH.'">' . $Lang['user_list_title']. '</a>&nbsp;|&nbsp;';
        echo '<a href="'.$modBaseUrl.'&act=photo&item_id='.$value['id'].'&vote_id='.$vote_id.'&formhash='.FORMHASH.'">' . $Lang['item_photo']. '</a>&nbsp;|&nbsp;';
        echo '<a href="'.$modBaseUrl.'&act=edit&id='.$value['id'].'&vote_id='.$vote_id.'&formhash='.FORMHASH.'">' . $Lang['item_edit']. '</a>&nbsp;|&nbsp;';
        if($value['status'] == 0){
            echo '<a href="'.$modBaseUrl.'&act=locking&id='.$value['id'].'&vote_id='.$vote_id.'&formhash='.FORMHASH.'">' . $Lang['locking'] . '</a>&nbsp;|&nbsp;';
        }else if($value['status'] == 2){
            echo '<a href="'.$modBaseUrl.'&act=recover&id='.$value['id'].'&vote_id='.$vote_id.'&formhash='.FORMHASH.'">' . $Lang['recover'] . '</a>&nbsp;|&nbsp;';
        }
        if($value['status'] == 0){
            echo '<a href="'.$modBaseUrl.'&act=delete&id='.$value['id'].'&vote_id='.$vote_id.'&formhash='.FORMHASH.'">' . $Lang['status_delete'] . '</a>&nbsp;|&nbsp;';
        }else if($value['status'] == 1){
            echo '<a href="'.$modBaseUrl.'&act=recover&id='.$value['id'].'&vote_id='.$vote_id.'&formhash='.FORMHASH.'">' . $Lang['shenhe'] . '</a>&nbsp;|&nbsp;';
        }
        echo '<a href="javascript:void(0);" onclick="del_confirm(\''.$modBaseUrl.'&act=del&id='.$value['id'].'&vote_id='.$vote_id.'&formhash='.FORMHASH.'\');">' . $Lang['del'] . '</a>';
        echo '</td>';
        echo '</tr>';
        $i++;
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBaseUrl."&status={$status}");	
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
    
    $name          = isset($_GET['name'])? addslashes($_GET['name']):'';
    $tel        = isset($_GET['tel'])? addslashes($_GET['tel']):'';
    $desc    = isset($_GET['desc'])? addslashes($_GET['desc']):'';
    $num     = isset($_GET['num'])? intval($_GET['num']):'';
    $pwd    = isset($_GET['pwd'])? addslashes($_GET['pwd']):'';
    
    $pic_url = "";
    if($_GET['act'] == 'add'){
        $pic_url        = tomuploadFile("pic_url");
    }else if($_GET['act'] == 'edit'){
        $pic_url        = tomuploadFile("pic_url",$infoArr['pic_url']);
    }
    
    $data['vote_id']      = $_GET['vote_id'];
    $data['name']         = $name;
    $data['tel']          = $tel;
    $data['desc']         = $desc;
    $data['pwd']          = $pwd;
    $data['num']          = $num;
    $data['pic_url']      = $pic_url;
    
    return $data;
}

function __create_info_html($infoArr = array()){
    global $Lang;
    $options = array(
        'name'          => '',
        'tel'           => "",
        'desc'          => "",
        'num'           => "",
        'pwd'           => "",
        'pic_url'       => "",
    );
    $options = array_merge($options, $infoArr);
    
    tomshowsetting(array('title'=>$Lang['item_name'],'name'=>'name','value'=>$options['name'],'msg'=>$Lang['item_name_msg']),"input");
    tomshowsetting(array('title'=>$Lang['item_tel'],'name'=>'tel','value'=>$options['tel'],'msg'=>$Lang['item_tel_msg']),"input");
    tomshowsetting(array('title'=>$Lang['item_num'],'name'=>'num','value'=>$options['num'],'msg'=>$Lang['item_num_msg']),"input");
    tomshowsetting(array('title'=>$Lang['item_pic_url'],'name'=>'pic_url','value'=>$options['pic_url'],'msg'=>$Lang['item_pic_url_msg']),"file");
    tomshowsetting(array('title'=>$Lang['item_desc'],'name'=>'desc','value'=>$options['desc'],'msg'=>$Lang['item_desc_msg']),"text");
    tomshowsetting(array('title'=>$Lang['item_pwd'],'name'=>'pwd','value'=>$options['pwd'],'msg'=>$Lang['item_pwd_msg']),"input");
    
    return;
}

function __create_nav_html($infoArr = array()){
    global $Lang,$modBaseUrl,$adminBaseUrl;
    tomshownavheader();
    if($_GET['act'] == 'add'){
        tomshownavli($Lang['item_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['item_add'],"",true);
    }else if($_GET['act'] == 'edit'){
        tomshownavli($Lang['item_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['item_add'],$modBaseUrl."&act=add",false);
        tomshownavli($Lang['item_edit'],"",true);
    }else if($_GET['act'] == 'photo'){
        tomshownavli($Lang['item_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['item_photo'],"",true);
    }else{
        tomshownavli($Lang['item_list_title'],$modBaseUrl,true);
        tomshownavli($Lang['item_add'],$modBaseUrl."&act=add",false);
    }
    tomshownavfooter();
}

