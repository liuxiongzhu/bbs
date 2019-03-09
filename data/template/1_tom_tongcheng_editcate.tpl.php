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
<title>修改分类 - <?php echo $__SitesInfo['name'];?></title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/mobiscroll/mobiscroll.css" />
<script src="source/plugin/tom_tongcheng/images/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/layer_mobile/layer.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?></head>
<body>
<header class="header header-index on in2 tc-template__bg">
   <section class="wrap">
       <a href="<?php echo $backUrl;?>"><section class="sec-ico go-back">返回</section></a>
        <h2>修改分类</h2>
        <section class="sec-ico btn slide-btn">
            <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=article">发布须知</a>
        </section>
   </section>
</header>
<form class="mainer" name="saveForm" id="saveForm" >
   <section class="wrap edit-form">
        <section class="edit-item">
            <section class="input-control">
                  <span>分类</span>
                  <section class="user-fav">
                       <section class="sec-input">
                            <select name="model_id" id="model_id" class="tcui-select" onchange="refreshmodel();">
                                <option value="0">选择分类</option>
                                <?php if(is_array($modelList)) foreach($modelList as $key => $val) { ?>                                <option value="<?php echo $val['id'];?>" <?php if($val['id']==$model_id ) { ?>selected<?php } ?>> <?php echo $val['name'];?></option>
                                <?php } ?>
                            </select>
                       </section>
                       <div class="frt">
                            <div class="right-arrow"></div>
                       </div>
                  </section>
             </section>
            <?php if($typeList ) { ?>
            <section class="input-control ">
                  <span>类别</span>
                  <section class="user-fav">
                       <section class="sec-input">
                            <select name="type_id" id="type_id" class="tcui-select" onchange="refreshtype();">
                                <option value="0">选择类别</option>
                                <?php if(is_array($typeList)) foreach($typeList as $key => $val) { ?>                                <option value="<?php echo $val['id'];?>" <?php if($val['id']==$type_id ) { ?>selected<?php } ?>> <?php echo $val['name'];?></option>
                                <?php } ?>
                            </select>
                       </section>
                       <div class="frt">
                            <div class="right-arrow"></div>
                       </div>
                  </section>
             </section>
            <?php } ?>
            <?php if($cateList ) { ?>
            <section class="input-control ">
                  <span><?php echo $typeInfo['cate_title'];?></span>
                  <section class="user-fav">
                       <section class="sec-input">
                            <select name="cate_id" id="cate_id" class="tcui-select">
                                <?php if(is_array($cateList)) foreach($cateList as $key => $val) { ?>                                <option value="<?php echo $val['id'];?>"> <?php echo $val['name'];?></option>
                                <?php } ?>
                            </select>
                       </section>
                       <div class="frt">
                            <div class="right-arrow"></div>
                       </div>
                  </section>
             </section>
            <?php } ?>
        </section>
   </section>
   <section class="btn-group-block">
        <?php if($type_id > 0 ) { ?>
        <button type="button" id="id_save_btn" class="id_save_btn tc-template__bg">修 改</button>
        <?php } else { ?>
        <button type="button" style="background-color: #c7c7c7;">修 改</button>
        <?php } ?>
        <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
        <input type="hidden" name="tongcheng_id" value="<?php echo $tongcheng_id;?>">
        <div class="clear10"></div>
        <div class="clear10"></div>
        <div class="clear10"></div>
   </section>
    <div class="tcui-cells__title">
         <section style="padding:10px;background: #eff9ff;line-height:1.5;letter-spacing: 1px;">
             <p class="tc-template__color" style="color:#f8a543"><b>修改说明：</b></p>
            <p class="tc-template__color" style="color:#f8a543">1、选择类别后才可以保存，修改类别后，需要重新编辑信息内容，否则会出现标签和属性对不上</p>
            <p class="tc-template__color" style="color:#f8a543">2、免费发布类别的信息不允许转移到收费类别下</p>
            <p class="tc-template__color" style="color:#f8a543">3、收费发布类别的信息可以转移到免费类别下（但转移后不能返回）</p>
            <p class="tc-template__color" style="color:#f8a543">4、收费发布类别之间可以互相转移，但收费低的不能转移到收费高的类别下（且转移后不能返回）</p>
         </section>
    </div>
</form>
<script>
    
function refreshmodel() {
location.href = 'plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=editcate&tongcheng_id=<?php echo $tongcheng_id;?>&fromlist=<?php echo $_GET['fromlist'];?>'+"&model_id="+$('#model_id').val();
}

function refreshtype() {
location.href = 'plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=editcate&tongcheng_id=<?php echo $tongcheng_id;?>&fromlist=<?php echo $_GET['fromlist'];?>'+"&model_id="+$('#model_id').val()+"&type_id="+$('#type_id').val();
}

var submintSaveStatus = 0;
$(".id_save_btn").click( function (){
    if(submintSaveStatus == 1){
        return false;
    }
    layer.open({
        content: '你确定要修改类别吗？修改类别后需要你重新编辑信息，否则会出现标签和属性对不上'
        ,btn: ['修改', '取消']
        ,yes: function(index){
            submintSaveStatus = 1;
            $.ajax({
                type: "POST",
                url: "<?php echo $saveUrl;?>",
                dataType : "json",
                data: $('#saveForm').serialize(),
                success: function(data){
                    submintSaveStatus = 0;
                    if(data.status == 200) {
                        tusi("修改成功");
                        setTimeout(function(){window.location.href="<?php echo $backUrl;?>";},1888);
                    }else if(data.status == 301){
                        tusi_h("收费低的不能转移到收费高的类别下");
                        //setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                    }else if(data.status == 302){
                        tusi_h("免费发布类别的信息不允许转移到收费类别下");
                        //setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                    }else{
                        tusi("修改失败");
                        //setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                    }
                }
            });
            layer.close(index);
        }
      });
});
</script>
<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
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