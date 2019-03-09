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
<title><?php echo $user['nickname'];?>的主页，共有<?php echo $tcCount;?>条信息等你来看！ - <?php echo $__SitesInfo['name'];?></title>
<link href="source/plugin/tom_tongcheng/images/swiper.min.css?v=<?php echo $cssJsVersion;?>" rel="stylesheet" />
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/iconfont/iconfont.css?v=<?php echo $cssJsVersion;?>" />
<script src="source/plugin/tom_tongcheng/images/jquery.min-2.1.3.js" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/swiper.min.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?></head>
<body>
<section class="mainer">
   <section class="wrap">
        <section class="user-page">
            <section class="user-wrap user-wrap-nobg" style="height: 9em;">
                  <div class="blur10" style="background: url(<?php echo $user['picurl'];?>);background-size: contain;"></div>
                  <section class="user-page-avatar" style="margin-top: 0.4em;">
                       <section class="_bigav user-avatar-pic" style="text-align: center;">
                            <img src="<?php echo $user['picurl'];?>"/>
                       </section>
                      <div class="btn-group" style="background-color:transparent;">
                           <a style="border: 1px solid #eaeae9;padding: 0;height: 25px;line-height: 25px;margin-top: 0.5em;" href="<?php echo $messageUrl;?>" class="text-center">私信</a>
                       </div>
                  </section>
                  <section class="user-avatar-extend">
                       <h3><?php echo $user['nickname'];?></h3>
                       <p style="color: #666;"> 
                           注册时间：<?php echo $add_time;?><br /> 
                           发布：<?php echo $tcCount;?> 条 
                          <!-- <br />访客：<?php echo $visitorCount;?> 次 -->
                       </p>
                  </section>
                  <div class="clear10"></div>
             </section>
        </section>
        <ul class="home-tab dislay-flex" style="display:none;">
             <li <?php if($act == 'list'  ) { ?>class="active"<?php } ?>><a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=home&amp;uid=<?php echo $user['id'];?>&amp;act=list">TA的信息</a></li>
             <li <?php if($act == 'visitor'  ) { ?>class="active"<?php } ?>><a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=home&amp;uid=<?php echo $user['id'];?>&amp;act=visitor">TA的访客</a></li>
        </ul>
        <?php if($act == 'list'  ) { ?>
        <section class="tc-sec">
            <section class="tc-sec mt0" id="home-list">
                 <div class="tcui-loadmore" style="padding:1em"><i class="tcui-loading"></i><span class="tcui-loadmore__tips">正在加载...</span></div>
             </section>
             <section class="tc-sec mt0" style="display: none;" id="no-more-html">
                <div class="tcui-loadmore" style="padding:1em"><i class="tcui-loading"></i><span class="tcui-loadmore__tips">没有更多信息...</span></div>
             </section>
            <section class="tc-sec mt0" style="display: none;" id="no-list-html">
                <div class="clear10" style="height:7em;"></div>
                  <div class="tcui-loadmore tcui-loadmore_line">
                       <span class="tcui-loadmore__tips">没有信息</span>
                  </div>
                  <div class="btn-group-block">
                       <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=fabu">开始发布一条</a>
                       <div class="clear10" style="height:7em;"></div>
                  </div>
             </section>
        </section>
        <?php } ?>
        <?php if($act == 'visitor'  ) { ?>
        <section class="tc-sec">
             <section class="tc-sec mt0">
                  <style>.home-visitor{margin-top:0}.home-visitor .tcui-cell img{width:28px;margin-right:5px;display:block}</style>
                  <?php if(is_array($visitorList)) foreach($visitorList as $key => $val) { ?>                  <div class="tcui-cells home-visitor">
                       <a class="tcui-cell" href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=home&amp;uid=<?php echo $val['visitUserInfo']['id'];?>">
                            <div class="tcui-cell__hd">
                                 <img src="<?php echo $val['visitUserInfo']['picurl'];?>" />
                            </div>
                            <div class="tcui-cell__bd"><p><?php echo $val['visitUserInfo']['nickname'];?></p></div>
                            <div class="tcui-cell__ft"><?php echo dgmdate($val[add_time], 'u');?></div>
                       </a>
                  </div>
                  <?php } ?>
             </section>
        </section>
        <?php } ?>
        
   </section>
</section>
<section class="pic_info id-pic-tip box_hide clearfix" style="z-index: 999;height: 2000px;position: fixed;">
<div class="pic_info_in id-pic-tip-in" style="top: 0px; height: 550px; background-image: url();"></div>
</section>
<div class="swiper-container rebox" id="rebox">
    <div class="swiper-wrapper " id="rebox-wrapper__box">
    </div>
    <div class="swiper-pagination rebox-pagination"></div>
<div class="swiper-close" id="rebox-close"></div>
</div><?php include template('tom_tongcheng:footer'); ?><div style="display: none;"><?php echo $tongchengConfig['tongji_code'];?></div>
<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
   $.get("<?php echo $ajaxCommonClicksUrl;?>");
   $.get("<?php echo $ajaxUpdateTopstatusUrl;?>");
});
<?php if($act == 'list'  ) { ?>
var pageIndex = 1;
$(document).ready(function(){
    loadList("<?php echo $user['id'];?>",pageIndex);
});
$(window).scroll(function (){
    var scrollTop       = $(this).scrollTop();
    var scrollHeight    = $(document).height();
    var windowHeight    = $(this).height();
    if ((scrollTop + windowHeight) >= (scrollHeight * 0.9)) {
        loadList("<?php echo $user['id'];?>",pageIndex);
    }
});

var loadListStatus = 0;
function loadList(userId,Page) {
    if(pageIndex > 50){
        $("#no-more-html").show();
    }
    if(loadListStatus == 1){
        return false;
    }
    loadListStatus = 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxLoadListUrl;?>",
        data: { user_id:userId,page:Page},
        success: function(msg){
            if(pageIndex == 1){
                $("#home-list").html('');
            }
            loadListStatus = 0;
            var data = eval('('+msg+')');
            if(data == 205){
                if(pageIndex == 1){
                    $("#no-list-html").show();
                }else{
                    $("#no-more-html").show();
                }
                return false;
            }else{
                pageIndex += 1;
                $("#home-list").append(data);
            }
        }
    });
}
<?php } ?>
</script>
<?php if($act == 'list'  ) { include template('tom_tongcheng:list_sub'); } ?>
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
      'previewImage'
    ]
});
wx.ready(function () {
    wx.onMenuShareTimeline({
        title: '<?php echo $user['nickname'];?>的主页，共有<?php echo $tcCount;?>条信息等你来看！',
        link: '<?php echo $shareUrl;?>', 
        imgUrl: '<?php echo $shareLogo;?>', 
        success: function () { 
        },
        cancel: function () { 
        }
    });
    wx.onMenuShareAppMessage({
        title: '<?php echo $user['nickname'];?>的主页，共有<?php echo $tcCount;?>条信息等你来看！',
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