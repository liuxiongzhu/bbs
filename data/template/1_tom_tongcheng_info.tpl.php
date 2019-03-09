<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<!DOCTYPE html>
<html>
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
<?php if($__ShowTchongbao == 1) { ?>
<link rel="stylesheet" href="source/plugin/tom_tchongbao/images/yinru_hb_style.css?v=<?php echo $cssJsVersion;?>" />
<?php } ?>
<script src="source/plugin/tom_tongcheng/images/jquery.min-2.1.3.js" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/swiper.min.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/global.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/layer_mobile/layer.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?><style>
    .layui-m-layer0 .layui-m-layerchild{width: 70%;}
    .layui-m-layercont{padding: 5px 3px;}
    .index-navs .index-nav.active{ border-bottom: 2px solid <?php echo $tongchengConfig['template_color'];?> !important; color: <?php echo $tongchengConfig['template_color'];?> !important;}
    .index-navs .index-nav.active a{ color: <?php echo $tongchengConfig['template_color'];?> !important;}
    .noAllowCopy{-moz-user-select: none;-webkit-user-select: none;-ms-user-select: none;user-select: none;}
</style>
</head>
<body id="tc_info">
<?php if($__HideHeader == 0 ) { ?>
<header class="header on tc-template__bg">
   <section class="wrap">
        <section class="sec-ico go-back" onclick="javascript:history.go(-1);">返回</section>
        <h2><?php echo $title;?></h2>
   </section>
</header>
<?php } ?>
<section class="info-item" style="<?php if($__HideHeader == 0 ) { ?>margin-top: 3em;<?php } ?>margin-bottom: 1px;">
<div class="info-item-title clearfix">
        <div class="item-headimg-l">
            <img src="<?php echo $userInfo['picurl'];?>">
        </div>
        <div class="item-title-r">
            <h5>
                <a href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=list&type_id=<?php echo $typeInfo['id'];?>">
                    <span class="tc-template__bg"><?php echo $typeInfo['name'];?></span>
                </a>
                <?php if($tongchengConfig['list_title_type'] == 1 ) { ?>
                <?php echo $userInfo['nickname'];?>
                <?php } elseif($tongchengConfig['list_title_type'] == 2) { ?>
                <?php echo $tongchengInfo['xm'];?>
                 <?php } elseif($tongchengConfig['list_title_type'] == 3 && $tongchengInfo['title'] && $tongchengConfig['open_fabu_title'] == 1) { ?>
                <?php echo $tongchengInfo['title'];?>
                <?php } else { ?>
                <?php echo $userInfo['nickname'];?>
                <?php } ?>
                <?php if($tchongbaoInfo && $tchongbaoInfo['status'] == 1 && $tchongbaoConfig['open_show_hongbao_price'] == 1) { ?>
                <i class="hbsy_money" ><img src="source/plugin/tom_tchongbao/images/hongbao-ico.png"><?php echo $tchongbaoInfo['money'];?></i>
                <?php } ?>
            </h5>
            <div class="title-time clearfix">
                <?php echo dgmdate($tongchengInfo[refresh_time], 'u','9999','m-d H:i');?>                <?php if($tongchengConfig['show_site_name'] == 1 ) { ?>
                &nbsp;来自<?php echo $siteInfo['name'];?>
                <?php } ?>
            </div>
        </div>
        <?php if($tongchengConfig['open_info_pic_jgg'] == 0) { ?>
        <p class="item-liulan"><?php echo $tongchengInfo['clicks'];?> 人浏览、 <?php echo $zanCount;?> 人点赞</p>
        <?php } ?>
    </div>
    <?php if($tongchengInfo['finish'] == 1) { ?>
    <div class="title-finish"><img src="source/plugin/tom_tongcheng/images/icon35.png"></div>
    <?php } ?>
