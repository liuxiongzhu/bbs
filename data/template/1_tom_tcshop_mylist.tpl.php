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
<title>我的店铺 - <?php echo $__SitesInfo['name'];?></title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tcshop/images/iconfont/iconfont.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tcshop/images/shop_style.css?v=<?php echo $cssJsVersion;?>" />
<script src="source/plugin/tom_tcshop/images/jquery.min-2.1.3.js" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/layer_mobile/layer.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?></head>
<body>
<?php if($__HideHeader == 0 ) { ?>
<header class="header on tc-template__bg">
   <section class="wrap">
        <section class="sec-ico go-back" onclick="history.back();">返回</section>
        <h2>我的店铺</h2>
   </section>
</header>
<?php } ?>
<section class="mainer">
   <section class="wrap">
        <div class="tcui-navbar">
             <a class="tcui-navbar__item <?php if($type==0  ) { ?>tcui-bar__item_on tc-template__color tc-template__border<?php } ?>" href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=mylist&amp;type=0">全部 </a>
             <a class="tcui-navbar__item <?php if($type==1  ) { ?>tcui-bar__item_on tc-template__color tc-template__border<?php } ?>" href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=mylist&amp;type=1">展示中 </a>
             <a class="tcui-navbar__item <?php if($type==2  ) { ?>tcui-bar__item_on tc-template__color tc-template__border<?php } ?>" href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=mylist&amp;type=2">未支付 </a>
             <a class="tcui-navbar__item <?php if($type==4  ) { ?>tcui-bar__item_on tc-template__color tc-template__border<?php } ?>" href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=mylist&amp;type=4">未审核 </a>
        </div>
        <section class="shop_list" style="padding-top: 3em;<?php if($__HideHeader == 1 ) { ?>margin-top: 0px;<?php } ?>">
            <div class="list-item">
                <?php if(is_array($tcshopList)) foreach($tcshopList as $key => $val) { ?>                <div class="item-box clearfix">
                    <?php if($val['shenhe_status'] == 1 && $val['pay_status'] != 1) { ?>
                    <div class="item-pic" style="width: 70px;height: 70px;"><a href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=details&amp;tcshop_id=<?php echo $val['id'];?>"><img src="<?php echo $val['picurl'];?>"></a></div>
                    <?php } else { ?>
                    <div class="item-pic" style="width: 70px;height: 70px;"><a href="javascript:void(0);"><img src="<?php echo $val['picurl'];?>"></a></div>
                    <?php } ?>
                    <div class="item-content">
                        <div class="content">
                            <h5>
                                <?php if($val['vip_level'] == 1 ) { ?>
                                <span class="text-icon tc-template__bg">高级版</span>
                                <?php } else { ?>
                                <span class="text-icon tc-template__bg">基础版</span>
                                <?php } ?>
                                <?php if($val['shenhe_status'] == 1 && $val['pay_status'] != 1) { ?>
                                <a href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=details&amp;tcshop_id=<?php echo $val['id'];?>"><?php echo $val['name'];?></a>
                                <?php } else { ?>
                                <a href="javascript:void(0);"><?php echo $val['name'];?></a>
                                <?php } ?>
                            </h5>
                            <p class="xinxi">浏览量:&nbsp;<?php echo $val['clicks'];?></p>
                            <?php if($val['pay_status'] == 0 || $val['pay_status'] == 2 ) { ?>
                            <p class="nr">到期时间:&nbsp;
                                <?php if($val['overTime'] == 1 ) { ?>
                                <font color="#fd0d0d">永久</font>
                                <?php } else { ?>
                                <font color="#fd0d0d"><?php echo $val['overTime'];?></font>
                                <?php } ?>
                            </p>
                            <?php } ?>
                        </div>
                        <div class="details" style="top: 0;">
                            <?php if($val['pay_status'] == 1 ) { ?>
                            <font color="#fd0d0d">未支付</font>
                            <?php } else { ?>
                                <?php if($val['shenhe_status'] == 1 ) { ?>
                                    <?php if($val['status'] == 1 ) { ?>
                                    <font color="#238206">展示中</font>
                                    <?php } ?>
                                    <?php if($val['status'] == 2 ) { ?>
                                    <font color="#fd0d0d">已下架</font>
                                    <?php } ?>
                                    <?php if($val['status'] == 3 ) { ?>
                                    <font color="#fd0d0d">已过期</font>
                                    <?php } ?>
                                <?php } elseif($val['shenhe_status'] == 2) { ?>
                                    <font color="#fd0d0d">待审核</font>
                                <?php } elseif($val['shenhe_status'] == 3) { ?>
                                    <font color="#fd0d0d">未通过</font>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php if($val['pay_status'] == 1 ) { ?>
                    <?php if($__IsMiniprogram == 1 && $__Ios == 1  && $tcshopConfig['closed_ios_pay'] == 1 ) { } else { ?>
                    <section class="btn-group">
                        <a class="red tc-template__color tc-template__border" href="javascript:void(0);" onclick="pay(<?php echo $val['id'];?>);" style="min-width: 10em;">立即支付</a>
                    </section>
                    <?php } ?>
                <?php } else { ?>
                <section class="btn-group">
                    <?php if($val['is_ok'] == 1) { ?>
                        <?php if($val['shenhe_status'] == 1 ) { ?>
                            <?php if($val['status'] == 1 ) { ?>
                                <?php if($__IsMiniprogram == 1 && $__Ios == 1  && $tcshopConfig['closed_ios_pay'] == 1 ) { } else { ?>
                                    <?php if($val['vip_level'] == 0 ) { ?>
                                    <a href="javascript:void(0);" onclick="vipSure(<?php echo $val['id'];?>);" >升级</a>
                                    <?php } ?>
                                    <a href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=buy&amp;tcshop_id=<?php echo $val['id'];?>">置顶</a>
                                    <?php if($__ShowTchongbao == 1) { ?>
                                    <a href="plugin.php?id=tom_tchongbao&amp;site=<?php echo $site_id;?>&amp;mod=add_tcshop_hb&amp;tcshop_id=<?php echo $val['id'];?>">塞红包</a>
                                    <?php } ?>
                                <?php } ?>
                                <a href="javascript:void(0);" onclick="updateStatus2(<?php echo $val['id'];?>);" >下架</a>
                                <a href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=clerk&amp;tcshop_id=<?php echo $val['id'];?>" >店员</a>
                            <?php } ?>
                            <?php if($val['status'] == 2 ) { ?>
                                <a href="javascript:void(0);" onclick="updateStatus1(<?php echo $val['id'];?>);" style="min-width: 10em;">上架</a>
                            <?php } ?>
                            <?php if($val['status'] == 3 ) { ?>
                                <?php if($__IsMiniprogram == 1 && $__Ios == 1  && $tcshopConfig['closed_ios_pay'] == 1 ) { } else { ?>
                                <a href="javascript:void(0);" style="min-width: 6em;" onclick="xufeiSure(<?php echo $val['id'];?>);">续费基础版</a>
                                <a class="red  tc-template__color tc-template__border" href="javascript:void(0);" style="min-width: 6em;" onclick="xufeiVipSure(<?php echo $val['id'];?>);" >续费高级版</a>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                        <?php if($val['status'] == 3 ) { ?>
                        <?php } else { ?>
                        <a href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=edit&amp;tcshop_id=<?php echo $val['id'];?>&amp;fromlist=mylist">修改</a>
                        <a href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=shop_focuspic&amp;tcshop_id=<?php echo $val['id'];?>&amp;fromlist=mylist">幻灯片</a>
                        <?php } ?>
                    <?php } else { ?>
                    <a class="red  tc-template__color tc-template__border" href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=edit&amp;tcshop_id=<?php echo $val['id'];?>&amp;fromlist=mylist" style="min-width: 10em;">立即完善资料</a>
                    <?php } ?>
                </section>
                <?php } ?>
                <?php } ?>
            </div>
        </section>
       <div class="pages clearfix">
            <ul class="clearfix">
              <li style="width: 40%;"><?php if($page > 1) { ?><a class="tc-template__border tc-template__color" href="<?php echo $prePageUrl;?>">上一页</a><?php } else { ?><span>上一页</span><?php } ?></li>
              <li style="width: 20%;"><span><?php echo $page;?>/<?php echo $allPageNum;?></span></li>
              <li style="width: 40%;"><?php if($showNextPage == 1) { ?><a class="tc-template__border tc-template__color" href="<?php echo $nextPageUrl;?>">下一页</a><?php } else { ?><span>下一页</span><?php } ?></li>
          </ul>
        </div>
   </section>
</section>
<section class="pic_info id-pic-tip box_hide clearfix" style="z-index: 999;height: 2000px;position: fixed;">
<div class="pic_info_in id-pic-tip-in" style="top: 0px; height: 550px; background-image: url();"></div>
</section><?php include template('tom_tcshop:footer'); ?><script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
   $.get("<?php echo $ajaxCommonClicksUrl;?>");
});

var submintPayStatus = 0;
function pay(tcshop_id){
    if(submintPayStatus == 1){
        return false;
    }
    
    submintPayStatus = 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $payUrl;?>",
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

var submintPayStatus = 0;
function vip(tcshop_id){
    if(submintPayStatus == 1){
        return false;
    }
    
    submintPayStatus = 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $vipUrl;?>",
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
            }else if(data.status == 500){
                tusi("当前店铺已经是高级版");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else{
                tusi("支付错误");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }
        }
    });
}

var submintPayStatus = 0;
function xufei(tcshop_id){
    if(submintPayStatus == 1){
        return false;
    }
    
    submintPayStatus = 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $xufeiUrl;?>",
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
            }else if(data.status == 500){
                tusi("当前店铺未过期");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else{
                tusi("支付错误");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }
        }
    });
}

