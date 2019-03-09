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
<title>我的 - <?php echo $__SitesInfo['name'];?></title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/iconfont/iconfont.css?v=<?php echo $cssJsVersion;?>" />
<script src="source/plugin/tom_tongcheng/images/jquery.min-2.1.3.js" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/layer_mobile/layer.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?><style>
.layui-m-layer0 .layui-m-layerchild{width: 70%;}
.layui-m-layercont{padding: 5px 3px;}
.top__bg{background: <?php echo $tongchengConfig['template_color'];?> url(source/plugin/tom_tongcheng/images/personal/bg.png)no-repeat;background-size: 100% 100%;}
.personal_nav .nav-nav__mall a .mall_hd .tciconfont{color: <?php echo $tongchengConfig['template_color'];?>;}
</style>
</head>
<body>
<?php if($subscribeFlag==2) { ?>
<section id="subscribe_box" class="personal_guanzu_pormpt">
    <div class="guanzu_pormpt_area guanzu_pormpt_left">
        <div class="guanzu_pic"><img src="<?php echo $tongchengConfig['fwh_logo'];?>"></div>
        <div class="guanzu_text">
            <h5><?php echo $tongchengConfig['fwh_name'];?></h5>
            <p><?php echo $tongchengConfig['fwh_desc'];?></p>
        </div>
    </div>
    <div class="guanzu_pormpt_area guanzu_pormpt_right">
        <div class="guanzu_button tc-template__bg" onclick="guanzu();">关注</div>
        <div class="guanzu_close" onclick="hide_guanzu();"></div>
    </div>
</section>
<?php } ?>
<section class="mainer">
   <section class="wrap">
        <section class="user-page">
            <section class="user-wrap top__bg" style="position: relative;overflow: hidden;">
                  <section class="user-page-avatar">
                       <section class="user-avatar-pic">
                            <img src="<?php echo $__UserInfo['picurl'];?>" />
                       </section>
                  </section>
                  <section class="user-avatar-extend">
                       <h3><a><?php echo $__UserInfo['nickname'];?></a></h3>
                       <p><a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=myedit">我的资料(UID:<?php echo $__UserInfo['id'];?>)</a></p>
                  </section>
                 <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=personal&amp;act=set">
                    <div class="personal_set">
                        <img src="source/plugin/tom_tongcheng/images/personal/set.png">
                    </div>
                 </a>
                  <?php if($__ShowTcyikatong==1) { ?>
                  <a href="plugin.php?id=tom_tcyikatong&amp;site=<?php echo $site_id;?>&amp;mod=index">
                      <div class="personal_vip">
                         <div class="personal_vip_box"><?php echo $tcyikatongConfig['card_name'];?></div>
                         <div class="personal_vip_msg">查看专属特权</div>
                     </div>
                  </a>
                  <?php } ?>
            </section>
            <section class="personal_tongji clearfix">
                <ul class="clearfix">
                    <li>
                        <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=scorelog">
                            <p class="num"><?php echo $__UserInfo['score'];?></p>
                            <p class="title">金币</p>
                        </a>
                    </li>
                    <li>
                        <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=money">
                            <p class="num"><?php echo $__UserInfo['money'];?></p>
                            <p class="title">钱包</p>
                        </a>
                    </li>
                    <li>
                        <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=message">
                            <?php if($pmNewNum > 0) { ?>
                            <p class="num"><span><?php echo $pmNewNum;?></span></p>
                            <?php } else { ?>
                            <p class="num"><?php echo $pmNewNum;?></p>
                            <?php } ?>
                            <p class="title">消息</p>
                        </a>
                    </li>
                </ul>
            </section>
            <?php if($__ShowTcmall == 1) { ?>
            <section class="personal_nav_title clearfix">
                <div class="personal_nav_title_left personal_mall_title">我的订单<a class="more" href="plugin.php?id=tom_tcmall&amp;site=<?php echo $site_id;?>&amp;mod=order">查看全部<i class="tciconfont tcicon-jiantou__you"></i></a></div>
            </section>
            <section class="personal_nav">
                <div class="nav-nav__mall clearfix dislay-flex">
                    <a class="flex" href="plugin.php?id=tom_tcmall&amp;site=<?php echo $site_id;?>&amp;mod=order&amp;type=1">
                        <div class="mall_hd">
                            <i class="tciconfont tcicon-mall__daifukuan"></i>
                            <?php if($daiFuKuanCount > 0) { ?>
                            <span class="num"><?php echo $daiFuKuanCount;?></span>
                            <?php } ?>
                        </div>
                        <p>!order_nav_1!</p>
                    </a>
                    <a class="flex" href="plugin.php?id=tom_tcmall&amp;site=<?php echo $site_id;?>&amp;mod=order&amp;type=2">
                        <div class="mall_hd">
                            <i class="tciconfont tcicon-mall__daifahuo"></i>
                            <?php if($daiFaHuoCount > 0) { ?>
                            <span class="num"><?php echo $daiFaHuoCount;?></span>
                            <?php } ?>
                        </div>
                        <p>!order_nav_2!</p>
                    </a>
                    <a class="flex" href="plugin.php?id=tom_tcmall&amp;site=<?php echo $site_id;?>&amp;mod=order&amp;type=3">
                        <div class="mall_hd">
                            <i class="tciconfont tcicon-mall__daishouhuo"></i>
                            <?php if($daiShouHuoCount > 0) { ?>
                            <span class="num"><?php echo $daiShouHuoCount;?></span>
                            <?php } ?>
                        </div>
                        <p>!order_nav_3!</p>
                    </a>
                    <a class="flex" href="plugin.php?id=tom_tcmall&amp;site=<?php echo $site_id;?>&amp;mod=order&amp;type=4">
                        <div class="mall_hd">
                            <i class="tciconfont tcicon-mall__daipingjia"></i>
                            <?php if($daiPinglunCount > 0) { ?>
                            <span class="num"><?php echo $daiPinglunCount;?></span>
                            <?php } ?>
                        </div>
                        <p>!order_nav_4!</p>
                    </a>
                </div>
            </section>
            <?php } ?>
            <section class="personal_nav_title clearfix">
                <div class="personal_nav_title_left">我的服务</div>
            </section>
            <section class="personal_nav">
                <div class="nav-nav clearfix">
                    <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=mylist">
                        <img src="source/plugin/tom_tongcheng/images/personal/nav-tc.png">
                        <p>我的信息</p>
                    </a>
                    <?php if($__ShowTcqianggou == 1) { ?>
                    <a href="plugin.php?id=tom_tcqianggou&amp;site=<?php echo $site_id;?>&amp;mod=mylist&amp;type=1">
                        <img src="source/plugin/tom_tongcheng/images/personal/nav-tcqianggou.png">
                        <p>我的抢购</p>
                    </a>
                    <?php } ?>
                    <?php if($__ShowTcptuan == 1) { ?>
                    <a href="plugin.php?id=tom_tcptuan&amp;site=<?php echo $site_id;?>&amp;mod=order">
                        <img src="source/plugin/tom_tongcheng/images/personal/nav-tcptuan.png">
                        <p>我的拼单</p>
                    </a>
                    <?php } ?>
                    <?php if($__ShowTckjia == 1) { ?>
                    <a href="plugin.php?id=tom_tckjia&amp;site=<?php echo $site_id;?>&amp;mod=mylist">
                        <img src="source/plugin/tom_tongcheng/images/personal/nav-tckjia.png">
                        <p>我的减价</p>
                    </a>
                    <?php } ?>
                    <?php if($__ShowTcqianggou == 1) { ?>
                    <a href="plugin.php?id=tom_tcqianggou&amp;site=<?php echo $site_id;?>&amp;mod=mylist&amp;type=2">
                        <img src="source/plugin/tom_tongcheng/images/personal/nav-tckaquan.png">
                        <p>我的卡券</p>
                    </a>
                    <?php } ?>
                    <?php if($__ShowTc114 == 1) { ?>
                    <a href="plugin.php?id=tom_tc114&amp;site=<?php echo $site_id;?>&amp;mod=mylist">
                        <img src="source/plugin/tom_tongcheng/images/personal/nav-tc114.png">
                        <p>电话本</p>
                    </a>
                    <?php } ?>
                    <?php if($__ShowLove == 1) { ?>
                    <a href="plugin.php?id=tom_love&amp;mod=index" style="display:none;">
                        <img src="source/plugin/tom_tongcheng/images/personal/nav-love.png">
                        <p>婚恋交友</p>
                    </a>
                    <?php } ?>
                    <?php if($__ShowTchehuoren == 1) { ?>
                    <a href="plugin.php?id=tom_tchehuoren&amp;site=<?php echo $site_id;?>&amp;mod=index">
                        <img src="source/plugin/tom_tongcheng/images/personal/nav-tchehuoren.png">
                        <p>合伙人</p>
                    </a>
                    <?php } ?>
                    <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=myorder" style="display:none;">
                        <img src="source/plugin/tom_tongcheng/images/personal/nav-order.png">
                        <p>同城订单</p>
                    </a>
                    <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=mycollect">
                        <img src="source/plugin/tom_tongcheng/images/personal/nav-zan.png">
                        <p>我的点赞</p>
                    </a>
                    <?php if($__ShowTcmall == 1) { ?>
                    <a href="plugin.php?id=tom_tcmall&amp;site=<?php echo $site_id;?>&amp;mod=collect">
                        <img src="source/plugin/tom_tongcheng/images/personal/nav-shoucang.png">
                        <p>商品收藏</p>
                    </a>
                    <?php } ?>
                    <?php if($__ShowTcshop == 1) { ?>
                    <a href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=guanzulist">
                        <img src="source/plugin/tom_tongcheng/images/personal/nav-guanzu.png?v=2">
                        <p>店铺关注</p>
                    </a>
                    <?php } ?>
                </div>
            </section>
            <?php if($showTcshopBtn == 1) { ?>
            <section class="personal_nav_title clearfix">
                <div class="personal_nav_title_left">商家服务</div>
            </section>
            <section class="personal_nav">
                <div class="nav-nav2 clearfix">
                    <a href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=store">
                        <img src="source/plugin/tom_tongcheng/images/personal/nav-store.png">
                        <p>管理中心</p>
                    </a>
                    <a href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=mylist">
                        <img src="source/plugin/tom_tongcheng/images/personal/nav-tcshop.png">
                        <p>我的店铺</p>
                    </a>
                    <a href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=money">
                        <img src="source/plugin/tom_tongcheng/images/personal/nav-money.png">
                        <p>运营账户</p>
                    </a>
                </div>
            </section>
            <?php } ?>
            <section class="personal_nav_title clearfix">
                <div class="personal_nav_title_left">必备工具</div>
            </section>
            <section class="personal_nav">
                <div class="nav-nav2 clearfix">
                    <a  href="javascript:void(0);" onclick="tongzhi();">
                        <img src="source/plugin/tom_tongcheng/images/personal/nav-tongzhi.png">
                        <p>开启通知</p>
                    </a>
                    <a  href="javascript:void(0);" onclick="kefu();">
                        <img src="source/plugin/tom_tongcheng/images/personal/nav-kefu.png">
                        <p>平台客服</p>
                    </a>
                    <a  href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=help">
                        <img src="source/plugin/tom_tongcheng/images/personal/nav-help.png">
                        <p>帮助中心</p>
                    </a>
                </div>
            </section>
        </section>
       <section class="page_rgs">
           <section class="btn-group" style="background-color: #f2f2f2;">
                <?php if($openMajiaStatus ==1 ) { ?>
                <input onclick="location.href='plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=majia';" type="button" class="tcui-btn tcui-btn_primary tc-template__bg" value="马甲中心">
                <?php } ?>
                <?php if($__UserInfo['groupid']==1 && $site_id ==1 ) { ?>
                <input onclick="location.href='plugin.php?id=tom_tongcheng&site=1&mod=managerList';" type="button" class="tcui-btn tcui-btn_primary tc-template__bg" value="管理后台">
                <?php } ?>
                <?php if($__UserInfo['groupid']==2 && $site_id ==$__UserInfo['groupsiteid'] ) { ?>
                <input onclick="location.href='plugin.php?id=tom_tcadmin&site=<?php echo $site_id;?>&mod=index';" type="button" class="tcui-btn tcui-btn_primary tc-template__bg" value="管理后台">
                <?php } ?>
            </section>
        </section>
       <?php if($__MemberInfo ) { ?>
           <?php if($__IsWeixin == 1 && $ucenterConfig['login_type'] == 3 ) { ?>
           <section class="page_rgs">
                <section class="btn-group" style="background-color: #f2f2f2;">
                    <input type="button" id="id_login_out" style="color: #FFF;background-color: #04be02;" class="tcui-btn tcui-btn_primary" value="退出当前登录">
                </section>
            </section>
           <?php } ?>
           <?php if($__IsWeixin == 0 ) { ?>
           <section class="page_rgs">
                <section class="btn-group" style="background-color: #f2f2f2;">
                    <input type="button" id="id_login_out" style="color: #FFF;background-color: #04be02;" class="tcui-btn tcui-btn_primary" value="退出当前登录">
                </section>
            </section>
           <?php } ?>
       <?php } ?>
   </section>
