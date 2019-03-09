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
<title>店铺筛选 - <?php echo $__SitesInfo['name'];?></title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tcshop/images/iconfont/iconfont.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tcshop/images/shop_style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tcshop/images/list-nav.css?v=<?php echo $cssJsVersion;?>" />
<script src="source/plugin/tom_tcshop/images/jquery.min-2.1.3.js" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?><style>
.tc-list-top-filter li .active{ color:<?php echo $tongchengConfig['template_color'];?>}
</style>
</head>
<body id="shop_list">
<div class="alsh-all" style="padding-bottom:0;<?php if($__HideHeader == 1 ) { ?>padding-top: 3em;<?php } ?>" >
    <div class="tc-list-top-filter-fixed">
        <?php if($__HideHeader == 0 ) { ?>
        <div class="Se_nav d-flex tc-template__bg">
            <div class="SeBack" style="width:50px;"><a onclick="history.back();" style="display:block;height:100%;"><i></i></a></div>
            <div class="SeTitle flex">店铺筛选</div>
            <div class="SeMore temp-post-info" style="width:50px;"><a href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=ruzhu&amp;prand=<?php echo $prand;?>">入驻</a></div>
        </div>
        <?php } ?>
        <ul class="tc-list-top-filter">
            <li>
                <a class="id-area" href="javascript:void(0);">
                    <i class="id-area-txt tc-list-top-filter-f"><?php if($street_id > 0  ) { ?><?php echo $streetInfo['name'];?><?php } elseif($area_id > 0) { ?><?php echo $areaInfo['name'];?><?php } else { ?>区域<?php } ?></i><em class="tc-list-top-triangle tciconfont tcicon-jiantou__xia "></em>
                </a>
            </li>
            <li>
                <a class="id-cate" href="javascript:void(0);">
                    <i class="id-cate-txt tc-list-top-filter-f"><?php if($cate_child_id > 0  ) { ?><?php echo $cateChildInfo['name'];?><?php } elseif($cate_id > 0) { ?><?php echo $cateInfo['name'];?><?php } else { ?>类别<?php } ?></i><em class="tc-list-top-triangle tciconfont tcicon-jiantou__xia "></em>
                </a>
            </li>
            <li>
                <a class="id-ordertype" href="javascript:void(0);">
                    <i class="id-ordertype-txt tc-list-top-filter-f">
                        <?php if($ordertype == 'new' ) { ?>最新<?php } elseif($ordertype == 'lbs') { ?>附近<?php } else { ?>排序<?php } ?>
                    </i><em class="tc-list-top-triangle tciconfont tcicon-jiantou__xia "></em>
                </a>
            </li>
        </ul>
    </div>
    <div class="id-list-div tc-list-filter-area-fixed dn" <?php if($__HideHeader == 1 ) { ?>style="padding-top: 3em;"<?php } ?>>
        <ul class="id-areadiv tc-list-filter tc-list-filter-area dn" style="float: left;">
            <li class="item" data-id="0" data-name="全部">全部</li>
            <?php if(is_array($areaList)) foreach($areaList as $key => $val) { ?>            <li class="item" data-id="<?php echo $val['id'];?>" data-name="<?php echo $val['name'];?>"><?php echo $val['name'];?></li>
            <?php } ?>
        </ul>
        <ul class="id-streetdiv tc-list-filter tc-list-filter-area dn width50" style="float: left;max-height: 400px;background-color: #eaeaea;">
        </ul>
        <ul class="id-catediv tc-list-filter tc-list-filter-area dn" style="float: left;">
            <li class="item" data-id="0" data-name="全部">全部</li>
            <?php if(is_array($cateList)) foreach($cateList as $key => $val) { ?>            <li class="item" data-id="<?php echo $val['id'];?>" data-name="<?php echo $val['name'];?>"><?php echo $val['name'];?></li>
            <?php } ?>
        </ul>
        <ul class="id-catechilddiv tc-list-filter tc-list-filter-area dn width50" style="float: left;background: #eaeaea;">
        </ul>
        <ul class="id-ordertypediv tc-list-filter tc-list-filter-area dn">
            <li class="item" data-id="null" data-name="默认排序">默认排序</li>
            <li class="item" data-id="new" data-name="最新加入">最新加入</li>
            <li class="item" data-id="lbs" data-name="附近商家">附近商家</li>
        </ul>
    </div>
</div>
<section class="shop_list" style="margin-top: 0px;">
    <div class="list-item" id="list-list"></div>
    <div class="list-msg" id="load-html">加载中...</div>
    <div class="list-msg" style="display: none;" id="no-load-html">没有更多商家</div>
    <div class="list-msg" style="display: none;" id="no-list-html">没有相关商家</div>
</section><?php include template('tom_tcshop:footer'); ?><div style="display: none;"><?php echo $tongchengConfig['tongji_code'];?></div>
<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<script src="//api.map.baidu.com/api?v=2.0&ak=<?php echo $tcshopConfig['baidu_js_ak'];?>" type="text/javascript"></script>
<script>
$(document).ready(function(){
   $.get("<?php echo $ajaxCommonClicksUrl;?>");
});
    
var pageIndex = 1;
$(document).ready(function(){
    loadList("<?php echo $cate_id;?>","<?php echo $cate_child_id;?>","<?php echo $city_id;?>","<?php echo $area_id;?>","<?php echo $street_id;?>",'<?php echo $keyword;?>','<?php echo $tabs;?>','<?php echo $ordertype;?>',pageIndex);
});
$(window).scroll(function () {
    var scrollTop       = $(this).scrollTop();
    var scrollHeight    = $(document).height();
    var windowHeight    = $(this).height();
    if ((scrollTop + windowHeight) >= (scrollHeight * 0.9)) {
        loadList("<?php echo $cate_id;?>","<?php echo $cate_child_id;?>","<?php echo $city_id;?>","<?php echo $area_id;?>","<?php echo $street_id;?>",'<?php echo $keyword;?>','<?php echo $tabs;?>','<?php echo $ordertype;?>',pageIndex);
    }
});
var loadListStatus = 0;
function loadList(cateId,cateChildId,cityId,areaId,streetId,Keyword,tabs,orderType,Page) {
    if(pageIndex > 50){
        $("#no-more-html").show();
    }
    if(loadListStatus == 1){
        return false;
    }
    loadListStatus = 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxLoadListUrl;?>",
        data: { cate_id:cateId,cate_child_id:cateChildId,city_id:cityId,area_id:areaId,street_id:streetId,keyword:Keyword,tabs:tabs,ordertype:orderType,page:Page},
        success: function(msg){
            $("#load-html").hide();
            if(pageIndex == 1){
                $("#list-list").html('');
            }
            loadListStatus = 0;
            var data = eval('('+msg+')');
            if(data == 205){
                if(pageIndex == 1){
                    $("#no-list-html").show();
                }else{
                    $("#no-more-html").show();
                }
                return false;
            }else{
                pageIndex += 1;
                $("#list-list").append(data);
            }
        }
    });
}
</script><?php include template('tom_tcshop:list_nav'); ?><script>
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