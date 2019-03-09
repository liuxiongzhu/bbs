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
<title><?php echo $shareTitle;?></title>
<meta name="keywords" content="<?php echo $shareTitle;?>" />
<meta name="description" content="<?php echo $shareDesc;?>" />
<link href="source/plugin/tom_tongcheng/images/swiper.min.css?v=<?php echo $cssJsVersion;?>" rel="stylesheet" />
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/iconfont/iconfont.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/jquery-popups.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/list-nav.css?v=<?php echo $cssJsVersion;?>" />
<script src="source/plugin/tom_tongcheng/images/jquery.min-2.1.3.js" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/swiper.min.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/global.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/jquery-popups.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?><style>
.tc-list-top-filter li .active{ color:<?php echo $tongchengConfig['template_color'];?>}
.noAllowCopy{-moz-user-select: none;-webkit-user-select: none;-ms-user-select: none;user-select: none;}
<?php if($__Android == 1) { ?>
.detail-tags span{padding-top: 3px;}
<?php } ?>
</style>
</head>
<body class="body-bg">
<?php if($modelInfo['is_sfc'] == 1) { if($__HideHeader == 0 ) { ?>
<div class="alsh-all" style="padding-top:3em;">
    <div class="tc-list-top-filter-fixed">
        <div class="Se_nav d-flex tc-template__bg">
            <div class="SeBack"><a onclick="history.back();"><i></i></a></div>
            <div class="SeTitle flex"><?php echo $title;?></div>
            <div class="SeMore temp-post-info"><a href="<?php echo $fabuUrl;?>">发布</a></div>
        </div>
    </div>
</div>
<?php } } else { ?>
<div class="alsh-all" <?php if($__HideHeader == 1 ) { ?>style="padding-top: 3em;"<?php } ?>>
    <div class="tc-list-top-filter-fixed">
        <?php if($__HideHeader == 0 ) { ?>
        <div class="Se_nav d-flex tc-template__bg">
            <div class="SeBack"><a onclick="history.back();"><i></i></a></div>
            <div class="SeTitle flex"><?php echo $title;?></div>
            <div class="SeMore temp-post-info"><a href="<?php echo $fabuUrl;?>">发布</a></div>
        </div>
        <?php } ?>
        <ul class="tc-list-top-filter">
            <li <?php if($modelInfo['area_select'] == 0  ) { ?>style="display: none;"<?php } ?>>
                <a class="id-area" href="javascript:void(0);">
                    <i class="id-area-txt tc-list-top-filter-f"><?php if($street_id > 0  ) { ?><?php echo $streetInfo['name'];?><?php } elseif($area_id > 0) { ?><?php echo $areaInfo['name'];?><?php } else { ?>区域<?php } ?></i><em class="tc-list-top-triangle tciconfont tcicon-jiantou__xia "></em>
                </a>
            </li>
            <li>
                <a class="id-model" href="javascript:void(0);">
                    <i  class="id-model-txt tc-list-top-filter-f"><?php if($model_id > 0  ) { ?><?php echo $modelInfo['name'];?><?php } else { ?>分类<?php } ?></i><em class="tc-list-top-triangle tciconfont tcicon-jiantou__xia"></em>
                </a>
            </li>
            <li>
                <a class="id-type" href="javascript:void(0);">
                    <i class="id-type-txt tc-list-top-filter-f"><?php if($cate_id > 0  ) { ?><?php echo $cateInfo['name'];?><?php } elseif($type_id > 0) { ?><?php echo $typeInfo['name'];?><?php } else { ?>类别<?php } ?></i><em class="tc-list-top-triangle tciconfont tcicon-jiantou__xia"></em>
                </a>
            </li>
            <li style="display: none;">
                <a class="id-ordertype" href="javascript:void(0);">
                    <i  class="id-ordertype-txt tc-list-top-filter-f">排序</i><em class="tc-list-top-triangle tciconfont tcicon-jiantou__xia"></em>
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
        <ul class="id-streetdiv tc-list-filter tc-list-filter-area dn width50" style="float: left;height: 75%;background-color: #eaeaea;">
        </ul>
        <ul class="id-modeldiv tc-list-filter tc-list-filter-area dn" style="float: left;">
            <?php if(is_array($modelList)) foreach($modelList as $key => $val) { ?>            <li class="item" data-id="<?php echo $val['id'];?>" data-name="<?php echo $val['name'];?>"><?php echo $val['name'];?></li>
            <?php } ?>
        </ul>
        <ul class="id-typediv tc-list-filter tc-list-filter-area dn" style="float: left;">
            <li class="item" data-id="0" data-name="全部">全部</li>
            <?php if(is_array($typeList)) foreach($typeList as $key => $val) { ?>            <li class="item" data-id="<?php echo $val['id'];?>" data-name="<?php echo $val['name'];?>"><?php echo $val['name'];?></li>
            <?php } ?>
        </ul>
        <ul class="id-catediv tc-list-filter tc-list-filter-area dn width50" style="float: left;background: #eaeaea;">
        </ul>
        <ul class="id-ordertypediv tc-list-filter tc-list-filter-area dn">
        </ul>
    </div>
</div>
<?php } ?>
<section class="mainer">
    <section class="wrap" style="padding-top: 10px;">
        <?php if($modelInfo['is_sfc'] == 1) { ?>
        <form class="sec-search tc-template__border flex" id="search_form" onsubmit="return false;" style="margin-bottom: 5px;">
            <section class="sfc-input dislay-flex">
                <div class="sfc-chufa flex"><input type="text" placeholder="出发地" name="chufa" value="<?php echo $sfcChufa;?>" /></div>
                <div class="wangfan"></div>
                <div class="sfc-mude flex"><input type="text" placeholder="目的地" name="mude" value="<?php echo $sfcMude;?>" /></div>
            </section>
            <section class="search-btn tc-template__border" style="width: 110px;padding-left: 0em;font-size: 1em;text-align: center;">
                <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
                <button class="btn id_search_btn tc-template__color" type="button">搜索</button>
            </section>
        </form>
        <script>
        $(".id_search_btn").click( function (){ 
            $.ajax({
                type: "GET",
                url: "<?php echo $sfcSearchUrl;?>",
                data: $('#search_form').serialize(),
                success: function(msg){
                    window.location = msg;
                }
            });
        });
        </script>
        <?php } else { ?>
        <form class="sec-search tc-template__border flex" id="search_form" onsubmit="return false;" style="margin-bottom: 5px;">
            <section class="sec-input dislay-flex">
                <i class="tciconfont tcicon-sousuo tc-template__color"></i>
                <input type="text" placeholder="找顺风车，找工作，租房子" name="keyword" value="" />
            </section>
            <section class="search-btn tc-template__border">
                <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
                <button class="btn id_search_btn tc-template__color" type="button">搜索</button>
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
        </script>
        <?php } ?>
        <div class="clear1"></div>
        <?php if($showTypeList == 1) { ?>
        <div class="cat-search block">
             <div class="item-list2">
                  <?php if(is_array($typeList)) foreach($typeList as $key => $val) { ?>                  <a class="bg<?php echo $key;?>" href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=list&amp;type_id=<?php echo $val['id'];?>" <?php if($type_id==$val['id'] ) { ?>class="active"<?php } ?> ><?php echo $val['name'];?></a>
                  <?php } ?>
             </div>
        </div>
        <?php } elseif($showTypeList == 2) { ?>
        <div class="cat-sarch__more clearfix">
            <?php if(is_array($typeList)) foreach($typeList as $key => $val) { ?>            <a class="bg<?php echo $key;?> <?php if($type_id==$val['id'] ) { ?>on<?php } ?>" href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=list&amp;type_id=<?php echo $val['id'];?>"><?php echo $val['name'];?></a>
            <?php } ?>
        </div>
        <?php } ?>
        <?php if($focuspicList) { ?>
        <div class="swiper-container swiper-container-focuspic">
            <div class="swiper-wrapper">
                <?php if(is_array($focuspicList)) foreach($focuspicList as $key => $val) { ?>                <div class="swiper-slide">
                    <a href="<?php echo $val['link'];?>"><img src="<?php echo $val['picurl'];?>" width="100%"></a>
                </div>
                <?php } ?>
            </div>
            <div class="swiper-pagination swiper-pagination-focuspic"></div>
        </div>
        <?php } ?>
        <?php if($modelInfo['is_sfc'] == 1 && $showSfcTxtStatus == 1) { ?>
        <div class="sfc-xieyi">
            <div class="sfc-xieyi__simple dislay-flex"><span class="sfc-xieyi__gonggao tc-template__bg" >公告</span><span class="flex  open-popups" data-target="#sfc-xieyi__box" style="cursor: pointer;"><?php echo $sfcCutTxt;?></span><a class="open-popups" data-target="#sfc-xieyi__box"></a></div>
            <div id="sfc-xieyi__box" class='pop-ups__container'>
                <div class="pop-ups__overlay"></div>
                <div class="pop-ups__modal">
                    <div class="pop-ups__box">
                        <div class="list_sfc_top tc-template__bg">顺风车协议</div>
                        <section class="list_sfc_txt"><?php echo $sfcTxt;?></section>
                        <div class="pop-ups__block"></div>
                    </div>
                    <div class="pop-ups__close">
                        <a href="javascript:void(0);" class="tcui-btn tcui-btn_default close-popups">关闭</a>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <section class="tc-sec">
             <section class="tc-sec mt0" id="list-list">
                 <div class="tcui-loadmore" style="padding:1em"><i class="tcui-loading"></i><span class="tcui-loadmore__tips">正在加载...</span></div>
             </section>
             <section class="tc-sec mt0" style="display: none;" id="no-more-html">
                <div class="tcui-loadmore" style="padding:1em"><span class="tcui-loadmore__tips">没有更多信息...</span></div>
             </section>
            <section class="tc-sec mt0" style="display: none;" id="no-list-html">
                <div class="clear10" style="height:7em;"></div>
                  <div class="tcui-loadmore tcui-loadmore_line">
                       <span class="tcui-loadmore__tips">没有信息</span>
                  </div>
                  <div class="btn-group-block">
                       <a class="tc-template__bg" href="<?php echo $fabuUrl;?>">开始发布一条</a>
                       <div class="clear10" style="height:7em;"></div>
                  </div>
             </section>
        </section>
   </section>
</section>
<section class="pic_info id-pic-tip box_hide clearfix" style="z-index: 999;height: 2000px;position: fixed;">
<div class="pic_info_in id-pic-tip-in" style="top: 0px; height: 550px; background-image: url();"></div>
</section>
<?php if($browser_shouchang_show == 1) { ?>
<section id="index_prompt" onClick="hide_shouchang_prompt(<?php echo $__UserInfo['id'];?>);">
    <div class="prompt-pic"><img src="source/plugin/tom_tongcheng/images/index-tip-bg.png"></div>
</section>
<?php } ?>
<section class="back_top">
    <a href="javascript:;"><img src="source/plugin/tom_tongcheng/images/back_top.png"></a>
</section>
<div class="swiper-container rebox" id="rebox">
    <div class="swiper-wrapper " id="rebox-wrapper__box">
    </div>
    <div class="swiper-pagination rebox-pagination"></div>
<div class="swiper-close" id="rebox-close"></div>
</div><?php include template('tom_tongcheng:footer'); ?><div style="display: none;"><?php echo $tongchengConfig['tongji_code'];?></div>
<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<script type="text/javascript">
var list_jm_link    = '<?php echo $md5HostUrl;?>';
var list_stop       = 'list_scrollTop'+list_jm_link;
var list_page       = 'list_page'+list_jm_link;
var list_data       = 'list_data'+list_jm_link;
var pageIndex = 1;
$(document).ready(function(){
    //loadList("<?php echo $model_id;?>","<?php echo $type_id;?>","<?php echo $cate_id;?>","<?php echo $city_id;?>","<?php echo $area_id;?>","<?php echo $street_id;?>",'<?php echo $keyword;?>','<?php echo $ordertype;?>',pageIndex);
    if($("#list-list").length>0){
        if(sessionStorage.getItem(list_page)){
            $('#list-list').html(sessionStorage.getItem(list_data));
            pageIndex = sessionStorage.getItem(list_page);
            pageIndex = pageIndex*1;
            $(document).scrollTop(sessionStorage.getItem(list_stop));
        }else{
            loadList("<?php echo $model_id;?>","<?php echo $type_id;?>","<?php echo $cate_id;?>","<?php echo $city_id;?>","<?php echo $area_id;?>","<?php echo $street_id;?>",'<?php echo $keyword;?>','<?php echo $ordertype;?>','<?php echo $sfcChufa;?>','<?php echo $sfcMude;?>',pageIndex);
        }
    }
    
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
$(document).ready(function(){
   $.get("<?php echo $ajaxCommonClicksUrl;?>");
});
var scrollRunStatus = 0;
$(window).scroll(function () {
    var runScrollTop       = $(this).scrollTop();
    if(runScrollTop > 100 && scrollRunStatus == 0){
       scrollRunStatus = 1;
       console.log('runScrollTop:'+runScrollTop);
       $.get("<?php echo $ajaxUpdateTopstatusUrl;?>");
       $.get("<?php echo $ajaxAutoClickUrl;?>");
       $.get("<?php echo $ajaxAutoZhuanfaUrl;?>");
       <?php if($modelInfo['is_sfc'] == 1) { ?>
       $.get("<?php echo $ajaxSfcCacheUrl;?>");
       <?php } ?>
    }
});

$(window).scroll(function () {
    var scrollTop       = $(this).scrollTop();
    var scrollHeight    = $(document).height();
    var windowHeight    = $(this).height();
    if ((scrollTop + windowHeight) >= (scrollHeight * 0.9)) {
        loadList("<?php echo $model_id;?>","<?php echo $type_id;?>","<?php echo $cate_id;?>","<?php echo $city_id;?>","<?php echo $area_id;?>","<?php echo $street_id;?>",'<?php echo $keyword;?>','<?php echo $ordertype;?>','<?php echo $sfcChufa;?>','<?php echo $sfcMude;?>',pageIndex);
    }
    
    if ((scrollTop + windowHeight) >= 1000) {
        $('.back_top').show();
    }else{
        $('.back_top').hide();
    }
    
    if ($(window).scrollTop()> 350) {
        sessionStorage.setItem(list_stop, $(window).scrollTop());
        sessionStorage.setItem(list_data, $('#list-list').html());
        if(pageIndex >= 1){ sessionStorage.setItem(list_page, pageIndex); }
    } else {
        sessionStorage.removeItem(list_page);
        sessionStorage.removeItem(list_data);
        sessionStorage.removeItem(list_stop);
    }
});

$(document).on('click','.back_top', function () {
    $('body,html').animate({scrollTop: 0}, 500);
    return false;
});

var loadListStatus = 0;
function loadList(modelId,typeId,cateId,cityId,areaId,streetId,Keyword,orderType,sfcChufa,sfcMude,Page) {
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
        data: { model_id:modelId,type_id:typeId,cate_id:cateId,city_id:cityId,area_id:areaId,street_id:streetId,keyword:Keyword,ordertype:orderType,chufa:sfcChufa,mude:sfcMude,page:Page},
        success: function(msg){
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
                ++pageIndex;
                $("#list-list").append(data);
            }
        }
    });
}

function hide_shouchang_prompt(uid){
    $('#index_prompt').hide();
    $.ajax({
type: "GET",
url: "<?php echo $ajaxShouchangUrl;?>",
data: {user_id:uid},
success: function(msg){
            
}
})
    
}
</script><?php include template('tom_tongcheng:list_nav'); include template('tom_tongcheng:list_sub'); ?><script>
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