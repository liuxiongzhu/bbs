<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


function st_get_pluin_set(){
	global $_G;
	loadcache('plugin');
	return $_G['cache']['plugin']['dxc_api'];
}


function st_ajax_decode($str){
	return json_decode(base64_decode($str));
}


function seo_tpl($args = array()){
	global $_S,$_G;
	extract((array)$args);
	$head_url = '?'.PLUGIN_GO.$_GET['pmod'].'&myac=';
	$myac = $_GET['myac'];
	$tpl = $_GET['tpl'];
	if(empty($myac)) $myac = $default_ac ? $default_ac : $_GET['pmod'].'_run';
	if($_G['adminid'] < 1 && !in_array($myac, array('dxc_ajax_func', 'dxc_api_cron'))) exit('Access Denied:3302');
	sload('C:dxcShowHelper');
	if(!in_array($myac, array('api_add', 'dxc_ajax_func', 'dxc_api_call', 'api_list', 'attach_upload', 'api_del', 'api_report', 'api_empty', 'public_info', 'api_info', 'create_api_key'))) exit('Access Denied:33635');
	if(function_exists($myac)) $info = $myac();
	$_GET['mytemp'] = $_GET['mytemp'] ? $_GET['mytemp'] : $info['tpl'];
	$mytemp = $_GET['mytemp'] ? $_GET['mytemp'] : $myac;
	$tpl = $info['tpl'] ? $info['tpl'] : $tpl;
	if(!$_GET['inajax']){
		$_S['set'] = st_get_pluin_set();
		$submit_pmod = $info['submit_pmod'] ? $info['submit_pmod'] : $_GET['pmod'];
		$submit_action = $info['submit_action'] ? $info['submit_action'] : $myac;
		//$info['header'] = dxcShowHelper::pick_header_output();
		if(!$tpl || $tpl!= 'no') include template('dxc_api:'.$mytemp);
	}
}



function st_serialize($arr){
	return serialize(dstripslashes($arr));
}


function dxc_check_uid_exists($uid = ''){
	global $_G;
	$uid = $uid ? $uid : intval($_GET['uid']);
	if(!$uid) return 'no';
	$count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('common_member')." WHERE uid = '$uid' "), 0);
	if($count == 0){
		return 'no';
	}else{
		return $count;
	}
}



if(!function_exists('dunserialize')){//’‚∏ˆ∫Ø ˝ «DZ2.5–¬º”»Îµƒ
	function dunserialize($data) {
		if(($ret = unserialize($data)) === false) {
			$ret = unserialize(stripslashes($data));
		}
		return $ret;
	}
}

function get_site_category(){
	global $pluin_info,$_G;
	$cache_key = 'dxc_api_site_category';
	loadcache($cache_key);
	$big5 = $_G['config']['output']['language'] == 'zh_tw' && $_G['config']['output']['charset'] == 'big5' ? TRUE : FALSE;
	if( !($data = $_G['cache'][$cache_key] )){
		$cate_str = stlang('site_category');
		if(!$big5){
			$cate_arr = explode('|', $cate_str);
			foreach((array)$cate_arr as $k => $v){
				$temp_arr = explode('=', $v);
				$data[$temp_arr[0]] = $temp_arr[1];
			}
		}else{//≤ª’‚—˘∑±ÃÂ∑÷∏Óª·¬“¬Î
			preg_match_all("/([\x81-\xfe][\x40-\xfe])+/", $cate_str, $matches);
			$value_arr = $matches[0];
			$key_arr = range(1, count($value_arr));
			$data = array_combine($key_arr, $value_arr);
		}
		save_syscache($cache_key, $data);
	}
	return $data;
}


function tool_common_set($name, $value, $flag = ''){
	$conf_arr = tool_common_get();
	$setting = $conf_arr[$name];
	$value = (array)$value;
	$setting = (array)$setting;
	$value += $setting;
	$conf_arr[$name] = $value;
	save_syscache('dxc_api_setting', $conf_arr);
}

function tool_common_get($key = ''){
	global $_G;
	loadcache('dxc_api_setting');
	$setting = $_G['cache']['dxc_api_setting'];
	$setting = dstripslashes($setting);
	$setting = $key ? $setting[$key] : $setting;
	return $setting;
}


function st_stripslashes($data){
	if(DISCUZ_VERSION == 'X2') return $data;
	return dstripslashes($data);
}

function st_addslashes($data){
	if(DISCUZ_VERSION != 'X2') return $data;
	return daddslashes($data);
}

function stlang($name, $val_arr = array()){
	return lang('plugin/dxc_api', $name, $val_arr);
}


function s_s($name = 'default') {
	global $ss_timing_start_times;
	$ss_timing_start_times[$name] = explode(' ', microtime());
}

