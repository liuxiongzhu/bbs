<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<link href="source/plugin/tom_tcshop/images/pinglun.css?v=<?php echo $cssJsVersion;?>" rel="stylesheet" />
<section class="info-item info-item-pinglun" style="background:#fff;">
    <div class="info-item-comment">
        <div class="comment-title">商家评论<span class="tc-template__color" onClick="comment('comment_pinglun');">评论</span>
            <?php if($open_edit_pinglun == 1 && $pinglunCount > 0) { ?>
            <span>
                <a id="close_remove" href="javascript:;" onClick="hide_pinglun_remove();">[关闭]</a>
                <a id="show_remove" href="javascript:;" onClick="show_pinglun_remove();">编辑</a>
            </span>
            <?php } ?>
        </div>
        <div id="comment_pinglun"></div>
        <?php if($pinglunCount > 0) { ?>
        <div id="comment-list"></div>
        <div id="m1" class="no-comment-more"><a href="javascript:;" onClick="loadPinglunMore(2);">点击加载更多</a></div>
        <div id="m2" class="no-comment-more"><a href="javascript:;">没有更多评论...</a></div>
        <div id="m3" class="no-comment-more"><img src="source/plugin/tom_tongcheng/images/loading.gif"><a href="javascript:;">正在加载...</a></div>
        <?php } else { ?>
        <div class="no-comment"><a href="javascript:;">还没有评论...</a></div>
        <?php } ?>
        
    </div>
</section>
<div class="swiper-container rebox" id="rebox">
    <div class="swiper-wrapper " id="rebox-wrapper__box">
    </div>
    <div class="swiper-pagination rebox-pagination"></div>
<div class="swiper-close" id="rebox-close"></div>
</div>
<div class="js_dialog" id="pinglun_phone" style="display: none;">
    <div class="tcui-mask"></div>
    <div class="tcui-dialog">
        <div class="tcui-dialog__hd"><strong class="tcui-dialog__title">温馨提示</strong></div>
        <div class="tcui-dialog__bd">评论回复需要绑定手机号</div>
        <div class="tcui-dialog__ft">
            <a href="<?php echo $phoneUrl;?>" class="tcui-dialog__btn tcui-dialog__btn_default">去绑定</a>
            <a href="javascript:;" class="tcui-dialog__btn tcui-dialog__btn_primary">取消</a>
        </div>
    </div>
</div>
<script type="text/input_comment" id="show_comment">
<div  class='post-ping-kuang-bottom-content bz' style='z-index:0;'>
<form id="add_pinglun_form" onsubmit="return false">
<ul class='temp-describe-photo post-wrap-pic-select clearfix bz' id='imgList' style='height: auto; display:none'>
<li class='lastpost' id='btn-addimg'  style='cursor:pointer;width:55px;height:55px;max-height: auto;' >
<img class='addfile' src='source/plugin/tom_tongcheng/images/pinglun/pic.png'   style='width:55px;height:55px;' >
<input type="file" name="pinglunPic" id="pinglunPic" style='cursor:pointer;width:55px;height:55px;'>
</li>
</ul>

<div class='post-ping-kuang-textarea rel'>
<textarea style='resize:none;' id='txtContentAdd' name='txtContentAdd' class='rel' placeholder='用户评论：'></textarea>
            <input type="hidden" name="tcshop_id" id="tcshop_id">
            <input type="hidden" name="pinglun_id" id="pinglun_id">
            <input type="hidden" name="user_id" id="user_id">
            <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
            
</div>
</form>
<div class='bt-list'>
<span id='send-repley-button' style='cursor:pointer;' class='post-ping-bt-send'>发表</span>
<span id='cancle-reply-button' style='cursor:pointer;' class='post-ping-bt-cancel' >取消</span>
<i class='bt-face' id='btn-qqface' style='cursor:pointer;'></i>
<i class='bt-img temp-upload-img' id='reply-upload-img-btn' style='cursor:pointer; display:none;' ></i>
</div>

<div class='chat-view-face-group' id='div-qqfaces' style='height:185px; display:none;'>
<div class='chat-view-window-face' style="height:100%;">
<div id="qqfaceid" class="post-qq-face bz clearfix">
<?php if($qqface) { ?>
                <?php if(is_array($qqface)) foreach($qqface as $key => $value) { ?>                <span class="fl">
<a href="javascript:;" class="qqface-img" title="<?php echo $key;?>" code="[<?php echo $key;?>]" style="<?php echo $value['background-position'];?>"></a>
               	</span>
                <?php } ?>
                <?php } ?>
            </div>
</div>
</div>
</div>

</script>
<script type="text/javascript">
$(document).on('click', '.tcui-dialog__btn_primary', function(){
    $(this).parents('.js_dialog').fadeOut(200);
})

function comment(id){
    $(".post-ping-kuang-bottom-content").remove();
var plHtm = $("#show_comment").html();
$('#'+id).html(plHtm);
    $('#reply-upload-img-btn').show();
    $('#tcshop_id').val(<?php echo $tcshopInfo['id'];?>);
    $('#user_id').val(<?php echo $__UserInfo['id'];?>);
    
}

function comment_reply(id, ssid, name){
    $(".post-ping-kuang-bottom-content").remove();
var plHtm = $("#show_comment").html();
$('#'+id).html(plHtm);
    $('#pinglun_id').val(ssid);
    $('#tcshop_id').val(<?php echo $tcshopInfo['id'];?>);
    $('#user_id').val(<?php echo $__UserInfo['id'];?>);
    //$('#txtContentAdd').attr('placeholder','回复'+name+':')
}

