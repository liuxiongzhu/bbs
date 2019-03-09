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
<title>塞福利</title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tchongbao/images/hb_style.css?v=<?php echo $cssJsVersion;?>" />
<script src="source/plugin/tom_tongcheng/images/jquery-1.8.3.min.js" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?></head>
<body>
<header class="header header-index on in2 tc-template__bg">
   <section class="wrap">
       <section class="sec-ico go-back" onclick="window.location.href='<?php echo $backUrl;?>&prand=<?php echo $prand;?>'">返回</section>
        <h2>塞福利</h2>
   </section>
</header>
<?php if($tchongbaoInfo['status'] == 1) { ?>
<form class="add_form" name="edit_form" id="edit_form" onsubmit="return false;">
    <section class="wrap edit-form">
        <div class="btn-group-block" style="margin-top: 10px;">
            <p class="pt">福利还没有领取结束,还剩余<?php echo $tchongShenyuCount;?>个福利，剩余<?php echo $tchongbaoInfo['money'];?>元。</p>
        </div>
        <?php if($tchongbaoInfo['open_kouling'] == 1) { ?>
        <div class="tcui-cells tcui-cells_form">
            <div id="input_kouling" class="tcui-cell">
                <div class="tcui-cell__hd">
                    <label class="tcui-label">输入口令:</label>
                </div>
                <div class="tcui-cell__bd">
                    <input class="tcui-input" type="text" id="kouling" name="kouling" value="<?php echo $tchongbaoInfo['kouling'];?>" placeholder="输入口令">
                </div>
            </div>
            <div id="input_kouling_pormpt" class="tcui-cells tcui-cells_form" style="margin-top:0;">
                <div class="tcui-cell">
                    <div class="tcui-cell__bd">
                        <textarea class="tcui-textarea" id="kouling_pormpt" name="kouling_pormpt" placeholder="填写口令提示，引导抢红包用户找到口令。" row="3"><?php echo $tchongbaoInfo['kouling_pormpt'];?></textarea>
                    </div>
                </div>
            </div>
            <div class="box_hide">
                <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
                <input type="hidden" name="tchongbao_id" value="<?php echo $tchongbaoInfo['id'];?>">
                <input type="hidden" name="site" value="<?php echo $site_id;?>">
                <input type="hidden" name="act" value="edit_kouling">
            </div>
        </div>
        <div class="btn-group-block" style="margin-top: 10px;">
            <button type="button" class="id_edit_btn  tc-template__bg">修改口令信息</button>
        </div>
        <?php } ?>
    </section>
</form>
<?php } else { ?>
<form class="add_form" name="add_form" id="add_form" onsubmit="return false;">
    <section class="wrap edit-form">
        <div class="tcui-cells__title" style="display:none;">
             <section style="padding:10px;background: #eff9ff;line-height:1.5;letter-spacing: 1px;">
                <p style="color:#f8a543"></p>
             </section>
        </div>
        <div class="tcui-cells tcui-cells_form">
            <div class="tcui-cell">
                <div class="tcui-cell__hd">
                    <label class="tcui-label">福利总金额:</label>
                </div>
                <div class="tcui-cell__bd">
                    <input class="tcui-input" type="number" id="all_money" name="all_money" pattern="[0-9]" placeholder="请输入福利金额">
                </div>
            </div>
            <div class="tcui-cells__tips all_money_tips hongbao_tips"></div>
            <div class="tcui-cell">
                <div class="tcui-cell__hd">
                    <label class="tcui-label">分成几份:</label>
                </div>
                <div class="tcui-cell__bd">
                    <input class="tcui-input" type="number" id="hb_count" name="hb_count" pattern="[0-9]" placeholder="<?php if($tchongbaoConfig['hongbao_min_count'] > 0) { ?>至少<?php echo $tchongbaoConfig['hongbao_min_count'];?>份<?php } ?>">
                </div>
            </div>
            <div class="tcui-cells__tips hb_count_tips hongbao_tips"></div>
            <div class="tcui-cell tcui-cell_switch">
                <div class="tcui-cell__bd">是否平均分配福利</div>
                <div class="tcui-cell__ft">
                    <input class="tcui-switch" type="checkbox" id="fenpei_status" name="fenpei_status" value="1">
                </div>
            </div>
            <div class="tcui-cells__tips fenpei_status_tips hongbao_tips"></div>
            <?php if($tchongbaoConfig['open_kouling_hb'] == 1) { ?>
            <div class="tcui-cell tcui-cell_switch <?php if($tchongbaoConfig['hb_lq_type'] != 1) { ?>box_hide <?php } ?>">
                <div class="tcui-cell__bd">是否开启口令模式<?php if($tchongbaoConfig['open_kouling_hb_qunfa'] == 0) { ?><span style="font-size:0.7em; color:#F00;">(口令福利不支持公众号群发)</span><?php } ?></div>
                <div class="tcui-cell__ft">
                    <input class="tcui-switch" type="checkbox" id="open_kouling" name="open_kouling" value="1">
                </div>
            </div>
            <div id="input_kouling" class="tcui-cell box_hide">
                <div class="tcui-cell__hd">
                    <label class="tcui-label">输入口令:</label>
                </div>
                <div class="tcui-cell__bd">
                    <input class="tcui-input" type="text" id="kouling" name="kouling" placeholder="输入口令">
                </div>
            </div>
            <div id="input_kouling_pormpt" class="tcui-cells tcui-cells_form box_hide" style="margin-top:0;">
                <div class="tcui-cell">
                    <div class="tcui-cell__bd">
                        <textarea class="tcui-textarea" id="kouling_pormpt" name="kouling_pormpt" placeholder="填写口令提示，引导抢红包用户找到口令。" row="3"></textarea>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="box_hide">
                <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
                <input type="hidden" name="tongcheng_id" value="<?php echo $tongcheng_id;?>">
                <input type="hidden" name="tcshop_id" value="<?php echo $tcshop_id;?>">
                <input type="hidden" name="site" value="<?php echo $site_id;?>">
                <input type="hidden" name="act" value="<?php echo $pay_save;?>">
                <input type="hidden" name="user_id" value="<?php echo $__UserInfo['id'];?>">
            </div>
        </div>
        <div id="shouxu_text" class="shouxu_text"></div>
        <div id="min_hongbao_text" class="min_hb_text"></div>
        <div class="btn-group-block">
            <button type="button" class="id_fahongbao_btn  tc-template__bg">确定</button>
        </div>
        <?php if($tchongbaoConfig['open_hb_template_sms'] < 999999 && $tchongbaoConfig['open_hb_template_sms'] > 0) { ?>
        <div class="template_pormpt">温馨提示：只有福利总金额达到<?php echo $tchongbaoConfig['open_hb_template_sms'];?>元才会公众号群发。</div>
        <?php } ?>
    </section>
</form>
<?php } if($send_status == 1 && $tchongbaoInfo['pay_status'] == 2 && $tchongbaoInfo['send_status'] != 1) { ?>
<section class="add_hb_pormpt">
    <div class="pormpt_box">
        <div class="pt_text">
            <p class="title">恭喜你</p>
            <p class="txt">成功塞了<?php echo $tchongbaoInfo['all_money'];?>元福利</p>
            <a class="button" href="<?php echo $succLookUrl;?>">点击查看</a>
        </div>
        <div class="pormpt_close" onClick="$('.add_hb_pormpt').hide();"></div>
    </div>
</section>
<?php } if($add_hb_text) { ?>
<div class="tcui-cells__title">
    <section style="padding:10px;background: #eff9ff;line-height:1.5;letter-spacing: 1px;">
       <p style="color:#f8a543"><?php echo $add_hb_text;?></p>
    </section>
</div>
<?php } ?>
<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<script src="source/plugin/tom_tchongbao/images/jisuan.js" type="text/javascript" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
    <?php if($send_status == 1 && $tongchengInfo['shenhe_status'] == 1 && $tchongbaoInfo['pay_status'] == 2 && $tchongbaoInfo['send_status'] != 1) { ?>
        <?php if($tchongbaoInfo['open_kouling'] == 1) { ?>
            <?php if($tchongbaoConfig['open_kouling_hb_qunfa'] == 1) { ?>
                $.get("<?php echo $templateSmsAjaxUrl;?>");
            <?php } ?>
        <?php } else { ?>
            $.get("<?php echo $templateSmsAjaxUrl;?>");
        <?php } ?>
    <?php } ?>
})
$(function(){
    <?php if($send_status == 1 && $tcshopInfo['shenhe_status'] == 1 && $tchongbaoInfo['pay_status'] == 2 && $tchongbaoInfo['send_status'] != 1) { ?>
        <?php if($tchongbaoInfo['open_kouling'] == 1) { ?>
            <?php if($tchongbaoConfig['open_kouling_hb_qunfa'] == 1) { ?>
                $.get("<?php echo $templateSmsAjaxUrl;?>");
            <?php } ?>
        <?php } else { ?>
            $.get("<?php echo $templateSmsAjaxUrl;?>");
        <?php } ?>
    <?php } ?>
})
   
