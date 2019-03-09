<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$twmenuBaseUrl = $moduleBaseUrl.'&act=admin&moduleid=twmenu';
$twmenuListUrl = $moduleListUrl.'&act=admin&moduleid=twmenu';
if($_GET['mact'] == 'add'){
    if(submitcheck('submit')){
        $cmd        = isset($_GET['cmd'])? addslashes($_GET['cmd']):'';
        $title      = isset($_GET['title'])? addslashes($_GET['title']):'';
        $description = isset($_GET['description'])? addslashes($_GET['description']):'';
        $picurl     = isset($_GET['picurl'])? addslashes($_GET['picurl']):'';
        $url        = isset($_GET['url'])? addslashes($_GET['url']):'';
        $login      = isset($_GET['login'])? intval($_GET['login']):'';
        $paixu      = isset($_GET['paixu'])? intval($_GET['paixu']):'';
        
        $insertData = array();
        $insertData['cmd']          = $cmd;
        $insertData['title']        = $title;
        $insertData['description']  = $description;
        $insertData['picurl']       = $picurl;
        $insertData['url']          = $url;
        $insertData['login']        = $login;
        $insertData['paixu']        = $paixu;
        C::t('#tom_weixin#tom_weixin_twmenu')->insert($insertData);
        cpmsg($tomScriptLang['act_success'], $twmenuListUrl, 'succeed');
    }else{
        showformheader($moduleFromUrl.'&act=admin&moduleid=twmenu&mact=add');
        showtableheader();
        echo '<tr><th colspan="15" class="partition"><a href="'.$twmenuBaseUrl.'"><font color="#F60"><b>' . $moduleLang['twmenu_list_back'] . '</b></font></a></th></tr>';
        echo '<tr class="header"><th>'.$moduleLang['cmd'].'</th><th></th></tr>';
        echo '<tr><td width="300"><input name="cmd" type="text" value="" size="60" /></td><td>'.$moduleLang['cmd_msg'].'</td></tr>';
        echo '<tr class="header"><th>'.$moduleLang['title'].'</th><th></th></tr>';
        echo '<tr><td width="300"><input name="title" type="text" value="" size="40" /></td><td>'.$moduleLang['title_msg'].'</td></tr>';
        echo '<tr class="header"><th>'.$moduleLang['description'].'</th><th></th></tr>';
        echo '<tr><td><textarea rows="6" name="description" cols="40" class="tarea"></textarea></td><td>'.$moduleLang['description_msg'].'</td></tr>';
        echo '<tr class="header"><th>'.$moduleLang['picurl'].'</th><th></th></tr>';
        echo '<tr><td><input name="picurl" type="text" value="" size="60"/></td><td>'.$moduleLang['picurl_msg'].'</td></tr>';
        echo '<tr class="header"><th>'.$moduleLang['url'].'</th><th></th></tr>';
        echo '<tr><td><input name="url" type="text" value="" size="60"/></td><td>'.$moduleLang['url_msg'].'</td></tr>';
        echo '<tr class="header"><th>'.$moduleLang['login'].'</th><th></th></tr>';
        echo '<tr><td><input type="radio" name="login" value="1">'.$moduleLang['login_ok'].'<input type="radio" name="login" value="2" checked>'.$moduleLang['login_no'].'</td><td>'.$moduleLang['login_msg'].'</td></tr>';
        echo '<tr class="header"><th>'.$moduleLang['paixu'].'</th><th></th></tr>';
        echo '<tr><td><input name="paixu" type="text" value="10" size="10"/></td><td></td></tr>';
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
}else if($_GET['mact'] == 'edit'){
    $twmenuInfo = C::t('#tom_weixin#tom_weixin_twmenu')->fetch_by_id($_GET['id']);
    if(submitcheck('submit')){
        $cmd        = isset($_GET['cmd'])? addslashes($_GET['cmd']):'';
        $title      = isset($_GET['title'])? addslashes($_GET['title']):'';
        $description = isset($_GET['description'])? addslashes($_GET['description']):'';
        $picurl     = isset($_GET['picurl'])? addslashes($_GET['picurl']):'';
        $url        = isset($_GET['url'])? addslashes($_GET['url']):'';
        $login      = isset($_GET['login'])? intval($_GET['login']):2;
        $paixu      = isset($_GET['paixu'])? intval($_GET['paixu']):'';
        
        $updateData = array();
        $updateData['cmd']  = $cmd;
        $updateData['title']  = $title;
        $updateData['description'] = $description;
        $updateData['picurl'] = $picurl;
        $updateData['url'] = $url;
        $updateData['login'] = $login;
        $updateData['paixu'] = $paixu;
        C::t('#tom_weixin#tom_weixin_twmenu')->update($twmenuInfo['id'],$updateData);
        cpmsg($tomScriptLang['act_success'], $twmenuListUrl, 'succeed');
    }else{
        $loginOkChecked = '';
        $loginNoChecked = '';
        if($twmenuInfo['login'] == 1){
            $loginOkChecked = 'checked';
        }else if($twmenuInfo['login'] == 2){
            $loginNoChecked = 'checked';
        }
        
        showformheader($moduleFromUrl.'&act=admin&moduleid=twmenu&mact=edit&id='.$_GET['id']);
        showtableheader();
        echo '<tr><th colspan="15" class="partition"><a href="'.$twmenuBaseUrl.'"><font color="#F60"><b>' . $moduleLang['twmenu_list_back'] . '</b></font></a></th></tr>';
        echo '<tr class="header"><th>'.$moduleLang['cmd'].'</th><th></th></tr>';
        echo '<tr><td width="300"><input name="cmd" type="text" value="'.$twmenuInfo['cmd'].'" size="60" /></td><td>'.$moduleLang['cmd_msg'].'</td></tr>';
        echo '<tr class="header"><th>'.$moduleLang['title'].'</th><th></th></tr>';
        echo '<tr><td width="300"><input name="title" type="text" value="'.$twmenuInfo['title'].'" size="40" /></td><td>'.$moduleLang['title_msg'].'</td></tr>';
        echo '<tr class="header"><th>'.$moduleLang['description'].'</th><th></th></tr>';
        echo '<tr><td><textarea rows="6" name="description" cols="40" class="tarea">'.$twmenuInfo['description'].'</textarea></td><td>'.$moduleLang['description_msg'].'</td></tr>';
        echo '<tr class="header"><th>'.$moduleLang['picurl'].'</th><th></th></tr>';
        echo '<tr><td><input name="picurl" type="text" value="'.$twmenuInfo['picurl'].'" size="60"/></td><td>'.$moduleLang['picurl_msg'].'</td></tr>';
        echo '<tr class="header"><th>'.$moduleLang['url'].'</th><th></th></tr>';
        echo '<tr><td><input name="url" type="text" value="'.$twmenuInfo['url'].'" size="60"/></td><td>'.$moduleLang['url_msg'].'</td></tr>';
        echo '<tr class="header"><th>'.$moduleLang['login'].'</th><th></th></tr>';
        echo '<tr><td><input type="radio" name="login" value="1" '.$loginOkChecked.'>'.$moduleLang['login_ok'].'<input type="radio" name="login" value="2" '.$loginNoChecked.'>'.$moduleLang['login_no'].'</td><td>'.$moduleLang['login_msg'].'</td></tr>';
        echo '<tr class="header"><th>'.$moduleLang['paixu'].'</th><th></th></tr>';
        echo '<tr><td><input name="paixu" type="text" value="'.$twmenuInfo['paixu'].'" size="10"/></td><td></td></tr>';
        
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
}else if($_GET['formhash'] == FORMHASH && $_GET['mact'] == 'del'){
    C::t('#tom_weixin#tom_weixin_twmenu')->delete_by_id($_GET['id']);
    cpmsg($tomScriptLang['act_success'], $twmenuListUrl, 'succeed');
}else{
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $moduleLang['twmenu_help_title'] . '</th></tr>';
    echo '<tr><td colspan="15" class="tipsblock" s="1"><ul id="tipslis">';
    echo '<li>' . $moduleLang['twmenu_help_1'] . '</li>';
    echo '<li>' . $moduleLang['twmenu_help_2'] . '</li>';
    echo '</ul></td></tr>';
    showtablefooter();
    
    $search_cmd = '';
    if(submitcheck('submit')){
        $search_cmd  = isset($_GET['search_cmd'])? addslashes($_GET['search_cmd']):'';
    }
    if(!empty($search_cmd)){
        $twmenuList = C::t('#tom_weixin#tom_weixin_twmenu')->fetch_all_by_cmd($search_cmd);
    }else{
        $pagesize = 15;
        $page = intval($_GET['page'])>0? intval($_GET['page']):1;
        $start = ($page-1)*$pagesize;	
        $count = C::t('#tom_weixin#tom_weixin_twmenu')->fetch_all_count('');
        $twmenuList = C::t('#tom_weixin#tom_weixin_twmenu')->fetch_all_list('',$start,$pagesize);
    }
    
    showformheader($moduleFromUrl.'&act=admin&moduleid=twmenu');
    showtableheader();
    echo '<tr><th colspan="15" class="partition"><font color="#F60"><b>' . $moduleLang['twmeun_search_title'] . '</b></font></th></tr>';
    echo '<tr><td width="60">'.$moduleLang['twmeun_search_cmd'].'</td><td><input name="search_cmd" type="text" value="'.$search_cmd.'" size="40" /></td></tr>';
    showsubmit('submit', 'submit');
    showtablefooter();
    showformfooter();
    
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $moduleLang['twmenu_list_title'] . '</th></tr>';
    echo '<tr><th colspan="15">';
    echo '&nbsp;&nbsp;<a class="addtr" href="'.$twmenuBaseUrl.'&mact=add">' . $moduleLang['twmenu_add'] . '</a>';
    echo '</th></tr>';
    echo '<tr class="header">';
    echo '<th width="10%">ID</th>';
    echo '<th>' . $moduleLang['title'] . '</th>';
    echo '<th>' . $moduleLang['cmd'] . '</th>';
    echo '<th>' . $moduleLang['paixu'] . '</th>';
    echo '<th>' . $tomScriptLang['handle'] . '</th>';
    echo '</tr>';
    
    foreach ($twmenuList as $key => $value) {
        echo '<tr>';
        echo '<td>' . $value['id'] . '</td>';
        echo '<td>' . $value['title'] . '</td>';
        echo '<td>' . $value['cmd'] . '</td>';
        echo '<td>' . $value['paixu'] . '</td>';
        echo '<td>';
        echo '<a href="'.$twmenuBaseUrl.'&mact=edit&id='.$value['id'].'&formhash='.FORMHASH.'">' . $moduleLang['twmenu_edit']. '</a>&nbsp;|&nbsp;';
        echo '<a href="'.$twmenuBaseUrl.'&mact=del&id='.$value['id'].'&formhash='.FORMHASH.'">' . $tomScriptLang['delete'] . '</a>';
        echo '</td>';
        echo '</tr>';
    }
    showtablefooter();
    if(empty($search_cmd)){
        $multi = multi($count, $pagesize, $page, $moduleBaseUrl."&act=admin&moduleid=twmenu");
        showsubmit('', '', '', '', $multi, false);
    }
}
?>
