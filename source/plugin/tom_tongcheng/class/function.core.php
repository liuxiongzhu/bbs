<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
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

function contentFormat($content){
    
    $content = dhtmlspecialchars($content);
    
    $pos = strpos($content,"|+|+|+|+|+|+|+|+|+|");
    if($pos === false){
        return $content;
    }else if($pos === 0){
        return "";
    }else{
        return substr($content, 0, $pos);
    }
    
}

function filterEmojiMatches($match){
	return strlen($match[0]) >= 4 ? '' : $match[0];
}

function filterEmoji($str){
    
    if(CHARSET == 'utf-8') {
        $str = preg_replace_callback(
           '/./u',
           'filterEmojiMatches',
		   $str);
    }

    return $str;
  
 }
 
 /**
 * ���������������֮��ľ���
 * @param  Decimal $longitude1 ��㾭��
 * @param  Decimal $latitude1  ���γ��
 * @param  Decimal $longitude2 �յ㾭��
 * @param  Decimal $latitude2  �յ�γ��
 * @param  Int     $unit       ��λ 1:�� 2:����
 * @param  Int     $decimal    ���� ����С��λ��
 * @return Decimal
 */
function tomGetDistance($longitude1, $latitude1, $longitude2, $latitude2, $unit=2, $decimal=1){

    $EARTH_RADIUS = 6370.996; // ����뾶ϵ��
    $PI = 3.1415926;

    $radLat1 = $latitude1 * $PI / 180.0;
    $radLat2 = $latitude2 * $PI / 180.0;

    $radLng1 = $longitude1 * $PI / 180.0;
    $radLng2 = $longitude2 * $PI / 180.0;

    $a = $radLat1 - $radLat2;
    $b = $radLng1 - $radLng2;

    $distance = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1) * cos($radLat2) * pow(sin($b/2),2)));
    $distance = $distance * $EARTH_RADIUS * 1000;

    if($unit==2){
        $distance = $distance / 1000;
    }

    return round($distance, $decimal);

}