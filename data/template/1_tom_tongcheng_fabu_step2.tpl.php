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
<title><?php echo $modelInfo['name'];?> - <?php echo $__SitesInfo['name'];?></title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/mobiscroll/mobiscroll.css" />
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/jquery-popups.css?v=<?php echo $cssJsVersion;?>" />
<script src="source/plugin/tom_tongcheng/images/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/jquery-popups.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script>
<script>
var tomBrowser = {
    versions: function () {
        var u = navigator.userAgent, app = navigator.appVersion;
        return { /*�ƶ��ն�������汾��Ϣ*/
            trident: u.indexOf('Trident') > -1, /*IE�ں�*/
            presto: u.indexOf('Presto') > -1, /*opera�ں�*/
            webKit: u.indexOf('AppleWebKit') > -1, /*ƻ�����ȸ��ں�*/
            gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, /*����ں�*/
            mobile: !!u.match(/AppleWebKit.*Mobile.*/) || !!u.match(/AppleWebKit/), /*�Ƿ�Ϊ�ƶ��ն�*/
            ios: !!u.match(/i[^;]+;( U;)? CPU.+Mac OS X/), /*ios�ն�*/
            android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, /*android�ն˻���uc�����*/
            iPhone: u.indexOf('iPhone') > -1 || (u.indexOf('Mac') > -1 && u.indexOf('Macintosh') < 0), /*�Ƿ�ΪiPhone����QQHD�����*/
            iPad: u.indexOf('iPad') > -1, /*�Ƿ�iPad*/
            webApp: u.indexOf('Safari') == -1, /*�Ƿ�webӦ�ó���û��ͷ����ײ�*/
            WindowsWechat: u.indexOf('WindowsWechat') > 0 /*�Ƿ�webӦ�ó���û��ͷ����ײ�*/
        };
    }(),
    language: (navigator.browserLanguage || navigator.language).toLowerCase()
}
</script><?php include template('tom_tongcheng:template_css'); ?><style>
.tcui-actionsheet__cell:before{border:0}
.tcui-actionsheet__cell{border-bottom:1px solid #EFEFF4;padding:20px 0}
.dialog-btns a{ color:<?php echo $tongchengConfig['template_color'];?>; border-color:<?php echo $tongchengConfig['template_color'];?>;}
.dialog-btns a:first-child{ background-color:<?php echo $tongchengConfig['template_color'];?>;}
.dialog-btns a.hb-link{ background-color:#F23039;border-color:#F23039;}
.fabu_over_days_box ul li .buyitem .days{color: <?php echo $tongchengConfig['template_color'];?>;}
.fabu_over_days_box ul li .on{background-color: <?php echo $tongchengConfig['template_color'];?>;}
.fabu_over_days_box ul li .on .days{color: #fff;}
.fabu_over_days_box ul li .on .msg{color: #fff;}
</style>
</head>
<body>
<div id="over-days-box" class='pop-ups__container'>
  <div class="pop-ups__overlay"></div>
  <div class="pop-ups__modal">
      <div class="pop-ups__box">
          <div class="fabu_over_days_title">发布天数</div>
            <div class="fabu_over_days_box">
                <ul>
                    <?php if(is_array($over_days_item)) foreach($over_days_item as $key => $val) { ?>                    <li>
                        <?php if($isVipFabu == 2 || $__UserInfo['editor']==1 ) { ?>
                        <div id="over-days-item-<?php echo $val['days'];?>" class="id-over-days buyitem tc-template__border" onclick="chooseOverDaysItem(<?php echo $val['days'];?>,'0','0');">
                        <?php } else { ?>
                        <div id="over-days-item-<?php echo $val['days'];?>" class="id-over-days buyitem tc-template__border" onclick="chooseOverDaysItem(<?php echo $val['days'];?>,'<?php echo $val['price'];?>','<?php echo $val['vipprice'];?>');">
                        <?php } ?>
                            <?php if($val['msg'] == 'NULL' ) { ?>
                            <?php if($isVipFabu == 1) { ?>
                            <div class="days "><?php echo $val['vipprice'];?>元</div>
                            <?php } elseif($isVipFabu == 2  || $__UserInfo['editor']==1) { ?>
                            <div class="days ">0元</div>
                            <?php } else { ?>
                            <div class="days "><?php echo $val['price'];?>元</div>
                            <?php } ?>
                            <div class="msg">有效<?php echo $val['days'];?>天</div>
                            <?php } else { ?>
                            <?php if($isVipFabu == 1) { ?>
                            <div class="days ">有效<?php echo $val['days'];?>天/<?php echo $val['vipprice'];?>元</div>
                            <?php } elseif($isVipFabu == 2  || $__UserInfo['editor']==1) { ?>
                            <div class="days ">有效<?php echo $val['days'];?>天/0元</div>
                            <?php } else { ?>
                            <div class="days ">有效<?php echo $val['days'];?>天/<?php echo $val['price'];?>元</div>
                            <?php } ?>
                            <div class="msg"><?php echo $val['msg'];?></div>
                            <?php } ?>
                        </div>
                    </li>
                    <?php } ?> 
                </ul>
                <div class="clear5"></div>
            </div>
          <div class="pop-ups__block"></div>
      </div>
      <div class="pop-ups__close">
          <a href="javascript:void(0);" class="tcui-btn tcui-btn_default close-popups">关闭</a>
      </div>
  </div>
</div>
<header class="header header-index on in2 tc-template__bg">
   <section class="wrap">
       <?php if($__HideHeader == 0 ) { ?>
       <section class="sec-ico go-back" onclick="history.back();">返回</section>
       <?php } ?>
        <h2>发布“<?php echo $typeInfo['name'];?>”信息</h2>
        <section class="sec-ico btn slide-btn">
            <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=article">发布须知</a>
        </section>
   </section>
</header>
<form class="mainer" name="payForm" id="payForm" >
   <section class="wrap edit-form">
        <?php if($typeInfo['warning_msg']) { ?>
        <div class="tcui-cells__title">
             <section style="padding:10px;background: #eff9ff;line-height:1.5;letter-spacing: 1px;">
                <p class="tc-template__color" style="color:#f8a543"><?php echo $typeInfo['warning_msg'];?></p>
             </section>
        </div>
       <?php } ?>
        <section class="edit-item">
            <?php if($tcadminConfig['open_fabu_sites'] == 1) { ?>
            <?php if($sitesList) { ?>
             <section class="input-control ">
                  <span>发布站点</span>
                  <section class="user-fav">
                       <section class="sec-input">
                            <select name="site_id" id="site_id" class="tcui-select" onchange="refreshsites();">
                                <option value="1" <?php if($site_id == 1) { ?>selected<?php } ?>> <?php echo $tongchengConfig['plugin_name'];?></option>
                                <?php if(is_array($sitesList)) foreach($sitesList as $key => $val) { ?>                                <option value="<?php echo $val['id'];?>" <?php if($site_id == $val['id']) { ?>selected<?php } ?>> <?php echo $val['lbs_name'];?></option>
                                <?php } ?>
                            </select>
                       </section>
                       <div class="frt">
                            <div class="right-arrow"></div>
                       </div>
                  </section>
             </section>
            <?php } ?>
            <?php } ?>
            <?php if($typeInfo['jifei_type'] == 2 ) { ?>
            <section class="input-control ">
                 <span>发布天数</span>
                 <section class="user-fav">
                      <section class="sec-input">
                          <div id="choseOverDays" class="open-popups" style="cursor: pointer;" data-target="#over-days-box"><font color="#8e8e8e">选择有效发布天数</font></div>
                           <input type="hidden" name="over_days" id="over_days" value="0">
                      </section>
                      <div class="frt"></div>
                 </section>
            </section>
            <?php } ?>
            <?php if($__ShowTcshop == 1) { ?>
            <?php if($tcshopList) { ?>
             <section class="input-control ">
                  <span>关联店铺</span>
                  <section class="user-fav">
                       <section class="sec-input">
                            <select name="tcshop_id" id="tcshop_id" class="tcui-select">
                                <option value="0"> 不关联店铺</option>
                                <?php if(is_array($tcshopList)) foreach($tcshopList as $key => $val) { ?>                                <option value="<?php echo $val['id'];?>"> <?php echo $val['name'];?></option>
                                <?php } ?>
                            </select>
                       </section>
                       <div class="frt">
                            <div class="right-arrow"></div>
                       </div>
                  </section>
             </section>
            <?php } ?>
            <?php } ?>
            <?php if($tongchengConfig['open_fabu_title'] == 1) { ?>
            <section class="input-control ">
                <span>标题</span>
                <section class="user-fav">
                    <section class="sec-input">
                        <input type="text" name="title" id="title" placeholder="请输入标题" value="" />
                    </section>
                    <div class="frt"></div>
                </section>
            </section>
            <?php } ?>
            <?php if($cateList) { ?>
             <section class="input-control ">
                  <span><?php echo $typeInfo['cate_title'];?></span>
                  <section class="user-fav">
                       <section class="sec-input">
                            <select name="cate_id" id="cate_id" class="tcui-select">
                                <option value="0">请选择</option>
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
            <?php if($attrList) { ?>
            <?php if(is_array($attrList)) foreach($attrList as $key => $val) { ?>                <section class="input-control ">
                      <span><?php echo $val['name'];?></span>
                      <input type="hidden" name="attrname_<?php echo $val['id'];?>" value="<?php echo $val['name'];?>">
                      <input type="hidden" name="attrpaixu_<?php echo $val['id'];?>" value="<?php echo $val['paixu'];?>">
                      <input type="hidden" name="attrunit_<?php echo $val['id'];?>" value="<?php echo $val['unit'];?>">
                      <section class="user-fav">
                           <section class="sec-input">
                               <?php if($val['type'] == 1) { ?>
                               <input type="text" name="attr_<?php echo $val['id'];?>" id="attr_<?php echo $val['id'];?>" placeholder="<?php echo $val['name'];?>" value=""  />
                               <?php } ?>
                               <?php if($val['type'] == 2) { ?>
                               <select name="attr_<?php echo $val['id'];?>" id="attr_<?php echo $val['id'];?>" class="tcui-select" >
                                    <option value="0">请选择<?php echo $val['name'];?></option>
                                    <?php if(is_array($val['list'])) foreach($val['list'] as $kk => $vv) { ?>                                    <option value="<?php echo $vv;?>"><?php echo $vv;?></option>
                                    <?php } ?>
                                </select>
                               <?php } ?>
                               <?php if($val['type'] == 3) { ?>
                               <input class="tcui-input" type="datetime-local" name="attrdate_<?php echo $val['id'];?>" id="attrdate_<?php echo $val['id'];?>" value="" max="<?php echo $maxDateTime;?>" min="<?php echo $minDateTime;?>" />
                               <input type="hidden" name="attrdatetmp_<?php echo $val['id'];?>" id="attrdatetmp_<?php echo $val['id'];?>" value="">
                               <?php } ?>
                               <?php if($val['type'] == 4) { ?>
                               <div class="tcui-cells tcui-cells_checkbox" style="margin-top: 0px;line-height: 30px;">
                                   <?php if(is_array($val['list'])) foreach($val['list'] as $kk => $vv) { ?>                                    <label class="tcui-cell-cell tcui-check__label clearfix" for="s_<?php echo $val['id'];?>_<?php echo $kk;?>">
                                        <div class="tcui-cell__hd" style="float: left;">
                                            <input type="checkbox" class="tcui-check" name="attr_<?php echo $val['id'];?>[]" value="<?php echo $vv;?>" id="s_<?php echo $val['id'];?>_<?php echo $kk;?>">
                                            <i class="tcui-icon-checked"></i>
                                        </div>
                                        <div class="tcui-cell__bd" style="float: left;">
                                            <p><?php echo $vv;?></p>
                                        </div>
                                    </label>
                                   <?php } ?>
                                </div>
                               <?php } ?>
                               <?php if($val['type'] == 5) { ?>
                               <input type="number" name="attr_<?php echo $val['id'];?>" id="attr_<?php echo $val['id'];?>" placeholder="<?php echo $val['name'];?>" value=""  />
                               <?php } ?>
                           </section>
                           <div class="frt"><?php if($val['unit']) { ?><?php echo $val['unit'];?><?php } elseif($val['type'] == 3) { ?><div class="right-arrow"></div><?php } ?></div>
                      </section>
                 </section>
            <?php } ?>
            <?php } ?>
            <section class="input-control " <?php if($modelInfo['area_select'] == 0  ) { ?>style="display: none;"<?php } ?>>
                 <span>选择区域</span>
                 <section class="user-fav">
                      <section class="sec-input">
                           <div id="choseCity"><font color="#8e8e8e">选择区域</font></div>
                           <input type="hidden" name="area_id" id="area_id" value="">
                           <input type="hidden" name="street_id" id="street_id" value="">
                      </section>
                      <div class="frt"></div>
                 </section>
            </section>
            <?php if($modelInfo['open_dingwei'] == 1 ) { ?>
            <section class="input-control ">
                 <span>详细地址</span>
                 <section class="user-fav">
                      <section class="sec-input">
                           <input type="text" id="address" name="address" placeholder="点击右侧地图按钮进行地址定位" value=""  />
                           <input type="hidden" name="lng" id="hidlng" value="" />
                           <input type="hidden" name="lat" id="hidlat" value="" />
                      </section>
                     <div id="showActionSheet" class="frt"><i class="tciconfont tcicon-dingwei tc-template__color"  style="color: #F60;"></i><i id="locationtext" class="tc-template__color" style="color: #F60;">定位</i></div>
                 </section>
            </section>
            <?php } ?>
             <section class="input-control clear bb0">
                  <div style="line-height: 3em;"><?php echo $typeInfo['desc_title'];?></div>
                  <section class="textarea">
                       <section class="sec-input">
                            <textarea name="content" id="content" maxlength="10000" placeholder="<?php echo $typeInfo['desc_content'];?>"></textarea>
                       </section>
                  </section>
             </section>
            <?php if($tagList) { ?>
             <section class="input-control clear input-control-hide-title">
                  <span>-</span>
                  <section class="user-fav">
                       <section class="sec-input small-line">
                            <div data-max="5">
                                 <?php if(is_array($tagList)) foreach($tagList as $key => $val) { ?>                                 <input type="checkbox" id="check-fuli-<?php echo $val['id'];?>" name="tag[]" value="<?php echo $val['id'];?>" class="file-hide checkbox-label-item" />
                                 <label for="check-fuli-<?php echo $val['id'];?>"><?php echo $val['name'];?></label>
                                 <input type="hidden" name="tagname_<?php echo $val['id'];?>" value="<?php echo $val['name'];?>">
                                 <?php } ?>
                            </div>
                       </section>
                  </section>
             </section>
            <?php } ?>
             <section class="input-control ">
                  <ul>
                      <div id="photolist" class="clearfix"></div>
                       <li>
                            <section class="img pic-upload-btn" id="picpic-btn">
                                <?php if($is_weixin == 0 || $tongchengConfig['open_many_pic_upload'] == 0) { ?>
                                <input type="file" name="filedata1" id="filedata1" class="post-upload-fileprew"  />
                                <?php } ?>
                                <img src="source/plugin/tom_tongcheng/images/img7.png" />
                            </section>
                       </li>
                       <li class="li_text"><span>添加照片（最多<?php echo $tongchengConfig['max_photo_num'];?>张） </span></li>
                  </ul>
             </section>
        </section>
        <section class="input-control ">
             <span>联系人</span>
             <section class="user-fav">
                  <section class="sec-input">
                       <input type="text" name="xm" id="xm" placeholder="请输入联系人" value="<?php echo $defaultXm;?>" />
                  </section>
                  <div class="frt"></div>
             </section>
        </section>
        <section class="input-control ">
             <span>电话</span>
             <section class="user-fav">
                  <section class="sec-input">
                       <input class="tcui-input" type="tel" name="tel" id="tel" placeholder="请输入电话" value="<?php echo $defaultTel;?>"  />
                  </section>
                  <div class="frt"></div>
             </section>
        </section>
        <section class="input-control">
             <span class="slide-btn" data-target="advance-slide" data-html="1">发布条款</span>
             <section>
                 <input type="checkbox" name="xieyi" id="xieyi" value="1" checked/> <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=article">我同意条款，保证信息合法合规</a> 
             </section>
        </section>
        <?php if($openMajiaStatus == 1) { ?>
        <section class="input-majia tcui-cell tcui-cell_switch">
            <div class="tcui-cell__bd">开启马甲</div>
            <div class="tcui-cell__ft">
                <input class="tcui-switch" type="checkbox" id="open_majia" name="open_majia" value="1">
            </div>
        </section>
        <?php } ?>
   </section>
   <section class="btn-group-block">
       <?php if($fabuPayStatus == 1) { ?>
           <button type="button" id="id_fabu_btn" class="id_fabu_btn tc-template__bg">发布，支付￥<span class="id_fabu_price"><?php echo $typeInfo['fabu_price'];?></span></button>
           <?php if($isVipFabu == 1) { ?>
           <br/>本次享受“<font color="#fd0d0d"><?php echo $tcyikatongConfig['card_name'];?></font>”半价发布
           <?php } ?>
           <div class="id_fabu_msg"></div>
       <?php } elseif($fabuPayStatus == 2) { ?>
           <button type="button" id="id_fabu_btn" class="id_fabu_btn tc-template__bg">金币支付</button>
           <br/>我的金币：<font color="#fd0d0d"><?php echo $__UserInfo['score'];?></font>，本次扣除：<font color="#fd0d0d"><?php echo $useScore;?></font>
       <?php } else { ?>
           <button type="button" id="id_fabu_btn" class="id_fabu_btn tc-template__bg">发 布</button>
           <?php if($isVipFabu == 2) { ?>
           <br/>本次享受“<font color="#fd0d0d"><?php echo $tcyikatongConfig['card_name'];?></font>”免费发布，今日剩余<font color="#fd0d0d"><?php echo $shengyuVipTimes;?></font>次
           <?php } ?>
       <?php } ?>
        <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
        <input type="hidden" name="model_id" value="<?php echo $typeInfo['model_id'];?>">
        <input type="hidden" name="type_id" value="<?php echo $type_id;?>">
        <input type="hidden" name="user_id" value="<?php echo $__UserInfo['id'];?>">
        <input type="hidden" name="city_id" id="city_id" value="<?php echo $__CityInfo['id'];?>">
        <div class="clear10"></div>
        <?php if($__IsMiniprogram == 1 && $__Ios == 1 && $tongchengConfig['closed_ios_pay'] == 1 ) { } else { ?>
            <?php if($isVipFabu == 3) { ?>
            <div class="fabu_card-box__tishi dislay-flex">
                <div class="box-tishi__lt flex"><?php echo $tcyikatongConfig['card_name'];?>会员半价发布</div>
                <a class="box-tishi__rt" href="plugin.php?id=tom_tcyikatong&amp;site=<?php echo $site_id;?>&amp;mod=card">开通</a>
            </div>
            <?php } ?>
            <?php if($isVipFabu == 4) { ?>
            <div class="fabu_card-box__tishi dislay-flex">
                <div class="box-tishi__lt flex"><?php echo $tcyikatongConfig['card_name'];?>会员免费发布</div>
                <a class="box-tishi__rt" href="plugin.php?id=tom_tcyikatong&amp;site=<?php echo $site_id;?>&amp;mod=card">开通</a>
            </div>
            <?php } ?>
        <?php } ?>
        <div class="clear10"></div>
        <div class="clear10"></div>
        <div class="clear10"></div>
        <div class="clear10"></div>
   </section>
</form>
<?php if($__IsMiniprogram == 1 && $__Ios == 1 && $fabuPayStatus == 1 && $tongchengConfig['closed_ios_pay'] == 1 ) { ?>
<div class="js_dialog">
    <div class="tcui-mask"></div>
    <div class="tcui-dialog">
        <div class="tcui-dialog__hd"><strong class="tcui-dialog__title">温馨提示</strong></div>
        <div class="tcui-dialog__bd">本栏目不支持苹果手机小程序发布</div>
        <div class="tcui-dialog__ft">
            <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=fabu&amp;prand=<?php echo $prand;?>" class="tcui-dialog__btn tcui-dialog__btn_default">关闭</a>
        </div>
    </div>
</div>
<?php } ?>
<section class="dialog succ-dialog id-fabu-succ" style="display: none;">
   <section class="dialog-wrap">
        <section class="dialog-center">
            <a href="javascript:void(0);" onclick="hideFabuSucc();" class="group-link close"></a>
             <section class="dialog-body">
                  <h1>发布成功</h1>
                  <p><span class="tc-template__border">想快速交易成功，要常来个人中心 </span><label class="tc-template__color tc-template__border">刷新</label><span class="tc-template__border"> 哦！</span></p>
                  <section class="dialog-btns clear">
                       <?php if($__IsMiniprogram == 1 ) { ?>
                       <a href="javascript:void(0);" class="share-link id-share-link">查看信息</a>
                       <?php } else { ?>
                       <a href="#" class="share-link id-share-link">查看信息</a>
                       <?php } ?>
                       <a href="#" class="buy-link id-buy-link">置顶推广</a>
                       <?php if($__ShowTchongbao == 1) { ?>
                       <a href="#" class="hb-link id-hb-link">红包推广</a>
                       <?php } ?>
                  </section>
             </section>
        </section>
   </section>
</section>
<?php if($modelInfo['open_dingwei'] == 1 ) { ?>
<div id="baidumap" style="position: fixed;bottom: 0px; height:100%; width:100%;z-index:9999;display:none">
    <iframe style="border:0px;width:100%;height:100%"></iframe>
</div>
<div class="tcui-actionsheet" id="actionSheet_wrap">
    <header class="header on in2 tc-template__bg">
        <section class="wrap"><h2>选择位置</h2></section>
    </header>
    <div class="tcui-actionsheet__menu">
        <a class="tcui-actionsheet__cell" href="javascript:void(0);" id="mylocation">我当前位置</a>
        <a class="tcui-actionsheet__cell" href="javascript:void(0);" id="maplocation">地图上选点</a>
    </div>
    <div class="clear"></div>
    <div class="tcui-actionsheet__action">
        <div class="tcui-actionsheet__cell" id="actionsheet_cancel">取消</div>
    </div>
</div>
<?php } if($showPhoneDialog == 1  ) { ?>
<section class="dialog succ-dialog">
   <section class="dialog-wrap">
        <section class="dialog-center">
             <section class="dialog-body">
                  <h1>绑定手机号</h1>
                  <p><span class="tc-template__border">必须绑定手机号后才能发布信息</span></p>
                  <section class="dialog-btns clear">
                      <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=phone&amp;phone_back=<?php echo $phone_back_url;?>" class="share-link" style="width: 90%;">去认证</a>
                  </section>
             </section>
        </section>
   </section>
</section>
<?php } ?>
<script>var city = eval(decodeURIComponent('<?php echo $cityData;?>'));var selectedIndex = [0, 0];</script>
<?php if($isGbk) { ?>
<script src="source/plugin/tom_tongcheng/images/mobiscroll/mobiscroll.gbk.js" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/picker/picker.min.gbk.js?v=2" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/picker/picker.fabu.gbk.js" type="text/javascript"></script>
<?php } else { ?>
<script src="source/plugin/tom_tongcheng/images/mobiscroll/mobiscroll.utf8.js" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/picker/picker.min.utf8.js?v=2" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/picker/picker.fabu.utf8.js" type="text/javascript"></script>
<?php } if($modelInfo['open_dingwei'] == 1 ) { ?>
<script src="//api.map.baidu.com/api?v=2.0&ak=<?php echo $tongchengConfig['baidu_js_ak'];?>" type="text/javascript"></script>
<?php } ?>
<script src="//res.wx.qq.com/open/js/jweixin-1.3.2.js" type="text/javascript" type="text/javascript"></script>
<script>
var li_i = 1;
var count = 0;
var tongcheng_id    = "<?php echo $tongcheng_id;?>";
var max_photo_num   = "<?php echo $tongchengConfig['max_photo_num'];?>";
max_photo_num       = max_photo_num*1;
var shareLinkUrl    = "<?php echo $shareLinkUrl;?>";
var buyLinkUrl      = "<?php echo $buyLinkUrl;?>";
var hbLinkUrl       = "<?php echo $hbLinkUrl;?>";
var score           = "<?php echo $__UserInfo['score'];?>";
score               = score*1;
var pay_score_yuan  = "<?php echo $tongchengConfig['pay_score_yuan'];?>";
pay_score_yuan      = pay_score_yuan*1;
var score_fabu_status = 0;

wx.config({
    debug: false,
    appId: '<?php echo $wxJssdkConfig["appId"];?>',
    timestamp: <?php echo $wxJssdkConfig["timestamp"];?>,
    nonceStr: '<?php echo $wxJssdkConfig["nonceStr"];?>',
    signature: '<?php echo $wxJssdkConfig["signature"];?>',
    jsApiList: [
      'onMenuShareTimeline',
      'onMenuShareAppMessage',
      'previewImage',
      'chooseImage',
      'uploadImage',
      'downloadImage'
    ]
});

$('#open_majia').change(function(){
    if($('#open_majia').attr("checked")) {
        $('#xm').val('');
    }
})

function chooseOverDaysItem(days,price,vipprice){
    $('#choseOverDays').html('<font color="#fd0d0d">有效'+days+'天/'+price+'元</font>');
    $(".id-over-days").removeClass("on");
    $("#over-days-item-"+days).addClass("on");
    $('#over_days').val(days);
    <?php if($isVipFabu == 1) { ?>
    $('.id_fabu_price').html(vipprice);
    var use_score = vipprice*pay_score_yuan;
    <?php } else { ?>
    $('.id_fabu_price').html(price);
    var use_score = price*pay_score_yuan;
    <?php } ?>
    use_score = Math.ceil(use_score);
    <?php if($isVipFabu != 2) { ?>
    if(score >= use_score && pay_score_yuan > 0){
        score_fabu_status = 1;
        $('.id_fabu_btn').html('金币支付');
        $('.id_fabu_msg').html('<br/>我的金币：<font color="#fd0d0d">'+score+'</font>，本次扣除：<font color="#fd0d0d">'+use_score+'</font>');
    }else{
        $('.id_fabu_msg').html('');
         <?php if($isVipFabu == 1) { ?>
         $('.id_fabu_btn').html('发布，支付￥<span class="id_fabu_price">'+vipprice+'</span>');
         <?php } else { ?>
         $('.id_fabu_btn').html('发布，支付￥<span class="id_fabu_price">'+price+'</span>');
         <?php } ?>
    }
    <?php } ?>
    $.closePopup();
}

function refreshsites() {
location.href = 'plugin.php?id=tom_tongcheng&site='+$('#site_id').val()+'&mod=fabu&act=step2&type_id=<?php echo $type_id;?>&lbs_no=1';
}

var submintPayStatus = 0;
$(".id_fabu_btn").click( function (){
    if(submintPayStatus == 1){
        return false;
    }
    
    var xm          = $("#xm").val();
    var tel         = $("#tel").val();
    var content      = $("#content").val();
    var area_id      = $("#area_id").val();
    var street_id      = $("#street_id").val();
    
    <?php if($typeInfo['jifei_type'] == 2 ) { ?>
    var over_days      = $("#over_days").val();
    if(over_days == 0){
        tusi('必须选择发布天数');
        return false;
    }
    <?php } ?>

    <?php if($cateList) { ?>
    var cate_id      = $("#cate_id").val();
    if(cate_id == 0){
        tusi('必须填写<?php echo $typeInfo['cate_title'];?>');
        return false;
    }
    <?php } ?>
    
    <?php if($attrList) { ?>
    <?php if(is_array($attrList)) foreach($attrList as $key => $val) { ?>        <?php if($val['is_must'] == 1) { ?>
            <?php if($val['type'] == 1 || $val['type'] == 5) { ?>
            var attr_<?php echo $val['id'];?> = $('#attr_<?php echo $val["id"];?>').val();
            if(attr_<?php echo $val['id'];?> == ''){
                tusi('必须填写<?php echo $val["name"];?>');
                return false;
            }
            <?php } elseif($val['type'] == 2) { ?>
            var attr_<?php echo $val['id'];?> = $('#attr_<?php echo $val["id"];?>').val();
            if(attr_<?php echo $val['id'];?> == 0){
                tusi('必须填写<?php echo $val["name"];?>');
                return false;
            }
            <?php } elseif($val['type'] == 3) { ?>
            var attrdate_<?php echo $val['id'];?> = $('#attrdate_<?php echo $val["id"];?>').val();
            if(attrdate_<?php echo $val['id'];?> == ''){
                tusi('必须填写<?php echo $val["name"];?>');
                return false;
            }
            <?php } ?>
        <?php } ?>
    <?php } ?>        
    <?php } ?>
    
    if($('#xieyi').attr("checked")) {
    }else{
        tusi("必须同意发布协议");
        return false;
    }
    <?php if($tongchengConfig['open_fabu_title'] == 1) { ?>
    var title          = $("#title").val();
    if(title == ""){
        tusi("必须填写标题");
        return false;
    }
    <?php } ?>
    <?php if($modelInfo['area_select'] == 1  ) { ?>
    if(area_id == ""){
        tusi("必须选择区域");
        return false;
    }
    <?php } ?>
    
    if(xm == ""){
        tusi("必须填写联系人");
        return false;
    }
    <?php if($tongchengConfig['fabu_phone_check'] == 1  ) { ?>
    if(tel == "" || !checkMobile(tel)){
        tusi("必须填写手机号");
        return false;
    }
    <?php } else { ?>
    if(tel == ""){
        tusi("必须填写手机号");
        return false;
    }
    <?php } ?>
    <?php if($modelInfo['open_dingwei'] == 1 ) { ?>
    <?php if($__Ios == 1 || $__Android == 1 ) { ?>
        var address     = $("#address").val();
        var hidlat      = $("#hidlat").val();
        if(hidlat == "" || address == ""){
            tusi("必须定位位置");
            return false;
        }
    <?php } ?>
    <?php } ?>
    if(content == ""){
        tusi("必须填写<?php echo $typeInfo['desc_title'];?>");
        return false;
    }
    
    if(count > max_photo_num){
        tusi("超过上传张数限制");
        return false;
    }
    
    loading('处理中...');
    submintPayStatus = 1;
    $.ajax({
        type: "POST",
        url: "<?php echo $payUrl;?>",
        dataType : "json",
        data: $('#payForm').serialize(),
        success: function(data){
            loading(false);
            if(data.status == 200 && score_fabu_status == 0) {
                <?php if($fabuPayStatus == 1) { ?>
                tusi("下单成功，立即支付");
                setTimeout(function(){window.location.href=data.payurl+"&prand=<?php echo $prand;?>";},500);
                <?php } else { ?>
                tongcheng_id = data.tongcheng_id;
                submintPayStatus = 0;
                setTimeout(function(){window.location.href="<?php echo $succLinkUrl;?>"+tongcheng_id+"&prand=<?php echo $prand;?>";},500);
                //showFabuSucc();
                <?php } ?>
            }else if(data.status == 200  && score_fabu_status == 1){
                tongcheng_id = data.tongcheng_id;
                submintPayStatus = 0;
                setTimeout(function(){window.location.href="<?php echo $succLinkUrl;?>"+tongcheng_id+"&prand=<?php echo $prand;?>";},500);
            }else if(data.status == 301){
                tusi("账号被封，不允许发布");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 303){
                tusi("生成微信订单失败");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 304){
                tusi("插入订单数据失败");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 305){
                tusi("<?php echo $tongchengConfig['fabu_next_minute'];?>分钟后才能再发布");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 306){
                tusi("没有马甲可用");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 307){
                tusi("没有安装TOM支付中心插件");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 404){
                tusi("插入信息数据失败");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 500){
                tusi("数据验证错误");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 501){
                submintPayStatus = 0;
                tusi("你发布的内容已经存在相似内容");
            }else if(data.status == 502){
                submintPayStatus = 0;
                tusi("发布天数异常");
            }else if(data.status == 505){
                submintPayStatus = 0;
                tusi("包含违禁词："+data.word);
                //setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else{
                tusi("发布出错");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }
        }
    });
});

function showFabuSucc(){
    <?php if($tongchengConfig['open_yun'] == 2) { ?>
    $.get("<?php echo $ossBatchUrl;?>");
    <?php } ?>
    <?php if($tongchengConfig['open_yun'] == 3) { ?>
    $.get("<?php echo $qiniuBatchUrl;?>");
    <?php } ?>
    <?php if($__IsMiniprogram == 1 ) { } else { ?>
    $(".id-share-link").attr("href",shareLinkUrl+tongcheng_id); 
    <?php } ?>
    $(".id-buy-link").attr("href",buyLinkUrl+tongcheng_id); 
    <?php if($__ShowTchongbao == 1) { ?>
    $(".id-hb-link").attr("href",hbLinkUrl+tongcheng_id); 
    <?php } ?>
    $(".id-fabu-succ").show();
    return false;
}
<?php if($__IsMiniprogram == 1 ) { ?>
$(".id-share-link").click( function (){
    jumpMiniprogram('<?php echo $_G['siteurl'];?>'+shareLinkUrl+tongcheng_id);
});
<?php } ?>
function hideFabuSucc(){
    //$(".id-fabu-succ").hide();
    setTimeout(function(){window.location.href="<?php echo $myListAllUrl;?>";},1);
    return false;
}

function checkMobile(s){
    var regu =/^[1][0-9]{10}$/;
var re = new RegExp(regu);
if (re.test(s)) {
return true;
}else{
return false;
}
}

$(document).ready(function() {
    var a = (new Date).getFullYear();
    $("input[type=date]").each(function() {
        $(this).mobiscroll().date({
            startYear: a - 60,
            endYear: a + 10
        })
    }),
    $("input[type=datetime-local]").mobiscroll().datetime({
        startYear: a - 60,
        endYear: a + 10
    })
});

function picremove(i){
    $(".li_"+i).remove();
    count--;
}

$(document).on("click", ".checkbox-label-item",function() {
    var t = $(this).parent(),
    a = parseInt(t.data("max"), 10) || 0;
    a > 0 && $(this).is(":checked") && t.find("input:checked").length > a && ($(this).prop("checked", !1), tusi("只允许选择" + a + "项"))
});

$(document).ready(function() {
    <?php if($pay_ok == 1 && $tongchengInfo['pay_status'] == 2) { ?>
    showFabuSucc();
    <?php } ?>
});
</script>
<?php if($is_weixin == 1 && $tongchengConfig['open_many_pic_upload'] == 1) { include template('tom_tongcheng:wx_upload'); } else { include template('tom_tongcheng:new_upload'); } if($modelInfo['open_dingwei'] == 1 ) { if($__IsWeixin == 1) { include template('tom_tongcheng:wx_map'); } else { include template('tom_tongcheng:baidu_map'); } } ?>
</body>
</html>