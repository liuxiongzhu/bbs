<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<!DOCTYPE html>
<html>
<head>
<?php if($isGbk) { ?>
<meta charset="GBK">
<?php } else { ?>
<meta charset="UTF-8">
<?php } ?>
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
<title>合伙人中心</title>
<link rel="stylesheet" href="source/plugin/tom_tchehuoren/images/weui.css?v=<?php echo $cssJsVersion;?>"/>
<link rel="stylesheet" href="source/plugin/tom_tchehuoren/images/style.css?v=<?php echo $cssJsVersion;?>"/>
<link rel="stylesheet" href="source/plugin/tom_tchehuoren/images/iconfont/iconfont.css?v=<?php echo $cssJsVersion;?>" />
<script src="source/plugin/tom_tchehuoren/images/jquery.min-2.1.3.js" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tchehuoren/images';
</script>
<script src="source/plugin/tom_tchehuoren/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?><style>
.my_info_box .my_yaoqi_menu .yaoqi_menu a.on{ color:<?php echo $tongchengConfig['template_color'];?>; border-color:<?php echo $tongchengConfig['template_color'];?>;}
.my_info_box .info-title span{ background:<?php echo $tongchengConfig['template_color'];?>;}
.my_info_box .info-title span.info-title__lt:after{ border-color:<?php echo $tongchengConfig['template_color'];?>; }
.my_info_box .info-title span.info-title__rt:before{ border-color:<?php echo $tongchengConfig['template_color'];?>; }
</style>
</head>
<body>
<section class="my_header">
<div class="header_hd">
<div class="header_hd_left">
<img src="<?php echo $tchehuorenInfo['picurl'];?>">
</div>
<div class="header_hd_right">
<h4><?php echo $__UserInfo['nickname'];?></h4>
<p><a href="plugin.php?id=tom_tchehuoren&amp;site=<?php echo $site_id;?>&amp;mod=level"><img src="<?php echo $dengjiInfo['picurl'];?>">（等级说明）</a></p>
</div>
</div>
<div class="header_bd">
<div class="header_bd_term">
<div class="type_name">今天收入(元)</div>
<div class="type_num"><span class="red"><?php echo $todayMoney;?></span></div>
</div>
<div class="header_bd_term">
<div class="type_name">本周收入(元)</div>
<div class="type_num"><span class="red"><?php echo $weekMoney;?></span></div>
</div>
<div class="header_bd_term">
<div class="type_name">本月收入(元)</div>
<div class="type_num"><span class="red"><?php echo $monthMoney;?></span></div>
</div>
</div>
</section>
<section class="my_info_box">
<div class="info-title">
        <span class="info-title__lt"></span>推广任务<span class="info-title__rt"></span>
    </div>
