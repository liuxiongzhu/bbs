<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<!DOCTYPE html>
<html>
<head>
<?php if($isGbk) { ?>
<meta charset="GBK">
<?php } else { ?>
<meta charset="UTF-8">
<?php } ?>
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
<title>加盟合伙人</title>
<link rel="stylesheet" href="source/plugin/tom_tchehuoren/images/weui.css?v=<?php echo $cssJsVersion;?>"/>
<link rel="stylesheet" href="source/plugin/tom_tchehuoren/images/style.css?v=<?php echo $cssJsVersion;?>"/>
<link rel="stylesheet" href="source/plugin/tom_tchehuoren/images/iconfont/iconfont.css?v=<?php echo $cssJsVersion;?>" />
<script src="source/plugin/tom_tchehuoren/images/jquery.min-2.1.3.js" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/global.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tchehuoren/images';
</script>
<script src="source/plugin/tom_tchehuoren/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?><style>
.index_info_box .info-title span{ background:<?php echo $tongchengConfig['template_color'];?>;}
.index_info_box .info-title span.info-title__lt:after{ border-color:<?php echo $tongchengConfig['template_color'];?>; }
.index_info_box .info-title span.info-title__rt:before{ border-color:<?php echo $tongchengConfig['template_color'];?>; }
</style>
</head>
<body>
<section class="index_header">
<div class="header_logo">
        <img src="<?php echo $tchehuorenConfig['inlet_header_logo'];?>">
        <a class="back" href="javascript:void(0);" onclick="window.history.back(-1);"><img src="source/plugin/tom_tchehuoren/images/inlet_back.png"></a>
        <a class="index" href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=index"><img src="source/plugin/tom_tchehuoren/images/inlet_index.png"></a>
    </div>
    <?php if($newShowList) { ?>
    <div class="header_new_shouyi">
        <div class="header_list-pic"><i class="tciconfont tcicon-shangshen tc-template__color"></i></div>
        <div class="header_list">
            <?php if(is_array($newShowList)) foreach($newShowList as $key => $value) { ?>            <div class="header-term">
                <div class="header-term__hd"><?php echo $value['userInfo']['xm'];?>获得收益￥<?php echo $value['shouyi_price'];?></div>
                <div class="header-term__bd"><?php echo dgmdate($value[add_time], 'u','9999','m-d H:i');?></div>
            </div>
            <?php } ?>
        </div>
    </div>
    <?php } ?>
</section>
<?php if($exclusive) { ?>
<section class="index_info_box">
<div class="info-title">
        <span class="info-title__lt"></span>专属权利<span class="info-title__rt"></span>
    </div>
<div class="info-content"><?php if(is_array($exclusive)) foreach($exclusive as $key => $value) { ?>        <div class="info-term info-zhuanshu">
            <div class="info-zhuanshu-text">
                <h6><?php echo $value['i'];?><span class="ff00E3C3 tc-template__color">&nbsp;/&nbsp;</span><?php echo $value['title'];?></h6>
                <p class="info-term_text"><?php echo $value['content'];?></p>
            </div>
            <div class="info-zs-pic"><img src="<?php echo $value['zhuanshu_picurl'];?>"></div>
</div>
        <?php } ?>
</div>
</section>
<?php } if($problem) { ?>
<section class="index_info_box">
<div class="info-title">
        <span class="info-title__lt"></span>常见问题<span class="info-title__rt"></span>
    </div>
<div class="info-content">
        <?php if(is_array($problem)) foreach($problem as $key => $value) { ?><div class="info-term">
<h6>Q<?php echo $value['i'];?>&nbsp;<?php echo $value['title'];?></h6>
<p class="info-term_text"><?php echo $value['content'];?></p>
</div>
<?php } ?>
</div>
</section>
<?php } ?>
<section class="index_become_box">
    <?php if($shenqingStatus == 1) { ?>
<a href="javascript:void(0);" class="become_button tc-template__bg">审核中，请等待。。。</a>
    <?php } elseif($shenqingStatus == 2) { ?>
        <?php if($tchehuorenConfig['open_pay_hehuoren'] == 1) { ?>
            <?php if($__IsMiniprogram == 1 && $__Ios == 1 && $tchehuorenConfig['closed_ios_pay'] == 1 ) { } else { ?>
            <a href="javascript:void(0);" id="add_hehuoren" class="become_button tc-template__bg">审核失败,点击重新申请支付￥ <?php echo $tchehuorenConfig['hehuoren_pay_money'];?></a>
            <?php } ?>
        <?php } else { ?>
        <a href="javascript:void(0);" id="add_hehuoren" class="become_button tc-template__bg">审核失败,点击重新申请</a>
        <?php } ?>
    <?php } elseif($shenqingStatus == 3) { ?>
    <a href="plugin.php?id=tom_tchehuoren&amp;site=<?php echo $site_id;?>&amp;mod=index" class="become_button tc-template__bg">前往合伙人中心</a>
    <?php } else { ?>
        <?php if($tchehuorenConfig['open_pay_hehuoren'] == 1) { ?>
            <?php if($__IsMiniprogram == 1 && $__Ios == 1 && $tchehuorenConfig['closed_ios_pay'] == 1 ) { } else { ?>
            <a href="javascript:void(0);" id="add_hehuoren" class="become_button tc-template__bg">成为合伙人支付￥ <?php echo $tchehuorenConfig['hehuoren_pay_money'];?></a>
            <?php } ?>
        <?php } else { ?>
        <a href="javascript:void(0);" id="add_hehuoren" class="become_button tc-template__bg">成为合伙人</a>
        <?php } ?>
    <?php } ?>