</section>
<?php if($attrList || $addressStr || $cateInfo ) { ?>
<section class="info-item" style="margin-bottom: 1px;">
<div class="info-item-attr">
        <?php if($cateInfo) { ?>
        <div class="attr clearfix">
        	<div class="attr-left"><?php echo $typeInfo['cate_title'];?>&nbsp;:&nbsp;</div>
        	<div class="attr-right"><?php echo $cateInfo['name'];?></div>
        </div>
        <?php } ?>
        <?php if(is_array($attrList)) foreach($attrList as $k2 => $v2) { ?>        <?php if($v2['value']) { ?>
    	<div class="attr clearfix">
        	<div class="attr-left"><?php echo $v2['attr_name'];?>&nbsp;:&nbsp;</div>
        	<div class="attr-right"><?php echo $v2['value'];?><?php if($v2['unit']) { ?><?php echo $v2['unit'];?><?php } ?></div>
        </div>
        <?php } ?>
        <?php } ?>
        <?php if($addressStr  ) { ?>
        <div class="attr clearfix">
        	<div class="attr-left">地区&nbsp;:&nbsp;</div>
        	<div class="attr-right"><?php echo $addressStr;?></div>
        </div>
        <?php } ?>
    </div>
</section>
<?php } ?>
<section class="info-item">
<div class="info-item-mation">
    	<!--<h5>信息详情</h5>-->
        <?php if($tagList) { ?>
        <div class="title-bq clearfix">
            <?php if(is_array($tagList)) foreach($tagList as $k1 => $v1) { ?>            <span class="span<?php echo $k1;?>"><?php echo $v1['tag_name'];?></span>
            <?php } ?> 
        </div>
        <?php } ?>
        <?php if($showNewContent == 1) { ?>
        <div class="mation-content"><?php echo $newContent;?></div>
        <?php } else { ?>
        <div class="mation-content"><?php echo $content;?></div>
        <?php if($photoList) { ?>
            <?php if($tongchengConfig['open_info_pic_jgg'] == 1) { ?>
            <div class="mation-photo__jgg clearfix">
                <?php if(is_array($photoList)) foreach($photoList as $k3 => $v3) { ?>                <img class="picture <?php if($photoCount == 1) { ?>bigwidth<?php } ?>" src="<?php echo $v3;?>" onClick="showPicList($(this),'<?php echo $k3;?>');">
                <?php } ?>
                <input type="hidden" name="photo_list" class="photo_list" value="<?php echo $photoListStr;?>">
            </div>
            <?php } else { ?>
            <div class="mation-photo clearfix">
                <input type="hidden" name="photo_list" class="photo_list" value="<?php echo $photoListStr;?>">
                <?php if(is_array($photoList)) foreach($photoList as $k3 => $v3) { ?>                <img class="picture" src="<?php echo $v3;?>" onClick="showPicList($(this),'<?php echo $k3;?>');">
                <?php } ?>
            </div>
            <?php } ?>
        <?php } ?>
        <?php } ?>
    </div>
    <?php if($showDingwei == 1) { ?>
    <div class="info-item-dingwei ">
        <i class="tciconfont tcicon-dingwei_shi"></i><?php echo $tongchengInfo['address'];?>
        <?php if($juli > 0) { ?>
        <span>距您≈<?php echo $juli;?>km</span>
        <?php } ?>
    </div>
    <?php } ?>
    <div class="info-item-zan ">
        <div class="zan-hd clearfix">
            <div class="zan-hd_num">
                <?php if($isCollect == 1 ) { ?>
                <i class="on tciconfont tcicon-tcdianzan__on tc-template__color" onClick="collect(<?php echo $__UserInfo['id'];?>, <?php echo $tongcheng_id;?>);"></i>
                <?php } else { ?>
                <i class="tciconfont tcicon-tcdianzan tc-template__color" onClick="collect(<?php echo $__UserInfo['id'];?>, <?php echo $tongcheng_id;?>);"></i>
                <?php } ?>
                <span><?php echo $zanCount;?></span>
            </div>
            <?php if($tongchengConfig['open_info_pic_jgg'] == 1) { ?>
            <div class="zan-hd_clicks"><?php echo $tongchengInfo['clicks'];?> 人浏览、 <?php echo $zanCount;?> 人点赞</div>
            <?php } ?>
        </div>
        <?php if($zanCount > 0) { ?>
        <div class="zan-bd">
            <i class="detail-cmtr"></i>
            <div class="zan-bd_content clearfix">
                <?php if(is_array($zanList)) foreach($zanList as $key => $value) { ?>                <img src="<?php echo $value['userInfo']['picurl'];?>">
                <?php } ?>
            </div>
        </div>
        <?php } ?>
    </div>
</section>
<section class="info-item">
    <div class="info-item-ly">
        <div class="ly-content">
            <p>联系人：<?php echo $tongchengInfo['xm'];?></p>
            <p class="import tc-template__color">联系时请告知在<a href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=index"><span class="tc-template__color"><?php echo $__SitesInfo['name'];?></span></a>上面看到的</p>
        </div>
        <?php if($tongchengInfo['finish'] == 0 && $showBuyTelBtn == 0) { ?>
        <div class="ly-right"><a href="tel:<?php echo $tongchengInfo['tel'];?>"></a></div>
        <?php } ?>
    </div>
