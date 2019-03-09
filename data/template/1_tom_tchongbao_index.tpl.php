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
<title><?php echo $tchongbaoConfig['plugin_name'];?> - <?php echo $__SitesInfo['name'];?></title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/iconfont/iconfont.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tchongbao/images/hb_style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tcshop/images/yinru_shop_style.css?v=<?php echo $cssJsVersion;?>" />
<script src="source/plugin/tom_tongcheng/images/jquery.min-2.1.3.js" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?><style>
.tchb_header_index .tchb_option .tchb_area.on a:before{ background:<?php echo $tongchengConfig['template_color'];?>;}
</style>
</head>
<body class="tchb_index">
<header class="header on">
   <section class="wrap">
        <a class="sec-ico go-back" href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=index">返回</a>
        <h2>抢福利</h2>
        <a class="gueize" href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=mylist">塞福利</a>
   </section>
</header>
<div class="tchb_header_index">
    <div class="pic" style="position: relative;">
        <img src="<?php echo $tchongbaoConfig['top_pic'];?>">
        <div class="water" style="bottom:-10px">
            <div class="water-c">
                <div class="water-1"></div>
                <div class="water-2"></div>
            </div>
        </div>
    </div>
    <div class="tchb_option clearfix">
        <div class="tchb_area <?php if($tab == 1) { ?>on<?php } ?>"><a href="plugin.php?id=tom_tchongbao&amp;site=<?php echo $site_id;?>&amp;mod=index&amp;tab=1">全抢</a></div>
        <?php if($__ShowTcshop == 1 && $tchongbaoConfig['open_tcshop_tchongbao'] == 1) { ?>
        <div class="tchb_area <?php if($tab == 3) { ?>on<?php } ?>"><a href="plugin.php?id=tom_tchongbao&amp;site=<?php echo $site_id;?>&amp;mod=index&amp;tab=3">商家福利</a></div>
        <?php } ?>
        <div class="tchb_area <?php if($tab == 2) { ?>on<?php } ?>"><a href="plugin.php?id=tom_tchongbao&amp;site=<?php echo $site_id;?>&amp;mod=index&amp;tab=2">待抢</a></div>
    </div>
</div>
<section class="mainer">
    <section class="wrap" >
        <section class="tc-sec shop_list" style="margin-top:0;">
             <section class="tc-sec mt0 list-item" id="list-list"></section>
             <section class="tc-sec mt0 list-item" style="display: none;" id="loading">
                 <div class="tcui-loadmore" style="padding:1em"><i class="tcui-loading"></i><span class="tcui-loadmore__tips">正在加载...</span></div>
             </section>
             <section class="tc-sec mt0" style="display: none;" id="no-more-html">
                <div class="tcui-loadmore" style="padding:1em"><!--<i class="tcui-loading"></i>--><span class="tcui-loadmore__tips">没有更多信息...</span></div>
             </section>
            <section class="tc-sec mt0" style="display: none;" id="no-list-html">
                <div class="clear10" style="height:7em;"></div>
                  <div class="tcui-loadmore tcui-loadmore_line">
                       <span class="tcui-loadmore__tips">没有信息</span>
                  </div>
             </section>
        </section>
   </section>
</section><?php include template('tom_tchongbao:footer'); ?><script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<script>

var pageIndex = 1;
$(document).ready(function(){
    loadList(pageIndex);
});

$(window).scroll(function () {
    var scrollTop       = $(this).scrollTop();
    var scrollHeight    = $(document).height();
    var windowHeight    = $(this).height();
    if ((scrollTop + windowHeight) >= (scrollHeight * 0.9)) {
        loadList(pageIndex);
    }
});

var loadListStatus = 0;
function loadList(Page) {
    if(pageIndex > 50){
        $("#no-more-html").show();
    }
    if(loadListStatus == 1){
        return false;
    }
    $("#no-more-html").hide();
    $("#loading").show();
    loadListStatus = 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxLoadListUrl;?>",
        data: { page:Page},
        success: function(msg){
            if(pageIndex == 1){
                $("#list-list").html('');
            }
            loadListStatus = 0;
            var data = eval('('+msg+')');
            if(data == 205){
                $("#loading").hide();
                if(pageIndex == 1){
                    $("#no-list-html").show();
                }else{
                    $("#no-more-html").show();
                }
                return false;
            }else{
                $("#loading").hide();
                pageIndex += 1;
                $("#list-list").append(data);
            }
        }
    });
}

    
/* list js start */
function showPic(picurl,id){
    var photo_list = $("#photo_list_"+id).val();
    var picarr = photo_list.split('|');
    wx.previewImage({
        current: picurl,
        urls: picarr 
    });
}
/* list js end */
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