function s_e($show=1,$name = 'default') {
	global $ss_timing_stop_times;
	$ss_timing_stop_times[$name] = explode(' ', microtime());
	if($show == 1){
		echo '<p>'.st_timing_current($name).'</p>';
	}else{
		return st_timing_current($name);
	}
}

function st_timing_current ($name = 'default') {
	global $ss_timing_start_times, $ss_timing_stop_times;
	if (!isset($ss_timing_start_times[$name])) {
	   return 0;
	}
	if (!isset($ss_timing_stop_times[$name])) {
	   $stop_time = explode(' ', microtime());
	} else {
	   $stop_time = $ss_timing_stop_times[$name];
	}
	$current = $stop_time[1] - $ss_timing_start_times[$name][1];
	$current += $stop_time[0] - $ss_timing_start_times[$name][0];
	return $current;
}


function sload($name){
	$arr = explode(',', $name);
	$temp_arr = array();
	$pick_dir = DISCUZ_ROOT.'source/plugin/dxc_api';
	foreach($arr as $k => $v){
		$temp_arr = explode(':', $v);
		$type = strtolower($temp_arr[0]);
		$name = $temp_arr[1];
		$func_file = $pick_dir.'/lib/function.'.$name.'.php';
		$class_file = $pick_dir.'/lib/'.$name.'.class.php';
		if( (!$type || $type == 'f')){//∫Ø ˝ø‚
			require_once($func_file);
		}else if($type == 'c'){//¿‡ø‚
			require_once($class_file);
		}
	}
}


function get_api_key(){

    $global = tool_common_get('global');
    $api_key = $global['api_key'];
    if(!$api_key) {

		$set['api_key'] = $api_key = random(20);
    	tool_common_set('global', $set);

    }

    return $api_key;
}


function getthreadtypes($args = array() ){
    global $_G;
    if(empty($_GET['selectname'])) $_GET['selectname'] = 'threadtypeid';
    $now_id = $args['typeid'] ? $args['typeid'] : intval($_GET['typeid']);
    $fid = $args['fid'] ? $args['fid'] : intval($_GET['fid']);
    $output = '<select name="'.$_GET['selectname'].'">';
    $query = DB::query("SELECT typeid,name,displayorder FROM ".DB::table('forum_threadclass')." WHERE  fid='$fid' ORDER BY displayorder");
    $output .= '<option value="0" >'.stlang('select_class').'</option>';
    while($rs = DB::fetch($query)) {
        $selected = ($rs['typeid'] == $now_id) ? 'selected="selected"' : '';
        $output .= '<option '.$selected.' value="'.$rs['typeid'].'">'.$rs['name'].'</option>';
    }
    $output .= '</select>';
    return $output;
}


function getthreadsorts($args = array()){
	global $_G;

	$selectname = 'threadsortid';
    $now_id = $args['sortid'] ? $args['sortid'] : intval($_GET['sortid']);
	$fid = $args['fid'] ? $args['fid'] : intval($_GET['fid']);
    $output = '<select name="'.$selectname.'">';
    $output .= '<option value="0" >'.stlang('please_select').'</option>';


	$forum_forumfield_info = DB::fetch_first("SELECT threadsorts,moderators FROM ".DB::table('forum_forumfield')." WHERE fid='$fid'");
	$threadsorts_data = dunserialize($forum_forumfield_info['threadsorts']);
	$types = $threadsorts_data['types'];

    foreach($types as $typeid => $name){
        $selected = ($typeid == $now_id) ? 'selected="selected"' : '';
        $output .= '<option '.$selected.' value="'.$typeid.'">'.$name.'</option>';
    }
    $output .= '</select>';


	return $output;

}


//”…¥À∫Ø ˝µ˜ajax∫Ø ˝
function dxc_ajax_func(){
    global $_G;
    $seotool_ajax_func = $_GET['af'];
    $allow_func_arr = array('getthreadtypes', 'public_info');

    if(strexists($seotool_ajax_func, ':')){
        $temp_arr = explode(':', $seotool_ajax_func);
        $file_name = $temp_arr[0];
        $seotool_ajax_func = $temp_arr[1];
        sload('F:'.$file_name);
        if(!function_exists($seotool_ajax_func)){
            if(!in_array($seotool_ajax_func, $allow_func_arr)) exit('Access Denied:ajax3036');
            sload('C:'.$file_name);
            if(!function_exists($seotool_ajax_func)){
                exit(stlang('no_found_ajaxfunc'));
            }
        }
    }
    $xml = empty($_GET['xml']) ? 0 : $_GET['xml'];
    if(!function_exists($seotool_ajax_func)) exit(stlang('no_found_ajaxfunc'));
    $output = $seotool_ajax_func();
	ob_end_clean();
	ob_start();
    if($xml == 1) include template('common/header_ajax');
    echo $output;
    if($xml == 1) include template('common/footer_ajax');
    define(FOOTERDISABLED, false);
    exit();
}