<div class="info-tg_task">
<?php if($dengjiInfo['fl_fc_open'] == 1) { ?>
        <div class="tg_task_term">
<div class="task_term_hd">
<div class="task_border"><i class="tciconfont tcicon-xinxi__hehuoren"></i></div>
<div class="line"></div>
</div>
<div class="task_term_bd">
<h6>同城平台推广</h6>
<div class="task_text"><p><?php echo $fl_tuiguang_desc;?></p></div>
                <div class="task_button">
<a id="show_haibao" class="button tc-template__bg" href="javascript:void(0);">海报推广</a>
                    <?php if($tchehuorenConfig['open_link_share'] == 1) { ?>
                    <a class="button_link tc-template__color tc-template__border" onclick="showLinkShare();" href="javascript:void(0);">链接邀请</a>
                    <?php } ?>
</div>
<p class="task_pormpt"><?php echo $fl_tuiguang_below_desc;?></p>
</div>
</div>
        <?php } ?>
        <?php if($dengjiInfo['shop_fc_open'] == 1 && $__ShowTcshop == 1 && $tchehuorenConfig['tcshop_type'] == 1) { ?>
<div class="tg_task_term">
<div class="task_term_hd">
<div class="task_border"><i class="tciconfont tcicon-shop"></i></div>
<div class="line"></div>
</div>
<div class="task_term_bd">
<h6>好店入驻推广</h6>
<div class="task_text"><p>邀请码:&nbsp;<?php echo $tchehuorenInfo['invite_code'];?><?php echo $tcshop_ruzhu_discount_msg;?></p></div>
<p class="task_pormpt"><?php echo $shop_tuiguang_below_desc;?></p>
</div>
</div>
        <?php } ?>
        <?php if($dengjiInfo['mall_fc_open'] == 1 && $__ShowTcmall == 1) { ?>
<div class="tg_task_term">
<div class="task_term_hd">
<div class="task_border"><i class="tciconfont tcicon-mall"></i></div>
<div class="line"></div>
</div>
<div class="task_term_bd">
<h6>商城商品推广</h6>
<div class="task_button">
<a class="button  tc-template__bg" href="plugin.php?id=tom_tcmall&amp;site=<?php echo $site_id;?>&amp;mod=list&amp;is_tg=1">商城活动<i class="tciconfont tcicon-bofang"></i></a>
</div>
<p class="task_pormpt"><?php echo $mall_tuiguang_below_desc;?></p>
</div>
</div>
        <?php } ?>
        <?php if($dengjiInfo['qg_fc_open'] == 1 && $__ShowTcqianggou == 1) { ?>
<div class="tg_task_term">
<div class="task_term_hd">
<div class="task_border"><i class="tciconfont tcicon-qianggou"></i></div>
<div class="line"></div>
</div>
<div class="task_term_bd">
<h6>抢购商品推广</h6>
<div class="task_button">
<a class="button tc-template__bg" href="plugin.php?id=tom_tcqianggou&amp;site=<?php echo $site_id;?>&amp;mod=index&amp;tui=1">抢购活动<i class="tciconfont tcicon-bofang"></i></a>
</div>
<p class="task_pormpt"><?php echo $qg_tuiguang_below_desc;?></p>
</div>
</div>
        <?php } ?>
        <?php if($dengjiInfo['pt_fc_open'] == 1 && $__ShowTcptuan == 1) { ?>
<div class="tg_task_term">
<div class="task_term_hd">
<div class="task_border"><i class="tciconfont tcicon-ptuan"></i></div>
<div class="line"></div>
</div>
<div class="task_term_bd">
<h6>拼单商品推广</h6>
<div class="task_button">
<a class="button  tc-template__bg" href="plugin.php?id=tom_tcptuan&amp;site=<?php echo $site_id;?>&amp;mod=index&amp;tui=1">拼单活动<i class="tciconfont tcicon-bofang"></i></a>
</div>
<p class="task_pormpt"><?php echo $pt_tuiguang_below_desc;?></p>
</div>
</div>
        <?php } ?>
        <?php if($dengjiInfo['114_fc_open'] == 1 && $__ShowTc114 == 1 && $tchehuorenConfig['tc114_type'] == 1) { ?>
<div class="tg_task_term">
<div class="task_term_hd">
<div class="task_border"><i class="tciconfont tcicon-114"></i></div>
<div class="line"></div>
</div>
<div class="task_term_bd">
<h6>电话本入驻推广</h6>
<div class="task_text"><p>邀请码:&nbsp;<?php echo $tchehuorenInfo['invite_code'];?><?php echo $tc114_ruzhu_discount_msg;?></p></div>
<p class="task_pormpt"><?php echo $tc114_tuiguang_below_desc;?></p>
</div>
</div>
        <?php } ?>
        <?php if($tchehuorenConfig['open_subordinate'] == 1 && $tchehuorenConfig['subordinate_type'] == 1) { ?>
        <div class="tg_task_term">
<div class="task_term_hd">
<div class="task_border"><i class="tciconfont tcicon-tuandui"></i></div>
<div class="line"></div>
</div>
<div class="task_term_bd">
<h6>下级伙伴推广
                    <?php if($tchehuorenInfo['tj_hehuoren_id'] > 0 ) { ?>
                    <span class="red">(我的推荐人: <?php echo $TJtchehuorenInfo['xm'];?> )</span>
                    <?php } ?>
                </h6>
<div class="task_text"><p><?php echo $subordinate_tuiguang_desc;?></p></div>
<p class="task_pormpt"><?php echo $subordinate_tuiguang_below_desc;?></p>
</div>
</div>
        <?php } ?>