var submintPayStatus = 0;
function xufeiVip(tcshop_id){
    if(submintPayStatus == 1){
        return false;
    }
    
    submintPayStatus = 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $xufeiVipUrl;?>",
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
            }else if(data.status == 500){
                tusi("当前店铺未过期");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else{
                tusi("支付错误");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }
        }
    });
}

function vipSure(tcshop_id){
    layer.open({
        content: '你确定要把店铺升级为高级版？'
        ,btn: ['升级', '取消']
        ,yes: function(index){
          vip(tcshop_id);
          layer.close(index);
        }
      });
}

function xufeiSure(tcshop_id){
    layer.open({
        content: '你确定要续费基础版，你也可以选择直接续费高级版'
        ,btn: ['续费', '取消']
        ,yes: function(index){
          xufei(tcshop_id);
          layer.close(index);
        }
      });
}

function xufeiVipSure(tcshop_id){
    layer.open({
        content: '你确定要续费高级版？'
        ,btn: ['续费', '取消']
        ,yes: function(index){
          xufeiVip(tcshop_id);
          layer.close(index);
        }
      });
}

function updateStatus1(tcshop_id){
    layer.open({
        content: '您确定上架店铺吗？'
        ,btn: ['上架', '取消']
        ,yes: function(index){
          $.ajax({
                type: "GET",
                url: "<?php echo $ajaxUpdateStatusUrl;?>",
                data: "status=1&tcshop_id="+tcshop_id,
                success: function(msg){
                    if(msg == '200'){
                        tusi("上架成功");
                        setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                    }else{
                        tusi("操作失败");
                    }
                }
            });
            layer.close(index);
        }
      });
}
function updateStatus2(tcshop_id){
    layer.open({
        content: '您确定下架店铺吗？'
        ,btn: ['下架', '取消']
        ,yes: function(index){
          $.ajax({
                type: "GET",
                url: "<?php echo $ajaxUpdateStatusUrl;?>",
                data: "status=2&tcshop_id="+tcshop_id,
                success: function(msg){
                    if(msg == '200'){
                        tusi("下架成功");
                        setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                    }else{
                        tusi("操作失败");
                    }
                }
            });
          layer.close(index);
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
      'previewImage',
      'openLocation', 
      'getLocation'
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