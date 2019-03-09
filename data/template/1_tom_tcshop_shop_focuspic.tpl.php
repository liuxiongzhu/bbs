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
<title>修改店铺幻灯片 - <?php echo $__SitesInfo['name'];?></title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
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
        <h2>修改店铺幻灯片</h2>
   </section>
</header>

<form class="mainer" name="saveForm" id="saveForm" >
    <section class="wrap edit-form">
         <section class="edit-item">
             <section class="input-control ">
                 <div style="line-height: 2em;margin-top: 0.5em;">修改店铺幻灯片<font color="#8e8e8e"></font></div>
                 <div style="line-height: 1em;margin-bottom: 0.5em;"><font color="#f5833b;">幻灯片尺寸 720 * 324 (单位: px) 如果不是这个尺寸，将会被程序裁剪</font></div>
                   <ul>
                       <div id="photolist">
                            <?php if(is_array($tcshopFocuspicInfo)) foreach($tcshopFocuspicInfo as $key => $val) { ?>                           <li class="li_<?php echo $val['li_i'];?>">
                               <section class="img">
                                   <img src="<?php echo $val['picurl'];?>" />
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
                                 <?php if($__IsWeixin == 1 && $tongchengConfig['open_many_pic_upload'] == 1) { ?>
                                 <div id="shop_focuspic" class="post-upload-fileprew"></div>
                                 <?php } else { ?>
                                 <input type="file" name="shop_focuspic" id="shop_focuspic" class="post-upload-fileprew"/>
                                 <?php } ?>
                                 <img src="source/plugin/tom_tongcheng/images/img7.png" />
                             </section>
                        </li>
                   </ul>
              </section>
         </section>
    </section>
    <section class="btn-group-block">
        <button type="button" id="id_save_btn" onClick="save();" class="id_save_btn tc-template__bg">点击修改</button>
        <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
        <input type="hidden" name="tcshop_id" value="<?php echo $tcshop_id;?>">
        <div class="clear10"></div>
        <div class="clear10"></div>
        <div class="clear10"></div>
   </section>
</form>
    
<script src="//res.wx.qq.com/open/js/jweixin-1.3.2.js" type="text/javascript" type="text/javascript"></script>
<script>
var li_i = "<?php echo $i;?>" * 1;
var photo_count = "<?php echo $tcshopFocuspicCount;?>" * 1;

var submintPayStatus = 0;
function save(type){
    
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
            
                tusi("修改成功");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                
            }else{
                tusi("修改失败");
                //setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }
        }
    });
}
</script><?php include template('tom_tcshop:upload'); if($__IsWeixin == 1 && $tongchengConfig['open_many_pic_upload'] == 1) { include template('tom_tcshop:wx_upload'); } ?>
<script>
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
</body>
</html>