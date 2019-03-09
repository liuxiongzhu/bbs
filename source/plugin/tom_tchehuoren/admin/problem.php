<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$modBaseUrl = $adminBaseUrl.'&tmod=problem';
$modListUrl = $adminListUrl.'&tmod=problem';
$modFromUrl = $adminFromUrl.'&tmod=problem';

if($_GET['act'] == 'add'){
    if(submitcheck('submit')){
        $insertData = array();
        $insertData = __get_post_data();
        C::t('#tom_tchehuoren#tom_tchehuoren_common_problem')->insert($insertData);
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
    $problemInfo = C::t('#tom_tchehuoren#tom_tchehuoren_common_problem')->fetch_by_id($_GET['id']);
    if(submitcheck('submit')){
        $updateData = array();
        $updateData = __get_post_data($problemInfo);
        C::t('#tom_tchehuoren#tom_tchehuoren_common_problem')->update($problemInfo['id'],$updateData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        tomloadcalendarjs();
        loadeditorjs();
        __create_nav_html();
        showformheader($modFromUrl.'&act=edit&id='.$_GET['id'],'enctype');
        showtableheader();
        __create_info_html($problemInfo);
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'del'){
    
    C::t('#tom_tchehuoren#tom_tchehuoren_common_problem')->delete_by_id($_GET['id']);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
}else{
    
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    
    $pagesize = 100;
    $start = ($page-1)*$pagesize;
    $count = C::t('#tom_tchehuoren#tom_tchehuoren_common_problem')->fetch_all_count("");
    $problemList = C::t('#tom_tchehuoren#tom_tchehuoren_common_problem')->fetch_all_list(""," ORDER BY type ASC, paixu ASC,id ASC ",$start,$pagesize);
    
    __create_nav_html();
    showtableheader();
    echo '<tr class="header">';
    echo '<th> '. $Lang['problem_paixu'] .' </th>';
    echo '<th>' . $Lang['problem_title'] . '</th>';
    echo '<th>' . $Lang['problem_type'] . '</th>';
    echo '<th>' . $Lang['problem_content'] . '</th>';
    echo '<th>' . $Lang['problem_zhuanshu_picurl'] . '</th>';
    echo '<th>' . $Lang['problem_add_time'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    
    $i = 1;
    foreach ($problemList as $key => $value) {
        if($value['type'] == 1){
            if(!preg_match('/^http/', $value['zhuanshu_picurl']) ){
                $zhuanshu_picurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'tomwx/'.$value['zhuanshu_picurl'];
            }else{
                $zhuanshu_picurl = $value['zhuanshu_picurl'];
            }
            $zhuanshu_picurl = '<img width="40px" src="' . $zhuanshu_picurl . '">';
        }else{
            $zhuanshu_picurl = '--';
        }
        
        echo '<tr>';
        echo '<td>' . $value['paixu'] . '</td>';
        echo '<td>' . $value['title'] . '</td>';
        if($value['type'] == 1){
            echo '<td>' . $Lang['problem_type_1'] . '</td>';
        }else if($value['type'] == 2){
            echo '<td>' . $Lang['problem_type_2'] . '</td>';
        }else{
            echo '<td> -- </td>';
        }
        echo '<td width="30%">' . $value['content'] . '</td>';
        echo '<td >'.$zhuanshu_picurl.'</td>';
        echo '<td>' . dgmdate($value['add_time'], "Y-m-d H:i", $tomSysOffset) . '</td>';
        echo '<td>';
        echo '<a href="'.$modBaseUrl.'&act=edit&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['edit']. '</a>&nbsp;|&nbsp;';
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
    
    $title                      = isset($_GET['title'])? addslashes($_GET['title']):'';
    $type                       = isset($_GET['type'])? intval($_GET['type']):1;
    $content                    = isset($_GET['content'])? addslashes($_GET['content']):'';
    $paixu                      = isset($_GET['paixu'])? intval($_GET['paixu']):0;
    
    $zhuanshu_picurl = "";
    if($_GET['act'] == 'add'){
        $zhuanshu_picurl        = tomuploadFile("zhuanshu_picurl");
    }else if($_GET['act'] == 'edit'){
        $zhuanshu_picurl        = tomuploadFile("zhuanshu_picurl",$infoArr['zhuanshu_picurl']);
    }
    
    $data['title']              = $title;
    $data['type']               = $type;
    $data['content']            = $content;
    $data['zhuanshu_picurl']    = $zhuanshu_picurl;
    $data['paixu']              = $paixu;
    $data['add_time']           = TIMESTAMP;
    
    return $data;
}

function __create_info_html($infoArr = array()){
    global $Lang;
    $options = array(
        'title'                 => '',
        'type'                  => 1,
        'content'               => '',
        'zhuanshu_picurl'       => '',
        'paixu'                 => 0,
    );
    $options = array_merge($options, $infoArr);
    
    tomshowsetting(true,array('title'=>$Lang['problem_title'],'name'=>'title','value'=>$options['title'],'msg'=>$Lang['problem_title_msg']),"input");
    $type_item = array(1=>$Lang['problem_type_1'],2=>$Lang['problem_type_2']);
    tomshowsetting(true,array('title'=>$Lang['problem_type'],'name'=>'type','value'=>$options['type'],'msg'=>$Lang['problem_type_msg'],'item'=>$type_item),"radio");
    tomshowsetting(true,array('title'=>$Lang['problem_content'],'name'=>'content','value'=>$options['content'],'msg'=>$Lang['problem_content_msg']),"textarea");
    tomshowsetting(true,array('title'=>$Lang['problem_zhuanshu_picurl'],'name'=>'zhuanshu_picurl','value'=>$options['zhuanshu_picurl'],'msg'=>$Lang['problem_zhuanshu_picurl_msg']),"file");
    tomshowsetting(true,array('title'=>$Lang['problem_paixu'],'name'=>'paixu','value'=>$options['paixu'],'msg'=>$Lang['problem_paiux_msg']),"input");
    return;
}

function __create_nav_html($infoArr = array()){
    global $Lang,$modBaseUrl,$adminBaseUrl;
    tomshownavheader();
    if($_GET['act'] == 'add'){
        tomshownavli($Lang['problem_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['problem_add'],"",true);
    }else if($_GET['act'] == 'edit'){
        tomshownavli($Lang['problem_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['problem_add'],$modBaseUrl."&act=add",false);
        tomshownavli($Lang['problem_edit'],"",true);
    }else{
        tomshownavli($Lang['problem_list_title'],$modBaseUrl,true);
        tomshownavli($Lang['problem_add'],$modBaseUrl."&act=add",false);
    }
    tomshownavfooter();
}