</section>
<section class="info-item">
    <div class="info-item-jubao">
        <div class="jubao-content">
            <p class="title tc-template__color">如遇无效、虚假、诈骗信息，请立即举报</p>
            <p class="desc"><?php echo $zhapian_msg;?></p>
        </div>
        <div class="jubao-right">
            <a href="<?php echo $tousuUrl;?>">
                <div class="ico"><img src="source/plugin/tom_tongcheng/images/jubao_ico.png" width="30" height="28"/></div>
                <div class="btn">举报</div>
            </a>
        </div>
    </div>
</section>
<?php if($focuspicList) { ?>
<div class="swiper-container swiper-container-focuspic" style="margin-bottom:8px;">
    <div class="swiper-wrapper">
        <?php if(is_array($focuspicList)) foreach($focuspicList as $key => $val) { ?>        <div class="swiper-slide">
            <a href="<?php echo $val['link'];?>"><img src="<?php echo $val['picurl'];?>" width="100%"></a>
        </div>
        <?php } ?>
    </div>
    <div class="swiper-pagination swiper-pagination-focuspic"></div>
</div>
<?php } include template('tom_tongcheng:pinglun'); ?><section class="info-item">
<div class="info-item-fbr clearfix">
    	<a href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=home&uid=<?php echo $userInfo['id'];?>">
            <div class="fbr-avatar"><img src="<?php echo $userInfo['picurl'];?>"></div>
            <div class="fbr-content">
                <div class="fbr-name"><?php echo $userInfo['nickname'];?> <i></i></div>
                <div class="fbr-count">发布<?php echo $tcCount;?>条</div>
            </div>
        </a>
    </div>
</section>
<?php if($__ShowTcshop == 1 && $shopNum > 0 ) { include template('tom_tongcheng:info_shop'); } if($__ShowTchongbao == 1 && $tchongbaoInfo) { ?>
<section class="info-item">
    <div class="hb_title">
        福利已抢<font color="#f00"><?php echo $tchongbaoLogCount;?></font>/<?php echo $tchongbaoInfo['hb_count'];?>
        <a href="<?php echo $hongbaoLogListUrl;?>">看看大家的手气</a>
    </div>
    <div class="hongbaolog-list">
        <?php if($tchongbaoLogList) { ?>
        <ul>
            <?php if(is_array($tchongbaoLogList)) foreach($tchongbaoLogList as $key => $value) { ?>            <li><a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=home&amp;uid=<?php echo $value['user_id'];?>"><img src="<?php echo $value['user_picurl'];?>"></a><?php echo $value['nickname'];?><span><?php echo $value['money'];?></span></li>
            <?php } ?>
        </ul>
        <?php } else { ?>
        <div class="no-hb-ts">还没有人领取那，快点击领取福利吧！</div>
        <?php } ?>
    </div>
</section>
<?php } ?>
<section id="tab-navs">
    <ul class="tab-navs index-navs detail-navs" >
       <div class="tab-scroll">
            <li class="tab-nav index-nav active" onclick="indexLoadList(0);">最新信息</li>
            <?php if(is_array($modelList)) foreach($modelList as $key => $val) { ?>             <li class="tab-nav index-nav"><a href="javascript:void(0);" onclick="indexLoadList(<?php echo $val['id'];?>);"><?php echo $val['name'];?></a></li>
             <?php } ?>
       </div>
    </ul>
    <div id="index-list" style="min-height: 400px;background-color: #fff;">
    </div>
    <section style="display: none;" id="load-html">
        <div class="tcui-loadmore" style="padding:1em"><i class="tcui-loading"></i><span class="tcui-loadmore__tips">正在加载...</span></div>
    </section>
    <section  style="display: none;" id="no-list-html">
       <div class="clear10" style="height:7em;"></div>
       <div class="tcui-loadmore tcui-loadmore_line">
           <span class="tcui-loadmore__tips">没有信息</span>
       </div>
       <div class="btn-group-block">
           <a class="tc-template__bg" href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=fabu">开始发布一条</a>
           <div class="clear10" style="height:7em;"></div>
       </div>
   </section>
