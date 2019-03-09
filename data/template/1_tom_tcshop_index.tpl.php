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
<title><?php echo $tcshopConfig['plugin_name'];?> - <?php echo $__SitesInfo['name'];?></title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tcshop/images/iconfont/iconfont.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tcshop/images/shop_style.css?v=<?php echo $cssJsVersion;?>" />
<link href="source/plugin/tom_tongcheng/images/swiper.min.css" rel="stylesheet" />
<script src="source/plugin/tom_tcshop/images/jquery.min-2.1.3.js" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/swiper.min.js" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/global.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?><style>
.swiper-pagination-bullet-active{ background:<?php echo $tongchengConfig['template_color'];?>}
</style>
</head>
<body id="shop_index">
<section class="shop_foucs">
<?php if($focuspicList) { ?>
   <div class="swiper-container swiper-container-focuspic">
       <?php if($tcshopConfig['index_search_type'] == 1) { ?>
        <section class="new_search_box clearfix">
            <div class="search_box">
                <a href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=search">
                    <form onSubmit="return false;">
                    <input type="text" readonly="readonly"  value="" placeholder="搜店铺">
                    <div class="search_button"><i class="tciconfont tcicon-sousuo"></i></div>
                    </form>
                </a>
            </div>
        </section>
       <?php } ?>
        <div class="swiper-wrapper">
            <?php if(is_array($focuspicList)) foreach($focuspicList as $key => $val) { ?>            <div class="swiper-slide">
                <a href="<?php echo $val['link'];?>"><img src="<?php echo $val['picurl'];?>" width="100%"></a>
            </div>
            <?php } ?>
        </div>
        <div class="swiper-pagination swiper-pagination-focuspic"></div>
    </div>
   <?php } ?>
</section>
<?php if($tcshopConfig['index_search_type'] == 2) { ?>
<form onSubmit="return false;" id="search_form">
<section class="index-search-box">
    <section class="index-search-box__hd tc-template__border">
        <i class="shadow"></i>
        <input type="text" id="keyword" name="keyword" placeholder="请输入店铺关键词">
    </section>
    <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
    <section class="index-search-box__bd id_search_btn tc-template__bg">搜索</section>
</section>
</form>
<script>
$(".id_search_btn").click( function (){ 
    $.ajax({
        type: "GET",
        url: "<?php echo $searchUrl;?>",
        data: $('#search_form').serialize(),
        success: function(msg){
            window.location = msg;
        }
    });
});
$(".id_clear_btn").click( function (){ 
    $("#keyword").val("");
});
</script>
<?php } ?>
<section class="shop_nav" style="margin-top: -2px;">
<section class="nav-li swiper-container swiper-container-nav">
        <div class="swiper-wrapper">
            <ul class="swiper-slide">
            <?php if(is_array($navList)) foreach($navList as $key => $val) { ?>                <li>
                    <a href="<?php echo $val['link'];?>">
                      <section class="nav-li-pic">
                            <img src="<?php echo $val['picurl'];?>?v=1"/>
                      </section>
                      <p><?php echo $val['title'];?></p>
                    </a>
                </li>
                <?php if(($navCount> 10 && $val['i'] == 10) || ($navCount> 20 && $val['i'] == 20) || ($navCount> 30 && $val['i'] == 30) || ($navCount> 40 && $val['i'] == 40) ) { ?>
                </ul>
                <ul class="swiper-slide">
                <?php } ?>
            <?php } ?> 
            </ul>
        </div>
        <?php if($navCount> 10  ) { ?>
        <div class="swiper-pagination swiper-pagination-nav" style="bottom: 5px;"></div>
        <?php } ?>
        <section class="clear"></section>
    </section>
</section>
<section class="shop_headlines">
    <div class="shop_headlines-title">商圈<span>头条</span></div>
<div class="shop_headlines-list id-index-scroll-ad">
    	<ul>
            <?php if(is_array($newTcshopList)) foreach($newTcshopList as $key => $val) { ?>        	<li><font color="<?php echo $tongchengConfig['template_color'];?>"><?php echo $val['name'];?></font> 入驻成功</li>
            <?php } ?>
        </ul>
    </div>
    <div class="shop_headlines-ruzhu"><a class="tc-template__bg" href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=ruzhu&amp;prand=<?php echo $prand;?>">立即入驻</a></div> 
</section>
<section class="shop_list">
<div class="shop_list-menu">
    	<div class="list-menu"><a <?php if($tab == 1 ) { ?>class="on tc-template__color tc-template__border"<?php } ?> href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=index&amp;tab=1">推荐</a></div>
    	<div class="list-menu"><a <?php if($tab == 2 ) { ?>class="on tc-template__color tc-template__border"<?php } ?> href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=index&amp;tab=2">新入</a></div>
    	<div class="list-menu"><a <?php if($tab == 3 ) { ?>class="on tc-template__color tc-template__border"<?php } ?> href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=index&amp;tab=3">附近</a></div>
    </div>
    <div class="list-item" id="index-list"></div>
    <div class="list-msg" style="display: none;" id="load-html">加载中...</div>
    <div class="list-msg" style="display: none;" id="no-load-html">没有更多商家</div>
    <div class="list-msg" style="display: none;" id="no-list-html">没有相关商家</div>
