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
<title>我的关注 - <?php echo $__SitesInfo['name'];?></title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tcshop/images/iconfont/iconfont.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tcshop/images/shop_style.css?v=<?php echo $cssJsVersion;?>" />
<script src="source/plugin/tom_tcshop/images/jquery.min-2.1.3.js" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/layer_mobile/layer.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?></head>
<body>
<?php if($__HideHeader == 0 ) { ?>
<header class="header on tc-template__bg">
   <section class="wrap">
        <section class="sec-ico go-back" onclick="history.back();">返回</section>
        <h2>我的关注</h2>
   </section>
</header>
<?php } ?>
<section class="mainer">
   <section class="wrap">
        <section class="shop_list" style="<?php if($__HideHeader == 1 ) { ?>margin-top: 0px;<?php } ?>">
            <div class="list-item">
                <?php if(is_array($guanzuList)) foreach($guanzuList as $key => $val) { ?>                <div class="item-box clearfix">
                    <div class="item-pic" style="width: 70px;height: 70px;"><a href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=details&amp;tcshop_id=<?php echo $val['tcshop_id'];?>"><img src="<?php echo $val['tcshopInfo']['picurl'];?>"></a></div>
                    <div class="item-content">
                        <div class="content">
                            <h5 style="margin-top: 2px;">
                                <a href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=details&amp;tcshop_id=<?php echo $val['tcshop_id'];?>"><?php echo $val['tcshopInfo']['name'];?></a>
                            </h5>
                            <p class="nr" style="margin-top: 10px;color: #999;font-size:0.85em;"><i class="tciconfont tcicon-dingwei_shi"></i><?php echo $val['tcshopInfo']['address'];?></p>
                        </div>
                    </div>
                </div>
                <section class="btn-group">
                    <a class="" href="javascript:void(0);" onclick="cancleGuanzu(<?php echo $__UserInfo['id'];?>,<?php echo $val['tcshop_id'];?>);" style="min-width: 10em;">取消关注</a>
                </section>
                <?php } ?>
            </div>
        </section>
       <div class="pages clearfix">
            <ul class="clearfix">
              <li style="width: 40%;"><?php if($page > 1) { ?><a class="tc-template__border tc-template__color" href="<?php echo $prePageUrl;?>">上一页</a><?php } else { ?><span>上一页</span><?php } ?></li>
              <li style="width: 20%;"><span><?php echo $page;?>/<?php echo $allPageNum;?></span></li>
              <li style="width: 40%;"><?php if($showNextPage == 1) { ?><a class="tc-template__border tc-template__color" href="<?php echo $nextPageUrl;?>">下一页</a><?php } else { ?><span>下一页</span><?php } ?></li>
          </ul>
        </div>
   </section>
</section><?php include template('tom_tcshop:footer'); ?><script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
   $.get("<?php echo $ajaxCommonClicksUrl;?>");
});

var submintPayStatus = 0;
function cancleGuanzu(user_id, tcshop_id){
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxUpdateGuanzuUrl;?>",
        data: "user_id="+user_id+"&tcshop_id="+tcshop_id,
        success: function(msg){
            var msg = $.trim(msg);
            if(msg == '100'){
                tusi("已经取消关注");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else{
                tusi("关注失败");
            }
        }
    });
}

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
      'previewImage',
      'openLocation', 
      'getLocation'
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