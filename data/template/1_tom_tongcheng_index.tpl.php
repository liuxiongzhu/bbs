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
<title><?php echo $__SitesInfo['name'];?></title>
<meta name="keywords" content="<?php echo $shareTitle;?>" />
<meta name="description" content="<?php echo $shareDesc;?>" />
<link href="source/plugin/tom_tongcheng/images/swiper.min.css" rel="stylesheet" />
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/tongcheng.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/iconfont/iconfont.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/jquery-popups.css?v=<?php echo $cssJsVersion;?>" />
<?php if($__ShowTcqianggou == 1) { ?>
<link rel="stylesheet" href="source/plugin/tom_tcqianggou/images/cash_list_style.css?v=<?php echo $cssJsVersion;?>" />
<?php } ?>
<script src="source/plugin/tom_tongcheng/images/jquery.min-2.1.3.js" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/swiper.min.js" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/global.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/layer_mobile/layer.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/jquery-popups.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?><style>
.layui-m-layer0 .layui-m-layerchild{width: 70%;}
.layui-m-layercont{padding: 5px 3px;}
.index-navs .index-nav.active{ border-bottom: 2px solid <?php echo $tongchengConfig['template_color'];?> !important; color: <?php echo $tongchengConfig['template_color'];?> !important;}
.index-navs .index-nav.active a{ color: <?php echo $tongchengConfig['template_color'];?> !important;}
.swiper-pagination-bullet-active{ background-color: <?php echo $tongchengConfig['template_color'];?> !important;}
.noAllowCopy{-moz-user-select: none;-webkit-user-select: none;-ms-user-select: none;user-select: none;}
<?php if($__Android == 1) { ?>
.detail-tags span{padding-top: 3px;}
<?php } ?>
</style>
</head>
<body class="body-bg">
<div id="sites-lbs" class='pop-ups__container'>
  <div class="pop-ups__overlay"></div>
  <div class="pop-ups__modal">
      <div class="pop-ups__box">
          <div class="index_lbs_top">当前站点：<?php echo $__SitesInfo['lbs_name'];?></div>
          <section class="index_lbs_sites">
            <h5>热门站点</h5>
            <div class="index_lbs_sites-list clearfix">
                <span><a href="plugin.php?id=tom_tongcheng&amp;site=1&amp;mod=index&amp;lbs_no=1"><?php echo $tongchengConfig['lbs_name'];?></a></span>
                <?php if(is_array($hotSitesList)) foreach($hotSitesList as $key => $val) { ?>                <span><a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $val['id'];?>&amp;mod=index&amp;lbs_no=1"><?php echo $val['lbs_name'];?></a></span>
                <?php } ?>
            </div>
            <?php if(is_array($cateSitesList)) foreach($cateSitesList as $key => $val) { ?>            <h5><?php echo $val['name'];?></h5>
            <div class="index_lbs_sites-list clearfix">
                <?php if(is_array($val['sites'])) foreach($val['sites'] as $kk => $vv) { ?>                <span><a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $vv['id'];?>&amp;mod=index&amp;lbs_no=1"><?php echo $vv['lbs_name'];?></a></span>
                <?php } ?>
            </div>
            <?php } ?>
            </section>
          <div class="pop-ups__block"></div>
      </div>
      <div class="pop-ups__close">
          <a href="javascript:void(0);" class="tcui-btn tcui-btn_default close-popups">关闭</a>
      </div>
  </div>