</section><?php include template('tom_tcshop:footer'); ?><div style="display: none;"><?php echo $tongchengConfig['tongji_code'];?></div>
<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<script src="//api.map.baidu.com/api?v=2.0&ak=<?php echo $tcshopConfig['baidu_js_ak'];?>" type="text/javascript"></script>
<script>
$(document).ready(function(){
   $.get("<?php echo $ajaxCommonClicksUrl;?>");
});

var scrollRunStatus = 0;
$(window).scroll(function () {
    var runScrollTop       = $(this).scrollTop();
    if(runScrollTop > 100 && scrollRunStatus == 0){
       scrollRunStatus = 1;
       console.log('runScrollTop:'+runScrollTop);
       $.get("<?php echo $ajaxAddLbsUrl;?>");
       $.get("<?php echo $ajaxAutoClickUrl;?>");
       $.get("<?php echo $ajaxAutoZhuanfaUrl;?>");
       $.get("<?php echo $ajaxUpdateTopstatusUrl;?>");
       $.get("<?php echo $ajaxUpdateVipLevelUrl;?>");
       $.get("<?php echo $ajaxUpdateBaseLevelUrl;?>");
    }
});
    
$(document).ready(function(){
    var swiper1 = new Swiper('.swiper-container-nav', {
        pagination: '.swiper-pagination-nav',
        paginationClickable: true,
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: 5000,
        autoplayDisableOnInteraction: false
    });
    <?php if($focuspicList) { ?>
    var swiper2 = new Swiper('.swiper-container-focuspic', {
        pagination: '.swiper-pagination-focuspic',
        paginationClickable: true,
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: 2500,
        autoplayDisableOnInteraction: false
    });
    <?php } ?>
});

var loadPage = 1;
function indexLoadList(){
    loadPage = 1;
    loadList(1);
}

var loadListStatus = 0;
function loadList(Page) {
    if(loadListStatus == 1){
        return false;
    }
    loadListStatus = 1;
    $("#index-list").html('');
    $("#load-html").show();
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxIndexLoadListUrl;?>",
        data: {page:Page},
        success: function(msg){
            loadListStatus = 0;
            var data = eval('('+msg+')');
            if(data == 205){
                $("#no-list-html").show();
                return false;
            }else{
                loadPage += 1;
                $("#index-list").html(data);
            }
        }
    });
}

$(document).ready(function(){
   indexLoadList();
});

$(window).scroll(function () {
    var scrollTop       = $(this).scrollTop();
    var scrollHeight    = $(document).height();
    var windowHeight    = $(this).height();
    if ((scrollTop + windowHeight) >= (scrollHeight * 0.9)) {
        scrollLoadList();
    }
});

function scrollLoadList() {
    if(loadListStatus == 1){
        return false;
    }
    if(loadPage > 50){
        return false;
    }
    $('#load-html').show();
$('#no-load-html').hide();
    loadListStatus = 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxIndexLoadListUrl;?>",
        data: {page:loadPage},
        success: function(msg){
            loadListStatus = 0;
            var data = eval('('+msg+')');
            if(data == 205){
                loadListStatus = 1;
                $('#load-html').hide();
                $('#no-load-html').show();
                return false;
            }else{
                loadPage += 1;
                $('#load-html').hide();
                $("#index-list").append(data);
            }
        }
    });
}

$(function() {
    setInterval(function() {
        var e = $(".id-index-scroll-ad ul");
        e.scrollTo({
            to: e.find("li").eq(0).height(),
            durTime: 800,
            delay: 80,
            callback: function() {
                var a = e.find("li").eq(0),
                i = a.clone(!0);
                e.scrollTop(0),
                a.remove(),
                e.append(i)
            }
        })
    },
    2e3)
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
      'onMenuShareAppMessage',
      'onMenuShareQQ',
      'previewImage',
      'openLocation', 
      'getLocation'
    ]
});
wx.ready(function () {
    wx.getLocation({
        type: 'wgs84', // Ĭ��Ϊwgs84��gps���꣬���Ҫ����ֱ�Ӹ�openLocation�õĻ������꣬�ɴ���'gcj02'
        success: function(res) {
            var point = new BMap.Point(res.longitude, res.latitude);
            var convertor = new BMap.Convertor();
            var pointArr = [];
            pointArr.push(point);
            convertor.translate(pointArr, 1, 5, function(data) {
                if (data.status === 0) {
                    $.get("<?php echo $ajaxUpdateLbsUrl;?>&latitude="+data.points[0].lat+"&longitude="+data.points[0].lng);
                } else {
                    $.get("<?php echo $ajaxUpdateLbsUrl;?>&latitude="+res.latitude+"&longitude="+res.longitude);
                }
            });
        }
    });
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
<?php if($__IsWeixin == 0) { include template('tom_tcshop:baidu_location'); ?><script>
function getLocation(){
    <?php if($tongchengConfig['open_moblie_https_location'] == 1) { ?>
    h5Geolocation();
    <?php } else { ?>
    wapGeolocation();
    <?php } ?>
}
getLocation();
</script>
<?php } ?>
</body>
</html>