</section><?php include template('tom_tongcheng:popup'); if($__ShowTchongbao == 1 && $tchongbaoInfo && $show_hongbao_button == 1) { ?>
<section class="info-hongbao">
    <div class="hongbao-button" style="bottom: 50px;">
        <?php if($lqHongbaoStatus == 1) { ?>
        <a href="<?php echo $myMoneyUrl;?>" class="qiang_over">已领取，申请提现</a>
        <?php } elseif($tchongbaoInfo['status'] == 1) { ?>
        <a href="javascript:;" onClick="hongbaoFilter();">领取福利</a>
        <?php } else { ?>
        <a href="<?php echo $hongbaoIndexUrl;?>" class="qiang_over">已抢完，更多福利</a>
        <?php } ?>
    </div>
</section>
<?php } ?>
<section id="info-footer">
<div class="info-footer">
    	<div class="info-footer-item">
        	<a href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=index&prand=<?php echo $prand;?>">
                <i class="icon tciconfont tcicon-nav__index"></i>
                <span>首页</span>
            </a>
        </div>
    	<div class="info-footer-item">
        	<a href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=fabu&prand=<?php echo $prand;?>" >
                <i class="icon tciconfont tcicon-fabu__info"></i>
                <span>发布</span>
            </a>
        </div>
    	<div class="info-footer-item">
        	<a href="<?php echo $messageUrl;?>">
                <i class="icon tciconfont tcicon-nav__message"></i>
                <span>私信</span>
            </a>
        </div>
    	<div class="info-footer-item info-footer-tel tc-template__bg tc-template__border">
            <?php if($tongchengInfo['finish'] == 1) { ?>
            <a href="javascript:;" class="finish">已完成</a>
            <?php } else { ?>
            <?php if($showBuyTelBtn == 1) { ?>
                <?php if($__IsMiniprogram == 1 && $__Ios == 1 && $tongchengConfig['closed_ios_pay'] == 1 ) { } else { ?>
                <a href="javascript:void(0);" onclick="payTel(<?php echo $tongchengInfo['id'];?>);">付费查看<br/><?php echo $tongchengInfo['tel'];?></a>
                <?php } ?>
            <?php } elseif($showBuyTelBtn == 2) { ?>
            <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=personal">付费查看<br/><?php echo $tongchengInfo['tel'];?></a>
            <?php } else { ?>
            <a href="tel:<?php echo $tongchengInfo['tel'];?>">一键拨号<br/><?php echo $tongchengInfo['tel'];?></a>
            <?php } ?>
            <?php } ?>
        </div>
    </div>
</section>
<?php if($showBuyTelBtn == 1) { ?>
<script type="text/javascript">
var submintPayStatus = 0;
function payTel(tongcheng_id){
    if(submintPayStatus == 1){
        return false;
    }
    submintPayStatus = 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $payTelUrl;?>",
        dataType : "json",
        data: "tongcheng_id="+tongcheng_id,
        success: function(data){
            if(data.status == 200) {
                tusi("下单成功，立即支付");
                setTimeout(function(){window.location.href=data.payurl+"&prand=<?php echo $prand;?>";},500);
            }else if(data.status == 303){
                tusi("生成微信订单失败");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 304){
                tusi("插入订单数据失败");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 307){
                tusi("没有安装TOM支付中心插件");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 400){
                tusi("未设置查看电话费用");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else{
                tusi("支付错误");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }
        }
    });
}
</script>
<?php } ?>
<section class="pic_info id-pic-tip box_hide clearfix" style="z-index: 999;height: 2000px;position: fixed;">
<div class="pic_info_in id-pic-tip-in" style="top: 0px; height: 550px; background-image: url();"></div>
</section>
<div class="site-float" style="font-size: 0.7em;">
    <span class="img-dialog" onclick="dingyue();" > 订阅 <i></i> 我们 </span>
    <span class="img-dialog" onclick="kefu();" > 联系 <i></i> 客服 </span>
</div>
<section class="back_top">
    <a href="javascript:void(0);"><img src="source/plugin/tom_tongcheng/images/back_top.png"></a>
</section>
<?php if($browser_shouchang_show == 1) { ?>
<section id="index_prompt" onClick="hide_shouchang_prompt(<?php echo $__UserInfo['id'];?>);">
    <div class="prompt-pic"><img src="source/plugin/tom_tongcheng/images/index-tip-bg.png"></div>
</section>
<?php } ?>
<div class="swiper-container rebox" id="rebox">
    <div class="swiper-wrapper " id="rebox-wrapper__box">
    </div>
    <div class="swiper-pagination rebox-pagination"></div>
