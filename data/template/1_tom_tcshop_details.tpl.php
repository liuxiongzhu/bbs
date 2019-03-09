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
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tcshop/images/iconfont/iconfont.css?v=<?php echo $cssJsVersion;?>" />
<link href="source/plugin/tom_tongcheng/images/swiper.min.css" rel="stylesheet" />
<link rel="stylesheet" href="source/plugin/tom_tcshop/images/shop_style.css?v=<?php echo $cssJsVersion;?>" />
<?php if($__ShowTchongbao == 1) { ?>
<link rel="stylesheet" href="source/plugin/tom_tchongbao/images/yinru_hb_style.css?v=<?php echo $cssJsVersion;?>" />
<?php } ?>
<link href="source/plugin/tom_tcshop/images/music/music.css" rel="stylesheet" type="text/css"/>
<script src="source/plugin/tom_tcshop/images/jquery.min-2.1.3.js" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/swiper.min.js" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/global.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<script src="source/plugin/tom_tcshop/images/html2canvas.min.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/layer_mobile/layer.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?><style>
    .layui-m-layer0 .layui-m-layerchild{width: 70%;}
    .layui-m-layercont{padding: 5px 3px;}
    #shop_details .details-info .deta-menu .menu-item a.on{ color:<?php echo $tongchengConfig['template_color'];?>; border-color:<?php echo $tongchengConfig['template_color'];?>;}
    .swiper-pagination-bullet-active{ background-color:<?php echo $tongchengConfig['template_color'];?>;}
    #shop_details .details-info{margin-bottom: 10px;}
</style>
</head>
<body id="shop_details" style="background-color:#f3f6f5;">
<?php if($__IsMiniprogram == 0 ) { ?>
<a class="back" href="javascript:void(0);" onclick="window.history.back(-1);"><img src="source/plugin/tom_tcshop/images/details_back.png"></a>
<a class="index" href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=index"><img src="source/plugin/tom_tcshop/images/details_index.png"></a>
<?php } if($tcshopInfo['mp3_url'] && $tcshopInfo['vip_level'] == 1) { ?>
<script src="source/plugin/tom_tcshop/images/music/music.js" type="text/javascript"></script>
<div class="music_play_yinfu" id="music_audio_btn" style="display: block;">
    <div id="music_yinfu" class="music_rotate"></div>
    <audio preload="auto" autoplay id="music_media" src="<?php echo $tcshopInfo['mp3_url'];?>" loop></audio>
</div>
<?php } ?>
<section class="details-info details-header">
    <?php if($topShowBox == 0 ) { ?>
    <?php if($focuspicList ) { ?>
<div class="info-item">
        <div class="swiper-container swiper-container-focuspic">
            <div class="swiper-wrapper">
                <?php if(is_array($focuspicList)) foreach($focuspicList as $key => $val) { ?>                <div class="swiper-slide">
                    <a href="javascript:void(0);"><img src="<?php echo $val['picurl'];?>" width="100%" style="object-fit: cover;height: calc(100vw*0.45);max-height: 380px;"></a>
                </div>
                <?php } ?>
            </div>
            <div class="swiper-pagination swiper-pagination-focuspic"></div>
        </div>
    </div>
    <?php } ?>
    <?php } ?>
    <?php if($topShowBox == 1 ) { ?>
    <div class="info-item" style="height:<?php echo $tcshopConfig['panorama_height_value'];?>px">
        <iframe height="100%" width="100%" src="<?php echo $tcshopInfo['vr_url'];?>" frameborder="0" allowfullscreen></iframe>
    </div>
    <?php } ?>
    <?php if($topShowBox == 2 ) { ?>
    <?php if($video_type == 'youku' ) { ?>
    <div class="info-item">
        <iframe height="<?php echo $tcshopConfig['video_height_value'];?>" width="100%" src="//player.youku.com/embed/<?php echo $video_id;?>" frameborder="0" allowfullscreen="false"></iframe>
    </div>
    <?php } ?>
    <?php if($video_type == 'qq' ) { ?>
    <div class="info-item">
        <iframe height="<?php echo $tcshopConfig['video_height_value'];?>" width="100%" src="//v.qq.com/iframe/player.html?vid=<?php echo $video_id;?>&amp;tiny=0&amp;auto=0&amp;width=100%25&amp;height=<?php echo $tcshopConfig['video_height_value'];?>" frameborder="0" allowfullscreen="false"></iframe>
    </div>
    <?php } ?>
    <?php if($video_type == 'mp4' ) { ?>
    <div class="info-item">
        <video style="background:#000;width:100%;height:<?php echo $tcshopConfig['video_height_value'];?>px" src="<?php echo $tcshopInfo['video_url'];?>" controls="controls" x5-playsinline="" playsinline="" webkit-playsinline=""></video>
    </div>
    <?php } ?>
    <?php } ?>
    <div class="info-item-title">
        <div class="title"><?php echo $tcshopInfo['name'];?></div>
        <div class="desc"><i class="tciconfont tcicon-business-hours"></i>&nbsp;<?php echo $tcshopInfo['business_hours'];?>&nbsp;&nbsp;<i class="tciconfont tcicon-hot"></i><?php echo $tcshopInfo['clicks'];?>人浏览</div>
        <?php if($isGuanzu == 1 ) { ?>
        <span class="guanzu shop__guanzu tc-template__bg tc-template__border" style="color: #FFF;background-color: #F60;" onclick="guanzu('<?php echo $__UserInfo['id'];?>','<?php echo $tcshop_id;?>');">关注<?php echo $tcshopInfo['guanzu'];?></span>
        <?php } else { ?>
        <span class="guanzu shop__guanzu tc-template__color tc-template__border" onclick="guanzu('<?php echo $__UserInfo['id'];?>','<?php echo $tcshop_id;?>');">关注<?php echo $tcshopInfo['guanzu'];?></span>
        <?php } ?>
    </div>
    <div class="info-item-address">
        <div class="dingwei_ico"><i class="tciconfont tcicon-dingwei_shi"></i></div>
        <?php if($open_wx_map == 1 ) { ?>
        <a href="javascript:void(0);" onclick="wxopenLocation();"><div class="position"><?php echo $tcshopInfo['address'];?><br/><span id="get-distance" style="font-size: 0.8em;color: #BBBBBB;">距离计算中...</span></div></a>
        <a href="javascript:void(0);" onclick="wxopenLocation();" class="qiche"><img src="source/plugin/tom_tcshop/images/qiche.png"/></a>
        <?php } else { ?>
        <a href="<?php echo $baiduMapUrl;?>" target="_blank"><div class="position"><?php echo $tcshopInfo['address'];?><br/><span id="get-distance" style="font-size: 0.8em;color: #BBBBBB;">距离计算中...</span></div></a>
        <a href="<?php echo $baiduMapUrl;?>" class="qiche"><img src="source/plugin/tom_tcshop/images/qiche.png"/></a>
        <?php } ?>
        <?php if($showBuyTelBtn == 0) { ?>
        <a href="tel:<?php echo $tcshopInfo['tel'];?>" class="tel tc-template__color"><i class="tciconfont tcicon-dianhua"></i></a>
        <?php } else { ?>
        <a href="javascript:void(0);" class="tel tc-template__color"><i class="tciconfont tcicon-dianhua"></i></a>
        <?php } ?>
    </div>
