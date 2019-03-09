<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$site_id = intval($_GET['site'])>0? intval($_GET['site']):1;

set_time_limit(0);

$tcshopConfig = $_G['cache']['plugin']['tom_tcshop'];

$tcshop_id = intval($_GET['tcshop_id'])>0? intval($_GET['tcshop_id']):0;

if($_GET['formhash'] == FORMHASH){
}else{
    echo 'HASH|XXX';exit;
}

$tcshopInfo = C::t('#tom_tcshop#tom_tcshop')->fetch_by_id($tcshop_id);
if($tcshopInfo){
}else{
    echo 'TCSHOPID|XXX';exit;
}

if(!preg_match('/^http/', $tcshopInfo['picurl']) ){
    if(strpos($tcshopInfo['picurl'], 'source/plugin/tom_tcshop/') === FALSE){
        $picurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : DISCUZ_ROOT).$_G['setting']['attachurl'].'tomwx/'.$tcshopInfo['picurl'];
    }else{
        $picurl = DISCUZ_ROOT.$tcshopInfo['picurl'];
    }
}else{
    $picurl = $tcshopInfo['picurl'];
}

$qrcodeKey = md5($site_id.'------'.$tcshop_id.'-----'.$picurl);

$qrcodeUrl      = 'source/plugin/tom_tcshop/data/xiao/'.$qrcodeKey.'_qrcode.png';
$qrcodeImg      = DISCUZ_ROOT.'./source/plugin/tom_tcshop/data/xiao/'.$qrcodeKey.'_qrcode.png';
$picurlImg      = DISCUZ_ROOT.'./source/plugin/tom_tcshop/data/xiao/'.$qrcodeKey.'_picurl.png';
$picurlSmallImg = DISCUZ_ROOT.'./source/plugin/tom_tcshop/data/xiao/'.$qrcodeKey.'_picurl_small.png';

if(file_exists($qrcodeImg) && getimagesize($qrcodeImg)){
    echo 'OK|'.$qrcodeUrl;exit;
}

$tempDir = "/source/plugin/tom_tcshop/data/xiao/";
$tempDir = DISCUZ_ROOT.'.'.$tempDir;
if(!is_dir($tempDir)){
    mkdir($tempDir, 0777,true);
}else{
    chmod($tempDir, 0777); 
}

$picurlData = file_get_contents($picurl);
file_put_contents($picurlImg, $picurlData);
require_once libfile('class/image');
$image = new image();
$image->Thumb($picurlImg, '', 197, 197, 2, 1);

circlePic($picurlImg,$picurlSmallImg);

$xiaoQrcodeSrc = '';
$xiaoQrcodeStatus = 404;
if(file_exists(DISCUZ_ROOT.'./source/plugin/tom_xiaofenlei/qrcode.func.php')){
    include DISCUZ_ROOT.'./source/plugin/tom_xiaofenlei/qrcode.func.php';
    $xiaor = xiaoGetwxacodeunlimit("pages/index/tcshop",$site_id.'_'.$tcshop_id,430);
    if(isset($xiaor['code']) && $xiaor['code'] == 0 && !empty($xiaor['src'])){
        $xiaoQrcodeSrc = $xiaor['src'];
        $xiaoQrcodeStatus = 1;
    }
}

if($xiaoQrcodeStatus == 404){
    echo 'XIAO|'.$xiaor['code'].'|'.$xiaor['msg'];exit;
}

watermark_img(DISCUZ_ROOT.'./'.$xiaoQrcodeSrc,$qrcodeImg,$picurlSmallImg);

@unlink($picurlImg);
@unlink($picurlSmallImg);

echo 'OK|'.$qrcodeUrl;exit;


function circlePic($url,$dest_path='./'){  
    $w              = 197;  
    $h              = 197;
    $original_path  = $url;  
    $src            = imagecreatefromstring(file_get_contents($original_path));  
    $newpic         = imagecreatetruecolor($w,$h);  
    imagealphablending($newpic,false);  
    $transparent    = imagecolorallocatealpha($newpic, 0, 0, 0, 127);  
    $r = $w/2;  
    for($x=0;$x<$w;$x++){
        for($y=0;$y<$h;$y++){  
            $c  = imagecolorat($src,$x,$y);  
            $_x = $x - $w/2;  
            $_y = $y - $h/2;  
            if((($_x*$_x) + ($_y*$_y)) < ($r*$r)){  
                imagesetpixel($newpic,$x,$y,$c);  
            }else{  
                imagesetpixel($newpic,$x,$y,$transparent);  
            }  
        }
    }  
    imagesavealpha($newpic, true);  
    imagepng($newpic, $dest_path);  
    imagedestroy($newpic);  
    imagedestroy($src);  
    return $dest_path;  
}

function watermark_img($source_path,$target_path,$watermark_path){
    
    $source = imagecreatefromstring(file_get_contents($source_path));
    $watermark = imagecreatefromstring(file_get_contents($watermark_path));
    
    list($source_w, $source_h, $source_type) = getimagesize($source_path);
    list($watermark_w, $watermark_h) = getimagesize($watermark_path);
    
    $x = ($source_w - $watermark_w) / 2;
    $y = ($source_h - $watermark_h) / 2; 
    
    imagecopy($source, $watermark, $x, $y, 0, 0, $watermark_w, $watermark_h);
    
    switch ($source_type) {
        case 1:
            imagegif($source,$target_path);
            break;
        case 2:
            imagejpeg($source,$target_path);
            break;
        case 3:
            imagepng($source,$target_path);
            break;
        default:
            break;
    }
    
    imagedestroy($source);
    imagedestroy($watermark);
    
    return $y;
}