<div class="swiper-close" id="rebox-close"></div>
</div>
<?php if($__ShowTchongbao == 1 && $tchongbaoInfo) { ?>
<section class="info-hongbao-box">
    <div class="hongbao-box">
        <div class="shop-pic" style="margin-top: 40px">
            <img src="<?php echo $userInfo['picurl'];?>">
            <p><?php echo $userInfo['nickname'];?></p>
            <p>给你发了一个福利</p>
        </div>
        <?php if($tchongbaoInfo['open_kouling'] == 1) { ?>
        <?php } else { ?>
        <div class="bongbao-title" style="height: 40px;"></div>
        <?php } ?>
        <form id="qiang_hongbao_form" onsubmit="return false;">
            <?php if($tchongbaoInfo['open_kouling'] == 1) { ?>
            <input type="text" id="kouling" name="kouling" value="" placeholder="请输入领取口令">
            <?php } ?>
            <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
            <input type="hidden" name="site" value="<?php echo $site_id;?>">
            <input type="hidden" name="tongcheng_id" value="<?php echo $tongcheng_id;?>">
            <input type="hidden" name="act" value="open_hb">
            <input type="hidden" name="hongbao_id" value="<?php echo $tchongbaoInfo['id'];?>">
        </form>
        <div class="hongbao-button" id="open_hb"><img src="source/plugin/tom_tchongbao/images/hongbao_qiang.png"></div>
        <?php if($tchongbaoInfo['open_kouling'] == 1) { ?>
        <p class="kouling_pormpt"><span>口令提示：</span><?php echo $tchongbaoInfo['kouling_pormpt'];?></p>
        <?php } ?>
        <div class="hongbao-close" onClick="hongbaoBoxHide();"></div>
    </div>
</section>
<?php if($tchongbaoConfig['mp3_link']) { ?>
<script src="source/plugin/tom_tchongbao/images/music/music.js" type="text/javascript"></script>
<div class="music_play_yinfu" id="music_audio_btn" style="display: none;">
    <div id="music_yinfu" class="music_rotate"></div>
    <audio id="music_media" controls="controls" src="<?php echo $tchongbaoConfig['mp3_link'];?>" ></audio>
</div>
<?php } ?>
<div id="loadingToast" class="loading-toast">
    <div class="tcui-mask_transparent"></div>
    <div class="tcui-toast">
        <i class="tcui-loading tcui-icon_toast"></i>
        <p class="tcui-toast__content"></p>
    </div>
</div>
<div id="toast" style="display: none;">
    <div class="tcui-mask_transparent"></div>
    <div class="tcui-toast">
        <i class="tcui-icon-success-no-circle tcui-icon_toast"></i>
        <p class="tcui-toast__content">福利已抢完</p>
    </div>
</div>
<script type="text/javascript">
<?php if($__ShowTchongbao == 1 && $lqHongbaoStatus != 1 && $tchongbaoInfo['status'] == 1 && $openLocaltionDistance == 1 && $hongbaoLocationStatus == 0) { ?>
    $('#loadingToast .tcui-toast .tcui-toast__content').html("红包定位中...");
    $('#loadingToast').show();
<?php } if($tchongbaoInfo['status'] == 2) { ?>
/*
$(function(){
    $('#toast').fadeIn(100);
    setTimeout(function () {
        $('#toast').fadeOut(100);
    }, 2000);
});*/
<?php } ?>
$(document).ready(function(){
    <?php if($tchongbaoConfig['mp3_link']) { ?>
    var audio2 = $('#music_media');
    audio2[0].pause();
    <?php } ?>
});

var hbButtomClickStatus = 0;
function hongbaoFilter(){
    <?php if($tchongbaoConfig['mp3_link']) { ?>
    var audio2 = $('#music_media');
    audio2[0].play();
    <?php } ?>
    <?php if($openLocaltionDistance == 2) { ?>
    tusi('请在手机微信客户端打开网页');
    return false;
    <?php } elseif($openLocaltionDistance == 3) { ?>
    tusi('[301]定位失败，无法领取福利');
    return false;
    <?php } elseif($openLocaltionDistance == 1) { ?>
    
        <?php if($hongbaoLocationStatus == 1) { ?>
            hbButtomClickStatus = 1;
            hongbaoBox();
            return false;
        <?php } elseif($hongbaoLocationStatus == 2) { ?>
            tusi('不在允许抢福利地区');
            return false;
        <?php } ?>
        
        if(getLocationStatus == 1){
            if(hbButtomClickStatus == 1){
                hongbaoBox();
            }else{
                tusi('不在允许抢福利地区');
                return false;
            }
        }else if(getLocationStatus == 2){
            tusi("用户拒绝授权获取地理位置");
            return false;
        }else{
            tusi('定位失败，请刷新页面重新定位');
            return false;
        }
    
    <?php } else { ?>
    hongbaoBox();
    return false;
    <?php } ?>
}

function locationRequest(latitude, longitude){
    if(latitude == '' || longitude == ''){
        $('#loadingToast').hide();
        tusi('[304]定位失败，无法领取福利');
        return false;
    }
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxDistanceHongbaoUrl;?>",
        data: {latitude:latitude,longitude:longitude},
        success: function(msg){
            $('#loadingToast').hide();
            getLocationStatus = 1;
            var data = eval('('+msg+')');
            if(data == 200){
                hbButtomClickStatus = 1;
            }else if(data == 301){
                tusi('[305]定位失败，无法领取福利');
                return false;
            }else if(data == 302){
                tusi('[306]定位失败，无法领取福利');
                return false;
            }else if(data == 303){
                tusi('不在允许抢福利地区');
                return false;
            }else{
                tusi('定位失败，无法领取福利');
                return false;
            }
        }
    });
}

