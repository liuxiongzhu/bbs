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
<title>金币变动日志 - <?php echo $__SitesInfo['name'];?></title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/iconfont/iconfont.css?v=<?php echo $cssJsVersion;?>" />
<script src="source/plugin/tom_tongcheng/images/jquery.min-2.1.3.js" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?></head>
<body>
<header class="header on tc-template__bg">
   <section class="wrap">
       <section class="sec-ico go-back" onclick="history.back();">返回</section>
        <h2>金币变动日志</h2>
   </section>
</header>
<section class="mainer">
    <div class="tcui-cells__title" style="margin-top: 55px;">
        <section style="padding:10px;background: #eff9ff;line-height:1.5;letter-spacing: 1px;">
           <?php if($tongchengConfig['open_top_score_pay'] == 1 ) { ?>
           <p class="tc-template__color" style="color:#f8a543">金币可以用于发布、置顶、刷新信息时抵扣现金（<?php echo $tongchengConfig['pay_score_yuan'];?>金币=1元）</p>
           <?php } else { ?>
           <p class="tc-template__color" style="color:#f8a543">金币可以用于发布、刷新信息时抵扣现金（<?php echo $tongchengConfig['pay_score_yuan'];?>金币=1元）</p>
           <?php } ?>
        </section>
    </div>
    <section class="wrap">
        <div class="myorder clearfix">
        <section>
            <ul class="clearfix">
                <?php if(is_array($scorelogList)) foreach($scorelogList as $key => $val) { ?>            	<li>
                    <?php if($val['log_type'] == 1  ) { ?>商家入驻获得<?php } ?>
                    <?php if($val['log_type'] == 2  ) { ?>商家置顶获得<?php } ?>
                    <?php if($val['log_type'] == 3  ) { ?>商家升级获得<?php } ?>
                    <?php if($val['log_type'] == 4  ) { ?>发布信息消耗<?php } ?>
                    <?php if($val['log_type'] == 5  ) { ?>刷新信息消耗<?php } ?>
                    <?php if($val['log_type'] == 6  ) { ?>信息奖励<?php } ?>
                    <?php if($val['log_type'] == 7  ) { ?>抢购商品获取<?php } ?>
                    <?php if($val['log_type'] == 8  ) { ?>后台增加金币<?php } ?>
                    <?php if($val['log_type'] == 9  ) { ?>后台减少金币<?php } ?>
                    <?php if($val['log_type'] == 10  ) { ?>新用户奖励<?php } ?>
                    <?php if($val['log_type'] == 11  ) { ?>拼单商品获取<?php } ?>
                    <?php if($val['log_type'] == 12  ) { ?>减价商品获取<?php } ?>
                    <?php if($val['log_type'] == 13  ) { ?>入驻114获取<?php } ?>
                    <?php if($val['log_type'] == 14  ) { ?>续费114获取<?php } ?>
                    <?php if($val['log_type'] == 15  ) { ?>开通VIP获取<?php } ?>
                    <?php if($val['log_type'] == 16  ) { ?>特权商家消费获取<?php } ?>
                    <?php if($val['log_type'] == 17  ) { ?>商城消费获取<?php } ?>
                    <?php if($val['log_type'] == 18  ) { ?>置顶信息消耗<?php } ?>
                    <?php if($val['log_type'] == 19  ) { ?>打赏作者获取<?php } ?>
                    <?php if($val['log_type'] == 20  ) { ?>付费阅读获取<?php } ?>
                    &nbsp;<font color="#f60"><?php echo $val['score_value'];?></font>&nbsp;金币<span><?php echo dgmdate($val[log_time], 'u');?></span>
                </li>
                <?php } ?> 
            </ul>
        </section>
        <div class="pages clearfix">
            <ul class="clearfix">
              <li><?php if($page > 1) { ?><a class="tc-template__color tc-template__border" href="<?php echo $prePageUrl;?>">上一页</a><?php } else { ?><span>上一页</span><?php } ?></li>
              <li><?php if($showNextPage == 1) { ?><a class="tc-template__color tc-template__border" href="<?php echo $nextPageUrl;?>">下一页</a><?php } else { ?><span>下一页</span><?php } ?></li>
          </ul>
        </div>
    </div>
    </section>
</section><?php include template('tom_tongcheng:footer'); ?><script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
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