var bili = "<?php echo $tchongbaoConfig['hongbao_shouxufei'];?>";
bili = bili * 1;
$('#all_money').change(function(){
    var all_money = $('#all_money').val();
    var hb_count = $('#hb_count').val();
    if(all_money != '' && hb_count != '' && $('#fenpei_status').attr('checked')){
        var all_hb_money = all_money * 100;
        if((all_hb_money % hb_count) != 0){
            $('.hongbao_tips').hide();
            $('.all_money_tips').html('福利总额和份数是不是整数倍');
            $('.all_money_tips').show();
        }else{
            $('.hongbao_tips').hide();
        }
    }

    var sx_money = accMul(accDiv(bili, 100), all_money);
    var money = accAdd(sx_money, all_money);
    $('#shouxu_text').html("需要支付: "+all_money+"(福利) + "+sx_money+"(平台手续费) = "+money+"（总金额）");
});

$('#hb_count').change(function(){
    var all_money = $('#all_money').val();
    var hb_count = $('#hb_count').val();
    if(all_money != '' && hb_count != '' && $('#fenpei_status').attr('checked')){
        all_money = all_money * 100;
        if((all_money % hb_count) != 0){
            $('.hongbao_tips').hide();
            $('.hb_count_tips').html('福利总额和份数是不是整数倍');
            $('.hb_count_tips').show();
        }else{
            $('.hongbao_tips').hide();
        }
    }
});

