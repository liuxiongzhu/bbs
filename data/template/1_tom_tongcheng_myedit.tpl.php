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
<title>资料修改</title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<script src="source/plugin/tom_tongcheng/images/jquery.min-2.1.3.js" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?></head>
<body class="body-white">
<header class="header on tc-template__bg">
    <section class="wrap">
        <section class="sec-ico go-back" onclick="history.back();">返回</section>
        <h2>资料修改</h2>
    </section>
</header>
<section class="mainer">
    <section class="wrap">
        <form name="editForm" id="editForm" onSubmit="return false;">
            <div class="tcui-cells tcui-cells_form">
                <div class="tcui-cell">
                    <div class="tcui-cell__hd">
                        <label class="tcui-label" style="width: 80px;">UID</label>
                    </div>
                    <div class="tcui-cell__bd">
                        <?php echo $__UserInfo['id'];?>
                    </div>
                </div>
                <div class="tcui-cell">
                    <div class="tcui-cell__hd">
                        <label class="tcui-label" style="width: 80px;">昵称</label>
                    </div>
                    <div class="tcui-cell__bd">
                        <input class="tcui-input" type="text" name="nickname" id="nickname" value="" placeholder="<?php echo $__UserInfo['nickname'];?>">
                    </div>
                </div>
            </div>
            <div class="user-avatar clearfix">
                <div class="upload-avatar" style="width: 80px;">
                    <label>头像</label>
                </div>
                <div class="show-avatar clearfix">
                    <div class="upload-click">
                        <img src="source/plugin/tom_tongcheng/images/img7.png">
                        <input type="file" id="filedata" name="filedata">
                    </div>
                    <div class="upload-picurl">
                        <img src="<?php echo $__UserInfo['picurl'];?>">
                        <input type="hidden" class="picurl" name="picurl" value="<?php echo $__UserInfo['picurl'];?>">
                        <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
                    </div>
                </div>
            </div>
            <div class="user-xian"></div>
            <section class="page_rgs">
                <section class="btn-group">
                    <input type="button" class="tcui-btn tcui-btn_primary id_avatar_form_btn tc-template__bg" value="保存">
                </section>
            </section>
        </form>
    </section>
</section>
<script src="source/plugin/tom_tongcheng/images/localResizeIMG4/dist/lrz.bundle.js" type="text/javascript"></script>
<script>
<?php if($mustUploadAvatar == 1) { ?>
$(document).ready(function(){
    tusi('请上传头像');
});
<?php } ?>
$(document).on('change', '#filedata', function() {
    loading('上传中...');
    lrz(this.files[0], {width:320,quality:0.8,fieldName:"filedata"})
        .then(function (rst) {
            return rst;
        })
        .then(function (rst) {
            rst.formData.append('fileLen', rst.fileLen);
            $.ajax({
                url: '<?php echo $uploadUrl;?>',
                data: rst.formData,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (data) {
                    if(data == '') {
                        loading(false);
                        tusi('上传出错');
                    }
                    var dataarr = data.split('|');
                    dataarr[0] = $.trim(dataarr[0]);
                    if(dataarr[0] == 'OK') {
                        loading(false);
                        $('.upload-picurl img').attr('src',dataarr[1]);
                        $('.upload-picurl .picurl').val(dataarr[1]);
                         
                    }else {
                        loading(false);
                        tusi('上传出错');
                    }
                }
            });
            return rst;
        })
        .catch(function (err) {
            loading(false);
            //alert(err);
        })
        .always(function () {
        });
});
</script>
<script>
var submintStatus = 0;

$(".id_avatar_form_btn").click( function () {
    
    if(submintStatus == 1){
        return false;
    }
    
    submintStatus = 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $saveUrl;?>",
        data: $('#editForm').serialize(),
        success: function(msg){
            submintStatus = 0;
            var data = eval('('+msg+')');
            tusi("修改成功");
            setTimeout(function(){window.location.href='plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=personal';},1888);
            
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