<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


class article{

    var $post_data;
    var $api_info;
	var $public_type;
	var $cache;
	var $errno;
	var $errmsg;
	var $is_bbs;

	function article($post_data){

		global $_G;

        $this->post_data = $post_data;

		$this->errno = 0;
		$this->errmsg = '';

		if($this->check_evn() == false) return;


		$this->public_type = $post_data['post_config']['cat_data']['catid'][0];
		$this->catid = $post_data['post_config']['cat_data']['catid'][1];

		$this->api_info['view_num'] = $post_data['post_config']['field_ext']['view_num'];
		$this->api_info['is_htmlon'] = $post_data['post_config']['field_ext']['is_htmlon'] == 1 ? 0 : 1;
		$this->api_info['public_uid'] = $post_data['post_config']['field_ext']['public_uid'];
		$this->api_info['reply_uid'] = $post_data['post_config']['field_ext']['reply_uid'];



		$this->cache['article_info']['view_num'] = dxcsdk::get_rand_data($this->api_info['view_num']);

		//门户跟论坛的字段名称不一样
		$this->post_data['field_data']['public_dateline'] = $this->post_data['field_data']['dateline'] ? $this->post_data['field_data']['dateline'] : $this->post_data['field_data']['public_dateline'];

		if(!empty($this->post_data['field_data']['public_dateline'])){//如果有发布时间,进行转换
			$new_date = dxcsdk::strtotime($this->post_data['field_data']['public_dateline']);
			$this->post_data['field_data']['public_dateline'] = $new_date ? $new_date : $_G['timestamp'];
		}


		$this->cache['article_info']['public_time'] = $this->get_article_dateline();


		$user_info = $this->get_article_user_info();

		$this->cache['article_info']['public_uid'] = $user_info['uid'];
		$this->cache['article_info']['public_username'] = $user_info['username'];

		$this->post_data['field_data']['title'] = unhtmlentities(strip_tags($this->post_data['field_data']['title'], '&nbsp;'));


		if(is_array($this->post_data['field_data']['content'])){
			$new_attach_list = array();
			foreach($this->post_data['attach_list']['content'] as $k => $v){
				$new_attach_list = array_merge($new_attach_list, $v);
			}
			$this->post_data['attach_list']['content'] = $new_attach_list;
		}

		$implode_str = $this->public_type == 'forum' ? '' : '###NextPage###';

		//如果有分页的情况
		$this->post_data['field_data']['content'] = is_array($this->post_data['field_data']['content']) ? implode($implode_str, $this->post_data['field_data']['content']) : $this->post_data['field_data']['content'];


		$this->is_bbs = 1;//后续扩展


	}


	function init_error($errno){
		$err = array(
			'-1' => stlang('post_err_reg_pwd_empty'),//密码没设置
			'-2' => stlang('post_err_avatar_dir_no_writeable'),//头像目录不可写
			'-3' => stlang('article_public_error_no_sort'),//发布的版块未开启分类信息
		);

		$this->errno = $errno;
		$this->errmsg = $err[$errno];

	}


	function check_evn(){

		$config = get_common_set();

		if($this->api_info['public_type'] == 'forum'){

			//有注册用户
			if(count($this->post_data['field_data']['reply_username']) > 0){
				if(empty($config['register_pwd'])){
					$this->init_error(-1);
					return false;
				}
			}

			//有会员头像
			if(count($this->post_data['attach_list']['reply_avatar']) > 0){
				sload('F:member');
				$uc_server_dir = get_uc_server_dir();
				if(!dir_writeable($uc_server_dir)){
					$this->init_error(-2);
					return false;
				}
			}

		}

		return true;


	}


    function post(){
        //发布到论坛
        if($this->public_type == 'forum'){
			sload('F:member');
            $this->move_forums();
			$this->reply_public();
        }else if($this->public_type == 'portal'){//门户
            $this->move_portal();
        }

    }


	function article_format_forum(){

	}




    function move_portal(){

        global $_G;

        require_once libfile('function/home');
        require_once libfile('function/portalcp');


        $subject = getstr($this->post_data['field_data']['title'], 80, 0, 0);

        $content = $this->post_data['field_data']['content'];


        $catid = $this->catid;
        loadcache('portalcategory');
        $cat_arr = $_G['cache']['portalcategory'];
        $cat_info = $cat_arr[$catid];
        $contents = 0;

        $view_num = $this->cache['article_info']['view_num'];

        if(empty($summary)) $summary = portalcp_get_summary(stripslashes($content));

        $dateline = $this->cache['article_info']['public_time'];

        $uid = $this->cache['article_info']['public_uid'];
        $username = $this->cache['article_info']['public_username'];

		$member_info = $this->get_member_info($this->post_data['field_data']['public_username'], $this->post_data['attach_list']['public_avatar']['attach']);

		if(is_array($member_info) && $member_info['uid']){
			$uid = $member_info['uid'];
			$username = $member_info['username'];
		}else{
		}


        $pic = $arr['pic'] ? $_thumb.addslashes($arr['pic']) : '';
        $thumb = 0;
        $remote = 0;
        $setarr = array(
                        'title' => $subject,
                        'author' => $this->post_data['field_data']['author'],
                        'from' => $this->post_data['field_data']['from'],
                        'catid' => $catid,
                        'pic' => $pic,
                        'thumb' => $thumb,
                        'remote' => $remote,
                        'fromurl' => $this->post_data['field_data']['fromurl'],
                        'dateline' => $dateline,
                        'url' => '',
                        'allowcomment' => $cat_info['allowcomment'],
                        'summary' => $summary,
                        'tag' => '',
                        'status' => 0,
                        'highlight' => $style,
                        'showinnernav' => empty($arr['showinnernav']) ? '0' : '1',
                        'uid' => $uid,
                        'username' => $username,
                        'contents' => $contents
                        );
        if($this->post_data['data_id']){
            $info = DB::fetch_first("SELECT catid,aid FROM ".DB::table('portal_article_title')." WHERE aid='".$this->post_data['data_id']."'");
            pic_delete($info['pic'], 'portal', $info['thumb'], $info['remote']);

            $query = DB::query("SELECT * FROM ".DB::table('portal_attachment')." WHERE aid='".$this->post_data['data_id']."' ORDER BY attachid DESC");
            while ($value = DB::fetch($query)) {
                pic_delete($value['attachment'], 'portal', $value['thumb'], $value['remote']);
            }
            DB::query('DELETE FROM '.DB::table('portal_attachment')." WHERE aid='".$this->post_data['data_id']."'");//…æ≥˝ƒø«∞µƒ ˝æ›‘Ÿ∏¸–¬

        }
        if(!$info['aid']){
            $aid = DB::insert('portal_article_title', st_addslashes($setarr), 1);
            DB::update('common_member_status', array('lastpost' => $dateline), array('uid' => $uid));
        }else{
            DB::update('portal_article_title', st_addslashes($setarr), array('aid' => $this->post_data['data_id']));
            DB::query('UPDATE '.DB::table('portal_category')." SET articles=articles-1 WHERE catid='".$catid."'");
            $aid = $this->post_data['data_id'];
        }

        $count_setarr = array(
                              'viewnum' => $view_num,
                              'dateline' => $dateline,
                              );
        if(DISCUZ_VERSION != 'X2'){
            unset($count_setarr['dateline']);

        }
        $view_check = DB::fetch_first("SELECT aid FROM ".DB::table('portal_article_count')." WHERE aid='".$aid."'");
        if($view_check){
            DB::update('portal_article_count', $count_setarr, array('aid' => $aid));
        }else{
            $count_setarr['aid'] = $aid;
            DB::insert('portal_article_count', $count_setarr);
        }

        $relatedarr = dunserialize($this->cache['article_info']['raids']);
        DB::query('DELETE FROM '.DB::table('portal_article_related')." WHERE aid='$aid'");
        DB::query('DELETE FROM '.DB::table('portal_article_related')." WHERE raid='$aid'");
        if($relatedarr) {
            $query = DB::query("SELECT * FROM ".DB::table('portal_article_title')." WHERE aid IN (".dimplode($relatedarr).")");
            $list = array();
            while(($value=DB::fetch($query))) {
                $list[$value['aid']] = $value;
            }
            $replaces = array();
            $displayorder = 0;
            foreach($relatedarr as $relate) {
                if(($value = $list[$relate])) {
                    if($value['aid'] != $aid) {
                        $replaces[] = "('$aid', '$value[aid]', '$displayorder')";
                        $replaces[] = "('$value[aid]', '$aid', '0')";
                        $displayorder++;
                    }
                }
            }
            if($replaces) {
                DB::query("REPLACE INTO ".DB::table('portal_article_related')." (aid,raid,displayorder) VALUES ".implode(',', $replaces));
            }
        }

        if(DISCUZ_VERSION != 'X2' && DISCUZ_VERSION != 'X2.5'){
            $pre_next_arr = portalcp_article_pre_next($catid, $aid);
            DB::update('portal_article_title', $pre_next_arr, array('aid' => $aid));
        }

        DB::query('UPDATE '.DB::table('portal_category')." SET articles=articles+1 WHERE catid='".$catid."'");

        $this->cache['common']['public_uid'] = $uid;
        $this->cache['common']['public_username'] = $username;
        $this->cache['common']['public_time'] = $dateline;
        $this->cache['common']['catid'] = $catid;
        $this->cache['common']['aid'] = $aid;

        $this->cache['finsh']['insert_id'] = $aid;
		$this->cache['finsh']['url']  = $_G['siteurl'].'portal.php?mod=view&aid='.$aid;



		$this->portal_attach_content($content);


    }


