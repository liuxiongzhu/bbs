<?php


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


function get_member_setarr($v){
	global $_G;
	$v = dstripslashes($v);
	$config = array('oltime' => '0,3', 'extcredits1' => '0,10', 'extcredits1' => '0,10', 'extcredits2' => '0,10', 'extcredits3' => '0,10');
	$v['username'] = str_replace(' ', '', $v['username']);
	$v['username'] = trim($v['username']);
	$v['username'] = strtolower($v['username']);
	if(strlen($v['username']) > 15){
		$v['username'] = cutstr($v['username'], 15, '');
	}
	var_dump($v);
	$setarr = $v;
	$setarr['oltime'] = $v['oltime'] ? $v['oltime'] : rand(1,5);
	$setarr['regdate'] = $v['regdate'] ? $v['regdate'] : time();
	$setarr['lastvisit'] = $setarr['lastactivity'] = rand($setarr['regdate'], $_G['timestamp']);

	$setarr['email'] = $v['email'] ? $v['email'] : rand_email($v['username']);
	if(!$v['qq']){
		if(strexists($setarr['email'], '@qq.com')){
			$qq_arr = explode('@', $setarr['email']);
			$setarr['qq'] = $qq_arr[0];
		}else{
			$setarr['qq'] = rand(55054836, 1450250164);
		}
	}
	$setarr['email'] = str_replace(array('~', ''), rand(1,99), $setarr['email']);
	$setarr['qq'] = intval($setarr['qq']);
	$info['rand_ip'] = $info['rand_ip'] ? $info['rand_ip'] : '202.106.189.3,202.106.189.4,202.106.189.6,218.247.166.82,218.30.119.114,218.30.119.114 4408,218.64.220.220,218.64.220.2,219.148.122.113,219.232.236.116,221.225.1.239,222.188.10.1,222.223.65.3,222.73.26.211,58.211.0.113,58.214.238.238,202.105.55.38,221.179.35.71,222.64.185.148,114.255.171.231,125.77.200.134';
	$ip_arr = format_wrap($info['rand_ip'], ',');
	$rand_ip = parray_rand($ip_arr);
	$setarr['lastip'] = $info['ip_type'] == 1 && $v['lastip'] ? $v['lastip'] : $rand_ip;
	$setarr['regip'] = $info['ip_type'] == 1 && $v['regip'] ? $v['regip'] : $rand_ip;
	$credits_list = credits_list();
	foreach((array)$credits_list as $k2 => $v2){
		$setarr[$v2['name']] = $info[$v2['name'].'_type'] == 1 && $v[$v2['name']] ? $v[$v2['name']] : get_data_range($config[$v2['name']], -1, 1);
	}


	return $setarr;
}


function credits_list(){
	global $_G;
	if(empty($_G['setting']['extcredits'])) return;
	foreach($_G['setting']['extcredits'] as $key => $value) {
		$arr[] = array('name' => 'extcredits'.$key, 'title' => $value['title']);
	}
	return $arr;
}


function get_data_range($str, $start = 0, $num = 1){
	$str = trim($str);
	if(!$str && $num == 1 ) return 0;
	if(!$str && $num > 1 ) return array();
	if(strexists($str, ',')){
		$str_arr = format_wrap($str, ',');
		$str_arr = array_filter($str_arr, 'intval') ;
		$str_arr[0] = intval($str_arr[0]);
		$str_arr[1] = intval($str_arr[1]);
		if($start < 0){
			for($i = 1; $i < $num + 1; $i++){
				$re_arr[] = rand($str_arr[0], $str_arr[1]);
			}
			return $num == 1 ? $re_arr[0] : $re_arr;
		}else{
			$start += $str_arr[0];
			$end = $start + $num - 1;
			$end = ($end > $str_arr[1]) ? $str_arr[1] : $end;
			$re_arr['list'] = $start > $str_arr[1] ? array() : range($start, $end);
			$re_arr['num'] = $num;
			$re_arr['all_num'] = ($str_arr[1] - $str_arr[0]) + 1;
		}
	}else if(strexists($str, '|')){
		$arr = format_wrap($str, '|');
		$end = $start + $num;
		if($start < 0){
			return array_rand($arr, $num);
		}else{
			$re_arr['list'] = array_slice($arr, $start, $end);
			$re_arr['num'] = $re_arr['all_num'] = count($arr);
		}
	}else{
		$re_arr['list'] = array($str);
		if($start < 0) return $str;
		$re_arr['num'] = $re_arr['all_num'] = 1;
	}
	return $re_arr;
}


