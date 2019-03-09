<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<script src="source/plugin/tom_tongcheng/images/localResizeIMG4/dist/lrz.bundle.js" type="text/javascript"></script>
<script>
$(document).on('change', '#filedata1', function() {
    loading('上传中...');
    lrz(this.files[0], {width:640,quality:0.8,fieldName:"filedata1"})
        .then(function (rst) {
            return rst;
        })
        .then(function (rst) {
            rst.formData.append('fileLen', rst.fileLen);
            $.ajax({
                url: '<?php echo $uploadUrl1;?>',
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
                        $("#picurl").html('<li><section class="img"><img src="'+dataarr[1]+'" /><input type="hidden" name="picurl" value="'+dataarr[2]+'"/></section></li>');
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
<?php if($__IsWeixin == 0 || $tongchengConfig['open_many_pic_upload'] == 0) { ?>
$(document).on('change', '#filedata2', function() {
    loading('上传中...');
    lrz(this.files[0], {width:640,quality:0.8,fieldName:"filedata2"})
        .then(function (rst) {
            return rst;
        })
        .then(function (rst) {
            rst.formData.append('fileLen', rst.fileLen);
            $.ajax({
                url: '<?php echo $uploadUrl2;?>',
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
                        $("#photolist").append('<li class="li_'+li_i+'"><section class="img"><img src="'+dataarr[1]+'" /><input type="hidden" name="photo_'+li_i+'" value="'+dataarr[2]+'"/><input type="hidden" name="photothumb_'+li_i+'" value="'+dataarr[3]+'"/></section><div class="paixu">排序<input class="tcui-input" type="text" id="photosort_'+li_i+'" name="photosort_'+li_i+'" value="999"/></div><div class=" close pic-delete-btn pointer" onclick="picremove('+li_i+');">&nbsp;X&nbsp;</div></li>');
                        li_i++;
                        photo_count++;
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
<?php } ?>

function picremove(i){
    $(".li_"+i).remove();
    photo_count--;
}

$(document).on('change', '#filedata3', function() {
    loading('上传中...');
    lrz(this.files[0], {width:640,quality:0.8,fieldName:"filedata3"})
        .then(function (rst) {
            return rst;
        })
        .then(function (rst) {
            rst.formData.append('fileLen', rst.fileLen);
            $.ajax({
                url: '<?php echo $uploadUrl3;?>',
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
                        $("#kefu_qrcode").html('<li><section class="img"><img src="'+dataarr[1]+'" /><input type="hidden" name="kefu_qrcode" value="'+dataarr[2]+'"/></section></li>');
                        qrcode_count++;
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

$(document).on('change', '#filedata4', function() {
    loading('上传中...');
    lrz(this.files[0], {width:640,quality:0.8,fieldName:"filedata4"})
        .then(function (rst) {
            return rst;
        })
        .then(function (rst) {
            rst.formData.append('fileLen', rst.fileLen);
            $.ajax({
                url: '<?php echo $uploadUrl4;?>',
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
                        $("#business_licence").html('<li><section class="img"><img src="'+dataarr[1]+'" /><input type="hidden" name="business_licence" value="'+dataarr[2]+'"/></section></li>');
                        business_licence_count = 1;
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

<?php if($__IsWeixin == 0 || $tongchengConfig['open_many_pic_upload'] == 0) { ?>
$(document).on('change', '#shop_focuspic', function() {
    loading('上传中...');
    lrz(this.files[0], {width:640,quality:0.8,fieldName:"shop_focuspic"})
        .then(function (rst) {
            return rst;
        })
        .then(function (rst) {
            rst.formData.append('fileLen', rst.fileLen);
            $.ajax({
                url: '<?php echo $uploadUrl;?>',
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
                        $("#photolist").append('<li class="li_'+li_i+'"><section class="img"><img src="'+dataarr[1]+'" /><input type="hidden" name="photo_'+li_i+'" value="'+dataarr[2]+'"/><input type="hidden" name="photothumb_'+li_i+'" value="'+dataarr[3]+'"/></section><div class="paixu">排序<input class="tcui-input" type="text" id="photosort_'+li_i+'" name="photosort_'+li_i+'" value="999"/></div><div class=" close pic-delete-btn pointer" onclick="picremove('+li_i+');">&nbsp;X&nbsp;</div></li>');
                        li_i++;
                        photo_count++;
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

$(document).on('change', '#filedata5', function() {
    loading('上传中...');
    lrz(this.files[0], {width:640,quality:0.8,fieldName:"filedata5"})
        .then(function (rst) {
            return rst;
        })
        .then(function (rst) {
            rst.formData.append('fileLen', rst.fileLen);
            $.ajax({
                url: '<?php echo $uploadUrl5;?>',
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
                        $("#prooflist").append('<li class="li"><section class="img"><img src="'+dataarr[1]+'" /><input type="hidden" name="proof[]" value="'+dataarr[2]+'"/></section><div class=" close pic-delete-btn pointer" onclick="proofremove(this);">&nbsp;X&nbsp;</div></li>');
                        proof_count++;
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
<?php } ?>

function proofremove(obj){
    $(obj).parent('.li').remove();
    proof_count--;
}
</script>