</div>
<div class="swiper-container swiper-container-focuspic">
    <?php if($tongchengConfig['index_search_show_type'] == 1) { ?>
    <section class="search_pic_box clearfix tc-template__bg">
    <?php } elseif($tongchengConfig['index_search_show_type'] == 2) { ?>
    <section class="search_pic_box search_pic_box_fiexd clearfix">
    <?php } ?>
        <?php if($tcadminConfig['open_sites'] == 1) { ?>
        <div class="search_pic open-popups" data-target="#sites-lbs">
            <a href="javascript:void(0);">
                <i class="lbs_txt"><?php echo $__SitesInfo['lbs_name'];?></i>
                <em class="lbs_ico"></em>
            </a>
        </div>
        <?php } else { ?>
        <div class="search_pic"><img src="<?php echo $logoSrc;?>"></div>
        <?php } ?>
        <?php if($tongchengConfig['index_search_show_type'] == 1) { ?>
        <div class="search_box">
        <?php } elseif($tongchengConfig['index_search_show_type'] == 2) { ?>
        <div class="search_box2">
        <?php } ?>
            <form  id="search_form" onsubmit="return false;">
                <input  type="text" name="keyword" placeholder="找顺风车，找工作，租房子">
                <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
                <div class="search_button id_search_btn tc-template__color">搜索</div>
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
        </div>
    </section>
    <?php if($focuspicList) { ?>
    <div class="swiper-wrapper">
        <?php if(is_array($focuspicList)) foreach($focuspicList as $key => $val) { ?>        <div class="swiper-slide">
            <a href="<?php echo $val['link'];?>"><img src="<?php echo $val['picurl'];?>" width="100%"></a>
        </div>
        <?php } ?>
    </div>
    <div class="swiper-pagination swiper-pagination-focuspic"></div>
    <?php } ?>
