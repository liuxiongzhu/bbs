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
<title>消息 - <?php echo $__SitesInfo['name'];?></title>
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
    .tzline-detail article > p > a{ color:<?php echo $tongchengConfig['template_color'];?> !important;}
</style>
</head>
<body>
<?php if($act == 'sms'  ) { ?>
<header class="header on  tc-template__bg">
   <section class="wrap">
        <?php if($__HideHeader == 0 ) { ?>
        <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=message"><section class="sec-ico go-back">返回</section></a>
        <?php } ?>
        <h2><?php echo $toUserInfo['nickname'];?></h2>
   </section>
</header>
<section class="mainer">
    <section class="wrap" style="width: 99%;">
        <div class="pages clearfix" style="padding-top:5px;">
            <ul class="clearfix">
                <li><?php if($page > 1) { ?><a class="tc-template__border tc-template__color" style="border: 0px;" href="<?php echo $prePageUrl;?>">下翻</a><?php } else { ?><span style="border: 0px;">下翻</span><?php } ?></li>
              <li><?php if($showNextPage == 1) { ?><a class="tc-template__border tc-template__color" style="border: 0px;" href="<?php echo $nextPageUrl;?>">上翻</a><?php } else { ?><span  style="border: 0px;">上翻</span><?php } ?></li>
          </ul>
        </div>
        <div class="msgbox b_m">
            <?php if(is_array($messageList)) foreach($messageList as $key => $val) { ?>                <?php if($val['user_id'] != $__UserInfo['id']) { ?>
                <div class="friend_msg cl">
                    <div class="avat z"><img style="height:32px;width:32px;" src="<?php echo $val['userInfo']['picurl'];?>" /></div>
                    <div class="dialog_green z">
                        <div class="dialog_c">
                            <div class="dialog_t"><?php echo $val['content'];?></div>
                        </div>
                        <div class="dialog_b"></div>
                        <div class="date"><?php echo dgmdate($val[add_time], 'u','9999','m-d H:i');?></div>
                    </div>
                </div>
                <?php } else { ?>
                <div class="self_msg cl">
                    <div class="avat y"><img style="height:32px;width:32px;" src="<?php echo $val['userInfo']['picurl'];?>" /></div>
                    <div class="dialog_white y">			
                        <div class="dialog_c">
                            <div class="dialog_t"><?php echo $val['content'];?></div>
                        </div>
                        <div class="dialog_b"></div>
                        <div class="date"><?php echo dgmdate($val[add_time], 'u','9999','m-d H:i');?></div>
                    </div>
                </div>
                <?php } ?>
            <?php } ?> 
        </div>
        <section class="foot-sec"></section>
        <div class="message_reload_btn"><a href="javascript:void(0);" onclick="reloadSms();"><i class="tciconfont tcicon-shuaxin tc-template__color"></i></a></div>
        <div class="message_show_reply clearfix">
            <form id="send_form">
            <table style="width: 95%;margin-left: auto;margin-right: auto;">
              <colgroup><col width="80%"><col><col width="20%"><col></colgroup>
              <tbody>
              <tr>
                  <td style="vertical-align: top;">
                      <textarea class="tcui-textarea" name="content" id="content" placeholder="填写聊天内容"></textarea>
                      <input type="hidden" name="act" value="send">
                      <input type="hidden" name="pm_lists_id" value="<?php echo $pm_lists_id;?>">
                      <input type="hidden" name="to_user_id" value="<?php echo $toUserInfo['id'];?>">
                      <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
                  </td>
                  <td style="vertical-align: top;">
                       <div id="send_btn" class="message_show_btn send_btn clearfix">
                            <a class="tc-template__bg" href="javascript:void(0);">发送</a>
                        </div>
                  </td>
              </tr>
              </tbody>
          </table>
          </form>
        </div>
    </section>
</section>
<div class="js_dialog" id="sms_phone" style="display: none;">
    <div class="tcui-mask"></div>
    <div class="tcui-dialog">
        <div class="tcui-dialog__hd"><strong class="tcui-dialog__title">温馨提示</strong></div>
        <div class="tcui-dialog__bd">发送私信需要绑定手机号</div>
        <div class="tcui-dialog__ft">
            <a href="<?php echo $phoneUrl;?>" class="tcui-dialog__btn tcui-dialog__btn_default">去绑定</a>
            <a href="javascript:;" class="tcui-dialog__btn tcui-dialog__btn_primary">取消</a>
        </div>
    </div>
</div>
<?php } if($act == 'tz'  ) { if($__HideHeader == 0 ) { ?>
<header class="header on tc-template__bg">
   <section class="wrap">
        <section class="sec-ico go-back" onclick="history.back();">返回</section>
        <h2>系统消息</h2>
   </section>
</header>
<?php } ?>
<section class="mainer">
    <section class="wrap" style="width: 99%;">
        <div class="tcui-panel">
            <?php if(is_array($tzList)) foreach($tzList as $key => $val) { ?>            <div class="tzline-item">
                <div class="tzline-avatar-label"><img src="source/plugin/tom_tongcheng/images/tz_logo.png" class="avatar"></div>
                <div class="tzline-detail">
                    <article>
                        <p><?php echo $val['content'];?></p>
                    </article>
                    <div class="tzline-detail-time"><span><?php echo dgmdate($val[tz_time], 'u','9999','m-d H:i');?></span></div>
                </div>
            </div>
            <?php } ?> 
        </div>
        <div class="pages clearfix" style="padding-top:5px;">
            <ul class="clearfix">
              <li style="width: 40%;"><?php if($page > 1) { ?><a class="tc-template__border tc-template__color" href="<?php echo $prePageUrl;?>">上一页</a><?php } else { ?><span>上一页</span><?php } ?></li>
              <li style="width: 20%;"><span><?php echo $page;?>/<?php echo $allPageNum;?></span></li>
              <li style="width: 40%;"><?php if($showNextPage == 1) { ?><a class="tc-template__border tc-template__color"  href="<?php echo $nextPageUrl;?>">下一页</a><?php } else { ?><span>下一页</span><?php } ?></li>
          </ul>
        </div>
    </section>
</section>
<?php } if($act == 'list'  ) { if($__HideHeader == 0 ) { ?>
<header class="header on tc-template__bg">
   <section class="wrap">
        <h2>消息</h2>
   </section>
</header>
<?php } ?>
<section class="mainer">
   <section class="wrap">
        <section class="page-msg">
             <section class="msg-border">
                 <?php if($tzCount > 0) { ?>
                 <section class="msg-list">
                       <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=message&amp;act=tz">
                            <section class="msg-list-pic">
                                 <img src="source/plugin/tom_tongcheng/images/tz_logo.png" />
                            </section>
                            <section class="msg-list-web">
                                 <h3><span><?php echo dgmdate($lastTzList[tz_time], 'u');?> </span>系统消息&nbsp;</h3>
                                 <p><?php if($noReadTzCount>0) { ?><i><?php echo $noReadTzCount;?></i><?php } ?><?php echo $lastTzList['content'];?></p>
                            </section>
                       </a>
                       <section class="clear"></section>
                  </section>
                 <?php } ?>
                 <div id="index-list"></div>
                 <section class="clear"></section>
                 <section class="tc-sec">
                     <section class="tc-sec mt0" style="display: none;" id="load-html">
                         <div class="tcui-loadmore" style="padding:1em"><i class="tcui-loading"></i><span class="tcui-loadmore__tips">正在加载...</span></div>
                     </section>
                     <section class="tc-sec mt0" style="display: none;" id="no-load-html">
                         <div class="tcui-loadmore" style="padding:1em"><span class="tcui-loadmore__tips">没有更多信息...</span></div>
                     </section>
                     <section class="tc-sec mt0" style="display: none;" id="no-list-html">
                         <div class="tcui-loadmore" style="padding:1em"><span class="tcui-loadmore__tips">没有信息</span></div>
                     </section>
                 </section>
                 
             </section>
        </section>
   </section>
</section>
<section class="back_top">
    <a href="javascript:;"><img src="source/plugin/tom_tongcheng/images/back_top.png"></a>
</section>
<?php if($subscribeFlag==2) { ?>
<section id="subscribe">
    <div class="subscribe_box">
        <span>接收私信、信息审核通知等实时提醒</span>
        <div class="right">
            <div class="guanzu_show"><a class=" tc-template__bg" onclick="guanzu();">关注</a></div>
            <div class="guanzu_close" onclick="hide_guanzu();"><i></i></div>
        </div>
    </div>
</section>
<?php } include template('tom_tongcheng:footer'); ?><div style="display: none;"><?php echo $tongchengConfig['tongji_code'];?></div>
<?php } ?>
<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<script type="text/javascript">
$(document).on('click', '.tcui-dialog__btn_primary', function(){
    $(this).parents('.js_dialog').fadeOut(200);
})

