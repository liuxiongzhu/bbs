<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<footer class="new-footer">
    <section class="new-footer__box dislay-flex">
        <a class="flex footer-box__item" href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=index&prand=<?php echo $prand;?>">
            <i class="tciconfont tcicon-nav__index"></i>
            <section class="text1">首页</section>
        </a>
        <?php if($__ShowTcshop == 1 ) { ?>
        <a class="flex footer-box__item " href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tcshop&site=<?php echo $site_id;?>&mod=index&prand=<?php echo $prand;?>">
            <i class="tciconfont tcicon-shop"></i>
            <section class="text1">好店</section>
        </a>
        <?php } else { ?>
        <a class="flex footer-box__item " href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=search&prand=<?php echo $prand;?>">
            <i class="tciconfont tcicon-nav__shoucang"></i>
            <section class="text1">分类</section>
        </a>
        <?php } ?>
        <a class="flex footer-box__item footer-box__fabu tc-template__color" href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=fabu&prand=<?php echo $prand;?>">
            <i class="tciconfont tcicon-fabu"></i>
            <section class="text1">发布</section>
        </a>
        <a class="flex footer-box__item on tc-template__color" href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tchongbao&site=<?php echo $site_id;?>&mod=index&prand=<?php echo $prand;?>">
            <i class="tciconfont tcicon-hongbao"></i>
            <section class="text1">红包</section>
        </a>
        <a class="flex footer-box__item " href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=personal&prand=<?php echo $prand;?>">
            <font class="iconfont">
              <?php if($pmNewNum > 0 ) { ?><i><?php echo $pmNewNum;?></i><?php } ?>
            <em class="tciconfont tcicon-nav__my"></em>
            </font>
            <section class="text1">我的</section>
        </a>
    </section>
</footer>