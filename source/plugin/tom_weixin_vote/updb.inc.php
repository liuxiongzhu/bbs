<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once libfile('function/plugin');

if(isset($_G['uid']) && $_G['uid'] > 0 && $_G['groupid'] == 1){
    
    $sql = '';
    $tom_weixin_vote_field = C::t('#tom_weixin_vote#tom_weixin_vote')->fetch_all_field();
    if (!isset($tom_weixin_vote_field['must_tel'])) {
        $sql .= "ALTER TABLE ".DB::table('tom_weixin_vote')." ADD `must_tel` int(11) DEFAULT '1';\n";
    }
    if (!isset($tom_weixin_vote_field['open_bianhao'])) {
        $sql .= "ALTER TABLE ".DB::table('tom_weixin_vote')." ADD `open_bianhao` int(11) DEFAULT '0';\n";
    }
    if (!isset($tom_weixin_vote_field['close_webtp'])) {
        $sql .= "ALTER TABLE ".DB::table('tom_weixin_vote')." ADD `close_webtp` int(11) DEFAULT '1';\n";
    }
    if (!isset($tom_weixin_vote_field['xuni_clicks'])) {
        $sql .= "ALTER TABLE ".DB::table('tom_weixin_vote')." ADD `xuni_clicks` int(11) DEFAULT '0';\n";
    }
    if (!isset($tom_weixin_vote_field['style_id'])) {
        $sql .= "ALTER TABLE ".DB::table('tom_weixin_vote')." ADD `style_id` int(11) DEFAULT '1';\n";
    }
    if (!isset($tom_weixin_vote_field['prize_txt'])) {
        $sql .= "ALTER TABLE ".DB::table('tom_weixin_vote')." ADD `prize_txt` text;\n";
    }
    if (!isset($tom_weixin_vote_field['focus_status'])) {
        $sql .= "ALTER TABLE ".DB::table('tom_weixin_vote')." ADD `focus_status` int(11) DEFAULT '0';\n";
    }
    if (!isset($tom_weixin_vote_field['focus_pic1'])) {
        $sql .= "ALTER TABLE ".DB::table('tom_weixin_vote')." ADD `focus_pic1` varchar(255) DEFAULT NULL;\n";
    }
    if (!isset($tom_weixin_vote_field['focus_pic2'])) {
        $sql .= "ALTER TABLE ".DB::table('tom_weixin_vote')." ADD `focus_pic2` varchar(255) DEFAULT NULL;\n";
    }
    if (!isset($tom_weixin_vote_field['focus_pic3'])) {
        $sql .= "ALTER TABLE ".DB::table('tom_weixin_vote')." ADD `focus_pic3` varchar(255) DEFAULT NULL;\n";
    }
    if (!isset($tom_weixin_vote_field['pic_err_msg'])) {
        $sql .= "ALTER TABLE ".DB::table('tom_weixin_vote')." ADD `pic_err_msg` varchar(255) DEFAULT NULL;\n";
    }
    if (!isset($tom_weixin_vote_field['mp3_link'])) {
        $sql .= "ALTER TABLE ".DB::table('tom_weixin_vote')." ADD `mp3_link` varchar(255) DEFAULT NULL;\n";
    }
    if (!isset($tom_weixin_vote_field['guanzu_qrcode'])) {
        $sql .= "ALTER TABLE ".DB::table('tom_weixin_vote')." ADD `guanzu_qrcode` varchar(255) DEFAULT NULL;\n";
    }
    if (!isset($tom_weixin_vote_field['guanzu_desc'])) {
        $sql .= "ALTER TABLE ".DB::table('tom_weixin_vote')." ADD `guanzu_desc` varchar(255) DEFAULT NULL;\n";
    }
    if (!isset($tom_weixin_vote_field['focus_pic_url1'])) {
        $sql .= "ALTER TABLE ".DB::table('tom_weixin_vote')." ADD `focus_pic_url1` varchar(255) DEFAULT NULL;\n";
    }
    if (!isset($tom_weixin_vote_field['focus_pic_url2'])) {
        $sql .= "ALTER TABLE ".DB::table('tom_weixin_vote')." ADD `focus_pic_url2` varchar(255) DEFAULT NULL;\n";
    }
    if (!isset($tom_weixin_vote_field['focus_pic_url3'])) {
        $sql .= "ALTER TABLE ".DB::table('tom_weixin_vote')." ADD `focus_pic_url3` varchar(255) DEFAULT NULL;\n";
    }
    if (!empty($sql)) {
        runquery($sql);
    }

    echo 'OK';exit;
    
}else{
    exit('Access Denied');
}