function d_s($name = 'default') {
	global $ss_timing_start_times;
	$ss_timing_start_times[$name] = explode(' ', microtime());
}

function d_e($show=1,$name = 'default') {
	global $ss_timing_stop_times;
	$ss_timing_stop_times[$name] = explode(' ', microtime());
	if($show == 1){
		echo '<p>'.ss_timing_current($name).'</p>';
	}else{
		return ss_timing_current($name);
	}
}

function ss_timing_current ($name = 'default') {
	global $ss_timing_start_times, $ss_timing_stop_times;
	if (!isset($ss_timing_start_times[$name])) {
	   return 0;
	}
	if (!isset($ss_timing_stop_times[$name])) {
	   $stop_time = explode(' ', microtime());
	} else {
	   $stop_time = $ss_timing_stop_times[$name];
	}
	$current = $stop_time[1] - $ss_timing_start_times[$name][1];
	$current += $stop_time[0] - $ss_timing_start_times[$name][0];
	return $current;
}


function get_rand_uid($args, $type = 'public'){
    global $_G;
    $p_arr = $args['p_arr'];
    $uid_set_rules = $p_arr[$type.'_uid'];
    $uid_set_type = $p_arr[$type.'_uid_type'];
    $public_uid = $args['public_uid'];
    $reply_num = $args['reply_num'];
    $no_uid_sql = $public_uid ? "uid<>'$public_uid' AND " : '';
    if($set_arr['uid']) {
        $sql = 'AND uid != '.$set_arr['uid'];
    }
    if($reply_num > 0 && $type == 'reply' && !$uid_set_rules && $p_arr['is_public_reply'] == 1) {
        $max_uid = DB::result(DB::query("SELECT MAX(uid) FROM ".DB::table('common_member')." WHERE groupid!=9 "), 0);
        $uid_set_rules = '1,'.$max_uid;
        $uid_set_type = 2;
    }
    $num = 1 + $reply_num;
    $limit_str = $num ==1 ? "limit 1" : "limit 0,$num";
    if($uid_set_type == 1){
        $uid_group = $p_arr[$type.'_uid_group'];
        $uid_group_arr = dunserialize($uid_group);
        $g_sql = '';
        if($uid_group_arr[0]){
            $g_sql = " WHERE $no_uid_sql groupid IN (".dimplode($uid_group_arr).") "	;
        }else{
            $g_sql = " WHERE $no_uid_sql groupid!=9 ";
        }
        $query = DB::query("SELECT uid,username FROM ".DB::table('common_member').$g_sql." ORDER BY rand() $limit_str");
        while(($v = DB::fetch($query))) {
            $arr[] = $v;
        }
    }else{
        if(strexists($uid_set_rules, '|')){

            $uid_arr = explode('|', $uid_set_rules);
            $uid_arr = array_filter($uid_arr);

            $query = DB::query("SELECT uid,username FROM ".DB::table('common_member')." WHERE $no_uid_sql uid IN (".dimplode($uid_arr).") ".$sql." AND groupid!=9 ORDER BY rand() $limit_str");
            while(($v = DB::fetch($query))) {
                $arr[] = $v;
            }
        }else if(strexists($uid_set_rules, ',')) {
            $range_arr = format_wrap($uid_set_rules, ',');
            $max = intval($range_arr[1]);
            $min = intval($range_arr[0]);
            if(!$max || !$min || $max < 0 || $min < 0 || (($max - $min) < 0 )) return $now_arr;
            $query = DB::query("SELECT uid,username FROM ".DB::table('common_member')." WHERE $no_uid_sql uid<$max AND uid>$min ".$sql." AND groupid!=9 ORDER BY rand() $limit_str");
            while(($v = DB::fetch($query))) {
                $arr[] = $v;
            }
        }else{
            $info = get_user_info($uid_set_rules);
            $now_arr[0]['uid'] = $info['uid'];
            $now_arr[0]['username'] = $info['username'];
            if($num == 1) return $now_arr;
            for($i = 1; $i< $num+1; $i++){
                $arr[] = $now_arr[0];
            }
        }
    }

    if(!$arr[0]['uid']){
        $now_arr[0]['uid'] = $_G['uid'];
        $now_arr[0]['username'] = $_G['username'];
        return $now_arr;
    }
    return $arr;
}