$('#fenpei_status').change(function(){
    var all_money = $('#all_money').val();
    var hb_count = $('#hb_count').val();
    if(all_money != '' && hb_count != '' && $('#fenpei_status').attr('checked')){
        all_money = all_money * 100;
        if((all_money % hb_count) != 0){
            $('.hongbao_tips').hide();
            $('.fenpei_status_tips').html('福利总额和份数是不是整数倍');
            $('.fenpei_status_tips').show();
        }else{
            $('.hongbao_tips').hide();
        }
    }else{
        $('.hongbao_tips').hide();
    }
});
   
$('#all_money').click(function(){
    $('#min_hongbao_text').hide();
});
$('#hb_count').click(function(){
    $('#min_hongbao_text').hide();
});
   
$('#open_kouling').change(function(){
    if($(this).attr('checked') && $('#input_kouling').hasClass('box_hide')){
        $('#input_kouling').removeClass('box_hide');
        $('#input_kouling_pormpt').removeClass('box_hide');
    }else if(!$('#input_kouling').hasClass('box_hide')){
        $('#input_kouling').addClass('box_hide');
        $('#input_kouling_pormpt').addClass('box_hide');
    }
});
   
var submintPayStatus = 0;
$(".id_fahongbao_btn").click( function () { 
    if(submintPayStatus == 1){
        return false;
    }
    var all_money = $('#all_money').val();
    var hb_count = $('#hb_count').val();
    var kouling = $.trim($('#kouling').val());
    var kouling_pormpt = $.trim($('#kouling_pormpt').val());

    if(all_money <= 0){
        tusi('福利总金额不能小于0元');
        return false;
    }
    if(hb_count < 1){
        tusi('福利份数不能小于1份');
        return false;
    }
    
    if($('#fenpei_status').attr('checked')){
        all_money = all_money * 100;
        if((all_money % hb_count) != 0){
            tusi('福利总额和份数是不是整数倍');
            return false;
        }
    }
    <?php if($tchongbaoConfig['open_kouling_hb'] == 1) { ?>
    if($('#open_kouling').attr('checked') && kouling == ''){
        tusi('口令不能为空');
        return false;
    }
    if($('#open_kouling').attr('checked') && kouling_pormpt == ''){
        tusi('口令提示不能为空');
        return false;
    }
    <?php } ?>
    loading('处理中...');
    submintPayStatus = 1;
    $.ajax({
        type: "POST",
        url: "<?php echo $payUrl;?>",
        dataType : "json",
        data: $('#add_form').serialize(),
        success: function(data){
            submintPayStatus = 0;
            loading(false);
            if(data.status == 200) {
                tusi("下单成功，立即支付");
                setTimeout(function(){window.location.href=data.payurl+"&prand=<?php echo $prand;?>";},500);
            }else if(data.status == 301){
                tusi("还没有福利没有被领取，不能再发福利");
                return false;
            }else if(data.status == 302){
                tusi("没有安装TOM支付中心插件");
                return false;
            }else if(data.status == 303){
                tusi("生成微信订单失败");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 304){
                tusi("人均所得福利不能小于0.01元");
                return false;
            }else if(data.status == 305){
                $('#min_hongbao_text').html(data.hbPormpt);
                $('#min_hongbao_text').show();
                return false;
            }else if(data.status == 306){
                tusi("福利份数不能大于<?php echo $tchongbaoConfig['hongbao_max_count'];?>");
                return false;
            }else if(data.status == 307){
                tusi("福利份数不能小于<?php echo $tchongbaoConfig['hongbao_min_count'];?>");
                return false;
            }else if(data.status == 404){
                tusi("插入信息数据失败");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 505){
                tusi("包含违禁词："+data.word);
                return false;
            }else{
                tusi("异常错误");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }
        }
    });
});


var submintPayStatus = 0;
$(".id_edit_btn").click( function () { 
    if(submintPayStatus == 1){
        return false;
    }
    var kouling = $.trim($('#kouling').val());
    var kouling_pormpt = $.trim($('#kouling_pormpt').val());

    if(kouling == ''){
        tusi('口令不能为空');
        return false;
    }
    if(kouling_pormpt == ''){
        tusi('口令提示不能为空');
        return false;
    }
    loading('处理中...');
    submintPayStatus = 1;
    $.ajax({
        type: "POST",
        url: "<?php echo $payUrl;?>",
        dataType : "json",
        data: $('#edit_form').serialize(),
        success: function(data){
            submintPayStatus = 0;
            loading(false);
            if(data.status == 200) {
                tusi("修改成功");
            }else{
                tusi("修改失败");
            }
        }
    });
});

</script>
</body>
</html>

