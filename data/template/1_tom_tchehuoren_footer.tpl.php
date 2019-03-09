<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<footer class="new-footer">
    <section class="new-footer__box dislay-flex">
        <a class="flex footer-box__item " href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=index&amp;prand=<?php echo $prand;?>">
            <i class="tciconfont tcicon-nav__index"></i>
            <section class="text1">首页</section>
        </a>
        <?php if($__ShowTcshop == 1 ) { ?>
        <a class="flex footer-box__item " href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=index&amp;prand=<?php echo $prand;?>">
            <i class="tciconfont tcicon-shop"></i>
            <section class="text1">好店</section>
        </a>
        <?php } else { ?>
        <a class="flex footer-box__item " href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=search&amp;prand=<?php echo $prand;?>">
            <i class="tciconfont tcicon-nav__shoucang"></i>
            <section class="text1">分类</section>
        </a>
        <?php } ?>
        <a class="flex footer-box__item footer-box__fabu tc-template__color" href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=fabu&amp;prand=<?php echo $prand;?>">
            <i class="tciconfont tcicon-fabu"></i>
            <section class="text1">发布</section>
        </a>
        <?php if($tongchengConfig['footer_nav_mod'] == 1 ) { ?>
        <a class="flex footer-box__item " href="<?php echo $footer_nav_content_link;?>">
            <i class="tciconfont tcicon-nav_fenlei"></i>
            <section class="text1"><?php echo $footer_nav_content_name;?></section>
        </a>
        <?php } ?>
        <?php if($tongchengConfig['footer_nav_mod'] == 2 ) { ?>
        <a class="flex footer-box__item  <?php if($_GET['mod'] == 'message' ) { ?>on<?php } ?>" href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=message&amp;prand=<?php echo $prand;?>">
            <font class="iconfont">
            <?php if($pmNewNum > 0 ) { ?><i><?php echo $pmNewNum;?></i><?php } ?>
                <em class="tciconfont tcicon-nav__message"></em>
            </font>
            <section class="text1">消息</section>
        </a>
        <?php } ?>
        <?php if($tongchengConfig['footer_nav_mod'] == 3 ) { ?>
        <a class="flex footer-box__item " href="plugin.php?id=tom_tchongbao&amp;site=<?php echo $site_id;?>&amp;mod=index&amp;prand=<?php echo $prand;?>">
            <i class="tciconfont tcicon-hongbao"></i>
            <section class="text1">红包</section>
        </a>
        <?php } ?>
        <?php if($tongchengConfig['footer_nav_mod'] == 4 ) { ?>
        <a class="flex footer-box__item " href="plugin.php?id=tom_tcqianggou&amp;site=<?php echo $site_id;?>&amp;mod=index&amp;prand=<?php echo $prand;?>">
            <i class="tciconfont tcicon-qianggou"></i>
            <section class="text1">抢购</section>
        </a>
        <?php } ?>
        <?php if($tongchengConfig['footer_nav_mod'] == 5 ) { ?>
        <a class="flex footer-box__item " href="plugin.php?id=tom_tcptuan&amp;site=<?php echo $site_id;?>&amp;mod=index&amp;prand=<?php echo $prand;?>">
            <i class="tciconfont tcicon-ptuan"></i>
            <section class="text1">拼单</section>
        </a>
        <?php } ?>
        <?php if($tongchengConfig['footer_nav_mod'] == 6 ) { ?>
        <a class="flex footer-box__item " href="plugin.php?id=tom_tcmall&amp;site=<?php echo $site_id;?>&amp;mod=index&amp;prand=<?php echo $prand;?>">
            <i class="tciconfont tcicon-mall"></i>
            <section class="text1">商城</section>
        </a>
        <?php } ?>
        <a class="flex footer-box__item  " href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=personal&amp;prand=<?php echo $prand;?>">
            <font class="iconfont">
            <?php if($tongchengConfig['footer_nav_mod'] != 2 ) { ?>
              <?php if($pmNewNum > 0 ) { ?><i><?php echo $pmNewNum;?></i><?php } ?>
            <?php } ?>
            <em class="tciconfont tcicon-nav__my"></em>
            </font>
            <section class="text1">我的</section>
        </a>
    </section>
</footer>