<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<link href="source/plugin/tom_tongcheng/images/pinglun.css?v=<?php echo $cssJsVersion;?>" rel="stylesheet" />
<section class="info-item info-item-pinglun">
    <div class="info-item-comment">
        <div class="comment-title">全部评论<span onClick="comment();">评论</span>
            <?php if($open_edit_pinglun == 1 && $pinglunList) { ?>
            <span>
                <a id="close_remove" href="javascript:;" onClick="hide_pinglun_remove();">[关闭]</a>
                <a id="show_remove" href="javascript:;" onClick="show_pinglun_remove();">编辑</a>
            </span>
            <?php } ?>
        </div>
        <div id="comment-list" data-id="<?php echo $tongcheng_id;?>">
            <?php if(is_array($pinglunList)) foreach($pinglunList as $key => $value) { ?>            <div class="comment-item clearfix" id="comment-item_<?php echo $value['id'];?>" data-id="<?php echo $tongcheng_id;?>" data-touserid="<?php echo $value['userInfo']['id'];?>" data-tonickname="<?php echo $value['userInfo']['nickname'];?>">
                <div class="comment-item-avatar"><img src="<?php echo $value['userInfo']['picurl'];?>"></div>
                <div class="comment-item-content">
                    <h5><span onClick="comment_reply(this);"><?php echo $value['userInfo']['nickname'];?></span>
                        <?php if($value['touser_id'] > 0) { ?>
                        <span class="hf">&nbsp;回复:&nbsp;</span><span onClick="comment_reply(this);"><?php echo $value['touser_nickname'];?></span>
                        <?php } ?>
                        <span class="right remove" onClick="removePinglun(<?php echo $value['id'];?>);">[删除]</span>
                        <span class="right"  onClick="comment_reply(this);"><?php echo dgmdate($value['ping_time']);?></span>
                    </h5>
                    <div class="comment-item-content-text" onClick="comment_reply(this);"><?php echo $value['content'];?></div>
                    <?php echo $value['reply_list'];?>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php if($pinglunList) { ?>
        <div id="m1" class="no-comment-more"><a href="javascript:;" onClick="loadMore();">点击加载更多</a></div>
        <?php } else { ?>
        <div id="m1" class="no-comment-more box_hide"><a href="javascript:;" onClick="loadMore();">点击加载更多</a></div>
        <div class="no-comment"><a href="javascript:;">还没有评论...</a></div>
        <?php } ?>
        <div id="m2" class="no-comment-more"><a href="javascript:;">没有更多评论...</a></div>
        <div id="m3" class="no-comment-more"><img src="source/plugin/tom_tongcheng/images/loading.gif"><a href="javascript:;">正在加载...</a></div>
        
    </div>
</section>
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

<div class="plugin-info__box">
    <div class="plugin-reply__visible">
        <div class="tcui-dialog weui-dialog--visible">
            <div class="tcui-dialog__hd">
                <strong class="tcui-dialog__title plugin-reply__title">随便说点什么</strong>
            </div>
            <div class="tcui-dialog__bd">
                <div class="text-border">
                    <textarea class="tcui-textarea tcui-prompt-input " id="tcui-info-input" placeholder="请输入文字" rows="3"></textarea>
                </div>
            </div>
            <div class="weui-dialog__ft dislay-flex">
                <a href="javascript:void(0);" class="tcui-dialog__btn default plugin-info__cancel">取消</a>
                <a href="javascript:void(0);" class="tcui-dialog__btn primary plugin-info__queren tc-template__color">确定</a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).on('click', '.tcui-dialog__btn_primary', function(){
    $(this).parents('.js_dialog').fadeOut(200);
})

var info_u = navigator.userAgent;  
var info_isiOS = !!info_u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
var infoPluginTongchengId = 0;
var infoPluginToUserId = 0;
var infoPluginToNickname = '';
$(document).on('click', '.plugin-info__cancel', function () {
    infoPluginTongchengId = 0;
    infoPluginToUserId = 0;
    infoPluginToNickname = '';
    $('.plugin-info__box .plugin-reply__title').html('随便说点什么');
    $('.plugin-info__box').hide();
    $("#tcui-info-input").val('');
});

function comment(){
    <?php if($__UserInfo['id'] <= 0) { ?>
    tusi("未登录不能评论");
    return false;
    <?php } ?>
    
    infoPluginTongchengId = "<?php echo $tongcheng_id;?>";
    
    if(info_isiOS){
        $('.plugin-info__box .plugin-reply__visible').css({
            'position':'absolute',
            'height':$(document).height()+'px',
        });
        $('.plugin-info__box .weui-dialog--visible').css({
            'position':'absolute',
            'top':($(document).scrollTop() + $(window).height()/2.25)+'px',
        });
    }
    $('.plugin-info__box').show();
    
}

function comment_reply(obj){
    <?php if($__UserInfo['id'] <= 0) { ?>
    tusi("未登录不能评论");
    return false;
    <?php } ?>
    var that = obj;
    infoPluginTongchengId = $(that).parents('.comment-item').data('id');
    infoPluginToUserId = $(that).parents('.comment-item').data('touserid');
    infoPluginToNickname = $(that).parents('.comment-item').data('tonickname');
    
    $('.plugin-info__box .plugin-reply__title').html('回复:'+ infoPluginToNickname);

    if(info_isiOS){
        $('.plugin-info__box .plugin-reply__visible').css({
            'position':'absolute',
            'height':$(document).height()+'px',
        });
        $('.plugin-info__box .weui-dialog--visible').css({
            'position':'absolute',
            'top':($(document).scrollTop() + $(window).height()/2.25)+'px',
        });
    }
    $('.plugin-info__box').show();
}

