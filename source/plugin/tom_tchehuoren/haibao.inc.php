<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

set_time_limit(0);
$tchehuorenConfig = $_G['cache']['plugin']['tom_tchehuoren'];
$plugin_id = 'tom_tchehuoren';

if('utf-8' != CHARSET) {
    if(defined('IN_MOBILE')) {}else{
        foreach($_POST AS $pk => $pv) {
            if(!is_numeric($pv)) {
                $_GET[$pk] = $_POST[$pk] = wx_iconv_recurrence($pv);
            }
        }
    }
}

$share_url = isset($_GET['share_url'])? daddslashes($_GET['share_url']):'';

include DISCUZ_ROOT.'./source/plugin/'.$plugin_id.'/class/function.haibao.php';

if(file_exists(DISCUZ_ROOT.'./source/plugin/tom_qrcode/phpqrcode/phpqrcode.php')){
    include DISCUZ_ROOT.'./source/plugin/tom_qrcode/phpqrcode/phpqrcode.php';
}else{
    echo 'QR|phpqrcode';exit;
}

if(empty($tchehuorenConfig['haibao_bg'])){
    echo 'HB|nothaibao';exit;
}else{
    $bgImg = $tchehuorenConfig['haibao_bg'];
}

$haibaoKey = md5($share_url.$bgImg);

$haibaoImg = DISCUZ_ROOT.'./source/plugin/tom_tchehuoren/data/haibao/'.$haibaoKey.'_haibao.png';
$haibaoUrl = $_G['siteurl'].'./source/plugin/tom_tchehuoren/data/haibao/'.$haibaoKey.'_haibao.png';

if(file_exists($haibaoImg)){
    echo 'OK|'.$haibaoUrl;exit;
}

$tempDir = "/source/plugin/tom_tchehuoren/data/haibao/";
$tempDir = DISCUZ_ROOT.'.'.$tempDir;
if(!is_dir($tempDir)){
    mkdir($tempDir, 0777,true);
}else{
    chmod($tempDir, 0777); 
}

$tempImg = $tempDir.$haibaoKey;

QRcode::png($share_url,$tempImg.'_qrcode.png','H',5,2);

require_once libfile('class/image');
$image = new image();
$image->Thumb($tempImg.'_qrcode.png', '', 240, 240, 1, 1);

$linshiImg = DISCUZ_ROOT.'./source/plugin/tom_tchehuoren/data/haibao/'.$haibaoKey.'_lingshihaibao.png';
$bg_pic_content = file_get_contents($bgImg);
if(false ===file_put_contents($linshiImg,$bg_pic_content)){
    $linshiImg = $bgImg;
}

share_haibao_img($linshiImg,$tempImg.'_haibao.png',$tempImg.'_qrcode.png',385);

@unlink($tempImg.'_qrcode.png');
@unlink($tempImg.'_new.png');
@unlink($tempImg.'_lingshihaibao.png');

echo 'OK|'.$haibaoUrl;exit;

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



