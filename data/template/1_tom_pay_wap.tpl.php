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
<title><?php echo $payConfig['plugin_name'];?></title>
<link rel="stylesheet" href="source/plugin/tom_pay/images/wap.css?v=<?php echo $cssJsVersion;?>"/>
<link rel="stylesheet" href="source/plugin/tom_pay/images/weui.css"/>
<script src="source/plugin/tom_pay/images/jquery.min-2.1.3.js" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_pay/images';
</script>
<script src="source/plugin/tom_pay/images/common.js" type="text/javascript" type="text/javascript"></script>
<script>
var tomBrowser = {
    versions: function () {
        var u = navigator.userAgent, app = navigator.appVersion;
        return { /*�ƶ��ն�������汾��Ϣ*/
            trident: u.indexOf('Trident') > -1, /*IE�ں�*/
            presto: u.indexOf('Presto') > -1, /*opera�ں�*/
            webKit: u.indexOf('AppleWebKit') > -1, /*ƻ�����ȸ��ں�*/
            gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, /*����ں�*/
            mobile: !!u.match(/AppleWebKit.*Mobile.*/) || !!u.match(/AppleWebKit/), /*�Ƿ�Ϊ�ƶ��ն�*/
            ios: !!u.match(/i[^;]+;( U;)? CPU.+Mac OS X/), /*ios�ն�*/
            android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, /*android�ն˻���uc�����*/
            iPhone: u.indexOf('iPhone') > -1 || (u.indexOf('Mac') > -1 && u.indexOf('Macintosh') < 0), /*�Ƿ�ΪiPhone����QQHD�����*/
            iPad: u.indexOf('iPad') > -1, /*�Ƿ�iPad*/
            webApp: u.indexOf('Safari') == -1, /*�Ƿ�webӦ�ó���û��ͷ����ײ�*/
            WindowsWechat: u.indexOf('WindowsWechat') > 0 /*�Ƿ�webӦ�ó���û��ͷ����ײ�*/
        };
    }(),
    language: (navigator.browserLanguage || navigator.language).toLowerCase()
}
</script>
</head>
<body>
<section class="pay_header">
<h2><a class="back" href="<?php echo $orderInfo['fail_back_url'];?>">&nbsp;&nbsp;返回</a><?php echo $payConfig['plugin_name'];?></h2>
</section>
<div class="container clearfix">
    <div class="goods_box clearfix">
        <div class="weui-form-preview">
            <div class="weui-form-preview__bd">
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">商品名</label>
                    <span class="weui-form-preview__value"><?php echo $orderInfo['goods_name'];?></span>
                </div>
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">备注信息</label>
                    <span class="weui-form-preview__value"><?php echo $orderInfo['goods_beizu'];?></span>
                </div>
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">支付倒计时</label>
                    <span class="weui-form-preview__value daojishi" style="color:#ff0021;" data-time="<?php echo $syTime;?>">-</span>
                </div>
            </div>
            <div class="weui-form-preview__hd">
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">付款金额</label>
                    <em class="weui-form-preview__value"><font color="#fd0d0d">￥<?php echo $orderInfo['pay_price'];?></font></em>
                </div>
            </div>
        </div>
    </div>
    <div class="pay_box clearfix">
        <form name="payForm" id="payForm">
        <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
        <input type="hidden" name="order_no" value="<?php echo $order_no;?>">
        <input type="hidden" name="openid" value="<?php echo $openid;?>">
        <input type="hidden" name="souhu_pv_ip" id="souhu_pv_ip" value="">
        <?php if($__IsQianfan == 1 && $payConfig['open_qf_pay'] == 1 ) { ?>
        <input type="hidden" name="payment" value="qianfan_pay">
        <?php } elseif($__IsXiaoyun == 1 && $payConfig['open_xy_pay'] == 1 ) { ?>
        <input type="hidden" name="payment" value="appbyme_pay">
        <?php } elseif($__IsMagapp == 1 && $payConfig['open_mag_pay'] == 1 ) { ?>
        <input type="hidden" name="payment" value="magapp_pay">
        <?php } else { ?>
        <div class="weui-cells__title">选择支付方式</div>
        <div class="weui-cells weui-cells_checkbox">
            <?php if($_isWeiXin == 1 ) { ?>
            <label class="weui-cell weui-check__label" for="payment1">
                <div class="weui-cell__hd">
                    <input type="radio" class="weui-check" name="payment" value="wxpay_jsapi" id="payment1" checked="checked">
                    <i class="weui-icon-checked"></i>
                </div>
                <div class="weui-cell__bd">
                    <p><img height="30" src="source/plugin/tom_pay/images/wxpay.png"/></p>
                </div>
            </label>
            <?php } ?>
            <label class="weui-cell weui-check__label" for="payment2" style="display: none;">
                <div class="weui-cell__hd">
                    <input type="radio" class="weui-check" name="payment" value="wxpay_native" id="payment2">
                    <i class="weui-icon-checked"></i>
                </div>
                <div class="weui-cell__bd">
                    <p><img height="30" src="source/plugin/tom_pay/images/wxpay.png"/></p>
                </div>
            </label>
            <?php if($_isWeiXin == 0 ) { ?>
            <?php if($payConfig['open_h5'] == 1 ) { ?>
            <label class="weui-cell weui-check__label" for="payment3">
                <div class="weui-cell__hd">
                    <input type="radio" class="weui-check" name="payment" value="wxpay_h5" id="payment3" checked="checked">
                    <i class="weui-icon-checked"></i>
                </div>
                <div class="weui-cell__bd">
                    <p><img height="30" src="source/plugin/tom_pay/images/wxpay.png"/></p>
                </div>
            </label>
            <?php } ?>
            <?php } ?>
            <?php if($orderInfo['allow_alipay'] == 1 ) { ?>
            <?php if($payConfig['open_alipay'] == 1 ) { ?>
            <label class="weui-cell weui-check__label" for="payment4">
                <div class="weui-cell__hd">
                    <input type="radio" class="weui-check" name="payment" value="alipay_wap" id="payment4" checked="checked">
                    <i class="weui-icon-checked"></i>
                </div>
                <div class="weui-cell__bd">
                    <p><img height="35" src="source/plugin/tom_pay/images/alipay.png"/></p>
                </div>
            </label>
            <?php } ?>
            <?php } ?>
        </div>
        <?php } ?>
        </form>
    </div>
    <div class="btn_box clearfix">
        <?php if($orderInfo) { ?>
        <?php if($orderInfo['order_status'] != 2 ) { ?>
        <a href="javascript:;" class="weui-btn id_buy_btn" style="background-color: #38b035; color: #FFF; ">立即支付</a>
        <?php } ?>
        <?php } ?>
  	</div>
    <div class="footer_box clearfix">
        <div class="weui-footer">
            <p class="weui-footer__text"><?php echo $payConfig['copyright'];?></p>
        </div>
    </div>