function get_user_info($uid=0){
	global $_G;
	if($uid == 0) $uid =  $_G['uid'];
	return DB::fetch_first("SELECT * FROM ".DB::table('common_member')." WHERE uid='$uid'");
}


if(!function_exists('portalcp_article_pre_next')){
    function portalcp_article_pre_next($catid, $aid) {
        $data = array(
                      'preaid' => C::t('portal_article_title')->fetch_preaid_by_catid_aid($catid, $aid),
                      'nextaid' => C::t('portal_article_title')->fetch_nextaid_by_catid_aid($catid, $aid),
                      );
        if($data['preaid']) {
            C::t('portal_article_title')->update($data['preaid'], array(
                                                                        'preaid' => C::t('portal_article_title')->fetch_preaid_by_catid_aid($catid, $data['preaid']),
                                                                        'nextaid' => C::t('portal_article_title')->fetch_nextaid_by_catid_aid($catid, $data['preaid']),
                                                                        )
                                                 );
        }
        return $data;
    }
}



    if(!function_exists('portalcp_get_summary')){
    function portalcp_get_summary($message) {
        $message = preg_replace(array("/\[attach\].*?\[\/attach\]/", "/\&[a-z]+\;/i", "/\<script.*?\<\/script\>/"), '', $message);
        $message = preg_replace("/\[.*?\]/", '', $message);
        require_once libfile('function/home');
        $message = getstr(strip_tags($message), 200);
        return $message;
    }
}

function format_wrap($str, $exp_type = PHP_EOL){
    if(!$str) return false;
    $arr = explode($exp_type, trim($str));
    $arr = array_map('trim',$arr);
    $arr = array_filter($arr);
    return $arr;
}


function pload_upload_class(){
	if(file_exists(libfile('class/upload'))){
		require_once libfile('class/upload');
	}else{
		require_once libfile('discuz/upload', 'class');
	}
}


function pstripslashes($data){
	if(DISCUZ_VERSION != 'X2') return $data;
	return dstripslashes($data);
}

function paddslashes($data){
	if(DISCUZ_VERSION != 'X2') return $data;
	return daddslashes($data);
}


function content_html_ubb($content, $page_url, $is_htmlon = 0){
	if(DISCUZ_VERSION == 'X2.5' || DISCUZ_VERSION == 'X2') $is_htmlon = 0;//X3ÒÔÉÏ°æ±¾²ÅÓÐÕâ¸ö¹¦ÄÜ
	$content = img_htmlbbcode($content, $page_url);
	if($is_htmlon != 1) $content = media_htmlbbcode($content, $page_url, 'bbs', $is_htmlon);
	if($is_htmlon != 1) $content = audio_htmlbbcode($content, $page_url, 'bbs', $is_htmlon);
	if($is_htmlon == 1) return $content;
	$content = pick_html2bbcode($content);
	$content = htmlspecialchars_decode($content, ENT_QUOTES);
	$content = format_html($content);
	$content = unhtmlentities($content);
	$content = pick_parseed2k($content);//¶ÔÖÖ×ÓµØÖ·(ed2k://)µÄÌØÊâ´¦Àí
	return $content;
}


function img_htmlbbcode($text, $url = ''){
	$pregfind = array(
		'/<img[^>]*file="([^>]+)"[^>]*>/eiU',
		'/<img[^>]*picsrc="([^>]+)"[^>]*>/eiU',
	);
	$pregreplace = array(
		"img_tag('\\1', '".$url."')",
		"img_tag('\\1', '".$url."')",
	);
	return preg_replace($pregfind, $pregreplace, $text);
}



function pick_parseed2k($message){
	if(strpos($message, 'ed2k://') === FALSE) return $message;
	preg_match_all('/\[url=ed2k:\/\/(.*?)\](.*?)\[\/url\]/is', $message, $block_arr, PREG_SET_ORDER);//DZ2.0ºÍDZ2.5µÄ¸½¼þ
	$search_arr = $replace_arr = array();
	foreach((array)$block_arr as $k => $v){
		$search_arr[] = $v[0];
		$replace_arr[] = '[b]ed2k://'.$v[1].'[/b]';
	}
	if($search_arr[0]){
		$message = str_replace($search_arr, $replace_arr, $message);
	}
	return $message;
}




//ÊÓÆµ±êÇ©µÄ¹ýÂË
function media_htmlbbcode($text, $url= '', $type = 'bbs', $pick_htmlon = 0){
	global $_G;
	if(!$text) return;
	$pregfind = array(
		"/<embed([^>]*src[^>]*)>/eiU",
		"/<embed([^>]*src[^>]*)*\"><\/embed>/eiU",
	);

	$pregreplace = array(
		"mediatag('\\1', '".$url."', ".$type.")",
		"mediatag('\\1', '".$url."', ".$type.")",
	);
	return preg_replace($pregfind, $pregreplace, $text);
}


