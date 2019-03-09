<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); if($__ShowTchongbao == 1 && $tchongbaoInfo['status'] == 1 && $show_hongbao_button == 1 && $lqHongbaoStatus == 0) { ?>
<section class="info-hongbao">
    <div class="hongbao-button" style="bottom: 51px;">
        <a href="javascript:;" onClick="hongbaoFilter();">领取福利</a>
    </div>
</section>
<?php } if($__ShowTchongbao == 1 && $tchongbaoInfo['only_show'] == 1) { ?>
<section class="info-hongbao-box">
    <div class="hongbao-box">
        <div class="shop-pic" style="margin-top: 40px">
            <img src="<?php echo $sendHongbaoUserInfo['picurl'];?>">
            <p><?php echo $sendHongbaoUserInfo['nickname'];?></p>
            <p>给你发了一个福利</p>
        </div>
        <?php if($tchongbaoInfo['open_kouling'] == 1) { ?>
        <?php } else { ?>
        <div class="bongbao-title" style="height: 40px;"></div>
        <?php } ?>
        <form id="qiang_hongbao_form" onsubmit="return false;">
            <?php if($tchongbaoInfo['open_kouling'] == 1) { ?>
            <input type="text" id="kouling" name="kouling" value="" placeholder="请输入领取口令">
            <?php } ?>
            <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
            <input type="hidden" name="site" value="<?php echo $site_id;?>">
            <input type="hidden" name="tcshop_id" value="<?php echo $tcshop_id;?>">
            <input type="hidden" name="act" value="open_tcshop_hb">
            <input type="hidden" name="hongbao_id" value="<?php echo $tchongbaoInfo['id'];?>">
            <input type="hidden" id="longitude" name="longitude" value="<?php echo $longitude;?>">
            <input type="hidden" id="latitude" name="latitude" value="<?php echo $latitude;?>">
        </form>
        <div class="hongbao-button" id="open_hb"><img src="source/plugin/tom_tchongbao/images/hongbao_qiang.png"></div>
        <?php if($tchongbaoInfo['open_kouling'] == 1) { ?>
        <p class="kouling_pormpt"><span>口令提示：</span><?php echo $tchongbaoInfo['kouling_pormpt'];?></p>
        <?php } ?>
        <div class="hongbao-close" onClick="hongbaoBoxHide();"></div>
    </div>
</section>
<?php if($tchongbaoConfig['mp3_link']) { ?>
<script src="source/plugin/tom_tchongbao/images/music/music.js" type="text/javascript"></script>
<div class="music_play_yinfu" id="music_audio_btn" style="display: none;">
    <div id="music_yinfu" class="music_rotate"></div>
    <audio id="music_media" controls="controls" src="<?php echo $tchongbaoConfig['mp3_link'];?>" ></audio>
</div>
<?php } ?>
<div id="loadingToast" class="loading-toast">
    <div class="tcui-mask_transparent"></div>
    <div class="tcui-toast">
        <i class="tcui-loading tcui-icon_toast"></i>
        <p class="tcui-toast__content"></p>
    </div>
</div>
<div id="toast" style="display: none;">
    <div class="tcui-mask_transparent"></div>
    <div class="tcui-toast">
        <i class="tcui-icon-success-no-circle tcui-icon_toast"></i>
        <p class="tcui-toast__content">红包已抢完</p>
    </div>
</div>
<script type="text/javascript">
<?php if($__ShowTchongbao == 1 && $lqHongbaoStatus != 1 && $tchongbaoInfo['status'] == 1 && $openLocaltionDistance == 1 && $hongbaoLocationStatus == 0) { ?>
    $('#loadingToast .tcui-toast .tcui-toast__content').html("红包定位中...");
    $('#loadingToast').show();
<?php } if($tchongbaoInfo['status'] == 2 && $lastLogTime > TIMESTAMP) { ?>
$(function(){
    $('#toast').fadeIn(100);
    setTimeout(function () {
        $('#toast').fadeOut(100);
    }, 2000);
});
<?php } ?>
$(document).ready(function(){
    <?php if($tchongbaoConfig['mp3_link']) { ?>
    var audio2 = $('#music_media');
    audio2[0].pause();
    <?php } ?>
});

var hbButtomClickStatus = 0;
function hongbaoFilter(){
    <?php if($tchongbaoConfig['mp3_link']) { ?>
    var audio2 = $('#music_media');
    audio2[0].play();
    <?php } ?>
    <?php if($openLocaltionDistance == 2) { ?>
    tusi('请在手机微信客户端打开网页');
    return false;
    <?php } elseif($openLocaltionDistance == 3) { ?>
    tusi('[301]定位失败，无法领取福利');
    return false;
    <?php } elseif($openLocaltionDistance == 1) { ?>
        
        <?php if($hongbaoLocationStatus == 1) { ?>
            hbButtomClickStatus = 1;
            hongbaoBox();
            return false;
        <?php } elseif($hongbaoLocationStatus == 2) { ?>
            tusi('不在允许抢福利地区');
            return false;
        <?php } ?>
        
        if(getLocationStatus == 1){
            if(hbButtomClickStatus == 1){
                hongbaoBox();
            }else{
                tusi('不在允许抢福利地区');
                return false;
            }
        }else if(getLocationStatus == 2){
            tusi("用户拒绝授权获取地理位置");
            return false;
        }else{
            tusi('定位失败，请刷新页面重新定位');
            return false;
        }
        
    <?php } else { ?>
    hbButtomClickStatus = 1;
    hongbaoBox();
    return false;
    <?php } ?>
}

function locationRequest(){
    var lat = $('#latitude').val();
    var long = $('#longitude').val();
    
    <?php if($hongbaoLocationStatus == 1) { ?>
        getLocationStatus = 1;
        hbButtomClickStatus = 1;
        return false;
    <?php } elseif($hongbaoLocationStatus == 2) { ?>
        getLocationStatus = 1;
        return false;
    <?php } ?>
    
    if(lat == '' || long == ''){
        $('#loadingToast').hide();
        tusi('[304]定位失败，无法领取福利');
        return false;
    }
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxDistanceHongbaoUrl;?>",
        data: {latitude:lat,longitude:long},
        success: function(msg){
            getLocationStatus = 1;
            $('#loadingToast').hide();
            var data = eval('('+msg+')');
            if(data == 200){
                hbButtomClickStatus = 1;
            }else if(data == 301){
                tusi('[305]定位失败，无法领取福利');
                return false;
            }else if(data == 302){
                tusi('[306]定位失败，无法领取福利');
                return false;
            }else if(data == 303){
                tusi('不在允许抢福利地区');
                return false;
            }else{
                tusi('定位失败，无法领取福利');
                return false;
            }
        }
    });
}

