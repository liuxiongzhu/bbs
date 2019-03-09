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
<title>我的钱包</title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/money.css?v=<?php echo $cssJsVersion;?>" type="text/css">
<script src="source/plugin/tom_tongcheng/images/jquery.min-2.1.3.js" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?></head>
<body class="body-white">
<?php if($__HideHeader == 0 ) { ?>
<header class="header on tc-template__bg">
    <section class="wrap">
        <section class="sec-ico go-back" onclick="location.href='plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=personal';">返回</section>
        <h2>我的钱包</h2>
    </section>
</header>
<?php } ?>
<section class="mainer">
    <section class="wrap">
        
        <div class="balanceMain border horizonBottom">
            <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=moneylog">
                <div class="balanceBanner">
                    <div class="detail">
                    余额明细
                        <div class="arrow">
                            <i class="hmFi icon-arrowright"></i>
                        </div>
                    </div>
                </div>
                <div class="balance"><?php echo $__UserInfo['money'];?>元</div>
                <div class="balanceFrozen">已提现款项：<?php echo $__UserInfo['tixian_money'];?>元</div>
            </a>
        </div>
        
        <section class="page_rgs">
            <section class="btn-group">
                <input style="width: 80%;" onclick="location.href='plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=moneytixian';" type="button" class="tcui-btn tcui-btn_primary tc-template__bg" value="申请提现">
            </section>
        </section>
        <div class="recordMain" id="list">
            <?php if(is_array($moneylogList)) foreach($moneylogList as $key => $val) { ?>            <div class="balanceItem">
                <div class="time"><?php echo dgmdate($val[log_time], 'u');?></div>
                <div class="type"><?php echo $val['tag'];?></div>
                <div class="amount">￥<?php echo $val['change_money'];?><span>元</span></div>
                <div class="status">
                <?php if($val['type_id'] == 1) { ?>
                    <?php if($val['tixianInfo']['status'] == 1) { ?>待审核<?php } ?>
                    <?php if($val['tixianInfo']['status'] == 2) { ?>已经转账<?php } ?>
                <?php } ?>
                </div>
            </div>
            <?php } ?>
        </div>
        
    </section>
</section>
<script>

</script>
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