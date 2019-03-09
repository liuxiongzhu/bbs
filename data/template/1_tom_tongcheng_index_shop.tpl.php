<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<link rel="stylesheet" href="source/plugin/tom_tcshop/images/yinru_shop_style.css?v=<?php echo $cssJsVersion;?>" />
<div class="index_shop">
    <div class="clear5" style="height: 8px;"></div>
    <div class="index_shop_title">
        <div class="index_shop_title_left tc-template__color"><em class="index_shop_title_icon"></em>本地商家</div>
        <div class="index_shop_title_right"><a href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=index">全部<i class="tciconfont tcicon-jiantou__you"></i></a></div>
    </div>
    <div class="clear5"></div>
    <?php if($tcshopConfig['index_shop_show'] == 1) { ?>
    <div class="index_shop_list">
        <div class="swiper-container swiper-container-shoplist" style="height:100%;">
            <div class="swiper-wrapper">
                <?php if(is_array($tcshopList)) foreach($tcshopList as $key => $val) { ?>                <a class="swiper-slide index_shop_list_item" href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=details&amp;dpid=<?php echo $val['id'];?>">
                    <div class="index_shop_list_item_img tc-template__color">
                        <img style="border-radius: 5px;" src="<?php echo $val['picurl'];?>">
                        <?php if($val['vip_level'] == 1) { ?>
                        <i class="vip"></i>
                        <?php } ?>
                        <?php if($val['topstatus'] == 1) { ?>
                        <span style="display: none;" class="index_shop_list_item_top" style="display: inline-block;width: 30px;height: 30px; position: absolute;color: #fff;right: 0;top:0;text-align: center;left: inherit;"></span>
                        <?php } ?>
                    </div>
                    <div class="index_shop_list_item_txt"><?php echo $val['name'];?></div>
                </a>
                <?php } ?>
                <a class="swiper-slide index_shop_list_item" href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=index">
                    <div class="index_shop_list_item_img tc-template__color" style="line-height: 90px; font-size: 1.2em;color: #ff5a00;">
                        更多商家
                    </div>
                    <div class="index_shop_list_item_txt"></div>
                </a>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php if($tcshopConfig['index_shop_show'] == 2) { ?>
    <div class="shop_list" style="margin-top: 0px;">
        <div class="list-item">
            <?php if(is_array($tcshopList)) foreach($tcshopList as $key => $val) { ?>            <div class="item-box clearfix" style="border-top: 1px solid #eee;">
                <div class="item-pic">
                    <a href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=details&amp;dpid=<?php echo $val['id'];?>">
                        <img src="<?php echo $val['picurl'];?>">
                        <?php if($val['vip_level'] == 1) { ?><i class="vip"></i><?php } ?>
                    </a>
                </div>
                <div class="item-content">
                    <div class="content">
                        <h5>
                            <a href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=details&amp;dpid=<?php echo $val['id'];?>">
                                <?php if($val['topstatus'] == 1) { ?><span class="icon top"></span><?php } ?>
                                <?php echo $val['name'];?>
                                <?php if($val['video_type'] == 1) { ?>
                                <span class="icon video"></span>
                                <?php } elseif($val['video_type'] == 2) { ?>
                                <span class="icon video_720"></span>
                                <?php } ?>
                            </a>
                        </h5>
                        <a href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=details&amp;dpid=<?php echo $val['id'];?>">
                            <p class="xinxi tc-template__color" style="color: #FDA233;">营业时间：<?php echo $val['business_hours'];?></p>
                            <p class="nr"><?php echo $val['address'];?></p>
                        </a>
                    </div>
                    <div class="details">
                        <div class="tel"><a href="tel:<?php echo $val['tel'];?>"></a></div>
                        <div class="dist"><?php echo $val['clicks'];?>浏览</div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="list-msg" style="height: 30px;line-height: 30px;"><a href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=index" style="color: #807f7f;">点击查看更多</a></div>
    </div>
    <?php } ?>
    <div class="clear5"></div>
</div>
<div class="clear5"></div>
<?php if($tcshopConfig['index_shop_show'] == 1) { ?>
<script type="text/javascript">
$(document).ready(function(){
    var swiper3 = new Swiper('.swiper-container-shoplist', {
        spaceBetween: 15,
        slidesPerView : 'auto',
    });
});
</script>
<?php } ?>
