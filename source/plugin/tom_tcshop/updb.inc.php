<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once libfile('function/plugin');

if(isset($_G['uid']) && $_G['uid'] > 0 && $_G['groupid'] == 1){
    
    $sql = '';

    $tom_tcshop_field = C::t('#tom_tcshop#tom_tcshop')->fetch_all_field();
    if (!isset($tom_tcshop_field['ruzhu_level'])) {
        $sql .= "ALTER TABLE `pre_tom_tcshop` ADD `ruzhu_level` int(11) DEFAULT '0';\n";
    }
    if (!isset($tom_tcshop_field['admin_edit'])) {
        $sql .= "ALTER TABLE `pre_tom_tcshop` ADD `admin_edit` int(11) DEFAULT '0';\n";
    }
    if (!isset($tom_tcshop_field['city_id'])) {
        $sql .= "ALTER TABLE `pre_tom_tcshop` ADD `city_id` int(11) DEFAULT '0';\n";
    }
    if (!isset($tom_tcshop_field['area_id'])) {
        $sql .= "ALTER TABLE `pre_tom_tcshop` ADD `area_id` int(11) DEFAULT '0';\n";
    }
    if (!isset($tom_tcshop_field['street_id'])) {
        $sql .= "ALTER TABLE `pre_tom_tcshop` ADD `street_id` int(11) DEFAULT '0';\n";
    }
    if (!isset($tom_tcshop_field['tabs'])) {
        $sql .= "ALTER TABLE `pre_tom_tcshop` ADD `tabs` varchar(255) DEFAULT NULL;\n";
    }
    if (!isset($tom_tcshop_field['is_ok'])) {
        $sql .= "ALTER TABLE `pre_tom_tcshop` ADD `is_ok` int(11) DEFAULT '0';\n";
    }
    if (!isset($tom_tcshop_field['business_licence'])) {
        $sql .= "ALTER TABLE `pre_tom_tcshop` ADD `business_licence` varchar(255) DEFAULT NULL;\n";
    }
    if (!isset($tom_tcshop_field['tj_hehuoren_id'])) {
        $sql .= "ALTER TABLE `pre_tom_tcshop` ADD `tj_hehuoren_id` int(11) DEFAULT '0';\n";
    }
    if (!isset($tom_tcshop_field['link'])) {
        $sql .= "ALTER TABLE `pre_tom_tcshop` ADD `link` varchar(255) DEFAULT NULL;\n";
    }
    if (!isset($tom_tcshop_field['link_name'])) {
        $sql .= "ALTER TABLE `pre_tom_tcshop` ADD `link_name` varchar(255) DEFAULT NULL;\n";
    }
    if (!isset($tom_tcshop_field['base_level'])) {
        $sql .= "ALTER TABLE `pre_tom_tcshop` ADD `base_level` int(11) DEFAULT '1';\n";
    }
    if (!isset($tom_tcshop_field['base_time'])) {
        $sql .= "ALTER TABLE `pre_tom_tcshop` ADD `base_time` int(11) DEFAULT '0';\n";
    }
    if (!isset($tom_tcshop_field['shopkeeper_tel'])) {
        $sql .= "ALTER TABLE `pre_tom_tcshop` ADD `shopkeeper_tel` varchar(255) DEFAULT NULL;\n";
    }
    if (!isset($tom_tcshop_field['toprand'])) {
        $sql .= "ALTER TABLE `pre_tom_tcshop` ADD `toprand` int(11) DEFAULT '1';\n";
    }
    if (!isset($tom_tcshop_field['refresh_time'])) {
        $sql .= "ALTER TABLE `pre_tom_tcshop` ADD `refresh_time` int(11) DEFAULT '0';\n";
    }
    if (!isset($tom_tcshop_field['vr_url'])) {
        $sql .= "ALTER TABLE `pre_tom_tcshop` ADD `vr_url` varchar(255) DEFAULT NULL;\n";
    }
    
    $tom_tcshop_cate_field = C::t('#tom_tcshop#tom_tcshop_cate')->fetch_all_field();
    if (!isset($tom_tcshop_cate_field['youhui_model_name'])) {
        $sql .= "ALTER TABLE `pre_tom_tcshop_cate` ADD `youhui_model_name` varchar(255) DEFAULT NULL;\n";
    }
    if (!isset($tom_tcshop_cate_field['youhui_model_id'])) {
        $sql .= "ALTER TABLE `pre_tom_tcshop_cate` ADD `youhui_model_id` int(11) DEFAULT '0';\n";
    }
    if (!isset($tom_tcshop_cate_field['youhui_model_ids'])) {
        $sql .= "ALTER TABLE `pre_tom_tcshop_cate` ADD `youhui_model_ids` varchar(255) DEFAULT NULL;\n";
    }
    if (!isset($tom_tcshop_cate_field['open_tel_price'])) {
        $sql .= "ALTER TABLE `pre_tom_tcshop_cate` ADD `open_tel_price` int(11) DEFAULT '0';\n";
    }
    if (!isset($tom_tcshop_cate_field['open_upload_proof'])) {
        $sql .= "ALTER TABLE `pre_tom_tcshop_cate` ADD `open_upload_proof` tinyint(4) DEFAULT '0';\n";
    }
    if (!isset($tom_tcshop_cate_field['upload_proof_text'])) {
        $sql .= "ALTER TABLE `pre_tom_tcshop_cate` ADD `upload_proof_text` varchar(255) DEFAULT NULL;\n";
    }
    
    $tom_tcshop_photo_field = C::t('#tom_tcshop#tom_tcshop_photo')->fetch_all_field();
    if (!isset($tom_tcshop_photo_field['oss_picurl'])) {
        $sql .= "ALTER TABLE `pre_tom_tcshop_photo` ADD `oss_picurl` varchar(255) DEFAULT NULL;\n";
    }
    if (!isset($tom_tcshop_photo_field['oss_status'])) {
        $sql .= "ALTER TABLE `pre_tom_tcshop_photo` ADD `oss_status` int(11) DEFAULT '0';\n";
    }
    if (!isset($tom_tcshop_photo_field['qiniu_picurl'])) {
        $sql .= "ALTER TABLE `pre_tom_tcshop_photo` ADD `qiniu_picurl` varchar(255) DEFAULT NULL;\n";
    }
    if (!isset($tom_tcshop_photo_field['qiniu_status'])) {
        $sql .= "ALTER TABLE `pre_tom_tcshop_photo` ADD `qiniu_status` int(11) DEFAULT '0';\n";
    }
    if (!isset($tom_tcshop_photo_field['type_id'])) {
        $sql .= "ALTER TABLE `pre_tom_tcshop_photo` ADD `type_id` int(11) DEFAULT '1';\n";
    }
    if (!isset($tom_tcshop_photo_field['paixu'])) {
        $sql .= "ALTER TABLE `pre_tom_tcshop_photo` ADD `paixu` int(11) DEFAULT '999';\n";
    }

    if (!empty($sql)) {
        runquery($sql);
    }
    
    $sql = <<<EOF
    CREATE TABLE IF NOT EXISTS `pre_tom_tcshop_clerk` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `tcshop_id` int(11) DEFAULT '0',
      `user_id` int(11) DEFAULT '0',
      `add_time` int(11) DEFAULT '0',
      `part1` varchar(255) DEFAULT NULL,
      `part2` varchar(255) DEFAULT NULL,
      `part3` int(11) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM;
            
    CREATE TABLE IF NOT EXISTS `pre_tom_tcshop_tuwen` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `tcshop_id` int(11) DEFAULT '0',
      `picurl` varchar(255) DEFAULT NULL,
      `txt` text,
      `paixu` int(11) DEFAULT '0',
      `part1` varchar(255) DEFAULT NULL,
      `part2` varchar(255) DEFAULT NULL,
      `part3` int(11) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM;
            
    CREATE TABLE IF NOT EXISTS `pre_tom_tcshop_clicks_log` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `tcshop_id` int(11) DEFAULT '0',
        `ip` int(11) unsigned DEFAULT '0',
        `today_time` int(11) DEFAULT '0',
        `log_time` int(11) DEFAULT '0',
        `part1` varchar(255) DEFAULT NULL,
        `part2` varchar(255) DEFAULT NULL,
        `part3` int(11) DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=MyISAM;
            
    CREATE TABLE IF NOT EXISTS `pre_tom_tcshop_pinglun_photo` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `pinglun_id` int(11) DEFAULT '0',
        `picurl` varchar(255) DEFAULT NULL,
        `add_time` int(11) DEFAULT '0',
        `part1` varchar(255) DEFAULT NULL,
        `part2` varchar(255) DEFAULT NULL,
        `part3` int(11) DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=MyISAM;
            
    CREATE TABLE IF NOT EXISTS `pre_tom_tcshop_money_log` (
      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `user_id` int(11) DEFAULT '0',
      `type_id` int(11) DEFAULT '0',
      `tixian_id` int(11) DEFAULT '0',
      `change_money` decimal(10,2) DEFAULT '0.00',
      `old_money` decimal(10,2) DEFAULT '0.00',
      `business_id` varchar(255) DEFAULT NULL,
      `business_user_id` int(11) DEFAULT '0',
      `title` varchar(255) DEFAULT NULL,
      `order_no` varchar(255) DEFAULT NULL,
      `beizu` text,
      `log_year` int(11) DEFAULT '0',
      `log_month` int(11) DEFAULT '0',
      `log_day` int(11) DEFAULT '0',
      `log_ip` varchar(255) DEFAULT NULL,
      `log_time` int(11) DEFAULT '0',
      `part1` varchar(255) DEFAULT NULL,
      `part2` varchar(255) DEFAULT NULL,
      `part3` int(11) DEFAULT '0',
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM;
        
    CREATE TABLE IF NOT EXISTS `pre_tom_tcshop_money_tixian` (
      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `tx_order_no` varchar(255) DEFAULT NULL,
      `user_id` int(11) DEFAULT '0',
      `type_id` int(11) DEFAULT '0',
      `money` decimal(10,2) DEFAULT '0.00',
      `alipay_zhanghao` varchar(255) DEFAULT NULL,
      `alipay_truename` varchar(255) DEFAULT NULL,
      `beizu` text,
      `status` int(11) DEFAULT '0',
      `tixian_ip` varchar(255) DEFAULT NULL,
      `tixian_time` int(11) DEFAULT '0',
      `part1` varchar(255) DEFAULT NULL,
      `part2` varchar(255) DEFAULT NULL,
      `part3` int(11) DEFAULT '0',
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM;
    
    CREATE TABLE IF NOT EXISTS `pre_tom_tcshop_mall_cate` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `tcshop_id` int(11) DEFAULT '0',
      `name` varchar(255) DEFAULT NULL,
      `csort` int(11) DEFAULT '10',
      `part1` varchar(255) DEFAULT NULL,
      `part2` varchar(255) DEFAULT NULL,
      `part3` int(11) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM;

EOF;

    runquery($sql);
    

    echo 'OK';exit;
    
}else{
    exit('Access Denied');
}