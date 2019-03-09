<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$modBaseUrl = $adminBaseUrl.'&tmod=sitesCate';
$modListUrl = $adminListUrl.'&tmod=sitesCate';
$modFromUrl = $adminFromUrl.'&tmod=sitesCate';

if($_GET['act'] == 'add'){
    if(submitcheck('submit')){
        $insertData = array();
        $insertData = __get_post_data();
        C::t('#tom_tongcheng#tom_tongcheng_sites_cate')->insert($insertData);
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
    $sites_cateInfo = C::t('#tom_tongcheng#tom_tongcheng_sites_cate')->fetch_by_id($_GET['id']);
    if(submitcheck('submit')){
        $updateData = array();
        $updateData = __get_post_data($sites_cateInfo);
        C::t('#tom_tongcheng#tom_tongcheng_sites_cate')->update($sites_cateInfo['id'],$updateData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        tomloadcalendarjs();
        loadeditorjs();
        __create_nav_html();
        showformheader($modFromUrl.'&act=edit&id='.$_GET['id'],'enctype');
        showtableheader();
        __create_info_html($sites_cateInfo);
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'del'){
    
    C::t('#tom_tongcheng#tom_tongcheng_sites_cate')->delete_by_id($_GET['id']);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
}else{
    
    $sites_cateList = C::t('#tom_tongcheng#tom_tongcheng_sites_cate')->fetch_all_list(" "," ORDER BY paixu ASC,id DESC ",0,100);
    
    __create_nav_html();
    showtableheader();
    echo '<tr class="header">';
    echo '<th>' . $Lang['sites_cate_name'] . '</th>';
    echo '<th>' . $Lang['sites_cate_paixu'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    
    $i = 1;
    foreach ($sites_cateList as $key => $value) {
        
        echo '<tr>';
        echo '<td>' . $value['name'] . '</td>';
        echo '<td>' . $value['paixu'] . '</td>';
        echo '<td>';
        echo '<a href="'.$modBaseUrl.'&act=edit&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['edit']. '</a>&nbsp;|&nbsp;';
        echo '<a href="javascript:void(0);" onclick="del_confirm(\''.$modBaseUrl.'&act=del&id='.$value['id'].'&formhash='.FORMHASH.'\');">' . $Lang['delete'] . '</a>';
        echo '</td>';
        echo '</tr>';
        $i++;
    }
    showtablefooter();
    
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
    
    $name        = isset($_GET['name'])? addslashes($_GET['name']):'';
    $paixu       = isset($_GET['paixu'])? intval($_GET['paixu']):0;
    
    $data['name']      = $name;
    $data['paixu']     = $paixu;
    
    return $data;
}

function __create_info_html($infoArr = array()){
    global $Lang;
    $options = array(
        'name'           => '',
        'paixu'          => 100,
    );
    $options = array_merge($options, $infoArr);
    
    tomshowsetting(true,array('title'=>$Lang['sites_cate_name'],'name'=>'name','value'=>$options['name'],'msg'=>$Lang['sites_cate_name_msg']),"input");
    tomshowsetting(true,array('title'=>$Lang['sites_cate_paixu'],'name'=>'paixu','value'=>$options['paixu'],'msg'=>$Lang['sites_cate_paixu_msg']),"input");
    return;
}

function __create_nav_html($infoArr = array()){
    global $Lang,$modBaseUrl,$adminBaseUrl;
    tomshownavheader();
    if($_GET['act'] == 'add'){
        tomshownavli($Lang['sites_cate_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['sites_cate_add'],"",true);
    }else if($_GET['act'] == 'edit'){
        tomshownavli($Lang['sites_cate_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['sites_cate_add'],$modBaseUrl."&act=add",false);
        tomshownavli($Lang['sites_cate_edit'],"",true);
    }else{
        tomshownavli($Lang['sites_cate_list_title'],$modBaseUrl,true);
        tomshownavli($Lang['sites_cate_add'],$modBaseUrl."&act=add",false);
    }
    tomshownavfooter();
}