function audio_htmlbbcode($text, $url = '', $type = 'bbs', $pick_htmlon = 0){
	global $_G;
	if($pick_htmlon == 1){//¿ªÆôhtml
		preg_match_all('/<param\sname="(url|src)"\svalue="(.*?)"/is', stripslashes($text), $matches, PREG_SET_ORDER);
		if(is_array($matches[0])) {
			$audio_url = _expandlinks($matches[0][2], $url);
		}
		$replace_url = str_replace($matches[0][1], $audio_url, $matches[0][0]);
		$text = str_replace($matches[0][0], $replace_url, $text);
		return $text;
	}
	preg_match_all("/\<object(.*)?>(.*)?<\/object>/i", $text , $attach_arr, PREG_SET_ORDER);
	if(!$attach_arr) return $text;
	$search_arr = $replace_arr = array();
	foreach($attach_arr as $k => $v){
		if(strexists($v[0], '[/flash]')) continue;
		$search_arr[] = $v[0];
		$replace_arr[] = get_audio_param($v[1], $url, $type);
	}
	$text = str_replace($search_arr, $replace_arr, $text);
	return $text;
}

function get_audio_param($attributes, $page_url, $type = 'bbs') {
	global $_G;
	if(!$attributes) return;
	$attributes = dstripslashes($attributes);
	$value = array('width' => '', 'height' => '');
	preg_match_all('/(width|height)=(["\'])?([^\'" ]*)(?(2)\2)/i', dstripslashes($attributes), $matches);
	if(is_array($matches[1])) {
		foreach($matches[1] as $key => $attribute) {
			$value[strtolower($attribute)] = $matches[3][$key];
		}
	}
	$value['width'] = $value['width'] ? $value['width'] : 500;
	$value['height'] = $value['height'] ? $value['height'] : 375;
	preg_match_all('/<param\sname="(url|src)"\svalue="(.*?)"/is', stripslashes($attributes), $matches, PREG_SET_ORDER);
	if(is_array($matches[0])) {
		$audio_url = _expandlinks($matches[0][2], $page_url);
	}

	$ext = strtolower(substr(strrchr($audio_url, '.'), 1, 10));
	$x = in_array($ext, array('wmv', 'avi', 'rmvb', 'mov', 'swf', 'flv')) ? $ext : 'wmv';
	return $type == 'bbs' ? '[media='.$x.','.$value['width'].','.$value['height'].']'.$audio_url.'[/media]' : '[flash]'.$audio_url.'[/flash]';

}

