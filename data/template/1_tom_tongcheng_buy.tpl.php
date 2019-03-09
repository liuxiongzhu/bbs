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
<title>购买推广 - <?php echo $__SitesInfo['name'];?></title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/iconfont/iconfont.css?v=<?php echo $cssJsVersion;?>" />
<script src="source/plugin/tom_tongcheng/images/jquery.min-2.1.3.js" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?><style>
.item-buy ul{overflow:hidden;margin:0 -1.5%;padding:0 1em;margin-top:1em}
.item-buy ul li{width:22%;color:#999;margin:0 1.5%;float:left;text-align:center;background:#f5f5f5;line-height:3em;border-radius:0.2em}
.item-buy ul li span{display:block}
.item-buy ul li span:first-child{border-bottom:2px solid #fff}
.item-buy ul li.on{background:#3cb5f6;color:#fff}
.buy-text{padding:1em}
.buy-text .buy-tit{color:#000;font-size:1.2em;padding-left:1.2em;background:url(source/plugin/tom_tongcheng/images/icon49.png) no-repeat left center;background-size:auto 1em;margin-bottom:0.3em}
.text-price{color:#ff6737}
.bold{font-weight:bold}
.text-delete{text-decoration:line-through;}

.buy_top_box{}
.buy_top_box ul {margin:0px;}
.buy_top_box ul li{width:33%;height: 60px;margin:0px;background:#fff;}
.buy_top_box ul li .buyitem{
    width: 80%;
    height: 45px;
    margin-top: 5px;
    padding-top: 5px;
    border: 1px solid #f5833b;
    border-radius: 3px;
    margin-left: auto;
    margin-right: auto;
    cursor: pointer;
}
.buy_top_box ul li .buyitem .days{
    line-height: 20px;
    color: <?php echo $tongchengConfig['template_color'];?>;
}
.buy_top_box ul li .buyitem .price{
    line-height: 20px;
    font-size: 0.7em;
}
.buy_top_box ul li .on .days{color: #fff;}
.buy_top_box ul li .on .price{color: #fff;}
.buy_top_box ul li .on{background-color: #f5833b;}
.buy_top_box ul li .on{background-color: <?php echo $tongchengConfig['template_color'];?>;}
</style>
</head>
<body>
<?php if($__HideHeader == 0 ) { ?>
<header class="header on  tc-template__bg">
    <section class="wrap">
        <a class="sec-ico go-back" href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=mylist">返回</a>
        <h2>购买推广</h2>
    </section>
</header>
<?php } ?>
<section class="mainer">
    <section class="wrap">
        <div class="campaign-main">
             <section class="item" <?php if($__HideHeader == 1 ) { ?>style="margin-top: -1px;"<?php } ?>>
                  <section class="campaign-item clear">
                       <section class="img">
                            <img src="source/plugin/tom_tongcheng/images/icon47.png" />
                       </section>
                       <section class="user-fav">
                            <h4>置顶</h4>
                            <p>系统自动把推广信息置顶到所在类目的高曝光位置，按展示天数付费、实时生效。</p>
                       </section>
                  </section>
             </section>
             <form name="payForm" id="payForm">
                  <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
                  <input type="hidden" name="tongcheng_id" value="<?php echo $tongcheng_id;?>">
                  <input type="hidden" name="days" id="days" value="0">
                  <section class="item item-buy">
                       <section class="buy_list">
                            <div class="clear10"></div>
                            <div class="clear10"></div>
                            <div class="clear10"></div>
                            <?php if($tongchengInfo['topstatus'] == 1) { ?>
                            <div class="tcui-loadmore tcui-loadmore_line">
                                <span class="tcui-loadmore__tips" style="color: #f70404;">已经置顶，<?php echo $toptime;?> 过期</span>
                            </div>
                            <?php } ?>
                            <div class="tcui-loadmore tcui-loadmore_line">
                                 <span class="tcui-loadmore__tips">选择置顶时间</span>
                            </div>
                            <div class="buy_top_box">
                                <ul>
                                    <?php if(is_array($buy_days_item)) foreach($buy_days_item as $key => $val) { ?>                                    <li>
                                        <div id="buy-item-<?php echo $key;?>" class="id-buy-item buyitem tc-template__border" onclick="chooseBuyItem(<?php echo $val['days'];?>,'<?php echo $val['price'];?>',<?php echo $val['score_pay'];?>,'<?php echo $val['score'];?>');">
                                            <div class="days "><?php echo $val['days'];?>天</div>
                                            <?php if($val['score_pay'] == 1) { ?>
                                            <div class="price"><?php echo $val['score'];?>金币</div>
                                            <?php } else { ?>
                                            <div class="price">支付:<?php echo $val['price'];?>元</div>
                                            <?php } ?>
                                        </div>
                                    </li>
                                    <?php } ?> 
                                </ul>
                            </div>
                            
                       </section>
                       <section class="buy-text">
                           <p>置顶的信息显示版块：<?php echo $modelInfo['name'];?>&nbsp;,&nbsp;<?php echo $typeInfo['name'];?><span style="float: right;color: #f00;font-size: 1.1em;" id="totalPrice"></span></p>
                       </section>
                  </section>
                  <section class="btn-group-block">
                      <button type="button" class="id_top_btn tc-template__bg" style="display:none;">确认购买</button>
                      <button type="button" class="id_top_btn2" style="background: #cacaca;">确认购买</button>
                  </section>
             </form>
        </div>
    </section>
</section><?php include template('tom_tongcheng:footer'); ?><script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<script>

function chooseBuyItem(days,price,score_pay,score){
    if(score_pay == 1){
        $('#totalPrice').html(score+'金币');
    }else{
        $('#totalPrice').html('￥'+price);
    }
    $(".id-buy-item").removeClass("on");
    $("#buy-item-"+days).addClass("on");
    $('#days').val(days);
    $(".id_top_btn").show();
    $(".id_top_btn2").hide();
}
    
var submintPayStatus = 0;
$(".id_top_btn").click( function (){
    if(submintPayStatus == 1){
        return false;
    }
    
    submintPayStatus = 1;
    $.ajax({
        type: "POST",
        url: "<?php echo $payTopUrl;?>",
        dataType : "json",
        data: $('#payForm').serialize(),
        success: function(data){
            if(data.status == 200) {
                tusi("下单成功，立即支付");
                setTimeout(function(){window.location.href=data.payurl+"&prand=<?php echo $prand;?>";},500);
            }else if(data.status == 201){
                tusi("置顶成功");
                setTimeout(function(){window.location.href=data.succurl+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 302){
                tusi("置顶天数异常");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
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
                tusi("未设置置顶费用");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else{
                tusi("支付错误");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }
        }
    });
});
</script>
</body>
</html>