</div>
<section class="mainer" style="margin-top: -4px;">
   <section class="wrap">
        <section class="nav-list">
             <section class="nav-list-tit clearfix">
                 <section class="nav-list-tit-l clearfix" style="padding-left: 10px;">
                       <div class="dt_xh2" style="float: left;color: #464443;font-size: 0.9em;width: 100%;">
                           <i class="icon tciconfont tcicon-tongzhi tc-template__color"></i>
                                浏览:&nbsp;<font color="<?php echo $tongchengConfig['template_color'];?>"><?php echo $clicksNumTxt;?><?php if($clicksNum > 10000) { ?>万<?php } ?> </font>&nbsp; 
                                发布:&nbsp;<font color="<?php echo $tongchengConfig['template_color'];?>"><?php echo $fabuNumTxt;?><?php if($fabuNum > 10000) { ?>万<?php } ?> </font>&nbsp;
                                <?php if($__ShowTcshop == 1) { ?>
                                商家:&nbsp;<font color="<?php echo $tongchengConfig['template_color'];?>"><?php echo $ruzhuNumTxt;?><?php if($ruzhuNum > 10000) { ?>万<?php } ?> </font>&nbsp;
                                <?php } ?>
                                <?php if($__ShowTcshop == 0) { ?>
                                用户:&nbsp;<font color="<?php echo $tongchengConfig['template_color'];?>"><?php echo $userNumTxt;?><?php if($userNum > 10000) { ?>万<?php } ?></font>&nbsp;
                                <?php } ?>
                       </div>
                  </section>
                 <div class="help_title"><a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=help">帮助</a></div>
             </section>
             <section class="nav-li swiper-container swiper-container-nav">
                <div class="swiper-wrapper">
                    <ul class="swiper-slide">
                    <?php if(is_array($navList)) foreach($navList as $key => $val) { ?>                        <li>
                            <a href="<?php echo $val['link'];?>">
                              <section class="nav-li-pic">
                                    <img src="<?php echo $val['picurl'];?>"/>
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
        <section class="index-scroll-ad">
            <div class="scroll-ad__lt tc-template__color">同城动态</div>
            <ul>
                <?php if(is_array($topnewsList)) foreach($topnewsList as $key => $val) { ?>                <li><a href="<?php echo $val['link'];?>" target="_blank"><?php echo $val['title'];?></a></li>
                <?php } ?> 
                <?php if($__ShowTcshop == 1) { ?>
                <?php if(is_array($newTcshopList)) foreach($newTcshopList as $key => $val) { ?>                <li><a href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=details&amp;dpid=<?php echo $val['id'];?>" target="_blank"><font color="#0894fb"><?php echo $val['name'];?></font> 入驻成功</a></li>
                <?php } ?> 
                <?php } ?>
            </ul>
        </section>
       <?php if($colorMenuList) { ?>
       <section class="clear5" style="background-color: #fff;"></section>
       <?php } else { ?>
       <section class="clear5" style="background-color: #fff;margin-bottom: 5px;"></section>
       <?php } ?>
       <?php if($colorMenuList) { ?>
        <section class="index-color_menu clearfix">
            <?php if(is_array($colorMenuList)) foreach($colorMenuList as $key => $val) { ?>           <a href="<?php echo $val['4'];?>">
                <div class="color_area " style="background:<?php echo $val['3'];?>;">
                    <div class="color-left">
                         <p class="title"><?php echo $val['0'];?></p>
                         <p class="button"><?php echo $val['1'];?></p>
                     </div>
                     <div class="color-right">
                         <img src="source/plugin/tom_tongcheng/images/index_nav/<?php echo $val['2'];?>">
                     </div>
                </div>
           </a>
           <?php } ?> 
        </section>
       <?php } ?>
       <?php if($whiteMenuList) { ?>
        <section class="index-white_menu clearfix">
           <?php if(is_array($whiteMenuList)) foreach($whiteMenuList as $key => $val) { ?>           <a href="<?php echo $val['4'];?>">
                <div class="white_area ">
                    <div class="white-left">
                         <p class="title"><?php echo $val['0'];?></p>
                         <p class="button" style="color:<?php echo $val['3'];?>;"><?php echo $val['1'];?></p>
                     </div>
                     <div class="white-right">
                         <img src="source/plugin/tom_tongcheng/images/index_nav/<?php echo $val['2'];?>">
                     </div>
                </div>
           </a>
            <?php } ?> 
        </section>
        <?php } ?>
        <?php if($__ShowTctoutiao == 1 && $tctoutiaoConfig['tongcheng_index_num'] > 0) { ?>
        <?php include template('tom_tongcheng:index_toutiao'); ?>        <section class="clear5" style="background-color: #fff;margin-bottom: 5px;"></section>
        <?php } ?>
        <?php if($__ShowTcshop == 1) { ?>
        <?php if($tcshopList) { ?>
        <?php include template('tom_tongcheng:index_shop'); ?>        <?php } ?>
        <?php } ?>
        <section class="tc-sec">
             <ul class="tab-navs index-navs">
                  <div class="tab-scroll" >
                       <li id="index-nav_id_0" class="tab-nav index-nav active" onclick="indexLoadList(0, 1);">最新信息</li>
                       <?php if($__ShowTcqianggou == 1) { ?>
                            <?php if($showQianggouBtn == 1) { ?>
                            <li id="index-nav_id_qg" class="tab-nav index-nav" onclick="indexLoadList(0, 2);">大牌抢购</li>
                            <?php } ?>
                            <?php if($showCouponBtn == 1) { ?>
                            <li id="index-nav_id_coupon" class="tab-nav index-nav" onclick="indexLoadList(0, 3);">优惠劵</li>
                            <?php } ?>
                       <?php } ?>
                       <?php if($tongchengConfig['open_nearby'] == 1) { ?>
                       <li id="index-nav_id_999999" class="tab-nav index-nav" onclick="indexLoadList(999999, 1);">附近信息</li>
                       <?php } ?>
                       <?php if(is_array($modelList)) foreach($modelList as $key => $val) { ?>                       <li id="index-nav_id_<?php echo $val['id'];?>" class="tab-nav index-nav"><a href="javascript:void(0);" onclick="indexLoadList(<?php echo $val['id'];?>, 1);"><?php echo $val['name'];?></a></li>
                       <?php } ?> 
                  </div>
             </ul>
            <section class="tc-sec mt0" id="index-list" style="min-height: 400px;">
                <div class="tcui-loadmore" style="padding:1em"><i class="tcui-loading"></i><span class="tcui-loadmore__tips">正在加载...</span></div>
             </section>
             <section style="display: none;" id="load-html">
                <div class="tcui-loadmore" style="padding:1em"><i class="tcui-loading"></i><span class="tcui-loadmore__tips">正在加载...</span></div>
             </section>
             <section style="display: none;" id="no-load-html">
                <div class="tcui-loadmore" style="padding:1em"><span class="tcui-loadmore__tips">没有更多信息...</span></div>
             </section>
             <section  style="display: none;" id="no-list-html">
                <div class="clear10" style="height:7em;"></div>
                  <div class="tcui-loadmore tcui-loadmore_line">
                       <span class="tcui-loadmore__tips">没有信息</span>
                  </div>
                  <div class="btn-group-block">
                       <a class="id-fabu-url tc-template__bg" href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=fabu">开始发布一条</a>
                       <div class="clear10" style="height:7em;"></div>
                  </div>
             </section>
        </section>
   </section>
</section><?php include template('tom_tongcheng:popup'); ?><section class="pic_info id-pic-tip box_hide clearfix" style="z-index: 999;height: 2000px;position: fixed;">
<div class="pic_info_in id-pic-tip-in" style="top: 0px; height: 550px; background-image: url();"></div>
</section>
<div class="site-float">
    <span class="img-dialog" onclick="dingyue();" > 订阅 <i></i> 我们 </span>
    <span class="img-dialog" onclick="kefu();" > 联系 <i></i> 客服 </span>
</div>
<?php if($browser_shouchang_show == 1) { ?>
<section id="index_prompt" onClick="hide_shouchang_prompt(<?php echo $__UserInfo['id'];?>);">
    <div class="prompt-pic"><img src="source/plugin/tom_tongcheng/images/index-tip-bg.png"></div>
</section>
<?php } ?>
<section class="back_top">
    <a href="javascript:void(0);"><img src="source/plugin/tom_tongcheng/images/back_top.png"></a>
</section>
<div id="dialogs">
    <!--BEGIN dialog1-->
    <div class="js_dialog" id="lbsDialog" style="display: none;">
        <div class="tcui-mask"></div>
        <div class="tcui-dialog" id="lbsDialogBox" style="top: 40%;">
        </div>
    </div>
    <!--END dialog1-->
</div>
<div class="swiper-container rebox" id="rebox">
    <div class="swiper-wrapper " id="rebox-wrapper__box">
    </div>
    <div class="swiper-pagination rebox-pagination"></div>
<div class="swiper-close" id="rebox-close"></div>
</div><?php include template('tom_tongcheng:footer'); ?><div style="display: none;"><?php echo $tongchengConfig['tongji_code'];?></div>
<script src="source/plugin/tom_tongcheng/images/index.js" type="text/javascript"></script>
<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<script type="text/javascript">
var index_jm_link = '<?php echo $md5HostUrl;?>';
var index_top = 'index_scrollTop'+index_jm_link;
var index_page = 'index_page'+index_jm_link;
var index_data = 'index_data'+index_jm_link;
var index_modeId = 'index_modeId'+index_jm_link;
var index_type = 'index_type'+index_jm_link;

var loadModeId = 0;
var loadPage = 1;
var loadType = 1;
var ajaxLoadListUrl = "<?php echo $ajaxLoadListUrl;?>";

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
    <?php if($_GET['must_sites_lbs'] == 1) { ?>
    $("#sites-lbs").popup();
    <?php } ?>
    //loadList('',1);
    if($("#index-list").length>0){
        if(sessionStorage.getItem(index_page)){
            $('#index-list').html(sessionStorage.getItem(index_data));
            loadPage = sessionStorage.getItem(index_page);
            loadPage = loadPage*1;
            loadModeId = sessionStorage.getItem(index_modeId);
            loadType = sessionStorage.getItem(index_type);
            loadType = loadType*1;
            $(document).scrollTop(sessionStorage.getItem(index_top));
            if(loadType == 1){
                $('#index-nav_id_'+loadModeId).addClass('active').siblings('.index-nav').removeClass('active');
            }else if(loadType == 2){
                ajaxLoadListUrl = '<?php echo $ajaxLoadQianggouListUrl;?>';
                $('#index-nav_id_qg').addClass('active').siblings('.index-nav').removeClass('active');
            }else if(loadType == 3){
                ajaxLoadListUrl = '<?php echo $ajaxLoadCouponListUrl;?>';
                $('#index-nav_id_coupon').addClass('active').siblings('.index-nav').removeClass('active');
            }
        }else{
            loadList('<?php echo $ajaxLoadListUrl;?>',1);
        }
    }
    
});

