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
<title>搴楅摵鎼滅储 - <?php echo $__SitesInfo['name'];?></title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tcshop/images/shop_style.css?v=<?php echo $cssJsVersion;?>" />
<script src="source/plugin/tom_tcshop/images/jquery.min-2.1.3.js" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?></head>
<body id="shop_search">
<section class="shop_head tc-template__bg">
<div class="search-title">
    	搴楅摵鎼滅储
        <a href="javascript:;" onclick="history.back();" class="back"><i></i>杩斿洖</a>
        <a href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=ruzhu&amp;prand=<?php echo $prand;?>" class="ruzhu">鍟嗗鍏ラ┗</a>
    </div>
</section>
<section class="search-head tc-template__bg">
<div class="search-form">
    	<form onSubmit="return false;" id="search_form">
        	<div class="search_box">
        		<input type="text" id="keyword" name="keyword" placeholder="璇疯緭鍏ュ簵閾哄叧閿瘝">
                <i class="id_clear_btn"></i>
            </div>
            <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
            <button class="id_search_btn tc-template__color">鎼滅储</button>
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
    </div>
</section>
<section class="search_recom">
<h5>澶у閮藉湪鎼�</h5>
    <div class="recom-list clearfix">
        <?php if(is_array($resouList)) foreach($resouList as $key => $val) { ?>        <span><a href="<?php echo $val['url'];?>"><?php echo $val['keywords'];?></a></span>
        <?php } ?>
    </div>
</section>
<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<script src="//api.map.baidu.com/api?v=2.0&ak=<?php echo $tcshopConfig['baidu_js_ak'];?>" type="text/javascript"></script>
<script>
$(document).ready(function(){
   $.get("<?php echo $ajaxCommonClicksUrl;?>");
});

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
    wx.getLocation({
        type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
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