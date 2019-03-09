<?php

if(empty($_GET['myac']) && !defined('IN_ADMINCP')){
    exit('Access Denied');
}


require_once(DISCUZ_ROOT.'source/plugin/dxc_api/config.inc.php');

$header_arr = array('api_info');
$args = array('default_ac' => 'api_info');

seo_tpl($args);

function api_info(){

    $api_key = get_api_key();

	$show .= dxcShowHelper::show_title(stlang('connect_info'));

    $show .=  dxcShowHelper::add_tr(
                                 array(
                                       'name' => stlang('local_key_code'),
                                       'desc' => stlang('local_key_code_notice'),
                                       )
                                 , $api_key.'<a  style=" margin-left:15px;" href="?'.PLUGIN_GO.'api_info&myac=create_api_key">'.stlang('rebuild').'</a><a onclick="setCopy(\''.$api_key.'\', \''.stlang('copy_success').'\');return false;" style=" margin-left:15px;" href="javascript:void(0);">'.stlang('copy').'</a>');





	$show .= dxcShowHelper::show_title(stlang('about_info'));


	$show .=  dxcShowHelper::add_tr(
                                 array(
                                       'name' => '',
                                       'desc' => '',
                                       )
                                 ,  stlang('bbs_name').'   <a  target="_blank" href="http://bbs.dxcer.com/">http://bbs.dxcer.com/</a>');

	$show .=  dxcShowHelper::add_tr(
                                 array(
                                       'name' => '',
                                       'desc' => '',
                                       )
                                 ,  stlang('jia_qun').'<img style="margin-top:15px;" src="http://www.dxcer.com/images/jiaqun.jpg" width="280" height="384">');


    $info['show'] = $show;
    $info['tpl'] = 'common_set';
    $info['submit_style'] = 'style="display:none"';
    return $info;

}

function get_api_info($api_id){

    $data_info = DB::fetch_first("SELECT * FROM ".DB::table('dxcapi_list')." WHERE id='".$api_id."'");
    $info = dunserialize($data_info['config']);
    $info['name'] = $data_info['name'];
    $info['id'] = $data_info['id'];

    return $info;
}


function dxc_api_call(){

    $action = $_POST['action'];
    $api_key = $_POST['api_key'];

    $dxcsdk = get_dxc_sdk_object();


    $allow_action = array('api_info', 'category_list', 'category_sort_list', 'attach_upload', 'field_data', 'post_data');
    if(empty($action) || !in_array($action , $allow_action)) exit('Access Denied:0255');

    $ori_api_key = get_api_key();

	if($ori_api_key != $api_key){
		$result_data['status'] = -1;
		$result_data['msg'] = stlang('api_key_error');
		return $dxcsdk->json_encode($result_data);
	}


    $func = 'dxc_call_'.$action;


    return $dxcsdk->json_encode($func());


}


function get_dxc_sdk_object(){
    sload('C:dxcsdk');
    $dxcsdk = new dxcsdk();
    $dxcsdk->charset = CHARSET;
    return $dxcsdk;
}


function dxc_call_api_info(){

    $result_data = array('status' => 0, 'msg'=> 'ok', 'data' => '');

    $system['cms_type'] = 'discuz';
    $system['cms_vertion'] = DISCUZ_VERSION;
	$system['api_version'] = PLUGIN_VERSION;
	$system['charset'] = CHARSET;

    $result_data['data'] = $system;

    return $result_data;

}

function dxc_call_category_list(){

    global $_G;

    $result_data = array('status' => 0, 'msg'=> 'ok', 'data' => '');



    loadcache('forums');
    $forumcache = &$_G['cache']['forums'];

    $categery_data = array();
    $categery_data['forum'] = array('name' => stlang('forum'), 'id' => 'forum');

    foreach ($forumcache as $key => $value) {
        $categery_data['forum']['data'][] = array('id' => $value['fid'], 'name' => $value['name'], 'parent_id' => $value['fup'], 'disabled' => $value['type'] == 'group' ? 1 : 0);
    }


    loadcache('portalcategory');
	$category = $_G['cache']['portalcategory'];
    $categery_data['portal'] = array('name' => stlang('portal'), 'id' => 'portal');
    foreach ($category as $key => $value) {
        $categery_data['portal']['data'][] = array('id' => $value['catid'], 'name' => $value['catname'], 'parent_id' => $value['upid'], 'disabled' => 0);
    }

    $result_data['data']['level'] = 2;//层级
    $result_data['data']['multiselect'] = 0;//是否多选
    $result_data['data']['api_callback'] = 'category_sort_list';//选择分类是否需要回调请求
    $result_data['data']['categery_data'] = $categery_data;


    return $result_data;



}