function indexLoadList(modelId ,type){
    loadModeId = modelId;
    loadPage = 1;
    loadType = type;
    if(loadType == 1){
        ajaxLoadListUrl = '<?php echo $ajaxLoadListUrl;?>&model_id='+modelId;
        loadList(ajaxLoadListUrl,1);
    }else if(loadType == 2){
        ajaxLoadListUrl = '<?php echo $ajaxLoadQianggouListUrl;?>';
        loadList(ajaxLoadListUrl,1);
    }else if(loadType == 3){
        ajaxLoadListUrl = '<?php echo $ajaxLoadCouponListUrl;?>';
        loadList(ajaxLoadListUrl,1);
    }
}

var loadHtml = $("#load-html").html();
var noListHtml = $("#no-list-html").html();
var loadListStatus = 0;
function loadList(url,Page) {
    if(loadListStatus == 1){
        return false;
    }
    loadListStatus = 1;
    $("#index-list").html(loadHtml);
    $.ajax({
        type: "GET",
        url: url,
        data: {page:Page},
        success: function(msg){
            loadListStatus = 0;
            var data = eval('('+msg+')');
            if(data == 205){
                $("#index-list").html(noListHtml);
                $(".id-fabu-url").attr("href",'<?php echo $fabuUrl;?>'+loadModeId);
                return false;
            }else{
                loadPage += 1;
                $("#index-list").html(data);
                if(loadType == 2 || loadType == 3){
                    countDaojishi();
                }
            }
        }
    });
}

