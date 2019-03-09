<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$server_yasu_size = 320;
if($voteConfig['server_yasu_size'] > 0){
    $server_yasu_size = $voteConfig['server_yasu_size'];
}

if($_GET['act'] == 'photo' && $_GET['formhash'] == FORMHASH){
    
    $vid      = isset($_GET['vid'])? intval($_GET['vid']):0;
    $itemid      = isset($_GET['itemid'])? intval($_GET['itemid']):0;
    
    $upload = new discuz_upload();
    $_FILES["filedata2"]['name'] = addslashes(diconv(urldecode($_FILES["filedata2"]['name']), 'UTF-8'));
    
    if($_FILES['filedata2']['size'] > $voteConfig['pic_size_kb']*1024){
        echo 'SIZE|url';exit;
    }
    
    if(!getimagesize($_FILES['filedata2']['tmp_name']) || !$upload->init($_FILES['filedata2'], 'common', random(3, 1), random(8)) || !$upload->save()) {
        echo 'NO|url';exit;
    }
    if($voteConfig['server_yasu'] == 1){
        require_once libfile('class/image');
        $image = new image();
        $image->Thumb($upload->attach['target'], '', $server_yasu_size, $server_yasu_size, 1, 1); 
    }
    $picurl = (preg_match('/^http:/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$upload->attach['attachment'];
    $insertData = array();
    $insertData['vote_id'] = $vid;
    $insertData['item_id'] = $itemid;
    $insertData['pic_url'] = $upload->attach['attachment'];
    $insertData['add_time']     = TIMESTAMP;
    C::t('#tom_weixin_vote#tom_weixin_vote_photo')->insert($insertData);
    echo 'OK|'.$picurl;exit;
    
}else if($_GET['act'] == 'avatar' && $_GET['formhash'] == FORMHASH){
    $upload = new discuz_upload();
    $_FILES["filedata1"]['name'] = addslashes(diconv(urldecode($_FILES["filedata1"]['name']), 'UTF-8'));
    
    if($_FILES['filedata1']['size'] > $voteConfig['pic_size_kb']*1024){
        echo 'SIZE|url';exit;
    }
    
    if(!getimagesize($_FILES['filedata1']['tmp_name']) || !$upload->init($_FILES['filedata1'], 'common', random(3, 1), random(8)) || !$upload->save()) {
        echo 'NO|url';exit;
    }
    if($voteConfig['server_yasu'] == 1){
        require_once libfile('class/image');
        $image = new image();
        $image->Thumb($upload->attach['target'], '', $server_yasu_size, $server_yasu_size, 1, 1); 
    }
    $picurl = (preg_match('/^http:/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'common/'.$upload->attach['attachment'];
    echo 'OK|'.$picurl.'|'.$upload->attach['attachment'];exit;
    
}

