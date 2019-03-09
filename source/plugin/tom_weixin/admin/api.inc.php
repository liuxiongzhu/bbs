<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$moduleBaseUrl = $adminBaseUrl.'&tmod=api';
$moduleListUrl = $adminListUrl.'&tmod=api';
$moduleFromUrl = $adminFromUrl.'&tmod=api';


$allHookData = array(
    'receiveAllStart' => array(
		'plugin' => 'tom_weixin',
		'include' => 'wechat.class.php',
		'class' => 'tom_wechat',
		'method' => 'all'
	),
    'receiveMsg::text' => array(
		'plugin' => 'tom_weixin',
		'include' => 'wechat.class.php',
		'class' => 'tom_wechat',
		'method' => 'run'
	),
    'receiveMsg::location' => array(
		'plugin' => 'tom_weixin',
		'include' => 'wechat.class.php',
		'class' => 'tom_wechat',
		'method' => 'run'
	),
    'receiveMsg::image' => array(
		'plugin' => 'tom_weixin',
		'include' => 'wechat.class.php',
		'class' => 'tom_wechat',
		'method' => 'run'
	),
    'receiveMsg::video' => array(
		'plugin' => 'tom_weixin',
		'include' => 'wechat.class.php',
		'class' => 'tom_wechat',
		'method' => 'run'
	),
    'receiveMsg::link' => array(
		'plugin' => 'tom_weixin',
		'include' => 'wechat.class.php',
		'class' => 'tom_wechat',
		'method' => 'run'
	),
    'receiveMsg::voice' => array(
		'plugin' => 'tom_weixin',
		'include' => 'wechat.class.php',
		'class' => 'tom_wechat',
		'method' => 'run'
	),
    'receiveEvent::unsubscribe' => array(
		'plugin' => 'tom_weixin',
		'include' => 'wechat.class.php',
		'class' => 'tom_wechat',
		'method' => 'run'
	),
    'receiveEvent::location' => array(
		'plugin' => 'tom_weixin',
		'include' => 'wechat.class.php',
		'class' => 'tom_wechat',
		'method' => 'run'
	),
    'receiveEvent::click' => array(
		'plugin' => 'tom_weixin',
		'include' => 'wechat.class.php',
		'class' => 'tom_wechat',
		'method' => 'run'
	),
);
$tomSubscribeHookData = array(
    'receiveEvent::subscribe' => array(
		'plugin' => 'tom_weixin',
		'include' => 'wechat.class.php',
		'class' => 'tom_wechat',
		'method' => 'run'
	),
);
$wechatSubscribeHookData = array(
    'receiveEvent::subscribe' => array(
		'plugin' => 'wechat',
		'include' => 'response.class.php',
		'class' => 'WSQResponse',
		'method' => 'subscribe'
	),
);

if($_GET['act'] == 'wechat' && submitcheck('submit')){
    require_once DISCUZ_ROOT . './source/plugin/wechat/wechat.lib.class.php';
    WeChatHook::updateResponse($allHookData);
    $subscribeType = isset($_GET['subscribe'])? intval($_GET['subscribe']):1;
    if($subscribeType == 1){
        WeChatHook::updateResponse($wechatSubscribeHookData);
    }else{
        WeChatHook::updateResponse($tomSubscribeHookData);
    }
    cpmsg($tomScriptLang['act_success'], $moduleListUrl.'&act=wechat', 'succeed');
}


$wxurl = $_G['siteurl']."source/plugin/tom_weixin/wx.php";