</section>
<?php if($gonggao ) { ?>
<section class="details-info">
    <section class="shop_gonggao">
        <div class="shop_gonggao-title">店铺<span>公告</span></div>
        <div class="shop_gonggao-content one_line"><?php echo $gonggao;?></div>
    </section>
</section>
<?php } if(($__ShowTcyikatong == 1 && $tequanList) ||  ($__ShowTcqianggou == 1 && $couponList) || ($__ShowTcqianggou == 1 && $qgGoodsList) || ($__ShowTcptuan == 1 && $ptGoodsList) || ($__ShowTckjia == 1 && $kjGoodsList) ) { ?>
<section class="details-info">
    <div class="youhi-title"><span class="details_title_ico">本店优惠</span></div>
    <?php if($__ShowTcyikatong == 1 ) { ?>
    <?php if($tequanList) { ?>
    <div class="youhi-item">
        <h5><span class="qiang" style="background: #ffd980;">卡</span></h5>
        <?php if(is_array($tequanList)) foreach($tequanList as $key => $val) { ?>        <div class="item-area">
            <a href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tcyikatong&site=<?php echo $site_id;?>&mod=info&tq_id=<?php echo $val['id'];?>">
        	<div class="option clearfix">
                <div class="vipcontent">
                    <?php if($val['tequan_type'] == 1 ) { ?>
                    <div class="title"><?php echo $tcyikatongConfig['card_name'];?>专享<span><?php echo $val['tequan_zhekou'];?></span>折</div>
                    <p>
                        <?php if($val['type'] == 1 ) { ?>
                        <span class="weekdays">每<?php echo $val['weeksStr'];?>可用</span>
                        <?php } ?>
                        <?php if($val['type'] == 2 ) { ?>
                        <span class="weekdays">每月<?php echo $val['daysStr'];?>可用</span>
                        <?php } ?>
                    </p>
                    <?php } ?>
                    <?php if($val['tequan_type'] == 2 ) { ?>
                    <div class="title"><?php echo $tcyikatongConfig['card_name'];?>专享<span><?php echo $val['tequan_shengprice'];?></span>元代金券</div>
                    <p>
                        <?php if($val['type'] == 1 ) { ?>
                        <span class="weekdays">每<?php echo $val['weeksStr'];?>可用</span>
                        <?php } ?>
                        <?php if($val['type'] == 2 ) { ?>
                        <span class="weekdays">每月<?php echo $val['daysStr'];?>可用</span>
                        <?php } ?>
                    </p>
                    <?php } ?>
                    <span class="btn tc-template__bg tc-template__border">立即领取</span>
                    <span class="salenum">已领<?php echo $val['lingCount'];?></span>
                </div>
            </div>
            </a>
        </div>
        <?php } ?>
    </div>
    <?php } ?>
    <?php } ?>
    <?php if($__ShowTcqianggou == 1 ) { ?>
    <?php if($couponList) { ?>
    <div class="youhi-item">
        <h5><span class="qiang" style="background: #ffb6f2;">劵</span></h5>
        <?php if(is_array($couponList)) foreach($couponList as $key => $val) { ?>        <div class="item-area">
            <a href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tcqianggou&site=<?php echo $site_id;?>&mod=coupon&goods_id=<?php echo $val['id'];?>">
        	<div class="option clearfix">
            	<div class="pic"><img src="<?php echo $val['picurl'];?>"></div>
                <div class="content">
                    <div class="title"><?php echo $val['title'];?></div>
                    <?php if($val['type_id'] == 2 ) { ?>
                    <p>
                        <span class="new_price">&nbsp;<?php echo $val['coupon_price'];?>元</span>
                        <span class="price_name">优惠劵</span>
                        <?php if($val['coupon_limit'] > 0 ) { ?>
                        <span class="old_price">满<?php echo $val['coupon_limit'];?>元可用</span>
                        <?php } ?>
                    </p>
                    <?php } ?>
                    <?php if($val['type_id'] == 3 ) { ?>
                    <p>
                        <span class="new_price">&nbsp;<?php echo $val['coupon_zhekou'];?>折</span>
                    </p>
                    <?php } ?>
                    <?php if($val['type_id'] == 4 ) { ?>
                    <p>
                        <span class="new_price">&nbsp;<?php echo $val['coupon_price'];?>元</span>
                        <span class="price_name">代金券</span>
                        <?php if($val['coupon_limit'] > 0 ) { ?>
                        <span class="old_price">满<?php echo $val['coupon_limit'];?>元可用</span>
                        <?php } ?>
                    </p>
                    <?php } ?>
                    <?php if($val['coupon_is_buy'] == 1 ) { ?>
                    <span class="btn tc-template__bg tc-template__border">购买</span>
                    <?php } else { ?>
                    <span class="btn tc-template__bg tc-template__border">免费领</span>
                    <?php } ?>
                    <span class="salenum">已领<?php echo $val['sale_num'];?></span>
                </div>
            </div>
            </a>
        </div>
        <?php } ?>
    </div>
    <?php } ?>
    <?php } ?>
    <?php if($__ShowTcqianggou == 1 ) { ?>
    <?php if($qgGoodsList) { ?>
    <div class="youhi-item">
        <h5><span class="qiang" style="background: #ff9b9b;">抢</span></h5>
        <?php if(is_array($qgGoodsList)) foreach($qgGoodsList as $key => $val) { ?>        <div class="item-area">
            <a href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tcqianggou&site=<?php echo $site_id;?>&mod=details&goods_id=<?php echo $val['id'];?>">
        	<div class="option clearfix">
            	<div class="pic"><img src="<?php echo $val['picurl'];?>"></div>
                <div class="content">
                    <div class="title"><?php echo $val['title'];?></div>
                    <p>
                        <span class="new_price">￥<?php echo $val['buy_price'];?></span>
                        <span class="old_price">￥<?php echo $val['market_price'];?></span>
                    </p>
                    <span class="btn tc-template__bg tc-template__border">去抢购</span>
                    <span class="salenum">已售<?php echo $val['sale_num'];?></span>
                </div>
            </div>
            </a>
        </div>
        <?php } ?>
        <?php if($qgGoodsCount > $tcshopConfig['details_qg_num'] ) { ?>
        <div class="item-more">
        	<a href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tcshop&site=<?php echo $site_id;?>&mod=qglist&tcshop_id=<?php echo $tcshop_id;?>">更多抢购<i></i></a>	
 		</div>
        <?php } ?>
    </div>
    <?php } ?>
    <?php } ?>
    <?php if($__ShowTcptuan == 1 ) { ?>
    <?php if($ptGoodsList) { ?>
    <div class="youhi-item">
        <h5><span class="qiang" style="background: #b1b3ff;">拼</span></h5>
        <?php if(is_array($ptGoodsList)) foreach($ptGoodsList as $key => $val) { ?>        <div class="item-area">
            <a href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tcptuan&site=<?php echo $site_id;?>&mod=goodsinfo&goods_id=<?php echo $val['id'];?>">
        	<div class="option clearfix">
            	<div class="pic"><img src="<?php echo $val['picurl'];?>"></div>
                <div class="content">
                    <div class="title"><?php echo $val['name'];?></div>
                    <p>
                        <span class="new_price">￥<?php echo $val['show_tuan_price'];?></span>
                        <span>&nbsp;&nbsp;<?php echo $val['tuan_num'];?> 人拼单</span>
                    </p>
                    <span class="btn tc-template__bg tc-template__border">去拼单</span>
                    <span class="salenum">已售<?php echo $val['sale_num'];?></span>
                </div>
            </div>
            </a>
        </div>
        <?php } ?>
        <?php if($ptGoodsCount > $tcshopConfig['details_pt_num'] ) { ?>
        <div class="item-more">
        	<a href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tcshop&site=<?php echo $site_id;?>&mod=ptlist&tcshop_id=<?php echo $tcshop_id;?>">更多拼单<i></i></a>	
 		</div>
        <?php } ?>
    </div>
    <?php } ?>
    <?php } ?>
    <?php if($__ShowTckjia == 1 ) { ?>
    <?php if($kjGoodsList) { ?>
    <div class="youhi-item">
        <h5><span class="qiang" style="    background: #a0d7ff;">砍</span></h5>
        <?php if(is_array($kjGoodsList)) foreach($kjGoodsList as $key => $val) { ?>        <div class="item-area">
            <a href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tckjia&site=<?php echo $site_id;?>&mod=details&goods_id=<?php echo $val['id'];?>">
        	<div class="option clearfix">
            	<div class="pic"><img src="<?php echo $val['picurl'];?>"></div>
                <div class="content">
                	<div class="title"><?php echo $val['title'];?></div>
                    <p>
                        <span class="new_price">￥<?php echo $val['base_price'];?></span>
                        <span class="old_price">￥<?php echo $val['goods_price'];?></span>
                    </p>
                    <span class="btn tc-template__bg tc-template__border">去减价</span>
                    <span class="salenum">已售<?php echo $val['sale_num'];?></span>
                </div>
            </div>
            </a>
        </div>
        <?php } ?>
        <?php if($kjGoodsCount > $tcshopConfig['details_kj_num'] ) { ?>
        <div class="item-more">
        	<a href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tcshop&site=<?php echo $site_id;?>&mod=kjlist&tcshop_id=<?php echo $tcshop_id;?>">更多减价<i></i></a>	
 		</div>
        <?php } ?>
    </div>
    <?php } ?>
    <?php } ?>
</section>
<?php } if($__ShowTcmall == 1 ) { if($mallGoodsList) { ?>
<section class="details-info details-info__mall">
    <div class="photo-title"><span class="details_title_ico">商家商品</span></div>
    <div class="mall-list dislay-flex">
        <?php if(is_array($mallGoodsList)) foreach($mallGoodsList as $key => $val) { ?>        <a class="mall-list__item" href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tcmall&site=<?php echo $site_id;?>&mod=goodsinfo&goods_id=<?php echo $val['id'];?>">
            <div class="mall-item__hd">
                <img src="<?php echo $val['picurl'];?>">
            </div>
            <div class="mall-item__bd">
                <div class="item-bd__title"><?php echo $val['title'];?></div>
                <div class="item-bd__price">
                    <span class="price"><span class="ico">￥</span><?php echo $val['show_buy_price'];?></span>
                    <span class="old-price">￥<?php echo $val['show_market_price'];?></span>
                </div>
            </div>
        </a>
        <?php } ?>
    </div>
    <?php if($mallGoodsCount > $tcshopConfig['details_mall_num'] ) { ?>
    <div class="photo-item-more">
        <a href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tcmall&site=<?php echo $site_id;?>&mod=shop&tcshop_id=<?php echo $tcshop_id;?>">查看更多(<?php echo $mallGoodsCount;?>)<i></i></a>	
    </div>
    <?php } ?>
</section>
<?php } } if($photoCount > 0 && $tcshopConfig['photo_show_type'] == 2 ) { ?>
<section class="details-info">
    <div class="photo-title"><span class="details_title_ico">商家相册</span></div>
    <div class="photo-item">
        <?php if(is_array($photoSmallList)) foreach($photoSmallList as $key => $val) { ?>        <a href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tcshop&site=<?php echo $site_id;?>&mod=photos&tcshop_id=<?php echo $tcshop_id;?>">
            <img src="<?php echo $val['picurl'];?>">
        </a>
        <?php } ?>
    </div>
    <?php if($photoCount > 3 ) { ?>
    <div class="photo-item-more">
        <a href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tcshop&site=<?php echo $site_id;?>&mod=photos&tcshop_id=<?php echo $tcshop_id;?>">查看更多(<?php echo $photoCount;?>)<i></i></a>	
    </div>
    <?php } ?>
</section>
<?php } ?>
<section class="details-info" style="margin-bottom: 0px;">
    <div class="content-title"><span class="details_title_ico">商家信息</span></div>