$(window).scroll(function () {
    var scrollTop       = $(this).scrollTop();
    var scrollHeight    = $(document).height();
    var windowHeight    = $(this).height();
    if ((scrollTop + windowHeight) >= (scrollHeight * 0.9)) {
        scrollLoadList(ajaxLoadListUrl);
    }
    
    if ((scrollTop + windowHeight) >= 1000) {
        $('.back_top').show();
    }else{
        $('.back_top').hide();
    }
    
    if ($(window).scrollTop()> 350) {
        sessionStorage.setItem(index_top, $(window).scrollTop());
        sessionStorage.setItem(index_data, $('#index-list').html());
        if(loadPage >= 1){ sessionStorage.setItem(index_page, loadPage); }
        sessionStorage.setItem(index_modeId, loadModeId);
        sessionStorage.setItem(index_type, loadType);
    } else {
        sessionStorage.removeItem(index_page);
        sessionStorage.removeItem(index_data);
        sessionStorage.removeItem(index_top);
        sessionStorage.removeItem(index_type);
        sessionStorage.removeItem(index_modeId);
    }
});

$(document).on('click','.back_top', function () {
    $('body,html').animate({scrollTop: 0}, 500);
    return false;
});

function scrollLoadList(url) {
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
        url: url,
        data: {page:loadPage},
        success: function(msg){
            loadListStatus = 0;
            var data = eval('('+msg+')');
            if(data == 205){
                $('#load-html').hide();
                $('#no-load-html').show();
                return false;
            }else{
                loadPage += 1;
                $('#load-html').hide();
                $("#index-list").append(data);
                if(loadType == 2 || loadType == 3){
                    countDaojishi();
                }
            }
        }
    });
}

$(function(){
    $('#dialogs').on('click', '.tcui-dialog__btn', function(){
        $(this).parents('.js_dialog').fadeOut(200);
    });
});

var djsTime;
function countDaojishi()
{
    window.clearInterval(djsTime);
    djsTime=setInterval(function() {
        $(".daojishi").each(function() { 
            var t = $(this).attr('data-time');
            t = t-100;
            var d=Math.floor(t/1000/60/60/24);
            var h=Math.floor(t/1000/60/60%24);
            var m=Math.floor(t/1000/60%60);
            var s=Math.floor(t/1000%60);
            if (t > 0) { 
                var str = d + "!tian!" + ( h<10?"0"+h:h) + "!hour!" + ( m<10?"0"+m:m) + "!minute!" + ( s<10?"0"+s:s)+"!second!"; 
            }
            else { 
                var str = "!details_end!"; 
            } 
            $(this).attr('data-time',t);
            $(this).html(str); 		
        })
    },100);
}

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
    }
});

function dingyue(){
    layer.open({
        content: '<img src="<?php echo $__SitesInfo['dingyue_qrcode'];?>"><p>长按二维码识别订阅我们<p/>'
        ,btn: '确认'
      });
}
function kefu(){
    layer.open({
        content: '<img src="<?php echo $kefuQrcodeSrc;?>"><p>长按二维码添加客服微信<p/>'
        ,btn: '确认'
      });
}