</div>
</section>
<section class="my_info_box">
<div class="my_yaoqi_menu clearfix">
<div class="yaoqi_menu menu_button" ><a data-id="shouyi_box" class="on" href="javascript:void(0);">最新收益</a></div>
        <div class="yaoqi_menu menu_button" ><a data-id="yushouyi_box" href="javascript:void(0);">预计收益</a></div>
        <?php if($tchehuorenConfig['open_subordinate'] == 1) { ?>
<div class="yaoqi_menu menu_button"><a data-id="xiaodi_box" href="javascript:void(0);">我的下级</a></div>
        <?php } ?>
<div class="yaoqi_menu menu_button"><a data-id="yaoqi_box" href="javascript:void(0);">我的粉丝</a></div>
</div>
    <div id="shouyi_box" class="shouyi term_box">
        <?php if($shouyiList) { ?>
        <div class="shouyi_box">
            <?php if(is_array($shouyiList)) foreach($shouyiList as $key => $value) { ?>            <div class="shouyi_term clearfix">
                <div class="shouyi_term_hd">
                    <p class="name"><?php echo $value['userInfo']['nickname'];?></p>
                    <p class="cont">
                    <?php if($value['child_hehuoren_id'] > 0) { ?>
                    [下级]
                    <?php } ?>
                    <?php echo $value['type'];?>
                    </p>
                </div>
                <div class="shouyi_term_bd">
                    <p class="price"><span class="red">￥<?php echo $value['shouyi_price'];?></span></p>
                    <?php if($value['shouyi_status'] == 1) { ?>
                    <p class="status1"><?php echo $value['ruzhuang_time'];?> 入账</p>
                    <?php } ?>
                    <?php if($value['shouyi_status'] == 2) { ?>
                    <p class="status2">已入账</p>
                    <?php } ?>
                    <p class="time"><?php echo dgmdate($value[add_time], 'u');?></p>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="m1 box_prompt" style="display:block;"><a id="shouyi_more" href="javascript:void(0);">查看更多</a></div>
        <div class="m2 box_prompt"><a href="javascript:void(0);"><img src="source/plugin/tom_tchehuoren/images/loading.gif">加载中...</a></div>
        <div class="m3 box_prompt"><a href="javascript:void(0);">没有更多了</a></div>
        <?php } else { ?>
        <div class="box_prompt" style="display:block;">没有更多了</div>
        <?php } ?>
    </div>
    <div id="yushouyi_box" class="shouyi term_box">
        <?php if($yushouyiList) { ?>
        <div class="yushouyi_box">
            <?php if(is_array($yushouyiList)) foreach($yushouyiList as $key => $value) { ?>            <div class="yushouyi_term clearfix">
                <div class="yushouyi_term_hd">
                    <p class="name"><?php echo $value['userInfo']['nickname'];?></p>
                    <p class="cont">
                    <?php if($value['child_hehuoren_id'] > 0) { ?>
                    [下级]
                    <?php } ?>
                    <?php echo $value['type'];?>
                    </p>
                </div>
                <div class="yushouyi_term_bd">
                    <p class="price"><span class="red">￥<?php echo $value['shouyi_price'];?></span></p>
                    <p class="status1">核销后入账</p>
                    <p class="time"><?php echo dgmdate($value[add_time], 'u');?></p>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="m1 box_prompt" style="display:block;"><a id="yushouyi_more" href="javascript:void(0);">查看更多</a></div>
        <div class="m2 box_prompt"><a href="javascript:void(0);"><img src="source/plugin/tom_tchehuoren/images/loading.gif">加载中...</a></div>
        <div class="m3 box_prompt"><a href="javascript:void(0);">没有更多了</a></div>
        <?php } else { ?>
        <div class="box_prompt" style="display:block;">没有更多了</div>
        <?php } ?>
    </div>
    <?php if($tchehuorenConfig['open_subordinate'] == 1) { ?>
    <div id="xiaodi_box" class="xiaodi term_box">
        <?php if($myUserListTmp) { ?>
        <div class="ter_count">我的下级<span class="red">(<?php echo $myUserCount;?>)</span>人</div>
        <div class="xiaodi_box">
            <?php if(is_array($myUserListTmp)) foreach($myUserListTmp as $key => $value) { ?>            <div class="xiaodi_term">
                <p><?php echo $value['xm'];?>  <span><?php echo dgmdate($value[add_time], 'u');?></span></p>
            </div>
            <?php } ?>
        </div>
        <div class="m1 box_prompt" style="display:block;"><a id="xiaodi_more" href="javascript:void(0);">查看更多</a></div>
        <div class="m2 box_prompt"><a href="javascript:void(0);"><img src="source/plugin/tom_tchehuoren/images/loading.gif">加载中...</a></div>
        <div class="m3 box_prompt"><a href="javascript:void(0);">没有更多了</a></div>
        <?php } else { ?>
        <div class="box_prompt" style="display:block;">没有更多了</div>
        <?php } ?>
    </div>
    <?php } ?>
    <div id="yaoqi_box" class="yaoqi term_box">
        <?php if($myTcUserList) { ?>
        <div class="ter_count">我的粉丝<span class="red">(<?php echo $myTcUserCount;?>)</span>人</div>
        <div class="yaoqi_box">
            <?php if(is_array($myTcUserList)) foreach($myTcUserList as $key => $value) { ?>            <div class="yaoqi_term">
                <p><?php echo $value['nickname'];?>  <span><?php echo dgmdate($value[add_time], 'u');?></span></p>
            </div>
            <?php } ?>
        </div>
        <div class="m1 box_prompt" style="display:block;"><a id="yaoqi_more" href="javascript:void(0);">查看更多</a></div>
        <div class="m2 box_prompt"><a href="javascript:void(0);"><img src="source/plugin/tom_tchehuoren/images/loading.gif">加载中...</a></div>
        <div class="m3 box_prompt"><a href="javascript:void(0);">没有更多了</a></div>
        <?php } else { ?>
        <div class="box_prompt" style="display:block;">没有更多了</div>
        <?php } ?>
    </div>
</section>
<section class="height50"></section><?php include template('tom_tchehuoren:footer'); ?><section class="index_menu_nav">
    <a  href="javascript:void(0);" class="nav-area" onclick="guanzu('<?php echo $tchehuorenConfig['kefu_qrcode'];?>','kefu');">联系 <br/> 客服</a>
    <?php if($tchehuorenConfig['open_group_qrcode'] == 1) { ?>
    <a  href="javascript:void(0);" class="nav-area" onclick="guanzu('<?php echo $tchehuorenConfig['group_qrcode'];?>','group');">群二 <br/> 维码</a>
    <?php } ?>
    <a  href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=money" class="nav-area" >申请 <br/> 提现</a>
    <a  href="javascript:void(0);" class="nav-area index_menu_close" ></a>
</section>
<?php if($subscribeFlag==2) { ?>
<section id="subscribe_box" class="info_guanzu_pormpt">
    <div class="guanzu_pormpt_area guanzu_pormpt_left">
        <div class="guanzu_text">接受审核、活动消息等实时提醒</div>
    </div>
    <div class="guanzu_pormpt_area guanzu_pormpt_right">
        <div class="guanzu_button" onclick="guanzu('<?php echo $tongchengConfig['fwh_qrcode'];?>','fwh');">关注</div>
        <div class="guanzu_close" onclick="$('#subscribe_box').hide();"></div>
    </div>
</section>
<?php } ?>
<div class="js_dialog" id="pic_popup" style="display: none;">
    <div class="weui-mask"></div>
    <div class="weui-dialog">
        <div class="weui-dialog__bd">
            <img id="pic" src="">
            <p id="text" class="center">长按二维码识别关注</p>
        </div>
        <div class="weui-dialog__ft">
            <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary">确认</a>
        </div>
    </div>
</div>
<form action="" id="haibao_form" method="post" onsubmit="return false;">
    <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
    <input type="hidden" name="share_url" value="<?php echo $tongchengUrl;?>">
</form>
<div id="dialogs">
    <div class="js_dialog" id="showHaibaoBox" style="display: none;">
        <div class="weui-mask"></div>
        <div class="weui-dialog">
            <div class="weui-dialog__bd" id="id_haibao_img"><img src=""/></div>
            <div class="weui-dialog__ft">
                <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary">知道了</a>
            </div>
        </div>
    </div>
</div>
<div id="loadingHaibao" style="display:none;">
    <div class="weui-mask_transparent"></div>
    <div class="weui-toast">
        <i class="weui-loading weui-icon_toast"></i>
        <p class="weui-toast__content">正在生成海报</p>
    </div>
</div>
<?php if($tchehuorenInfo['status'] == 2) { ?>
<div class="js_dialog">
    <div class="weui-mask"></div>
    <div class="weui-dialog">
        <div class="weui-dialog__bd">
            <img id="pic" src="">
            <p class="center">您的合伙人账号已被冻结，详情请联系客服</p>
        </div>
        <div class="weui-dialog__ft">
            <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary">知道了</a>
        </div>
    </div>
</div>
<?php } ?>
<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<script>
function showLinkShare(){
$('body').append('<div id="share_link_box" onclick="hideLinkShare();" style="z-index:99999999;position:fixed;left:0px;top:0px;width:100%;height:100%;background-color: rgba(0,0,0,0.5);text-align:right;" ontouchmove="return true;" ><img src="source/plugin/tom_tchehuoren/images/sharetips.png" style="margin-top:10px;margin-right:10px;"></div>');
}
function hideLinkShare(){
    $("#share_link_box").remove();
}

$(document).on('click', '#show_haibao', function(){
    $('#loadingHaibao').fadeIn(100);
    $.ajax({
        type: "POST",
        url: 'plugin.php?id=tom_tchehuoren:haibao',
        data: $('#haibao_form').serialize(),
        success: function(msg){
            $('#loadingHaibao').fadeOut(100);
            var dataarr = msg.split('|');
            dataarr[0] = $.trim(dataarr[0]);
            if(dataarr[0] == 'OK') {
                $('#id_haibao_img').css({'padding':'0'}).html('<img style="display:block" src="'+dataarr[1]+'"/>');
                $('#showHaibaoBox').fadeIn(200);
            }else if(dataarr[0] == 'QR'){
                tusi("没有安装TOM二维码");
            }else if(dataarr[0] == 'HB'){
                tusi("没有上传海报背景图");
            }else{
                tusi("生成海报错误");
            }
        }
    });
})
$(function(){
    $(document).on('click', '.weui-dialog__btn', function(){
        $(this).parents('.js_dialog').fadeOut(200);
    });
});

$(document).on('click', '.menu_button a', function(){
    var id = $(this).data('id');
    $('.menu_button').find('a').removeClass('on');
    $(this).addClass('on');
    $('#'+id).show().siblings('.term_box').hide();
})

function guanzu(picurl,type){
    $('#pic').attr('src', picurl);
    if(type == 'fwh'){
        $('#pic_popup #text').html('<?php echo 长按二维码识别关注;?>');
    }else if(type == 'group'){
        $('#pic_popup #text').html('<?php echo 长按二维码识别进群，与其他合伙人一起交流;?>');
    }else if(type == 'kefu'){
        $('#pic_popup #text').html('<?php echo 长按二维码添加客服微信;?>');
    }
    $('#pic_popup').show();
}

$(document).on('click', '.index_menu_close', function(){
    $('.index_menu_nav').fadeOut(200);
})

var onLoadShouyiStatus = 0;
var shouyiPage = 2;
$(document).on('click', '#shouyi_more', function(){
    if(onLoadShouyiStatus == 1){
        return false;
    }
    onLoadShouyiStatus = 1

    $('#shouyi_box .m1').hide();
    $('#shouyi_box .m2').show();
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxUrl;?>",
        data: { act:"loadMoreShouyi",loadPage:shouyiPage},
        success: function(msg){
            var data = eval('('+msg+')');
            if(data == 205){
                $('#shouyi_box .m2').hide();
                $('#shouyi_box .m3').show();
                return false;
            }else{
                onLoadShouyiStatus = 0;
                $('#shouyi_box .m2').hide();
                $('#shouyi_box .m1').show();
                shouyiPage += 1;
                $(".shouyi_box").append(data);
                flag = 1;
            }
        }
    })
})

