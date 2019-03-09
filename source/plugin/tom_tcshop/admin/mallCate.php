<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$modBaseUrl = $adminBaseUrl.'&tmod=mallCate&tcshop_id='.$_GET['tcshop_id'];
$modListUrl = $adminListUrl.'&tmod=mallCate&tcshop_id='.$_GET['tcshop_id'];
$modFromUrl = $adminFromUrl.'&tmod=mallCate&tcshop_id='.$_GET['tcshop_id'];

$tcshop_id = intval($_GET['tcshop_id'])>0? intval($_GET['tcshop_id']):0;

$tcshopInfo = C::t('#tom_tcshop#tom_tcshop')->fetch_by_id($tcshop_id);

if($_GET['act'] == 'add'){
    if(submitcheck('submit')){
        $insertData = array();
        $insertData = __get_post_data();
        C::t('#tom_tcshop#tom_tcshop_mall_cate')->insert($insertData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        tomloadcalendarjs();
        loadeditorjs();
        __create_nav_html();
        showformheader($modFromUrl.'&act=add','enctype');
        showtableheader();
        __create_info_html();
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
    
}else if($_GET['act'] == 'edit'){
    $mallCateInfo = C::t('#tom_tcshop#tom_tcshop_mall_cate')->fetch_by_id($_GET['id']);
    if(submitcheck('submit')){
        $updateData = array();
        $updateData = __get_post_data($mallCateInfo);
        C::t('#tom_tcshop#tom_tcshop_mall_cate')->update($mallCateInfo['id'],$updateData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        tomloadcalendarjs();
        loadeditorjs();
        __create_nav_html();
        showformheader($modFromUrl.'&act=edit&id='.$_GET['id'],'enctype');
        showtableheader();
        __create_info_html($mallCateInfo);
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'del'){
    
    C::t('#tom_tcshop#tom_tcshop_mall_cate')->delete_by_id($_GET['id']);
    
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
}else{
    
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    
    $where = " AND tcshop_id={$tcshop_id} ";
    $pagesize = 100;
    $start = ($page-1)*$pagesize;	
    $mallCateList = C::t('#tom_tcshop#tom_tcshop_mall_cate')->fetch_all_list("{$where}"," ORDER BY csort ASC,id DESC ",$start,$pagesize);
    
    showtableheader();
    echo '<tr><th colspan="15" class="partition"><font color="#238206">'.$tcshopInfo['name'].'</font>&nbsp;>&nbsp;' .$Lang['mallCate_list_title']. '</th></tr>';
    showtablefooter();
    
    __create_nav_html();
    showtableheader();
    echo '<tr class="header">';
    echo '<th>' . $Lang['mallCate_name'] . '</th>';
    echo '<th>' . $Lang['mallCate_csort'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    
    $i = 1;
    foreach ($mallCateList as $key => $value) {
        echo '<tr>';
        echo '<td>' . $value['name'] . '</td>';
        echo '<td>' . $value['csort'] . '</td>';
        echo '<td>';
        echo '<a href="'.$modBaseUrl.'&act=edit&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['mallCate_edit']. '</a>&nbsp;|&nbsp;';
        echo '<a href="javascript:void(0);" onclick="del_confirm(\''.$modBaseUrl.'&act=del&id='.$value['id'].'&formhash='.FORMHASH.'\');">' . $Lang['delete'] . '</a>';
        echo '</td>';
        echo '</tr>';
        $i++;
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

function __get_post_data($infoArr = array()){
    $data = array();
    
    $name       = isset($_GET['name'])? addslashes($_GET['name']):'';
    $csort       = isset($_GET['csort'])? intval($_GET['csort']):10;
    
    $data['tcshop_id'] = $_GET['tcshop_id'];
    $data['name']      = $name;
    $data['csort']     = $csort;
    
    return $data;
}

function __create_info_html($infoArr = array()){
    global $Lang;
    $options = array(
        'name'          => '',
        'csort'          => 10,
    );
    $options = array_merge($options, $infoArr);
    
    tomshowsetting(true,array('title'=>$Lang['mallCate_name'],'name'=>'name','value'=>$options['name'],'msg'=>$Lang['mallCate_name_msg']),"input");
    tomshowsetting(true,array('title'=>$Lang['mallCate_csort'],'name'=>'csort','value'=>$options['csort'],'msg'=>$Lang['mallCate_csort_msg']),"input");
    
    return;
}

function __create_nav_html($infoArr = array()){
    global $Lang,$modBaseUrl,$adminBaseUrl;
    tomshownavheader();
    if($_GET['act'] == 'add'){
        tomshownavli($Lang['mallCate_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['mallCate_add'],"",true);
    }else if($_GET['act'] == 'edit'){
        tomshownavli($Lang['mallCate_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['mallCate_add'],$modBaseUrl."&act=add",false);
        tomshownavli($Lang['mallCate_edit'],"",true);
    }else{
        tomshownavli($Lang['mallCate_list_title'],$modBaseUrl,true);
        tomshownavli($Lang['mallCate_add'],$modBaseUrl."&act=add",false);
    }
    tomshownavfooter();
}