function rand_email($username){
	$arr = array('@126.com', '@163.com', '@qq.com', '@gmail.com', '@hotmail.com', '@sina.com', '@yahoo.com.cn', '@yahoo.cn', '@sohu.com', '@139.com' );
	$a = rand(0 , (count($arr) - 1));
	$h = $arr[$a];
	$a=ereg('['.chr(0xa1).'-'.chr(0xff).']', $username);
    $b=ereg('[0-9]', $username);
    $c=ereg('[a-zA-Z]', $username);
	if((!$a && $b && $c) || (!$a && $b && !$c) || (!$a && !$b && $c)){
		$f = $username;
	}else{
		if($h == '@qq.com') return random(8, 1).'@qq.com';
		$f = strtolower(random(rand(6,9)));
	}
	return $f.$h;
}

function get_avatar_path($uid, $size = 'middle'){
	global $_G;
	if(!$uid) return;
	$pick_set = get_common_set();
	$uc_server_dir = !empty($pick_set['uc_server_dir']) ? $pick_set['uc_server_dir'] : './uc_server';
	$path = $uc_server_dir.'/'.get_avatar($uid, $size);
	$path = relative_to_absolute($path);
	return $path;
}

function parray_rand($arr, $num = 1){
	$key = array_rand($arr, $num);
	$data_arr = array();
	foreach($key as $k => $v){
		$data_arr[] = $arr[$v];
	}
	if($num > 1) return $data_arr;
	return $arr[$key];
}


function relative_to_absolute($relative, $cur = ''){
	$cur = $cur ? $cur : DISCUZ_ROOT.'/source';
    $cur = str_replace('//', '/', $cur);
    $relative = str_replace('//', '/', $relative);
    $curArr = explode('/', $cur);
    $reArr = explode('/', $relative);
    $curlen = count($curArr);
    $relen = count($reArr);
    $base = dirname($cur);
    if($reArr[0] == '..'){
        foreach ($reArr as $val){
            if($val=='..') {
                $base=dirname($base);
                continue;
            }
            return $base.'/'.str_replace('../','',$relative);
        }
    }elseif($reArr[0]==''){
        return $relative;
    }else{
        if($reArr[0]=='.'){
            return $base.'/'.str_replace('./','',$relative);
        }
        return $base.'/'.$relative;
    }
}


function reg_error($errno){
	$errmsg = array(
		'-10' => stlang('too_short'),
		'-11' => stlang('too_long'),
		'-1' => stlang('bad_word'),
		'-2' => stlang('system_bad_word'),
		'-3' => stlang('reged'),
		'-4' => stlang('wrong_email'),
		'-5' => stlang('bad_email'),
		'-6' => stlang('email_reged'),
		'-7' => stlang('password_empty'),
		'-100' => stlang('unknow_error'),
	);

	return array('errno'=> $errno, 'errmsg' => $errmsg[$errno]);
}



