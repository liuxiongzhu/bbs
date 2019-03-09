<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function xy_getNonceStr($length = 32) 
{
    $chars = "abcdefghijklmnopqrstuvwxyz0123456789";  
    $str ="";
    for ( $i = 0; $i < $length; $i++ )  {  
        $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
    } 
    return $str;
}

function xy_ToUrlParams($param)
{
    $buff = "";
    foreach ($param as $k => $v)
    {
        if($k != "sign" && $v != "" && !is_array($v)){
            $buff .= $k . "=" . $v . "&";
        }
    }

    $buff = trim($buff, "&");
    return $buff;
}

function xy_MakeSign($param)
{
    //ǩ������һ�����ֵ����������
    ksort($param);
    $string = xy_ToUrlParams($param);
    //ǩ�����������string�����KEY
    $string = $string . "&key=".TOM_WXPAY_KEY;
    //ǩ����������MD5����
    $string = md5($string);
    //ǩ�������ģ������ַ�תΪ��д
    $result = strtoupper($string);
    return $result;
}