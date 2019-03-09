<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

set_time_limit(0);
$tcshopConfig = $_G['cache']['plugin']['tom_tcshop'];

if('utf-8' != CHARSET) {
    if(defined('IN_MOBILE')) {}else{
        foreach($_POST AS $pk => $pv) {
            if(!is_numeric($pv)) {
                $_GET[$pk] = $_POST[$pk] = wx_iconv_recurrence($pv);
            }
        }
    }
}

$dataURL = isset($_GET['dataURL'])? daddslashes($_GET['dataURL']):'';

$qrcodeImg = DISCUZ_ROOT.'./source/plugin/tom_tcshop/data/haibao/'.md5($dataURL).'_qrcode.png';
$qrcodeUrl = 'source/plugin/tom_tcshop/data/haibao/'.md5($dataURL).'_qrcode.png';

$tempDir = "/source/plugin/tom_tcshop/data/haibao/";
$tempDir = DISCUZ_ROOT.'.'.$tempDir;
if(!is_dir($tempDir)){
    mkdir($tempDir, 0777,true);
}else{
    chmod($tempDir, 0777); 
}

$base_img = str_replace('data:image/png;base64,', '', $dataURL);
$base_img = base64_decode($base_img);

if(false === file_put_contents($qrcodeImg,$base_img)){
    echo 'NO|'.$qrcodeUrl;exit;
}else{
    echo 'OK|'.$qrcodeUrl;exit;
}

function wx_iconv_recurrence($value) {
	if(is_array($value)) {
		foreach($value AS $key => $val) {
			$value[$key] = wx_iconv_recurrence($val);
		}
	} else {
		$value = diconv($value, 'utf-8', CHARSET);
	}
	return $value;
}


