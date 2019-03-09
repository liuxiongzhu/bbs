<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<!DOCTYPE html>
<html><head>
<title>新增地址</title>
<?php if($isGbk) { ?>
<meta http-equiv="Content-Type" content="text/html; charset=GBK">
<?php } else { ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php } ?>
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<script src="source/plugin/tom_tongcheng/images/jquery-1.8.3.min.js" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?></head>
<body class="body-white">
<header class="header on tc-template__bg">
    <section class="wrap">
        <section class="sec-ico go-back" onclick="history.back();">返回</section>
        <h2>新增地址</h2>
    </section>
</header>
<section class="mainer">
    <section class="wrap">
        <form id="add_form" method="post" onsubmit="return false;">
            <div class="tcui-cells tcui-cells_form">
                <div class="tcui-cell tcui-cell_switch">
                    <div class="tcui-cell__hd">
                        <label class="tcui-label">默认地址</label>
                    </div>
                    <div class="tcui-cell__ft">
                        <input class="tcui-switch" name="adddefault" id="adddefault" value="1" type="checkbox" checked="checked">
                    </div>
                </div>
                <div class="tcui-cell">
                    <div class="tcui-cell__hd">
                        <label class="tcui-label">收货人</label>
                    </div>
                    <div class="tcui-cell__bd">
                        <input class="tcui-input" type="text" id="addxm" name="addxm" value="" placeholder="姓名">
                    </div>
                </div>
                <div class="tcui-cell">
                    <div class="tcui-cell__hd">
                        <label class="tcui-label">手机号</label>
                    </div>
                    <div class="tcui-cell__bd">
                        <input class="tcui-input" type="text" id="addtel" name="addtel" value="" placeholder="手机号">
                    </div>
                </div>
                <div class="tcui-cell">
                    <div class="tcui-cell__hd">
                        <label class="tcui-label">地区</label>
                    </div>
                    <div class="tcui-cell__bd">
                        <div id="choseCity"><font color="#8e8e8e">选择地区</font></div>
                        <input type="hidden" name="province" id="province" value="">
                        <input type="hidden" name="city" id="city" value="">
                        <input type="hidden" name="area" id="area" value="">
                    </div>
                </div>
                <div class="tcui-cell">
                    <div class="tcui-cell__bd">
                        <textarea class="tcui-textarea" name="addinfo" id="addinfo" placeholder="详细地址" rows="3"></textarea>
                    </div>
                </div>
            </div>
            <section class="page_rgs">
                <section class="btn-group">
                    <input type="hidden" name="act" value="addsave">
                    <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
                    <input type="button" class="tcui-btn tcui-btn_primary id_add_form_btn tc-template__bg" value="保存">
                </section>
            </section>
        </form>
    </section>
</section>
<script>var city = eval(decodeURIComponent('<?php echo $aData;?>'));var selectedIndex = [0,0,0];</script>
<?php if($isGbk) { ?>
<script src="source/plugin/tom_tongcheng/images/picker/picker.min.gbk.js" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/picker/picker.address.gbk.js" type="text/javascript"></script>
<?php } else { ?>
<script src="source/plugin/tom_tongcheng/images/picker/picker.min.utf8.js" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/picker/picker.address.utf8.js" type="text/javascript"></script>
<?php } ?>
<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<script>

var submintStatus = 0;
$(".id_add_form_btn").click( function () { 
    
    if(submintStatus == 1){
        return false;
    }
    
    var addxm       = $("#addxm").val();
    var addtel      = $("#addtel").val();
    var province    = $("#province").val();
    var addinfo     = $("#addinfo").val();
    
    if(addxm == ""){
        tusi("必须填写收货人姓名");
        return false;
    }
    <?php if($tongchengConfig['fabu_phone_check'] == 1  ) { ?>
    if(addtel == "" || !checkMobile(addtel)){
        tusi("必须填写收货人手机号");
        return false;
    }
    <?php } else { ?>
    if(addtel == ""){
        tusi("必须填写收货人手机号");
        return false;
    }
    <?php } ?>
    
    if(province == 0){
        tusi("必须选择地区");
        return false;
    }
    
    if(addinfo == ""){
        tusi("必须填写详细地址");
        return false;
    }
    
    submintStatus = 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxSaveUrl;?>",
        data: $('#add_form').serialize(),
        success: function(msg){
            submintStatus = 0;
            
            if(msg == '400'){
                tusi("保存失败，请重试");
            }else{
                tusi("保存成功");
                <?php if($buying == 1) { ?>
                setTimeout(function(){window.location.href='<?php echo $address_back_url;?>';},1888);
                <?php } else { ?>
                setTimeout(function(){window.location.href='<?php echo $addressUrl;?>';},1888);
                <?php } ?>
                
            }
        }
    });
});

function checkMobile(s){
var regu =/^[1][3|8|4|5|7][0-9]{9}$/;
var re = new RegExp(regu);
if (re.test(s)) {
return true;
}else{
return false;
}
} 

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