function pick_html2bbcode($text) {
	//´¦Àípre±êÇ©
	require_once libfile('function/editor');
	$pre_arr = $blockcode_arr = array();
	if(strexists($text, '</pre>')){
		preg_match_all("/<pre.*>(.*)?<\/pre>/isU", $text, $pre_arr, PREG_SET_ORDER);
		if($pre_arr){
			$replace_key = 'DXCPICKPRE_';
			$replace_arr = array();
			foreach($pre_arr as $k => $v){
				$replace_arr['_old'][] = $v[0];
				$replace_arr['old'][] = str_replace($v[1], $replace_key.$k, $v[0]);
				$replace_arr['key'][] = $replace_key.$k;
				$v[1] = strip_tags($v[1], '');
				//$v[1] = str_replace('<br/>', "", $v[1]);
				$replace_arr['new'][] = $v[1];
			}
			$text = str_replace($replace_arr['_old'], $replace_arr['old'], $text);
		}
	}
	//´¦Àíblockcode±êÇ©
	if(strexists($text, '<div class="blockcode">')){
		preg_match_all("/<div class=\"blockcode\">(.*)?<\/em><\/div><br \/>/isU", $text, $blockcode_arr, PREG_SET_ORDER);
		if($blockcode_arr){
			$replace_key = 'DXCPICKCODE_';
			$blockcode_replace_arr = array();
			foreach($blockcode_arr as $k => $v){
				$blockcode_replace_arr['_old'][] = $v[0];
				$blockcode_replace_arr['old'][] = '[code]'.$replace_key.$k.'[/code]';
				$blockcode_replace_arr['key'][] = $replace_key.$k;
				$v[1] = strip_tags($v[1], '<li>');
				$v[1] = str_replace(array('<li>', '¸´ÖÆ´úÂë'), array("\r\n", ''), $v[1]);
				$blockcode_replace_arr['new'][] = '[code]'.$v[1].'[/code]';
			}
			$text = str_replace($blockcode_replace_arr['_old'], $blockcode_replace_arr['old'], $text);
		}
	}

	$text = strip_tags($text, '<table><tr><td><b><strong><i><em><u><a><div><span><p><strike><blockquote><pre><ol><ul><li><font><img><br><br/><h1><h2><h3><h4><h5><h6><script>');
	if(ismozilla()) {
		$text = preg_replace("/(?<!<br>|<br \/>|\r)(\r\n|\n|\r)/", ' ', $text);
	}
	$pregfind = array(
		"/<script.*>.*<\/script>/siU",
		'/on(mousewheel|mouseover|click|load|onload|submit|focus|blur)="[^"]*"/i',
		"/(\r\n|\n|\r)/",
		"/<table([^>]*(width|background|background-color|bgcolor)[^>]*)>/siUe",
		"/<table.*>/siU",
		"/<tbody.*>/siU",//ÕâÀïÐÂÔö
		"/<\/tbody>/i",//ÕâÀïÐÂÔö
		"/<blockquote.*>/siU",//ÕâÀïÐÂÔö
		"/<\/blockquote>/i",//ÕâÀïÐÂÔö
		"/<pre.*>/siU",//ÕâÀïÐÂÔö
		"/<\/pre>/i",//ÕâÀïÐÂÔö
		"/<tr.*>/siU",
		"/<td>/i",
		"/<td(.+)>/siUe",
		"/<\/td>/i",
		"/<\/tr>/i",
		"/<\/table>/i",
		'/<h([0-9]+)[^>]*>/siUe',
		'/<\/h([0-9]+)>/siU',
		"/<img[^>]+smilieid=\"(\d+)\".*>/esiU",
		"/<img([^>]*src[^>]*)>/eiU",
		"/<a\s+?name=.+?\".\">(.+?)<\/a>/is",
		"/<br.*>/siU",
		"/<span\s+?style=\"float:\s+(left|right);\">(.+?)<\/span>/is",
	);
	$pregreplace = array(
		'',
		'',
		'',
		"tabletag('\\1')",
		'[table]',
		'',//ÕâÀïÐÂÔö
		'',//ÕâÀïÐÂÔö
		'[quote]',//ÕâÀïÐÂÔö
		'[/quote]',//ÕâÀïÐÂÔö
		'[code]',//ÕâÀïÐÂÔö
		'[/code]',//ÕâÀïÐÂÔö
		'[tr]',
		'[td]',
		"tdtag('\\1')",
		'[/td]',
		'[/tr]',
		'[/table]',
		"\"[size=\".(7 - \\1).\"]\"",
		"[/size]\n\n",
		"smileycode('\\1')",
		"pick_imgtag('\\1')",
		'\1',
		"\n",
		"[float=\\1]\\2[/float]",
	);
	$text = preg_replace($pregfind, $pregreplace, $text);
	//´¦Àípre±êÇ©
	if($pre_arr) $text = str_replace($replace_arr['key'], $replace_arr['new'], $text);

	//´¦Àíblockcode±êÇ©
	if($blockcode_arr) $text = str_replace($blockcode_replace_arr['old'], $blockcode_replace_arr['new'], $text);

	$text = recursion('b', $text, 'simpletag', 'b');
	$text = recursion('strong', $text, 'simpletag', 'b');
	$text = recursion('i', $text, 'simpletag', 'i');
	$text = recursion('em', $text, 'simpletag', 'i');
	$text = recursion('u', $text, 'simpletag', 'u');
	$text = recursion('a', $text, 'atag');
	$text = recursion('font', $text, 'fonttag');
	$text = recursion('blockquote', $text, 'simpletag', 'indent');
	$text = recursion('ol', $text, 'listtag');
	$text = recursion('ul', $text, 'listtag');
	$text = recursion('div', $text, 'divtag');
	$text = recursion('span', $text, 'spantag');
	$text = recursion('p', $text, 'ptag');


	$pregfind = array("/(?<!\r|\n|^)\[(\/list|list|\*)\]/", "/<li>(.*)((?=<li>)|<\/li>)/iU", "/<p><\/p>/i", "/(<a>|<\/a>|<\/li>)/is", "/<\/?(A|LI|FONT|DIV|SPAN)>/siU", "/\[url[^\]]*\]\[\/url\]/i", "/\[url=javascript:[^\]]*\](.+?)\[\/url\]/is");
	$pregreplace = array("\n[\\1]", "\\1\n", '', '', '', '', "\\1");
	$text = preg_replace($pregfind, $pregreplace, $text);

	$strfind = array('&nbsp;', '&lt;', '&gt;', '&amp;');
	$strreplace = array(' ', '<', '>', '&');
	$text = str_replace($strfind, $strreplace, $text);
	return dhtmlspecialchars(trim($text));
}