</section><?php include template('tom_tongcheng:footer'); ?><div style="display: none;"><?php echo $tongchengConfig['tongji_code'];?></div>
<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<script>

function kefu(){
    layer.open({
        content: '<img src="<?php echo $kefuQrcodeSrc;?>"><p>长按二维码添加客服微信<p/>'
        ,btn: '确认'
      });
}

function guanzu(){
    layer.open({
        content: '<img src="<?php echo $tongchengConfig['fwh_qrcode'];?>"><p>长按二维码识别关注<p/>'
        ,btn: '确认'
      });
}

function tongzhi(){
    layer.open({
        content: '<img src="<?php echo $tongchengConfig['fwh_qrcode'];?>"><p>长按二维码，开启平台消息实时通知<p/>'
        ,btn: '确认'
      });
}

function hide_guanzu(){
    $("#subscribe_box").hide();
}
    
$(document).ready(function(){
    <?php if($__UserInfo['status'] == 2) { ?>
    tusi("你已经涉嫌违规，被平台暂时封号");
    <?php } ?>
   $.get("<?php echo $ajaxCommonClicksUrl;?>");
   $.get("<?php echo $ajaxUpdateTopstatusUrl;?>");
   
});

$("#id_login_out").click(function(){
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxLoginOutUrl;?>",
        data: "a="+1,
        success: function(msg){
            if(msg == '200'){
                tusi("退出成功");
                <?php if($__IsWeixin == 1 && $ucenterConfig['login_type'] == 3 ) { ?>
                setTimeout(function(){window.location.href='<?php echo $bbsLoginOut;?>';},1888);
                <?php } ?>
                <?php if($__IsWeixin == 0 && $ucenterConfig['login_type'] == 3 ) { ?>
                setTimeout(function(){window.location.href='<?php echo $bbsLoginOut;?>';},1888);
                <?php } ?>
                <?php if($__IsWeixin == 0 && $ucenterConfig['login_type'] == 4 ) { ?>
                setTimeout(function(){window.location.href='<?php echo $bbsLoginOut;?>';},1888);
                <?php } ?>
                <?php if($__IsWeixin == 0 && $ucenterConfig['login_type'] == 2 ) { ?>
                setTimeout(function(){window.location.href='plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=index';},1888);
                <?php } ?>
            }else{
                tusi("退出错误");
            }
        }
    })
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
      'onMenuShareAppMessage'
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
});
</script>
</body>
</html>