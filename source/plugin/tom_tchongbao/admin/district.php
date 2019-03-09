<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$modBaseUrl = $adminBaseUrl.'&tmod=district';
$modListUrl = $adminListUrl.'&tmod=district';
$modFromUrl = $adminFromUrl.'&tmod=district';


if($_GET['act'] == 'add'){
    if(submitcheck('submit')){
        $insertData = array();
        $insertData = __get_post_data();
        C::t('#tom_tchongbao#tom_tchongbao_district')->insert($insertData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        echo '<script type="text/javascript" src="static/js/calendar.js"></script>';
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
    $districtInfo = C::t('#tom_tchongbao#tom_tchongbao_district')->fetch_by_id($_GET['id']);
    if(submitcheck('submit')){
        $updateData = array();
        $updateData = __get_post_data($districtInfo);
        C::t('#tom_tchongbao#tom_tchongbao_district')->update($districtInfo['id'],$updateData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        echo '<script type="text/javascript" src="static/js/calendar.js"></script>';
        loadeditorjs();
        __create_nav_html();
        showformheader($modFromUrl.'&act=edit&id='.$_GET['id'],'enctype');
        showtableheader();
        __create_info_html($districtInfo);
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'del'){
    C::t('#tom_tchongbao#tom_tchongbao_district')->delete_by_id($_GET['id']);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
}else{
    $pagesize = 15;
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $start = ($page-1)*$pagesize;	
    $count = C::t('#tom_tchongbao#tom_tchongbao_district')->fetch_all_count("");
    $districtList = C::t('#tom_tchongbao#tom_tchongbao_district')->fetch_all_list("","ORDER BY add_time DESC",$start,$pagesize);
    __create_nav_html();
    showtableheader();
    echo '<tr class="header">';
    echo '<th width="10%"> ID </th>';
    echo '<th>' . $Lang['district_position'] . '</th>';
    echo '<th>' . $Lang['district_latitude'] . '</th>';
    echo '<th>' . $Lang['district_longitude'] . '</th>';
    echo '<th>' . $Lang['district_max_distance_km'] . '</th>';
    echo '<th>' . $Lang['district_status'] . '</th>';
    echo '<th>' . $Lang['district_add_time'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    
    $i = 1;
    foreach ($districtList as $key => $value) {
        $tcdistrictInfo = C::t('#tom_tongcheng#tom_tongcheng_district')->fetch_by_id($value['district_id']);
        if($value['is_show'] == 1){
            $is_show = '<font color="#0a9409">'.$Lang['district_is_show_1'].'</font>';
        }else{
            $is_show = '<font color="#f00">'.$Lang['district_is_show_0'].'</font>';
        }
        echo '<tr>';
        echo '<td>' . $value['id'] . '</td>';
        echo '<td>' . $tcdistrictInfo['name'] . '</td>';
        echo '<td>' . $value['latitude'] . '</td>';
        echo '<td>' . $value['longitude'] . '</td>';
        echo '<td>' . $value['max_distance_km'] . '</td>';
        echo '<td>' . $is_show . '</td>';
        echo '<td>' . dgmdate($value['add_time'],"Y-m-d H:i",$tomSysOffset) . '</td>';
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
    
    $district_id            = isset($_GET['district_id'])? intval($_GET['district_id']):0;
    $latitude               = isset($_GET['latitude'])? addslashes($_GET['latitude']):'';
    $longitude              = isset($_GET['longitude'])? addslashes($_GET['longitude']):'';
    $max_distance_km        = isset($_GET['max_distance_km'])? intval($_GET['max_distance_km']):0;
    $is_show                = isset($_GET['is_show'])? intval($_GET['is_show']):0;
    
    $data['district_id']        = $district_id;
    $data['latitude']           = $latitude;
    $data['longitude']          = $longitude;
    $data['max_distance_km']    = $max_distance_km;
    $data['is_show']            = $is_show;
    $data['add_time']           = TIMESTAMP;
    return $data;
}

function __create_info_html($infoArr = array()){
    global $Lang;
    $options = array(
        'district_id'       => 0,
        'latitude'          => "",
        'longitude'         => '',
        'max_distance_km'   => 0,
        'is_show'           => "",
    );
    $options = array_merge($options, $infoArr);
    $tcdistrictList = C::t('#tom_tongcheng#tom_tongcheng_district')->fetch_all_list(' AND level = 1 ', 'ORDER BY id DESC', 0, 1000);
    
    $outStr = '<tr class="header"><th>'.$Lang['district_add_city'].'</th><th></th></tr>';
    $outStr.= '<tr><td width="300"><select name="district_id" >';
    foreach ($tcdistrictList as $key => $value){
        if($value['id'] == $options['district_id']){
            $outStr.=  '<option value="'.$value['id'].'" selected>'.$value['name'].'</option>';
        }else{
            $outStr.=  '<option value="'.$value['id'].'">'.$value['name'].'</option>';
        }
    }
    $outStr.= '</select></td><td>'.$options['district_add_city_msg'].'</td></tr>';
    echo $outStr;
    tomshowsetting('true',array('title'=>$Lang['district_add_latitude'],'name'=>'latitude','value'=>$options['latitude'],'msg'=>$Lang['district_add_latitude_msg']),"input");
    tomshowsetting('true',array('title'=>$Lang['district_add_longitude'],'name'=>'longitude','value'=>$options['longitude'],'msg'=>$Lang['district_add_longitude_msg']),"input");
    tomshowsetting('true',array('title'=>$Lang['district_add_max_distance_km'],'name'=>'max_distance_km','value'=>$options['max_distance_km'],'msg'=>$Lang['district_add_max_distance_km_msg']),"input");
    $is_show_item = array(0=>$Lang['close'],1=>$Lang['open']);
    tomshowsetting('true',array('title'=>$Lang['district_add_is_show'],'name'=>'is_show','value'=>$options['is_show'],'msg'=>$Lang['district_add_is_show_msg'],'item'=>$is_show_item),"radio");
    return;
}

function __create_nav_html($infoArr = array()){
    global $Lang,$modBaseUrl,$adminBaseUrl;
    tomshownavheader();
    if($_GET['act'] == 'add'){
        tomshownavli($Lang['district_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['district_add'],"",true);
    }else if($_GET['act'] == 'edit'){
        tomshownavli($Lang['district_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['district_add'],$modBaseUrl."&act=add",false);
        tomshownavli($Lang['district_edit'],"",true);
    }else{
        tomshownavli($Lang['district_list_title'],$modBaseUrl,true);
        tomshownavli($Lang['district_add'],$modBaseUrl."&act=add",false);
    }
    tomshownavfooter();
}
