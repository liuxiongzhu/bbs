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
<title>店员管理</title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tcshop/images/shop_style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tcshop/images/order.css?v=<?php echo $cssJsVersion;?>">
<script src="source/plugin/tom_tcshop/images/jquery.min-2.1.3.js" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/layer_mobile/layer.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?></head>
<body>
<?php if($__HideHeader == 0 ) { ?>
<header class="header on tc-template__bg">
   <section class="wrap">
       <section class="sec-ico go-back" onclick="location.href='plugin.php?id=tom_tcshop&site=<?php echo $site_id;?>&mod=mylist';">返回</section>
        <h2>店员管理</h2>
   </section>
</header>
<?php } ?>
<section class="mainer">
    <section class="wrap">
        <section class="cmy_container" style="padding-top: 3em;padding: 15px 0px;">
            <section class="hxren_box clearfix">
                <div class="hxren_box_main clearfix">
                    <div class="form_box">
                        <form id="saveForm" onsubmit="return false;">
                        <table width="100%">
                            <tr>
                                <td width=""><input type="text" class="input_class" name="user_id" id="user_id" placeholder="输入会员UID" value="" /></td>
                                <td width="120">
                                    <a class="a_class id_clerk_btn tc-template__bg" href="javascript:void(0);">添加</a>
                                    <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
                                </td>
                            </tr>
                        </table>
                        </form>
                    </div>
                </div>
            </section>
            <div class="tcui-panel__bd">
                <div class="tcui-media-box tcui-media-box_small-appmsg">
                    <div class="tcui-cells">
                        <?php if(is_array($clerkList)) foreach($clerkList as $key => $val) { ?>                        <a class="tcui-cell tcui-cell_access" href="javascript:void(0);">
                            <div class="tcui-cell__hd"><img src="<?php echo $val['userInfo']['picurl'];?>" alt="" style="width:20px;margin-right:5px;display:block"></div>
                            <div class="tcui-cell__bd tcui-cell_primary">
                                <p><?php echo $val['userInfo']['nickname'];?></p>
                            </div>
                            <span class="tcui-cell__ft" onclick="delClerk('<?php echo $val['id'];?>');">
                                删除
                            </span>
                        </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="tcui-cells__title">
                 <section style="padding:10px;background: #eff9ff;line-height:1.5;letter-spacing: 1px;">
                    <p class="tc-template__color" style="color:#f8a543">添加的店员有权限核销本店铺的商品。（我的 >> 修改资料 >> 查看店员UID）</p>
                 </section>
            </div>
        </section>
    </section>
</section>
<script>
$(".id_clerk_btn").click( function (){ 
    
    var user_id      = $("#user_id").val();
    if(user_id == ""){
        tusi("必须填写会员UID");
        return false;
    }
    
    $.ajax({
        type: "GET",
        url: "<?php echo $saveUrl;?>",
        dataType : "json",
        data: $('#saveForm').serialize(),
        success: function(data){
            if(data.status == 200) {
                tusi("添加成功");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 404){
                tusi("数据更新失败");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else{
                tusi("添加错误");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }
        }
    });
});

function delClerk(clerk_id){
    layer.open({
        content: '你确定删除该店员吗？'
        ,btn: ['确定', '取消']
        ,yes: function(index){
          $.ajax({
                type: "GET",
                url: "<?php echo $delUrl;?>",
                data: "clerk_id="+clerk_id,
                success: function(msg){
                    if(msg == '200'){
                        tusi("删除成功");
                        setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                    }else{
                        tusi("操作错误");
                    }
                }
            });
            layer.close(index);
        }
    });
}
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