function pick_imgtag($attributes) {
	$value = array('src' => '', 'width' => '', 'height' => '');
	preg_match_all("/(src|width|height)=([\"|\']?)([^\"']+)(\\2)/is", dstripslashes($attributes), $matches);
	if(is_array($matches[1])) {
		foreach($matches[1] as $key => $attribute) {
			$value[strtolower($attribute)] = $matches[3][$key];
		}
	}
	@extract($value);
	if(!preg_match("/^(http:|https:)\/\//i", $src)) {
		$src = absoluteurl($src);
	}
	return $src ? ($width && $height ? '[img='.$width.','.$height.']'.$src.'[/img]' : '[img]'.$src.'[/img]') : '';
}




function format_html($str){
	if(!$str) return;
	$format_str = stlang('format_str');
	$format_arr = explode('@', $format_str);
	foreach((array)$format_arr as $k => $v){
		$v_arr = explode('|', $v);
		$strfind[] = $v_arr[0];
		$strreplace[] = $v_arr[1];
	}
	$str = str_replace($strfind, $strreplace, $str);
	$str = str_replace('&nbsp;', ' ', $str);
	if(function_exists('mb_convert_encoding')){
		foreach(get_html_translation_table(HTML_ENTITIES) as $k=>$v) {
			$str = str_replace($v, mb_convert_encoding($v, CHARSET, "HTML-ENTITIES"), $str);
		}
	}
	return $str;
}


function unhtmlentities ($string) {
	$string = str_replace('&nbsp;', ' ', $string);
	// Get HTML entities table
	$trans_tbl = get_html_translation_table (HTML_ENTITIES, ENT_QUOTES);
	// Flip keys<==>values
	$trans_tbl = array_flip ($trans_tbl);
	// Add support for &apos; entity (missing in HTML_ENTITIES)
	$trans_tbl += array('&apos;' => "'");
	// Replace entities by values
	return strtr ($string, $trans_tbl);
}





function get_common_set(){
	global $_G;
	if($_G['cache']['plugin']['dxc_api']) return $_G['cache']['plugin']['dxc_api'];
	loadcache('plugin');
	return $_G['cache']['plugin']['dxc_api'];
}

if(!function_exists('dir_writeable')){

	function dir_writeable($dir) {
		if(!is_dir($dir)) {
			@mkdir($dir, 0777);
		}
		if(is_dir($dir)) {
			if($fp = @fopen("$dir/test.txt", 'w')) {
				@fclose($fp);
				@unlink("$dir/test.txt");
				$writeable = 1;
			} else {
				$writeable = 0;
			}
		}
		return $writeable;
	}

}


if(!function_exists('removedir')){
	function removedir($dirname, $keepdir = FALSE) {
        if(!is_dir($dirname)) {
            return FALSE;
        }
        $handle = opendir($dirname);
        while(($file = readdir($handle)) !== FALSE) {
                if($file != '.' && $file != '..') {
                        $dir = $dirname . DIRECTORY_SEPARATOR . $file;
                        is_dir($dir) ? removedir($dir) : unlink($dir);
                }
        }
        closedir($handle);
        return !$keepdir ? (@rmdir($dirname) ? TRUE : FALSE) : TRUE;
	}

}


function mediatag_format($src, $width = 0, $height = 0, $page_url = '') {
	if(!preg_match("/^http:\/\//i", $src)) {
		$src = _expandlinks($src, $page_url);
	}
	return '[flash]'.$src.'[/flash]';//√≈ªß∫Õ≤©øÕ—π∏˘æÕ≤ª–Ë“™≥§øÌ’‚–©£¨’’—˘ƒ‹≤•∑≈ ”∆µ

}