</div>
<div id="dialogs">
    <!--BEGIN dialog1-->
    <div class="js_dialog" id="nativePayBox" style="display: none;">
        <div class="weui-mask"></div>
        <div class="weui-dialog">
            <div class="weui-dialog__hd"><strong class="weui-dialog__title">微信扫码支付</strong></div>
            <div class="weui-dialog__bd">
                <img id="nativeImgId" src=""/>
                <p>长按图片保存二维码，然后点击微信扫一扫选择相册二维码，开始支付</p>
            </div>
            <div class="weui-dialog__ft">
                <a href="javascript:void(0);" class="weui-dialog__btn weui-dialog__btn_primary">知道了</a>
            </div>
        </div>
    </div>
    <!--END dialog1-->
    <!--BEGIN dialog2-->
    <div class="js_dialog" id="paySuccBox" style="opacity: 1;display:none;">
        <div class="weui-mask"></div>
        <div class="weui-dialog">
            <div class="weui-dialog__hd"><strong class="weui-dialog__title">支付成功</strong></div>
            <div class="weui-dialog__bd">恭喜你支付成功</div>
            <div class="weui-dialog__ft">
                <a href="<?php echo $orderInfo['succ_back_url'];?>" class="weui-dialog__btn weui-dialog__btn_primary" style="color: #0BB20C;">完成支付</a>
            </div>
        </div>
    </div>
    <!--END dialog2-->
    <!--BEGIN dialog3-->
    <div class="js_dialog" id="payErrorBox" style="opacity: 1;display:none;">
        <div class="weui-mask"></div>
        <div class="weui-dialog">
            <div class="weui-dialog__hd"><strong class="weui-dialog__title">支付失败</strong></div>
            <div class="weui-dialog__bd">抱歉支付失败</div>
            <div class="weui-dialog__ft">
                <a href="<?php echo $orderInfo['fail_back_url'];?>" class="weui-dialog__btn weui-dialog__btn_default">返回</a>
            </div>
        </div>
    </div>
    <!--END dialog3-->
    <!--BEGIN dialog4-->
    <?php if($orderInfo['order_status'] == 2 ) { ?>
    <div class="js_dialog" style="opacity: 1;">
        <div class="weui-mask"></div>
        <div class="weui-dialog">
            <div class="weui-dialog__hd"><strong class="weui-dialog__title">已经支付</strong></div>
            <div class="weui-dialog__bd">当前订单已经完成支付，请勿重复支付</div>
            <div class="weui-dialog__ft">
                <?php if($__IsMiniprogram == 1 ) { ?>
                <a href="javascript:void(0);" onclick="jumpMiniprogram('<?php echo $_G['siteurl'];?><?php echo $orderInfo['succ_back_url'];?>&f=miniprogram');" class="weui-dialog__btn weui-dialog__btn_primary" style="color: #0BB20C;">完成支付</a>
                <?php } else { ?>
                <a href="<?php echo $orderInfo['succ_back_url'];?>" class="weui-dialog__btn weui-dialog__btn_primary" style="color: #0BB20C;">完成支付</a>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php } ?>
    <!--END dialog4-->
</div>
<script src="//res.wx.qq.com/open/js/jweixin-1.3.2.js" type="text/javascript" type="text/javascript"></script>
<?php if($payConfig['open_js_getip'] == 1 ) { ?>
<script src="http://pv.sohu.com/cityjson?ie=utf-8" type="text/javascript"></script>
<?php } ?>
<script type="text/javascript">
$(function(){
    
    $('#dialogs').on('click', '.weui-dialog__btn', function(){
        $(this).parents('.js_dialog').fadeOut(200);
    });

});
<?php if($__IsMiniprogram == 1 ) { ?>
var isMiniprogram = 1;
<?php } else { ?>
var isMiniprogram = 0;
<?php } ?>
wx.miniProgram.getEnv(function(res) {
  if(res.miniprogram){
      isMiniprogram = 1;
  }else{
      isMiniprogram = 0;
  }
})

var djsTime;
function countDaojishi()
{
    window.clearInterval(djsTime);
    djsTime = setInterval(function(){
        $(".daojishi").each(function() { 
            var t = $(this).attr('data-time');
            t = t-100;
            var d=Math.floor(t/1000/60/60/24);
            var h=Math.floor(t/1000/60/60%24);
            var m=Math.floor(t/1000/60%60);
            var s=Math.floor(t/1000%60);
            if (t > 0) { 
                var str = d + "天" + ( h<10?"0"+h:h) + "时" + ( m<10?"0"+m:m) + "分" + ( s<10?"0"+s:s)+"秒"; 
            }else { 
                var str = "..."; 
            } 
            $(this).attr('data-time',t);
            $(this).html(str); 		
        })
    },100);
}

$(document).ready(function(){
    countDaojishi();
    <?php if($payConfig['open_js_getip'] == 1 ) { ?>
    $("#souhu_pv_ip").val(returnCitySN['cip']);
    <?php } ?>
});

function jumpMiniprogram(link){
    var newviewurl  = encodeURIComponent(link);
    if(wx.miniProgram){
        if(link.indexOf("mod=index") > 0 || link.indexOf("mod=list") > 0 || link.indexOf("mod=personal") > 0){
            wx.miniProgram.reLaunch({
              url: 'view?viewurl=' + newviewurl
            });
        }else{
            wx.miniProgram.navigateTo({
              url: 'view?viewurl=' + newviewurl
            });
        }
    }else{
        window.location.href=link;
    }
}
</script>
<script>
var jsApiParameters;

function jsApiCall(){
    WeixinJSBridge.invoke(
        'getBrandWCPayRequest',{
            "appId": jsApiParameters.appId,
            "timeStamp": jsApiParameters.timeStamp,
            "nonceStr": jsApiParameters.nonceStr,
            "package": jsApiParameters.package,
            "signType": jsApiParameters.signType,
            "paySign": jsApiParameters.paySign
        },
        function(res){
            if(res.err_msg == "get_brand_wcpay_request:ok" ) {
                loading(false);
                submintPayStatus = 0;
                //tusi("支付成功");
                $('#paySuccBox').fadeIn(200);
            }else{
                loading(false);
                submintPayStatus = 0;
                //tusi("支付失败");
                $('#payErrorBox').fadeIn(200);
            } 
        }
    );
}

function callpay(){
    if (typeof WeixinJSBridge == "undefined"){
        if( document.addEventListener ){
            document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
        }else if (document.attachEvent){
            document.attachEvent('WeixinJSBridgeReady', jsApiCall);
            document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
        }
    }else{
        jsApiCall();
    }
}

var submintPayStatus = 0;
$(".id_buy_btn").click( function (){
    <?php if($payConfig['open_xiao'] == 1 ) { ?>
    if(isMiniprogram == 1){
        wx.miniProgram.navigateTo({
          url: 'pay?order_no=<?php echo $order_no;?>'
        })
        return false;
    }
    <?php } ?>
    if(submintPayStatus == 1){
        return false;
    }
    
    <?php if($__IsQianfan == 1 && $payConfig['open_qf_pay'] == 1 ) { ?>
    var payment = 'qianfan_pay';
    <?php } elseif($__IsXiaoyun == 1 && $payConfig['open_xy_pay'] == 1 ) { ?>
    var payment = 'appbyme_pay';
    <?php } elseif($__IsMagapp == 1 && $payConfig['open_mag_pay'] == 1 ) { ?>
    var payment = 'magapp_pay';
    <?php } else { ?>
    var payment = $(':radio[name="payment"]:checked').val();
    <?php } ?>
    
    submintPayStatus = 1;
    loading('处理中...');
    if(payment == 'wxpay_jsapi'){
        $.ajax({
            type: "POST",
            url: "<?php echo $payUrl;?>",
            dataType : "json",
            data: $('#payForm').serialize(),
            success: function(data){
                loading(false);
                if(data.status == 200) {
                    jsApiParameters = data.parameters;
                    setTimeout(function(){callpay();},0);
                }else if(data.status == 100){
                    tusi("已经支付");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }else if(data.status == 101){
                    tusi("订单状态异常");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }else if(data.status == 500){
                    tusi("生成微信订单失败");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }else if(data.status == 301){
                    tusi("支付标示获取失败");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }else if(data.status == 404){
                    tusi("订单不存在");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }else{
                    tusi("支付错误");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }
            }
        });
    }else if(payment == 'wxpay_native'){
        $.ajax({
            type: "POST",
            url: "<?php echo $payUrl;?>",
            dataType : "json",
            data: $('#payForm').serialize(),
            success: function(data){
                loading(false);
                submintPayStatus = 0;
                if(data.status == 200) {
                    $("#nativeImgId").attr('src',data.src);
                    $('#nativePayBox').fadeIn(200);
                }else if(data.status == 100){
                    tusi("已经支付");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }else if(data.status == 101){
                    tusi("订单状态异常");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }else if(data.status == 500){
                    tusi("生成微信订单失败");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }else if(data.status == 301){
                    tusi("支付标示获取失败");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }else if(data.status == 404){
                    tusi("订单不存在");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }else{
                    tusi("支付错误");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }
            }
        });
    }else if(payment == 'wxpay_h5'){
        
        if (tomBrowser.versions.android || tomBrowser.versions.iPhone) {
        }else{
            submintPayStatus = 0;
            tusi("在手机端才能发起微信支付");
            return false;
        }
        
        $.ajax({
            type: "POST",
            url: "<?php echo $payUrl;?>",
            dataType : "json",
            data: $('#payForm').serialize(),
            success: function(data){
                loading(false);
                submintPayStatus = 0;
                if(data.status == 200){
                    window.location.href=data.mweburl;
                }else if(data.status == 100){
                    tusi("已经支付");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }else if(data.status == 101){
                    tusi("订单状态异常");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }else if(data.status == 500){
                    tusi("生成微信订单失败");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }else if(data.status == 301){
                    tusi("支付标示获取失败");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }else if(data.status == 404){
                    tusi("订单不存在");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }else{
                    tusi("支付错误");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }
            }
        });
    }else if(payment == 'alipay_wap'){
        $.ajax({
            type: "POST",
            url: "<?php echo $payUrl;?>",
            dataType : "json",
            data: $('#payForm').serialize(),
            success: function(data){
                loading(false);
                if(data.status == 200) {
                    setTimeout(function(){window.location.href=data.payurl;},1);
                }else if(data.status == 100){
                    tusi("已经支付");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }else if(data.status == 101){
                    tusi("订单状态异常");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }else if(data.status == 404){
                    tusi("订单不存在");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }else{
                    tusi("支付错误");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }
            }
        });
    }else if(payment == 'qianfan_pay'){
        <?php if($__IsQianfan == 1 && $payConfig['open_qf_pay'] == 1 ) { ?>
        qianfanOrder(<?php echo $payConfig['qf_type'];?>,'<?php echo $order_no;?>','<?php echo $orderInfo['goods_name'];?>','<?php echo $orderInfo['pay_price'];?>');
        <?php } ?>
    }else if(payment == 'appbyme_pay'){
        <?php if($__IsXiaoyun == 1 && $payConfig['open_xy_pay'] == 1 ) { ?>
        $.ajax({
            type: "POST",
            url: "<?php echo $payUrl;?>",
            dataType : "json",
            data: $('#payForm').serialize(),
            success: function(data){
                loading(false);
                if(data.status == 200) {
                    xiaoyunPay(data.parameters);
                    connectAppbymeJavascriptBridge(function (bridge) {
                        xiaoyunPay(data.parameters);
                    });
                }else if(data.status == 100){
                    tusi("已经支付");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }else if(data.status == 101){
                    tusi("订单状态异常");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }else if(data.status == 500){
                    tusi("生成微信订单失败");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }else if(data.status == 301){
                    tusi("支付标示获取失败");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }else if(data.status == 404){
                    tusi("订单不存在");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }else{
                    tusi("支付错误");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }
            }
        });
        <?php } ?>
    }else if(payment == 'magapp_pay'){
        <?php if($__IsMagapp == 1 && $payConfig['open_mag_pay'] == 1 ) { ?>
        $.ajax({
            type: "POST",
            url: "<?php echo $payUrl;?>",
            dataType : "json",
            data: $('#payForm').serialize(),
            success: function(data){
                loading(false);
                if(data.status == 200) {
                    magappPay(data.mag_order_id)
                }else if(data.status == 100){
                    tusi("已经支付");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }else if(data.status == 101){
                    tusi("订单状态异常");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }else if(data.status == 500){
                    tusi("生成微信订单失败");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }else if(data.status == 301){
                    tusi("支付标示获取失败");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }else if(data.status == 404){
                    tusi("订单不存在");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }else{
                    tusi("支付错误");
                    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                }
            }
        });
        <?php } ?>
    }
    
});

<?php if($__IsQianfan == 1 && $payConfig['open_qf_pay'] == 1 ) { ?>
function qianfanOrder(qftype,order_no,goods_name,pay_price){
    
    try{
        
        var time = new Date().getTime();
        var chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        var len = chars.length;
        for(var i = 1;i < 8; i++){
            time = time + chars.charAt(Math.floor(Math.random() * len));
        }
        var data = {
            type: qftype,
            item: [
                {
                    title: goods_name,
                    subtitle: "",
                    cover: "",
                    num: 1,
                    cash_cost: pay_price,
                    gold_cost: 0,
                    get_expire: 0
                }
            ],
            send_type: 0,
            send_cost: '0',
            allow_change_address:1,
            address: {
                name: 'tom_pay',
                mobile: '15888888889',
                address: 'suzhou'
            },
            allow_pay_type: 14,
            allow_pay_time: 900,
            out_trade_no: time
        };
        
        QFH5.Order(JSON.stringify(data),function(state,data){
            if(state == 1){
                qianfanPay(data.order_id);
            }else if(state == 2){
                alert(data.error);
            }else{
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }
        });
        
    }catch(e){
        var qfJson = {
            "item" : '[{"title":"'+goods_name+'", "cover":"", "num":1, "gold_cost":0, "cash_cost":'+pay_price+'}]',
            "address" : '{"name":"tom_pay", "mobile":"15888888888", "address":"suzhou"}'
        }
        
        QFH5.createOrder(qftype,qfJson.item,0,qfJson.address,14,function(state,data){
            if(state == 1){
                qianfanPay(data.order_id);
            }else if(state == 2){
                alert(data.error);
            }else{
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }
        });
    }
}

function qianfanPay(qf_order_id){
    $.ajax({
        type: "POST",
        url: '<?php echo $payUrl;?>&qf_order_id='+qf_order_id,
        dataType : "json",
        data: $('#payForm').serialize(),
        success: function(data){
            loading(false);
            if(data.status == 200) {
                loading('处理中...');
                QFH5.jumpPayOrder(qf_order_id,function(state_jump,data){
                    if(state_jump==1){
                        setTimeout(function(){window.location.href="<?php echo $_G['siteurl'];?>source/plugin/tom_pay/qianfanReturn.php?qf_order_id="+qf_order_id;},888);
                    }else{
                        setTimeout(function(){window.location.href="<?php echo $_G['siteurl'];?>source/plugin/tom_pay/qianfanReturn.php?qf_order_id="+qf_order_id;},888);
                        //alert(data.error);
                    }
                });

            }else if(data.status == 100){
                tusi("已经支付");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 101){
                tusi("订单状态异常");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 404){
                tusi("订单不存在");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else{
                tusi("支付错误");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }
        }
    });
}
<?php } ?>
</script>
<?php if($__IsXiaoyun == 1 && $payConfig['open_xy_pay'] == 1 ) { ?>
<script src="//market-cdn.app.xiaoyun.com/release/sq-2.3.js" type="text/javascript"></script>
<script type="text/javascript">
    function xiaoyunPay(kapi) {
        submintPayStatus = 0;
        var payParam = {
            appid: kapi.appid,
            partnerid: kapi.partnerid,
            prepayid: kapi.prepayid,
            attach: 'Sign=WxPay',
            noncestr: kapi.noncestr,
            timestamp: kapi.timestamp,
            sign: kapi.sign
        };
        AppbymeJavascriptBridge.payRequest(function (data) {
            if (data.errCode == '0') {
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},888);
            } else {
                alert(data.errInfo);
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},888);
            }
        }, 1, JSON.stringify(payParam));
    }
