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
<title>设置 - <?php echo $__SitesInfo['name'];?></title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/iconfont/iconfont.css?v=<?php echo $cssJsVersion;?>" />
<script src="source/plugin/tom_tongcheng/images/jquery.min-2.1.3.js" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?><style>
.tcui-grid {padding: 15px 5px;}
.tcui-panel:after{border-bottom: 0px solid #E5E5E5;}
.tcui-panel__hd{padding: 12px 10px;}
.tcui-panel__hd:after{border-bottom: 0px solid #E5E5E5;}
.tcui-grid__icon + .tcui-grid__label{margin-top: 7px;}
</style>
</head>
<body>
<?php if($__HideHeader == 0 ) { ?>
<header class="header on tc-template__bg">
    <section class="wrap">
        <section class="sec-ico go-back" onclick="location.href='plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=personal';">返回</section>
        <h2>设置</h2>
    </section>
</header>
<?php } ?>
<section class="mainer">
   <section class="wrap">
        <section class="user-page">
             <?php if($__HideHeader == 0 ) { ?>
             <div class="clear10"></div>
             <?php } ?>
             <section class="user-page-nav">
                 <div class="tcui-media-box tcui-media-box_small-appmsg">
                    <div class="tcui-cells">
                        <?php if($tongchengConfig['open_phone']==1 || $tongchengConfig['fabu_must_phone']==1 ) { ?>
                        <a class="tcui-cell tcui-cell_access" href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=phone">
                            <div class="tcui-cell__hd"><img src="source/plugin/tom_tongcheng/images/personal/nav-phone.png" alt="" style="width:24px;margin-right:10px;display:block"></div>
                            <div class="tcui-cell__bd tcui-cell_primary"><p>绑定手机号&nbsp;<?php if($__UserInfo['tel'] ) { ?><font color="#238206">(已绑定)</font><?php } ?></p></div>
                            <span class="tcui-cell__ft"></span>
                        </a>
                        <?php } ?>
                        <?php if($__ShowTchongbao == 1) { ?>
                        <a class="tcui-cell" href="javascript:void(0);" style="padding: 0px 15px;">
                            <div class="tcui-cell__hd"><img src="source/plugin/tom_tongcheng/images/personal/nav-hongbao.png" alt="" style="width:24px;margin-right:10px;display:block"></div>
                            <div class="tcui-cell__bd tcui-cell_primary"><p>接收抢红包消息提醒</p></div>
                            <div class="tcui-cell__ft">
                                <input id="id_hongbao_tz" class="tcui-switch" type="checkbox">
                            </div>
                        </a>
                        <?php } ?>
                        <?php if($__MemberInfo) { ?>
                        <a class="tcui-cell tcui-cell_access" href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=address&amp;address_back_url=<?php echo $address_back_url;?>">
                            <div class="tcui-cell__hd"><img src="source/plugin/tom_tongcheng/images/personal/nav-address.png" alt="" style="width:24px;margin-right:10px;display:block"></div>
                            <div class="tcui-cell__bd tcui-cell_primary"><p>收货地址</p></div>
                            <span class="tcui-cell__ft"></span>
                        </a>
                        <?php } ?>
                    </div>
                </div>
             </section>
            <div class="clear10"></div>
            <div class="clear10"></div>
            <div class="clear10"></div>
        </section>
   </section>
</section><?php include template('tom_tongcheng:footer'); ?><script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<script>
var userGetHongbaoTz = "<?php echo $__UserInfo['hongbao_tz'];?>";
userGetHongbaoTz = userGetHongbaoTz*1;

$(document).ready(function(){
    <?php if($__UserInfo['status'] == 2) { ?>
    tusi("你已经涉嫌违规，被平台暂时封号");
    <?php } ?>
   $.get("<?php echo $ajaxCommonClicksUrl;?>");
   $.get("<?php echo $ajaxUpdateTopstatusUrl;?>");
   if(userGetHongbaoTz == 1){
       $("#id_hongbao_tz").prop("checked",true);
   }else{
       $("#id_hongbao_tz").prop("checked",false);
   }
});

$("#id_hongbao_tz").click(function(){
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxHongbaoTzUrl;?>",
        data: "a="+1,
        success: function(msg){
            if(msg == '100'){
                userGetHongbaoTz = 1;
                $("#id_hongbao_tz").prop("checked",false);
                tusi("关闭成功");
            }else if(msg == '200'){
                userGetHongbaoTz = 0;
                $("#id_hongbao_tz").prop("checked",true);
                tusi("开启成功");
            }else{
                tusi("操作错误");
            }
        }
    })
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