function _expandlinks($links,$URI)
{
	$links = trim($links);
	$URI = trim($URI);
	$links = html_entity_decode($links);
	$links =  str_replace(array("\/", "\\/"), array("/", '/'), $links);
	preg_match("/^[^\?]+/",$URI,$match);
	$url_parse_arr = parse_url($URI);
	$check = strpos($links, "?");
	if($check == 0 && $check !== FALSE){
		return $url_parse_arr["scheme"]."://".$url_parse_arr["host"].'/'.$url_parse_arr['path'].$links;
	}
	$check = strpos($links, "../");
	if($check == 0 && $check !== FALSE){//Ïà¶ÔÂ·¾¶
		$check_arr = explode('/', $url_parse_arr['path']);
		if(trim(end($check_arr))) {//×îºóÒ»¸ö×Ö·ûÊÇ/µÄÊ±ºò
			$path = dirname($url_parse_arr['path']);
		}else{
			$path = $url_parse_arr['path'];
		}
		$path_arr = explode('/', $path);
		array_shift($path_arr);
		$path_arr = array_filter($path_arr);
		$i = 0;
		while ( substr ( $links, 0, 3 ) == "../" ) {
			$links = substr ( $links, strlen ( $links ) - (strlen ( $links ) - 3), strlen ( $links ) - 3 );
			$i++;
		}
		$temp_arr = array_slice($path_arr, 0, count($path_arr) - $i);
		return $url_parse_arr["scheme"]."://".$url_parse_arr["host"].'/'.($temp_arr ? implode('/',$temp_arr).'/' : '').$links;
	}
	$match = preg_replace("|/[^\/\.]+\.[^\/\.]+$|","",$match[0]);
	$match = preg_replace("|/$|","",$match);
	$match_part = parse_url($match);
	//¾ÀÕýÀàËÆÕâÑù£¬ÓÐ¶à¸öµãµÄ»á³ö´í http://www.56php.com/54.345.html
	if($match_part['path'] && strexists($match_part['path'], '.htm') || strexists($match_part['path'], '.html')){
		$exp_info = explode('/', $match_part['path']);
		$last = end($exp_info);
		$match = str_replace('/'.$last, '', $match);
	}
	$port = $match_part["port"]  ?  ':'.$match_part["port"] : '';
	$match_root = $match_part["scheme"]."://".$match_part["host"].$port;
	$links = str_replace('https://', 'http://ASDFAFDSAFASDFSDA', $links);
	$search = array( 	"|^http://".preg_quote($match_root)."|i",
						"|^(\/)|i",
						"|^(?!http://)(?!mailto:)|i",
						"|/\./|",
						"|/[^\/]+/\.\./|"
					);

	$replace = array(	"",
						$match_root."/",
						$match."/",
						"/",
						"/"
					);
	$expandedLinks = preg_replace($search,$replace,$links);
	$expandedLinks = str_replace('http://ASDFAFDSAFASDFSDA', 'https://', $expandedLinks);
	return $expandedLinks;
}

function mediatag($attributes, $page_url, $type = 'bbs') {
	global $_G;
	$attributes = dstripslashes($attributes);
	$value = array('src' => '', 'width' => '', 'height' => '', 'flashvars' => '');
	preg_match_all('/(src|width|flashvars|height)=(["\'])?([^\'" ]*)(?(2)\2)/i', $attributes, $matches);
	if(is_array($matches[1])) {
		foreach($matches[1] as $key => $attribute) {
			$attribute = strtolower($attribute);
			$value[$attribute] = $matches[3][$key];
		}
	}

	@extract($value);
	if($flashvars)  {

		parse_str($flashvars);
		$flash_src = $file;
	}
	if(!preg_match("/^http:\/\//i", $src)) {
		$src = _expandlinks($src, $page_url);
	}
	if(!preg_match("/^http:\/\//i", $flash_src) && $flash_src) {
		$flash_src = _expandlinks($flash_src, $page_url);
	}
	$src_info = parse_url($src);
	$ext = strtolower(substr(strrchr($src_info['path'], '.'), 1, 10));
	if(strexists($ext, '&')){
		$ext = current(explode('&', $ext));
	}
	if(strexists($ext, '?')){
		$ext = current(explode('?', $ext));
	}
	if($ext == 'swf'){
		$src = $flash_src ? $flash_src : $src;
		return $src ? ($width && $height && $type == 'bbs' ? '[flash='.$width.','.$height.']'.$src.'[/flash]' : '[flash]'.$src.'[/flash]') : '';
	}else{
		$file_ext = addslashes(strtolower(substr(strrchr($src, '.'), 1, 10)));
		if($type != 'bbs'){
			//if($file_ext == 'wmv'){
				$media_type = 'media';
			//}
			return $src ? '[flash]'.$src.'[/flash]' : '';
		}
		if(!$src) return '';
		switch(strtolower($file_ext)) {
			case 'mp3':
			case 'wma':
			case 'ra':
			case 'ram':
			case 'wav':
			case 'mid':
				return '[audio]'.$src.'[/audio]';
			case 'wmv':
			case 'rm':
			case 'rmvb':
			case 'avi':
			case 'asf':
			case 'mpg':
			case 'mpeg':
			case 'mov':
			case 'flv':
			case 'swf':
				return '[media='.$attach['ext'].','.$width.','.$height.']'.$src.'[/media]';
			default:
				return '[media=x,'.$width.','.$height.']'.$src.'[/media]';
		}
	}
}


function object_to_array($obj){
	$_arr = is_object($obj)? get_object_vars($obj) : $obj;
	foreach ((array)$_arr as $key => $val) {
		$val = (is_array($val)) || is_object($val) ? object_to_array($val) : $val;
		$arr[$key] = $val;
	}

	return $arr;
}

?>