$(function() {
    setInterval(function() {
        var e = $(".index-scroll-ad ul");
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

$(document).on("click", ".index-nav",function() {
    var e = $(this),
    a = e.parent();
    a.find(".active").removeClass("active"),
    e.addClass("active");
    var i = e.data("id");
});

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
</script><?php include template('tom_tongcheng:list_sub'); ?><!-- lbs start -->
<?php if($tcadminConfig['open_sites_lbs'] > 1 || $haveModelDingwei == 1 ) { ?>
<script src="//api.map.baidu.com/api?v=2.0&ak=<?php echo $tongchengConfig['baidu_js_ak'];?>" type="text/javascript"></script>
<form name="lbsForm" id="lbsForm">
    <input type="hidden" id="id_city" name="city" value="" />
    <input type="hidden" id="id_district" name="district" value="" />
    <input type="hidden" name="formhash" value="<?php echo $formhash;?>" />
</form>
<script>
var gc = new BMap.Geocoder();
function getaddress(lat, lng) {
    <?php if($tcadminConfig['open_sites_lbs'] > 1) { ?>
    var point = new BMap.Point(lng, lat);
    gc.getLocation(point, function (rs) {
        var addComp = rs.addressComponents;
        <?php if($lbs_show == 1) { ?>
        alert(addComp.city +','+ addComp.district);
        <?php } ?>
        $('#id_city').val(addComp.city);
        $('#id_district').val(addComp.district);
        $.ajax({
            type: "GET",
            url: "<?php echo $ajaxLbsCheckUrl;?>",
            data: $('#lbsForm').serialize(),
            success: function(msg){
                var data = eval('('+msg+')');
                if(data == 100){
                    return false;
                }else{
                    $("#lbsDialogBox").html(data);
                    $("#lbsDialog").show();
                }
            }
        });
    });
    <?php } else { ?>
    return false;
    <?php } ?>
}
function closeLbs(){
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxLbsCloseUrl;?>",
        data: "u=1",
        success: function(msg){
        }
    });
}
</script>
<?php if($__IsWeixin == 1) { ?>
<script>
function getaddresswx(lat, lng) {
    var point = new BMap.Point(lng, lat);
    var convertor = new BMap.Convertor();
    var pointArr = [];
    pointArr.push(point);
    convertor.translate(pointArr, 1, 5, function(data) {
        if (data.status === 0) {
            $.get("<?php echo $ajaxUpdateLbsUrl;?>&latitude="+data.points[0].lat+"&longitude="+data.points[0].lng);
            getaddress(data.points[0].lat, data.points[0].lng);
        } else {
            getaddress(lat, lng);
        }
    });
}
</script>
<?php } else { if($tongchengConfig['open_moblie_https_location'] == 1) { ?>
<script>
$(document).ready(function(){
   h5Geolocation();
});
function h5Geolocation(){
if (navigator.geolocation){
navigator.geolocation.getCurrentPosition(
function(position) {  
var lat = position.coords.latitude;
var lng = position.coords.longitude;
var point = new BMap.Point(lng, lat);
var convertor = new BMap.Convertor();
var pointArr = [];
pointArr.push(point);
convertor.translate(pointArr, 1, 5, function(data) {
                    if (data.status === 0) {
                        latitude = data.points[0].lat;
                        longitude = data.points[0].lng;
} else {
                        latitude = lat;
                        longitude = lng;
}
                    $.get("<?php echo $ajaxUpdateLbsUrl;?>&latitude="+latitude+"&longitude="+longitude);
                    getaddress(latitude, longitude);
});
 },
function(error) {
}
)
}else{
tusi('浏览器不支持Geolocation服务');
}
}
</script>
<?php } } } ?>
<!-- lbs end -->
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
    <?php if($tcadminConfig['open_sites_lbs'] > 1  || $haveModelDingwei == 1 ) { ?>
    <?php if($__IsWeixin == 1) { ?>
    wx.getLocation({
        type: 'wgs84',
        success: function(res) {
            getaddresswx(res.latitude, res.longitude);
        }
    });
    <?php } ?>
    <?php } ?>
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