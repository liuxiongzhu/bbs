<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$moduleBaseUrl = $adminBaseUrl.'&tmod=subuser';
$moduleListUrl = $adminListUrl.'&tmod=subuser';
$moduleFromUrl = $adminFromUrl.'&tmod=subuser';

$act = isset($_GET['act'])? $_GET['act']:'';
$formhash =  $_GET['formhash']? $_GET['formhash']:'';

if ($formhash == FORMHASH && $act == 'del'){
}else{
    $pagesize = 50;
	$page = intval($_GET['page'])>0? intval($_GET['page']):1;
	$start = ($page-1)*$pagesize;
    
    $count = C::t('#tom_weixin#tom_weixin_subuser')->fetch_all_count2("");
	$subuserList = C::t('#tom_weixin#tom_weixin_subuser')->fetch_all_list2(""," ORDER BY id DESC ",$start,$pagesize);
	showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $tomScriptLang['subuser_list_title'] . '</th></tr>';
    echo '<tr class="header">';
    echo '<th>OPENID</th>';
    echo '<th>' . $tomScriptLang['subuser_headimgurl'] . '</th>';
    echo '<th>' . $tomScriptLang['subuser_nickname'] . '</th>';
    echo '<th>' . $tomScriptLang['subuser_sex'] . '</th>';
    echo '<th>' . $tomScriptLang['subuser_address'] . '</th>';
    echo '</tr>';
	foreach ($subuserList as $key => $value){
        echo '<tr>';
        echo '<td>' . $value['open_id'] . '</td>';
        echo '<td><img src="'.$value['headimgurl'].'" width="40" /></td>';
        echo '<td>' . $value['nickname'] . '</td>';
        if($value['sex'] == 1){
            echo '<td>' . $tomScriptLang['subuser_sex1'] . '</td>';
        }else if($value['sex'] == 2){
            echo '<td>' . $tomScriptLang['subuser_sex2'] . '</td>';
        }else{
            echo '<td>-</td>';
        }
        echo '<td>' . $value['country'] .' '. $value['province'] .' '. $value['city'] . '</td>';
        echo '</tr>';
	}
	showtablefooter();
	$multi = multi($count, $pagesize, $page, $moduleBaseUrl);	
	showsubmit('', '', '', '', $multi, false);
}

