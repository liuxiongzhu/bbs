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
<title>商户中心 - <?php echo $__SitesInfo['name'];?></title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tcshop/images/iconfont/iconfont.css?v=<?php echo $cssJsVersion;?>" />
<link href="source/plugin/tom_tongcheng/images/swiper.min.css" rel="stylesheet" />
<link rel="stylesheet" href="source/plugin/tom_tcshop/images/shop_style.css?v=<?php echo $cssJsVersion;?>" />
<script src="source/plugin/tom_tcshop/images/jquery.min-2.1.3.js" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/swiper.min.js" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/global.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<script src="source/plugin/tom_tcshop/images/html2canvas.min.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/layer_mobile/layer.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?><style>
.layui-m-layer0 .layui-m-layerchild{width: 70%;}
.layui-m-layercont{padding: 5px 3px;}
.tcui-actionsheet__cell:before{border:0}
.tcui-actionsheet__cell{border-bottom:1px solid #EFEFF4;padding:20px 0}
.tcui-skin_android .tcui-actionsheet__cell{font-size: 18px;color: #505050;}
<?php if($__ShowTcqianggou == 0) { ?>
.store_top .top-nav a{width: 33%;};
<?php } ?>
</style>
</head>
<body id="shop_details">
<section class="shop_head tc-template__bg">
<div class="search-title">
    	商户中心
        <a href="javascript:;" style="position:absolute; top:0px; width:60px;" class="back" onclick="location.href='plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=personal';"><i></i>返回</a>
    </div>
</section>
<section class="store_top tc-template__bg">
    <div class="top-nav clearfix">
        <?php if($__ShowTcqianggou == 1) { ?>
        <a href="plugin.php?id=tom_tcqianggou&amp;site=<?php echo $site_id;?>&amp;mod=orderhexiao">
            <img src="source/plugin/tom_tcshop/images/store/top-nav-1.png">
            <p>输码核销</p>
        </a>
        <?php } ?>
        <a onclick="getQrcode();" href="javascript:void(0);">
            <img src="source/plugin/tom_tcshop/images/store/top-nav-2.png">
            <p>扫码核销</p>
        </a>
        <a class="show-menu" data-id="order" href="javascript:void(0);">
            <img src="source/plugin/tom_tcshop/images/store/top-nav-3.png">
            <p>订单管理</p>
        </a>
        <a href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=money">
            <img src="source/plugin/tom_tcshop/images/store/top-nav-4.png">
            <p>账户提现</p>
        </a>
    </div>
</section>
<section class="store_nav">
    <div class="nav-nav clearfix">
        <a href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=mylist">
            <img src="source/plugin/tom_tcshop/images/store/nav-tcshop.png">
            <p>店铺管理</p>
        </a>
        <?php if($__ShowTcmall == 1) { ?>
        <a class="show-menu" data-id="mall" href="javascript:void(0);">
            <img src="source/plugin/tom_tcshop/images/store/nav-tcmall.png">
            <p>商城管理</p>
        </a>
        <?php } ?>
        <?php if($__ShowTcqianggou == 1) { ?>
        <a class="show-menu" data-id="qianggou" href="javascript:void(0);">
            <img src="source/plugin/tom_tcshop/images/store/nav-tcqianggou.png">
            <p>抢购管理</p>
        </a>
        <?php } ?>
        <?php if($__ShowTcptuan == 1) { ?>
        <a class="show-menu" data-id="ptuan" href="javascript:void(0);">
            <img src="source/plugin/tom_tcshop/images/store/nav-tcptuan.png">
            <p>拼单管理</p>
        </a>
        <?php } ?>
        <?php if($__ShowTckjia == 1) { ?>
        <a class="show-menu" data-id="kjia" href="javascript:void(0);">
            <img src="source/plugin/tom_tcshop/images/store/nav-tckjia.png">
            <p>减价管理</p>
        </a>
        <?php } ?>
        <?php if($__ShowTcyikatong == 1) { ?>
        <a class="show-menu" data-id="vip" href="javascript:void(0);">
            <img src="source/plugin/tom_tcshop/images/store/nav-tcvip.png">
            <p><?php echo $tcyikatongConfig['card_name'];?></p>
        </a>
        <?php } ?>
        <?php if($__ShowTcqianggou == 1 && $tcqianggouConfig['open_kajuan'] == 1) { ?>
        <a class="show-menu" data-id="kaquan" href="javascript:void(0);">
            <img src="source/plugin/tom_tcshop/images/store/nav-tckaquan.png">
            <p>卡券管理</p>
        </a>
        <?php } ?>
    </div>
</section>
<section class="store_tongji_title clearfix">
    <div class="store_tongji_title_pic"><img src="source/plugin/tom_tcshop/images/store/data.gif"></div>
    <div class="store_tongji_title_txt">店铺统计</div>
</section>
<section class="store_tongji clearfix">
    <ul class="clearfix">
        <li>
            <a>
                <p class="title">累计收入</p>
                <p class="num"><?php echo $total_money;?></p>
            </a>
        </li>
        <li>
            <a>
                <p class="title">订单总数</p>
                <p class="num"><?php echo $total_orders;?></p>
            </a>
        </li>
        <li>
            <a>
                <p class="title">店铺曝光</p>
                <p class="num"><?php echo $total_clicks;?></p>
            </a>
        </li>
    </ul>
</section>
<center style="margin:10px;background:#FFF;border:1px solid #e8e8e8;line-height:2;color:#888;padding:1em">
    <img src="<?php echo $kefuQrcodeSrc;?>" style="max-width:60%;">
    <br>长按二维码添加客服微信
</center>
<div id="menu-child-order" style="display:none">
    <?php if($__ShowTcmall == 1) { ?>
    <a class="tcui-actionsheet__cell" href="plugin.php?id=tom_tcmall&amp;site=<?php echo $site_id;?>&amp;mod=myorder">商城订单</a>
    <?php } ?>
    <?php if($__ShowTcqianggou == 1) { ?>
    <a class="tcui-actionsheet__cell" href="plugin.php?id=tom_tcqianggou&amp;site=<?php echo $site_id;?>&amp;mod=order&amp;type=1">抢购订单</a>
    <?php } ?>
    <?php if($__ShowTcptuan == 1) { ?>
    <a class="tcui-actionsheet__cell" href="plugin.php?id=tom_tcptuan&amp;site=<?php echo $site_id;?>&amp;mod=myorder">拼单订单</a>
    <?php } ?>
    <?php if($__ShowTckjia == 1) { ?>
    <a class="tcui-actionsheet__cell" href="plugin.php?id=tom_tckjia&amp;site=<?php echo $site_id;?>&amp;mod=order">减价订单</a>
    <?php } ?>
    <?php if($__ShowTcqianggou == 1) { ?>
    <a class="tcui-actionsheet__cell" href="plugin.php?id=tom_tcqianggou&amp;site=<?php echo $site_id;?>&amp;mod=order&amp;type=2">卡券订单</a>
    <?php } ?>
</div>
<div id="menu-child-qianggou" style="display:none">
    <a class="tcui-actionsheet__cell" href="plugin.php?id=tom_tcqianggou&amp;site=<?php echo $site_id;?>&amp;mod=myfabu&amp;t_id=1">抢购商品</a>
    <a class="tcui-actionsheet__cell" href="plugin.php?id=tom_tcqianggou&amp;site=<?php echo $site_id;?>&amp;mod=fabu&amp;type=qianggou">发布抢购</a>
</div>
<div id="menu-child-ptuan" style="display:none">
    <a class="tcui-actionsheet__cell" href="plugin.php?id=tom_tcptuan&amp;site=<?php echo $site_id;?>&amp;mod=myfabu">拼单商品</a>
    <a class="tcui-actionsheet__cell" href="plugin.php?id=tom_tcptuan&amp;site=<?php echo $site_id;?>&amp;mod=fabu">发布拼单</a>
</div>
<div id="menu-child-kjia" style="display:none">
    <a class="tcui-actionsheet__cell" href="plugin.php?id=tom_tckjia&amp;site=<?php echo $site_id;?>&amp;mod=myfabu">减价商品</a>
    <a class="tcui-actionsheet__cell" href="plugin.php?id=tom_tckjia&amp;site=<?php echo $site_id;?>&amp;mod=fabu">发布减价</a>
</div>
<div id="menu-child-vip" style="display:none">
    <a class="tcui-actionsheet__cell" href="plugin.php?id=tom_tcyikatong&amp;site=<?php echo $site_id;?>&amp;mod=mylist">特权管理</a>
    <a class="tcui-actionsheet__cell" href="plugin.php?id=tom_tcyikatong&amp;site=<?php echo $site_id;?>&amp;mod=ruzhu">发布特权</a>
</div>
<div id="menu-child-kaquan" style="display:none">
    <a class="tcui-actionsheet__cell" href="plugin.php?id=tom_tcqianggou&amp;site=<?php echo $site_id;?>&amp;mod=myfabu&amp;t_id=2">卡券商品</a>
    <a class="tcui-actionsheet__cell" href="plugin.php?id=tom_tcqianggou&amp;site=<?php echo $site_id;?>&amp;mod=fabu&amp;type=kaquan">发布卡券</a>
</div>
<div id="menu-child-mall" style="display:none">
    <a class="tcui-actionsheet__cell" href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=mallCate">店铺分类</a>
    <a class="tcui-actionsheet__cell" href="plugin.php?id=tom_tcmall&amp;site=<?php echo $site_id;?>&amp;mod=mylist">商城商品</a>
    <a class="tcui-actionsheet__cell" href="plugin.php?id=tom_tcmall&amp;site=<?php echo $site_id;?>&amp;mod=ruzhu">发布商品</a>
</div>
<div class="tcui-skin_android" id="menu-sheet" style="display: none;">
    <div class="tcui-mask"></div>
    <div class="tcui-actionsheet">
        <div class="tcui-actionsheet__menu" id="menu-sheet-menu"></div>
    </div>
</div><?php include template('tom_tcshop:footer'); ?><div style="display: none;"><?php echo $tongchengConfig['tongji_code'];?></div>
<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<script>
$(function(){
    var menuActionSheet = $('#menu-sheet');
    var menuMask = menuActionSheet.find('.tcui-mask');
    $(".show-menu").on('click', function(){
        menuActionSheet.fadeIn(200);
        var menuId = $(this).data('id');
        var menuHtml = $('#menu-child-' + menuId).html();
        $('#menu-sheet-menu').html(menuHtml);
        menuMask.on('click',function () {
            menuActionSheet.fadeOut(200);
        });
    });
});
</script>
<script>
function getQrcode(){
    <?php if($__IsWeixin == 1) { ?>
    wx.scanQRCode({
        needResult: 0, // Ĭ��Ϊ0��ɨ������΢�Ŵ���1��ֱ�ӷ���ɨ������
        scanType: ["qrCode","barCode"], // ����ָ��ɨ��ά�뻹��һά�룬Ĭ�϶��߶���
        success: function (res) {
            var result = res.resultStr; // ��needResult Ϊ 1 ʱ��ɨ�뷵�صĽ��
        }
    });
    <?php } else { ?>
    tusi("请用手机微信打开");
    return false;
    <?php } ?>
}

wx.config({
    debug: false,
    appId: '<?php echo $wxJssdkConfig["appId"];?>',
    timestamp: <?php echo $wxJssdkConfig["timestamp"];?>,
    nonceStr: '<?php echo $wxJssdkConfig["nonceStr"];?>',
    signature: '<?php echo $wxJssdkConfig["signature"];?>',
    jsApiList: [
      'onMenuShareTimeline',
      'onMenuShareAppMessage',
      'onMenuShareQQ',
      'previewImage',
      'openLocation',
      'getLocation',
      'scanQRCode'
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