<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

# check start
if($__UserInfo['groupid'] == 1 || $__UserInfo['groupid'] == 2 ){
}else{
    tomheader('location:'.$_G['siteurl']."plugin.php?id=tom_tcshop&site={$site_id}&mod=index");exit;
}
# check end


if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'shenhe_ok'){
    
    $tcshop_id = intval($_GET['tcshop_id'])>0? intval($_GET['tcshop_id']):0;
    
    $updateData = array();
    $updateData['shenhe_status']     = 1;
    C::t('#tom_tcshop#tom_tcshop')->update($tcshop_id,$updateData);
    
    $tcshopInfo = C::t('#tom_tcshop#tom_tcshop')->fetch_by_id($tcshop_id);
    $tcUserInfo = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($tcshopInfo['user_id']);
    
    $shenhe = str_replace('{SHOPNAME}', $tcshopInfo['name'], lang("plugin/tom_tcshop", "template_tcshop_shenhe_ok"));

    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/class/templatesms.class.php';
    $access_token = $weixinClass->get_access_token();
    if($access_token && !empty($tcUserInfo['openid'])){
        $templateSmsClass = new templateSms($access_token, $_G['siteurl']."plugin.php?id=tom_tcshop&site={$tcshopInfo['site_id']}&mod=details&tcshop_id=".$tcshopInfo['id']);
        $smsData = array(
            'first'         => $shenhe,
            'keyword1'      => $tcshopConfig['plugin_name'],
            'keyword2'      => dgmdate(TIMESTAMP,"Y-m-d H:i:s",$tomSysOffset),
            'remark'        => ''
        );

        @$r = $templateSmsClass->sendSms01($tcUserInfo['openid'], $tongchengConfig['template_id'], $smsData);
    }
    
    $insertData = array();
    $insertData['user_id']      = $tcUserInfo['id'];
    $insertData['type']         = 1;
    $insertData['content']      = '<font color="#238206">'.$tcshopConfig['plugin_name'].'</font><br/>'.$shenhe.'<br/>'.dgmdate(TIMESTAMP,"Y-m-d H:i:s",$tomSysOffset);
    $insertData['is_read']      = 0;
    $insertData['tz_time']      = TIMESTAMP;
    C::t('#tom_tongcheng#tom_tongcheng_tz')->insert($insertData);
    
    echo 200;exit;
    
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'shenhe_no'){
    
    if('utf-8' != CHARSET) {
        if(defined('IN_MOBILE')){
        }else{
            foreach($_POST AS $pk => $pv) {
                if(!is_numeric($pv)) {
                    $_GET[$pk] = $_POST[$pk] = wx_iconv_recurrence($pv);	
                }
            }
        }
    }
    
    $tcshop_id      = intval($_GET['tcshop_id'])>0? intval($_GET['tcshop_id']):0;
    $content        = isset($_GET['content'])? daddslashes($_GET['content']):'';
    
    $tcshopInfo = C::t('#tom_tcshop#tom_tcshop')->fetch_by_id($tcshop_id);
    $tcUserInfo = C::t('#tom_tongcheng#tom_tongcheng_user')->fetch_by_id($tcshopInfo['user_id']);

    $updateData = array();
    $updateData['shenhe_status']     = 3;
    C::t('#tom_tcshop#tom_tcshop')->update($tcshop_id,$updateData);

    $shenhe  = str_replace('{SHOPNAME}', $tcshopInfo['name'], lang("plugin/tom_tcshop", "template_tcshop_shenhe_no"));
    $content = str_replace("\r\n","",$content);
    $content = str_replace("\n","",$content);
    $content = str_replace("\r","",$content);

    include DISCUZ_ROOT.'./source/plugin/tom_tongcheng/class/templatesms.class.php';
    $access_token = $weixinClass->get_access_token();
    if($access_token && !empty($tcUserInfo['openid'])){
        $templateSmsClass = new templateSms($access_token, $_G['siteurl']."plugin.php?id=tom_tcshop&site={$tcshopInfo['site_id']}&mod=edit&tcshop_id=".$tcshopInfo['id']);
        $smsData = array(
            'first'         => $shenhe,
            'keyword1'      => $tcshopConfig['plugin_name'],
            'keyword2'      => dgmdate(TIMESTAMP,"Y-m-d H:i:s",$tomSysOffset),
            'remark'        => $content
        );
        @$r = $templateSmsClass->sendSms01($tcUserInfo['openid'], $tongchengConfig['template_id'], $smsData);
    }

    $insertData = array();
    $insertData['user_id']      = $tcUserInfo['id'];
    $insertData['type']         = 1;
    $insertData['content']      = '<font color="#238206">'.$tcshopConfig['plugin_name'].'</font><br/>'.$shenhe.'<br/>'.lang("plugin/tom_tcshop", "tcshop_shenhe_fail_title").$content.'<br/>'.dgmdate(TIMESTAMP,"Y-m-d H:i:s",$tomSysOffset);
    $insertData['is_read']      = 0;
    $insertData['tz_time']      = TIMESTAMP;
    C::t('#tom_tongcheng#tom_tongcheng_tz')->insert($insertData);
    
    echo 200;exit;
    
}else if($_GET['act'] == 'updateStatus' && $_GET['formhash'] == FORMHASH){
    
    $tcshop_id   = intval($_GET['tcshop_id'])>0? intval($_GET['tcshop_id']):0;
    
    $tcshopInfo = C::t('#tom_tcshop#tom_tcshop')->fetch_by_id($tcshop_id);
    
    if($_GET['status'] == 1){
        $updateData = array();
        $updateData['status'] = 1;
        C::t('#tom_tcshop#tom_tcshop')->update($tcshop_id,$updateData);
    }else if($_GET['status'] == 2){
        $updateData = array();
        $updateData['status'] = 2;
        C::t('#tom_tcshop#tom_tcshop')->update($tcshop_id,$updateData);
    }
    
    echo 200;exit;
}else if($_GET['act'] == 'get_search_url' && $_GET['formhash'] == FORMHASH){
    
    $keyword = isset($_GET['keyword'])? daddslashes(diconv(urldecode($_GET['keyword']),'utf-8')):'';
    
    $url = $_G['siteurl']."plugin.php?id=tom_tcshop&site={$site_id}&mod=managerList&keyword=".urlencode(trim($keyword));
    
    echo $url;exit;
    
}else if($_GET['act'] == 'shenhe_show'){
    
    $tcshop_id      = intval($_GET['tcshop_id'])>0? intval($_GET['tcshop_id']):0;
    $fromtype       = intval($_GET['fromtype'])>0? intval($_GET['fromtype']):0;
    $frompage       = intval($_GET['frompage'])>0? intval($_GET['frompage']):1;
    
    $tcshopInfo = C::t('#tom_tcshop#tom_tcshop')->fetch_by_id($tcshop_id);
    
    $ajaxShenheUrl = "plugin.php?id=tom_tcshop&site={$site_id}&mod=managerList&act=shenhe_no";
    
    $isGbk = false;
    if (CHARSET == 'gbk') $isGbk = true;
    include template("tom_tcshop:managerShenhe");exit;
    
}

