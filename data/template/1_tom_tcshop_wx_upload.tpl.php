<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<script>
wx.ready(function () {
    $(document).on('click', '#filedata1', function(){
        wx.chooseImage({
            count: 1,
            sizeType: ['original', 'compressed'],
            sourceType: ['album', 'camera'],
            success: function (res) {
                var length = res.localIds.length;
                if(length > 0){
                    loading('上传中...');
                    uploadImg(res, 1);
                }
            }
        });
    })
    
    $(document).on('click', '#filedata2', function(){
        wx.chooseImage({
            count: 9,
            sizeType: ['original', 'compressed'],
            sourceType: ['album', 'camera'],
            success: function (res) {
                var length = res.localIds.length;
                if(length > 0){
                    loading('上传中...');
                    uploadImg(res, 2);
                }
            }
        });
    })
    
    $(document).on('click', '#filedata3', function(){
        wx.chooseImage({
            count: 1,
            sizeType: ['original', 'compressed'],
            sourceType: ['album', 'camera'],
            success: function (res) {
                var length = res.localIds.length;
                if(length > 0){
                    loading('上传中...');
                    uploadImg(res, 3);
                }
            }
        });
    })
    
    $(document).on('click', '#filedata4', function(){
        wx.chooseImage({
            count: 1,
            sizeType: ['original', 'compressed'],
            sourceType: ['album', 'camera'],
            success: function (res) {
                var length = res.localIds.length;
                if(length > 0){
                    loading('上传中...');
                    uploadImg(res, 4);
                }
            }
        });
    })
    
    $(document).on('click', '#filedata5', function(){
        wx.chooseImage({
            count: 9,
            sizeType: ['original', 'compressed'],
            sourceType: ['album', 'camera'],
            success: function (res) {
                var length = res.localIds.length;
                if(length > 0){
                    loading('上传中...');
                    uploadImg(res, 5);
                }
            }
        });
    })
    
    $(document).on('click', '#shop_focuspic', function(){
        wx.chooseImage({
            count: 9,
            sizeType: ['original', 'compressed'],
            sourceType: ['album', 'camera'],
            success: function (res) {
                var length = res.localIds.length;
                if(length > 0){
                    loading('上传中...');
                    uploadImg(res, 6);
                }
            }
        });
    })
    
    function uploadImg(res, type){
        var i = 0, length = res.localIds.length;
        if(length > 0){
            function upload(){    
                wx.uploadImage({
                    localId: res.localIds[i], 
                    isShowProgressTips: 0, 
                    success: function (res) {
                        var serverId = res.serverId;
                        downloadServer(serverId, type);
                        i++;
                        if(i < length){
                            upload(); 
                        }else{
                            loading(false);
                        }
                    },
                    fail:function(res){
                        loading(false);
                        tusi('上传失败，请重新上传！');
                    }
                });
            }
            upload();
        }
    } 
    
    function downloadServer(serverId, type){
        var type = type;
        $.ajax({
            type:'POST',
            url:'<?php echo $wxUploadUrl2;?>',
            data:{serverId:serverId},
            dataType:'json',
            success:function(data){
                if(data.status == 200){
                    if(type == 1){
                        $("#picurl").html('<li><section class="img"><img src="'+data.picurl+'" /><input type="hidden" name="picurl" value="'+data.picurl+'"/></section></li>');
                        picurl_count++;
                    }else if(type == 2){
                        $("#photolist").append('<li class="li_'+li_i+'"><section class="img"><img src="'+data.picurl+'" /><input type="hidden" name="photo_'+li_i+'" value="'+data.picurl+'"/><input type="hidden" name="photothumb_'+li_i+'" value="'+data.thumburl+'"/></section><div class="paixu">排序<input class="tcui-input" type="text" id="photosort_'+li_i+'" name="photosort_'+li_i+'" value="999"/></div><div class=" close pic-delete-btn pointer" onclick="picremove('+li_i+');">&nbsp;X&nbsp;</div></li>');
                        li_i++;
                        photo_count++;
                    }else if(type == 3){
                        $("#kefu_qrcode").html('<li><section class="img"><img src="'+data.picurl+'" /><input type="hidden" name="kefu_qrcode" value="'+data.picurl+'"/></section></li>');
                        qrcode_count++;
                    }else if(type == 4){
                        $("#business_licence").html('<li><section class="img"><img src="'+data.picurl+'" /><input type="hidden" name="business_licence" value="'+data.picurl+'"/></section></li>');
                        business_licence_count = 1;
                    }else if(type == 5){
                        $("#prooflist").append('<li class="li"><section class="img"><img src="'+data.picurl+'" /><input type="hidden" name="proof[]" value="'+data.picurl+'"/></section><div class=" close pic-delete-btn pointer" onclick="proofremove(this);">&nbsp;X&nbsp;</div></li>');
                        proof_count++;
                    }else if(type == 6){
                        $("#photolist").append('<li class="li_'+li_i+'"><section class="img"><img src="'+data.picurl+'" /><input type="hidden" name="photo_'+li_i+'" value="'+data.picurl+'"/><input type="hidden" name="photothumb_'+li_i+'" value="'+data.thumburl+'"/></section><div class="paixu">排序<input class="tcui-input" type="text" id="photosort_'+li_i+'" name="photosort_'+li_i+'" value="999"/></div><div class=" close pic-delete-btn pointer" onclick="picremove('+li_i+');">&nbsp;X&nbsp;</div></li>');
                        li_i++;
                        photo_count++;
                    }
                }else if(data.status == 301){
                    <?php if($test == 1) { ?>
                    alert(data.content);
                    <?php } ?>
                    tusi('图片格式不正确');
                    return false;
                }else if(data.status == 302){
                    <?php if($test == 1) { ?>
                    alert(data.type);
                    <?php } ?>
                    tusi('文件写入失败');
                    return false;
                }else{
                    tusi('error');
                    return false;
                }
            },
            error:function(){
                loading(false);
                tusi('服务器开小差了，请重新上传！');
            }
        })
    }    
});
</script>