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
<title>余额明细</title>
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
        <section class="sec-ico go-back" onclick="location.href='plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=money';">返回</section>
        <h2>余额明细</h2>
    </section>
</header>
<?php } ?>
<section class="mainer">
    <section class="wrap">
        <?php if($moneylogList) { ?>
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
        <?php } else { ?>
        <div class="recordMain noData"><img src="source/plugin/tom_tongcheng/images/money_log_none.png"><br/>暂无余额变动记录</div>
        <?php } ?>
        <div class="pages clearfix" style="margin-bottom: 80px;">
            <ul class="clearfix">
              <li><?php if($page > 1) { ?><a class="tc-template__border tc-template__color" href="<?php echo $prePageUrl;?>">上一页</a><?php } else { ?><span>上一页</span><?php } ?></li>
              <li><?php if($showNextPage == 1) { ?><a class="tc-template__border tc-template__color" href="<?php echo $nextPageUrl;?>">下一页</a><?php } else { ?><span>下一页</span><?php } ?></li>
          </ul>
        </div>
        <div class="totalAmount">
            <div class="menu">
                <div class="menuBtn">款项筛选</div>
                    <div class="menuList">
                        <ul>
                            <li data-type="all">全 部 款 项</li>
                            <li data-type="1">已提现款项</li>
                            <li data-type="2">已收入款项</li>
                            <li data-type="3">已支出款项</li>
                            <li data-type="4">抢到的福利</li>
                        </ul>
                        <em></em>
                        <span></span> 
                    </div>
                </div>
                <div class="balance">余额(元)
                <div class="amount"><?php echo $__UserInfo['money'];?></div>
            </div>
        </div>
        
    </section>
</section>
<script>
$(function () {

    $(".totalAmount .balance").on('click', function () {
        location.href = 'plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=moneylog';
    });

    $(".totalAmount .menu").on("click", function () {
        $(this).find('.menuList').toggle();
    });

    $(".totalAmount .menu .menuList ul li").on("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        var _type = $(this).data('type');
        if (_type) {
            location.href = 'plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=moneylog&type_id=' + _type;
        }
    });
});
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