<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<!DOCTYPE html>
<html><head>
<title>收货地址</title>
<?php if($isGbk) { ?>
<meta http-equiv="Content-Type" content="text/html; charset=GBK">
<?php } else { ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php } ?>
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/address.css?v=<?php echo $cssJsVersion;?>">
<script src="source/plugin/tom_tongcheng/images/jquery-1.8.3.min.js" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?></head>
<body>
<div class='div_block'></div>
<div class="add_address_red">
    <div class="inner_red tc-template__bg">
        <a href="<?php echo $addressUrl;?>&act=add" class="add_text_red" style="color:white">新增地址</a>
    </div>
    <div class="inner_back">
        <a href="<?php echo $address_back_url;?>" class="add_text_red" style="color:3e3a3a;">返回</a>
    </div>
</div>
<div class="wx_wrap">
    <div class="address_list" id="addressList" style="-webkit-transform-origin: 0px 0px; opacity: 1; -webkit-transform: scale(1, 1);">
        <div>
            <?php if(is_array($addressList)) foreach($addressList as $key => $val) { ?>            <!-- item start -->
            <div class="address">
                <div class="wrap_address">
                    <?php if($val['default_id']==1) { ?><span class='none' >默认</span><?php } ?>
                </div>
                <?php if($buying==1) { ?>
                <ul <?php if($val['id']==$address_id) { ?>class="bg_color"<?php } ?> onclick="javascript:window.location.href='<?php echo $address_back_url;?>&address_id=<?php echo $val['id'];?>'">
                    <li class="add_li"><strong><?php echo $val['xm'];?></strong></li>
                    <li><?php echo $val['tel'];?></li>
                    <li class="add_li_font"><span><?php echo $val['area_str'];?></span></li>
                    <li class="add_li_font"><span><?php echo $val['info'];?></span></li>
                    <li style="display:none" class="def_add_id"></li>
                    <li class="bchange" >选择</li>
                    <?php if($val['id']==$address_id) { ?><span class="icon_address"></span><?php } ?>
                </ul>
                <?php } else { ?>
                <ul <?php if($val['id']==$address_id) { ?>class="bg_color"<?php } ?>>
                    <li class="add_li"><strong><?php echo $val['xm'];?></strong></li>
                    <li><?php echo $val['tel'];?></li>
                    <li class="add_li_font"><span><?php echo $val['area_str'];?></span></li>
                    <li class="add_li_font"><span><?php echo $val['info'];?></span></li>
                    <li style="display:none" class="def_add_id"></li>
                    <li class="edit" onclick="javascript:window.location.href='<?php echo $editUrl;?><?php echo $val['id'];?>&address_back_url=<?php echo $address_back_url_encode;?>'">编辑</li>
                    <?php if($val['default_id']==1) { ?><span class="icon_address"></span><?php } ?>
                </ul>
                <?php } ?>
            </div>
            <!-- item end -->
            <?php } ?>
        </div>
        <div class="margin_footer"></div>
    </div>
</div>
<div style="display: none;"><?php echo $tongchengConfig['tongji_code'];?></div>
<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
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