</script>
<?php } if($__IsMagapp == 1 && $payConfig['open_mag_pay'] == 1 ) { if($_G['scheme'] == 'https' ) { ?>
<script src='https://static.app1.magcloud.net/public/static/dest/js/libs/magjs-x.js'></script>
<?php } else { ?>
<script src='http://app.lxh.magcloud.cc/public/static/dest/js/libs/magjs-x.js'></script>
<?php } ?>
<script type="text/javascript">
function magappPay(mag_order_id) {
    var magConfig = {
        money:'<?php echo $orderInfo['pay_price'];?>',
        title:'<?php echo $orderInfo['goods_name'];?>',
        des:'<?php echo $orderInfo['goods_name'];?>',
        payWay: {
            wallet:1,
            weixin:1,
            alipay:1
        },
        orderNum:'<?php echo $orderInfo['order_no'];?>',
        unionOrderNum: mag_order_id,
        type: "<?php echo $payConfig['plugin_name'];?>"
    };
    mag.pay(magConfig, function(){
        setTimeout(function(){window.location.href="<?php echo $_G['siteurl'];?>source/plugin/tom_pay/magappReturn.php?mag_order_id="+mag_order_id;},888);
    }, function(){
        setTimeout(function(){window.location.href="<?php echo $_G['siteurl'];?>source/plugin/tom_pay/magappReturn.php?mag_order_id="+mag_order_id;},888);
    });
}                        
</script>
<?php } ?>
</body>
</html>