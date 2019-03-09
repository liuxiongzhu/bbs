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
<title>选择分类 - <?php echo $__SitesInfo['name'];?></title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/iconfont/iconfont.css?v=<?php echo $cssJsVersion;?>" />
<script src="source/plugin/tom_tongcheng/images/jquery.min-2.1.3.js" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?><style>
.tcui-actionsheet__cell:before{border:0}
.tcui-actionsheet__cell{border-bottom:1px solid #EFEFF4;padding:20px 0}
</style>
</head>
<body class="body-white">
<header class="header header-index on in2 tc-template__bg">
    <section class="wrap">
        <?php if($__HideHeader == 0 ) { ?>
        <section class="sec-ico go-back" onclick="history.back();">返回</section>
        <?php } ?>
        <h2>选择分类</h2>
        <section class="sec-ico btn slide-btn"><a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=article">发布须知</a></section>
    </section>
</header>
<div class="mainer">
    <?php if($__ShowTcshop == 1) { ?>
    <?php if($tcshopList) { ?>
    <div class="fabu_step1_new_shop_list" style="display:none;">
        <marquee direction="left" scrollamount="3">
        <a style="white-space: nowrap;">
        <?php if(is_array($tcshopList)) foreach($tcshopList as $key => $val) { ?>        恭喜<font color="#fd0d0d">&lt;<?php echo $val['name'];?>&gt;</font>成功入驻好店&nbsp;&nbsp;&nbsp;&nbsp;
        <?php } ?>
        </a>
        </marquee>
    </div>
    <?php } ?>
    <?php } ?>
    <?php if($fabu_warning_msg) { ?>
    <div class="tcui-cells__title">
        <section style="padding:10px;background: #eff9ff;line-height:1.5;letter-spacing: 1px;">
           <p class="tc-template__color" style="color:#f8a543"><?php echo $fabu_warning_msg;?></p>
        </section>
    </div>
    <?php } ?>
    <div class="clear5"></div>
    <?php if($__ShowTcshop == 1) { ?>
    <div class="tcui-cells" style="margin-top:10px;">
         <a class="tcui-cell tcui-cell_access" href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=ruzhu&amp;prand=<?php echo $prand;?>">
              <div class="tcui-cell__bd tcui-cell_primary align-center">
                <img src="source/plugin/tom_tcshop/images/tcshop_ico.png" style="margin-right:10px;float: left;width:3.5em">
                <p>
                    我有店铺，入驻好店&nbsp;<img src="source/plugin/tom_tcshop/images/icon-hot-text.png" height="16"><br>
                    <span class="f13" style="color:#999;">超低成本，本地宣传，简单有效，方便快捷！</span>
                </p>
              </div>
             <span class="tcui-cell__ft"></span>
         </a>
    </div>
    <?php } ?>
    <div class="clear5"></div>
    <div class="clear5"></div>
    <div class="clear10"></div>
    <div class="tcui-loadmore tcui-loadmore_line">
        <span class="tcui-loadmore__tips">请选择你要发布的栏目</span>
    </div>
    <section class="nav-list">
        <section class="nav-li" style="margin-top:-10px">
            <ul>
                <?php if(is_array($modelList)) foreach($modelList as $key => $val) { ?>                <li style="width:20%">
                    <?php if($val['showType'] == 1) { ?>
                    <a class="cat-item" data-id="<?php echo $val['id'];?>" href="javascript:void(0);">
                    <?php } else { ?>
                    <a class="" href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=fabu&amp;act=step2&amp;type_id=<?php echo $val['typeList']['0']['id'];?>">
                    <?php } ?>
                        <section class="nav-li-pic">
                            <img src="<?php echo $val['picurl'];?>"/>
                        </section>
                        <p><?php echo $val['name'];?></p>
                    </a>
                </li>
                <div id="title-<?php echo $val['id'];?>" style="display:none">
                    发布“<?php echo $val['name'];?>”信息
                </div>
                <div id="child-<?php echo $val['id'];?>" style="display:none">
                    <?php if(is_array($val['typeList'])) foreach($val['typeList'] as $kk => $vv) { ?>                    <a class="tcui-actionsheet__cell" href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=fabu&amp;act=step2&amp;type_id=<?php echo $vv['id'];?>"><?php echo $vv['name'];?></a>
                    <?php } ?>
                </div>
                <?php } ?>
            </ul>
            <section class="clear"></section>
        </section>
    </section>
    <div class="clear5"></div>
    <div class="tcui-loadmore tcui-loadmore_line">
        <span class="tcui-loadmore__tips">请选择你要发布的活动</span>
    </div>
    <section class="nav-list">
        <section class="nav-li" style="margin-top:-10px">
            <ul>
                <?php if($__ShowTcmall == 1) { ?>
                <li style="width:20%">
                    <a class="" href="plugin.php?id=tom_tcmall&amp;site=<?php echo $site_id;?>&amp;mod=ruzhu">
                        <section class="nav-li-pic">
                            <img src="source/plugin/tom_tongcheng/images/mall_ico.png">
                        </section>
                        <p>发布商品</p>
                    </a>
                </li>
                <?php } ?>
                <?php if($__ShowTcqianggou == 1) { ?>
                <li style="width:20%">
                    <a class="" href="plugin.php?id=tom_tcqianggou&amp;site=<?php echo $site_id;?>&amp;mod=fabu&amp;type=qianggou">
                        <section class="nav-li-pic">
                            <img src="source/plugin/tom_tongcheng/images/qianggou_ico.png">
                        </section>
                        <p>发布抢购</p>
                    </a>
                </li>
                <?php } ?>
                <?php if($__ShowTcptuan == 1) { ?>
                <li style="width:20%">
                    <a class="" href="plugin.php?id=tom_tcptuan&amp;site=<?php echo $site_id;?>&amp;mod=fabu">
                        <section class="nav-li-pic">
                            <img src="source/plugin/tom_tongcheng/images/pintuan_ico.png">
                        </section>
                        <p>发布拼单</p>
                    </a>
                </li>
                <?php } ?>
                <?php if($__ShowTckjia == 1) { ?>
                <li style="width:20%">
                    <a class="" href="plugin.php?id=tom_tckjia&amp;site=<?php echo $site_id;?>&amp;mod=fabu">
                        <section class="nav-li-pic">
                            <img src="source/plugin/tom_tongcheng/images/kanjia_ico.png">
                        </section>
                        <p>发布减价</p>
                    </a>
                </li>
                <?php } ?>
                <?php if($__ShowTcqianggou == 1) { ?>
                <li style="width:20%">
                    <a class="" href="plugin.php?id=tom_tcqianggou&amp;site=<?php echo $site_id;?>&amp;mod=fabu&amp;type=kaquan">
                        <section class="nav-li-pic">
                            <img src="source/plugin/tom_tongcheng/images/kaquan_ico.png">
                        </section>
                        <p>发布卡券</p>
                    </a>
                </li>
                <?php } ?>
                <?php if($__ShowTc114 == 1) { ?>
                <li style="width:20%">
                    <a class="" href="plugin.php?id=tom_tc114&amp;site=<?php echo $site_id;?>&amp;mod=ruzhu">
                        <section class="nav-li-pic">
                            <img src="source/plugin/tom_tongcheng/images/114_ico.png">
                        </section>
                        <p>加入电话本</p>
                    </a>
                </li>
                <?php } ?>
                <?php if($__IsMiniprogram == 1 && $jyConfig && $jyConfig['closed_xiao'] == 1 ) { } else { ?>
                <?php if($__ShowLove == 1) { ?>
                <li style="width:20%">
                    <a class="" href="plugin.php?id=tom_love&amp;mod=index">
                        <section class="nav-li-pic">
                            <img src="source/plugin/tom_tongcheng/images/love_ico.png">
                        </section>
                        <p>同城交友</p>
                    </a>
                </li>
                <?php } ?>
                <?php if($__ShowXiangqin == 1) { ?>
                <li style="width:20%">
                    <a class="" href="plugin.php?id=tom_xiangqin&amp;mod=index">
                        <section class="nav-li-pic">
                            <img src="source/plugin/tom_tongcheng/images/xiangqin_ico.png">
                        </section>
                        <p>我要相亲</p>
                    </a>
                </li>
                <?php } ?>
                <?php } ?>
            </ul>
            <section class="clear"></section>
        </section>
    </section>
</div>
<div class="tcui-actionsheet" id="cat-sheet">
    <header class="header on in2 tc-template__bg">
        <section class="wrap"><h2 id="cat-sheet-title">请选择发布类型</h2></section>
    </header>
    <div class="tcui-actionsheet__menu" style="max-height: 385px;overflow: scroll;" id="cat-sheet-menu"></div>
    <div class="clear"></div>
    <div class="tcui-actionsheet__action">
        <div class="tcui-actionsheet__cell" id="cat-sheet-cancel">取消</div>
    </div>
</div><?php include template('tom_tongcheng:footer'); ?><div style="display: none;"><?php echo $tongchengConfig['tongji_code'];?></div>
<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<script>
$(document).ready(function(){
   $.get("<?php echo $ajaxCommonClicksUrl;?>");
   $.get("<?php echo $ajaxUpdateTopstatusUrl;?>");
   $.get("<?php echo $ajaxShenheSmsUrl;?>");
});
$(function () {
    var catSheet = $('#cat-sheet');
    function hideActionSheet() {
        if (catSheet.hasClass('tcui-actionsheet_toggle')) {
            catSheet.removeClass('tcui-actionsheet_toggle');
            hideMask().hide();
        }
        return false;
    }
    $('#cat-sheet-cancel').on('click', hideActionSheet);
    $(".cat-item").on("click", function () {
        var id = $(this).data('id');
        var catEle = $('#child-' + id);
        var catHTML = catEle.html();
        $('#cat-sheet-menu').html(catHTML);
        var titleEle = $('#title-' + id);
        var titleHTML = titleEle.html();
        $('#cat-sheet-title').html(titleHTML);
        catSheet.addClass('tcui-actionsheet_toggle');
        showMask().one('click', hideActionSheet);
        return false;
    });
    <?php if($model_id > 0) { ?>
    var catEle = $('#child-<?php echo $model_id;?>');
    var catHTML = catEle.html();
    $('#cat-sheet-menu').html(catHTML);
    var titleEle = $('#title-<?php echo $model_id;?>');
    var titleHTML = titleEle.html();
    $('#cat-sheet-title').html(titleHTML);
    catSheet.addClass('tcui-actionsheet_toggle');
    showMask().one('click', hideActionSheet);
    return false;
    <?php } ?>
});
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