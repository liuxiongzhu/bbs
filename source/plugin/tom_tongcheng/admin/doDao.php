<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$modBaseUrl = $adminBaseUrl.'&tmod=doDao'; 
$modListUrl = $adminListUrl.'&tmod=doDao';
$modFromUrl = $adminFromUrl.'&tmod=doDao';

$site_id        = isset($_GET['site_id'])? intval($_GET['site_id']):0;
$day_type       = isset($_GET['day_type'])? intval($_GET['day_type']):1;
$days           = isset($_GET['days'])? intval($_GET['days']):0;
$pic            = isset($_GET['pic'])? intval($_GET['pic']):1;

$model_ids = '';
$model_ids_url = '';
if(is_array($_GET['model_ids']) && !empty($_GET['model_ids'])){
    $model_ids = implode(',', $_GET['model_ids']);
    $model_ids_url = implode('_', $_GET['model_ids']);
}

$site_ids = '';
$site_ids_url = '';
if(is_array($_GET['site_ids']) && !empty($_GET['site_ids'])){
    $site_ids = implode(',', $_GET['site_ids']);
    $site_ids_url = implode('_', $_GET['site_ids']);
}

tomloadcalendarjs();
showformheader($modFromUrl.'&submit_do=1&formhash='.FORMHASH);
showtableheader();
echo '<tr><th colspan="15" class="partition">' . $Lang['doDao_site_title'] .'</th></tr>';

$siteList = C::t('#tom_tongcheng#tom_tongcheng_sites')->fetch_all_list(" "," ORDER BY add_time ASC,id DESC ",0,1000);
$siteStr = '<tr class="header"><th>'.$Lang['doDao_site'].'</th><th></th></tr>';
$siteStr.= '<tr><td width="300"><select style="width: 260px;" name="site_id" id="site_id">';
$siteStr.=  '<option value="0">'.$Lang['doDao_site'].'</option>';
if($site_id == 1){
    $siteStr.=  '<option value="1" selected>'.$tongchengConfig['plugin_name'].'</option>';
}else{
    $siteStr.=  '<option value="1">'.$tongchengConfig['plugin_name'].'</option>';
}
foreach ($siteList as $key => $value){
    if($value['id'] == $site_id){
        $siteStr.=  '<option value="'.$value['id'].'" selected>'.$value['name'].'</option>';
    }else{
        $siteStr.=  '<option value="'.$value['id'].'">'.$value['name'].'</option>';
    }
}
$siteStr.= '</select></td><td></td></tr>';
//echo $siteStr;

$sitesStr   = '<tr class="header"><th>'.$Lang['doDao_site'].'</th><th></th></tr>';
$sitesStr.= '<tr><td width="800" style="line-height: 30px;">';
if(in_array(1, $_GET['site_ids'])){
    $sitesStr.=  '<input name="site_ids[]" type="checkbox" value="1" checked />'.$tongchengConfig['plugin_name'].'';
}else if(!empty($_GET['site_ids'])){    
    $sitesStr.=  '<input name="site_ids[]" type="checkbox" value="1" />'.$tongchengConfig['plugin_name'].'';
}else{
    $sitesStr.=  '<input name="site_ids[]" type="checkbox" value="1" checked />'.$tongchengConfig['plugin_name'].'';
}
foreach ($siteList as $key => $value){
    if(in_array($value['id'], $_GET['site_ids'])){
        $sitesStr.=  '<input name="site_ids[]" type="checkbox" value="'.$value['id'].'" checked />'.$value['name'].'&nbsp;&nbsp;';
    }else if(!empty($_GET['site_ids'])){
        $sitesStr.=  '<input name="site_ids[]" type="checkbox" value="'.$value['id'].'" />'.$value['name'].'';
    }else{
        $sitesStr.=  '<input name="site_ids[]" type="checkbox" value="'.$value['id'].'" checked />'.$value['name'].'';
    }
}
$sitesStr.= '</td><td></td></tr>';
echo $sitesStr;