function hongbaoBox(){
    <?php if($tchongbaoConfig['hb_lq_type'] == 1) { ?>
    $('.info-hongbao-box').show();
    <?php } ?>
}
    
function hongbaoBoxHide(){
    <?php if($tchongbaoConfig['mp3_link']) { ?>
    var audio2 = $('#music_media');
    audio2[0].pause();
    <?php } ?>
    $('.info-hongbao-box').hide();
}

var openHongbaoStatus = 0;
$('#open_hb').click(function(){
    <?php if($tchongbaoInfo['status'] != 1) { ?>
    tusi("福利已经领取完了");
    return false;
    <?php } ?>
    <?php if($tchongbaoConfig['open_hb_position'] == 1) { ?>
    if(hbButtomClickStatus != 1){
        tusi("不在允许抢福利地区");
        return false;
    }
    <?php } ?>
    
    <?php if($tchongbaoInfo['open_kouling'] == 1) { ?>
    var kouling = $('#kouling').val();
    if(kouling == ''){
        tusi("请输入领取口令");
        return false;
    }
    <?php } ?>
    if(openHongbaoStatus == 1){
        return false;
    }
    openHongbaoStatus = 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxHongbaoUrl;?>",
        data: $('#qiang_hongbao_form').serialize(),
        success: function(msg){
            openHongbaoStatus = 0;
            var data = eval('('+msg+')');
            if(data == 200){
                setTimeout(function(){window.location.href='<?php echo $hongbaoLogListUrl;?>';},500);
            }else if(data == 301){
                tusi("福利不存在");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data == 302){
                tusi("福利已经发放结束");
                return false;
            }else if(data == 303){
                tusi("口令错误，请重新填写");
                return false;
            }else if(data == 304){
                tusi("已经领取过了，不能再领取");
                setTimeout(function(){window.location.href='<?php echo $hongbaoLogListUrl;?>';},500);
            }else if(data == 305){
                tusi("福利已经发放结束");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else{
                tusi("异常错误");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }
        }
    });
})

</script>
<?php } ?>
<div style="display: none;"><?php echo $tongchengConfig['tongji_code'];?></div>
<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<script type="text/javascript">    
$(document).ready(function(){
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
       loadList('',1);
       $.get("<?php echo $ajaxUpdateTopstatusUrl;?>");
       $.get("<?php echo $ajaxAutoClickUrl;?>");
       $.get("<?php echo $ajaxAutoZhuanfaUrl;?>");
       $.get("<?php echo $ajaxUpdateToprandUrl;?>");
    }
});
function indexLoadList(modelId){
    loadList(modelId,1);
}

