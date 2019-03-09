<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$modBaseUrl = $adminBaseUrl.'&tmod=vote'; 
$modListUrl = $adminListUrl.'&tmod=vote';
$modFromUrl = $adminFromUrl.'&tmod=vote';

if($_GET['act'] == 'add'){
    if(submitcheck('submit')){
        $insertData = array();
        $insertData = __get_post_data();
        $insertData['add_time']     = TIMESTAMP;
        C::t('#tom_weixin_vote#tom_weixin_vote')->insert($insertData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        tomloadcalendarjs();
        loadeditorjs("tom_weixin_vote");
        __create_nav_html();
        showformheader($modFromUrl.'&act=add','enctype');
        showtableheader();
        __create_info_html();
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
    
}else if($_GET['act'] == 'edit'){
    $voteInfo = C::t('#tom_weixin_vote#tom_weixin_vote')->fetch_by_id($_GET['id']);
    if(submitcheck('submit')){
        $updateData = array();
        $updateData = __get_post_data($voteInfo);
        C::t('#tom_weixin_vote#tom_weixin_vote')->update($voteInfo['id'],$updateData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        tomloadcalendarjs();
        loadeditorjs("tom_weixin_vote");
        __create_nav_html();
        showformheader($modFromUrl.'&act=edit&id='.$_GET['id'],'enctype');
        showtableheader();
        __create_info_html($voteInfo);
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'del'){
    C::t('#tom_weixin_vote#tom_weixin_vote')->delete_by_id($_GET['id']);
    C::t('#tom_weixin_vote#tom_weixin_vote_cj')->delete_by_vote_id($_GET['id']);
    C::t('#tom_weixin_vote#tom_weixin_vote_item')->delete_by_vote_id($_GET['id']);
    C::t('#tom_weixin_vote#tom_weixin_vote_log')->delete_by_vote_id($_GET['id']);
    C::t('#tom_weixin_vote#tom_weixin_vote_photo')->delete_by_vote_id($_GET['id']);
    C::t('#tom_weixin_vote#tom_weixin_vote_user')->delete_by_vote_id($_GET['id']);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
}else{
    $pagesize = 15;
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    $start = ($page-1)*$pagesize;	
    $count = C::t('#tom_weixin_vote#tom_weixin_vote')->fetch_all_count("");
    $voteList = C::t('#tom_weixin_vote#tom_weixin_vote')->fetch_all_list("","ORDER BY add_time DESC",$start,$pagesize);
    //$uSiteUrl = urlencode($_G['siteurl']);
    //echo '<script type="text/javascript">var usiteurl="'.$uSiteUrl.'";plugin_id="tom_weixin_vote";</script>';
    //echo '<script src="source/plugin/tom_weixin_vote/images/admin.js"></script>';
    showtableheader();
    $Lang['vote_help_1']  = str_replace("{SITEURL}", $_G['siteurl'], $Lang['vote_help_1']);
    $Lang['vote_help_3']  = str_replace("{SITEURL}", $_G['siteurl'], $Lang['vote_help_3']);
    $Lang['vote_help_1'] = tom_link_replace($Lang['vote_help_1']);
    $Lang['vote_help_3'] = tom_link_replace($Lang['vote_help_3']);
    $Lang['vote_help_5']  = str_replace("{SITEURL}", $_G['siteurl'], $Lang['vote_help_5']);
    echo '<tr><th colspan="15" class="partition">' . $Lang['vote_help_title'] . '</th></tr>';
    echo '<tr><td  class="tipsblock" s="1"><ul id="tipslis">';
    echo '<li>' . $Lang['vote_help_1'] . '</li>';
    echo '<li>' . $Lang['vote_help_3'] . '</li>';
    echo '<li>' . $Lang['vote_help_2'] . '</li>';
    echo '<li>' . $Lang['vote_help_5'] . '</li>';
    $filename = DISCUZ_ROOT.'./source/plugin/tom_mengbao/tom_mengbao.inc.php';
    if(file_exists($filename)){
        //echo '<li>' . $Lang['vote_help_4'] . '</li>';
    }
    echo '</ul></td></tr>';
    showtablefooter();
    __create_nav_html();
    showtableheader();
    echo '<tr class="header">';
    echo '<th width="10%">' . $Lang['id'] . '</th>';
    echo '<th>' . $Lang['title'] . '</th>';
    echo '<th>' . $Lang['start_time'] . '</th>';
    echo '<th>' . $Lang['end_time'] . '</th>';
    echo '<th>' . $Lang['vote_add_status'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    
    $i = 1;
    foreach ($voteList as $key => $value) {
        
        $allCount = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_all_count("  AND vote_id={$value['id']} ");
        $deleteCount = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_all_count("  AND vote_id={$value['id']} AND status=1 ");
        $lockingCount = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_all_count("  AND vote_id={$value['id']} AND status=2 ");
        
        echo '<tr>';
        echo '<td>' . $value['id'] . '</td>';
        echo '<td>' . $value['title'] . '</td>';
        echo '<td>' . dgmdate($value['start_time'],"Y-m-d H:i",$tomSysOffset) . '</td>';
        echo '<td>' . dgmdate($value['end_time'],"Y-m-d H:i",$tomSysOffset) . '</td>';
        echo '<td>';
        echo '<a href="'.$adminBaseUrl.'&tmod=item&vote_id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['vote_all_count'].'('.$allCount.')</a>&nbsp;|&nbsp;';
        echo '<a href="'.$adminBaseUrl.'&tmod=item&vote_id='.$value['id'].'&status=1&formhash='.FORMHASH.'">' . $Lang['status_delete'].'('.$deleteCount.')</a>&nbsp;|&nbsp;';
        echo '<a href="'.$adminBaseUrl.'&tmod=item&vote_id='.$value['id'].'&status=2&formhash='.FORMHASH.'">' . $Lang['status_locking'].'('.$lockingCount.')</a>';
        echo '</td>';
        echo '<td>';
        echo '<a href="'.$adminBaseUrl.'&tmod=item&vote_id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['item_list_title']. '</a>&nbsp;|&nbsp;';
        //echo '<a href="'.$adminBaseUrl.'&tmod=user&vote_id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['user_list_title']. '</a>&nbsp;|&nbsp;';
        echo '<a href="'.$modBaseUrl.'&act=edit&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['vote_edit']. '</a>&nbsp;|&nbsp;';
        //echo '<a href="'.$modBaseUrl.'&act=del&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['delete'] . '</a>';
        echo '<a href="javascript:void(0);" onclick="del_confirm(\''.$modBaseUrl.'&act=del&id='.$value['id'].'&formhash='.FORMHASH.'\');">' . $Lang['delete'] . '</a>';
        echo '</td>';
        echo '</tr>';
        $i++;
    }
    showtablefooter();
    $multi = multi($count, $pagesize, $page, $modBaseUrl);	
    showsubmit('', '', '', '', $multi, false);
    
    $jsstr = <<<EOF
<script type="text/javascript">
function del_confirm(url){
  var r = confirm("{$Lang['makesure_del_msg']}")
  if (r == true){
    window.location = url;
  }else{
    return false;
  }
}
</script>
EOF;
    echo $jsstr;
}

function __get_post_data($infoArr = array()){
    $data = array();
    
    $title          = isset($_GET['title'])? addslashes($_GET['title']):'';
    $style_id       = isset($_GET['style_id'])? intval($_GET['style_id']):1;
    $must_tel       = isset($_GET['must_tel'])? intval($_GET['must_tel']):1;
    $must_gz        = isset($_GET['must_gz'])? intval($_GET['must_gz']):0;
    $open_bianhao   = isset($_GET['open_bianhao'])? intval($_GET['open_bianhao']):0;
    $close_webtp    = isset($_GET['close_webtp'])? intval($_GET['close_webtp']):1;
    $start_time     = isset($_GET['start_time'])? addslashes($_GET['start_time']):'';
    $start_time     = strtotime($start_time);
    $end_time       = isset($_GET['end_time'])? addslashes($_GET['end_time']):'';
    $end_time       = strtotime($end_time);
    $focus_status   = isset($_GET['focus_status'])? intval($_GET['focus_status']):0;
    $prize_txt      = isset($_GET['prize_txt'])? addslashes($_GET['prize_txt']):'';
    $content        = isset($_GET['content'])? addslashes($_GET['content']):'';
    $item_obj_name  = isset($_GET['item_obj_name'])? addslashes($_GET['item_obj_name']):'';
    $share_title    = isset($_GET['share_title'])? addslashes($_GET['share_title']):'';
    $share_desc     = isset($_GET['share_desc'])? addslashes($_GET['share_desc']):'';
    $guanzu_desc     = isset($_GET['guanzu_desc'])? addslashes($_GET['guanzu_desc']):'';
    $guanzu_url     = isset($_GET['guanzu_url'])? addslashes($_GET['guanzu_url']):'';
    $cj_status      = isset($_GET['cj_status'])? intval($_GET['cj_status']):1;
    $cj_id          = isset($_GET['cj_id'])? intval($_GET['cj_id']):'';
    $bm_status      = isset($_GET['bm_status'])? intval($_GET['bm_status']):1;
    $ads_text       = isset($_GET['ads_text'])? addslashes($_GET['ads_text']):'';
    $xuni_clicks    = isset($_GET['xuni_clicks'])? intval($_GET['xuni_clicks']):0;
    $pic_err_msg    = isset($_GET['pic_err_msg'])? addslashes($_GET['pic_err_msg']):'';
    $mp3_link       = isset($_GET['mp3_link'])? addslashes($_GET['mp3_link']):'';
    $paixu          = isset($_GET['paixu'])? intval($_GET['paixu']):'';
    $focus_pic_url1 = isset($_GET['focus_pic_url1'])? addslashes($_GET['focus_pic_url1']):'';
    $focus_pic_url2 = isset($_GET['focus_pic_url2'])? addslashes($_GET['focus_pic_url2']):'';
    $focus_pic_url3 = isset($_GET['focus_pic_url3'])? addslashes($_GET['focus_pic_url3']):'';
    
    $pic_url = "";
    if($_GET['act'] == 'add'){
        $pic_url        = tomuploadFile("pic_url");
    }else if($_GET['act'] == 'edit'){
        $pic_url        = tomuploadFile("pic_url",$infoArr['pic_url']);
    }
    
    $focus_pic1 = "";
    if($_GET['act'] == 'add'){
        $focus_pic1        = tomuploadFile("focus_pic1");
    }else if($_GET['act'] == 'edit'){
        $focus_pic1        = tomuploadFile("focus_pic1",$infoArr['focus_pic1']);
    }
    
    $focus_pic2 = "";
    if($_GET['act'] == 'add'){
        $focus_pic2        = tomuploadFile("focus_pic2");
    }else if($_GET['act'] == 'edit'){
        $focus_pic2        = tomuploadFile("focus_pic2",$infoArr['focus_pic2']);
    }
    
    $focus_pic3 = "";
    if($_GET['act'] == 'add'){
        $focus_pic3        = tomuploadFile("focus_pic3");
    }else if($_GET['act'] == 'edit'){
        $focus_pic3        = tomuploadFile("focus_pic3",$infoArr['focus_pic3']);
    }
    
    $share_logo = "";
    if($_GET['act'] == 'add'){
        $share_logo        = tomuploadFile("share_logo");
    }else if($_GET['act'] == 'edit'){
        $share_logo        = tomuploadFile("share_logo",$infoArr['share_logo']);
    }
    $guanzu_qrcode = "";
    if($_GET['act'] == 'add'){
        $guanzu_qrcode        = tomuploadFile("guanzu_qrcode");
    }else if($_GET['act'] == 'edit'){
        $guanzu_qrcode        = tomuploadFile("guanzu_qrcode",$infoArr['guanzu_qrcode']);
    }

    $data['title']        = $title;
    $data['style_id']     = $style_id;
    $data['must_tel']     = $must_tel;
    $data['must_gz']      = $must_gz;
    $data['open_bianhao']      = $open_bianhao;
    $data['close_webtp']      = $close_webtp;
    $data['start_time']   = $start_time;
    $data['end_time']     = $end_time;
    $data['pic_url']      = $pic_url;
    $data['focus_status'] = $focus_status;
    $data['focus_pic1']   = $focus_pic1;
    $data['focus_pic_url1']   = $focus_pic_url1;
    $data['focus_pic2']   = $focus_pic2;
    $data['focus_pic_url2']   = $focus_pic_url2;
    $data['focus_pic3']   = $focus_pic3;
    $data['focus_pic_url3']   = $focus_pic_url3;
    $data['prize_txt']    = $prize_txt;
    $data['content']      = $content;
    $data['item_obj_name']= $item_obj_name;
    $data['share_title']  = $share_title;
    $data['share_desc']   = $share_desc;
    $data['guanzu_qrcode']= $guanzu_qrcode;
    $data['guanzu_desc']  = $guanzu_desc;
    $data['guanzu_url']   = $guanzu_url;
    $data['share_logo']   = $share_logo;
    $data['cj_status']    = $cj_status;
    $data['cj_id']        = $cj_id;
    $data['bm_status']    = $bm_status;
    $data['ads_text']     = $ads_text;
    $data['xuni_clicks']  = $xuni_clicks;
    $data['pic_err_msg']  = $pic_err_msg;
    $data['mp3_link']     = $mp3_link;
    $data['paixu']        = $paixu;
    
    return $data;
}

function __create_info_html($infoArr = array()){
    global $Lang,$bgColorArray;
    $options = array(
        'title'         => '',
        'style_id'    => 1,
        'must_tel'      => 1,
        'must_gz'       => 0,
        'open_bianhao'       => 0,
        'close_webtp'       => 1,
        'start_time'    => time(),
        'end_time'      => time(),
        'pic_url'       => "",
        'focus_status'     => 0,
        'focus_pic1'       => "",
        'focus_pic_url1'    => "",
        'focus_pic2'       => "",
        'focus_pic_url2'    => "",
        'focus_pic3'       => "",
        'focus_pic_url3'    => "",
        'prize_txt'     => "",
        'content'       => "",
        'item_obj_name'   => $Lang['item_obj_name_value'],
        'share_title'   => "",
        'share_desc'    => "",
        'guanzu_qrcode'    => "",
        'guanzu_desc'    => "",
        'guanzu_url'    => "",
        'share_logo'    => "",
        'cj_status'     => 1,
        'cj_id'         => 0,
        'bm_status'     => 1,
        'ads_text'      => '',
        'xuni_clicks'   => '0',
        'pic_err_msg'   => '',
        'mp3_link'   => '',
        'paixu'         => 100,
    );
    $options = array_merge($options, $infoArr);
    
    tomshowsetting(array('title'=>$Lang['title'],'name'=>'title','value'=>$options['title'],'msg'=>$Lang['title_msg']),"input");
    $style_id_item = array();
    foreach ($bgColorArray as $key => $value){
        $style_id_item[$key] = '<font color="'.$value['value'].'">'.$value['name'].'</font>';
    }
    tomshowsetting(array('title'=>$Lang['style_id'],'name'=>'style_id','value'=>$options['style_id'],'msg'=>$Lang['style_id_msg'],'item'=>$style_id_item),"radio");
    $must_tel_item = array(0=>$Lang['close'],1=>$Lang['open']);
    tomshowsetting(array('title'=>$Lang['must_tel'],'name'=>'must_tel','value'=>$options['must_tel'],'msg'=>$Lang['must_tel_msg'],'item'=>$must_tel_item),"radio");
    $open_bianhao_item = array(0=>$Lang['close'],1=>$Lang['open']);
    tomshowsetting(array('title'=>$Lang['open_bianhao'],'name'=>'open_bianhao','value'=>$options['open_bianhao'],'msg'=>$Lang['open_bianhao_msg'],'item'=>$open_bianhao_item),"radio");
    $close_webtp_item = array(0=>$Lang['close'],1=>$Lang['open']);
    tomshowsetting(array('title'=>$Lang['close_webtp'],'name'=>'close_webtp','value'=>$options['close_webtp'],'msg'=>$Lang['close_webtp_msg'],'item'=>$close_webtp_item),"radio");
    $bm_status_item = array(0=>$Lang['close'],1=>$Lang['open']);
    tomshowsetting(array('title'=>$Lang['bm_status'],'name'=>'bm_status','value'=>$options['bm_status'],'msg'=>$Lang['bm_status_msg'],'item'=>$bm_status_item),"radio");
    tomshowsetting(array('title'=>$Lang['start_time'],'name'=>'start_time','value'=>$options['start_time'],'msg'=>$Lang['start_time_msg']),"calendar");
    tomshowsetting(array('title'=>$Lang['end_time'],'name'=>'end_time','value'=>$options['end_time'],'msg'=>$Lang['end_time_msg']),"calendar");
    tomshowsetting(array('title'=>$Lang['pic_url'],'name'=>'pic_url','value'=>$options['pic_url'],'msg'=>$Lang['pic_url_msg']),"file");
    $focus_status_item = array(0=>$Lang['close'],1=>$Lang['open']);
    tomshowsetting(array('title'=>$Lang['focus_status'],'name'=>'focus_status','value'=>$options['focus_status'],'msg'=>$Lang['focus_status_msg'],'item'=>$focus_status_item),"radio");
    tomshowsetting(array('title'=>$Lang['focus_pic1'],'name'=>'focus_pic1','value'=>$options['focus_pic1'],'msg'=>$Lang['focus_pic1_msg']),"file");
    tomshowsetting(array('title'=>$Lang['focus_pic_url1'],'name'=>'focus_pic_url1','value'=>$options['focus_pic_url1'],'msg'=>$Lang['focus_pic_url1_msg']),"input");
    tomshowsetting(array('title'=>$Lang['focus_pic2'],'name'=>'focus_pic2','value'=>$options['focus_pic2'],'msg'=>$Lang['focus_pic2_msg']),"file");
    tomshowsetting(array('title'=>$Lang['focus_pic_url2'],'name'=>'focus_pic_url2','value'=>$options['focus_pic_url2'],'msg'=>$Lang['focus_pic_url2_msg']),"input");
    tomshowsetting(array('title'=>$Lang['focus_pic3'],'name'=>'focus_pic3','value'=>$options['focus_pic3'],'msg'=>$Lang['focus_pic3_msg']),"file");
    tomshowsetting(array('title'=>$Lang['focus_pic_url3'],'name'=>'focus_pic_url3','value'=>$options['focus_pic_url3'],'msg'=>$Lang['focus_pic_url3_msg']),"input");
    tomshowsetting(array('title'=>$Lang['prize_txt'],'name'=>'prize_txt','value'=>$options['prize_txt'],'msg'=>$Lang['prize_txt_msg']),"text");
    tomshowsetting(array('title'=>$Lang['content'],'name'=>'content','value'=>$options['content'],'msg'=>$Lang['content_msg']),"text");
    tomshowsetting(array('title'=>$Lang['item_obj_name'],'name'=>'item_obj_name','value'=>$options['item_obj_name'],'msg'=>$Lang['item_obj_name_msg']),"input");
    tomshowsetting(array('title'=>$Lang['share_title'],'name'=>'share_title','value'=>$options['share_title'],'msg'=>$Lang['share_title_msg']),"input");
    tomshowsetting(array('title'=>$Lang['share_desc'],'name'=>'share_desc','value'=>$options['share_desc'],'msg'=>$Lang['share_desc_msg']),"input");
    tomshowsetting(array('title'=>$Lang['share_logo'],'name'=>'share_logo','value'=>$options['share_logo'],'msg'=>$Lang['share_logo_msg']),"file");
    tomshowsetting(array('title'=>$Lang['guanzu_qrcode'],'name'=>'guanzu_qrcode','value'=>$options['guanzu_qrcode'],'msg'=>$Lang['guanzu_qrcode_msg']),"file");
    tomshowsetting(array('title'=>$Lang['guanzu_desc'],'name'=>'guanzu_desc','value'=>$options['guanzu_desc'],'msg'=>$Lang['guanzu_desc_msg']),"textarea");
    tomshowsetting(array('title'=>$Lang['guanzu_url'],'name'=>'guanzu_url','value'=>$options['guanzu_url'],'msg'=>$Lang['guanzu_url_msg']),"input");
    $cj_status_item = array(0=>$Lang['close'],1=>$Lang['open']);
    tomshowsetting(array('title'=>$Lang['cj_status'],'name'=>'cj_status','value'=>$options['cj_status'],'msg'=>$Lang['cj_status_msg'],'item'=>$cj_status_item),"radio");
    tomshowsetting(array('title'=>$Lang['cj_id'],'name'=>'cj_id','value'=>$options['cj_id'],'msg'=>$Lang['cj_id_msg']),"input");
    $must_gz_item = array(0=>$Lang['close'],1=>$Lang['open']);
    tomshowsetting(array('title'=>$Lang['must_gz'],'name'=>'must_gz','value'=>$options['must_gz'],'msg'=>$Lang['must_gz_msg'],'item'=>$must_gz_item),"radio");
    tomshowsetting(array('title'=>$Lang['ads_text'],'name'=>'ads_text','value'=>$options['ads_text'],'msg'=>$Lang['ads_text_msg']),"text");
    tomshowsetting(array('title'=>$Lang['mp3_link'],'name'=>'mp3_link','value'=>$options['mp3_link'],'msg'=>$Lang['mp3_link_msg']),"input");
    tomshowsetting(array('title'=>$Lang['xuni_clicks'],'name'=>'xuni_clicks','value'=>$options['xuni_clicks'],'msg'=>$Lang['xuni_clicks_msg']),"input");
    tomshowsetting(array('title'=>$Lang['pic_err_msg'],'name'=>'pic_err_msg','value'=>$options['pic_err_msg'],'msg'=>$Lang['pic_err_msg_msg']),"textarea");
    tomshowsetting(array('title'=>$Lang['paixu'],'name'=>'paixu','value'=>$options['paixu'],'msg'=>$Lang['paixu_msg']),"input");
    
    return;
}

function __create_nav_html($infoArr = array()){
    global $Lang,$modBaseUrl,$adminBaseUrl;
    tomshownavheader();
    if($_GET['act'] == 'add'){
        tomshownavli($Lang['vote_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['vote_add'],"",true);
    }else if($_GET['act'] == 'edit'){
        tomshownavli($Lang['vote_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['vote_add'],$modBaseUrl."&act=add",false);
        tomshownavli($Lang['vote_edit'],"",true);
    }else{
        tomshownavli($Lang['vote_list_title'],$modBaseUrl,true);
        tomshownavli($Lang['vote_add'],$modBaseUrl."&act=add",false);
    }
    tomshownavfooter();
}

