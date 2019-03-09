<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<div class="plugin-reply__box">
    <div class="plugin-reply__visible">
        <div class="tcui-dialog weui-dialog--visible">
            <div class="tcui-dialog__hd">
                <strong class="tcui-dialog__title plugin-reply__title">随便说点什么</strong>
            </div>
            <div class="tcui-dialog__bd">
                <div class="text-border">
                    <textarea class="tcui-textarea tcui-prompt-input " id="tcui-prompt-input" placeholder="请输入文字" rows="3"></textarea>
                </div>
            </div>
            <div class="weui-dialog__ft dislay-flex">
                <a href="javascript:void(0);" class="tcui-dialog__btn default plugin-cancel__btn">取消</a>
                <a href="javascript:void(0);" class="tcui-dialog__btn primary plugin-cancel__queren tc-template__color">确定</a>
            </div>
        </div>
    </div>
</div>
<script>
$(document).on("click", ".detail-time-icon",function() {
    var t = $(this),
    a = t.next();
    /*if (!a.hasClass("detail-toolbar")) {
        var id = t.data("id"),message = t.data("message"),user_id = t.data("user-id"),tel = t.data("tel"),tousu = t.data("tousu");
        a = $('<div class="detail-toolbar"><A href="'+tousu+'" rel="nofollow"><img src="source/plugin/tom_tongcheng/images/icon_replay.png">评论</A><a href="javascript:void(0);" onclick="collect('+user_id+','+id+');" class="ajax-post"><img src="source/plugin/tom_tongcheng/images/list_zan.png">点赞</a><A href="'+message+'"><img src="source/plugin/tom_tongcheng/images/icon-message.png">私信</A><A href="'+tel+'" class="ajax-get"><img src="source/plugin/tom_tongcheng/images/icon-tel.png">电话</A></div>'),
        t.after(a);
    }*/
    a.hasClass("active") ? a.removeClass("active") : a.addClass("active");
});
$(document).on("click",function(t) {
    var a = $(t.target);
    a.hasClass("detail-time-icon") || $(".detail-toolbar").removeClass("active");
});
<?php if($tongchengConfig['open_list_quanwen'] == 1) { ?>
$(document).on("click", ".detail-toggle,.detail-toggle2,article",function() {
<?php } else { ?>
$(document).on("click", ".detail-toggle,.detail-toggle2",function() {
<?php } ?>
    var t = $(this).parent(),
    a = t.find("article"),
    i = t.find(".act-bar"),
    id = t.data("id"),
    e = i.find("img");
    $.get("<?php echo $ajaxClicksUrl;?>"+id);
    return a.attr("oldheight") ? (a.css("max-height", a.attr("oldheight") + "px"), a.removeAttr("oldheight"), t.find(".detail-toggle").show(),t.find(".detail-toggle2").hide(), t.find(".act-bar").hide(), void 0) : (a.attr("oldheight", parseInt(a.css("max-height"), 10)), a.css("max-height", "none"), t.find(".detail-toggle").hide(),t.find(".detail-toggle2").show(), i.show(), e.attr("url") && e.attr("src", e.attr("url")).removeAttr("url"), !1)
});
function collect(user_id,tongcheng_id){
    var num = $(".detail-collect__"+tongcheng_id+" .num").html();
    num = num * 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxCollectUrl;?>",
        data: "user_id="+user_id+"&tongcheng_id="+tongcheng_id,
        success: function(msg){
            msg = $.trim(msg);
            if(msg == '100'){
                tusi("已经点赞");
            }else if(msg == '200'){
                if($('.detail-list__'+tongcheng_id).hasClass('box_hide')){
                    $('.detail-list__'+tongcheng_id).removeClass('box_hide');
                }
                $(".detail-collect__"+tongcheng_id+" .num").html(++num);
                $(".detail-collect__"+tongcheng_id).append('<span><img src="<?php echo $__UserInfo['picurl'];?>"></span>');
                
                tusi("点赞成功");
            }else{
                tusi("点赞失败");
            }
        }
    });
}
function showPic(picurl,id){
    var photo_list = $("#photo_list_"+id).val();
    var picarr = photo_list.split('|');
    wx.previewImage({
        current: picurl,
        urls: picarr 
    });
    //$(".id-pic-tip").removeClass('box_hide');
    //$('.id-pic-tip-in').css('background-image', 'url(' + picurl + ')');
}