var loadHtml = $("#load-html").html();
var noListHtml = $("#no-list-html").html();
var loadListStatus = 0;
function loadList(modelId,Page) {
    if(loadListStatus == 1){
        return false;
    }
    loadListStatus = 1;
    $("#index-list").html(loadHtml);
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxLoadListUrl;?>",
        data: { model_id:modelId,page:Page},
        success: function(msg){
            loadListStatus = 0;
            var data = eval('('+msg+')');
            if(data == 205){
                $("#index-list").html(noListHtml);
                return false;
            }else{
                $("#index-list").html(data);
            }
        }
    });
}

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

$(window).scroll(function () {
    var scrollTop       = $(this).scrollTop();
    var scrollHeight    = $(document).height();
    var windowHeight    = $(this).height();
    if ((scrollTop + windowHeight) >= 1000) {
        $('.back_top').show();
    }else{
        $('.back_top').hide();
    }
});
$(document).on('click','.back_top', function () {
    $('body,html').animate({scrollTop: 0}, 500);
    return false;
});
</script><?php include template('tom_tongcheng:list_sub'); if($openLocaltionDistance == 1) { ?>
<script src="//api.map.baidu.com/api?v=2.0&ak=<?php echo $tchongbaoConfig['baidu_js_ak'];?>" type="text/javascript"></script>
<?php } ?>
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

var getLocationStatus = 0, latitude = '', longitude = '';
wx.ready(function (){
    <?php if($openLocaltionDistance == 1 && $hongbaoLocationStatus == 0) { ?>
    function wxGetLocation(){
        wx.getLocation({
            type: 'wgs84', // Ĭ��Ϊwgs84��gps���꣬���Ҫ����ֱ�Ӹ�openLocation�õĻ������꣬�ɴ���'gcj02'
            success: function(res) {
                var point = new BMap.Point(res.longitude, res.latitude);
                var convertor = new BMap.Convertor();
                var pointArr = [];
                pointArr.push(point);
                convertor.translate(pointArr, 1, 5, function(data) {
                    if (data.status === 0) {
                        latitude = data.points[0].lat;
                        longitude = data.points[0].lng;
                    } else {
                        latitude = res.latitude;
                        longitude = res.longitude;
                    }
                    locationRequest(latitude, longitude);
                });
            },
            fail: function(res){
                $('#loadingToast').hide();
                tusi("定位失败");
            },
            cancel: function(res){
                $('#loadingToast').hide();
                getLocationStatus = 2;
                tusi("用户拒绝授权获取地理位置");
            }
        });
    }
    <?php if($lqHongbaoStatus != 1 && $tchongbaoInfo['status'] == 1) { ?>
        wxGetLocation();
    <?php } ?>
    <?php } ?>
    wx.onMenuShareTimeline({
        title: '<?php echo $shareTitle;?>',
        link: '<?php echo $shareUrl;?>', 
        imgUrl: '<?php echo $shareLogo;?>', 
        success: function () { 
            $.get("<?php echo $ajaxZhuanfaUrl;?>");
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
            $.get("<?php echo $ajaxZhuanfaUrl;?>");
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
           $.get("<?php echo $ajaxZhuanfaUrl;?>");
        },
        cancel: function () { 
        }
    });
});
</script>
<script type="text/javascript">
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
                    locationRequest(latitude, longitude);
});
 },
function(error) {
                $('#loadingToast').hide();
                getLocationStatus = 2;
tusi("定位失败:"+error.code)
}
)
}else{
tusi('浏览器不支持Geolocation服务');
}
}

function wapGeolocation(){
var geolocation = new BMap.Geolocation();
geolocation.getCurrentPosition(function(r){
if(this.getStatus() == BMAP_STATUS_SUCCESS){
            locationRequest(r.point.lat, r.point.lng);
}else{
            $('#loadingToast').hide();
            getLocationStatus = 2;
alert('定位失败:'+this.getStatus());
}        
},{enableHighAccuracy: true})
}

function getLocation(){
    <?php if($show_hongbao_button == 0) { ?>
    return false;
    <?php } ?>
    <?php if($openLocaltionDistance == 1) { ?>
        <?php if($__IsWeixin == 1) { ?>
        return false;
        <?php } elseif($tongchengConfig['open_moblie_https_location'] == 1) { ?>
        h5Geolocation();
        <?php } else { ?>
        wapGeolocation();
        <?php } ?>
    <?php } ?>
}

<?php if($lqHongbaoStatus != 1 && $tchongbaoInfo['status'] == 1 && $openLocaltionDistance == 1 && $hongbaoLocationStatus == 0) { ?>
$(document).ready(function(){
    getLocation();
});
<?php } ?>
</script>
</body>
</html>