$(document).ready(function(){
   $.get("<?php echo $ajaxCommonClicksUrl;?>");
   $.get("<?php echo $ajaxUpdateTopstatusUrl;?>");
});
var submintStatus = 0;

$(".send_btn").click( function () {
    var content = $("#content").val();
    if(submintStatus == 1){
        return false;
    }
    <?php if($showMustPhoneBtn == 1) { ?>
    $('#sms_phone').show();
    return false;
    <?php } ?>
    if(content == ""){
        tusi("聊天内容不允许为空");
        return false;
    }
    submintStatus = 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $smsUrl;?>",
        data: $('#send_form').serialize(),
        success: function(msg){
            submintStatus = 0;
            if(msg == 200){
                $("#content").val('');
                tusi("发送成功");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else{
               tusi("发送失败");
               setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }
        }
    });
});

function reloadSms(){
    setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
}

<?php if($act == 'list'  ) { ?>
var loadPage = 1;
function indexLoadList(){
    loadPage = 1;
    loadList(1);
}

var loadListStatus = 0;
function loadList(Page) {
    if(loadListStatus == 1){
        return false;
    }
    loadListStatus = 1;
    $("#index-list").html('');
    $("#load-html").show();
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxLoadPmListUrl;?>",
        data: {page:Page},
        success: function(msg){
            $('#load-html').hide();
            loadListStatus = 0;
            var data = eval('('+msg+')');
            if(data == 205){
                $("#no-list-html").show();
                return false;
            }else{
                loadPage += 1;
                $("#index-list").html(data);
            }
        }
    });
}