$(".pic_info").on("click", function(){
    $(".id-pic-tip").addClass('box_hide');
    $('.id-pic-tip-in').css('background-image', '');
});

var swiper = null;
function showPicList(obj, idx){
    var that = obj;
    var index = idx;
    var pictureHtm = '';
    var photo_list = $(that).parent().find(".photo_list").val();
    var picarr = photo_list.split('|');
    if(picarr.length > 0){
        for(var i=0; i<picarr.length; i++){
            pictureHtm += '<div class="swiper-slide "><img src="'+picarr[i]+'"/></div>';
        }
    }
    $('#rebox-wrapper__box').html(pictureHtm);
    $('#rebox').removeClass('bocunceinOut').addClass('bocuncein').show();
    swiper = new Swiper('#rebox', {
        pagination: '.swiper-pagination',
        paginationType: 'fraction',	
        loop: true,	
        preventLinksPropagation : false,
        zoom : true,
        zoomToggle :false,
        lazyLoading : true,
    });
    swiper.slideTo(index * 1 + 1, 0);
    return false;
}
$(document).on('click', '#rebox', function () {
    $('#rebox').removeClass('bocuncein').addClass('bocunceinOut');
    setTimeout(function(){$('#rebox').hide();swiper.destroy();}, 400);
    return false;
});

var u = navigator.userAgent;  
var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
var selectedPluginTongchengId = 0;
var selectedPluginToUserId = 0;
var selectedPluginToNickname = '';
$(document).on('click', '.plugin-cancel__btn', function () {
    selectedPluginTongchengId = 0;
    selectedPluginToUserId = 0;
    selectedPluginToNickname = '';
    $('.plugin-reply__title').html('随便说点什么');
    $('.plugin-reply__box').hide();
    $("#tcui-prompt-input").val('');
});

$(document).on('click', '.list-plugin__btn', function () {
    <?php if($tongchengConfig['open_list_pinglun'] == 0) { ?>
    return false;
    <?php } ?>

    <?php if($showMustPhoneBtn == 1) { ?>
    tusi("评论回复需要绑定手机号");
    return false;
    <?php } ?>
    
    <?php if($__UserInfo['id'] <= 0) { ?>
    tusi("未登录不能评论");
    return false;
    <?php } ?>
    
    selectedPluginTongchengId = $(this).data('id');
    
    if(isiOS){
        $('.plugin-reply__box .plugin-reply__visible').css({
            'position':'absolute',
            'height':$(document).height()+'px',
        });
        $('.plugin-reply__box .weui-dialog--visible').css({
            'position':'absolute',
            'top':($(document).scrollTop() + $(window).height()/2.25)+'px',
        });
    }
    $('.plugin-reply__box').show();
});

$(document).on('click', '.replay-plugin__btn', function () {
    <?php if($tongchengConfig['open_list_pinglun'] == 0) { ?>
    return false;
    <?php } ?>

    <?php if($showMustPhoneBtn == 1) { ?>
    tusi("评论回复需要绑定手机号");
    return false;
    <?php } ?>
    
    <?php if($__UserInfo['id'] <= 0) { ?>
    tusi("未登录不能评论");
    return false;
    <?php } ?>
    selectedPluginTongchengId = $(this).data('id');
    selectedPluginToUserId = $(this).data('touserid');
    selectedPluginToNickname = $(this).data('tonickname');
    
    $('.plugin-reply__box .plugin-reply__title').html('回复:'+ selectedPluginToNickname);

    if(isiOS){
        $('.plugin-reply__box .plugin-reply__visible').css({
            'position':'absolute',
            'height':$(document).height()+'px',
        });
        $('.plugin-reply__box .weui-dialog--visible').css({
            'position':'absolute',
            'top':($(document).scrollTop() + $(window).height()/2.25)+'px',
        });
    }
    $('.plugin-reply__box').show();
});

