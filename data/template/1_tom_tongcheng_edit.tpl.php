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
<title>修改信息 - <?php echo $__SitesInfo['name'];?></title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/mobiscroll/mobiscroll.css" />
<script src="source/plugin/tom_tongcheng/images/jquery-1.8.3.min.js" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script>
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
</script><?php include template('tom_tongcheng:template_css'); ?><style>
.tcui-actionsheet__cell:before{border:0}
.tcui-actionsheet__cell{border-bottom:1px solid #EFEFF4;padding:20px 0}
</style>
</head>
<body>
<header class="header header-index on in2 tc-template__bg">
   <section class="wrap">
        <?php if($__HideHeader == 0 ) { ?>
        <?php if($_GET['fromlist'] == 'mylist' ) { ?>
        <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=mylist"><section class="sec-ico go-back">返回</section></a>
        <?php } elseif($_GET['fromlist'] == 'managerList') { ?>
        <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=managerList"><section class="sec-ico go-back">返回</section></a>
        <?php } else { ?>
        <section class="sec-ico go-back" onclick="history.back();">返回</section>
        <?php } ?>
        <?php } ?>
        <h2>修改信息</h2>
        <section class="sec-ico btn slide-btn">
            <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=article">发布须知</a>
        </section>
   </section>
</header>
<form class="mainer" name="saveForm" id="saveForm" >
   <section class="wrap edit-form">
        <?php if($typeInfo['warning_msg']) { ?>
        <div class="tcui-cells__title">
             <section style="padding:10px;background: #eff9ff;line-height:1.5;letter-spacing: 1px;">
                <p class="tc-template__color" style="color:#f8a543"><?php echo $typeInfo['warning_msg'];?></p>
             </section>
        </div>
       <?php } ?>
        <section class="edit-item">
            <?php if($tcadminConfig['open_fabu_sites'] == 1) { ?>
            <?php if($sitesList) { ?>
             <section class="input-control ">
                  <span>发布站点</span>
                  <section class="user-fav">
                       <section class="sec-input">
                            <select name="edit_site_id" id="edit_site_id" class="tcui-select" onchange="refreshsites();">
                                <option value="1" <?php if($tongchengInfo['site_id'] == 1) { ?>selected<?php } ?>> <?php echo $tongchengConfig['plugin_name'];?></option>
                                <?php if(is_array($sitesList)) foreach($sitesList as $key => $val) { ?>                                <option value="<?php echo $val['id'];?>" <?php if($tongchengInfo['site_id'] == $val['id']) { ?>selected<?php } ?>> <?php echo $val['lbs_name'];?></option>
                                <?php } ?>
                            </select>
                       </section>
                       <div class="frt">
                            <div class="right-arrow"></div>
                       </div>
                  </section>
             </section>
            <?php } ?>
            <?php } ?>
            <?php if($__ShowTcshop == 1 && $__UserInfo['id'] == $tongchengInfo['user_id']) { ?>
            <?php if($tcshopList) { ?>
             <section class="input-control ">
                  <span>关联店铺</span>
                  <section class="user-fav">
                       <section class="sec-input">
                            <select name="tcshop_id" id="tcshop_id" class="tcui-select">
                                <option value="0"> 不关联店铺</option>
                                <?php if(is_array($tcshopList)) foreach($tcshopList as $key => $val) { ?>                                <option value="<?php echo $val['id'];?>" <?php if($tongchengInfo['tcshop_id'] == $val['id']) { ?>selected<?php } ?>> <?php echo $val['name'];?></option>
                                <?php } ?>
                            </select>
                       </section>
                       <div class="frt">
                            <div class="right-arrow"></div>
                       </div>
                  </section>
             </section>
            <?php } ?>
            <?php } ?>
            <section class="input-control ">
                  <span>所属分类</span>
                  <section class="user-fav">
                       <section class="sec-input">
                           <a style="width: 100%;height: 100%;display: block;" href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=editcate&amp;tongcheng_id=<?php echo $tongcheng_id;?>&amp;fromlist=<?php echo $_GET['fromlist'];?>"><?php echo $modelInfo['name'];?> <?php echo $typeInfo['name'];?></a>
                       </section>
                       <div class="frt">
                            <div class="right-arrow"></div>
                       </div>
                  </section>
             </section>
            <?php if($tongchengConfig['open_fabu_title'] == 1) { ?>
            <section class="input-control ">
                <span>标题</span>
                <section class="user-fav">
                    <section class="sec-input">
                        <input type="text" name="title" id="title" placeholder="请输入标题" value="<?php echo $tongchengInfo['title'];?>" />
                    </section>
                    <div class="frt"></div>
                </section>
            </section>
            <?php } ?>
            <?php if($cateList) { ?>
             <section class="input-control ">
                  <span><?php echo $typeInfo['cate_title'];?></span>
                  <section class="user-fav">
                       <section class="sec-input">
                            <select name="cate_id" id="cate_id" class="tcui-select">
                                <?php if(is_array($cateList)) foreach($cateList as $key => $val) { ?>                                <option value="<?php echo $val['id'];?>" <?php if($val['id']==$tongchengInfo['cate_id'] ) { ?>selected<?php } ?>> <?php echo $val['name'];?></option>
                                <?php } ?>
                            </select>
                       </section>
                       <div class="frt">
                            <div class="right-arrow"></div>
                       </div>
                  </section>
             </section>
            <?php } ?>
            <?php if($attrList) { ?>
            <?php if(is_array($attrList)) foreach($attrList as $key => $val) { ?>                <section class="input-control ">
                      <span><?php echo $val['name'];?></span>
                      <input type="hidden" name="attrname_<?php echo $val['id'];?>" value="<?php echo $val['name'];?>">
                      <input type="hidden" name="attrpaixu_<?php echo $val['id'];?>" value="<?php echo $val['paixu'];?>">
                      <input type="hidden" name="attrunit_<?php echo $val['id'];?>" value="<?php echo $val['unit'];?>">
                      <section class="user-fav">
                           <section class="sec-input">
                               <?php if($val['type'] == 1) { ?>
                               <input type="text" name="attr_<?php echo $val['id'];?>" id="attr_<?php echo $val['id'];?>" placeholder="<?php echo $val['name'];?>" value="<?php echo $tongchengAttrList[$val['id']];?>"  />
                               <?php } ?>
                               <?php if($val['type'] == 2) { ?>
                               <select name="attr_<?php echo $val['id'];?>" id="attr_<?php echo $val['id'];?>" class="tcui-select" >
                                    <?php if(is_array($val['list'])) foreach($val['list'] as $kk => $vv) { ?>                                    <option value="<?php echo $vv;?>" <?php if($vv==$tongchengAttrList[$val['id']] ) { ?>selected<?php } ?>><?php echo $vv;?></option>
                                    <?php } ?>
                                </select>
                               <?php } ?>
                               <?php if($val['type'] == 3) { ?>
                               <input class="tcui-input" type="datetime-local" name="attrdate_<?php echo $val['id'];?>" id="attrdate_<?php echo $val['id'];?>" value="<?php echo $tongchengAttrList[$val['id']];?>" max="<?php echo $maxDateTime;?>" min="<?php echo $minDateTime;?>" />
                               <?php } ?>
                               <?php if($val['type'] == 4) { ?>
                               <div class="tcui-cells tcui-cells_checkbox" style="margin-top: 0px;line-height: 30px;">
                                   <?php if(is_array($val['list'])) foreach($val['list'] as $kk => $vv) { ?>                                    <label class="tcui-cell-cell tcui-check__label clearfix" for="s_<?php echo $val['id'];?>_<?php echo $kk;?>">
                                        <div class="tcui-cell__hd" style="float: left;">
                                            <input type="checkbox" class="tcui-check" name="attr_<?php echo $val['id'];?>[]" value="<?php echo $vv['value'];?>" id="s_<?php echo $val['id'];?>_<?php echo $kk;?>" <?php if($vv['check'] == 1 ) { ?>checked="checked"<?php } ?>>
                                            <i class="tcui-icon-checked"></i>
                                        </div>
                                        <div class="tcui-cell__bd" style="float: left;">
                                            <p><?php echo $vv['value'];?></p>
                                        </div>
                                    </label>
                                   <?php } ?>
                                </div>
                               <?php } ?>
                               <?php if($val['type'] == 5) { ?>
                               <input type="number" name="attr_<?php echo $val['id'];?>" id="attr_<?php echo $val['id'];?>" placeholder="<?php echo $val['name'];?>" value="<?php echo $tongchengAttrList[$val['id']];?>"  />
                               <?php } ?>
                           </section>
                           <div class="frt"><?php if($val['unit']) { ?>/<?php echo $val['unit'];?><?php } elseif($val['type'] == 3) { ?><div class="right-arrow"></div><?php } ?></div>
                      </section>
                 </section>
            <?php } ?>
            <?php } ?>
            <section class="input-control " <?php if($modelInfo['area_select'] == 0  ) { ?>style="display: none;"<?php } ?>>
                 <span>选择区域</span>
                 <section class="user-fav">
                      <section class="sec-input">
                           <div id="choseCity"><?php if($areaName  ) { ?><?php echo $areaName;?> <?php echo $streetName;?><?php } else { ?><font color="#8e8e8e">选择区域</font><?php } ?></div>
                           <input type="hidden" name="area_id" id="area_id" value="<?php echo $tongchengInfo['area_id'];?>">
                           <input type="hidden" name="street_id" id="street_id" value="<?php echo $tongchengInfo['street_id'];?>">
                      </section>
                      <div class="frt"></div>
                 </section>
            </section>
            <?php if($modelInfo['open_dingwei'] == 1 ) { ?>
            <section class="input-control ">
                 <span>详细地址</span>
                 <section class="user-fav">
                      <section class="sec-input">
                           <input type="text" id="address" name="address" placeholder="点击右侧地图按钮进行地址定位" value="<?php echo $tongchengInfo['address'];?>"  />
                           <input type="hidden" name="lng" id="hidlng" value="<?php echo $tongchengInfo['longitude'];?>" />
                           <input type="hidden" name="lat" id="hidlat" value="<?php echo $tongchengInfo['latitude'];?>" />
                      </section>
                     <div id="showActionSheet" class="frt"><i class="tciconfont tcicon-dingwei tc-template__color"  style="color: #F60;"></i><i id="locationtext" class="tc-template__color" style="color: #F60;">定位</i></div>
                 </section>
            </section>
            <?php } ?>
             <section class="input-control clear bb0">
                  <div style="line-height: 3em;"><?php echo $typeInfo['desc_title'];?></div>
                  <section class="textarea">
                       <section class="sec-input">
                            <textarea name="content" id="content" maxlength="10000" placeholder="<?php echo $typeInfo['desc_content'];?>"><?php echo $content;?></textarea>
                       </section>
                  </section>
             </section>
            <?php if($tagList) { ?>
             <section class="input-control clear input-control-hide-title">
                  <span>-</span>
                  <section class="user-fav">
                       <section class="sec-input small-line">
                            <div data-max="5">
                                 <?php if(is_array($tagList)) foreach($tagList as $key => $val) { ?>                                 <input type="checkbox" id="check-fuli-<?php echo $val['id'];?>" name="tag[]" value="<?php echo $val['id'];?>" <?php if($tongchengTagList[$val['id']]==1 ) { ?>checked="checked"<?php } ?> class="file-hide checkbox-label-item" />
                                 <label for="check-fuli-<?php echo $val['id'];?>"><?php echo $val['name'];?></label>
                                 <input type="hidden" name="tagname_<?php echo $val['id'];?>" value="<?php echo $val['name'];?>">
                                 <?php } ?>
                            </div>
                       </section>
                  </section>
             </section>
            <?php } ?>
             <section class="input-control ">
                  <ul>
                      <div id="photolist" class="clearfix">
                          <?php if(is_array($tongchengPhotoList)) foreach($tongchengPhotoList as $key => $val) { ?>                          <li class="li_<?php echo $val['li_i'];?>">
                              <section class="img">
                                  <img src="<?php echo $val['src'];?>" />
                                  <input type="hidden" name="photo_<?php echo $val['li_i'];?>" value="<?php echo $val['picurl'];?>"/>
                              </section>
                              <div class=" close pic-delete-btn pointer" onclick="picremove(<?php echo $val['li_i'];?>);">&nbsp;X&nbsp;</div>
                          </li>
                          <?php } ?>
                      </div>
                       <li>
                            <section class="img pic-upload-btn" id="picpic-btn">
                                <?php if($is_weixin == 0) { ?>
                                <input type="file" name="filedata1" id="filedata1" class="post-upload-fileprew"  />
                                <?php } ?>
                                <img src="source/plugin/tom_tongcheng/images/img7.png" />
                            </section>
                       </li>
                       <li class="li_text"><span>添加照片（最多<?php echo $tongchengConfig['max_photo_num'];?>张） </span></li>
                  </ul>
             </section>
        </section>
        <section class="input-control ">
             <span>联系人</span>
             <section class="user-fav">
                  <section class="sec-input">
                       <input type="text" name="xm" id="xm" placeholder="请输入联系人" value="<?php echo $tongchengInfo['xm'];?>" />
                  </section>
                  <div class="frt"></div>
             </section>
        </section>
        <section class="input-control ">
             <span>电话</span>
             <section class="user-fav">
                  <section class="sec-input">
                       <input type="text" name="tel" id="tel" placeholder="请输入电话" value="<?php echo $tongchengInfo['tel'];?>"  />
                  </section>
                  <div class="frt"></div>
             </section>
        </section>
       <section class="input-control">
             <span class="slide-btn" data-target="advance-slide" data-html="1">发布条款</span>
             <section>
                 <input type="checkbox" name="xieyi" id="xieyi" value="1" checked/> <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=article">我同意条款，保证信息合法合规</a> 
             </section>
        </section>
   </section>
   <section class="btn-group-block">
        <button type="button" id="id_save_btn" class="tc-template__bg id_save_btn">修 改</button>
        <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
        <input type="hidden" name="tongcheng_id" value="<?php echo $tongcheng_id;?>">
        <div class="clear10"></div>
        <div class="clear10"></div>
        <div class="clear10"></div>
   </section>
</form>
<?php if($modelInfo['open_dingwei'] == 1 ) { ?>
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
<?php } ?>
<script>var city = eval(decodeURIComponent('<?php echo $cityData;?>'));var selectedIndex = [<?php echo $chooseI;?>, <?php echo $chooseJ;?>];</script>
<?php if($isGbk) { ?>
<script src="source/plugin/tom_tongcheng/images/mobiscroll/mobiscroll.gbk.js" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/picker/picker.min.gbk.js" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/picker/picker.fabu.gbk.js" type="text/javascript"></script>
<?php } else { ?>
<script src="source/plugin/tom_tongcheng/images/mobiscroll/mobiscroll.utf8.js" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/picker/picker.min.utf8.js" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/picker/picker.fabu.utf8.js" type="text/javascript"></script>
<?php } if($modelInfo['open_dingwei'] == 1 ) { ?>
<script src="//api.map.baidu.com/api?v=2.0&ak=<?php echo $tongchengConfig['baidu_js_ak'];?>" type="text/javascript"></script>
<?php } ?>
<script src="//res.wx.qq.com/open/js/jweixin-1.3.2.js" type="text/javascript" type="text/javascript"></script>
<script>
function refreshsites() {
location.href = 'plugin.php?id=tom_tongcheng&site='+$('#edit_site_id').val()+'&edit_site_id='+$('#edit_site_id').val()+'&mod=edit&tongcheng_id=<?php echo $tongcheng_id;?>&fromlist=<?php echo $_GET['fromlist'];?>';
}    

var li_i = '<?php echo $photoCount;?>';
li_i = li_i*1 + 1;
var count = '<?php echo $photoCount;?>';
count = count*1;
var max_photo_num   = "<?php echo $tongchengConfig['max_photo_num'];?>";
max_photo_num       = max_photo_num*1;

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
      'chooseImage',
      'uploadImage',
      'downloadImage'
    ]
});