function dxc_call_category_sort_list(){
    global $_G;

    $result_data = array('status' => 0, 'msg'=> 'ok', 'data' => '');


    $catid = $_POST['cat_data']['catid'];

    $public_type = $catid[0];
    $fid = $catid[1];

    if($public_type == 'portal'){
        return $result_data;
    }


    $field_data = array();

    //主题分类字段
    $query = DB::query("SELECT typeid,name,displayorder FROM ".DB::table('forum_threadclass')." WHERE  fid='$fid' ORDER BY displayorder");
    $data = array();
    while($rs = DB::fetch($query)) {
        $data[] = array('id' => $rs['typeid'], 'name' => $rs['name'], 'disabled' => 0);
    }

    $field_data['typeid'] = array('id' => 'typeid', 'name' => stlang('thread_type_name'), 'type' => 'select', 'data' => $data);

    //分类信息字段
    $forum_forumfield_info = DB::fetch_first("SELECT threadsorts,moderators FROM ".DB::table('forum_forumfield')." WHERE fid='$fid'");
	$threadsorts_data = dunserialize($forum_forumfield_info['threadsorts']);
	$types = $threadsorts_data['types'];
    $data = array();
    foreach($types as $typeid => $name){
        $data[] = array('id' => $typeid, 'name' => $name, 'disabled' => 0);
    }

    $field_data['sortid'] = array('id' => 'sortid', 'name' => stlang('sort_name'), 'type' => 'select', 'data' => $data);


    $result_data['data'] = $field_data;

    return $result_data;



}


function dxc_call_field_data(){

    global $_G,$field_tpl_portal,$field_tpl_forum;

    $result_data = array('status' => 0, 'msg'=> 'ok', 'data' => '');
    $cat_data = $_POST['cat_data'];
    $catid = $cat_data['catid'];
    $ext_catid = $cat_data['ext_catid'];


    $public_type = $catid[0];
    $catid = $catid[1];

    $field_data = $public_type == 'forum' ? $field_tpl_forum : $field_tpl_portal;


    if($public_type == 'forum'){
        $fid = $catid;
        $threadsortid = $ext_catid['sortid'];
        $ext_field_data = get_threadtypes_field_data($fid, $threadsortid);
        $field_data = array_merge($field_data, $ext_field_data);
    }else {
        $field_data = $field_tpl_portal;
    }

    $result_data['data']['bind'] = $field_data;
    $result_data['data']['ext'] = array(
        'is_htmlon' => array(
            'type' => 'radio',
            'name' => stlang('is_htmlon'),
            'desc' => stlang('is_htmlon_notice'),
            'data' => array('0' => stlang('yes'), '1' => stlang('no')),
            'default_val' => '1'
        )
    );

    return $result_data;


}




function get_threadtypes_field_data($fid, $sortid){

	global $_G;

	loadcache(array('threadsort_option_'.$sortid));

	$sortoptionarray = $_G['cache']['threadsort_option_'.$sortid];


	$field_data = array();

	foreach($sortoptionarray as $k => $v){
		$identifier = $v['identifier'];
		$field_data[$identifier] = array('key' => $identifier, 'name' => $v['title']);
	}

	return $field_data;

}

function dxc_call_attach_upload(){
    global $_G;

    $result_data = array('status' => 0, 'msg'=> 'ok', 'data' => '');

    $attach_dir = PLUGIN_ATTACH_CACHE_DIR;

    $upload_re = dxcsdk::upload($attach_dir);

    if($upload_re < 0) {
        $result_data['status'] = -2;
        $result_data['msg'] = stlang('attach_upload_temp_dir_no_writeable', array('d' => $attach_dir));
		return $result_data;
    }

    return $result_data;

}



function dxc_call_post_data(){

	global $_G;


    $api_key = $_POST['api_key'];
    $api_id = $_POST['api_id'];


	$post_data = dxcsdk::get_post_data(PLUGIN_ATTACH_CACHE_DIR);


    $result_data = array('status' => 0, 'msg'=> '', 'data' => '');



    if(!$post_data['field_data']['content']){
        $result_data['status'] = -3;
        $result_data['msg'] = stlang('article_content_empty');
		return $result_data;
    }

    if(!$post_data['field_data']['title']){
        $result_data['status'] = -4;
        $result_data['msg'] = stlang('article_title_empty');
		return $result_data;
    }

    sload('C:article');

    $article_obj =  new article($post_data);

    $article_obj->post();


	if($article_obj->errno < 0){
		$result_data['status'] = $article_obj->errno;
        $result_data['msg'] = $article_obj->errmsg;
		return $result_data;
	}


	$result_data['data']['data_id'] = $article_obj->cache['finsh']['insert_id'];
	$result_data['data']['data_url'] = $article_obj->cache['finsh']['url'];



	return $result_data;


}



function create_api_key(){
    $set['api_key'] = random(20);
    tool_common_set('global', $set);
    cpmsg(stlang('op_success'), PLUGIN_GO."api_info", 'succeed');
}


?>