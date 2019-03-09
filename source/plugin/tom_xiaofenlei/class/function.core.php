<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function tom_json_encode($outArr){
    $outArr = out_iconv($outArr);
    return json_encode($outArr);
}

function out_iconv($value){
    if (CHARSET != 'utf-8') {
        if(is_array($value)) {
            foreach($value AS $key => $val) {
                $value[$key] = out_iconv($val);
            }
        }else{
            $value = diconv($value,CHARSET,'utf-8');
        }
    }
    return $value;
}

function xiao_iconv_recurrence($value) {
    if(is_array($value)) {
        foreach($value AS $key => $val) {
            $value[$key] = xiao_iconv_recurrence($val);
        }
    } else {
        $value = diconv($value, 'utf-8', CHARSET);
    }
    return $value;
}

function getHtml($url){
    if(function_exists('curl_init')){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $return = curl_exec($ch);
        curl_close($ch); 
        return $return;
    }
    return false;
}