$(document).on("click", "#cancle-reply-button", function () {
$(".post-ping-kuang-bottom-content").hide();
});
$(document).on("click", "#reply-upload-img-btn", function () {
$("#imgList").show();
});
$(document).on("click", "#btn-qqface", function () {
$("#div-qqfaces").toggle();
});

function removeId(id){
$("#"+id).remove();
}

$(document).on("click", "#txtContentAdd", function () {
$("#div-qqfaces").hide();
});

$(document).on("click", ".post-qq-face a", function () {
var facedata = $(this).attr("code");
$("#txtContentAdd").val($("#txtContentAdd").val() + facedata);
});

var submintPingLunStatus = 0;
$(document).on("click", "#send-repley-button", function () {
    
    <?php if($loginStatus == 0) { ?>
    tusi("请在微信里面打开");
        return false;
    <?php } ?>

    <?php if($showMustPhoneBtn == 1) { ?>
    $('#pinglun_phone').show();
    return false;
    <?php } ?>

    var content = $("#txtContentAdd").val();
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
        url: "<?php echo $addTcshopPinglunUrl;?>",
        data: $('#add_pinglun_form').serialize(),
        success: function(msg){
            //submintPingLunStatus = 0;
            var data = eval('('+msg+')');
            if(data == 200){
                tusi("评论成功!");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data == 200200){
                tusi("回复成功!");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
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

function show_pinglun_remove(){
    $('#show_remove').hide();
    $('#close_remove').show();
    $('.info-item-pinglun').before('<style id="show_remove_style">.remove{display:inline-block;}</style>');
}

function hide_pinglun_remove(){
    $('#close_remove').hide();
    $('#show_remove').show();
    $('#show_remove_style').remove();
}

var pinglun_num = 0;
<?php if($open_edit_pinglun == 1) { ?>
function removePinglun(ping_id){
    
    layer.open({
        content: '你确定删除该用户评论以及下面的回复?'
        ,btn: ['确定', '取消']
        ,yes: function(index){
          $.ajax({
                type: "GET",
                url: "<?php echo $removePinglunUrl;?>",
                data: {ping_id:ping_id},
                success: function(msg){
                    if(msg == '200'){
                        pinglun_num++;
                        $('#comment-item_'+ping_id).remove();
                        tusi("评论删除成功");
                    }else{
                        tusi("异常错误");
                    }
                }
            });
          layer.close(index);
        }
    });
}
<?php } if($open_edit_pinglun == 1) { ?>
function removeReply(reply_id){
    
    layer.open({
        content: '你确定删除该用户的回复?'
        ,btn: ['确定', '取消']
        ,yes: function(index){
          $.ajax({
                type: "GET",
                url: "<?php echo $removeReplyUrl;?>",
                data: {reply_id:reply_id},
                success: function(msg){
                    if(msg == '200'){
                        $('#comment-item-content-text_'+reply_id).remove();
                        tusi("回复删除成功");
                    }else{
                        tusi("异常错误");
                    }
                }
            });
          layer.close(index);
        }
    });
    
}
<?php } ?>

var pinglunPageIndex = 1;
var submintPinglunLoadStatus = 0;
function loadPinglunMore(type){
    if(type == 1){
        pinglunPageIndex = 1;
    }
    if(submintPinglunLoadStatus == 1){
        return false;
    }
    $('#m1').hide();
    $('#m3').show();
    submintPinglunLoadStatus = 1;
    $.ajax({
type: "GET",
url: "<?php echo $showPinglunUrl;?>",
data: {loadPage:pinglunPageIndex,pinglun_num:pinglun_num},
success: function(msg){
        submintPinglunLoadStatus = 0;
var data = eval('('+msg+')');
            if(data == 201){
                if(pinglunPageIndex != 1){
                    //tusi("没有更多评论");
                }
                $('#m3').hide();
                $('#m2').show();
            }else{
                $("#comment-list").append(data);
                $('#m3').hide();
                $('#m1').show();
                pinglunPageIndex++;
                
            }
}
})
}

var swiper = null;
function showPicList(picListStr){

    var pictureHtm = '';
    var picarr = picListStr.split('|');

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
    //swiper.slideTo($(this).parent().find('img').index($(this))+1, 0);
    return false;
}
$(document).on('click', '#rebox', function () {
    $('#rebox').removeClass('bocuncein').addClass('bocunceinOut');
    setTimeout(function(){$('#rebox').hide();swiper.destroy();}, 400);
    return false;
});

</script>
<script src="source/plugin/tom_tongcheng/images/localResizeIMG4/dist/lrz.bundle.js" type="text/javascript"></script>
<script>
var picurl_count = 0;
var pinglun_pic_num = "<?php echo $tcshopConfig['pinglun_pic_num'];?>";
pinglun_pic_num = pinglun_pic_num * 1;

$(document).on('change', '#pinglunPic', function() {
    if(picurl_count >= pinglun_pic_num){
        tusi('已经到达上传最大数量');
        return false;
    }
    loading('上传中...');
    lrz(this.files[0], {width:640,quality:0.8,fieldName:"pinglunPic"})
        .then(function (rst) {
            return rst;
        })
        .then(function (rst) {
            rst.formData.append('fileLen', rst.fileLen);
            $.ajax({
                url: '<?php echo $pinglunPloadUrl;?>',
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
                        $("#btn-addimg").before('<li class="lastpost" ><img class="addfile" src="'+dataarr[1]+'" /><input type="hidden" name="picurl[]" value="'+dataarr[2]+'"/><i onclick="removePic();"></i></li>');
                        picurl_count++;
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

function removePic(){
    $(document).on('click', '.lastpost i', function(){
        $(this).parents('.lastpost').remove();
        picurl_count--;
    });
}
</script>