showtableheader();
echo '<tr><th colspan="15" class="partition">' . $tomScriptLang['api_help_title'] . '</th></tr>';
echo '<tr><td  class="tipsblock" s="1"><ul id="tipslis">';
echo '<li>'.$tomScriptLang['api_help_1'].'</li>';
$tomScriptLang['api_help_2']  = str_replace("{SITEURL}", $_G['siteurl'], $tomScriptLang['api_help_2']);
echo '<li>'.$tomScriptLang['api_help_2'].'</li>';
echo '</ul></td></tr>';
echo '<tr><th colspan="15" class="partition">' . $tomScriptLang['api_title'] . '</th></tr>';
echo '<tr><td  class="tipsblock" s="1"><ul id="tipslis">';
echo '<li><b>' . $tomScriptLang['api_url'] . '</b><input name="" readonly="readonly" type="text" value="'.$wxurl.'" size="100" /></li>';
echo '<li><b>' . $tomScriptLang['api_token'] . '</b><input name="" readonly="readonly" type="text" value="'.$tomConfig['wx_token'].'" size="30" /><font color="#009900">' . $tomScriptLang['api_token_msg'] . '</font></li>';
echo '</ul></td></tr>';
if(!empty($tomConfig['wx_token']) && $tomConfig['wx_token'] == 'www_tomwx_net'){
    echo '<tr><th colspan="15"><font color="#FF0000"><b><img class="vmiddle" style="width: 16px;height: 16px;margin-right: 5px;" src="source/plugin/tom_weixin/images/no.png">' . $tomScriptLang['api_error_1'] . '</b></font></th></tr>';
}
if($tomConfig['token_check'] == 0 ){
    echo '<tr><th colspan="15"><font color="#FF0000"><b><img class="vmiddle" style="width: 16px;height: 16px;margin-right: 5px;" src="source/plugin/tom_weixin/images/no.png">' . $tomScriptLang['api_error_2'] . '</b></font></th></tr>';
}
showtablefooter();


$wechatLibName = DISCUZ_ROOT . './source/plugin/wechat/wechat.lib.class.php';
$isWechat = false;
if(file_exists($wechatLibName)){
    $isWechat = true;
    require_once $wechatLibName;
}
$isHookError = false;

$tomSubscribeStatus = "";
$wechatSubscribeStatus = "";
if($isWechat){
    $doHookData = WeChatHook::getResponse();
    foreach ($allHookData as $key => $value){
        if($doHookData[$key]['plugin'] != $value['plugin'] || $doHookData[$key]['include'] != $value['include'] || $doHookData[$key]['class'] != $value['class'] || $doHookData[$key]['method'] != $value['method']){
            $isHookError = true;
        }
    }
    if($doHookData['receiveEvent::subscribe']['plugin'] == 'tom_weixin'){
        $tomSubscribeStatus = "checked";
    }
    if($doHookData['receiveEvent::subscribe']['plugin'] == 'wechat'){
        $wechatSubscribeStatus = "checked";
    }
}
showformheader($moduleFromUrl.'&act=wechat');
showtableheader();
echo '<tr><th colspan="15" class="partition">'.$tomScriptLang['wechat_setting'].'</th><th></th></tr>';
echo '<tr><td>'.$tomScriptLang['wechat_gz_title'].'<input type="radio" name="subscribe" value="1" '.$wechatSubscribeStatus.'>'.$tomScriptLang['wechat_gz_wechat'].'&nbsp;<input type="radio" name="subscribe" value="2" '.$tomSubscribeStatus.'>'.$tomScriptLang['wechat_gz_tom'].'</td><td></td></tr>';

if($isWechat && $isHookError){
    echo '<tr><th colspan="15"><font color="#FF0000"><b><img class="vmiddle" style="width: 16px;height: 16px;margin-right: 5px;" src="source/plugin/tom_weixin/images/no.png">' . $tomScriptLang['wechat_hook_error'] . '</b></font></th></tr>';
}
if($isWechat && !$isHookError){
    echo '<tr><th colspan="15"><font color="#05a705"><b><img class="vmiddle" style="width: 16px;height: 16px;margin-right: 5px;" src="source/plugin/tom_weixin/images/ok.png">' . $tomScriptLang['wechat_hook_ok'] . '</b></font></th></tr>';
}
if(!$isWechat){
    echo '<tr><th colspan="15"><font color="#FF0000"><b><img class="vmiddle" style="width: 16px;height: 16px;margin-right: 5px;" src="source/plugin/tom_weixin/images/no.png">' . $tomScriptLang['wechat_no_install'] . '</b></font></th></tr>';
}else{
    showsubmit('submit', $tomScriptLang['wechat_btn']);
}
showtablefooter();
showformfooter();