function dxc_member_reg($info){

	global $_G;
	$member = $info;
	extract($info);

	if(empty($password)) return reg_error(-7);

	loaducenter();
	require_once libfile('function/misc');
	require_once libfile('function/profile');
	include_once libfile('class/member');

	$re_arr = array();

	$activation = array();
	if(!$activation) {
		$usernamelen = dstrlen($username);
		if($usernamelen < 3) {
			return reg_error(-10);
		} elseif($usernamelen > 15) {
			return reg_error(-11);
		}
		$username = addslashes(trim(dstripslashes($username)));
		$email = trim($email);
	}

	if(!$activation) {
		$uid = uc_user_register($username, $password, $email, $questionid, $answer, $_G['clientip']);

		if($uid <= 0) {
			if($uid == -1) {
				return reg_error(-1);
			} elseif($uid == -2) {
				return reg_error(-2);
			} elseif($uid == -3) {
				return reg_error(-3);
			} elseif($uid == -4) {
				return reg_error(-4);
			} elseif($uid == -5) {
				return reg_error(-5);
			} elseif($uid == -6) {
				return reg_error(-6);
			} else {
				return reg_error(-100);
			}
		}
	} else {
		list($uid, $username, $email) = $activation;
	}
	if(DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE uid='$uid'")) {
		if(!$activation) {
			uc_user_delete($uid);
		}
		return milu_lang('uid_reged');
	}
	$init_arr = explode(',', $_G['setting']['initcredits']);
	$groupinfo['groupid'] = $_G['setting']['newusergroupid'];

	$password = md5(random(10));
	$secques = $questionid > 0 ? random(8) : '';
	$profile['constellation'] = get_constellation($birthmonth, $birthday);
	$profile['zodiac'] = get_zodiac($birthyear);
	$profile['gender'] = rand(0, 1);

	$lastactivity =rand($regdate, ($regdate + 3600*24*2));
	if($regipsql) {
		DB::query($regipsql);
	}

	$credits = 0;
	if(!empty($_G['setting']['creditsformula'])) {
		eval("\$credits = round(".$_G['setting']['creditsformula'].");");
	}
	$userdata = array(
		'uid' => $uid,
		'username' => $username,
		'password' => $password,
		'email' => $email,
		'adminid' => 0,
		'groupid' => $groupinfo['groupid'],
		'regdate' => $regdate,
		'credits' => $credits,
		'timeoffset' => 9999
	);
	$status_data = array(
		'uid' => $uid,
		'regip' => $regip,
		'lastip' => $lastip,
		'lastvisit' => $lastvisit,
		'lastactivity' => $lastactivity,
		'lastpost' => $lastpost,
		'lastsendmail' => 0,
	);
	$profile['uid'] = $uid;
	$field_forum['uid'] = $uid;
	$field_forum['sightml'] = $sightml;

	$field_home['uid'] = $uid;


	DB::insert('common_member', paddslashes($userdata));
	DB::insert('common_member_status', paddslashes($status_data));
	DB::insert('common_member_profile', paddslashes($profile));
	DB::insert('common_member_field_forum', paddslashes($field_forum));
	DB::insert('common_member_field_home', paddslashes($field_home));


	if($verifyarr) {
		$setverify = array(
			'uid' => $uid,
			'username' => $username,
			'verifytype' => '0',
			'field' => daddslashes(serialize($verifyarr)),
			'dateline' => $lastactivity,
		);
		DB::insert('common_member_verify_info', $setverify);
		DB::insert('common_member_verify', array('uid' => $uid));
	}
	$count_data = array(
		'uid' => $uid,
		'oltime' => $oltime ? $oltime : 0,
		'extcredits1' => $extcredits1 ? $extcredits1 : $init_arr[1],
		'extcredits2' => $extcredits2 ? $extcredits2 : $init_arr[2],
		'extcredits3' => $extcredits3 ? $extcredits3 : $init_arr[3],
		'extcredits4' => $extcredits4 ? $extcredits4 : $init_arr[4],
		'extcredits5' => $extcredits5 ? $extcredits5 : $init_arr[5],
		'extcredits6' => $extcredits6 ? $extcredits6 : $init_arr[6],
		'extcredits7' => $extcredits7 ? $extcredits7 : $init_arr[7],
		'extcredits8' => $extcredits8 ? $extcredits8 : $init_arr[8]
	);
	DB::insert('common_member_count', paddslashes($count_data));
	DB::insert('common_setting', array('skey' => 'lastmember', 'svalue' => $username), false, true);
	manyoulog('user', $uid, 'add');

	$totalmembers = DB::result_first("SELECT COUNT(*) FROM ".DB::table('common_member'));
	$userstats = array('totalmembers' => $totalmembers, 'newsetuser' => $username);

	checkusergroup($uid);

	save_syscache('userstats', $userstats);
	$re_arr['uid'] = $uid;
	$re_arr['username'] = $username;
	return $re_arr;

}

function create_avatar_dir($uid, $size = 'middle'){
	$avatar_dir = get_avatar($uid, $size, '', true);
	$uc_server_dir = get_uc_server_dir();
	$avatar_dir_save = $uc_server_dir.'/'.$avatar_dir;
	$avatar_dir_save = relative_to_absolute($avatar_dir_save);
	return dmkdir($avatar_dir_save);
}

function get_uc_server_dir(){
	$pick_config = get_common_set();
	return $pick_config['uc_server_dir'] ? $pick_config['uc_server_dir'] : './uc_server';
}

function get_avatar($uid, $size = 'middle', $type = '', $dir = false) {
	$size = in_array($size, array('big', 'middle', 'small')) ? $size : 'middle';
	$uid = abs(intval($uid));
	$uid = sprintf("%09d", $uid);
	$dir1 = substr($uid, 0, 3);
	$dir2 = substr($uid, 3, 2);
	$dir3 = substr($uid, 5, 2);
	$typeadd = $type == 'real' ? '_real' : '';
	if($dir){
		return 'data/avatar/'.$dir1.'/'.$dir2.'/'.$dir3.'/';
	}else{
		return 'data/avatar/'.$dir1.'/'.$dir2.'/'.$dir3.'/'.substr($uid, -2).$typeadd."_avatar_$size.jpg";
	}

}




?>