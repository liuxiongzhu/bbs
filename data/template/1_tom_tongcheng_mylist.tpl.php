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
<title>信息管理 - <?php echo $__SitesInfo['name'];?></title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/iconfont/iconfont.css?v=<?php echo $cssJsVersion;?>" />
<script src="source/plugin/tom_tongcheng/images/jquery.min-2.1.3.js" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/layer_mobile/layer.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?></head>
<body>
<?php if($__HideHeader == 0 ) { ?>
<header class="header on tc-template__bg">
   <section class="wrap">
        <section class="sec-ico go-back" onclick="history.back();">返回</section>
        <h2>信息管理</h2>
   </section>
</header>
<?php } ?>
<section class="mainer">
   <section class="wrap">
        <div class="tcui-navbar">
             <a class="tcui-navbar__item <?php if($type==0  ) { ?>tcui-bar__item_on tc-template__color tc-template__border<?php } ?>" href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=mylist&amp;type=0"> 全部 </a>
             <a class="tcui-navbar__item <?php if($type==1  ) { ?>tcui-bar__item_on tc-template__color tc-template__border<?php } ?>" href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=mylist&amp;type=1"> 展示中 </a>
             <a class="tcui-navbar__item <?php if($type==2  ) { ?>tcui-bar__item_on tc-template__color tc-template__border<?php } ?>" href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=mylist&amp;type=2"> 未支付 </a>
             <a class="tcui-navbar__item <?php if($type==4  ) { ?>tcui-bar__item_on tc-template__color tc-template__border<?php } ?>" href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=mylist&amp;type=4"> 未审核 </a>
        </div>
        <section class="manage-case-list" style="padding-top: 3em;">
             <section class="tc-sec mt0">
                  <ul>
                      <?php if(is_array($tongchengList)) foreach($tongchengList as $key => $val) { ?>                       <div class="tcline-item">
                            <div class="avatar-label">
                                 <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=home&amp;uid=<?php echo $val['userInfo']['id'];?>"><img src="<?php echo $val['userInfo']['picurl'];?>" class="avatar" /></a>
                            </div>
                            <div class="tcline-detail">
                                 <span class="tc-template__bg"><a class="tc-template__bg" href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=list&amp;type_id=<?php echo $val['typeInfo']['id'];?>"><?php echo $val['typeInfo']['name'];?></a></span>&nbsp; 
                                 <?php if($tongchengConfig['open_list_xm'] == 1) { ?>
                                 <a class="username" href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=home&amp;uid=<?php echo $val['userInfo']['id'];?>"><?php echo $val['xm'];?></a>
                                 <?php } else { ?>
                                 <a class="username" href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=home&amp;uid=<?php echo $val['userInfo']['id'];?>"><?php echo $val['userInfo']['nickname'];?></a>
                                 <?php } ?>
                                 <?php if($val['tchongbaoInfo']['status'] == 1) { ?>
                                    <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=info&amp;tongcheng_id=<?php echo $val['id'];?>" class="ext-act tchongbao">
                                       <img src="source/plugin/tom_tchongbao/images/hongbao-ico.png" style="width: 11px;">&nbsp;抢红包
                                    </a>
                                 <?php } else { ?>
                                    <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=info&amp;tongcheng_id=<?php echo $val['id'];?>" class="ext-act">
                                       <img src="source/plugin/tom_tongcheng/images/icon-show.png" style="width: 12px;"> 详情 
                                    </a>
                                 <?php } ?>
                                 <article>
                                      <?php if($val['tagList']  ) { ?>
                                      <div class="detail-tags">
                                           <?php if(is_array($val['tagList'])) foreach($val['tagList'] as $k1 => $v1) { ?>                                           <a class="span<?php echo $k1;?>"><?php echo $v1['tag_name'];?></a>
                                           <?php } ?>
                                           <div class="clear"></div>
                                      </div>
                                      <?php } ?>
                                      <?php if($val['typeInfo']['jifei_type'] == 2 && $val['over_days'] > 0  ) { ?>
                                      <p>
                                         <font class="tc-template__color" color="#F60">发布天数&nbsp;:&nbsp;</font></b><font color="#fd0d0d"><?php echo $val['over_days'];?>天(<?php echo $val['over_time'];?>过期)</font>
                                     </p>
                                      <?php } ?>
                                      <?php if($val['attrList']  ) { ?>
                                     <?php if(is_array($val['attrList'])) foreach($val['attrList'] as $k2 => $v2) { ?>                                     <p>
                                         <font class="tc-template__color" color="#F60"><?php echo $v2['attr_name'];?>&nbsp;:&nbsp;</font></b><?php echo $v2['value'];?><?php if($v2['unit']) { ?>/<?php echo $v2['unit'];?><?php } ?>
                                     </p>
                                     <?php } ?> 
                                     <?php } ?>
                                     <p><?php echo $val['content'];?></p>
                                 </article>
                                 <div class="detail-toggle">全文</div>
                                 <?php if($val['photoList']  ) { ?>
                                <div class="detail-pics clearfix">
                                    <?php if(is_array($val['photoList'])) foreach($val['photoList'] as $k3 => $v3) { ?>                                    <a href="javascript:void(0);" onclick="showPic('<?php echo $v3;?>');"><img src="<?php echo $v3;?>"></a>
                                    <?php } ?>
                                </div>
                                <?php } ?>
                                 <div class="detail-time">
                                      <a ><span><?php echo dgmdate($val[refresh_time], 'u');?></span><span></span></a>
                                 </div>
                                <?php if($val['pay_status'] == 1 ) { ?>
                                <section class="mark-img nopay"></section>
                                <?php } else { ?>
                                    <?php if($val['shenhe_status'] == 1 ) { ?>
                                        <?php if($val['finish'] == 1 ) { ?>
                                        <section class="mark-img succ"></section>
                                        <?php } else { ?>
                                            <?php if($val['status'] == 2 ) { ?>
                                            <section class="mark-img xiajia"></section>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } elseif($val['shenhe_status'] == 2) { ?>
                                        <section class="mark-img shenhe2"></section>
                                    <?php } elseif($val['shenhe_status'] == 3) { ?>
                                        <section class="mark-img shenhe3"></section>
                                    <?php } ?>
                                <?php } ?>
                                 <div id="group-124052" class="detail-cmt-wrap">
                                      <i class="detail-cmtr"></i>
                                      <div class="detail-cmt">
                                           <div class="like-list">
                                                <?php echo $val['clicks'];?>人浏览、
                                                <span ><?php echo $val['zhuanfa'];?></span> 次扩散、
                                                <span id="like-124052"><?php echo $val['collect'];?></span> 人点赞
                                           </div>
                                      </div>
                                 </div>
                            </div>
                       </div>
                      <?php if($val['pay_status'] == 1 ) { ?>
                          <?php if($__IsMiniprogram == 1 && $__Ios == 1 && $tongchengConfig['closed_ios_pay'] == 1 ) { } else { ?>
                           <section class="btn-group">
                               <a href="javascript:void(0);" onclick="pay(<?php echo $val['id'];?>);" style="min-width: 10em;">立即支付</a>
                           </section>
                          <?php } ?>
                      <?php } else { ?>
                          <?php if($val['shenhe_status'] == 1 ) { ?>
                              <?php if($val['finish'] == 1 ) { ?>
                                   <section class="btn-group">
                                       <?php if($val['status'] == 1 ) { ?>
                                       <a href="javascript:void(0);" onclick="updateStatus2(<?php echo $val['id'];?>);" style="min-width: 10em;">下架</a>
                                       <?php } ?>
                                       <?php if($val['status'] == 2 ) { ?>
                                       <a href="javascript:void(0);" onclick="updateStatus1(<?php echo $val['id'];?>);" style="min-width: 10em;">上架</a>
                                       <?php } ?>
                                   </section>
                              <?php } else { ?>
                                  <?php if($val['status'] == 1 ) { ?>
                                   <section class="btn-group">
                                        <?php if($__IsMiniprogram == 1 && $__Ios == 1 && $tongchengConfig['closed_ios_pay'] == 1 ) { } else { ?>
                                        <?php if($val['over_status'] == 0 ) { ?>
                                            <?php if($val['payRefreshStatus'] == 1 ) { ?>
                                            <a href="javascript:void(0);" onclick="refresh2(<?php echo $val['id'];?>,<?php echo $val['typeInfo']['refresh_price'];?>);">刷新</a>
                                            <?php } elseif($val['payRefreshStatus'] == 2 ) { ?>
                                            <a href="javascript:void(0);" onclick="refresh3(<?php echo $val['id'];?>,<?php echo $val['refreshUseScore'];?>);">刷新</a>
                                            <?php } elseif($val['payRefreshStatus'] == 3 ) { ?>
                                            <a href="javascript:void(0);" onclick="refresh4(<?php echo $val['id'];?>);">刷新</a>
                                            <?php } else { ?>
                                            <a href="javascript:void(0);" onclick="refresh(<?php echo $val['id'];?>,<?php echo $val['shengyuRefreshTimes'];?>);">刷新</a>
                                            <?php } ?>
                                            <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=buy&amp;tongcheng_id=<?php echo $val['id'];?>">置顶</a>
                                        <?php } ?>
                                        <?php } ?>
                                        <a href="javascript:void(0);" onclick="updateFinish(<?php echo $val['id'];?>)">完成</a>
                                        <a href="javascript:void(0);" onclick="updateStatus2(<?php echo $val['id'];?>);">下架</a>
                                        <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=edit&amp;tongcheng_id=<?php echo $val['id'];?>&amp;fromlist=mylist">修改</a>
                                        <?php if($__IsMiniprogram == 1 && $__Ios == 1 && $tongchengConfig['closed_ios_pay'] == 1 ) { } else { ?>
                                        <?php if($__ShowTchongbao == 1) { ?>
                                        <a href="plugin.php?id=tom_tchongbao&amp;site=<?php echo $site_id;?>&amp;mod=add&amp;tongcheng_id=<?php echo $val['id'];?>">塞红包</a>
                                        <?php } ?>
                                        <?php } ?>
                                   </section>
                                  <?php } ?>
                                  <?php if($val['status'] == 2 ) { ?>
                                   <section class="btn-group">
                                       <a href="javascript:void(0);" onclick="updateStatus1(<?php echo $val['id'];?>);" style="min-width: 10em;">上架</a>
                                   </section>
                                  <?php } ?>
                              <?php } ?>
                          <?php } ?>
                          <?php if($val['shenhe_status'] == 3 ) { ?>
                          <section class="btn-group">
                          <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=edit&amp;tongcheng_id=<?php echo $val['id'];?>&amp;fromlist=mylist">修改</a>
                          </section>
                          <?php } ?>
                       <?php } ?>
                       <div class="clear10 bg-blue"></div>
                       <?php } ?>
                  </ul>
             </section>
        </section>
       <div class="pages clearfix">
            <ul class="clearfix">
              <li style="width: 40%;"><?php if($page > 1) { ?><a class="tc-template__color tc-template__border" href="<?php echo $prePageUrl;?>">上一页</a><?php } else { ?><span>上一页</span><?php } ?></li>
              <li style="width: 20%;"><span><?php echo $page;?>/<?php echo $allPageNum;?></span></li>
              <li style="width: 40%;"><?php if($showNextPage == 1) { ?><a class="tc-template__color tc-template__border" href="<?php echo $nextPageUrl;?>">下一页</a><?php } else { ?><span>下一页</span><?php } ?></li>
          </ul>
        </div>
   </section>
</section>
<section class="pic_info id-pic-tip box_hide clearfix" style="z-index: 999;height: 2000px;position: fixed;">
<div class="pic_info_in id-pic-tip-in" style="top: 0px; height: 550px; background-image: url();"></div>
</section><?php include template('tom_tongcheng:footer'); ?><script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" type="text/javascript"></script>
<script type="text/javascript">
var submintPayStatus = 0;
function pay(tongcheng_id){
    if(submintPayStatus == 1){
        return false;
    }
    
    submintPayStatus = 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $payUrl;?>",
        dataType : "json",
        data: "tongcheng_id="+tongcheng_id,
        success: function(data){
            if(data.status == 200) {
                tusi("下单成功，立即支付");
                setTimeout(function(){window.location.href=data.payurl+"&prand=<?php echo $prand;?>";},500);
            }else if(data.status == 303){
                tusi("生成微信订单失败");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 304){
                tusi("插入订单数据失败");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 307){
                tusi("没有安装TOM支付中心插件");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 400){
                tusi("未设置发布费用");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else{
                tusi("支付错误");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }
        }
    });
}
function payRefresh(tongcheng_id){
    if(submintPayStatus == 1){
        return false;
    }
    
    submintPayStatus = 1;
    $.ajax({
        type: "GET",
        url: "<?php echo $payRefreshUrl;?>",
        dataType : "json",
        data: "tongcheng_id="+tongcheng_id,
        success: function(data){
            if(data.status == 200) {
                tusi("下单成功，立即支付");
                setTimeout(function(){window.location.href=data.payurl+"&prand=<?php echo $prand;?>";},500);
            }else if(data.status == 303){
                tusi("生成微信订单失败");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 304){
                tusi("插入订单数据失败");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 307){
                tusi("没有安装TOM支付中心插件");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 400){
                tusi("未设置刷新费用");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else{
                tusi("支付错误");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }
        }
    });
}
    
function updateStatus1(tongcheng_id){
    layer.open({
        content: '您确定上架信息吗？'
        ,btn: ['上架', '取消']
        ,yes: function(index){
          $.ajax({
                type: "GET",
                url: "<?php echo $ajaxUpdateStatusUrl;?>",
                data: "status=1&tongcheng_id="+tongcheng_id,
                success: function(msg){
                    var msg = $.trim(msg);
                    if(msg == '200'){
                        tusi("上架成功");
                        setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                    }else{
                        tusi("操作失败");
                    }
                }
            });
            layer.close(index);
        }
      });
}
function updateStatus2(tongcheng_id){
    layer.open({
        content: '您确定下架信息吗？'
        ,btn: ['下架', '取消']
        ,yes: function(index){
          $.ajax({
                type: "GET",
                url: "<?php echo $ajaxUpdateStatusUrl;?>",
                data: "status=2&tongcheng_id="+tongcheng_id,
                success: function(msg){
                    var msg = $.trim(msg);
                    if(msg == '200'){
                        tusi("下架成功");
                        setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                    }else{
                        tusi("操作失败");
                    }
                }
            });
          layer.close(index);
        }
      });
}
function updateFinish(tongcheng_id){
    layer.open({
        content: '您确定已经完成了吗？完成后信息将会失效，不在显示！！【操作后不能恢复】'
        ,btn: ['完成', '取消']
        ,yes: function(index){
          $.ajax({
                type: "GET",
                url: "<?php echo $ajaxFinishStatusUrl;?>",
                data: "status=2&tongcheng_id="+tongcheng_id,
                success: function(msg){
                    var msg = $.trim(msg);
                    if(msg == '200'){
                        tusi("操作成功");
                        setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                    }else{
                        tusi("操作失败");
                    }
                }
            });
          layer.close(index);
        }
      });
}

function refresh(tongcheng_id,num){
    layer.open({
        content: '今天还剩<font color="#f70606">'+num+'</font>次免费刷新机会，确认刷新？'
        ,btn: ['刷新', '取消']
        ,yes: function(index){
          $.ajax({
                type: "GET",
                url: "<?php echo $ajaxrefreshUrl;?>",
                data: "tongcheng_id="+tongcheng_id,
                success: function(msg){
                    var msg = $.trim(msg);
                    if(msg == '200'){
                        tusi("刷新成功");
                        setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                    }else{
                        tusi("操作失败");
                    }
                }
            });
          layer.close(index);
        }
      });
}

function refresh2(tongcheng_id,price){
    layer.open({
        content: '本次刷新需要支付<font color="#f70606">'+price+'</font>元，确认刷新？'
        ,btn: ['刷新', '取消']
        ,yes: function(index){
          payRefresh(tongcheng_id);
          layer.close(index);
        }
      });
}

function refresh3(tongcheng_id,score){
    layer.open({
        content: '我的金币：<font color="#f70606"><?php echo $__UserInfo['score'];?></font>，本次刷新消耗金币：<font color="#f70606">'+score+'</font>'
        ,btn: ['刷新', '取消']
        ,yes: function(index){
          $.ajax({
                type: "GET",
                url: "<?php echo $ajaxrefresh3Url;?>",
                data: "tongcheng_id="+tongcheng_id,
                success: function(msg){
                    var msg = $.trim(msg);
                    if(msg == '200'){
                        tusi("刷新成功");
                        setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                    }else{
                        tusi("操作失败");
                    }
                }
            });
          layer.close(index);
        }
      });
}

function refresh4(tongcheng_id){
    layer.open({
        content: '你正在使用“<?php echo $tcyikatongConfig['card_name'];?>”免费刷新服务'
        ,btn: ['刷新', '取消']
        ,yes: function(index){
          $.ajax({
                type: "GET",
                url: "<?php echo $ajaxrefresh4Url;?>",
                data: "tongcheng_id="+tongcheng_id,
                success: function(msg){
                    var msg = $.trim(msg);
                    if(msg == '200'){
                        tusi("刷新成功");
                        setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
                    }else{
                        tusi("操作失败");
                    }
                }
            });
          layer.close(index);
        }
      });
}
    
$(document).on("click", ".detail-toggle,article",function() {
    var t = $(this).parent(),
    a = t.find("article"),
    i = t.find(".act-bar"),
    id = t.data("id"),
    e = i.find("img");
    return a.attr("oldheight") ? (a.css("max-height", a.attr("oldheight") + "px"), a.removeAttr("oldheight"), t.find(".detail-toggle").show(), t.find(".act-bar").hide(), void 0) : (a.attr("oldheight", parseInt(a.css("max-height"), 10)), a.css("max-height", "none"), t.find(".detail-toggle").hide(), i.show(), e.attr("url") && e.attr("src", e.attr("url")).removeAttr("url"), !1)
});
function showPic(picurl){
    $(".id-pic-tip").removeClass('box_hide');
    $('.id-pic-tip-in').css('background-image', 'url(' + picurl + ')');
}

$(".pic_info").on("click", function(){
    $(".id-pic-tip").addClass('box_hide');
    $('.id-pic-tip-in').css('background-image', '');
});
</script>
</body>
</html>