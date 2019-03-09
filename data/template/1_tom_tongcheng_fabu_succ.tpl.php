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
<title>发布成功 - <?php echo $__SitesInfo['name'];?></title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/iconfont/iconfont.css?v=<?php echo $cssJsVersion;?>" />
<script src="source/plugin/tom_tongcheng/images/jquery.min-2.1.3.js" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?><style>
.tcui-actionsheet__cell:before{border:0}
.tcui-actionsheet__cell{border-bottom:1px solid #EFEFF4;padding:20px 0}
.tcui-cells:before{border:0}
.tcui-cell:before{border:0}
.tcui-cell:after{
    content: " ";
    position: absolute;
    left: 0;
    bottom: 0;
    right: 0;
    height: 1px;
    color: #D9D9D9;
    -webkit-transform-origin: 0 0;
    transform-origin: 0 0;
    -webkit-transform: scaleY(0.5);
    transform: scaleY(0.5);
    border-bottom: 1px solid #fcf2dd;
    width: 90%;
    margin-left: auto;
    margin-right: auto;}
.tcui-cells:after{border:0}
.tcui-cells{background-color: #fff;margin-top: 0px;}
</style>
</head>
<body class="body-white">
<?php if($__HideHeader == 0 ) { ?>
<header class="header header-index on in2 tc-template__bg">
    <section class="wrap">
        <section class="sec-ico go-back" onclick="history.back();">返回</section>
        <h2>发布成功</h2>
    </section>
</header>
<?php } ?>
<div class="mainer">
    <div class="clear5"></div>
    <div class="fabu_succ_top">
        <div class="fabu_succ_top_logo"><i class="tcui-icon-success" style="font-size: 50px;"></i></div>
        <div class="fabu_succ_top_msg">恭喜，发布成功</div>
    </div>
    <?php if($tongchengInfo['shenhe_status'] == 2) { ?>
    <div class="fabu_succ_shenhe_msg">正在审核中，请稍等一会</div>
    <?php } ?>
    <div class="fabu_succ_nav">
        <a class="nav_span1" href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=mylist">管理信息</a>
        <?php if($tongchengInfo['shenhe_status'] == 1) { ?>
        <a class="nav_span2" href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=view&amp;xxid=<?php echo $tongchengInfo['id'];?>">查看信息</a>
        <?php } ?>
        <a class="nav_span3" href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=fabu&amp;act=step2&amp;type_id=<?php echo $tongchengInfo['type_id'];?>">再发一条</a>
        <?php if($__IsMiniprogram == 1 && $__Ios == 1 && $tongchengConfig['closed_ios_pay'] == 1 ) { } else { ?>
            <?php if($__ShowTchongbao == 1) { ?>
            <a class="nav_span4" href="plugin.php?id=tom_tchongbao&amp;mod=add&amp;site=<?php echo $site_id;?>&amp;tongcheng_id=<?php echo $tongchengInfo['id'];?>">塞红包</a>
            <?php } ?>
        <?php } ?>
    </div>
    <?php if($__IsMiniprogram == 1 && $__Ios == 1 && $tongchengConfig['closed_ios_pay'] == 1 ) { } else { ?>
     <div class="fabu_succ_buy_msg">
         <div class="fabu_succ_buy_msg_img"><img src="source/plugin/tom_tongcheng/images/dengpao.png"></div>
         <div class="fabu_succ_buy_msg_txt">信息置顶，提高6-8倍曝光量</div>
     </div>
    <div class="fabu_succ_buy">
        <div class="fabu_succ_buy_main">
            <div class="tcui-cells tcui-cells_checkbox">
                <form name="payForm" id="payForm">
                <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
                <input type="hidden" name="tongcheng_id" value="<?php echo $tongcheng_id;?>">
                <?php if(is_array($buy_days_item)) foreach($buy_days_item as $key => $val) { ?>                <label class="tcui-cell tcui-check__label buy_days_item" for="s<?php echo $val['i'];?>" <?php if($val['i'] > 4) { ?> style="display:none;"<?php } ?>>
                    <div class="tcui-cell__hd">
                        <input type="radio" class="tcui-check" name="days" value="<?php echo $val['days'];?>" id="s<?php echo $val['i'];?>" <?php if($chose_item == $val['i']) { ?> checked="checked"<?php } ?>>
                        <i class="tcui-icon-checked"></i>
                    </div>
                    <div class="tcui-cell__bd">
                        <p style="color: #606060;">置顶<font color="#fd0d0d"><?php echo $val['days'];?></font>天 / 
                            <?php if($val['score_pay'] == 1) { ?>
                            <font color="#fd0d0d"><?php echo $val['score'];?>金币</font>
                            <?php } else { ?>
                            <font color="#fd0d0d"><?php echo $val['price'];?>元</font>
                            <?php } ?>
                        </p>
                    </div>
                </label>
                <?php } ?> 
                </form>
            </div>
        </div>
        <?php if($buy_days_count > 4) { ?>
        <div class="fabu_succ_buy_more"><a href="javascript:void(0);" onclick="showAllDays();">查看更多置顶天数</a></div>
        <?php } ?>
    </div>
    <section class="btn-group-block" style="margin-top: 0.5em;">
        <button type="button" class="id_top_btn tc-template__bg">确认购买</button>
    </section>
    <?php } ?>
</div><?php include template('tom_tongcheng:footer'); ?><div style="display: none;"><?php echo $tongchengConfig['tongji_code'];?></div>
<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<script>
$(document).ready(function(){
   $.get("<?php echo $ajaxCommonClicksUrl;?>");
   $.get("<?php echo $ajaxShenheSmsUrl;?>");
   <?php if($tongchengConfig['open_yun'] == 2) { ?>
    $.get("<?php echo $ossBatchUrl;?>");
    <?php } ?>
    <?php if($tongchengConfig['open_yun'] == 3) { ?>
    $.get("<?php echo $qiniuBatchUrl;?>");
    <?php } ?>
});

function showAllDays(){
    $(".buy_days_item").show();
    $(".fabu_succ_buy_more").hide();
}

var submintPayStatus = 0;
$(".id_top_btn").click( function (){
    if(submintPayStatus == 1){
        return false;
    }
    
    submintPayStatus = 1;
    $.ajax({
        type: "POST",
        url: "<?php echo $payTopUrl;?>",
        dataType : "json",
        data: $('#payForm').serialize(),
        success: function(data){
            if(data.status == 200) {
                tusi("下单成功，立即支付");
                setTimeout(function(){window.location.href=data.payurl+"&prand=<?php echo $prand;?>";},500);
            }else if(data.status == 201){
                tusi("置顶成功");
                setTimeout(function(){window.location.href=data.succurl+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 302){
                tusi("置顶天数异常");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 303){
                tusi("生成微信订单失败");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 304){
                tusi("插入订单数据失败");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 307){
                tusi("没有安装TOM支付中心插件");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 400){
                tusi("未设置置顶费用");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else{
                tusi("支付错误");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }
        }
    });
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