<div id="deta_menu" class="deta-menu">
    	<div class="menu-item"><a class="on" href="javascript:void(0);" data-tab="content">介绍</a></div>
        <div class="menu-item"><a href="javascript:void(0);" data-tab="youhui"><?php if($cateInfo['youhui_model_name']) { ?><?php echo $cateInfo['youhui_model_name'];?><?php } else { ?>动态<?php } ?></a></div>
    </div>
</section>
<section class="details-info" id="data_content_box">
    <div class="details-store">
        <?php if($tabsArr ) { ?>
        <div class="info-item-box" style="padding: 10px 0 0 0;border-bottom: 0px solid #f1f1f1;">
            <div class="title-bq clearfix">
                <?php if(is_array($tabsArr)) foreach($tabsArr as $key => $val) { ?>                <a href="<?php echo $val['url'];?>" class="span<?php echo $val['i'];?>"><?php echo $val['txt'];?></a>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
        <?php if($vrShowBox == 1 ) { ?>
        <div class="vr-video" style="height:<?php echo $tcshopConfig['panorama_height_value'];?>px">
            <iframe height="100%" width="100%" src="<?php echo $tcshopInfo['vr_url'];?>" frameborder="0" allowfullscreen></iframe>
        </div>
        <?php } ?>
        <?php if($videoShowBox == 1 ) { ?>
        <?php if($video_type == 'youku' ) { ?>
        <div class="vr-video">
            <iframe height="<?php echo $tcshopConfig['video_height_value'];?>" width="100%" src="//player.youku.com/embed/<?php echo $video_id;?>" frameborder="0" allowfullscreen="false"></iframe>
        </div>
        <?php } ?>
        <?php if($video_type == 'qq' ) { ?>
        <div class="vr-video">
            <iframe height="<?php echo $tcshopConfig['video_height_value'];?>" width="100%" src="//v.qq.com/iframe/player.html?vid=<?php echo $video_id;?>&amp;tiny=0&amp;auto=0&amp;width=100%25&amp;height=<?php echo $tcshopConfig['video_height_value'];?>" frameborder="0" allowfullscreen="false"></iframe>
        </div>
        <?php } ?>
        <?php if($video_type == 'mp4' ) { ?>
        <div class="vr-video">
            <video style="background:#000;width:100%;height:<?php echo $tcshopConfig['video_height_value'];?>px" src="<?php echo $tcshopInfo['video_url'];?>" controls="controls" x5-playsinline="" playsinline="" webkit-playsinline=""></video>
        </div>
        <?php } ?>
        <?php } ?>
        <?php if($content || $tcshopTuwenList ) { ?>
        <div class="store-content">
            <?php if($content ) { ?>
            <?php echo $content;?><br/>
            <?php } ?>
            <?php if($tcshopTuwenList ) { ?>
            <?php if(is_array($tcshopTuwenList)) foreach($tcshopTuwenList as $key => $val) { ?>            <p><?php echo $val['txt'];?></p>
            <p><img src="<?php echo $val['picurl'];?>"></p>
            <?php } ?>
            <?php } ?>
        </div>
        <?php } else { ?>
        <div style="width: 100%;height: 9px;clear: both;"></div>
        <?php } ?>
        <?php if($tcshopConfig['photo_show_type'] == 1 ) { ?>
        <div class="store-photo">
            <?php if($photoList ) { ?>
            <?php if(is_array($photoList)) foreach($photoList as $key => $val) { ?>            <img style="margin-bottom: 2px;" src="<?php echo $val['picurl'];?>">
            <?php } ?>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
</section>
<section class="details-info" id="data_youhui_box" style="display:none;"><?php include template('tom_tcshop:details_fl'); ?></section>
<section class="details-info">
    <div id="shop_comment">
        <?php include template('tom_tcshop:pinglun'); ?>    </div>
</section>
<?php if($__ShowTchongbao == 1 && $tchongbaoInfo['only_show'] == 1 ) { ?>
<section class="details-info">
    <div class="hb_title">
        福利已抢<font color="#f00"><?php echo $tchongbaoLogCount;?></font>/<?php echo $tchongbaoInfo['hb_count'];?>
        <a href="<?php echo $hongbaoLogListUrl;?>">看看大家的手气</a>
    </div>
    <div class="hongbaolog-list">
        <?php if($tchongbaoLogList) { ?>
        <ul>
            <?php if(is_array($tchongbaoLogList)) foreach($tchongbaoLogList as $key => $value) { ?>            <li><img src="<?php echo $value['user_picurl'];?>"><?php echo $value['nickname'];?><span><?php echo $value['money'];?></span></li>
            <?php } ?>
        </ul>
        <?php } else { ?>
        <div class="no-hb-ts">还没有人领取那，快点击领取福利吧！</div>
        <?php } ?>
    </div>
</section>
<?php } if($showXiaoQrcode == 1 ) { ?>
<section class="details-info">
    <div class="xiao_qrcode_loading tcui-loadmore"><i class="tcui-loading"></i>小程序码生成中...</div>
    <div class="xiao_qrcode_loading id_xiao_qrcode_error" style="display: none;">小程序码生成出错</div>
    <div class="xiao_qrcode_box id_xiao_qrcode" style="display: none;"><img src=""></div>
    <div class="xiao_qrcode_msg" style="display: none;"><span><?php echo $tcshopInfo['name'];?></span>专属小程序码</div>
</section>
<?php } if($tcshopConfig['open_detail_fujin'] == 1 ) { ?>
<section class="details-info">
    <div class="shop_list">
        <div class="shop_list-title">附近推荐</div>
        <div class="list-item" id="index-list" style="background: #f2f2f2;"></div>
        <div class="list-msg" style="display: none;" id="load-html">加载中...</div>
        <div class="list-msg" style="display: none;" id="no-load-html">没有更多商家</div>
        <div class="list-msg" style="display: none;" id="no-list-html">没有相关商家</div>
    </div>
</section>
<?php } elseif($showXiaoQrcode == 0) { ?>
<section class="no-more__tip">
    <img src="source/plugin/tom_tcshop/images/no-more__tip.png">
</section>
<?php } ?>
<section class="details_footer">
<div class="details-footer">
    	<div class="footermenu footer-wx">
        	<a href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tcshop&site=<?php echo $site_id;?>&mod=index&prand=<?php echo $prand;?>">
        		<i class="icon tciconfont tcicon-nav__index"></i>
                <span>好店</span>
        	</a>
        </div>
        <?php if($tcshopInfo['link_name']) { ?>
        <div class="footermenu footer-wx">
        	<a href="<?php echo $tcshopInfo['link'];?>">
        		<i class="icon tciconfont tcicon-nav_fenlei"></i>
                <span><?php echo $tcshopInfo['link_name'];?></span>
        	</a>
        </div>
        <?php } else { ?>
        <?php if($tcshopConfig['info_footer_ruzhu'] == 1) { ?>
        <div class="footermenu footer-wx">
        	<a href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tcshop&site=<?php echo $site_id;?>&mod=ruzhu&prand=<?php echo $prand;?>">
        		<i class="icon tciconfont tcicon-shop"></i>
                <span>入驻</span>
        	</a>
        </div>
        <?php } ?>
        <?php } ?>
    	<div class="footermenu footer-wx">
        	<a href="javascript:;" onclick="kefu();">
        		<i class="icon tciconfont tcicon-weixin"></i>
                <span>微信</span>
        	</a>
        </div>
    	<div class="footermenu footer-tel tc-template__bg">
            <?php if($showBuyTelBtn == 1) { ?>
            <a href="javascript:void(0);" onclick="payTel(<?php echo $tcshopInfo['id'];?>);">
        		<span class="tel-pic"><img src="source/plugin/tom_tcshop/images/shop_details_nav_tel.png">付费查看</span>
                <span><?php echo $tcshopInfo['tel'];?></span>
        	</a>
            <?php } elseif($showBuyTelBtn == 2) { ?>
            <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=personal">
        		<span class="tel-pic"><img src="source/plugin/tom_tcshop/images/shop_details_nav_tel.png">付费查看</span>
                <span><?php echo $tcshopInfo['tel'];?></span>
        	</a>
            <?php } else { ?>
            <a href="tel:<?php echo $tcshopInfo['tel'];?>">
        		<span class="tel-pic"><img src="source/plugin/tom_tcshop/images/shop_details_nav_tel.png">一键拨号</span>
                <span><?php echo $tcshopInfo['tel'];?></span>
        	</a>
            <?php } ?>
        </div>
    </div>
</section>
<?php if($showBuyTelBtn == 1) { ?>
<script type="text/javascript">
var submintPayStatus = 0;
function payTel(tcshop_id){
    if(submintPayStatus == 1){
        return false;
    }
    submintPayStatus = 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $payTelUrl;?>",
        dataType : "json",
        data: "tcshop_id="+tcshop_id,
        success: function(data){
            if(data.status == 200) {
                tusi("下单成功，立即支付");
                setTimeout(function(){window.location.href=data.payurl+"&prand=<?php echo $prand;?>";},500);
            }else if(data.status == 302){
                tusi("没有安装TOM支付中心插件");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 303){
                tusi("生成微信订单失败");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 304){
                tusi("插入订单数据失败");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 400){
                tusi("金额有误");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else{
                tusi("支付错误");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }
        }
    });
}
</script>
<?php } include template('tom_tcshop:details_hb'); ?><script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<div style="display: none;"><?php echo $tongchengConfig['tongji_code'];?></div>
<script src="//api.map.baidu.com/api?v=2.0&ak=<?php echo $tcshopConfig['baidu_js_ak'];?>" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
    <?php if($topShowBox == 0 ) { ?>
    <?php if($focuspicList ) { ?>
    var swiper2 = new Swiper('.swiper-container-focuspic', {
        pagination: '.swiper-pagination-focuspic',
        paginationClickable: true,
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: 2500,
        autoplayDisableOnInteraction: false
    });
    <?php } ?>
    <?php } ?>

    $('#deta_menu').on('click', '.menu-item a', function(){
        $(this).parent('.menu-item').siblings().find('a').removeClass('on');
        $(this).addClass('on');
        var onTab = $(this).data('tab');
        if(onTab == 'content'){
            $("#data_content_box").show();
            $("#data_youhui_box").hide();
        }else if(onTab == 'youhui'){
            $("#data_content_box").hide();
            $("#data_youhui_box").show();
        }else{
            return;
        }
    })
});

function loadXiaoQrcodeSrc(){
    $.ajax({
        type: "GET",
        url: '<?php echo $showXiaoQrcodeUrl;?>',
        data: {v:1},
        success: function(msg){
            var dataarr = msg.split('|');
            dataarr[0] = $.trim(dataarr[0]);
            if(dataarr[0] == 'OK'){
                $('.id_xiao_qrcode img').attr('src', dataarr[1]);
                $('.xiao_qrcode_loading').hide();
                $('.xiao_qrcode_box').show();
                $('.xiao_qrcode_msg').show();
            }else{
                $('.xiao_qrcode_loading').hide();
                $('.id_xiao_qrcode_error').show();
            }
        }
    });
}

var scrollRunStatus = 0;
$(window).scroll(function () {
    var runScrollTop       = $(this).scrollTop();
    if(runScrollTop > 100 && scrollRunStatus == 0){
       scrollRunStatus = 1;
       console.log('runScrollTop:'+runScrollTop);
       $.get("<?php echo $ajaxAddLbsUrl;?>");
       $.get("<?php echo $ajaxUpdateToprandUrl;?>");
       loadPinglunMore(1);
       <?php if($showXiaoQrcode == 1 ) { ?>
       loadXiaoQrcodeSrc();
       <?php } ?>
       <?php if($tcshopConfig['open_detail_fujin'] == 1 ) { ?>
        indexLoadList();
        <?php } ?>
    }
});

$(document).ready(function(){
   $.get("<?php echo $ajaxCommonClicksUrl;?>");
   $.get("<?php echo $ajaxClicksUrl;?>");
});

var show_gonggao_all_line = 0;
$('.shop_gonggao-content').click(function(){
    if(show_gonggao_all_line == 1){
        show_gonggao_all_line = 0;
        $(this).removeClass("all_line");
        $(this).addClass("one_line");
    }else{
        show_gonggao_all_line = 1;
        $(this).removeClass("one_line");
        $(this).addClass("all_line");
    }
})

function kefu(){
    layer.open({
        content: '<img src="<?php echo $kefu_qrcode;?>">'
        ,btn: '确认'
    });
}

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
        url: "<?php echo $__TongchengHost;?><?php echo $ajaxDetailsLoadListUrl;?>",
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

var getDistanceStatus = 0;
function getDistance() {
    if(getDistanceStatus == 1){
        return false;
    }
    getDistanceStatus = 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxDistanceUrl;?>",
        data: {v:1},
        success: function(msg){
            getDistanceStatus = 0;
            var data = eval('('+msg+')');
            if(data == 205){
                return false;
            }else{
                $("#get-distance").html(data);
            }
        }
    });
}

