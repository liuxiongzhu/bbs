<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

include DISCUZ_ROOT.'./source/plugin/tom_xiaofenlei/class/function.core.php';
include DISCUZ_ROOT.'./source/plugin/tom_xiaofenlei/class/tom.upload.php';
$upload = new tom_upload();

if($_GET['act'] == 'photo'){
    
    $outArr = array(
        'code'  => 1,
        'msg'   => '',
        'data'  => array(),
    );
    
    $_FILES["file"]['name'] = addslashes(diconv(urldecode($_FILES["file"]['name']), 'UTF-8'));
    
    if(!$upload->init($_FILES['file'], 'tomwx', random(3, 1), random(8)) || !$upload->save()) {
        echo tom_json_encode($outArr);exit;
    }
    
    require_once libfile('class/image');
    $image = new image();
    $image->Thumb($upload->attach['target'], '', 720, 720, 1, 1);
    
    $picurl = (preg_match('/^http:/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$upload->attach['attachment'];
    
    $outArr['data'] = $upload->attach['attachment'];
    
    echo tom_json_encode($outArr);exit;
    
}