</section>
<section class="height50"></section>

<div class="js_dialog" id="go_phone" style="display: none;">
    <div class="weui-mask"></div>
    <div class="weui-dialog">
        <div class="weui-dialog__hd"><strong class="weui-dialog__title">温馨提示</strong></div>
        <div class="weui-dialog__bd">加入合伙人需要绑定手机号</div>
        <div class="weui-dialog__ft">
            <a href="<?php echo $phoneUrl;?>" class="weui-dialog__btn weui-dialog__btn_default">去绑定</a>
            <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary">取消</a>
        </div>
    </div>
</div>
<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<script>
$(function() {
    setInterval(function() {
        var e = $(".header_list");
        e.scrollTo({
            to: e.find(".header-term").eq(0).height(),
            durTime: 800,
            delay: 80,
            callback: function() {
                var a = e.find(".header-term").eq(0),
                i = a.clone(!0);
                e.scrollTop(0),
                a.remove(),
                e.append(i)
            }
        })
    },
    2e3)
});

var tj_hehuoren_id = "<?php echo $tj_hehuoren_id;?>";
tj_hehuoren_id = tj_hehuoren_id * 1;
var onSubmitStatus = 0;
$(document).on('click', '#add_hehuoren', function(){
    if(onSubmitStatus == 1){
        return false;
    }
    onSubmitStatus = 1;
    $.ajax({
        type: "POST",
        url: "<?php echo $ajaxUrl;?>",
        dataType : "json",
        data: {act:'add_tchehuoren',tj_hehuoren_id:tj_hehuoren_id},
        success: function(data){
            onSubmitStatus = 0;
            loading(false);
            if(data.status == 200) {
                if(data.paystatus == 1){
                    tusi("下单成功，立即支付");
                    setTimeout(function(){window.location.href=data.payurl+"&prand=<?php echo $prand;?>";},1888);
                }else{
                    tusi("申请成功");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }
            }else if(data.status == 301){
                tusi("您已经是合伙人");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 302){
                tusi("已申请，请等待");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 303){
                $('#go_phone').show();
            }else if(data.status == 304){
                tusi("请安装TOM支付中心");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 305){
                tusi("支付金额未设置");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 306){
                tusi("订单生产失败");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else{
                tusi("异常错误");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }
        }
    });
})

$(document).on('click', '.weui-dialog__btn_primary', function(){
    $(this).parents('.js_dialog').fadeOut(200);
})
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
      'onMenuShareAppMessage',
      'previewImage'
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
    wx.onMenuShareQQ({
        title: '<?php echo $shareTitle;?>',
        desc: '<?php echo $shareDesc;?>',
        link: '<?php echo $shareUrl;?>',
        imgUrl: '<?php echo $shareLogo;?>',
        success: function () { 
        },
        cancel: function () { 
        }
    });
});
</script>
</body>
</html>