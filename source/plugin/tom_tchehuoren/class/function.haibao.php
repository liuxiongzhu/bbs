<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function share_haibao_text($source_path,$target_path,$text,$y,$font){
    
    $source = imagecreatefromstring(file_get_contents($source_path));
    
    list($source_w, $source_h, $source_type) = getimagesize($source_path);
    
    $black = imagecolorallocate($source, 0x00, 0x00, 0x00);
    
    $text_arr =  preg_split('/(?<!^)(?!$)/u', $text);
    
    $text1 = $text2 = $text3 = '';
    if(count($text_arr) <= 15){
        $text1 = $text_arr[0].$text_arr[1].$text_arr[2].$text_arr[3].$text_arr[4].$text_arr[5].$text_arr[6].$text_arr[7].$text_arr[8].$text_arr[9].$text_arr[10].$text_arr[11].$text_arr[12].$text_arr[13].$text_arr[14].'';
    }else if(count($text_arr) <= 30){
        $text1 = $text_arr[0].$text_arr[1].$text_arr[2].$text_arr[3].$text_arr[4].$text_arr[5].$text_arr[6].$text_arr[7].$text_arr[8].$text_arr[9].$text_arr[10].$text_arr[11].$text_arr[12].$text_arr[13].$text_arr[14].'';
        $text2 = $text_arr[15].$text_arr[16].$text_arr[17].$text_arr[18].$text_arr[19].$text_arr[20].$text_arr[21].$text_arr[22].$text_arr[23].$text_arr[24].$text_arr[25].$text_arr[26].$text_arr[27].$text_arr[28].$text_arr[29];
    }else{
        $text1 = $text_arr[0].$text_arr[1].$text_arr[2].$text_arr[3].$text_arr[4].$text_arr[5].$text_arr[6].$text_arr[7].$text_arr[8].$text_arr[9].$text_arr[10].$text_arr[11].$text_arr[12].$text_arr[13].$text_arr[14].'';
        $text2 = $text_arr[15].$text_arr[16].$text_arr[17].$text_arr[18].$text_arr[19].$text_arr[20].$text_arr[21].$text_arr[22].$text_arr[23].$text_arr[24].$text_arr[25].$text_arr[26].$text_arr[27].$text_arr[28].$text_arr[29];
        $text3 = $text_arr[30].$text_arr[31].$text_arr[32].$text_arr[33].$text_arr[34].$text_arr[35].$text_arr[36].$text_arr[37].$text_arr[38].$text_arr[39].$text_arr[40].$text_arr[41].$text_arr[42].$text_arr[43].$text_arr[44].'';
    }
    
    if(!empty($text1)){
        $text_info = imagettfbbox(13,0,$font,$text1);
        $text_w = $text_info[2] - $text_info[6]; 
        $text_h = $text_info[3] - $text_info[7]; 
        $x = ($source_w - $text_w) / 2;
        imageTTFText($source, 13, 0, $x, $y, $black, $font, $text1);
        $y = $y+$text_h+5;
    }
    if(!empty($text2)){
        $text_info = imagettfbbox(13,0,$font,$text2);
        $text_w = $text_info[2] - $text_info[6]; 
        $text_h = $text_info[3] - $text_info[7]; 
        $x = ($source_w - $text_w) / 2; 
        imageTTFText($source, 13, 0, $x, $y, $black, $font, $text2);
        $y = $y+$text_h+5;
    }
    if(!empty($text3)){
        $text_info = imagettfbbox(13,0,$font,$text3);
        $text_w = $text_info[2] - $text_info[6]; 
        $text_h = $text_info[3] - $text_info[7]; 
        $x = ($source_w - $text_w) / 2; 
        imageTTFText($source, 13, 0, $x, $y, $black, $font, $text3);
        $y = $y+$text_h+5;
    }
    
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
    
    return $y;
}

function share_haibao_img($source_path,$target_path,$watermark_path,$y){
    
    $source = imagecreatefromstring(file_get_contents($source_path));
    $watermark = imagecreatefromstring(file_get_contents($watermark_path));
    
    list($source_w, $source_h, $source_type) = getimagesize($source_path);
    list($watermark_w, $watermark_h) = getimagesize($watermark_path);
    
    $x = ($source_w - $watermark_w) / 2; 
    
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