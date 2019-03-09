<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<script>
wx.ready(function () {
    $(document).on('click', '#picpic-btn', function(){
        var photo_num = max_photo_num - count;
        if(photo_num == 0){
            tusi("超过上传张数限制");
            return false;
        }else if(photo_num > 9){
            photo_num = 9;
        }

        wx.chooseImage({
            count: photo_num,
            sizeType: ['original', 'compressed'],
            sourceType: ['album', 'camera'],
            success: function (res) {
                var length = res.localIds.length;
                if(length > 0){
                    loading('上传中...');
                    uploadImg(res);
                }
            }
        });
        
    })
    
    function uploadImg(res){
        var i = 0, length = res.localIds.length;
        if(length > 0){
            function upload(){    
                wx.uploadImage({
                    localId: res.localIds[i], 
                    isShowProgressTips: 0, 
                    success: function (res) {
                        var serverId = res.serverId;
                        downloadServer(serverId);
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
    
    function downloadServer(serverId){
        $.ajax({
            type:'POST',
            url:'<?php echo $wxUploadUrl;?>',
            data:{serverId:serverId},
            dataType:'json',
            success:function(data){
                if(data.status == 200){
                    $("#photolist").append('<li class="li_'+li_i+'"><section class="img"><img src="'+data.picurl+'" /><input type="hidden" name="photo_'+li_i+'" value="'+data.picurl+'"/></section><div class=" close pic-delete-btn pointer" onclick="picremove('+li_i+');">&nbsp;X&nbsp;</div></li>');
                    li_i ++;
                    count++;
                }else if(data.status == 301){
                    <?php if($test == 1) { ?>
                    alert(data.content);
                    <?php } ?>
                    tusi('图片格式不正确');
                    return false;
                }else if(data.status == 302){
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