	function portal_attach_ftp_upload($attach){
		global $_G;
		$dir_name = 'portal';
		$ftpresult_thumb = 0;
		$ftpresult = ftpcmd('upload', $dir_name.'/'.$attach['attachment']);
		if($ftpresult) {
			@unlink($_G['setting']['attachdir'].$dir_name.'/'.$attach['attachment']);
			$thumbpath = getimgthumbname($attach['attachment']);
			ftpcmd('upload', $dir_name.'/'.$thumbpath);
			@unlink($_G['setting']['attachdir'].$dir_name.'/'.$thumbpath);
		}
	}



    //门户
    function portal_attach_content($content){

		global $_G;

		require_once libfile('class/image');

		$attach_arr = $this->post_data['attach_list']['content'];


		$public_time = $this->cache['common']['public_time'] ? $this->cache['common']['public_time'] : $_G['timestamp'];


		pload_upload_class();
		$upload = new discuz_upload();
		$content_md5_arr = array();
		$imagereplace = $aids = array();
		$attach_dir_name = 'portal';




		//处理a标签
		foreach($attach_arr as $key => $value){

			if($value['isimage'] == 1){
				continue;
			}

			$tempvalue = $value;
			$imageurl =  $tempvalue['url'];

			$attach = array();
		    $attach['ext'] = $upload->fileext($value['fileName']);
			$imagereplace['img_search'][$key] = $value['ref'];

			$isimage = $value['isimage'];

			$style_str = $value['style'] ? 'style="'.$value['style'].'"' : '';

			$imagereplace['img_replace'][$key] = '<p style="text-align: center;"><a '.$style_str.' href="'.$value['url'].'" target="_blank" class="attach">'.$value['text'].'</a></p>';

			$img_content = $value['content'];


			if(empty($img_content) || empty($attach['ext'])) {
				continue;
			}


			$attach['name'] = $value['fileName'] ;
			$attach['thumb'] = '';
			$attach['isimage'] = $isimage;
			$attach['attachment'] = $upload -> get_target_dir($attach_dir_name) . $upload->get_target_filename($attach_dir_name).'.'.$attach['ext'];
			$attach['extension'] = $upload -> get_target_extension($attach['ext']);
			$attach['attachdir'] = $upload -> get_target_dir($attach_dir_name);
			$attach['target'] = getglobal('setting/attachdir').'./'.$attach_dir_name.'/'.$attach['attachment'];


			if(!@$fp = fopen($attach['target'], 'wb')) {
				continue;
			} else {
				flock($fp, 2);
				fwrite($fp, $img_content);
				fclose($fp);
			}

			$attach['size'] = strlen($value['content']);
			$attach = daddslashes($attach);


			$remote = 0;
			if($_G['setting']['ftp']['on'] && $this->ftp_check_attach($attach['ext'], $attach['size'])){
				$remote = 1;
				$this->portal_attach_ftp_upload($attach);
			}

			$attach['remote'] = $remote;


			$setarr = array(
				'uid' => $this->cache['common']['public_uid'],
				'filename' => $attach['name'],
				'attachment' => $attach['attachment'],
				'filesize' => $attach['size'],
				'isimage' => $attach['isimage'],
				'thumb' => $attach['thumb'],
				'remote' => $attach['remote'],
				'filetype' => $attach['extension'],
				'dateline' => $this->cache['common']['public_time'],
				'aid' => $this->cache['common']['aid']
			);



			$setarr['attachid'] = DB::insert("portal_attachment", paddslashes($setarr), true);
			if($remote == 1){
				$aids[$setarr['attachid']] = $setarr['attachid'];
				$this->cache['upload']['attach_arr'][$setarr['attachid']] = $setarr;
			}

			$attach['url'] = ($attach['remote'] ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl']).''.$attach_dir_name.'/';

			$attach_url = 'portal.php?mod=attachment&amp;id='.$setarr['attachid'];
			$imagereplace['img_replace'][$key] = '<p style="text-align: center;"><a '.$style_str.' href="'.$attach_url.'" target="_blank" class="attach">'.($value['text'] ? $value['text'] : $attach['name']).'</a></p>';


		}


		$content = str_replace($imagereplace['img_search'], $imagereplace['img_replace'], $content);


		$imagereplace = array();

		$cover_pic_attachment = array();//封面

		//处理img标签
		foreach($attach_arr as $key => $value){

			if($value['isimage'] == 0){
				continue;
			}

			$tempvalue = $value;
			$imageurl =  $tempvalue['url'];
			$attach = array();
		    $attach['ext'] = $upload->fileext($value['fileName']);
			$imagereplace['img_search'][$key] = $value['ref'];


			$isimage = $value['isimage'];
			$imagereplace['img_replace'][$key] = '<p style="text-align: center;"><a href="'.$value['url'].'" target="_blank"><img src="'.$value['url'].'"></a></p>';




			$img_content = $value['content'];


			$attach['name'] = $value['fileName'] ;


			if(empty($img_content) || empty($attach['ext'])) {
				continue;
			}



			$attach['thumb'] = '';
			$attach['isimage'] = $isimage;
			$attach['attachment'] = $upload -> get_target_dir($attach_dir_name) . $upload->get_target_filename($attach_dir_name).'.'.$attach['ext'];
			$attach['extension'] = $upload -> get_target_extension($attach['ext']);
			$attach['attachdir'] = $upload -> get_target_dir($attach_dir_name);
			$attach['target'] = getglobal('setting/attachdir').'./'.$attach_dir_name.'/'.$attach['attachment'];


			if(!@$fp = fopen($attach['target'], 'wb')) {
				continue;
			} else {
				flock($fp, 2);
				fwrite($fp, $img_content);
				fclose($fp);
			}
			if(!$upload->get_image_info($attach['target']) && $attach['isimage'] == 1) {
				@unlink($attach['target']);
				continue;
			}

			if(empty($cover_pic_attachment)){
				$cover_pic_attachment = $attach['attachment'];
			}

			$attach['size'] = strlen($value['content']);
			$attach = daddslashes($attach);

			if($attach['isimage'] && empty($_G['setting']['portalarticleimgthumbclosed'])) {
				$image = new image();
				$thumbimgwidth = $_G['setting']['portalarticleimgthumbwidth'] ? $_G['setting']['portalarticleimgthumbwidth'] : 300;
				$thumbimgheight = $_G['setting']['portalarticleimgthumbheight'] ? $_G['setting']['portalarticleimgthumbheight'] : 300;
				$result = $image->Thumb($attach['target'], '', $thumbimgwidth, $thumbimgheight, 2);
				$attach['thumb'] = empty($result)?0:1;
				$image->Watermark($attach['target'], '', $attach_dir_name);
			}

			$remote = 0;
			if($_G['setting']['ftp']['on'] && $this->ftp_check_attach($attach['ext'], $attach['size'])){
				$remote = 1;
				$this->portal_attach_ftp_upload($attach);
			}

			$attach['remote'] = $remote;


			$setarr = array(
				'uid' => $this->cache['common']['public_uid'],
				'filename' => $attach['name'],
				'attachment' => $attach['attachment'],
				'filesize' => $attach['size'],
				'isimage' => $attach['isimage'],
				'thumb' => $attach['thumb'],
				'remote' => $attach['remote'],
				'filetype' => $attach['extension'],
				'dateline' => $this->cache['common']['public_time'],
				'aid' => $this->cache['common']['aid']
			);
			$setarr['attachid'] = DB::insert("portal_attachment", paddslashes($setarr), true);
			if($remote == 1){
				$aids[$setarr['attachid']] = $setarr['attachid'];
				$this->cache['upload']['attach_arr'][$setarr['attachid']] = $setarr;
			}

			$attach['url'] = ($attach['remote'] ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl']).''.$attach_dir_name.'/';


			$attach_url = $attach['url'].$attach['attachment'];
			$imagereplace['img_replace'][$key] = '<p style="text-align: center;"><a href="'.$attach_url.'" target="_blank"><img src="'.$attach_url.'"></a></p>';


		}


		$content = str_replace($imagereplace['img_search'], $imagereplace['img_replace'], $content);


		$this->cache['upload']['newaids'] = $aids;


		$aid = $this->cache['common']['aid'];


		$content = getstr($content, 0, 0, 1, 0, 1);
		$article_status = 0;
		$regexp = '/(###NextPage(\[title=(.*?)\])?###)+/';
		preg_match_all($regexp, $content ,$arr);
		$pagetitle = $arr[3];
		$pagetitle = array_map('trim', $pagetitle);
		$content_arr = preg_split($regexp, $content);
		$content_count = count($contents);
		$pageorder = intval($arr['pageorder']);
		$id = 0;

		$old_portal_id = $this->post_data['data_id'];//旧的发布id

		if($old_portal_id){
			DB::query('DELETE FROM '.DB::table('portal_article_content')." WHERE aid ='".$old_portal_id."'");
		}

		DB::query('DELETE FROM '.DB::table('portal_article_content')." WHERE aid ='$aid'");
		$idtype = '';
		$thumb = $cover_pic ? 1 : 0;
		$remote = 0;

		//设置封面
		if($content_arr) {

			$attach_img_info = $this->post_data['attach_list']['thumb']['attach'];

			if($attach_img_info){

				$save_name = $attach_img_info['save_name'];
				$attachdir = $upload -> get_target_dir('portal');
				$attachment = $attachdir . $upload->get_target_filename('portal').'.'.$attach_img_info['ext'];
				$this->cache['upload']['cover']['attachment'] = $attachment;

				$remote = $_G['setting']['ftp']['on'] == 1 ? 1 : 0;

				$setarr = array(
					'uid' => $this->cache['common']['public_uid'],
					'filename' => $attach_img_info['fileName'],
					'attachment' => $attachment,
					'filesize' => $attach_img_info['size'],
					'isimage' => 1,
					'thumb' => 1,
					'remote' => $remote,
					'filetype' => $attach_img_info['ext'],
					'dateline' => $this->cache['common']['public_time'],
					'aid' => $this->cache['common']['aid']
				);


				$setarr['attachid'] = DB::insert("portal_attachment", paddslashes($setarr), true);
				$root_url = ($remote ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl']).''.$attach_dir_name.'/';

				$cover_pic = $this->setcover_article($attach_img_info['content'], $attachment);

				if($_G['setting']['ftp']['on']){
					$remote = 1;
					$this->portal_attach_ftp_upload($setarr);
				}


			}else{
				if($_G['setting']['ftp']['on'] == 1){
					@unlink(getglobal('setting/attachdir').'./'.$cover_pic);
					$remote = 1;
				}

				if($cover_pic_attachment){
					$cover_pic = 'portal/'.$cover_pic_attachment;
				}
			}


			$thumb = $cover_pic ? 1 : 0;

			$inserts = array();
			foreach ($content_arr as $key => $value) {
				$value = trim($value);
				$inserts[] = "('$aid', '".(empty($pagetitle[$key-1]) && $content_count > 1 ? $this->cache['article_info']['title'] : $pagetitle[$key-1])."', '$value', '".($pageorder+$key)."', '".$this->cache['common']['public_time']."', '$id', '$idtype')";
			}
			DB::query("INSERT INTO ".DB::table('portal_article_content')."
				(aid, title, content, pageorder, dateline, id, idtype)
				VALUES ".implode(',', $inserts));

			DB::query('UPDATE '.DB::table('portal_article_title')." SET status = '$article_status',pic = '".$cover_pic."', thumb='$thumb', remote='$remote', contents = ".count($inserts)." WHERE aid='$aid'");
		}



	}


	function setcover_article($cover_pic_content, $attachment, $type_dir = 'portal'){
		global $_G;
		$image = new image();
		$thumbimgwidth = $_G['setting']['portalarticleimgthumbwidth'] ? $_G['setting']['portalarticleimgthumbwidth'] : 300;
		$thumbimgheight = $_G['setting']['portalarticleimgthumbheight'] ? $_G['setting']['portalarticleimgthumbheight'] : 300;
		if(empty($cover_pic_content)) return;
		$target = getglobal('setting/attachdir').'./'.$type_dir.'/'.$attachment;
		file_put_contents($target, $cover_pic_content);
		$thumb = $image->Thumb($target, '', $thumbimgwidth, $thumbimgheight, 2);
		if($thumb){
			$cover_pic = $type_dir == 'portal' ? $type_dir.'/'.$attachment : $attachment;
			return $cover_pic;
		}
		return FALSE;
	}


	function forum_set_cover($tid, $picsource){
		global $_G;
		$basedir = !$_G['setting']['attachdir'] ? (DISCUZ_ROOT.'./data/attachment/') : $_G['setting']['attachdir'];
		$coverdir = 'threadcover/'.substr(md5($tid), 0, 2).'/'.substr(md5($tid), 2, 2).'/';
		dmkdir($basedir.'./forum/'.$coverdir);
		$image = new image();
		if($_G['setting']['forumpicstyle'] && !is_array($_G['setting']['forumpicstyle'])){
			$_G['setting']['forumpicstyle'] = dunserialize($_G['setting']['forumpicstyle']);
		}
		if(!$_G['setting']['forumpicstyle']) $_G['setting']['forumpicstyle'] = $this->load_forumpicstyle();
		empty($_G['setting']['forumpicstyle']['thumbwidth']) && $_G['setting']['forumpicstyle']['thumbwidth'] = 203;
		empty($_G['setting']['forumpicstyle']['thumbheight']) && $_G['setting']['forumpicstyle']['thumbheight'] = 999;
		if($image->Thumb($picsource, 'forum/'.$coverdir.$tid.'.jpg', $_G['setting']['forumpicstyle']['thumbwidth'], $_G['setting']['forumpicstyle']['thumbheight'], 2)) {
			DB::update('forum_thread', array('cover' => 1), array('tid'=>$tid));
		}
	}


	function ftp_check_attach($ext, $filesize){
		global $_G;
		if(!$_G['setting']['ftp']['on']) return TRUE;
		if(((!$_G['setting']['ftp']['allowedexts'] && !$_G['setting']['ftp']['disallowedexts']) || ($_G['setting']['ftp']['allowedexts'] && in_array($ext, $_G['setting']['ftp']['allowedexts'])) || ($_G['setting']['ftp']['disallowedexts'] && !in_array($ext, $_G['setting']['ftp']['disallowedexts']) && (!$_G['setting']['ftp']['allowedexts'] || $_G['setting']['ftp']['allowedexts'] && in_array($ext, $_G['setting']['ftp']['allowedexts'])))) && (!$_G['setting']['ftp']['minsize'] || $filesize >= $_G['setting']['ftp']['minsize'] * 1024)) {
			return TRUE;
		}else{
			return FALSE;
		}
	}





	 function forum_attach_content($args, $is_post = 0){

		global $_G;
		extract($args);
		$tid = $this->cache['common']['tid'];
		$uid = $is_post ? $this->cache['common']['reply_public_uid'] : $this->cache['common']['public_uid'];
		$public_time = $is_post ? $this->cache['common']['reply_public_time'] : $this->cache['common']['public_time'];
		$fid = $this->cache['common']['fid'];
		$pid = $is_post ? $this->cache['common']['reply_pid'] : $this->cache['common']['pid'];

		require_once libfile('class/image');

		$attach_arr = $is_post == 0 ? $this->post_data['attach_list']['content'] : $this->post_data['attach_list']['reply'][$reply_key];


		if(!$attach_arr) return;

		$public_time = $public_time ? $public_time : $_G['timestamp'];


		pload_upload_class();
		$upload = new discuz_upload();
		$attachaids = array();
		$threadimage_flag = 0;
		$content_md5_arr = $imagereplace = array();
		$thread_image_data =  array();


		//处理a标签
		foreach($attach_arr as $key => $value){

			$imageurl = $value['url'];
			$hash = md5($imageurl);
			if(!strlen($imageurl)) continue;
			if($value['isimage'] == 1) continue;//


			$style_str = $value['style'] ? 'style="'.$value['style'].'"' : '';

			$imagereplace['oldimageurl'][$key] = $value['ref'];
			$imagereplace['newimageurl'][$key] = $this->api_info['is_htmlon'] == 1 ? '<a '.$style_str.' href="'.$imageurl.'">'.$value['text'].'</a>' : '[url='.$imageurl.']'.$value['text'].'[/url]';
			$existentimg[$hash] = $imageurl;

			$img_content = $value['content'];
			$file_ext = $value['ext'] = $upload->fileext($value['fileName']);
			$content_md5_arr[] = md5($img_content);

			$isimage = $value['isimage'];



			if(empty($img_content) || empty($file_ext)) {
				continue;
			}


			$attach_info = $this->attach_add(array('tid' => $tid, 'fid' => $fid, 'uid' => $uid, 'pid' => $pid, 'attach_img_info' => $value), $is_post);

			if(!$attach_info['aid']) continue;
			$tableid = $attach_info['tableid'];
			$attachaids[$hash] = $imagereplace['newimageurl'][$key] = '[align=center][attach]'.$attach_info['aid'].'[/attach][/align]';
			$newaids[] = $attach_info['aid'];


		}


		$content = str_replace($imagereplace['oldimageurl'], $imagereplace['newimageurl'], $content);


		$imagereplace = array();
		//处理img标签
		foreach($attach_arr as $key => $value){

			$imageurl = $value['url'];
			$hash = md5($imageurl);
			if(!strlen($imageurl)) continue;
			if($value['isimage'] == 0) continue;//

			$imagereplace['oldimageurl'][$key] = $value['ref'];
			$imagereplace['newimageurl'][$key] = $this->api_info['is_htmlon'] == 1 ? '<img src="'.$imageurl.'" >' :'[img]'.$imageurl.'[/img]';
			$existentimg[$hash] = $imageurl;

			$img_content = $value['content'];
			$file_ext = $value['ext'] = $upload->fileext($value['fileName']);
			$content_md5_arr[] = md5($img_content);

			$isimage = $value['isimage'];



			if(empty($img_content) || empty($file_ext)) {
				continue;
			}


			$attach_info = $this->attach_add(array('tid' => $tid, 'fid' => $fid, 'uid' => $uid, 'pid' => $pid, 'attach_img_info' => $value), $is_post);//Ìí¼Ó¸½¼þ
			$file_path = $attach_info['path'];
			if(!$attach_info['aid']) continue;

			if($value['isimage'] == 1) {
				$imginfo = @getimagesize($file_path);
				$width = $imginfo[0];
				if($thread_image_data['max_width'] == 0 || ($width > intval($thread_image_data['max_width']))){
					$thread_image_data['max_width'] = $width;
					$thread_image_data['aid'] = $attach_info['aid'];
					$thread_image_data['data'] = array(
						'tid' => $tid,
						'attachment' => $attach_info['attachment'],
						'remote' => getglobal('setting/ftp/on') ? 1 : 0,
					);

				}
			}

			$tableid = $attach_info['tableid'];
			$attachaids[$hash] = $imagereplace['newimageurl'][$key] = '[align=center][attach]'.$attach_info['aid'].'[/attach][/align]';
			$newaids[] = $attach_info['aid'];


		}


		if($thread_image_data['aid'] && !$is_post){
			DB::insert('forum_threadimage', $thread_image_data['data'], true);
		}
		$this->cache['upload']['newaids'][$pid] = array('uid' => $uid, 'aids' => $newaids);

		$content = str_replace($imagereplace['oldimageurl'], $imagereplace['newimageurl'], $content);



		$attachment = (count($newaids) > 0 || count($this->cache['upload']['sky_attach_arr']) > 0) ? 2 : 0;

		$setarr = array();
		require_once libfile('function/editor');
		require_once libfile('function/home');
		$setarr['attachment'] = $attachment;
		$setarr['message'] = $content;
		$is_htmlon = $this->api_info['is_htmlon'];
		$setarr['message'] = content_html_ubb($setarr['message'], $this->post_data['url'], $is_htmlon);


		$bbcodeoff = checkbbcodes($setarr['message'], FALSE);
		$setarr['bbcodeoff'] = $bbcodeoff;
		$setarr = paddslashes($setarr);
		DB::update('forum_post', $setarr, array('pid' => $pid));
		if(!$is_post || $is_post > 0 && $attachment > 0) {


			DB::update('forum_thread', array('attachment' => $attachment), array('tid' => $tid));

			//如果设置了封面，就不需要再设置
			if($this->cache['common']['is_set_cover'] == 0){

				if(getglobal('setting/ftp/on')){

					require_once libfile('function/post');
					$_G['forum']['ismoderator'] = 1;
					$_G['uid'] = $this->cache['common']['public_uid'];
					$_G['uid'] = $_G['uid'] ? $_G['uid'] : 1;
					setthreadcover($this->cache['common']['pid']);


				}else{
					$_G['forum']['ismoderator'] = 1;
					$_G['uid'] = $uid;
					$_G['uid'] = $_G['uid'] ? $_G['uid'] : 1;
					setthreadcover($this->cache['common']['pid']);
				}

			}

		}

	}


	function attach_add($args, $is_post = 0){
		extract($args);
		global $_G;
		require_once libfile('class/image');
		$img_content = $attach_img_info['content'];
		pload_upload_class();
		$upload = new discuz_upload();



		if(strlen($attach_img_info['content']) == 0) return;

		$public_time = $this->cache['common']['public_time'];
		$attach['name'] = $attach_img_info['fileName'];
		$attach['ext'] = trim($attach_img_info['ext']);
		$attach['thumb'] = '';
		$attach['isimage'] = $upload -> is_image_ext($attach['ext']);
		$attach['extension'] = $upload -> get_target_extension($attach['ext']);
		$attach['attachdir'] = $upload -> get_target_dir('forum');
		$attach['attachment'] = $attach['attachdir'] . $upload->get_target_filename('forum').'.'.$attach['extension'];
		$attach['target'] = getglobal('setting/attachdir').'./forum/'.$attach['attachment'];



		if(!@$fp = fopen($attach['target'], 'wb')) {
			return;
		} else {
			flock($fp, 2);
			fwrite($fp, $img_content);
			fclose($fp);
		}


		if(!$upload->get_image_info($attach['target']) && $attach['isimage'] == 1) {
			@unlink($attach['target']);
			return;
		}


		$attach['size'] = filesize($attach['target']);

		$remote = 0;
		if($_G['setting']['ftp']['on'] && $this->ftp_check_attach($attach['ext'], $attach['size'])){
			$result = ftpcmd('upload', 'forum/'.$attach['attachment']);
			$remote = 1;
		}


		$upload->attach = $attach;
		$thumb = $width = 0;
		if($upload->attach['isimage']) {
			if($_G['setting']['thumbstatus']) {
				$image = new image();
				$thumb = $image->Thumb($upload->attach['target'], '', $_G['setting']['thumbwidth'], $_G['setting']['thumbheight'], $_G['setting']['thumbstatus'], $_G['setting']['thumbsource']) ? 1 : 0;
				$width = $image->imginfo['width'];
			}
			if($_G['setting']['thumbsource'] || !$_G['setting']['thumbstatus']) {
				list($width) = @getimagesize($upload->attach['target']);
			}
			if(($_G['setting']['watermarkstatus'] && empty($_G['forum']['disablewatermark']))) {
				$image = new image();
				$image->Watermark($attach['target'], '', 'forum');
			}
		}


		$picid = 0;
		$setarr = array(
			'uid' => $uid,
			'tid' => $tid,
			'pid' => $pid,
			'filename' => daddslashes($upload->attach['name']),
			'attachment' => $upload->attach['attachment'],

			'filesize' => $upload->attach['size'],
			'thumb' => $thumb,
			'remote' => $remote,
			'picid' => $picid,
			'isimage' => $attach['isimage'],
			'description' => $attach_img_info['alt'] ? $attach_img_info['alt'] : $attach_img_info['text'],
			'readperm' => 0,
			'price' => 0,
			'width' => $width,
			'dateline' => $public_time,
		);


		$setimg_arr = array(
			'tid' => $tid,
			'attachment' => $upload->attach['attachment'],
			'remote' => $remote,
		);
		$set_att = array(
			'downloads' => rand(1,15),
			'tableid' => getattachtableid($tid),
			'uid' => $uid,
			'tid' => $tid,
			'pid' => $pid,
		);

		$setarr['aid'] = $newaids[] = DB::insert('forum_attachment', $set_att, true);
		$at[] = $setarr['aid'];


		$attachnew_arr[$setarr['aid']] = array('description' => $setarr['description']);
		DB::insert(getattachtablebytid($tid), paddslashes($setarr), true);
		return array('aid' => $setarr['aid'], 'path' => $attach['target'],  'url' => $_G['setting']['attachurl'].'forum/'.$attach['attachment'], 'tableid' => $set_att['tableid'], 'attachment' => $attach['attachment']);
	}



	function check_article_forum(){
		return true;//debug
	}


	function move_forums(){
		global $_G;
		require_once libfile('function/editor');
		require_once libfile('function/forum');
		require_once libfile('function/post');
		require_once libfile('function/home');

		if($this->check_article_forum() == FALSE) return FALSE;


		$old_forum_id = $this->post_data['data_id'];//旧的发布id

		$old_forum_id = '37528';

		$old_tid = '';//旧的发布id

		$subject = $this->post_data['field_data']['title'];
		$message = $this->post_data['field_data']['content'];



		$subject = getstr($subject, 80, 0, 0);


		$is_htmlon = $this->api_info['is_htmlon'];

		$message = content_html_ubb($message, $this->post_data['field_data']['url'], $is_htmlon);



		$bbcodeoff = checkbbcodes($message, FALSE);
		$smileyoff = checksmilies($message, FALSE);
		$readperm = 0;
		$displayorder = 0;
		$digest = 0;
		$moderated = 0;
		$isgroup = 0;
		$replycredit = 0;
		$isanonymous = 0;
		$parseurloff = 0;

		$view_num = $this->cache['article_info']['view_num'];
		$reply_count = count($this->post_data['field_data']['reply']);
		$view_num = $view_num < ($reply_count - 1) ? rand($reply_count*2, $reply_count*10) : $view_num;
		$fid = $this->catid;
		$_G['forum'] =  DB::fetch_first("SELECT * FROM ".DB::table('forum_forum')." WHERE fid='$fid'");
		$forum_forumfield_info = DB::fetch_first("SELECT threadsorts,moderators FROM ".DB::table('forum_forumfield')." WHERE fid='$fid'");
		$_G['forum']['threadsorts'] = dunserialize($forum_forumfield_info['threadsorts']);
		$_G['forum']['moderators'] = $forum_forumfield_info['moderators'];
		$this->cache['common']['forum'] = $_G['forum'];


		$uid = $this->cache['article_info']['public_uid'];
		$author =$this->cache['article_info']['public_username'];

		$member_info = $this->get_member_info($this->post_data['field_data']['public_username'], $this->post_data['attach_list']['public_avatar']['attach']);
		if(is_array($member_info) && $member_info['uid']){
			$uid = $member_info['uid'];
			$author = $member_info['username'];
		}else{
		}


		$public_time = $this->cache['article_info']['public_time'];



		$special = 0; //后续可能要改
		$sortid = $this->post_data['post_config']['cat_data']['ext_catid']['sortid'];//分类信息


		if($sortid && !in_array($sortid, array_keys($_G['forum']['threadsorts']['types']))){
			$this->init_error(-3);
			return FALSE;
		}

		if($special == 3){
			$price = $rewardprice = $this->api_info['reward_price'] ? $this->api_info['reward_price'] : rand(1,50);
		}

		$typeid = $this->post_data['post_config']['cat_data']['ext_catid']['typeid'];



		if($old_forum_id){
			$info = DB::fetch_first("SELECT p.pid,p.tid,t.tid,p.first,t.replies FROM ".DB::table('forum_post')." p Inner Join ".DB::table('forum_thread')." t  ON p.tid = t.tid WHERE p.first = '1' AND t.tid='".$old_forum_id."' AND t.displayorder > '-1'");
			$old_tid = $info['tid'];
		}

		$this->cache['common']['subject'] = $subject;

		if($old_tid){

			DB::query("UPDATE ".DB::table('forum_thread')." SET typeid='$typeid', author='".daddslashes($author)."', sortid='$sortid', authorid='$uid', subject='".daddslashes($subject)."', dateline='$public_time', price='$price', lastpost='$public_time', special='$special', fid='$fid', lastposter='".daddslashes($author)."', views='$view_num', attachment='0', replies ='0'  WHERE tid='".$old_tid."'", 'UNBUFFERED');
			$tid = $old_tid;
			$forum_info = DB::fetch_first("SELECT fid,posts,threads FROM ".DB::table('forum_forum')." WHERE fid='$fid'");
			$forum_info['posts'] -= $info['replies'];
			$forum_info['posts'] = max(0, $forum_info['posts']);

			$forum_info['threads'] -= 1;
			$forum_info['threads'] = max(0, $forum_info['threads']);

			DB::query("UPDATE ".DB::table('forum_forum')." SET  posts='".$forum_info['posts']."',threads='".$forum_info['threads']."' WHERE fid='".$fid."'", 'UNBUFFERED');


		}else{
			DB::query("INSERT INTO ".DB::table('forum_thread')." (fid, posttableid, readperm, price, typeid, sortid, author, authorid, subject, dateline, lastpost, lastposter, views, displayorder, digest, special, attachment, moderated, status, isgroup, replycredit, closed)
				VALUES ('".$fid."', '0', '$readperm', '$price', '$typeid', '$sortid', '".daddslashes($author)."', '$uid', '".daddslashes($subject)."', '$public_time', '$public_time', '".daddslashes($author)."', '$view_num', '$displayorder', '$digest', '$special', '0', '$moderated', '32', '$isgroup', '$replycredit', '0')");
			$tid = DB::insert_id();
			useractionlog($uid, 'tid');

		}

		$this->cache['finsh']['insert_id'] = $tid;
		DB::update('common_member_field_home', array('recentnote'=> daddslashes($subject)), array('uid'=> $uid));


		if(DISCUZ_VERSION == 'X2'){
			$tagstr = addthreadtag($this->api_info['article_tag'], $tid);
		}else{
			$class_tag = new tag();
			$tagstr = $class_tag->add_tag($this->api_info['article_tag'], $tid, 'tid');

		}

		$message = preg_replace('/\[attachimg\](\d+)\[\/attachimg\]/is', '[attach]\1[/attach]', $message);


		$post_setarr = array(
			'fid' => $fid,
			'tid' => $tid,
			'first' => '1',
			'author' => $author,
			'authorid' => $uid,
			'subject' => $subject,
			'dateline' => $public_time,
			'message' => $message,
			'useip' => $_G['clientip'],
			'invisible' => 0,
			'anonymous' => $isanonymous,
			'usesig' => 1,
			'htmlon' => $is_htmlon,
			'bbcodeoff' => $bbcodeoff,
			'smileyoff' => $smileyoff,
			'parseurloff' => $parseurloff,
			'attachment' => '0',
			'replycredit' => 0,
			'status' => 0
		);
		if(DISCUZ_VERSION != 'X2'){
			$post_setarr['position'] = 1;
		}
		$post_setarr = paddslashes($post_setarr);
		$post_setarr['tags'] = $tagstr;
		$today_time_arr = array();
		$replys = 0;
		if($info['tid']){
			$new_post_arr = DB::fetch_first("SELECT dateline FROM ".DB::table('forum_post')." WHERE tid='$tid' ORDER BY dateline ASC limit 1");
			$post_setarr['dateline'] = $post_setarr['dateline'] - 3600;
			DB::update('forum_post', $post_setarr, array('pid' => $info['pid']));
			$pid =  $info['pid'];

		}else{
			$pid = insertpost($post_setarr);
		}



		$threadimageaid = 0;
		$threadimage = array();



		if($old_forum_id){
			$tidsadd = "tid='".$old_forum_id."'";
			require_once libfile('function/delete');
			deleteattach(array($old_forum_id), 'tid');
			DB::query("UPDATE ".DB::table('forum_thread')." SET attachment='0' WHERE $tidsadd");
			updatepost(array('attachment' => '0'), $tidsadd);

			DB::delete('forum_post', "tid='".$old_forum_id."' AND pid<>'$pid'");

		}



		if(!empty($sortid)){

			loadcache(array('threadsort_option_'.$sortid));
			$sortoptionarray = $_G['cache']['threadsort_option_'.$sortid];
			foreach($sortoptionarray as $k => $v){

				$data_type = $v['type'];
				$data_id = $v['identifier'];
				$optionid = $k;

				$value =  $this->post_data['field_data'][$data_id];
				$value = trim($value);


				//图片
				if($data_type == 'image') {

					$attach_img_info = $this->post_data['attach_list'][$data_id]['attach'];
					$attach_info = strlen($attach_img_info['content']) > 0 ? $this->attach_add(array('tid' => $tid, 'fid' => $fid, 'uid' => $uid, 'pid' => $pid, 'attach_img_info' => $attach_img_info)) : array();

					if($attach_info['aid']){
						$value = st_serialize($attach_info);
					}else{

					}

				}


				//多选、选择什么的
				if($data_type == 'select' || $data_type == 'checkbox' || $data_type == 'radio') {
					$search_key = array_search($value, $v['choices']);
					if(empty($search_key)){
						foreach($v['choices'] as $k1 => $v1){
							if(strexists($value, trim($v1))){
								$value = $k1;
								break;
							}
							if(strexists(trim($v1), $value)){
								$value = $k1;
								break;
							}
						}
					}else{
						$value = $search_key;
					}

				}

				if($value) {
					$filedname .= $separator.$data_id;
					$valuelist .= $separator."'".daddslashes($value)."'";
					$separator = ' ,';
				}


				DB::query("INSERT INTO ".DB::table('forum_typeoptionvar')." (sortid, tid, fid, optionid, value, expiration)
					VALUES ('$sortid', '$tid', '$fid', '$optionid', '".daddslashes($value)."', '".($typeexpiration ? TIMESTAMP + $typeexpiration : 0)."')");



			}


			if($filedname && $valuelist) {
				DB::query("INSERT INTO ".DB::table('forum_optionvalue')."$sortid ($filedname, tid, fid) VALUES ($valuelist, '$tid', '$fid')");
			}



		}



		$param = array('fid' => $fid, 'tid' => $tid, 'pid' => $pid);

		$statarr = array(0 => 'thread', 1 => 'poll', 2 => 'trade', 3 => 'reward', 4 => 'activity', 5 => 'debate', 127 => 'thread');

		include_once libfile('function/stat');

		updatestat($isgroup ? 'groupthread' : $statarr[$special]);

		dsetcookie('clearUserdata', 'forum');


		if($specialextra) {

			$classname = 'threadplugin_'.$specialextra;
			if(class_exists($classname) && method_exists($threadpluginclass = new $classname, 'newthread_submit_end')) {
				$threadpluginclass->newthread_submit_end($fid, $tid);
			}

		}



		$feed = array(
			'icon' => '',
			'title_template' => '',
			'title_data' => array(),
			'body_template' => '',
			'body_data' => array(),
			'title_data'=>array(),
			'images'=>array()
		);

		if($_G['forum']['allowfeed'] && !$isanonymous) {
			$message = !$price ? $message : '';
			if($special == 0) {
				$feed['icon'] = 'thread';
				$feed['title_template'] = 'feed_thread_title';
				$feed['body_template'] = 'feed_thread_message';
				$feed['body_data'] = array(
					'subject' => "<a href=\"forum.php?mod=viewthread&tid=$tid\">$subject</a>",
					'message' => messagecutstr($message, 150)
				);

			}elseif($special == 3) {
				$feed['icon'] = 'reward';
				$feed['title_template'] = 'feed_thread_reward_title';
				$feed['body_template'] = 'feed_thread_reward_message';
				$feed['body_data'] = array(
					'subject'=> "<a href=\"forum.php?mod=viewthread&tid=$tid\">$subject</a>",
					'rewardprice'=> $rewardprice,
					'extcredits' => $_G['setting']['extcredits'][$_G['setting']['creditstransextra'][2]]['title'],
				);
			}
		}

		$feed['title_data']['hash_data'] = "tid{$tid}";
		$feed['id'] = $tid;
		$feed['idtype'] = 'tid';
		if($feed['icon']) {
			postfeed($feed);
		}


		if($displayorder != -4) {

			updatepostcredits('+',  $uid, 'post', $fid);

			$subject = str_replace("\t", ' ', daddslashes($subject));
			$f_lastpost = "$tid\t$subject\t".$public_time."\t".daddslashes($author);
			if($_G['forum']['type'] == 'sub') {
				DB::query("UPDATE ".DB::table('forum_forum')." SET lastpost='$f_lastpost' WHERE fid='".$_G['forum'][fup]."'", 'UNBUFFERED');
			}
		}

		$subject = str_replace("\t", ' ', daddslashes($subject));
		$replys = count($this->cache['content_arr']);
		$replys = $replys ? $replys : 1;
		$todayposts = date("Yjn", $public_time) == date("Yjn", $_G['timestamp']) ? 1 : 0;
		foreach((array)$today_time_arr as $k => $v){
			if(date("Yjn", $_G['timestamp']) == date("Yjn", $v)) $todayposts++;

		}


		DB::query("UPDATE ".DB::table('forum_forum')." SET lastpost='$f_lastpost', threads=threads+1, posts=posts+$replys, todayposts=todayposts+$todayposts WHERE fid='$fid'", 'UNBUFFERED');


		$this->cache['common']['tid'] = $tid;
		$this->cache['common']['public_uid'] = $uid;
		$this->cache['common']['public_username'] = $author;
		$this->cache['common']['public_time'] = $public_time;
		$this->cache['common']['fid'] = $fid;
		$this->cache['common']['pid'] = $pid;

		$this->cache['finsh']['url'] = $_G['siteurl'].'forum.php?mod=viewthread&tid='.$this->cache['finsh']['insert_id'];

		$this->cache['common']['is_set_cover'] = 0;

		//没有附件的情况下，设置封面
		$_G['setting']['forumpicstyle']  = $this->load_forumpicstyle();
		if($_G['setting']['forumpicstyle']) {
			$attach_img_info = $this->post_data['attach_list']['thumb']['attach'];
			if($attach_img_info ){
				$temp_avatar_dir = $_G['setting']['attachdir'].'./dxc_api/';
				dmkdir($temp_avatar_dir);
				$temp_path =  $temp_avatar_dir.$attach_img_info['fileName'];
				file_put_contents($temp_path, $attach_img_info['content']);
				$this->forum_set_cover($tid, $temp_path);
				@unlink($temp_path);
				$this->cache['common']['is_set_cover'] = 1;
			}
		}



		$this->forum_attach_content(array('content' => $this->post_data['field_data']['content']));


	}

	function load_forumpicstyle(){
		global $_G;
		$fid = $this->cache['common']['fid'];
		$forumpicstyle = DB::result_first("SELECT picstyle FROM ".DB::table('forum_forumfield')." WHERE fid='$fid'");
		if(!$forumpicstyle) return;
		loadcache('setting');
		if(DISCUZ_VERSION != 'X2.5' && DISCUZ_VERSION != 'X2'){//3.1ÒÔÉÏÓÐÆÙ²¼Á÷
			$width = 203;
			$height = 999;
		}else{
			$width = 214;
			$height = 160;
		}
		if($_G['setting']['forumpicstyle']) {
			if(!is_array($_G['setting']['forumpicstyle'])) $_G['setting']['forumpicstyle'] = dunserialize($_G['setting']['forumpicstyle']);
			empty($_G['setting']['forumpicstyle']['thumbwidth']) && $_G['setting']['forumpicstyle']['thumbwidth'] = $width;
			empty($_G['setting']['forumpicstyle']['thumbheight']) && $_G['setting']['forumpicstyle']['thumbheight'] = $height;
		} else {
			$_G['setting']['forumpicstyle'] = array('thumbwidth' => $width, 'thumbheight' => $height);
		}
		return $_G['setting']['forumpicstyle'];

	}

	function create_reply_time(){

		$time_arr = dxcsdk::create_public_time($this->post_data['post_config']['field_ext'], $this->cache['common']['public_time'], 1, count($this->post_data['field_data']['reply']), TIMESTAMP);

		$is_bbs = 1;//后续功能扩展

		if($is_bbs == 1){

			foreach($this->post_data['field_data']['reply'] as $k => $v){
				$c_info = $this->post_data['field_data']['reply'][$v];
				$time_arr[$k] = $c_info['dateline'] ? $c_info['dateline'] : $time_arr[$k];
			}

		}else{

			$first_dateline = reset($time_arr);
			$end_dateline = end($time_arr);
			$diff_time = $end_dateline - $first_dateline;
			if($diff_time > 3600*5){
				$time_arr = dxcsdk::create_public_time($this->post_data['post_config']['field_ext'], $this->cache['common']['public_time'], 1, 1, TIMESTAMP);
			}

		}

		if(empty($time_arr[0]) || $time_arr[0] == $this->cache['common']['public_time'] || $time_arr[0] < $this->cache['common']['public_time']) $time_arr[0] = $this->cache['common']['public_time'] + 60*rand(3, 10);
		$last_time = $time_arr[0];
		$count = count($time_arr);
		foreach($time_arr as $k => $v){
			if($k == 0) continue;
			$last_time = intval($time_arr[$k-1]);

			$next_time = intval($time_arr[$k+1]);
			if($v == $last_time || $v < $last_time){
				if($next_time > $v && $next_time > $last_time){
					$v = rand($v, $next_time);
				}else{
					$v = $last_time + rand(15*60, 3600*0.5);
				}
			}
			$time_arr[$k] = $v;

		}
		return $time_arr;
	}

	function create_rand_user(){
		$user_arr = array();
		if($this->is_bbs == 1){
			$user_arr = get_rand_uid(array('p_arr' => $this->api_info, 'public_uid' => $this->cache['common']['public_uid'], 'reply_num' => $this->cache['reply']['reply_num']), 'reply');
		}else{
		}
		return $user_arr;
	}

	function reply_public(){

		global $_G;

		require_once libfile('function/editor');
		require_once libfile('function/post');

		$reply_arr = $this->post_data['field_data']['reply'];

		if(count($reply_arr) == 0) return;



		$this->cache['reply']['reply_num'] = count($reply_arr);
		$this->cache['reply']['time_arr'] = $this->create_reply_time();
		$this->cache['reply']['uid_arr'] = $this->create_rand_user();
		$this->cache['reply']['now_key'] = 0;
		$this->cache['reply']['postid_arr'] = array();

		if($this->api_info['is_reply_shuffle'] == 1)  {//后续支持
			shuffle($reply_arr);//打乱之后，附件的索引也要一一对应
		}


		$is_htmlon = $this->api_info['is_htmlon'];


		foreach($reply_arr as $key => $v){

			$subject = '';
			$message = $v;
			if(!$message || strlen($message) < 2) continue;
			$reply_content = $message;
			$message = content_html_ubb($message, $this->cache['article_info']['url'], $is_htmlon);
			$bbcodeoff = checkbbcodes($message, !empty($_GET['bbcodeoff']));
			$smileyoff = checksmilies($message, !empty($_GET['smileyoff']));
			$parseurloff = 0;
			$usesig = 1;
			$isanonymous = 0;



			$dateline = $this->cache['reply']['time_arr'][$key] ? $this->cache['reply']['time_arr'][$key] : $_G['timestamp'];

			if(!empty($this->post_data['field_data']['reply_dateline'][$key])){
				$new_date = dxcsdk::strtotime($this->post_data['field_data']['reply_dateline'][$key]);
				$dateline = $new_date ? $new_date : $dateline;
			}



			//后面扩展
			if($this->cache['article_info']['best_answer_cid'] && $this->cache['article_info']['best_answer_cid'] == $v && $this->cache['article_info']['reward_price'] < 0){//ÐüÉÍÖ÷Ìâ£¬ÒÑ½â¾öÎÊÌâ
				$dateline = $this->cache['common']['public_time'] + 1;
			}

			$author = $this->cache['reply']['uid_arr'][$key]['username'] ? $this->cache['reply']['uid_arr'][$key]['username'] : $_G['username'];
			$authorid = $this->cache['reply']['uid_arr'][$key]['uid'] ? $this->cache['reply']['uid_arr'][$key]['uid'] : $_G['uid'];
			$member_info = $this->get_member_info($this->post_data['field_data']['reply_username'][$key], $this->post_data['attach_list']['reply_avatar'][$key]['attach']);

			if(is_array($member_info) && $member_info['uid']){
				$authorid = $member_info['uid'];
				$author = $member_info['username'];
			}else{
			}


			$post_setarr = array(
				'fid' => $this->cache['common']['fid'],
				'tid' => $this->cache['common']['tid'],
				'first' => '0',
				'author' => $author,
				'authorid' => $authorid,
				'subject' => $subject,
				'dateline' => $dateline,
				'message' => $message,
				'useip' => $_G['clientip'],
				'invisible' => 0,
				'anonymous' => $isanonymous,
				'usesig' => $usesig,
				'htmlon' => $is_htmlon,
				'bbcodeoff' => $bbcodeoff,
				'smileyoff' => $smileyoff,
				'parseurloff' => $parseurloff,
				'attachment' => '0',
				'tags' => 0,
				'replycredit' => 0,
				'status' => (defined('IN_MOBILE') ? 8 : 0)
			);
			$post_setarr = paddslashes($post_setarr);
			$lastpost = $post_setarr['dateline'];
			$lastposter = $post_setarr['author'];
			$reply_pid = insertpost($post_setarr);
			if($this->cache['article_info']['content_arr'][$v]['postid']){
				$this->cache['reply']['postid_arr'][$this->cache['article_info']['content_arr'][$v]['postid']] = array('author' => $post_setarr['author'], 'time' => $post_setarr['dateline'], 'pid' => $reply_pid, 'message' => $post_setarr['message']);
			}
			DB::query("UPDATE ".DB::table('common_member_count')." SET posts=posts+1 WHERE uid='$post_setarr[authorid]'");
			$this->cache['reply']['now_key']++;
			$this->cache['reply']['replyed_num']++;
			$this->cache['common']['reply_public_uid'] = $authorid;
			$this->cache['common']['reply_public_time'] = $dateline;
			$this->cache['common']['reply_pid'] = $reply_pid;
			$this->cache['common']['postid'] = $postid;
			$this->forum_attach_content(array('content' => $reply_content, 'cid' => $reply_info['cid'] , 'reply_key' => $key), 1);

		}


		if($this->cache['is_timing'] == 1 || !$lastposter || !$lastpost) return TRUE;
		$todayposts = 0;
		foreach((array)$this->cache['reply']['time_arr'] as $k => $v){
			if(date("Yjn", $_G['timestamp']) == date("Yjn", $v)) $todayposts++;

		}


		$this->reply_public_finsh(array('todayposts' => $todayposts, 'replies' => $this->cache['reply']['replyed_num'], 'lastpost' => $lastpost, 'lastposter' => $lastposter, 'tid' => $this->cache['common']['tid'], 'fid' => $this->cache['common']['fid']));


		return TRUE;
	}


	function reply_public_finsh($args){
		extract($args);
		$replies = max($replies, 0);
		DB::update('forum_thread', array('lastpost' => $lastpost, 'lastposter' => $lastposter), array('tid'=> $tid));
		DB::query('UPDATE '.DB::table('forum_thread')." SET replies=replies+$replies WHERE tid='".$tid."'");
		$subject = str_replace("\t", ' ', daddslashes($subject));
		$replys = $replies ? $replies : 1;
		$forum_lastpost = "$tid\t$subject\t$lastpost\t".daddslashes($lastposter)."";
		DB::query("UPDATE ".DB::table('forum_forum')." SET lastpost='$forum_lastpost', posts=posts+$replys, todayposts=todayposts+$todayposts WHERE fid='".$fid."'", 'UNBUFFERED');//¸üÐÂ½ñÈÕ·¢ÌûÕâÐ©Êý¾Ý
	}


	function get_member_info($username, $avatar_img){

		if(!$username) return -70;

		sload('F:member');

		$config = get_common_set();

		$info['username'] = $username;
		$info['password'] = $config['register_pwd'];

		$reg_info = DB::fetch_first("SELECT uid,username FROM ".DB::table('common_member')." WHERE username ='".$info['username']."'");


		if($reg_info['uid']) {
			$result = $this->member_set_avatar($reg_info['uid'], $avatar_img);
			return $reg_info;
		}
		$info = get_member_setarr($info);
		$reg_info = dxc_member_reg($info);
		if($reg_info['errno'] == -3){//已经被注册了
			$reg_info = DB::fetch_first("SELECT uid,username FROM ".DB::table('common_member')." WHERE username ='".$info['username']."'");
			if($reg_info['uid']) {
				$result = $this->member_set_avatar($reg_info['uid'], $avatar_img);
				return $reg_info;
			}
		}
		if($reg_info['errno']) {
			return $reg_info['errno'];
		}
		if($reg_info['uid']) {
			$result = $this->member_set_avatar($reg_info['uid'], $avatar_img);
		}
		return $reg_info;
	}


	function member_set_avatar($uid, $avatar_data){
		global $_G;
		if(empty($avatar_data)) return -4;

		$size_arr = array('big', 'middle', 'small');
		$create_re = create_avatar_dir($uid ,'');
		if(!$create_re) {
			return -1;
		}


		$avatar_dir_save  = get_avatar_path($uid, 'big');
		if(file_exists($avatar_dir_save)) return -5;


		require_once libfile('class/image');
		$image = new image();

		$root_path =  $_G['setting']['attachdir'];
		$ext = $avatar_data['ext'];

		$temp_avatar_dir = $root_path.'/dxc_api/';

		dmkdir($temp_avatar_dir);

		$temp_avatar_path = $temp_avatar_dir.$uid.'temp.'.$ext;
		$img_re = $avatar_data['content'];
		$put_re = file_put_contents($temp_avatar_path, $img_re);


		if(!$put_re) {
			return -2;
		}



		//根据大图，生成更小的图
		$avatar_dir_save = get_avatar_path($uid, 'big');
		$avatar_temp_file = './dxc_api/'.$uid.'big.'.$ext;
		$avatar_path = $root_path.$avatar_temp_file;
		$result = $image->Thumb($temp_avatar_path, $avatar_temp_file, 200, 250, 1);
		if(file_exists($avatar_path)) {
			$re = file_put_contents($avatar_dir_save, file_get_contents($avatar_path));
			@unlink($avatar_path);
		}


		//根据大图，生成更小的图
		$avatar_dir_save = get_avatar_path($uid, 'middle');
		$avatar_temp_file = './dxc_api/'.$uid.'middle.'.$ext;
		$avatar_path = $root_path.$avatar_temp_file;
		$result = $image->Thumb($temp_avatar_path, $avatar_temp_file, 120, 120, 1);
		if(file_exists($avatar_path)) {
			$re = file_put_contents($avatar_dir_save, file_get_contents($avatar_path));
			@unlink($avatar_path);
		}



		//根据大图，生成更小的图
		$avatar_dir_save = get_avatar_path($uid, 'small');
		$avatar_temp_file = './dxc_api/'.$uid.'small.'.$ext;
		$avatar_path = $root_path.$avatar_temp_file;
		$result = $image->Thumb($temp_avatar_path, $avatar_temp_file, 48, 48, 2);
		if(file_exists($avatar_path)) {
			file_put_contents($avatar_dir_save, file_get_contents($avatar_path));
			@unlink($avatar_path);
		}

		@unlink($temp_avatar_path);

		return 1;

	}



    function get_article_user_info(){

		global $_G;
        $rand_arr = get_rand_uid(array('p_arr' => array('public_uid_type' => 2, 'public_uid' => $this->api_info['public_uid'])));
		$_G['uid'] = $_G['uid'] ? $_G['uid'] : 1;
		$_G['username'] = $_G['username'] ? $_G['username'] : 'admin';
        $data['uid']  = $rand_arr[0]['uid'] ? $rand_arr[0]['uid'] : $_G['uid'];
        $data['username'] = $rand_arr[0]['username'] ? $rand_arr[0]['username'] : $_G['username'];

        return $data;
    }


	function get_article_dateline(){
		if($this->api_info['public_time_type'] == 0 && !empty($this->post_data['field_data']['public_dateline'])) return $this->post_data['field_data']['public_dateline'];
		$public_time = dxcsdk::create_public_time($this->post_data['post_config']['field_ext']['public_time'], 0, 1, 0, TIMESTAMP);
		//var_dump(date('Y-m-d H:i:s', $public_time));exit();
		$public_time = !empty($public_time) ? $public_time : TIMESTAMP;
		return $public_time;
	}





}

?>