var submintSaveStatus = 0;
$(".id_save_btn").click( function (){
    if(submintSaveStatus == 1){
        return false;
    }
    
    var xm          = $("#xm").val();
    var tel         = $("#tel").val();
    var content      = $("#content").val();
    var area_id      = $("#area_id").val();
    var street_id      = $("#street_id").val();
    
    <?php if($tongchengConfig['open_fabu_title'] == 1) { ?>
    var title          = $("#title").val();
    if(title == ""){
        tusi("必须填写标题");
        return false;
    }
    <?php } ?>
    
    <?php if($attrList) { ?>
    <?php if(is_array($attrList)) foreach($attrList as $key => $val) { ?>        <?php if($val['is_must'] == 1) { ?>
            var attr_<?php echo $val['id'];?> = $('#attr_<?php echo $val["id"];?>').val();
            <?php if($val['type'] == 1) { ?>
            if(attr_<?php echo $val['id'];?> == ''){
                tusi('必须填写<?php echo $val["name"];?>');
                return false;
            }
            <?php } elseif($val['type'] == 2) { ?>
            if(attr_<?php echo $val['id'];?> == 0){
                tusi('必须填写<?php echo $val["name"];?>');
                return false;
            }
            <?php } elseif($val['type'] == 3) { ?>
            if(attr_<?php echo $val['id'];?> == ''){
                tusi('必须填写<?php echo $val["name"];?>');
                return false;
            }
            <?php } ?>
        <?php } ?>
    <?php } ?>        
    <?php } ?>
    
    if($('#xieyi').attr("checked")) {
    }else{
        tusi("必须同意发布协议");
        return false;
    }
    
    <?php if($modelInfo['area_select'] == 1  ) { ?>
    if(area_id == ""){
        tusi("必须选择区域");
        return false;
    }
    <?php } ?>
    
    if(xm == ""){
        tusi("必须填写联系人");
        return false;
    }
    <?php if($tongchengConfig['fabu_phone_check'] == 1  ) { ?>
    if(tel == "" || !checkMobile(tel)){
        tusi("必须填写手机号");
        return false;
    }
    <?php } else { ?>
    if(tel == ""){
        tusi("必须填写手机号");
        return false;
    }
    <?php } ?>
    if(content == ""){
        tusi("必须填写<?php echo $typeInfo['desc_title'];?>");
        return false;
    }
    
    if(count > max_photo_num){
        tusi("超过上传张数限制");
        return false;
    }
    
    loading('处理中...');
    submintSaveStatus = 1;
    $.ajax({
        type: "POST",
        url: "<?php echo $saveUrl;?>",
        dataType : "json",
        data: $('#saveForm').serialize(),
        success: function(data){
            submintSaveStatus = 0;
            loading(false);
            if(data.status == 200) {
                tusi("修改成功");
                <?php if($_GET['fromlist'] == 'mylist' ) { ?>
                setTimeout(function(){window.location.href='plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=mylist';},1888);
                <?php } elseif($_GET['fromlist'] == 'managerList') { ?>
                setTimeout(function(){window.location.href='plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=managerList';},1888);
                <?php } ?>
            }else if(data.status == 404){
                tusi("插入信息数据失败");
                //setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 505){
                tusi("包含违禁词："+data.word);
                //setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else{
                tusi("修改失败");
                //setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }
        }
    });
});

function checkMobile(s){
var regu =/^[1][0-9]{10}$/;
var re = new RegExp(regu);
if (re.test(s)) {
return true;
}else{
return false;
}
}

$(document).ready(function() {
    var a = (new Date).getFullYear();
    $("input[type=date]").each(function() {
        $(this).mobiscroll().date({
            startYear: a - 60,
            endYear: a + 10
        })
    }),
    $("input[type=datetime-local]").mobiscroll().datetime({
        startYear: a - 60,
        endYear: a + 10
    })
});

function picremove(i){
    $(".li_"+i).remove();
    count--;
}

$(document).on("click", ".checkbox-label-item",function() {
    var t = $(this).parent(),
    a = parseInt(t.data("max"), 10) || 0;
    a > 0 && $(this).is(":checked") && t.find("input:checked").length > a && ($(this).prop("checked", !1), tusi("只允许选择" + a + "项"))
});
</script>
<?php if($is_weixin == 1) { include template('tom_tongcheng:wx_upload'); } else { include template('tom_tongcheng:new_upload'); } if($modelInfo['open_dingwei'] == 1 ) { if($__IsWeixin == 1) { include template('tom_tongcheng:wx_map'); } else { include template('tom_tongcheng:baidu_map'); } } ?>
</body>
</html>