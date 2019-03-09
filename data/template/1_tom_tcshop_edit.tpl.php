<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<!DOCTYPE html><html>
<head>
<?php if($isGbk) { ?>
<meta http-equiv="Content-Type" content="text/html; charset=GBK">
<?php } else { ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php } ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="format-detection" content="telephone=no" />
<title>完善店铺资料 - <?php echo $__SitesInfo['name'];?></title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tcshop/images/iconfont/iconfont.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tcshop/images/shop_style.css?v=<?php echo $cssJsVersion;?>" />
<script src="source/plugin/tom_tcshop/images/jquery.min-2.1.3.js" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?><style>
.tcui-actionsheet__cell:before{border:0}
.tcui-actionsheet__cell{border-bottom:1px solid #EFEFF4;padding:20px 0}
.edit-form ul li{line-height: initial;}
.edit-form ul li .paixu{font-size: 0.7em;height: 30px;line-height: 30px;}
.edit-form ul li .paixu input{width: 30px;text-align: center;border: 1px solid #efefef;}
</style>
<script>
var tomBrowser = {
    versions: function () {
        var u = navigator.userAgent, app = navigator.appVersion;
        return { /*�ƶ��ն�������汾��Ϣ*/
            trident: u.indexOf('Trident') > -1, /*IE�ں�*/
            presto: u.indexOf('Presto') > -1, /*opera�ں�*/
            webKit: u.indexOf('AppleWebKit') > -1, /*ƻ�����ȸ��ں�*/
            gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, /*����ں�*/
            mobile: !!u.match(/AppleWebKit.*Mobile.*/) || !!u.match(/AppleWebKit/), /*�Ƿ�Ϊ�ƶ��ն�*/
            ios: !!u.match(/i[^;]+;( U;)? CPU.+Mac OS X/), /*ios�ն�*/
            android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, /*android�ն˻���uc�����*/
            iPhone: u.indexOf('iPhone') > -1 || (u.indexOf('Mac') > -1 && u.indexOf('Macintosh') < 0), /*�Ƿ�ΪiPhone����QQHD�����*/
            iPad: u.indexOf('iPad') > -1, /*�Ƿ�iPad*/
            webApp: u.indexOf('Safari') == -1, /*�Ƿ�webӦ�ó���û��ͷ����ײ�*/
            WindowsWechat: u.indexOf('WindowsWechat') > 0 /*�Ƿ�webӦ�ó���û��ͷ����ײ�*/
        };
    }(),
    language: (navigator.browserLanguage || navigator.language).toLowerCase()
}
</script>
</head>
<body>
<header class="header header-index on in2 tc-template__bg">
   <section class="wrap">
        <?php if($__HideHeader == 0 ) { ?>
        <?php if($_GET['fromlist'] == 'mylist' ) { ?>
        <a href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=mylist"><section class="sec-ico go-back">返回</section></a>
        <?php } elseif($_GET['fromlist'] == 'managerList') { ?>
        <a href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=managerList"><section class="sec-ico go-back">返回</section></a>
        <?php } else { ?>
        <section class="sec-ico go-back" onclick="history.back();">返回</section>
        <?php } ?>
        <?php } ?>
        <h2>完善店铺资料</h2>
   </section>
</header>
<form class="mainer" name="saveForm" id="saveForm" >
   <section class="wrap edit-form">
        <section class="edit-item">
            <section class="input-control">
                 <span>店铺名称</span>
                 <section class="user-fav">
                      <section class="sec-input">
                           <input type="text" id="name" name="name" value="<?php echo $tcshopInfo['name'];?>"  />
                      </section>
                      <div class="frt"></div>
                 </section>
            </section>
             <section class="input-control ">
                  <span>店铺分类</span>
                  <section class="user-fav">
                       <section class="sec-input">
                           <div id="choseCate"><font color="#8e8e8e"><?php echo $cateInfo['name'];?> <?php echo $cateChildInfo['name'];?></font></div>
                           <input type="hidden" name="cate_id" id="cate_id" value="<?php echo $tcshopInfo['cate_id'];?>">
                           <input type="hidden" name="cate_child_id" id="cate_child_id" value="<?php echo $tcshopInfo['cate_child_id'];?>">
                       </section>
                       <div class="frt">
                            <div class="right-arrow"></div>
                       </div>
                  </section>
             </section>
            <?php if($tcshopConfig['open_ruzhu_area'] == 1  ) { ?>
            <section class="input-control " >
                 <span>店铺区域</span>
                 <section class="user-fav">
                      <section class="sec-input">
                           <div id="choseCity"><?php if($areaName  ) { ?><?php echo $areaName;?> <?php echo $streetName;?><?php } else { ?><font color="#8e8e8e">选择区域</font><?php } ?></div>
                           <input type="hidden" name="area_id" id="area_id" value="<?php echo $tcshopInfo['area_id'];?>">
                           <input type="hidden" name="street_id" id="street_id" value="<?php echo $tcshopInfo['street_id'];?>">
                      </section>
                      <div class="frt"><div class="right-arrow"></div></div>
                 </section>
            </section>
            <?php } ?>
            <section class="input-control ">
                 <span>详细地址</span>
                 <section class="user-fav">
                      <section class="sec-input">
                           <input type="text" id="address" name="address" value="<?php echo $tcshopInfo['address'];?>"  />
                           <input type="hidden" name="lng" id="hidlng" value="<?php echo $tcshopInfo['longitude'];?>" />
                           <input type="hidden" name="lat" id="hidlat" value="<?php echo $tcshopInfo['latitude'];?>" />
                      </section>
                     <div id="showActionSheet" class="frt"><i class="tciconfont tcicon-dingwei tc-template__color"  style="color: #F60;"></i><i id="locationtext" class="tc-template__color" style="color: #F60;">定位</i></div>
                 </section>
            </section>
            <section class="input-control ">
                 <span>营业时间</span>
                 <section class="user-fav">
                      <section class="sec-input">
                           <input type="text" id="business_hours" name="business_hours" value="<?php echo $tcshopInfo['business_hours'];?>" placeholder="请输入，如：9:00-24:00"/>
                      </section>
                      <div class="frt"></div>
                 </section>
            </section>
            <section class="input-control ">
                 <span>联系电话</span>
                 <section class="user-fav">
                      <section class="sec-input">
                           <input type="text" id="tel" name="tel" value="<?php echo $tcshopInfo['tel'];?>"  />
                      </section>
                      <div class="frt"></div>
                 </section>
            </section>
            <?php if($tcshopConfig['open_must_shopkeeper_tel'] == 1) { ?>
            <section class="input-control ">
                 <span>店主手机</span>
                 <section class="user-fav">
                      <section class="sec-input">
                           <input type="text" id="shopkeeper_tel" name="shopkeeper_tel" placeholder="不公开，仅平台联系使用" value="<?php echo $tcshopInfo['shopkeeper_tel'];?>"  />
                      </section>
                      <div class="frt"></div>
                 </section>
            </section>
            <?php } ?>
            <section class="input-control">
                 <span>店铺标签</span>
                 <section class="user-fav">
                      <section class="sec-input">
                           <input type="text" id="tabs" name="tabs" value="<?php echo $tcshopInfo['tabs'];?>" placeholder="多个标签，空格隔开" />
                      </section>
                      <div class="frt"></div>
                 </section>
            </section>
            <section class="input-control ">
                  <span>店铺介绍</span>
                  <section class="user-fav">
                       <section class="sec-input">
                           <?php if($tcshopInfo['admin_edit'] == 0) { ?>
                           <a style="width: 100%;height: 100%;display: block;" onClick="save('admin_edit');" href="javascript:;">点击修改店铺介绍</a>
                           <?php } else { ?>
                           <a style="width: 100%;height: 100%;display: block;" onClick="save('admin_edit');" href="javascript:;"><font color="#fd0d0d">内容已经后台排版，修改会丢失排版</font></a>
                           <?php } ?>
                       </section>
                       <div class="frt">
                            <div class="right-arrow"></div>
                       </div>
                  </section>
             </section>
            <?php if($__IsWeixin == 1 && $tongchengConfig['open_many_pic_upload'] == 1) { ?>
            <section class="input-control ">
                <div style="line-height: 3em;">店铺头像<font color="#8e8e8e">尺寸（200x200px）</font></div>
                 <ul>
                      <li>
                           <section class="img pic-upload-btn">
                                <div id="filedata1" class="post-upload-fileprew"></div>
                               <img src="source/plugin/tom_tongcheng/images/img7.png" />
                           </section>
                      </li>
                      <div id="picurl">
                          <?php if($tcshopInfo['picurl']) { ?>
                          <li><section class="img"><img src="<?php echo $picurl;?>" /><input type="hidden" name="picurl" value="<?php echo $tcshopInfo['picurl'];?>"/></section></li>
                          <?php } ?>
                      </div>
                 </ul>
            </section>
            <section class="input-control ">
                <div style="line-height: 2em;margin-top: 0.5em;">店铺相册<font color="#8e8e8e">（最多10 张）</font></div>
                <div style="line-height: 1em;margin-bottom: 0.5em;"><font class="tc-template__color" color="#f5833b;">店铺顶部幻灯片可在“我的店铺”列表单独上传</font></div>
                  <ul>
                      <div id="photolist">
                           <?php if(is_array($tcshopPhotoList)) foreach($tcshopPhotoList as $key => $val) { ?>                          <li class="li_<?php echo $val['li_i'];?>">
                              <section class="img">
                                  <img src="<?php echo $val['src'];?>" />
                                  <input type="hidden" name="photo_<?php echo $val['li_i'];?>" value="<?php echo $val['picurl'];?>"/>
                                  <input type="hidden" name="photothumb_<?php echo $val['li_i'];?>" value="<?php echo $val['thumb'];?>"/>
                              </section>
                              <div class="paixu">排序<input class="tcui-input" type="text" id="photosort_<?php echo $val['li_i'];?>" name="photosort_<?php echo $val['li_i'];?>" value="<?php echo $val['paixu'];?>"/></div>
                              <div class=" close pic-delete-btn pointer" onclick="picremove(<?php echo $val['li_i'];?>);">&nbsp;X&nbsp;</div>
                          </li>
                          <?php } ?>
                      </div>
                       <li>
                            <section class="img pic-upload-btn">
                                <div id="filedata2" class="post-upload-fileprew"></div>
                                <img src="source/plugin/tom_tongcheng/images/img7.png" />
                            </section>
                       </li>
                  </ul>
             </section>
            <section class="input-control ">
                 <div style="line-height: 3em;">商家微信<font color="#8e8e8e">（上传商家微信二维码）</font></div>
                  <ul>
                       <li>
                            <section class="img pic-upload-btn">
                                <div id="filedata3" class="post-upload-fileprew"></div>
                                <img src="source/plugin/tom_tongcheng/images/img7.png" />
                            </section>
                       </li>
                       <div id="kefu_qrcode">
                           <?php if($tcshopInfo['kefu_qrcode']) { ?>
                           <li><section class="img"><img src="<?php echo $kefu_qrcode;?>" /><input type="hidden" name="kefu_qrcode" value="<?php echo $tcshopInfo['kefu_qrcode'];?>"/></section></li>
                           <?php } ?>
                       </div>
                  </ul>
             </section>
            <?php if($tcshopConfig['open_must_business_licence'] == 1) { ?>
            <section class="input-control ">
                 <div style="line-height: 3em;">营业执照<font color="#8e8e8e">（上传商家营业执照）</font></div>
                  <ul>
                       <li>
                            <section class="img pic-upload-btn">
                                <?php if($notEditBusinessLicence == 1) { ?>
                                <img src="source/plugin/tom_tongcheng/images/img7.png" onClick="tusi('不允许修改营业执照');" />
                                <?php } else { ?>
                                <div id="filedata4" class="post-upload-fileprew"></div>
                                <img src="source/plugin/tom_tongcheng/images/img7.png" />
                                <?php } ?>
                            </section>
                       </li>
                       <div id="business_licence">
                           <?php if($tcshopInfo['business_licence']) { ?>
                           <li><section class="img"><img src="<?php echo $business_licence;?>" /><input type="hidden" name="business_licence" value="<?php echo $tcshopInfo['business_licence'];?>"/></section></li>
                           <?php } ?>
                       </div>
                  </ul>
             </section>
            <?php } ?>
            <?php if($cateInfo['open_upload_proof'] == 1 || $proofCount > 0) { ?>
            <section class="input-control input-prooflist" >
                <div style="line-height: 2em;margin-top: 0.5em;">其它证件<font color="#8e8e8e"></font></div>
                <?php if($cateInfo['open_upload_proof'] == 1) { ?><div style="line-height: 1em;margin-bottom: 0.5em;" class="input-prooflist__text"><font color="#f5833b;">(<?php echo $cateInfo['upload_proof_text'];?>)</font></div><?php } ?>
                <ul>
                    <div id="prooflist">
                        <?php if($proofCount > 0) { ?>
                        <?php if(is_array($proofList)) foreach($proofList as $key => $value) { ?>                        <li class="li"><section class="img"><img src="<?php echo $value['src'];?>" /><input type="hidden" name="proof[]" value="<?php echo $value['picurl'];?>"/></section><?php if($notEditProof == 0) { ?><div class=" close pic-delete-btn pointer" onclick="proofremove(this);">&nbsp;X&nbsp;</div><?php } ?></li>
                        <?php } ?>
                        <?php } ?>
                    </div>
                     <li>
                          <section class="img pic-upload-btn">
                              <?php if($notEditProof == 1) { ?>
                              <img src="source/plugin/tom_tongcheng/images/img7.png"  onClick="tusi('不允许修改证件');" />
                              <?php } else { ?>
                              <div id="filedata5" class="post-upload-fileprew"></div>
                              <img src="source/plugin/tom_tongcheng/images/img7.png" />
                              <?php } ?>
                          </section>
                     </li>
                </ul>
            </section>
            <?php } ?>
            <?php } else { ?>
            <section class="input-control ">
                 <div style="line-height: 3em;">店铺头像<font color="#8e8e8e">尺寸（200x200px）</font></div>
                  <ul>
                       <li>
                            <section class="img pic-upload-btn">
                                <input type="file" name="filedata1" id="filedata1" class="post-upload-fileprew"  />
                                <img src="source/plugin/tom_tongcheng/images/img7.png" />
                            </section>
                       </li>
                       <div id="picurl">
                           <?php if($tcshopInfo['picurl']) { ?>
                           <li><section class="img"><img src="<?php echo $picurl;?>" /><input type="hidden" name="picurl" value="<?php echo $tcshopInfo['picurl'];?>"/></section></li>
                           <?php } ?>
                       </div>
                  </ul>
             </section>
            <section class="input-control ">
                <div style="line-height: 2em;margin-top: 0.5em;">店铺相册<font color="#8e8e8e">（最多10 张）</font></div>
                <div style="line-height: 1em;margin-bottom: 0.5em;"><font class="tc-template__color" color="#f5833b;">店铺顶部幻灯片可在“我的店铺”列表单独上传</font></div>
                  <ul>
                      <div id="photolist">
                           <?php if(is_array($tcshopPhotoList)) foreach($tcshopPhotoList as $key => $val) { ?>                          <li class="li_<?php echo $val['li_i'];?>">
                              <section class="img">
                                  <img src="<?php echo $val['src'];?>" />
                                  <input type="hidden" name="photo_<?php echo $val['li_i'];?>" value="<?php echo $val['picurl'];?>"/>
                                  <input type="hidden" name="photothumb_<?php echo $val['li_i'];?>" value="<?php echo $val['thumb'];?>"/>
                              </section>
                              <div class="paixu">排序<input class="tcui-input" type="text" id="photosort_<?php echo $val['li_i'];?>" name="photosort_<?php echo $val['li_i'];?>" value="<?php echo $val['paixu'];?>"/></div>
                              <div class=" close pic-delete-btn pointer" onclick="picremove(<?php echo $val['li_i'];?>);">&nbsp;X&nbsp;</div>
                          </li>
                          <?php } ?>
                      </div>
                       <li>
                            <section class="img pic-upload-btn">
                                <input type="file" name="filedata2" id="filedata2" class="post-upload-fileprew"/>
                                <img src="source/plugin/tom_tongcheng/images/img7.png" />
                            </section>
                       </li>
                  </ul>
             </section>
            <section class="input-control ">
                 <div style="line-height: 3em;">商家微信<font color="#8e8e8e">（上传商家微信二维码）</font></div>
                  <ul>
                       <li>
                            <section class="img pic-upload-btn">
                                <input type="file" name="filedata3" id="filedata3" class="post-upload-fileprew"  />
                                <img src="source/plugin/tom_tongcheng/images/img7.png" />
                            </section>
                       </li>
                       <div id="kefu_qrcode">
                           <?php if($tcshopInfo['kefu_qrcode']) { ?>
                           <li><section class="img"><img src="<?php echo $kefu_qrcode;?>" /><input type="hidden" name="kefu_qrcode" value="<?php echo $tcshopInfo['kefu_qrcode'];?>"/></section></li>
                           <?php } ?>
                       </div>
                  </ul>
             </section>
            <?php if($tcshopConfig['open_must_business_licence'] == 1) { ?>
            <section class="input-control ">
                 <div style="line-height: 3em;">营业执照<font color="#8e8e8e">（上传商家营业执照）</font></div>
                  <ul>
                       <li>
                            <section class="img pic-upload-btn">
                                <?php if($notEditBusinessLicence == 1) { ?>
                                <img src="source/plugin/tom_tongcheng/images/img7.png" onClick="tusi('不允许修改营业执照');" />
                                <?php } else { ?>
                                <input type="file" name="filedata4" id="filedata4" class="post-upload-fileprew"  />
                                <img src="source/plugin/tom_tongcheng/images/img7.png" />
                                <?php } ?>
                            </section>
                       </li>
                       <div id="business_licence">
                           <?php if($tcshopInfo['business_licence']) { ?>
                           <li><section class="img"><img src="<?php echo $business_licence;?>" /><input type="hidden" name="business_licence" value="<?php echo $tcshopInfo['business_licence'];?>"/></section></li>
                           <?php } ?>
                       </div>
                  </ul>
             </section>
            <?php } ?>
            <?php if($cateInfo['open_upload_proof'] == 1 || $proofCount > 0) { ?>
            <section class="input-control input-prooflist" >
                <div style="line-height: 2em;margin-top: 0.5em;">其它证件<font color="#8e8e8e"></font></div>
                <?php if($cateInfo['open_upload_proof'] == 1) { ?><div style="line-height: 1em;margin-bottom: 0.5em;" class="input-prooflist__text"><font color="#f5833b;">(<?php echo $cateInfo['upload_proof_text'];?>)</font></div><?php } ?>
                  <ul>
                      <div id="prooflist">
                        <?php if($proofCount > 0) { ?>
                        <?php if(is_array($proofList)) foreach($proofList as $key => $value) { ?>                        <li class="li"><section class="img"><img src="<?php echo $value['src'];?>" /><input type="hidden" name="proof[]" value="<?php echo $value['picurl'];?>"/></section><?php if($notEditProof == 0) { ?><div class=" close pic-delete-btn pointer" onclick="proofremove(this);">&nbsp;X&nbsp;</div><?php } ?></li>
                        <?php } ?>
                        <?php } ?>
                      </div>
                       <li>
                            <section class="img pic-upload-btn">
                                <?php if($notEditProof == 1) { ?>
                                <img src="source/plugin/tom_tongcheng/images/img7.png"  onClick="tusi('不允许修改证件');" />
                                <?php } else { ?>
                                <input type="file" name="filedata5" id="filedata5" class="post-upload-fileprew"/>
                                <img src="source/plugin/tom_tongcheng/images/img7.png" />
                                <?php } ?>
                            </section>
                       </li>
                  </ul>
            </section>
            <?php } ?>
            <?php } ?>
            <?php if($tcshopInfo['vip_level'] == 1) { ?>
            <section class="input-control ">
                 <span>视频</span>
                 <section class="user-fav">
                      <section class="sec-input">
                           <input type="text" id="video_url" name="video_url" placeholder="请输入腾讯、优酷视频地址" value="<?php echo $tcshopInfo['video_url'];?>"  />
                      </section>
                      <div class="frt"></div>
                 </section>
            </section>
            <section class="input-control ">
                 <span>全景</span>
                 <section class="user-fav">
                      <section class="sec-input">
                           <input type="text" id="vr_url" name="vr_url" placeholder="请输入VR地址" value="<?php echo $tcshopInfo['vr_url'];?>"  />
                      </section>
                      <div class="frt"></div>
                 </section>
            </section>
            <section class="input-control ">
                 <span>背景音乐</span>
                 <section class="user-fav">
                      <section class="sec-input">
                           <input type="text" id="mp3_url" name="mp3_url" placeholder="请输入MP3地址" value="<?php echo $tcshopInfo['mp3_url'];?>"  />
                      </section>
                      <div class="frt"></div>
                 </section>
            </section>
            <section class="input-control ">
                 <span>宣传语</span>
                 <section class="user-fav">
                      <section class="sec-input">
                           <input type="text" id="zan_txt" name="zan_txt" placeholder="请输入特色宣传语，限10个字" value="<?php echo $tcshopInfo['zan_txt'];?>"  />
                      </section>
                      <div class="frt"></div>
                 </section>
            </section>
            <section class="input-control clear bb0">
                  <div style="line-height: 3em;">店铺公告</div>
                  <section class="textarea">
                       <section class="sec-input">
                            <textarea id="gonggao" name="gonggao" placeholder="请输入店铺公告" maxlength="1000"><?php echo $tcshopInfo['gonggao'];?></textarea>
                       </section>
                  </section>
             </section>
            <?php } ?>
        </section>
   </section>
   <section class="btn-group-block">
        <button type="button" id="id_save_btn" onClick="save('save');" class="id_save_btn tc-template__bg">修改信息</button>
        <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
        <input type="hidden" name="tcshop_id" value="<?php echo $tcshop_id;?>">
        <input type="hidden" id="type" name="type" value="">
        <div class="clear10"></div>
        <div class="clear10"></div>
        <div class="clear10"></div>
   </section>
</form>
<div id="baidumap" style="position: fixed;bottom: 0px; height:100%; width:100%;z-index:9999;display:none">
    <iframe style="border:0px;width:100%;height:100%"></iframe>
</div>
<div class="tcui-actionsheet" id="actionSheet_wrap">
    <header class="header on in2 tc-template__bg">
        <section class="wrap"><h2>选择位置</h2></section>
    </header>
    <div class="tcui-actionsheet__menu">
        <a class="tcui-actionsheet__cell" href="javascript:void(0);" id="mylocation">我当前位置</a>
        <a class="tcui-actionsheet__cell" href="javascript:void(0);" id="maplocation">地图上选点</a>
    </div>
    <div class="clear"></div>
    <div class="tcui-actionsheet__action">
        <div class="tcui-actionsheet__cell" id="actionsheet_cancel">取消</div>
    </div>
</div>
<script>var cate = eval(decodeURIComponent('<?php echo $cateData;?>'));var selectedIndex_Cate = [0, 0];</script>
<script>var city = eval(decodeURIComponent('<?php echo $cityData;?>'));var selectedIndex_City = [0, 0];</script>
<?php if($isGbk) { ?>
<script src="source/plugin/tom_tcshop/images/picker/picker.min.gbk.js" type="text/javascript"></script>
<script src="source/plugin/tom_tcshop/images/picker/picker.city.gbk.js" type="text/javascript"></script>
<script src="source/plugin/tom_tcshop/images/picker/picker.cate.gbk.js" type="text/javascript"></script>
<?php } else { ?>
<script src="source/plugin/tom_tcshop/images/picker/picker.min.utf8.js" type="text/javascript"></script>
<script src="source/plugin/tom_tcshop/images/picker/picker.city.utf8.js" type="text/javascript"></script>
<script src="source/plugin/tom_tcshop/images/picker/picker.cate.utf8.js" type="text/javascript"></script>
<?php } ?>
<script src="//api.map.baidu.com/api?v=2.0&ak=<?php echo $tcshopConfig['baidu_js_ak'];?>" type="text/javascript"></script>
<script src="//res.wx.qq.com/open/js/jweixin-1.3.2.js" type="text/javascript" type="text/javascript"></script>
<script>
$(document).ready(function(){
   $.get("<?php echo $ajaxCommonClicksUrl;?>");
});

wx.config({
    debug: false,
    appId: '<?php echo $wxJssdkConfig["appId"];?>',
    timestamp: <?php echo $wxJssdkConfig["timestamp"];?>,
    nonceStr: '<?php echo $wxJssdkConfig["nonceStr"];?>',
    signature: '<?php echo $wxJssdkConfig["signature"];?>',
    jsApiList: [
      'onMenuShareTimeline',
      'onMenuShareAppMessage',
      'previewImage',
      'openLocation', 
      'getLocation',
      'previewImage',
      'chooseImage',
      'uploadImage',
      'downloadImage'
    ]
});
wx.ready(function () {
    wx.onMenuShareTimeline({
        title: '<?php echo $shareTitle;?>',
        link: '<?php echo $shareUrl;?>', 
        imgUrl: '<?php echo $shareLogo;?>', 
        success: function () { 
        },
        cancel: function () {
        }
    });
    wx.onMenuShareAppMessage({
        title: '<?php echo $shareTitle;?>',
        desc: '<?php echo $shareDesc;?>',
        link: '<?php echo $shareUrl;?>',
        imgUrl: '<?php echo $shareLogo;?>',
        type: 'link',
        dataUrl: '',
        success: function () { 
        },
        cancel: function () { 
        }
    });
});
</script>
<script>
var li_i = <?php echo $photoCount;?>;
li_i++;
var count = 0;

<?php if($tcshopInfo['picurl']) { ?>
var picurl_count = 1;
<?php } else { ?>
var picurl_count = 0;
<?php } ?>
    
var photo_count = <?php echo $photoCount;?>;

<?php if($tcshopInfo['kefu_qrcode']) { ?>
var qrcode_count = 1;
<?php } else { ?>
var qrcode_count = 0;
<?php } ?>
    
<?php if($tcshopInfo['business_licence']) { ?>
var business_licence_count = 1;
<?php } else { ?>
var business_licence_count = 0;
<?php } if($proofCount > 0) { ?>
var proof_count = "<?php echo $proofCount;?>";
proof_count = proof_count * 1;
<?php } else { ?>
var proof_count = 0;
<?php } ?>

var submintPayStatus = 0;
function save(type){
    $('#type').val(type);
    if(type == 'save'){
        var business_hours      = $("#business_hours").val();
        if(business_hours == ""){
            tusi("必须输入营业时间");
            return false;
        }
        
        <?php if($tcshopConfig['open_must_shopkeeper_tel'] == 1) { ?>
        var shopkeeper_tel      = $("#shopkeeper_tel").val();

        if(shopkeeper_tel == "" || !checkMobile(shopkeeper_tel)){
            tusi("必须输入店主手机");
            return false;
        }
        <?php } ?>

        if(picurl_count == 0){
            tusi("必须上传店铺头像");
            return false;
        }

        if(photo_count == 0){
            tusi("至少上传一张相册");
            return false;
        }

        if(qrcode_count == 0){
            tusi("必须上传商家微信二维码");
            return false;
        }

        <?php if($tcshopConfig['open_must_business_licence'] == 1) { ?>
        if(business_licence_count == 0){
            tusi("必须上传营业执照");
            return false;
        }
        <?php } ?>
    }
    if(submintPayStatus == 1){
        return false;
    }
    
    loading('处理中...');
    submintPayStatus = 1;
    $.ajax({
        type: "POST",
        url: "<?php echo $saveUrl;?>",
        dataType : "json",
        data: $('#saveForm').serialize(),
        success: function(data){
            loading(false);
            if(data.status == 200) {
                submintPayStatus = 0;
                <?php if($tongchengConfig['open_yun'] == 2) { ?>
                $.get("<?php echo $ossBatchUrl;?>");
                <?php } elseif($tongchengConfig['open_yun'] == 3) { ?>
                $.get("<?php echo $qiniuBatchUrl;?>");
                <?php } ?>
            
                if(type == 'save'){
                    tusi("修改成功");
                    <?php if($_GET['fromlist'] == 'mylist' ) { ?>
                    setTimeout(function(){window.location.href='plugin.php?id=tom_tcshop&site=<?php echo $site_id;?>&mod=mylist';},1888);
                    <?php } elseif($_GET['fromlist'] == 'managerList') { ?>
                    setTimeout(function(){window.location.href='plugin.php?id=tom_tcshop&site=<?php echo $site_id;?>&mod=managerList';},1888);
                    <?php } ?>
                }else if(type == 'admin_edit'){
                    window.location.href='plugin.php?id=tom_tcshop&site=<?php echo $site_id;?>&mod=editContent&tcshop_id=<?php echo $tcshop_id;?>&fromlist=<?php echo $_GET["fromlist"];?>';
                }
            }else{
                tusi("修改出错");
                //setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }
        }
    });
}

function checkMobile(s){
var regu =/^[1][3|8|4|5|7|9][0-9]{9}$/;
var re = new RegExp(regu);
if (re.test(s)) {
return true;
}else{
return false;
}
}
</script><?php include template('tom_tcshop:upload'); if($__IsWeixin == 1) { ?>
    <?php if($tongchengConfig['open_many_pic_upload'] == 1) { ?>
    <?php include template('tom_tcshop:wx_upload'); ?>    <?php } ?>
    <?php if($tcshopConfig['open_tx_map_location'] == 1) { ?>
    <?php include template('tom_tcshop:tx_map'); ?>    <?php } else { ?>
    <?php include template('tom_tcshop:wx_map'); ?>    <?php } } else { include template('tom_tcshop:baidu_map'); } ?>
</body>
</html>