var onLoadYushouyiStatus = 0;
var yushouyiPage = 2;
$(document).on('click', '#yushouyi_more', function(){
    if(onLoadYushouyiStatus == 1){
        return false;
    }
    onLoadYushouyiStatus = 1

    $('#yushouyi_box .m1').hide();
    $('#yushouyi_box .m2').show();
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxUrl;?>",
        data: { act:"loadMoreYushouyi",loadPage:yushouyiPage},
        success: function(msg){
            var data = eval('('+msg+')');
            if(data == 205){
                $('#yushouyi_box .m2').hide();
                $('#yushouyi_box .m3').show();
                return false;
            }else{
                onLoadYushouyiStatus = 0;
                $('#yushouyi_box .m2').hide();
                $('#yushouyi_box .m1').show();
                yushouyiPage += 1;
                $(".yushouyi_box").append(data);
                flag = 1;
            }
        }
    })
})

var onLoadXiaodiStatus = 0;
var xiaodiPage = 2;
$(document).on('click', '#xiaodi_more', function(){
    if(onLoadXiaodiStatus == 1){
        return false;
    }
    onLoadXiaodiStatus = 1

    $('#xiaodi_box .m1').hide();
    $('#xiaodi_box .m2').show();
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxUrl;?>",
        data: { act:"loadMoreXiaodi",loadPage:xiaodiPage},
        success: function(msg){
            var data = eval('('+msg+')');
            if(data == 205){
                $('#xiaodi_box .m2').hide();
                $('#xiaodi_box .m3').show();
                return false;
            }else{
                onLoadXiaodiStatus = 0;
                $('#xiaodi_box .m2').hide();
                $('#xiaodi_box .m1').show();
                xiaodiPage += 1;
                $(".xiaodi_box").append(data);
                flag = 1;
            }
        }
    })
})

