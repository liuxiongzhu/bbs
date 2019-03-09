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
<title>完善店铺资料 - <?php echo $__SitesInfo['name'];?></title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tcshop/images/shop_style.css?v=<?php echo $cssJsVersion;?>" />
<script src="source/plugin/tom_tcshop/images/jquery.min-2.1.3.js" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?><style>
.tcui-actionsheet__cell:before{border:0}
.tcui-actionsheet__cell{border-bottom:1px solid #EFEFF4;padding:20px 0}
.tcui-uploader__input-box:before{height: 20.5px;}
.tcui-uploader__input-box:after{width: 20.5px;}
.paixu-class{width: 35px;margin-top: 30px;border: 1px solid #eadfe4;text-align: center;}
</style>
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
<header class="header header-index on in2 tc-template__bg">
   <section class="wrap">
       <?php if($__HideHeader == 0 ) { ?>
        <section class="sec-ico go-back" onclick="history.back();">返回</section>
        <?php } ?>
        <h2>完善店铺资料</h2>
   </section>
</header>
<form class="mainer" name="saveForm" id="saveForm" >
   <section class="wrap edit-form">
        <section class="edit-item">
            <section class="input-control clear bb0" style="margin-bottom: 5px;">
                  <div style="line-height: 3em;">店铺介绍</div>
                  <section class="textarea">
                       <section class="sec-input">
                            <textarea id="content" name="content" maxlength="1000"><?php echo $tcshopInfo['content'];?></textarea>
                       </section>
                  </section>
             </section>
            <section class="input-control " id="photolist" >
                <?php if(is_array($tcshopTuwenList)) foreach($tcshopTuwenList as $key => $val) { ?>                <div  class="tcui-flex li_<?php echo $val['li_i'];?>" style="position: relative;">
                    <div><img style="width: 75px;height: 75px;" src="<?php echo $val['src'];?>" /><input type="hidden" name="photo_<?php echo $val['li_i'];?>" value="<?php echo $val['picurl'];?>"/></div>
                    <div class="tcui-flex__item" style="line-height: 25px;"><textarea class="tcui-textarea" name="txt_<?php echo $val['li_i'];?>" placeholder="请输入图片介绍" rows="3"><?php echo $val['txt'];?></textarea></div>
                    <div><input class="tcui-input paixu-class" name="paixu_<?php echo $val['li_i'];?>" type="text" value="<?php echo $val['paixu'];?>" placeholder="排序"></div>
                    <div style="top: 3px;right: 3px" class="close pic-delete-btn pointer" onclick="picremove(<?php echo $val['li_i'];?>);">&nbsp;X&nbsp;</div>
                </div>
                <?php } ?>
             </section>
            <section class="input-control ">
                <div class="tcui-uploader__input-box" style="margin-top: 10px;float: none;margin-left: auto;margin-right: auto;width: 200px;height: 45px;">
                    <input name="filedata1" id="filedata1" class="tcui-uploader__input" type="file" accept="image/*" multiple="">
                </div>
             </section>
        </section>
   </section>
   <section class="btn-group-block">
        <button type="button" id="id_save_btn" class="id_save_btn tc-template__bg">修改信息</button>
        <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
        <input type="hidden" name="tcshop_id" value="<?php echo $tcshop_id;?>">
        <div class="clear10"></div>
        <div class="clear10"></div>
        <div class="clear10"></div>
   </section>
</form>
<div id="baidumap" style="position: fixed;bottom: 0px; height:100%; width:100%;z-index:9999;display:none">
    <iframe style="border:0px;width:100%;height:100%"></iframe>
</div>
<div class="tcui-actionsheet" id="actionSheet_wrap">
    <header class="header on in2">
        <section class="wrap"><h2>选择位置</h2></section>
    </header>
    <div class="tcui-actionsheet__menu">
        <a class="tcui-actionsheet__cell" href="javascript:void(0);" id="mylocation">我当前位置</a>
        <a class="tcui-actionsheet__cell" href="javascript:void(0);" id="maplocation">地图上选点</a>
    </div>
    <div class="clear"></div>
    <div class="tcui-actionsheet__action">
        <div class="tcui-actionsheet__cell" id="actionsheet_cancel">取消</div>
    </div>
</div>
<script src="source/plugin/tom_tongcheng/images/localResizeIMG4/dist/lrz.bundle.js" type="text/javascript"></script>
<script>
var li_i = <?php echo $photoCount;?>;
li_i++;
var count = 0;
    
var submintPayStatus = 0;
$(".id_save_btn").click( function (){
    if(submintPayStatus == 1){
        return false;
    }
    
    loading('处理中...');
    submintPayStatus = 1;
    $.ajax({
        type: "POST",
        url: "<?php echo $saveUrl;?>",
        dataType : "json",
        data: $('#saveForm').serialize(),
        success: function(data){
            submintPayStatus = 0;
            loading(false);
            if(data.status == 200) {
                tusi("修改成功");
                setTimeout(function(){window.location.href='plugin.php?id=tom_tcshop&site=<?php echo $site_id;?>&mod=edit&tcshop_id=<?php echo $tcshop_id;?>&fromlist=<?php echo $_GET['fromlist'];?>';},1888);
            }else{
                tusi("修改出错");
                //setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }
        }
    });
});

$(document).on('change', '#filedata1', function() {
    loading('上传中...');
    lrz(this.files[0], {width:640,quality:0.8,fieldName:"filedata1"})
        .then(function (rst) {
            return rst;
        })
        .then(function (rst) {
            rst.formData.append('fileLen', rst.fileLen);
            $.ajax({
                url: '<?php echo $uploadUrl1;?>',
                data: rst.formData,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (data) {
                    if(data == '') {
                        loading(false);
                        tusi('上传失败');
                    }
                    var dataarr = data.split('|');
                    dataarr[0] = $.trim(dataarr[0]);
                    if(dataarr[0] == 'OK') {
                        loading(false);
                        
                        html = '<div class="tcui-flex li_'+li_i+'" style="position: relative;">';
                            html+= '<div><img style="width: 75px;height: 75px;" src="'+dataarr[1]+'" /><input type="hidden" name="photo_'+li_i+'" value="'+dataarr[2]+'"/></div>';
                            html+= '<div class="tcui-flex__item" style="line-height: 25px;"><textarea class="tcui-textarea" name="txt_'+li_i+'" placeholder="请输入图片介绍" rows="3"></textarea></div>';
                            html+= '<div><input class="tcui-input paixu-class" name="paixu_'+li_i+'" type="text" placeholder="排序"></div>';
                            html+= '<div style="top: 3px;right: 3px" class="close pic-delete-btn pointer" onclick="picremove('+li_i+');">&nbsp;X&nbsp;</div>';
                        html+= '</div>';
                        $("#photolist").append(html);
                        li_i++;
                        photo_count++;
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

function picremove(i){
    $(".li_"+i).remove();
    photo_count--;
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