var submintPingLunStatus = 0;
$(document).on("click", ".plugin-cancel__queren", function () {

    var content = $("#tcui-prompt-input").val();
    if(submintPingLunStatus == 1){
        return false;
    }
    if(content == ""){
        tusi("评论不能为空！");
        return false;
    }
    submintPingLunStatus = 1;
    $.ajax({
        type: "POST",
        url: "<?php echo $addPinglunUrl;?>",
        dataType : "json",
        data: {content:content, tongcheng_id:selectedPluginTongchengId, user_id:"<?php echo $__UserInfo['id'];?>", touser_id:selectedPluginToUserId},
        success: function(data){
            submintPingLunStatus = 0;
            if(data.status == 200){
                $('.detail-plugin__'+selectedPluginTongchengId+' .plugin-item').prepend("<a href='javascript:void(0);' class='replay-plugin__btn' data-id='"+ selectedPluginTongchengId +"' data-touserid='<?php echo $__UserInfo['id'];?>' data-tonickname='<?php echo $__UserInfo['nickname'];?>'><span class='nick'><?php echo $__UserInfo['nickname'];?>:</span>"+ content +"</a>");
      
                if($('.detail-list__'+selectedPluginTongchengId).hasClass('box_hide')){
                    $('.detail-list__'+selectedPluginTongchengId).removeClass('box_hide');
                }
                if($('.detail-plugin__'+selectedPluginTongchengId).hasClass('box_hide')){
                    $('.detail-plugin__'+selectedPluginTongchengId).removeClass('box_hide');
                }
                
                selectedPluginTongchengId = 0;
                selectedPluginToUserId = 0;
                selectedPluginToNickname = '';
                $('.plugin-reply__title').html('随便说点什么');
                $('.plugin-reply__box').hide();
                $("#tcui-prompt-input").val('');
                
                tusi("评论成功!");
                
            }else if(data.status == 200200){
                
                $('.detail-plugin__'+selectedPluginTongchengId+' .plugin-item').prepend("<a href='javascript:void(0);' class='replay-plugin__btn' data-id='"+ selectedPluginTongchengId +"' data-touserid='<?php echo $__UserInfo['id'];?>' data-tonickname='<?php echo $__UserInfo['nickname'];?>'><span class='nick'><?php echo $__UserInfo['nickname'];?></span>回复<span class='nick'>"+selectedPluginToNickname+":</span>"+ content +"</a>");
                if($('.detail-list__'+selectedPluginTongchengId).hasClass('box_hide')){
                    $('.detail-list__'+selectedPluginTongchengId).removeClass('box_hide');
                }
                if($('.detail-plugin__'+selectedPluginTongchengId).hasClass('box_hide')){
                    $('.detail-plugin__'+selectedPluginTongchengId).removeClass('box_hide');
                }
                
                selectedPluginTongchengId = 0;
                selectedPluginToUserId = 0;
                selectedPluginToNickname = '';
                $('.plugin-reply__title').html('随便说点什么');
                $('.plugin-reply__box').hide();
                $("#tcui-prompt-input").val('');
                
                tusi("评论成功!");
                
            }else if(data.status == 401){
                submintPingLunStatus = 0;
                tusi("<?php echo $tongchengConfig['pinglun_next_minute'];?>分钟后才能再发评论");
            }else if(data.status == 505){
                submintPingLunStatus = 0;
                tusi("包含违禁词："+data.word);
            }else{
                tusi("未知错误");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }
        }
    });
});

$(window).scroll(function () {
    if(isiOS){
        $('.plugin-reply__box .plugin-reply__visible').css({
            'height':$(document).height()+'px',
        });
    }
})

</script>
