<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$modBaseUrl = $adminBaseUrl.'&tmod=level';
$modListUrl = $adminListUrl.'&tmod=level';
$modFromUrl = $adminFromUrl.'&tmod=level';

if($_GET['act'] == 'add'){
    if(submitcheck('submit')){
        $insertData = array();
        $insertData = __get_post_data();
        C::t('#tom_tchehuoren#tom_tchehuoren_dengji')->insert($insertData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        tomloadcalendarjs();
        loadeditorjs();
        __create_nav_html();
        showformheader($modFromUrl.'&act=add','enctype');
        showtableheader();
        __create_info_html();
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
    
}else if($_GET['act'] == 'edit'){
    $dengjiInfo = C::t('#tom_tchehuoren#tom_tchehuoren_dengji')->fetch_by_id($_GET['id']);
    if(submitcheck('submit')){
        $updateData = array();
        $updateData = __get_post_data($dengjiInfo);
        C::t('#tom_tchehuoren#tom_tchehuoren_dengji')->update($dengjiInfo['id'],$updateData);
        cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    }else{
        tomloadcalendarjs();
        loadeditorjs();
        __create_nav_html();
        showformheader($modFromUrl.'&act=edit&id='.$_GET['id'],'enctype');
        showtableheader();
        __create_info_html($dengjiInfo);
        showsubmit('submit', 'submit');
        showtablefooter();
        showformfooter();
    }
}else if($_GET['formhash'] == FORMHASH && $_GET['act'] == 'del'){
    
    C::t('#tom_tchehuoren#tom_tchehuoren_dengji')->delete_by_id($_GET['id']);
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else if($_GET['act'] == 'import' && $_GET['formhash'] == FORMHASH){
    
    $importArr = array(
        0 => array(
            'level'                 => 1,
            'name'                  => lang('plugin/tom_tchehuoren', 'dengji_import_name_1'),
            'picurl'                => 'source/plugin/tom_tchehuoren/images/silver_hehuioren.png',
            'tuijian_fc_scale'      => 20,
            'fl_fc_open'            => 1,
            'fl_fc_scale'           => 20,
            'shop_fc_open'          => 1,
            'shop_fc_scale'         => 20,
            'qg_fc_open'            => 1,
            'up_level'              => '',
        ),
        1 => array(
            'level'                 => 2,
            'name'                  => lang('plugin/tom_tchehuoren', 'dengji_import_name_2'),
            'picurl'                => 'source/plugin/tom_tchehuoren/images/gold_hehuoren.png',
            'tuijian_fc_scale'      => 30,
            'fl_fc_open'            => 1,
            'fl_fc_scale'           => 30,
            'shop_fc_open'          => 1,
            'shop_fc_scale'         => 30,
            'qg_fc_open'            => 1,
            'up_level'              => 500,
        ),
        2 => array(
            'level'                 => 3,
            'name'                  => lang('plugin/tom_tchehuoren', 'dengji_import_name_3'),
            'picurl'                => 'source/plugin/tom_tchehuoren/images/super_hehuoren.png',
            'tuijian_fc_scale'      => 35,
            'fl_fc_open'            => 1,
            'fl_fc_scale'           => 35,
            'shop_fc_open'          => 1,
            'shop_fc_scale'         => 35,
            'qg_fc_open'            => 1,
            'up_level'              => 1000,
        ),
    );
    
    foreach($importArr as $key => $value){
        $insertData = array();
        $insertData['level']            = $value['level'];
        $insertData['name']             = $value['name'];
        $insertData['picurl']           = $value['picurl'];
        $insertData['tuijian_fc_scale'] = $value['tuijian_fc_scale'];
        $insertData['fl_fc_open']       = $value['fl_fc_open'];
        $insertData['fl_fc_scale']      = $value['fl_fc_scale'];
        $insertData['shop_fc_open']     = $value['shop_fc_open'];
        $insertData['shop_fc_scale']    = $value['shop_fc_scale'];
        $insertData['qg_fc_open']       = $value['qg_fc_open'];
        $insertData['up_level']         = $value['up_level'];
        C::t('#tom_tchehuoren#tom_tchehuoren_dengji')->insert($insertData);
    }
    cpmsg($Lang['act_success'], $modListUrl, 'succeed');
    
}else{
    
    $page = intval($_GET['page'])>0? intval($_GET['page']):1;
    
    $pagesize = 100;
    $start = ($page-1)*$pagesize;
    $count = C::t('#tom_tchehuoren#tom_tchehuoren_dengji')->fetch_all_count("");
    $dengjiList = C::t('#tom_tchehuoren#tom_tchehuoren_dengji')->fetch_all_list(""," ORDER BY add_time ASC,id ASC ",$start,$pagesize);
    
    showtableheader();
    echo '<tr><th colspan="15" class="partition">' . $Lang['hehuoren_help_title'] . '</th></tr>';
    echo '<tr><td  class="tipsblock" s="1"><ul id="tipslis">';
    echo '<li><font color="#f00">' . $Lang['dengji_help_1'] . '</font></li>';
    echo '<li><a href="javascript:void(0);" onclick="import_confirm(\''.$modBaseUrl.'&act=import&formhash='.FORMHASH.'\');" class="addtr" ><font color="#F60">'.$Lang['dengji_import'].'</font></a></li>';
    echo '</ul></td></tr>';
    showtablefooter();
    
    __create_nav_html();
    showtableheader();
    echo '<tr class="header">';
    echo '<th> '. $Lang['dengji_level'] .' </th>';
    echo '<th>' . $Lang['dengji_name'] . '</th>';
    echo '<th>' . $Lang['dengji_picurl'] . '</th>';
    echo '<th>' . $Lang['dengji_tuijian_fc_scale'] . '</th>';
    echo '<th>' . $Lang['dengji_fl_fc_open_status'] . '</th>';
    echo '<th>' . $Lang['dengji_shop_fc_open_status'] . '</th>';
    echo '<th>' . $Lang['dengji_114_fc_open_status'] . '</th>';
    echo '<th>' . $Lang['dengji_vip_fc_open_status'] . '</th>';
    echo '<th>' . $Lang['dengji_qg_fc_open_status'] . '</th>';
    echo '<th>' . $Lang['dengji_pt_fc_open_status'] . '</th>';
    echo '<th>' . $Lang['dengji_mall_fc_open_status'] . '</th>';
    echo '<th>' . $Lang['dengji_up_level'] . '</th>';
    echo '<th>' . $Lang['handle'] . '</th>';
    echo '</tr>';
    
    $i = 1;
    foreach ($dengjiList as $key => $value) {
        
        if(!preg_match('/^http/', $value['picurl']) ){
            if(strpos($value['picurl'], 'source/plugin/tom_tchehuoren') === false){
                $picurl = (preg_match('/^http/', $_G['setting']['attachurl']) ? '' : $_G['siteurl']).$_G['setting']['attachurl'].'tomwx/'.$value['picurl'];
            }else{
                $picurl = $value['picurl'];
            }
        }else{
            $picurl = $value['picurl'];
        }
        $dengji_level = '';
        if($value['level'] == 1){
            $dengji_level = $Lang['dengji_level_1'];
        }else if($value['level'] == 2){
            $dengji_level = $Lang['dengji_level_2'];
        }else if($value['level'] == 3){
            $dengji_level = $Lang['dengji_level_3'];
        }else{
            $dengji_level = '--';
        }
        
        echo '<tr>';
        echo '<td>' . $dengji_level . '</td>';
        echo '<td>' . $value['name'] . '</td>';
        echo '<td><img src="'.$picurl.'" width="80" /></td>';
        echo '<td>' . $value['tuijian_fc_scale'] . '%</td>';
        if($value['fl_fc_open'] == 1){
            echo '<td><font color="#0a9409">'.$Lang['open'].'('.$value['fl_fc_scale'].'%)</font></td>';
        }else{
            echo '<td><font color="#f00">'.$Lang['close'].'</font></td>';
        }
        if($value['shop_fc_open'] == 1){
            echo '<td><font color="#0a9409">'.$Lang['open'].'('.$value['shop_fc_scale'].'%)</font></td>';
        }else{
            echo '<td><font color="#f00">'.$Lang['close'].'</font></td>';
        }
        if($value['114_fc_open'] == 1){
            echo '<td><font color="#0a9409">'.$Lang['open'].'('.$value['114_fc_scale'].'%)</font></td>';
        }else{
            echo '<td><font color="#f00">'.$Lang['close'].'</font></td>';
        }
        if($value['vip_fc_open'] == 1){
            echo '<td><font color="#0a9409">'.$Lang['open'].'('.$value['vip_fc_scale'].'%)</font></td>';
        }else{
            echo '<td><font color="#f00">'.$Lang['close'].'</font></td>';
        }
        if($value['qg_fc_open'] == 1){
            echo '<td><font color="#0a9409">'.$Lang['open'].'</font></td>';
        }else{
            echo '<td><font color="#f00">'.$Lang['close'].'</font></td>';
        }
        if($value['pt_fc_open'] == 1){
            echo '<td><font color="#0a9409">'.$Lang['open'].'</font></td>';
        }else{
            echo '<td><font color="#f00">'.$Lang['close'].'</font></td>';
        }
        if($value['mall_fc_open'] == 1){
            echo '<td><font color="#0a9409">'.$Lang['open'].'</font></td>';
        }else{
            echo '<td><font color="#f00">'.$Lang['close'].'</font></td>';
        }
        echo '<td>' . $value['up_level'] . '</td>';
        echo '<td>';
        echo '<a href="'.$modBaseUrl.'&act=edit&id='.$value['id'].'&formhash='.FORMHASH.'">' . $Lang['edit']. '</a>&nbsp;|&nbsp;';
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
function import_confirm(url){
  var r = confirm("{$Lang['makesure_import_msg']}")
  if (r == true){
    window.location = url;
  }else{
    return false;
  }
}
            
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
    
    $name                       = isset($_GET['name'])? addslashes($_GET['name']):'';
    $level                      = isset($_GET['level'])? intval($_GET['level']):1;
    $tuijian_fc_scale           = isset($_GET['tuijian_fc_scale'])? intval($_GET['tuijian_fc_scale']):0;
    $fl_fc_open                 = isset($_GET['fl_fc_open'])? intval($_GET['fl_fc_open']):0;
    $fl_fc_scale                = isset($_GET['fl_fc_scale'])? intval($_GET['fl_fc_scale']):0;
    $shop_fc_open               = isset($_GET['shop_fc_open'])? intval($_GET['shop_fc_open']):0;
    $shop_fc_scale              = isset($_GET['shop_fc_scale'])? intval($_GET['shop_fc_scale']):0;
    $qg_fc_open                 = isset($_GET['qg_fc_open'])? intval($_GET['qg_fc_open']):0;
    $pt_fc_open                 = isset($_GET['pt_fc_open'])? intval($_GET['pt_fc_open']):0;
    $mall_fc_open               = isset($_GET['mall_fc_open'])? intval($_GET['mall_fc_open']):0;
    $_114_fc_open               = isset($_GET['114_fc_open'])? intval($_GET['114_fc_open']):0;
    $_114_fc_scale              = isset($_GET['114_fc_scale'])? intval($_GET['114_fc_scale']):0;
    $vip_fc_open                = isset($_GET['vip_fc_open'])? intval($_GET['vip_fc_open']):0;
    $vip_fc_scale               = isset($_GET['vip_fc_scale'])? intval($_GET['vip_fc_scale']):0;
    $up_level                   = isset($_GET['up_level'])? intval($_GET['up_level']):0;
    
    $picurl = "";
    if($_GET['act'] == 'add'){
        $picurl        = tomuploadFile("picurl");
    }else if($_GET['act'] == 'edit'){
        $picurl        = tomuploadFile("picurl",$infoArr['picurl']);
    }
    
    $data['name']                   = $name;
    $data['level']                  = $level;
    $data['picurl']                 = $picurl;
    $data['tuijian_fc_scale']       = $tuijian_fc_scale;
    $data['fl_fc_open']             = $fl_fc_open;
    $data['fl_fc_scale']            = $fl_fc_scale;
    $data['shop_fc_open']           = $shop_fc_open;
    $data['shop_fc_scale']          = $shop_fc_scale;
    $data['qg_fc_open']             = $qg_fc_open;
    $data['pt_fc_open']             = $pt_fc_open;
    $data['mall_fc_open']           = $mall_fc_open;
    $data['114_fc_open']            = $_114_fc_open;
    $data['114_fc_scale']           = $_114_fc_scale;
    $data['vip_fc_open']            = $vip_fc_open;
    $data['vip_fc_scale']           = $vip_fc_scale;
    $data['up_level']               = $up_level;
    
    return $data;
}

function __create_info_html($infoArr = array()){
    global $Lang;
    $options = array(
        'name'                  => '',
        'level'                 => 1,
        'picurl'                => '',
        'tuijian_fc_scale'      => 0,
        'fl_fc_open'            => 0,
        'fl_fc_scale'           => 0,
        'shop_fc_open'          => 0,
        'shop_fc_scale'         => 0,
        'qg_fc_open'            => 0,
        'pt_fc_open'            => 0,
        'mall_fc_open'          => 0,
        '114_fc_open'           => 0,
        '114_fc_scale'          => 0,
        'vip_fc_open'           => 0,
        'vip_fc_scale'          => 0,
        'up_level'              => 0,
    );
    $options = array_merge($options, $infoArr);
    
    tomshowsetting(true,array('title'=>$Lang['dengji_name'],'name'=>'name','value'=>$options['name'],'msg'=>$Lang['dengji_name_msg']),"input");
    $level_item = array(1=>$Lang['dengji_level_1'],2=>$Lang['dengji_level_2'],3=>$Lang['dengji_level_3']);
    tomshowsetting(true,array('title'=>$Lang['dengji_level'],'name'=>'level','value'=>$options['level'],'msg'=>$Lang['dengji_level_msg'],'item'=>$level_item),"radio");
    tomshowsetting(true,array('title'=>$Lang['dengji_picurl'],'name'=>'picurl','value'=>$options['picurl'],'msg'=>$Lang['dengji_picurl_msg']),"file");
    tomshowsetting(true,array('title'=>$Lang['dengji_tuijian_fc_scale'],'name'=>'tuijian_fc_scale','value'=>$options['tuijian_fc_scale'],'msg'=>$Lang['dengji_tuijian_fc_scale_msg']),"input");
    $open_item = array(1=>$Lang['open'],0=>$Lang['close']);
    tomshowsetting(true,array('title'=>$Lang['dengji_fl_fc_open'],'name'=>'fl_fc_open','value'=>$options['fl_fc_open'],'msg'=>$Lang['dengji_fl_fc_open_msg'],'item'=>$open_item),"radio");
    tomshowsetting(true,array('title'=>$Lang['dengji_fl_fc_scale'],'name'=>'fl_fc_scale','value'=>$options['fl_fc_scale'],'msg'=>$Lang['dengji_fl_fc_scale_msg']),"input");
    tomshowsetting(true,array('title'=>$Lang['dengji_shop_fc_open'],'name'=>'shop_fc_open','value'=>$options['shop_fc_open'],'msg'=>$Lang['dengji_shop_fc_open_msg'],'item'=>$open_item),"radio");
    tomshowsetting(true,array('title'=>$Lang['dengji_shop_fc_scale'],'name'=>'shop_fc_scale','value'=>$options['shop_fc_scale'],'msg'=>$Lang['dengji_shop_fc_scale_msg']),"input");
    tomshowsetting(true,array('title'=>$Lang['dengji_qg_fc_open'],'name'=>'qg_fc_open','value'=>$options['qg_fc_open'],'msg'=>$Lang['dengji_qg_fc_open_msg'],'item'=>$open_item),"radio");
    tomshowsetting(true,array('title'=>$Lang['dengji_pt_fc_open'],'name'=>'pt_fc_open','value'=>$options['pt_fc_open'],'msg'=>$Lang['dengji_pt_fc_open_msg'],'item'=>$open_item),"radio");
    tomshowsetting(true,array('title'=>$Lang['dengji_mall_fc_open'],'name'=>'mall_fc_open','value'=>$options['mall_fc_open'],'msg'=>$Lang['dengji_mall_fc_open_msg'],'item'=>$open_item),"radio");
    tomshowsetting(true,array('title'=>$Lang['dengji_114_fc_open'],'name'=>'114_fc_open','value'=>$options['114_fc_open'],'msg'=>$Lang['dengji_114_fc_open_msg'],'item'=>$open_item),"radio");
    tomshowsetting(true,array('title'=>$Lang['dengji_114_fc_scale'],'name'=>'114_fc_scale','value'=>$options['114_fc_scale'],'msg'=>$Lang['dengji_114_fc_scale_msg']),"input");
    tomshowsetting(true,array('title'=>$Lang['dengji_vip_fc_open'],'name'=>'vip_fc_open','value'=>$options['vip_fc_open'],'msg'=>$Lang['dengji_vip_fc_open_msg'],'item'=>$open_item),"radio");
    tomshowsetting(true,array('title'=>$Lang['dengji_vip_fc_scale'],'name'=>'vip_fc_scale','value'=>$options['vip_fc_scale'],'msg'=>$Lang['dengji_vip_fc_scale_msg']),"input");
    tomshowsetting(true,array('title'=>$Lang['dengji_up_level'],'name'=>'up_level','value'=>$options['up_level'],'msg'=>$Lang['dengji_up_level_msg']),"input");
    
    return;
}

function __create_nav_html($infoArr = array()){
    global $Lang,$modBaseUrl,$adminBaseUrl;
    
    $count = C::t('#tom_tchehuoren#tom_tchehuoren_dengji')->fetch_all_count("");
    
    tomshownavheader();
    if($_GET['act'] == 'add'){
        tomshownavli($Lang['dengji_list_title'],$modBaseUrl,false);
        tomshownavli($Lang['dengji_add'],"",true);
    }else if($_GET['act'] == 'edit'){
        tomshownavli($Lang['dengji_list_title'],$modBaseUrl,false);
        if($count < 3){
            tomshownavli($Lang['dengji_add'],$modBaseUrl."&act=add",false);
        }
        tomshownavli($Lang['dengji_edit'],"",true);
    }else{
        tomshownavli($Lang['dengji_list_title'],$modBaseUrl,true);
        if($count < 3){
            tomshownavli($Lang['dengji_add'],$modBaseUrl."&act=add",false);
        }
    }
    tomshownavfooter();
}