$keyword  = isset($_GET['keyword'])? addslashes(urldecode($_GET['keyword'])):'';
$page  = intval($_GET['page'])>0? intval($_GET['page']):1;
$type  = intval($_GET['type'])>0? intval($_GET['type']):0;

$where = " AND pay_status!=1 AND is_ok=1 ";
if($type == 1){
    $where.= " AND shenhe_status=2 ";
}
if($type == 2){
    $where.= " AND shenhe_status=3 ";
}
if($__UserInfo['groupid'] == 2){
    $where.= " AND site_id={$site_id} ";
}

$pagesize = 8;
$start = ($page - 1)*$pagesize;
$order = " ORDER BY id DESC ";
$count = C::t('#tom_tcshop#tom_tcshop')->fetch_all_count(" {$where} ",$keyword);
$tcshopListTmp = C::t('#tom_tcshop#tom_tcshop')->fetch_all_list(" {$where} "," {$order} ",$start,$pagesize,$keyword);
$tcshopList = array();
if(is_array($tcshopListTmp) && !empty($tcshopListTmp)){
    foreach ($tcshopListTmp as $key => $value){
        $tcshopList[$key] = $value;
        if(!preg_match('/^http/', $value['picurl']) ){
            if(strpos($value['picurl'], 'source/plugin/') === FALSE){
                $picurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'tomwx/'.$value['picurl'];
            }else{
                $picurl = $value['picurl'];
            }
        }else{
            $picurl = $value['picurl'];
        }
        $tcshopList[$key]['picurl'] = $picurl;

        $overTime = 1;
        if($value['vip_level'] == 1){
            $overTime = dgmdate($value['vip_time'],"Y-m-d",$tomSysOffset);
        }else if($value['base_level'] == 2){
            $overTime = dgmdate($value['base_time'],"Y-m-d",$tomSysOffset);
        }
        $tcshopList[$key]['overTime'] = $overTime;

    }
}

$showNextPage = 1;
if(($start + $pagesize) >= $count){
    $showNextPage = 0;
}
$allPageNum = ceil($count/$pagesize);
$prePage = $page - 1;
$nextPage = $page + 1;
$prePageUrl = "plugin.php?id=tom_tcshop&site={$site_id}&mod=managerList&type={$type}&page={$prePage}";
$nextPageUrl = "plugin.php?id=tom_tcshop&site={$site_id}&mod=managerList&type={$type}&page={$nextPage}";

$searchUrl              = 'plugin.php?id=tom_tcshop&site='.$site_id.'&mod=managerList&act=get_search_url';
$ajaxShenheOkUrl        = "plugin.php?id=tom_tcshop&site={$site_id}&mod=managerList&act=shenhe_ok&formhash=".$formhash;
$ajaxUpdateStatusUrl    = "plugin.php?id=tom_tcshop&site={$site_id}&mod=managerList&act=updateStatus&formhash=".$formhash;

$isGbk = false;
if (CHARSET == 'gbk') $isGbk = true;
include template("tom_tcshop:managerList");