$(document).ready(function(){
   setTimeout(function(){getDistance();},500);
});

$(window).scroll(function () {
    var scrollTop       = $(this).scrollTop();
    var scrollHeight    = $(document).height();
    var windowHeight    = $(this).height();
    if ((scrollTop + windowHeight) >= (scrollHeight * 0.9)) {
        <?php if($tcshopConfig['open_detail_fujin'] == 1 ) { ?>
        scrollLoadList();
        <?php } ?>
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
        url: "<?php echo $__TongchengHost;?><?php echo $ajaxDetailsLoadListUrl;?>",
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

var guanzu_count = "<?php echo $tcshopInfo['guanzu'];?>";
guanzu_count = guanzu_count * 1;
function guanzu(user_id,tcshop_id){
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxGuanzuUrl;?>",
        data: "user_id="+user_id+"&tcshop_id="+tcshop_id,
        success: function(msg){
            var msg = $.trim(msg);
            if(msg == '100'){
                guanzu_count = guanzu_count - 1;
                $('.shop__guanzu').removeClass("tc-template__bg").removeAttr('style').addClass('tc-template__color');
                $('.shop__guanzu').html("关注"+guanzu_count);
                tusi("已经取消关注");
            }else if(msg == '200'){
                guanzu_count = guanzu_count + 1;
                $('.shop__guanzu').removeClass("tc-template__color").addClass("tc-template__bg tc-template__border").css({'color':'#fff','background':'#f60'});
                $('.shop__guanzu').html("关注"+guanzu_count);
                tusi("关注成功");
            }else{
                tusi("关注失败");
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
      'onMenuShareQQ',
      'previewImage',
      'openLocation',
      'getLocation'
    ]
});

var getLocationStatus = 0, latitude = '', longitude = '';
wx.ready(function () {
    <?php if($tcshopInfo['mp3_url'] && $tcshopInfo['vip_level'] == 1 ) { ?>
    var audio2 = $('#music_media');
    audio2[0].play();
    <?php } ?>
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
                        $.get("<?php echo $ajaxUpdateLbsUrl;?>&latitude="+data.points[0].lat+"&longitude="+data.points[0].lng);
                        <?php if($__ShowTchongbao == 1 && $lqHongbaoStatus != 1 && $tchongbaoInfo['only_show'] == 1 && $openLocaltionDistance == 1) { ?>
                            $('#latitude').val(data.points[0].lat);
                            $('#longitude').val(data.points[0].lng);
                            locationRequest();
                        <?php } ?>
                    } else {
                        $.get("<?php echo $ajaxUpdateLbsUrl;?>&latitude="+res.latitude+"&longitude="+res.longitude);
                        <?php if($__ShowTchongbao == 1 && $lqHongbaoStatus != 1 && $tchongbaoInfo['only_show'] == 1 && $openLocaltionDistance == 1) { ?>
                            $('#latitude').val(res.latitude);
                            $('#longitude').val(res.longitude);
                            locationRequest();
                        <?php } ?>
                    }
                    setTimeout(function(){getDistance();},500);
                });
            },
            fail: function(res){
                $('#loadingToast').hide();
                tusi("定位失败");
            },
            cancel: function(res){
                getLocationStatus = 2;
                $('#loadingToast').hide();
                tusi("用户拒绝授权获取地理位置");
            }
        });
    }
    wxGetLocation();
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
<script src="//map.qq.com/api/js?v=2.exp&libraries=convertor" type="text/javascript"></script>
<script>
function wxopenLocation(){
    //ת���ٶ�����Ϊ��Ѷ����
    qq.maps.convertor.translate(new qq.maps.LatLng(<?php echo $tcshopInfo['latitude'];?>,<?php echo $tcshopInfo['longitude'];?>), 3, function(res){
        latlng = res[0];
        console.log(latlng.lat);
        console.log(latlng.lng);
        wx.openLocation({
            latitude: latlng.lat, // γ�ȣ�����������ΧΪ90 ~ -90
            longitude: latlng.lng, // ���ȣ�����������ΧΪ180 ~ -180��
            name: '<?php echo $tcshopInfo['name'];?>', // λ����
            address: '<?php echo $tcshopInfo['address'];?>', // ��ַ����˵��
            scale: 28, // ��ͼ���ż���,����ֵ,��Χ��1~28��Ĭ��Ϊ���
            infoUrl: '' // �ڲ鿴λ�ý���ײ���ʾ�ĳ�����,�ɵ����ת
        });
    });
}
// 111
</script>
</body>
</html>