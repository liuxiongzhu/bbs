<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$nowDayTime = gmmktime(0,0,0,dgmdate($_G['timestamp'], 'n',$tomSysOffset),dgmdate($_G['timestamp'], 'j',$tomSysOffset),dgmdate($_G['timestamp'], 'Y',$tomSysOffset)) - $tomSysOffset*3600;

$vid      = isset($_GET['vid'])? intval($_GET['vid']):0;
$formhash     = isset($_GET['formhash'])? addslashes($_GET['formhash']):"";
$tomhash     = isset($_GET['tomhash'])? intval($_GET['tomhash']):"";

$_SESSION['tomhash'] = $tomhash;

if($_GET['act'] == 'add' && $formhash == FORMHASH && $_SESSION['tomhash'] == $tomhash){
    $_SESSION['tomhash'] = 0;
    
    $itemList = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_all_list(" AND vote_id={$vid} ","ORDER BY no DESC",0,1);
    $itemNo = 1;
    if(is_array($itemList) && !empty($itemList) && isset($itemList['0']) && $itemList['0']['no']>0){
        $itemNo = $itemList['0']['no']+1;
    }
    
    if('utf-8' != CHARSET) {
        if(defined('IN_MOBILE')) {}else{
            foreach($_POST AS $pk => $pv) {
                if(!is_numeric($pv)) {
                    $_GET[$pk] = $_POST[$pk] = wx_iconv_recurrence($pv);	
                }
            }
        }
    }
    
    $name          = isset($_GET['bmname'])? daddslashes($_GET['bmname']):'';
    $tel        = isset($_GET['bmtel'])? addslashes($_GET['bmtel']):'';
    $desc    = isset($_GET['bmdesc'])? daddslashes($_GET['bmdesc']):'';
    $pwd    = isset($_GET['bmpwd'])? addslashes($_GET['bmpwd']):'';
    $bmpicurl    = isset($_GET['bmpicurl'])? addslashes($_GET['bmpicurl']):'';
    
    $bmpicliArr = array();
    foreach($_GET as $key => $value){
        if(strpos($key, "bmpicli") !== false){
            $bmpicliArr[] = addslashes($value);
        }
    }
    
    $itemInfo = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_by_vid_tel($vid,$tel) ;
    if($itemInfo){
        echo '201';exit;
    }
    
    $insertData = array();
    $insertData['no']           = $itemNo;
    $insertData['vote_id']      = $vid;
    $insertData['name']         = $name;
    $insertData['tel']          = $tel;
    $insertData['desc']         = $desc;
    $insertData['num']          = 0;
    $insertData['pwd']          = $pwd;
    $insertData['pic_url']      = $bmpicliArr['0'];
    if($voteConfig['open_shehe_show']==1){
        $insertData['status']      = 1;
    }
    $insertData['add_time']     = TIMESTAMP;
    if(C::t('#tom_weixin_vote#tom_weixin_vote_item')->insert($insertData)){
        $itemid = C::t('#tom_weixin_vote#tom_weixin_vote_item')->insert_id();
        $lifeTime = 86400*30;
        $_SESSION['tom_wx_vote_vid'.$vid.'_itemid'] = $itemid;
        dsetcookie('tom_wx_vote_vid'.$vid.'_itemid',$itemid,$lifeTime);
        
        foreach ($bmpicliArr as $key => $value){
            $insertData = array();
            $insertData['vote_id'] = $vid;
            $insertData['item_id'] = $itemid;
            $insertData['pic_url'] = $value;
            $insertData['add_time']     = TIMESTAMP;
            C::t('#tom_weixin_vote#tom_weixin_vote_photo')->insert($insertData);
        }
        
        echo '200';exit;
    }
    echo '100';exit;
}else if($_GET['act'] == 'edit' && $formhash == FORMHASH && $_SESSION['tomhash'] == $tomhash){
    $_SESSION['tomhash'] = 0;
    
    $itemid      = isset($_GET['itemid'])? intval($_GET['itemid']):0;
    $name        = isset($_GET['bmname'])? daddslashes(diconv(urldecode($_GET['bmname']),'utf-8')):'';
    $tel         = isset($_GET['bmtel'])? addslashes($_GET['bmtel']):'';
    $desc        = isset($_GET['bmdesc'])? daddslashes(diconv(urldecode($_GET['bmdesc']),'utf-8')):'';
    $bmpicurl        = isset($_GET['bmpicurl'])? addslashes($_GET['bmpicurl']):'';
    
    $itemInfo = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_by_id($itemid);
    if($voteConfig['noallow_edit_info']==1 && $itemInfo['status'] == 0 ){
        echo '200';exit;
    }
    
    $updateData = array();
    $updateData['name']         = $name;
    $updateData['tel']          = $tel;
    $updateData['desc']         = $desc;
    if(!empty($bmpicurl)){
        $updateData['pic_url']      = $bmpicurl;
    }
    if(C::t('#tom_weixin_vote#tom_weixin_vote_item')->update($itemid,$updateData)){
        $lifeTime = 86400*30;
        $_SESSION['tom_wx_vote_vid'.$vid.'_itemid'] = $itemid;
        dsetcookie('tom_wx_vote_vid'.$vid.'_itemid',$itemid,$lifeTime);
    }
    echo '200';exit;
    
}else if($_GET['act'] == 'photo' && $formhash == FORMHASH && $_SESSION['tomhash'] == $tomhash){
    $_SESSION['tomhash'] = 0;
    
    $itemid      = isset($_GET['itemid'])? intval($_GET['itemid']):0;
    
    if($_FILES['bmpicurl']['size'] > $voteConfig['pic_size_kb']*1024){
        tomheader('location:'.$_G['siteurl']."plugin.php?id=tom_weixin_vote&mod=edit&vid={$vid}&itemid={$itemid}&psize=1");
        exit;
    }
    
    $pic_url = '';
    if($_FILES['bmpicurl']['tmp_name']) {
        $upload = new discuz_upload();
        if(!getimagesize($_FILES['bmpicurl']['tmp_name']) || !$upload->init($_FILES['bmpicurl'], 'common', random(3, 1), random(8)) || !$upload->save()) {
        }else{
            $pic_url = $upload->attach['attachment'];
        }
    }
    
    $insertData = array();
    $insertData['vote_id'] = $vid;
    $insertData['item_id'] = $itemid;
    $insertData['pic_url'] = $pic_url;
    $insertData['add_time']     = TIMESTAMP;
    C::t('#tom_weixin_vote#tom_weixin_vote_photo')->insert($insertData);
    tomheader('location:'.$_G['siteurl']."plugin.php?id=tom_weixin_vote&mod=edit&vid={$vid}&itemid={$itemid}");
    exit;
}else if($_GET['act'] == 'delphoto' && $formhash == FORMHASH && $_SESSION['tomhash'] == $tomhash){
    $_SESSION['tomhash'] = 0;
    
    $itemid      = isset($_GET['itemid'])? intval($_GET['itemid']):0;
    $photoid      = isset($_GET['photoid'])? intval($_GET['photoid']):0;
    
    C::t('#tom_weixin_vote#tom_weixin_vote_photo')->delete_by_id($photoid);
    
    tomheader('location:'.$_G['siteurl']."plugin.php?id=tom_weixin_vote&mod=edit&vid={$vid}&itemid={$itemid}");
    exit;
}else if($_GET['act'] == 'login' && $formhash == FORMHASH && $_SESSION['tomhash'] == $tomhash){
    $_SESSION['tomhash'] = 0;
    
    $tel        = isset($_GET['bmtel'])? addslashes($_GET['bmtel']):'';
    $pwd    = isset($_GET['bmpwd'])? addslashes($_GET['bmpwd']):'';
    if(empty($tel) || empty($pwd)){
        tomheader('location:'.$_G['siteurl']."plugin.php?id=tom_weixin_vote&mod=login&vid={$vid}&err=1");
        exit;
    }
    $itemInfo = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_by_vid_tel($vid,$tel) ;
    if($itemInfo && $itemInfo['pwd'] == $pwd ){
        $lifeTime = 86400*30;
        $_SESSION['tom_wx_vote_vid'.$vid.'_itemid'] = $itemInfo['id'];
        dsetcookie('tom_wx_vote_vid'.$vid.'_itemid',$itemInfo['id'],$lifeTime);
        tomheader('location:'.$_G['siteurl']."plugin.php?id=tom_weixin_vote&mod=edit&vid={$vid}&itemid={$itemInfo['id']}");
        exit;
    }else{
        tomheader('location:'.$_G['siteurl']."plugin.php?id=tom_weixin_vote&mod=login&vid={$vid}&err=1");
        exit;
    }
    
}else if($_GET['act'] == 'tpadd' && $formhash == FORMHASH && $_SESSION['tomhash'] == $tomhash){
    $_SESSION['tomhash'] = 0;
    $outArr = array(
        'status'=> 1,
        'cj'=> 0,
    );
    
    $tid      = isset($_GET['tid'])? intval($_GET['tid']):0;
    $xm       = isset($_GET['tpxm'])? daddslashes(diconv(urldecode($_GET['tpxm']),'utf-8')):'';
    $tel      = isset($_GET['tptel'])? addslashes($_GET['tptel']):'';
    $userid      = isset($_GET['userid'])? intval($_GET['userid']):0;
    
    if(empty($xm) || empty($tel)){
        echo json_encode($outArr); exit;
    }
    
    $voteInfo = C::t('#tom_weixin_vote#tom_weixin_vote')->fetch_by_id($vid);
    $itemInfo = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_by_id($tid);
    
    if(TIMESTAMP < $voteInfo['start_time']){
        echo json_encode($outArr); exit;
    }

    if(TIMESTAMP > $voteInfo['end_time']){
        echo json_encode($outArr); exit;
    }
    
    // IP verify
    $xzArea = 1;
    $voteConfig['xz_area_id'] = trim($voteConfig['xz_area_id']);
    if($voteConfig['open_taobao_ip'] == 1){
        $ipdata = @file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=".$_G['clientip']);
        $ipInfo = json_decode($ipdata, true);

        if(is_array($ipInfo) && $ipInfo['code'] == 0){
            if($voteConfig['xz_area_type'] == 1){
                if($ipInfo['data']['region_id'] != $voteConfig['xz_area_id']){
                    $xzArea = 0;
                }
            }else if($voteConfig['xz_area_type'] == 2){
                if($ipInfo['data']['city_id'] != $voteConfig['xz_area_id']){
                    $xzArea = 0;
                }
            }
        }else{
            $xzArea = 2;
        }
    }else{
        if($voteConfig['area_white'] && !empty($voteConfig['area_white'])){
            require_once libfile('function/misc');
            $location = $whitearea = '';
            $location = trim(convertip($_G['clientip'], "./"));
            if($location) {
                $whitearea = preg_quote(trim($voteConfig['area_white']), '/');
                $whitearea = str_replace(array("\\*"), array('.*'), $whitearea);
                $whitearea = '.*'.$whitearea.'.*';
                $whitearea = '/^('.str_replace(array("\r\n", ' '), array('.*|.*', ''), $whitearea).')$/i';
                if(@preg_match($whitearea, $location)) {
                }else{
                    $xzArea = 0;
                }
            }
        }
    }
    if($xzArea == 0){
        $outArr['status'] = 305;
        echo json_encode($outArr); exit;
    }
    
    if($xzArea == 2){
        $outArr['status'] = 306;
        echo json_encode($outArr); exit;
    }
    
    if($itemInfo['status'] == 1){
        $voteInfo['close_webtp'] = 0;
    }
    
    if($voteInfo['close_webtp'] == 0){
        echo json_encode($outArr); exit;
    }
    
    if($itemInfo['status'] == 2){
        $outArr['status'] = 302;
        echo json_encode($outArr); exit;
    }
    
    // openid start
    $openid = '';
    $openid = getcookie('tom_wx_vote_vid'.$vid.'_openid');
    if(!$openid){
        if($_SESSION['tom_wx_vote_vid'.$vid.'_openid']){
            $openid = $_SESSION['tom_wx_vote_vid'.$vid.'_openid'];
        }
    }
    $userInfoTmp = array();
    if($voteInfo['must_tel'] == 0 || $voteConfig['open_openid'] == 1){
        $openidCheck = false;
        if(!empty($openid) && $openid != '{openid}'){
            $subuserfilename = DISCUZ_ROOT.'./source/plugin/tom_weixin/table/table_tom_weixin_subuser.php';
            if(file_exists($subuserfilename)){
                $subuser = C::t('#tom_weixin#tom_weixin_subuser')->fetch_by_openid($openid);
                if($subuser){
                    $openidCheck = true;
                }
            }
        }
        if(!$openidCheck){
            $outArr['status'] = 301;
            echo json_encode($outArr); exit;
        }
        $userInfoTmp = C::t('#tom_weixin_vote#tom_weixin_vote_user')->fetch_by_vid_openid($vid,$openid);
    }
    // openid end
    
    if(!empty($userid)){
        $userInfoTmpTmp = C::t('#tom_weixin_vote#tom_weixin_vote_user')->fetch_by_id($userid);
        if($userInfoTmpTmp){
            $updateData = array();
            $updateData['xm']       = $xm;
            $updateData['tel']      = $tel;
            C::t('#tom_weixin_vote#tom_weixin_vote_user')->update($userid,$updateData);
        }
    }
    
    $userInfo = C::t('#tom_weixin_vote#tom_weixin_vote_user')->fetch_by_vid_tel($vid,$tel);
    if(!$userInfo){
        if(is_array($userInfoTmp) && !empty($userInfoTmp)){
            $userInfo = $userInfoTmp;
        }
    }
    if(!$userInfo){
        $insertData = array();
        $insertData['vote_id']      = $vid;
        $insertData['xm']           = $xm;
        $insertData['tel']          = $tel;
        $insertData['part1']        = $openid;
        $insertData['add_time']     = TIMESTAMP;
        if(C::t('#tom_weixin_vote#tom_weixin_vote_user')->insert($insertData)){
            $userid = C::t('#tom_weixin_vote#tom_weixin_vote_user')->insert_id();
            $lifeTime = 86400*30;
            $_SESSION['tom_wx_vote_vid'.$vid.'_userid'] = $userid;
            dsetcookie('tom_wx_vote_vid'.$vid.'_userid',$userid,$lifeTime);
        }
    }else{
        $userid = $userInfo['id'];
        $lifeTime = 86400*30;
        $_SESSION['tom_wx_vote_vid'.$vid.'_userid'] = $userInfo['id'];
        dsetcookie('tom_wx_vote_vid'.$vid.'_userid',$userInfo['id'],$lifeTime);
    }
    
    $ipStr = ip2long($_G['clientip']);
    $ipcount = C::t('#tom_weixin_vote#tom_weixin_vote_log')->fetch_count_by_vid_ip($vid,$ipStr,$nowDayTime);
    if($ipcount >= $voteConfig['today_ip_times']){
        $outArr['status'] = 303;
        echo json_encode($outArr); exit;
    }
    
    $todayTpStatus = C::t('#tom_weixin_vote#tom_weixin_vote_log')->fetch_by_v_i_u_t($vid,$tid,$userid,$nowDayTime);
    if($todayTpStatus){
        $outArr['status'] = 100;
        echo json_encode($outArr); exit;
    }
    $todayTpCount = C::t('#tom_weixin_vote#tom_weixin_vote_log')->fetch_all_count(" AND vote_id={$vid} AND user_id={$userid} AND time_key={$nowDayTime} ");
    if($todayTpCount >= $voteConfig['everyday_times']){
        $outArr['status'] = 201;
        echo json_encode($outArr); exit;
    }
    
    if($itemInfo['num'] > $voteConfig['mtxy_start_num']){
        $itemXeTpCount = C::t('#tom_weixin_vote#tom_weixin_vote_log')->fetch_all_count(" AND vote_id={$vid} AND time_key={$nowDayTime} AND item_id={$tid} ");
        if($itemXeTpCount >= $voteConfig['mtxy_num']){
            $outArr['status'] = 304;
            echo json_encode($outArr); exit;
        }
    }
    
    $itemTpCount = C::t('#tom_weixin_vote#tom_weixin_vote_log')->fetch_all_count(" AND vote_id={$vid} AND user_id={$userid} AND item_id={$tid} ");
    if($itemTpCount >= $voteConfig['all_times']){
        $outArr['status'] = 202;
        echo json_encode($outArr); exit;
    }
    
    $insertData = array();
    $insertData['vote_id']      = $vid;
    $insertData['item_id']      = $tid;
    $insertData['user_id']      = $userid;
    $insertData['time_key']     = $nowDayTime;
    $insertData['part1']        = ip2long($_G['clientip']);
    $insertData['log_time']     = TIMESTAMP;
    if(C::t('#tom_weixin_vote#tom_weixin_vote_log')->insert($insertData)){
        
        if($voteConfig['locking_num'] > 0){
            $fiveminutesTime = TIMESTAMP - 5*60;
            $fiveminutesTpCount = C::t('#tom_weixin_vote#tom_weixin_vote_log')->fetch_all_count(" AND vote_id={$vid}  AND item_id={$tid} AND log_time>$fiveminutesTime ");
            if($fiveminutesTpCount >= $voteConfig['locking_num']){
                $updateData = array();
                $updateData['status'] = 2;
                C::t('#tom_weixin_vote#tom_weixin_vote_item')->update($tid,$updateData);
            } 
        }
        
        DB::query("UPDATE ".DB::table('tom_weixin_vote_item')." SET num=num+1 WHERE id='{$tid}'", 'UNBUFFERED');
        
//        $updateData = array();
//        $updateData['num'] = $itemInfo['num']+1;
//        C::t('#tom_weixin_vote#tom_weixin_vote_item')->update($tid,$updateData);
        
        if($voteInfo['cj_status'] == 1){
            $cjCount = C::t('#tom_weixin_vote#tom_weixin_vote_cj')->fetch_all_count(" AND vote_id={$vid} AND user_id={$userid} AND time_key={$nowDayTime} ");
            if($cjCount < $voteConfig['cj_times']){
                $_SESSION['tom_wx_vote_cj'] = $userid;
                $lifeTime = 86400*30;
				dsetcookie('tom_wx_vote_cj',$userid,$lifeTime);
                $outArr['cj'] = 1;
            }
        }
        
        $outArr['status'] = 200;
        echo json_encode($outArr); exit;
    }
    echo json_encode($outArr); exit;
    
}else if($_GET['act'] == 'tp' && $formhash == FORMHASH && $_SESSION['tomhash'] == $tomhash){
    $_SESSION['tomhash'] = 0;
    $outArr = array(
        'status'=> 1,
        'cj'=> 0,
    );
    
    $tid      = isset($_GET['tid'])? intval($_GET['tid']):0;
    $userid      = isset($_GET['userid'])? intval($_GET['userid']):0;
    
    $voteInfo = C::t('#tom_weixin_vote#tom_weixin_vote')->fetch_by_id($vid);
    $userInfo = C::t('#tom_weixin_vote#tom_weixin_vote_user')->fetch_by_id($userid);
    $itemInfo = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_by_id($tid);
    
    if(!$userInfo){
        echo json_encode($outArr); exit;
    }
    
    if(TIMESTAMP < $voteInfo['start_time']){
        echo json_encode($outArr); exit;
    }

    if(TIMESTAMP > $voteInfo['end_time']){
        echo json_encode($outArr); exit;
    }
    
    // IP verify
    $xzArea = 1;
    $voteConfig['xz_area_id'] = trim($voteConfig['xz_area_id']);
    if($voteConfig['open_taobao_ip'] == 1){
        $ipdata = @file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=".$_G['clientip']);
        $ipInfo = json_decode($ipdata, true);

        if(is_array($ipInfo) && $ipInfo['code'] == 0){
            if($voteConfig['xz_area_type'] == 1){
                if($ipInfo['data']['region_id'] != $voteConfig['xz_area_id']){
                    $xzArea = 0;
                }
            }else if($voteConfig['xz_area_type'] == 2){
                if($ipInfo['data']['city_id'] != $voteConfig['xz_area_id']){
                    $xzArea = 0;
                }
            }
        }else{
            $xzArea = 2;
        }
    }else{
        if($voteConfig['area_white'] && !empty($voteConfig['area_white'])){
            require_once libfile('function/misc');
            $location = $whitearea = '';
            $location = trim(convertip($_G['clientip'], "./"));
            if($location) {
                $whitearea = preg_quote(trim($voteConfig['area_white']), '/');
                $whitearea = str_replace(array("\\*"), array('.*'), $whitearea);
                $whitearea = '.*'.$whitearea.'.*';
                $whitearea = '/^('.str_replace(array("\r\n", ' '), array('.*|.*', ''), $whitearea).')$/i';
                if(@preg_match($whitearea, $location)) {
                }else{
                    $xzArea = 0;
                }
            }
        }
    }
    if($xzArea == 0){
        $outArr['status'] = 305;
        echo json_encode($outArr); exit;
    }
    
    if($xzArea == 2){
        $outArr['status'] = 306;
        echo json_encode($outArr); exit;
    }
    
    if($itemInfo['status'] == 1){
        $voteInfo['close_webtp'] = 0;
    }
    
    if($voteInfo['close_webtp'] == 0){
        echo json_encode($outArr); exit;
    }
    
    if($itemInfo['status'] == 2){
        $outArr['status'] = 302;
        echo json_encode($outArr); exit;
    }
    
    // userid start
    $cookieUserid = getcookie('tom_wx_vote_vid'.$vid.'_userid');
    if(!$cookieUserid){
        if($_SESSION['tom_wx_vote_vid'.$vid.'_userid']){
            $cookieUserid = $_SESSION['tom_wx_vote_vid'.$vid.'_userid'];
        }
    }
    if($cookieUserid != $userid ){
        echo json_encode($outArr); exit;
    }
    // userid end
    
    // openid start
    $openid = '';
    $openid = getcookie('tom_wx_vote_vid'.$vid.'_openid');
    if(!$openid){
        if($_SESSION['tom_wx_vote_vid'.$vid.'_openid']){
            $openid = $_SESSION['tom_wx_vote_vid'.$vid.'_openid'];
        }
    }
    if($voteInfo['must_tel'] == 0 || $voteConfig['open_openid'] == 1){
        $openidCheck = false;
        if(!empty($openid) && $openid != '{openid}'){
            $subuserfilename = DISCUZ_ROOT.'./source/plugin/tom_weixin/table/table_tom_weixin_subuser.php';
            if(file_exists($subuserfilename)){
                $subuser = C::t('#tom_weixin#tom_weixin_subuser')->fetch_by_openid($openid);
                if($subuser){
                    $openidCheck = true;
                }
            }
        }
        
        if(!$openidCheck){
            $outArr['status'] = 301;
            echo json_encode($outArr); exit;
        }
        
//        if($userInfo['part1'] != $openid){
//            $outArr['status'] = 301;
//            echo json_encode($outArr); exit;
//        }
    }
    // openid end
    
    $ipStr = ip2long($_G['clientip']);
    $ipcount = C::t('#tom_weixin_vote#tom_weixin_vote_log')->fetch_count_by_vid_ip($vid,$ipStr,$nowDayTime);
    if($ipcount >= $voteConfig['today_ip_times']){
        $outArr['status'] = 303;
        echo json_encode($outArr); exit;
    }
    
    $todayTpStatus = C::t('#tom_weixin_vote#tom_weixin_vote_log')->fetch_by_v_i_u_t($vid,$tid,$userid,$nowDayTime);
    if($todayTpStatus){
        $outArr['status'] = 100;
        echo json_encode($outArr); exit;
    }
    $todayTpCount = C::t('#tom_weixin_vote#tom_weixin_vote_log')->fetch_all_count(" AND vote_id={$vid} AND user_id={$userid} AND time_key={$nowDayTime} ");
    if($todayTpCount >= $voteConfig['everyday_times']){
        $outArr['status'] = 201;
        echo json_encode($outArr); exit;
    }
    
    if($itemInfo['num'] > $voteConfig['mtxy_start_num']){
        $itemXeTpCount = C::t('#tom_weixin_vote#tom_weixin_vote_log')->fetch_all_count(" AND vote_id={$vid} AND time_key={$nowDayTime} AND item_id={$tid} ");
        if($itemXeTpCount >= $voteConfig['mtxy_num']){
            $outArr['status'] = 304;
            echo json_encode($outArr); exit;
        }
    }
    
    $itemTpCount = C::t('#tom_weixin_vote#tom_weixin_vote_log')->fetch_all_count(" AND vote_id={$vid} AND user_id={$userid} AND item_id={$tid} ");
    if($itemTpCount >= $voteConfig['all_times']){
        $outArr['status'] = 202;
        echo json_encode($outArr); exit;
    }
    
    $insertData = array();
    $insertData['vote_id']      = $vid;
    $insertData['item_id']      = $tid;
    $insertData['user_id']      = $userid;
    $insertData['time_key']     = $nowDayTime;
    $insertData['part1']        = ip2long($_G['clientip']);
    $insertData['log_time']     = TIMESTAMP;
    if(C::t('#tom_weixin_vote#tom_weixin_vote_log')->insert($insertData)){
        
        if($voteConfig['locking_num'] > 0){
            $fiveminutesTime = TIMESTAMP - 5*60;
            $fiveminutesTpCount = C::t('#tom_weixin_vote#tom_weixin_vote_log')->fetch_all_count(" AND vote_id={$vid}  AND item_id={$tid} AND log_time>$fiveminutesTime ");
            if($fiveminutesTpCount >= $voteConfig['locking_num']){
                $updateData = array();
                $updateData['status'] = 2;
                C::t('#tom_weixin_vote#tom_weixin_vote_item')->update($tid,$updateData);
            } 
        }
        
        DB::query("UPDATE ".DB::table('tom_weixin_vote_item')." SET num=num+1 WHERE id='{$tid}'", 'UNBUFFERED');
        
//        $updateData = array();
//        $updateData['num'] = $itemInfo['num']+1;
//        C::t('#tom_weixin_vote#tom_weixin_vote_item')->update($tid,$updateData);
        
        if($voteInfo['cj_status'] == 1 && $voteInfo['must_tel'] == 1 && $userInfo['tel'] != 0 ){
            $cjCount = C::t('#tom_weixin_vote#tom_weixin_vote_cj')->fetch_all_count(" AND vote_id={$vid} AND user_id={$userid} AND time_key={$nowDayTime} ");
            if($cjCount < $voteConfig['cj_times']){
                $_SESSION['tom_wx_vote_cj'] = $userInfo['id'];
                $lifeTime = 86400*30;
				dsetcookie('tom_wx_vote_cj',$userid,$lifeTime);
                $outArr['cj'] = 1;
            }
        }
        
        $outArr['status'] = 200;
        echo json_encode($outArr); exit;
    }
    echo json_encode($outArr); exit;
    
}else if($_GET['act'] == 'cj' && $formhash == FORMHASH){
    
    $voteInfo = C::t('#tom_weixin_vote#tom_weixin_vote')->fetch_by_id($vid);
    
    $jggIndexFile =  DISCUZ_ROOT . './source/plugin/tom_weixin_jgg/tom_weixin_jgg.inc.php';
    
    $tom_wx_vote_cj = getcookie('tom_wx_vote_cj');
    if(!$tom_wx_vote_cj){
        if($_SESSION['tom_wx_vote_cj']){
            $tom_wx_vote_cj = $_SESSION['tom_wx_vote_cj'];
        }
    }
    if($tom_wx_vote_cj && $tom_wx_vote_cj > 0 && file_exists($jggIndexFile)){
        $userid = $tom_wx_vote_cj;
        $lifeTime = 86400*30;
		dsetcookie('tom_wx_vote_cj',0,$lifeTime);
        $_SESSION['tom_wx_vote_cj'] = 0;
        $userInfo = C::t('#tom_weixin_vote#tom_weixin_vote_user')->fetch_by_id($userid);
        $jggInfo = C::t('#tom_weixin_jgg#tom_weixin_jgg')->fetch_by_id($voteInfo['cj_id']);
        if($userInfo && $jggInfo){
            $jggUserInfo = C::t('#tom_weixin_jgg#tom_weixin_jgg_user')->fetch_by_act_id_tel($voteInfo['cj_id'],$userInfo['tel']);
            if($jggUserInfo){
                $lifeTime = 86400*30;
                $_SESSION['tom_wx_jgg_user_actid'.$voteInfo['cj_id']] = $jggUserInfo['id'];
                dsetcookie('tom_wx_jgg_user_actid'.$voteInfo['cj_id'],$jggUserInfo['id'],$lifeTime);
            }else{
                $insertData = array();
                $insertData['activity_id']      = $voteInfo['cj_id'];
                $insertData['xm']               = $userInfo['xm'];
                $insertData['tel']              = $userInfo['tel'];
                $insertData['add_time']         = TIMESTAMP;
                C::t('#tom_weixin_jgg#tom_weixin_jgg_user')->insert($insertData);
                $jggUserInfo = C::t('#tom_weixin_jgg#tom_weixin_jgg_user')->fetch_by_act_id_tel($voteInfo['cj_id'],$userInfo['tel']);
                if($jggUserInfo){
                    $lifeTime = 86400*30;
                    $_SESSION['tom_wx_jgg_user_actid'.$voteInfo['cj_id']] = $jggUserInfo['id'];
                    dsetcookie('tom_wx_jgg_user_actid'.$voteInfo['cj_id'],$jggUserInfo['id'],$lifeTime);
                }
            }
            C::t('#tom_weixin_jgg#tom_weixin_jgg_log')->delete_by_condition(" AND activity_id = {$voteInfo['cj_id']} AND user_id = {$jggUserInfo['id']} ");
            
            $insertData = array();
            $insertData['vote_id']      = $vid;
            $insertData['user_id']      = $userid;
            $insertData['time_key']     = $nowDayTime;
            $insertData['log_time']     = TIMESTAMP;
            C::t('#tom_weixin_vote#tom_weixin_vote_cj')->insert($insertData);
            
            tomheader('location:'.$_G['siteurl']."plugin.php?id=tom_weixin_jgg&act_id={$voteInfo['cj_id']}");
            exit;
        }
    }
    tomheader('location:'.$_G['siteurl']."plugin.php?id=tom_weixin_vote&mod=index&vid={$vid}");
    exit;
    
}else if($_GET['act'] == 'clicks' && $formhash == FORMHASH){
    $voteInfo = C::t('#tom_weixin_vote#tom_weixin_vote')->fetch_by_id($vid);
    $updateData = array();
    $updateData['clicks'] = $voteInfo['clicks']+1;
    C::t('#tom_weixin_vote#tom_weixin_vote')->update($vid,$updateData);
    echo 1;exit;
}else if($_GET['act'] == 'get_search_url' && $formhash == FORMHASH){
    
    $keywords = isset($_GET['keywords'])? daddslashes(diconv(urldecode($_GET['keywords']),'utf-8')):'';
    $url = $_G['siteurl']."plugin.php?id=tom_weixin_vote&mod=index&vid={$vid}&keywords=".urlencode($keywords);
    echo $url;exit;
}else{
    //tomheader('location:'.$_G['siteurl']."plugin.php?id=tom_weixin_vote&mod=index&vid={$vid}");
    exit;
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

