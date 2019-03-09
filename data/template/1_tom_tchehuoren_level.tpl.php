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
<title>升级合伙人等级</title>
<link rel="stylesheet" href="source/plugin/tom_tchehuoren/images/weui.css"/>
<link rel="stylesheet" href="source/plugin/tom_tchehuoren/images/style.css"/>
<script src="source/plugin/tom_tchehuoren/images/jquery.min-2.1.3.js" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tchehuoren/images';
</script>
<script src="source/plugin/tom_tchehuoren/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?></head>
<body>
<section class="header tc-template__bg">
<a class="back" href="plugin.php?id=tom_tchehuoren&amp;site=<?php echo $site_id;?>&amp;mod=index"><i class="bk"></i>返回</a>
<h5>升级合伙人等级</h5>
</section>
<section class="level_box">
<table class="level_list">
        <?php if(is_array($levelArr)) foreach($levelArr as $key => $value) { ?><tr>
            <?php if(is_array($value)) foreach($value as $k => $v) { ?><td><?php echo $v;?></td>
            <?php } ?>
</tr>
        <?php } ?>
</table>
<div class="level_pormpt">
<p class="text">
            <span class="red">注：X</span>&nbsp;代表没有权限,
            <span class="yuan"></span>&nbsp;代表根据具体活动来进行分配
        </p>
</div>
    <?php if($tchehuorenInfo['kaohe_time'] > 0) { ?>
    <section class="level_expire">您的<span class="red"><?php echo $myDengjiInfo['name'];?></span>于<span class="red"><?php echo $kaoheStartTime;?></span>至<span class="red"><?php echo $kaoheEndTime;?></span>期间考核。</section>
    <?php } ?>
    <section class="level_explain"><?php echo $dengji_desc;?></section>
</section>
<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<script type="text/javascript">
var onSubmitStatus = 0;
function up_level(id){
    if(onSubmitStatus == 1){
        return false;
    }
    onSubmitStatus = 1;
    $.ajax({
        type: "POST",
        url: "<?php echo $ajaxUrl;?>",
        dataType : "json",
        data: {act:'up_level',dengji_id:id},
        success: function(data){
            loading(false);
            if(data.status == 200) {
                tusi("申请成功");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 301){
                tusi("月收入不能低于￥"+data.money);
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 302){
                tusi("异常错误");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 303){
                tusi("请勿重复提交申请，请等待");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else{
                tusi("异常错误");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
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