function removeId(id){
$("#"+id).remove();
}

var submintPingLunStatus = 0;
$(document).on("click", ".plugin-info__queren", function () {
    
    <?php if($showMustPhoneBtn == 1) { ?>
    infoPluginTongchengId = 0;
    infoPluginToUserId = 0;
    infoPluginToNickname = '';
    $('.plugin-info__box .plugin-reply__title').html('随便说点什么');
    $('.plugin-info__box').hide();
    $("#tcui-info-input").val('');
    $('#pinglun_phone').show();
    return false;
    <?php } ?>

    <?php if($loginStatus == 0) { ?>
    tusi("未登陆，请点击“我的”登陆");
        return false;
    <?php } ?>

    var content = $("#tcui-info-input").val();
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
        data: {content:content, tongcheng_id:infoPluginTongchengId, user_id:"<?php echo $__UserInfo['id'];?>", touser_id:infoPluginToUserId},
        success: function(data){
            submintPingLunStatus = 0;
            
            if(data.status == 200){
                
                var pinglunHtml = '<div class="comment-item clearfix" id="comment-item_'+data.pinglun_id+'" data-id="<?php echo $tongcheng_id;?>" data-touserid="<?php echo $__UserInfo['id'];?>" data-tonickname="<?php echo $__UserInfo['nickname'];?>">';
                pinglunHtml += '<div class="comment-item-avatar"><img src="<?php echo $__UserInfo['picurl'];?>"></div>';
                pinglunHtml += '<div class="comment-item-content">';
                pinglunHtml += '<h5><span onClick="comment_reply(this);"><?php echo $__UserInfo['nickname'];?></span>';
                pinglunHtml += '<span class="right remove" onClick="removePinglun(<?php echo $value['id'];?>);">[删除]</span>';
                pinglunHtml += '<span class="right"  onClick="comment_reply(this);">刚刚</span></h5>';
                pinglunHtml += '<div class="comment-item-content-text" onClick="comment_reply(this);">' + content + '</div>';
                pinglunHtml += '</div></div>';
                
                $('#comment-list').prepend(pinglunHtml);
                
                if($('#m1').hasClass('box_hide')){
                    $('#m1').removeClass('box_hide');
                }
                if($('.no-comment').length > 0){
                    $('.no-comment').remove();
                }
                
                infoPluginTongchengId = 0;
                infoPluginToUserId = 0;
                infoPluginToNickname = '';
                $('.plugin-info__box .plugin-reply__title').html('随便说点什么');
                $('.plugin-info__box').hide();
                $("#tcui-info-input").val('');
            
                tusi("评论成功!");
            }else if(data.status == 200200){
                
                var pinglunHtml = '<div class="comment-item clearfix" id="comment-item_'+data.pinglun_id+'" data-id="<?php echo $tongcheng_id;?>" data-touserid="<?php echo $__UserInfo['id'];?>" data-tonickname="<?php echo $__UserInfo['nickname'];?>">';
                pinglunHtml += '<div class="comment-item-avatar"><img src="<?php echo $__UserInfo['picurl'];?>"></div>';
                pinglunHtml += '<div class="comment-item-content">';
                pinglunHtml += '<h5><span onClick="comment_reply(this);"><?php echo $__UserInfo['nickname'];?></span>';
                pinglunHtml += '<span class="hf">&nbsp;回复:&nbsp;</span><span >' + infoPluginToNickname + '</span>';
                
                pinglunHtml += '<span class="right remove" onClick="removePinglun(<?php echo $value['id'];?>);">[删除]</span>';
                pinglunHtml += '<span class="right"  onClick="comment_reply(this);">刚刚</span></h5>';
                pinglunHtml += '<div class="comment-item-content-text" onClick="comment_reply(this);">' + content + '</div>';
                pinglunHtml += '</div></div>';
                
                $('#comment-list').prepend(pinglunHtml);
                
                infoPluginTongchengId = 0;
                infoPluginToUserId = 0;
                infoPluginToNickname = '';
                $('.plugin-info__box .plugin-reply__title').html('随便说点什么');
                $('.plugin-info__box').hide();
                $("#tcui-info-input").val('');
            
                tusi("回复成功!");
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
    if(info_isiOS){
        $('.plugin-info__box .plugin-reply__visible').css({
            'height':$(document).height()+'px',
        });
    }
})

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

var pageIndex = 2;
var submintLoadStatus = 0;
function loadMore(){
    if(submintLoadStatus == 1){
        return false;
    }
    $('#m1').hide();
    $('#m3').show();
    submintLoadStatus = 1;
    $.ajax({
type: "GET",
url: "<?php echo $showPinglunUrl;?>",
data: {loadPage:pageIndex,pinglun_num:pinglun_num},
success: function(msg){
        submintLoadStatus = 0;
var data = eval('('+msg+')');
            if(data == 201){
                tusi("没有更多评论");
                $('#m3').hide();
                $('#m2').show();
            }else{
                $("#comment-list").append(data);
                $('#m3').hide();
                $('#m1').show();
                pageIndex++;
                
            }
}
})
}

</script>

