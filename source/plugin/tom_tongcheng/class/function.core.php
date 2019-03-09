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
 * 计算两点地理坐标之间的距离
 * @param  Decimal $longitude1 起点经度
 * @param  Decimal $latitude1  起点纬度
 * @param  Decimal $longitude2 终点经度
 * @param  Decimal $latitude2  终点纬度
 * @param  Int     $unit       单位 1:米 2:公里
 * @param  Int     $decimal    精度 保留小数位数
 * @return Decimal
 */
function tomGetDistance($longitude1, $latitude1, $longitude2, $latitude2, $unit=2, $decimal=1){

    $EARTH_RADIUS = 6370.996; // 地球半径系数
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