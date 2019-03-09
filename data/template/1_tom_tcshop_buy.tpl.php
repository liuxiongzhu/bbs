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
<title>店铺置顶 - <?php echo $__SitesInfo['name'];?></title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tcshop/images/iconfont/iconfont.css?v=<?php echo $cssJsVersion;?>" />
<script src="source/plugin/tom_tcshop/images/jquery.min-2.1.3.js" type="text/javascript"></script>
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
</style>
</head>
<body>
<?php if($__HideHeader == 0 ) { ?>
<header class="header on tc-template__bg">
    <section class="wrap">
        <section class="sec-ico go-back" onclick="history.back();">返回</section>
        <h2>店铺置顶</h2>
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
                  <input type="hidden" name="tcshop_id" value="<?php echo $tcshop_id;?>">
                  <input type="hidden" name="days" id="days" value="<?php echo $day_num;?>">
                  <section class="item item-buy">
                       <section class="buy_list">
                            <div class="clear10"></div>
                            <div class="clear10"></div>
                            <div class="clear10"></div>
                            <?php if($tcshopInfo['topstatus'] == 1) { ?>
                            <div class="tcui-loadmore tcui-loadmore_line">
                                <span class="tcui-loadmore__tips" style="color: #f70404;">已经置顶，<?php echo $toptime;?> 过期</span>
                            </div>
                            <?php } ?>
                            <div class="tcui-loadmore tcui-loadmore_line">
                                 <span class="tcui-loadmore__tips">选择置顶时间</span>
                            </div>
                            <div class="makeorder_from">
                                <div class="makeorder_from_num_box">
                                    <li class="reduce"><a href="javascript:void(0);" onclick="numReduce();">-</a></li>
                                    <li class="in"><input id="buy_num" name="buy_num" type="text" value="<?php echo $day_num;?>" size="2" readonly="true">/天</li>
                                    <li class="add"><a href="javascript:void(0);" onclick="numAdd();">+</a></li>
                                </div>
                            </div>
                       </section>
                       <section class="buy-text">
                           <p>&nbsp;&nbsp;<span style="float: right;color: #f00;font-size: 1.1em;" id="totalPrice">￥<?php echo $pay_price_arr[$day_num];?></span></p>
                       </section>
                  </section>
                  <section class="btn-group-block">
                      <button type="button" class="id_top_btn tc-template__bg">确认购买</button>
                  </section>
             </form>
        </div>
    </section>
</section><?php include template('tom_tcshop:footer'); ?><script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<script>
$(document).ready(function(){
   $.get("<?php echo $ajaxCommonClicksUrl;?>");
});  

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
});

var pay_price_arr=new Array(31);
pay_price_arr[0]="";<?php if(is_array($pay_price_arr)) foreach($pay_price_arr as $key => $val) { ?>pay_price_arr[<?php echo $key;?>]="<?php echo $val;?>";
<?php } ?>

var buy_num = "<?php echo $day_num;?>";
buy_num = buy_num * 1;
function numReduce(){
    if(buy_num <= 1){
        return false;
    }
    buy_num = buy_num - 1;
    $('#buy_num').val(buy_num);
    $('#days').val(buy_num);
    total_price = pay_price_arr[buy_num];
    $('#totalPrice').html('￥'+total_price);
    return false;
}

function numAdd(){
    if(buy_num >= 30){
        return false;
    }
    buy_num = buy_num + 1;
    $('#buy_num').val(buy_num);
    $('#days').val(buy_num);
    total_price = pay_price_arr[buy_num];
    $('#totalPrice').html('￥'+total_price);
    return false;
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