$modelList  = C::t('#tom_tongcheng#tom_tongcheng_model')->fetch_all_list(" AND is_show=1 "," ORDER BY paixu ASC,id DESC ",0,1000);
$modelStr   = '<tr class="header"><th>'.$Lang['model_ids'].'</th><th></th></tr>';
$modelStr.= '<tr><td width="800" style="line-height: 30px;">';
foreach ($modelList as $key => $value){
    if(in_array($value['id'], $_GET['model_ids'])){
        $modelStr.=  '<input name="model_ids[]" type="checkbox" value="'.$value['id'].'" checked />'.$value['name'].'&nbsp;&nbsp;';
    }else if(!empty($_GET['model_ids'])){
        $modelStr.=  '<input name="model_ids[]" type="checkbox" value="'.$value['id'].'" />'.$value['name'].'';
    }else{
        $modelStr.=  '<input name="model_ids[]" type="checkbox" value="'.$value['id'].'" checked />'.$value['name'].'';
    }
}
$modelStr.= '</td><td></td></tr>';
echo $modelStr;

$day_type_1 = $day_type_2 = '';
if($day_type == 1){ $day_type_1 = 'checked';}
if($day_type == 2){ $day_type_2 = 'checked';}
$day_typeStr = '<tr class="header"><th>'.$Lang['doDao_day_type'].'</th><th></th></tr>';
$day_typeStr.= '<tr><td width="300"><label><input type="radio" name="day_type" value="1" '.$day_type_1.'>'.$Lang['doDao_day_type_1'].'<label>&nbsp;&nbsp;&nbsp;';
$day_typeStr.=  '<label><input type="radio" name="day_type" value="2" '.$day_type_2.'>'.$Lang['doDao_day_type_2'].'<label>';
$day_typeStr.= '</td><td></td></tr>';
echo $day_typeStr;

$daysStr = '<tr class="header"><th>'.$Lang['doDao_days'].'</th><th></th></tr>';
$daysStr.= '<tr><td width="300"><select style="width: 260px;" name="days" id="days">';
$daysStr.=  '<option value="0">'.$Lang['doDao_days_0'].'</option>';
for($i = 1; $i<= 30 ;$i++){
    if($i == $days){
        $daysStr.=  '<option value="'.$i.'" selected>'.$i.''.$Lang['doDao_days_msg'].'</option>';
    }else{
        $daysStr.=  '<option value="'.$i.'">'.$i.''.$Lang['doDao_days_msg'].'</option>';
    }
}
$daysStr.= '</select></td><td></td></tr>';
echo $daysStr;

$pic_1 = $pic_2 = '';
if($pic == 1){ $pic_1 = 'checked';}
if($pic == 2){ $pic_2 = 'checked';}
$picStr = '<tr class="header"><th>'.$Lang['doDao_pic'].'</th><th></th></tr>';
$picStr.= '<tr><td width="300"><label><input type="radio" name="pic" value="1" '.$pic_1.'>'.$Lang['doDao_pic_yes'].'<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$picStr.=  '<label><input type="radio" name="pic" value="2" '.$pic_2.'>'.$Lang['doDao_pic_no'].'<label>';
$picStr.= '</td><td></td></tr>';
echo $picStr;

showsubmit('submit',$Lang['daDao_btn']);

showtablefooter();
showformfooter();

$where = " AND {$tongchengConfig['admin_tongcheng_doDao_status']} = 1 AND status = 1 AND finish = 0  ";

if(!empty($site_ids)){
    $where.= " AND site_id IN($site_ids) ";
}else if($site_id){
    $where.= " AND site_id = {$site_id} ";
}
if(!empty($model_ids)){
    $where.= " AND model_id IN($model_ids) ";
}
if($days > 0){
    $minTime = TIMESTAMP - $days * 86400;
    if($day_type == 1){
        $where.= " AND refresh_time > {$minTime} ";
    }else{
        $where.= " AND add_time > {$minTime} ";
    }
}

$count = C::t('#tom_tongcheng#tom_tongcheng')->fetch_all_count($where);

$doDaoUrl = $_G['siteurl']."plugin.php?id=tom_tongcheng:doDao&site_id={$site_id}&site_ids={$site_ids_url}&model_ids={$model_ids_url}&day_type={$day_type}&days={$days}&pic={$pic}";

if($_GET['submit_do'] == 1){
    if($count > 0){
        showtableheader();
        echo '<tr>';
        echo '<td><a href="'.$doDaoUrl.'" target="_blank" style="color: #FA6A03; padding:2px 7px; font-weight:600; margin-left: 10px; border-radius: 5px; border: 1px solid #FA6A03;">'.$Lang['daDao_url'].'</a></td>';
        echo '</tr>';
        showtablefooter();
        echo '<br/><b><font color="#0894fb">'.$Lang['daDao_chu_msg'].'</font></b>';
    }else{
        echo '<br/><b><font color="#fd0d0d">'.$Lang['daDao_no_msg'].'</font></b>';
    }
}