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
<title><?php echo $hbUserInfo['nickname'];?>的福利</title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tchongbao/images/hb_style.css?v=<?php echo $cssJsVersion;?>" />
<script src="source/plugin/tom_tongcheng/images/jquery-1.8.3.min.js" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script>
</head>
<body class="body_loglist">
<?php if($show_my_hb == 1) { ?>
<section class="header-loglist">
    <div class="back"><a href="<?php echo $back;?>">返回</a></div>
    <div class="myhongbao">
        <img src="<?php echo $hbUserInfo['picurl'];?>">
        <p><?php echo $hbUserInfo['nickname'];?>的福利</p>
        <p class="price"><span><?php echo $tchongbaoLogInfo['money'];?></span>元</p>
        <p class="hb_prompt"><a href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=money">已存入钱包，申请提现</a></p>
    </div>
</section>
<?php } else { ?>
<section class="header-loglist">
    <div class="back"><a href="javascript:void(0);" onclick="javascript:history.go(-1);">返回</a></div>
    <div class="myhongbao">
        <img src="<?php echo $hbUserInfo['picurl'];?>">
        <p><?php echo $hbUserInfo['nickname'];?>的福利</p>
    </div>
</section>
<?php } ?>
<section class="loglist">
    <?php if($tchongbaoInfo['status'] == 1) { ?>
    <div class="loglist-title">已领取<?php echo $tchongbaoLogCount;?>/<?php echo $tchongbaoInfo['hb_count'];?>,共<?php echo $tchongbaoLogSumMoney;?>/<?php echo $tchongbaoInfo['all_money'];?>元</div>
    <?php } else { ?>
    <div class="loglist-title"><?php echo $tchongbaoInfo['hb_count'];?>,个福利，<?php echo $times;?>被抢光了</div>
    <?php } ?>
    <div class="loglist-list">
        <?php if($tchongbaoLogList) { ?>
        <ul>
            <?php if(is_array($tchongbaoLogList)) foreach($tchongbaoLogList as $key => $value) { ?>            <li>
                <div class="log-pic"><img src="<?php echo $value['user_picurl'];?>"></div>
                <div class="log-content">
                    <p><a href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=home&uid=<?php echo $value['user_id'];?>"><?php echo $value['nickname'];?></a> <span class="price"><?php echo $value['money'];?>元</span></p>
                    <p class="time"><?php echo dgmdate($value['log_time']);?></p>
                </div>
            </li>
            <?php } ?>
        </ul>
        <?php } else { ?>
        <div class="no-hb-ts">还没有人领取那，快去领取福利吧！</div>
        <?php } ?>
    </div>
</section>
<div class="site-float" style="font-size: 1em;">
    <span class="img-dialog" onclick="window.location.href='<?php echo $__TongchengHost;?>plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=money';" > 申请 <i></i> 提现 </span>
</div>    
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
      'onMenuShareAppMessage',
      'previewImage'
    ]
});
wx.ready(function () {
    wx.onMenuShareTimeline({
        title: '<?php echo $shareTitle;?>-<?php echo $__SitesInfo['name'];?>',
        link: '<?php echo $shareUrl;?>',
        imgUrl: '<?php echo $shareLogo;?>', 
        success: function () {
            
        },
        cancel: function () { 
        }
    });
    wx.onMenuShareAppMessage({
        title: '<?php echo $shareTitle;?>-<?php echo $__SitesInfo['name'];?>',
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
        title: '<?php echo $shareTitle;?>-<?php echo $__SitesInfo['name'];?>',
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