$(document).ready(function(){
   indexLoadList();
});

$(window).scroll(function () {
    var scrollTop       = $(this).scrollTop();
    var scrollHeight    = $(document).height();
    var windowHeight    = $(this).height();
    if ((scrollTop + windowHeight) >= (scrollHeight * 0.9)) {
        scrollLoadList();
    }
    if ((scrollTop + windowHeight) >= 1000) {
        $('.back_top').show();
    }else{
        $('.back_top').hide();
    }
});

function scrollLoadList() {
    if(loadListStatus == 1){
        return false;
    }
    if(loadPage > 500){
        return false;
    }
    $('#load-html').show();
$('#no-load-html').hide();
    loadListStatus = 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxLoadPmListUrl;?>",
        data: {page:loadPage},
        success: function(msg){
            loadListStatus = 0;
            var data = eval('('+msg+')');
            if(data == 205){
                loadListStatus = 1;
                $('#load-html').hide();
                $('#no-load-html').show();
                return false;
            }else{
                loadPage += 1;
                $('#load-html').hide();
                $("#index-list").append(data);
            }
        }
    });
}
$(document).on('click','.back_top', function () {
    $('body,html').animate({scrollTop: 0}, 500);
    return false;
});
<?php } ?>
</script>
<script>
function guanzu(){
    layer.open({
        content: '<img src="<?php echo $tongchengConfig['fwh_qrcode'];?>"><p>长按二维码识别关注<p/>'
        ,btn: '确认'
      });
}

function hide_guanzu(){
    $("#subscribe").hide();
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