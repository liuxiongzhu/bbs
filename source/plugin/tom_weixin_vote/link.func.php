<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function tomoutput(){
    if(file_exists(DISCUZ_ROOT."./source/plugin/tom_link/data/rule.php")){
        $tom_link_rule = include DISCUZ_ROOT."./source/plugin/tom_link/data/rule.php";
        if(isset($tom_link_rule['tom_weixin_vote'])){
            $content = ob_get_contents();
            $content = str_replace("plugin.php?id=tom_weixin_vote", $tom_link_rule['tom_weixin_vote']['rk']."?id=".$tom_link_rule['tom_weixin_vote']['bs'], $content);
            ob_end_clean();
            $_G['gzipcompress'] ? ob_start('ob_gzhandler') : ob_start();
            echo $content;
        }
    }
    exit;
}

function tomheader($string){
    if(file_exists(DISCUZ_ROOT."./source/plugin/tom_link/data/rule.php")){
        $tom_link_rule = include DISCUZ_ROOT."./source/plugin/tom_link/data/rule.php";
        if(isset($tom_link_rule['tom_weixin_vote'])){
            $string = str_replace("plugin.php?id=tom_weixin_vote", $tom_link_rule['tom_weixin_vote']['rk']."?id=".$tom_link_rule['tom_weixin_vote']['bs'], $string);
        }
    }
    dheader($string);
    
    return;
}

function tom_link_replace($string){
    if(file_exists(DISCUZ_ROOT."./source/plugin/tom_link/data/rule.php")){
        $tom_link_rule = include DISCUZ_ROOT."./source/plugin/tom_link/data/rule.php";
        if(isset($tom_link_rule['tom_weixin_vote'])){
            $string = str_replace("plugin.php?id=tom_weixin_vote", $tom_link_rule['tom_weixin_vote']['rk']."?id=".$tom_link_rule['tom_weixin_vote']['bs'], $string);
        }
    }
    return $string;
}

