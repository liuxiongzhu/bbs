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
<title>马甲中心 - <?php echo $__SitesInfo['name'];?></title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<script src="source/plugin/tom_tongcheng/images/jquery.min-2.1.3.js" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?></head>
<body>
<header class="header on tc-template__bg">
    <section class="wrap">
        <section class="sec-ico go-back" onclick="location.href='plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=personal';">返回</section>
        <h2>马甲中心</h2>
        <section class="sec-ico btn slide-btn tc-template__bg" style="background: #f5833b;">
            <a onclick="majiaLoginOut();" href="javascript:void(0);">退出</a>
        </section>
    </section>
</header>
<section class="mainer">
   <section class="wrap">
       <div class="tcui-cells" style="margin-top: 3.1em;">
            <?php if(is_array($tcmajiaList)) foreach($tcmajiaList as $key => $val) { ?>            <div class="tcui-cell" style="cursor: pointer;" onclick="majiaLogin(<?php echo $val['id'];?>);">
                <div class="tcui-cell__hd"><img src="<?php echo $val['picurl'];?>" alt="" style="width:20px;height: 20px;border-radius: 10px;margin-right:5px;display:block"></div>
                <div class="tcui-cell__bd">
                    <p><?php echo $val['nickname'];?>(UID:<?php echo $val['id'];?>)</p>
                </div>
                <div class="tcui-cell__ft"><?php if($val['id'] == $__UserInfo['id']  ) { ?><i class="tcui-icon-success"></i><?php } ?></div>
            </div>
            <?php } ?> 
        </div>
   </section>
</section>
<div id="hongbaoLogin" style="height:1px; width:1px;">
    <iframe style="border:0px;width:100%;height:100%"></iframe>
</div>
<div id="hongbaoLoginOut" style="height:1px; width:1px;">
    <iframe style="border:0px;width:100%;height:100%"></iframe>
</div>
<div id="kjiaLogin" style="height:1px; width:1px;">
    <iframe style="border:0px;width:100%;height:100%"></iframe>
</div>
<div id="kjiaLoginOut" style="height:1px; width:1px;">
    <iframe style="border:0px;width:100%;height:100%"></iframe>
</div>
<div id="ptuanLogin" style="height:1px; width:1px;">
    <iframe style="border:0px;width:100%;height:100%"></iframe>
</div>
<div id="ptuanLoginOut" style="height:1px; width:1px;">
    <iframe style="border:0px;width:100%;height:100%"></iframe>
</div>
<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<script>
function majiaLogin(majia_user_id){
    loading('处理中...');
    $.ajax({
        type: "GET",
        url: "<?php echo $loginUrl;?>",
        data: {majia_user_id:majia_user_id},
        success: function(msg){
            var data = eval('('+msg+')');
            if(data.status == 200){
                <?php if($showHongbaoIframe == 1  ) { ?>
                $("#hongbaoLogin iframe").attr("src", '<?php echo $hongbaoLoginUrl;?>' + majia_user_id);
                <?php } ?>
                <?php if($showKjiaIframe == 1  ) { ?>
                $("#kjiaLogin iframe").attr("src", '<?php echo $kjiaLoginUrl;?>' + majia_user_id);
                <?php } ?>
                <?php if($showPtuanIframe == 1  ) { ?>
                $("#ptuanLogin iframe").attr("src", '<?php echo $ptuanLoginUrl;?>' + majia_user_id);
                <?php } ?>
                loading(false);
                tusi("马甲切换成功");
                setTimeout(function(){window.location.href='plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=personal';},2888);
            }else{
                tusi("马甲切换失败");
                return false;
            }
        }
    });
}
function majiaLoginOut(){
    loading('处理中...');
    $.ajax({
        type: "GET",
        url: "<?php echo $loginOutUrl;?>",
        data: {a:1},
        success: function(msg){
            var data = eval('('+msg+')');
            if(data.status == 200){
                <?php if($showHongbaoIframe == 1  ) { ?>
                $("#hongbaoLoginOut iframe").attr("src", '<?php echo $hongbaoLoginOutUrl;?>');
                <?php } ?>
                <?php if($showHongbaoIframe == 1  ) { ?>
                $("#kjiaLoginOut iframe").attr("src", '<?php echo $kjiaLoginOutUrl;?>');
                <?php } ?>
                <?php if($showHongbaoIframe == 1  ) { ?>
                $("#ptuanLoginOut iframe").attr("src", '<?php echo $ptuanLoginOutUrl;?>');
                <?php } ?>
                loading(false);
                tusi("退出成功");
                setTimeout(function(){window.location.href='plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=personal';},2888);
            }else{
                tusi("退出失败");
                return false;
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