var onLoadYaoqiStatus = 0;
var yaoqiPage = 2;
$(document).on('click', '#yaoqi_more', function(){
    if(onLoadYaoqiStatus == 1){
        return false;
    }
    onLoadYaoqiStatus = 1

    $('#yaoqi_box .m1').hide();
    $('#yaoqi_box .m2').show();
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxUrl;?>",
        data: { act:"loadMoreYaoqi",loadPage:yaoqiPage},
        success: function(msg){
            var data = eval('('+msg+')');
            if(data == 205){
                $('#yaoqi_box .m2').hide();
                $('#yaoqi_box .m3').show();
                return false;
            }else{
                onLoadYaoqiStatus = 0;
                $('#yaoqi_box .m2').hide();
                $('#yaoqi_box .m1').show();
                yaoqiPage += 1;
                $(".yaoqi_box").append(data);
                flag = 1;
            }
        }
    })
})
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
      'previewImage'
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
    wx.onMenuShareQQ({
        title: '<?php echo $shareTitle;?>',
        desc: '<?php echo $shareDesc;?>',
        link: '<?php echo $shareUrl;?>',
        imgUrl: '<?php echo $shareLogo;?>',
        success: function () { 
        },
        cancel: function () { 
        }
    });
});
</script>
</body>
</html>