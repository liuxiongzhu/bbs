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
<title>帮助中心 - <?php echo $__SitesInfo['name'];?></title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/help.css?v=<?php echo $cssJsVersion;?>" />
<script src="source/plugin/tom_tongcheng/images/jquery.min-2.1.3.js" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?><style>
.help-item .help-checkbox:checked ~ .tcui-cell__bd{ color:<?php echo $tongchengConfig['template_color'];?>}
.help-item .help-checkbox:checked ~ .tcui-cell__ft:after{ border-color:<?php echo $tongchengConfig['template_color'];?>}
</style>
</head>
<body>
<?php if($__HideHeader == 0 ) { ?>
<header class="header on tc-template__bg">
    <section class="wrap">
        <section class="sec-ico go-back" onclick="history.back();">返回</section>
            <h2>帮助中心</h2>
    </section>
</header>
<?php } ?>
<section class="mainer">
   <section class="wrap">
       <div class="tcui-cells" <?php if($__HideHeader == 1 ) { ?>style="margin-top: 0px;"<?php } ?>>
         <?php if(is_array($helpList)) foreach($helpList as $key => $val) { ?>         <label class="tcui-cell tcui-cell_access help-item">
            <input class="help-checkbox" id="item-<?php echo $val['id'];?>" type="checkbox">
            <div class="tcui-cell__bd">
                <p><?php echo $val['i'];?>、<?php echo $val['title'];?> </p>
            </div>
            <div class="tcui-cell__ft"></div>
            <div class="help-body">
            <?php echo $val['content'];?>
            </div>
         </label>
         <?php } ?> 
        </div>
        <center style="margin:10px;background:#FFF;border:1px solid #DDD;line-height:2;color:#888;padding:1em">
            <img src="<?php echo $kefuQrcodeSrc;?>" style="max-width:60%;">
            <br>没有找到要解决的问题？
            <br>长按二维码添加客服微信
        </center>
   </section>
</section>    
<div style="display: none;"><?php echo $tongchengConfig['tongji_code'];?></div>
<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<script>
$(document).ready(function(){
   $.get("<?php echo $ajaxCommonClicksUrl;?>");
   $.get("<?php echo $ajaxUpdateTopstatusUrl;?>");
});
</script>
<script>
wx.config({
    debug: false,
    appId: '<?php echo $wxJssdkConfig["appId"];?>',
    timestamp: <?php echo $wxJssdkConfig["timestamp"];?>,
    nonceStr: '<?php echo $wxJssdkConfig["nonceStr"];?>',
    signature: '<?php echo $wxJssdkConfig["signature"];?>',
    jsApiList: [
      'onMenuShareTimeline',
      'onMenuShareAppMessage'
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