function hongbaoBox(){
    <?php if($tchongbaoConfig['hb_lq_type'] == 1) { ?>
    $('.info-hongbao-box').show();
    <?php } ?>
}
    
function hongbaoBoxHide(){
    <?php if($tchongbaoConfig['mp3_link']) { ?>
    var audio2 = $('#music_media');
    audio2[0].pause();
    <?php } ?>
    $('.info-hongbao-box').hide();
}

var openHongbaoStatus = 0;
$('#open_hb').click(function(){
    <?php if($tchongbaoInfo['status'] != 1) { ?>
    tusi("福利已经领取完了");
    return false;
    <?php } ?>
    
    <?php if($tchongbaoConfig['open_hb_position'] == 1) { ?>
    if(hbButtomClickStatus != 1){
        tusi("不在允许抢福利地区");
        return false;
    }
    <?php } ?>
    <?php if($tchongbaoInfo['open_kouling'] == 1) { ?>
    var kouling = $('#kouling').val();
    if(kouling == ''){
        tusi("请输入领取口令");
        return false;
    }
    <?php } ?>
    if(openHongbaoStatus == 1){
        return false;
    }
    openHongbaoStatus = 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxHongbaoUrl;?>",
        data: $('#qiang_hongbao_form').serialize(),
        success: function(msg){
            openHongbaoStatus = 0;
            var data = eval('('+msg+')');
            if(data == 200){
                setTimeout(function(){window.location.href='<?php echo $hongbaoLogListUrl;?>';},500);
            }else if(data == 301){
                tusi("福利不存在");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data == 302){
                tusi("福利已经发放结束");
                return false;
            }else if(data == 303){
                tusi("口令错误，请重新填写");
                return false;
            }else if(data == 304){
                tusi("已经领取过了，不能再领取");
                setTimeout(function(){window.location.href='<?php echo $hongbaoLogListUrl;?>';},500);
            }else if(data == 305){
                tusi("福利已经发放结束");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else{
                tusi("异常错误");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }
        }
    });
})

</script>
<?php } ?>