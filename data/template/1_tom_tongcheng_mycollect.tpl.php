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
<title>我的点赞 - <?php echo $__SitesInfo['name'];?></title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/iconfont/iconfont.css?v=<?php echo $cssJsVersion;?>" />
<script src="source/plugin/tom_tongcheng/images/jquery.min-2.1.3.js" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?></head>
<body>
<?php if($__HideHeader == 0 ) { ?>
<header class="header on tc-template__bg"> 
   <section class="wrap">
       <section class="sec-ico go-back" onclick="history.back();">返回</section>
        <h2>我的点赞</h2>
   </section>
</header>
<?php } ?>
<section class="mainer">
   <section class="wrap">
        <section class="tc-sec">
             <section class="tc-sec mt0">
                  <?php if(is_array($collectList)) foreach($collectList as $key => $val) { ?>                  <div class="tcline-item" style="border-bottom: 0px solid #eee;">
                       <div class="avatar-label">
                            <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=home&amp;uid=<?php echo $val['userInfo']['id'];?>"><img src="<?php echo $val['userInfo']['picurl'];?>" class="avatar" /></a>
                       </div>
                       <div class="tcline-detail">
                            <span class="tc-template__bg"><a class="tc-template__bg" href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=list&amp;type_id=<?php echo $val['typeInfo']['id'];?>"><?php echo $val['typeInfo']['name'];?></a></span>&nbsp; 
                            <a class="username" href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=home&amp;uid=<?php echo $val['userInfo']['id'];?>"><?php echo $val['userInfo']['nickname'];?></a>
                            <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=info&amp;tongcheng_id=<?php echo $val['tongchengInfo']['id'];?>" class="ext-act"><img src="source/plugin/tom_tongcheng/images/icon-show.png" style="width: 12px;"> 详情 </a>
                            <article data-id="nwa3egex5l">
                                 <p><?php echo $val['tongchengInfo']['content'];?></p>
                            </article>
                       </div>
                  </div>
                  <div class="group-top-tip clear text-center">点赞于<?php echo dgmdate($val[add_time], 'u');?></div>
                  <?php } ?> 
             </section>
        </section>
       <div class="pages clearfix">
            <ul class="clearfix">
              <li style="width: 40%;"><?php if($page > 1) { ?><a class="tc-template__color tc-template__border" href="<?php echo $prePageUrl;?>">上一页</a><?php } else { ?><span>上一页</span><?php } ?></li>
              <li style="width: 20%;"><span><?php echo $page;?>/<?php echo $allPageNum;?></span></li>
              <li style="width: 40%;"><?php if($showNextPage == 1) { ?><a class="tc-template__color tc-template__border" href="<?php echo $nextPageUrl;?>">下一页</a><?php } else { ?><span>下一页</span><?php } ?></li>
          </ul>
        </div>
   </section>
</section><?php include template('tom_tongcheng:footer'); ?><script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<script type="text/javascript">
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