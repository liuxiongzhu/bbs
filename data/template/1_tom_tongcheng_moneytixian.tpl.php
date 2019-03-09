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
<title>申请提现</title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/money.css?v=<?php echo $cssJsVersion;?>" type="text/css">
<script src="source/plugin/tom_tongcheng/images/jquery.min-2.1.3.js" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?></head>
<body class="body-white">
<?php if($__HideHeader == 0 ) { ?>
<header class="header on tc-template__bg">
    <section class="wrap">
        <section class="sec-ico go-back" onclick="location.href='plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=money';">返回</section>
        <h2>申请提现</h2>
    </section>
</header>
<?php } ?>
<section class="mainer">
    <section class="wrap">
        
        <form class="recharge-form tixian-form" name="tixianForm" id="tixianForm">
        <div class="rechargeMain">
            <div class="rechargeItem">
                <div class="title">提现金额：</div>
                <div class="numInput money"><input class="tcui-input" type="number" name="money" id="money" value="" placeholder="请输入要提现的金额"></div>
            </div>
            <div class="tip">余额<?php echo $__UserInfo['money'];?>元,最低提现金额<?php echo $tongchengConfig['min_tixian_money'];?>元</div>
        </div>
        <div class="pay-way">
            <div class="title">提现方式</div>
            <div class="ng-scope">
                <ul>
                    <?php if($tongchengConfig['tixian_type'] == 1) { ?>
                    <li class="group selected" data-value="weixin" data-type="1">
                        <img class="pay-way-icon" src="source/plugin/tom_tongcheng/images/pay_icon_weixin.png">
                        <div class="pay-way-explain">
                            <h3>微信</h3>
                            <p>申请通过后将自动打入您的微信零钱帐户</p>
                        </div>
                        <span class="vico green" data-value="weixin" ></span>
                    </li>
                    <?php } ?>
                    <?php if($tongchengConfig['tixian_type'] == 2) { ?>
                    <li class="group selected" data-value="alipay" data-type="2">
                        <img class="pay-way-icon" src="source/plugin/tom_tongcheng/images/pay_icon_alipay.png">
                        <div class="pay-way-explain">
                            <h3>支付宝</h3>
                            <p>推荐已经申请开通支付宝的用户提现</p>
                        </div>
                        <span class="vico green" data-value="alipay"></span>
                    </li>
                    <?php } ?>
                    <?php if($tongchengConfig['tixian_type'] == 3) { ?>
                    <li class="group selected" data-value="weixin" data-type="1">
                        <img class="pay-way-icon" src="source/plugin/tom_tongcheng/images/pay_icon_weixin.png">
                        <div class="pay-way-explain">
                            <h3>微信</h3>
                            <p>申请通过后将自动打入您的微信零钱帐户</p>
                        </div>
                        <span class="vico green" data-value="weixin" ></span>
                    </li>
                    <li class="group selected" data-value="alipay" data-type="2">
                        <img class="pay-way-icon" src="source/plugin/tom_tongcheng/images/pay_icon_alipay.png">
                        <div class="pay-way-explain">
                            <h3>支付宝</h3>
                            <p>推荐已经申请开通支付宝的用户提现</p>
                        </div>
                        <span class="vico " data-value="alipay"></span>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="alipay" <?php if($tongchengConfig['tixian_type'] == 2) { } else { ?>style="display:none;"<?php } ?>>
            <div class="pay-text">支付宝帐号：<input class="input" id="alipay_zhanghao" name="alipay_zhanghao" style="text-align:left;"></div>
            <div class="borderD2"></div>
            <div class="pay-text">支付宝姓名：<input class="input" id="alipay_truename" name="alipay_truename" ></div>
        </div>
        <div class="recharge-btn" style="margin:20px 0px 20px 0px">
            <a class="tixian-btn id_tixian_form_btn tc-template__bg">确认提现</a>
            <?php if($tongchengConfig['tixian_type'] == 2) { ?>
            <input type="hidden" name="type_id" id="type_id" value="2">
            <?php } else { ?>
            <input type="hidden" name="type_id" id="type_id" value="1">
            <?php } ?>
            <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
        </div>
        </form>
        
    </section>
</section>
<div class="js_dialog" id="tixian_phone" style="display: none;">
    <div class="tcui-mask"></div>
    <div class="tcui-dialog">
        <div class="tcui-dialog__hd"><strong class="tcui-dialog__title">温馨提示</strong></div>
        <div class="tcui-dialog__bd">提现需要绑定手机号</div>
        <div class="tcui-dialog__ft">
            <a href="<?php echo $phoneUrl;?>" class="tcui-dialog__btn tcui-dialog__btn_default">去绑定</a>
            <a href="javascript:;" class="tcui-dialog__btn tcui-dialog__btn_primary">取消</a>
        </div>
    </div>
</div>
<script>
$(document).on('click', '.tcui-dialog__btn_primary', function(){
    $(this).parents('.js_dialog').fadeOut(200);
})
    
var submintStatus = 0;

$(".id_tixian_form_btn").click( function () {
    
    if(submintStatus == 1){
        return false;
    }
    
    <?php if($showMustPhoneBtn == 1) { ?>
    $('#tixian_phone').show();
    return false;
    <?php } ?>
    
    var money = $("#money").val();
    if(money == ""){
        tusi("必须输入提现金额");
        return false;
    }
   
    submintStatus = 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $saveUrl;?>",
        data: $('#tixianForm').serialize(),
        success: function(msg){
            submintStatus = 0;
            var data = eval('('+msg+')');
            if(data.status==200){
                tusi("提现申请提交成功");
                setTimeout(function(){window.location.href='plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=money';},1888);
                return false;
            }else if(data.status==301){
                tusi("提现金额有误");
                return false;
            }else if(data.status==302){
                tusi("最少提现<?php echo $tongchengConfig['min_tixian_money'];?>元");
                return false;
            }else if(data.status==303){
                tusi("余额不足");
                return false;
            }else if(data.status==304){
                tusi("必须填写支付宝账号和姓名");
                return false;
            }else{
                tusi("提现出错");
                return false;
            }
        }
    });
});
    
$(".tixian-form .pay-way li").click(function(){
    var o=$(this);
    $(".vico").removeClass("green");
    o.find(".vico").addClass("green");
    $(".alipay").hide();
    $("."+o.data("value")).show();
    $("#type_id").val(o.data("type"));
});
</script>
<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
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