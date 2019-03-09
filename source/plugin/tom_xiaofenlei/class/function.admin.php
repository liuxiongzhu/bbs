<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

function tom_iconv($data, $in_charset, $out_charset) {
    if(is_array($data)) {
        foreach($data AS $key => $val) {
            $data[$key] = tom_iconv($val, $in_charset, $out_charset);
        }
    } else {
        $data = diconv($data, $in_charset, $out_charset);
    }
    return $data;
}

function tom_doing($do_msg,$dourl){
    cpmsg($do_msg, $dourl, 'loadingform');
}

function tomshowsetting($status,$param,$type){
    if($status){
        if($type == 'input'){
            tomcreateInput($param);
        }else if($type == 'calendar'){
            tomcreateCalendar($param);
        }else if($type == 'textarea'){
            tomcreateTextarea($param);
        }else if($type == 'text'){
            tomcreateText($param);
        }else if($type == 'radio'){
            tomcreateRadio($param);
        }else if($type == 'select'){
            tomcreateSelect($param);
        }else if($type == 'file'){
            tomcreateFile($param);
        }
    }
    return false;
}

function tomshowsubmit($var1,$var2){
    showsubmit($var1, $var2);
    return;
}

function tomloadcalendarjs(){
    echo '<script type="text/javascript" src="static/js/calendar.js"></script>';
    return;
}

function set_list_url($name = ""){
    $cookieValue = "";
    foreach ($_GET as $key => $value){
        $cookieValue.=$key."=".$value."&";
    }
    $cookieValue.="s=1";
    $lifeTime = 86400;
    dsetcookie($name,$cookieValue,$lifeTime);
    return false;
}

function get_list_url($name = ""){
    $cookieValue = getcookie($name);
    if($cookieValue && !empty($cookieValue)){
       return $cookieValue; 
    }
    return false;
}