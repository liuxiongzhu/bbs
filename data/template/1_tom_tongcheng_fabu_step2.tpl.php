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
        return { /*移动终端浏览器版本信息*/
            trident: u.indexOf('Trident') > -1, /*IE内核*/
            presto: u.indexOf('Presto') > -1, /*opera内核*/
            webKit: u.indexOf('AppleWebKit') > -1, /*苹果、谷歌内核*/
            gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, /*火狐内核*/
            mobile: !!u.match(/AppleWebKit.*Mobile.*/) || !!u.match(/AppleWebKit/), /*是否为移动终端*/
            ios: !!u.match(/i[^;]+;( U;)? CPU.+Mac OS X/), /*ios终端*/
            android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, /*android终端或者uc浏览器*/
            iPhone: u.indexOf('iPhone') > -1 || (u.indexOf('Mac') > -1 && u.indexOf('Macintosh') < 0), /*是否为iPhone或者QQHD浏览器*/
            iPad: u.indexOf('iPad') > -1, /*是否iPad*/
            webApp: u.indexOf('Safari') == -1, /*是否web应该程序，没有头部与底部*/
            WindowsWechat: u.indexOf('WindowsWechat') > 0 /*是否web应该程序，没有头部与底部*/
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
          <div class="fabu_over_days_title">鍙戝竷澶╂暟</div>
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
                            <div class="days "><?php echo $val['vipprice'];?>鍏�</div>
                            <?php } elseif($isVipFabu == 2  || $__UserInfo['editor']==1) { ?>
                            <div class="days ">0鍏�</div>
                            <?php } else { ?>
                            <div class="days "><?php echo $val['price'];?>鍏�</div>
                            <?php } ?>
                            <div class="msg">鏈夋晥<?php echo $val['days'];?>澶�</div>
                            <?php } else { ?>
                            <?php if($isVipFabu == 1) { ?>
                            <div class="days ">鏈夋晥<?php echo $val['days'];?>澶�/<?php echo $val['vipprice'];?>鍏�</div>
                            <?php } elseif($isVipFabu == 2  || $__UserInfo['editor']==1) { ?>
                            <div class="days ">鏈夋晥<?php echo $val['days'];?>澶�/0鍏�</div>
                            <?php } else { ?>
                            <div class="days ">鏈夋晥<?php echo $val['days'];?>澶�/<?php echo $val['price'];?>鍏�</div>
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
          <a href="javascript:void(0);" class="tcui-btn tcui-btn_default close-popups">鍏抽棴</a>
      </div>
  </div>
</div>
<header class="header header-index on in2 tc-template__bg">
   <section class="wrap">
       <?php if($__HideHeader == 0 ) { ?>
       <section class="sec-ico go-back" onclick="history.back();">杩斿洖</section>
       <?php } ?>
        <h2>鍙戝竷鈥�<?php echo $typeInfo['name'];?>鈥濅俊鎭�</h2>
        <section class="sec-ico btn slide-btn">
            <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=article">鍙戝竷椤荤煡</a>
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
                  <span>鍙戝竷绔欑偣</span>
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
                 <span>鍙戝竷澶╂暟</span>
                 <section class="user-fav">
                      <section class="sec-input">
                          <div id="choseOverDays" class="open-popups" style="cursor: pointer;" data-target="#over-days-box"><font color="#8e8e8e">閫夋嫨鏈夋晥鍙戝竷澶╂暟</font></div>
                           <input type="hidden" name="over_days" id="over_days" value="0">
                      </section>
                      <div class="frt"></div>
                 </section>
            </section>
            <?php } ?>
            <?php if($__ShowTcshop == 1) { ?>
            <?php if($tcshopList) { ?>
             <section class="input-control ">
                  <span>鍏宠仈搴楅摵</span>
                  <section class="user-fav">
                       <section class="sec-input">
                            <select name="tcshop_id" id="tcshop_id" class="tcui-select">
                                <option value="0"> 涓嶅叧鑱斿簵閾�</option>
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
                <span>鏍囬</span>
                <section class="user-fav">
                    <section class="sec-input">
                        <input type="text" name="title" id="title" placeholder="璇疯緭鍏ユ爣棰�" value="" />
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
                                <option value="0">璇烽�夋嫨</option>
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
                                    <option value="0">璇烽�夋嫨<?php echo $val['name'];?></option>
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
                 <span>閫夋嫨鍖哄煙</span>
                 <section class="user-fav">
                      <section class="sec-input">
                           <div id="choseCity"><font color="#8e8e8e">閫夋嫨鍖哄煙</font></div>
                           <input type="hidden" name="area_id" id="area_id" value="">
                           <input type="hidden" name="street_id" id="street_id" value="">
                      </section>
                      <div class="frt"></div>
                 </section>
            </section>
            <?php if($modelInfo['open_dingwei'] == 1 ) { ?>
            <section class="input-control ">
                 <span>璇︾粏鍦板潃</span>
                 <section class="user-fav">
                      <section class="sec-input">
                           <input type="text" id="address" name="address" placeholder="鐐瑰嚮鍙充晶鍦板浘鎸夐挳杩涜鍦板潃瀹氫綅" value=""  />
                           <input type="hidden" name="lng" id="hidlng" value="" />
                           <input type="hidden" name="lat" id="hidlat" value="" />
                      </section>
                     <div id="showActionSheet" class="frt"><i class="tciconfont tcicon-dingwei tc-template__color"  style="color: #F60;"></i><i id="locationtext" class="tc-template__color" style="color: #F60;">瀹氫綅</i></div>
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
                       <li class="li_text"><span>娣诲姞鐓х墖锛堟渶澶�<?php echo $tongchengConfig['max_photo_num'];?>寮狅級 </span></li>
                  </ul>
             </section>
        </section>
        <section class="input-control ">
             <span>鑱旂郴浜�</span>
             <section class="user-fav">
                  <section class="sec-input">
                       <input type="text" name="xm" id="xm" placeholder="璇疯緭鍏ヨ仈绯讳汉" value="<?php echo $defaultXm;?>" />
                  </section>
                  <div class="frt"></div>
             </section>
        </section>
        <section class="input-control ">
             <span>鐢佃瘽</span>
             <section class="user-fav">
                  <section class="sec-input">
                       <input class="tcui-input" type="tel" name="tel" id="tel" placeholder="璇疯緭鍏ョ數璇�" value="<?php echo $defaultTel;?>"  />
                  </section>
                  <div class="frt"></div>
             </section>
        </section>
        <section class="input-control">
             <span class="slide-btn" data-target="advance-slide" data-html="1">鍙戝竷鏉℃</span>
             <section>
                 <input type="checkbox" name="xieyi" id="xieyi" value="1" checked/> <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=article">鎴戝悓鎰忔潯娆撅紝淇濊瘉淇℃伅鍚堟硶鍚堣</a> 
             </section>
        </section>
        <?php if($openMajiaStatus == 1) { ?>
        <section class="input-majia tcui-cell tcui-cell_switch">
            <div class="tcui-cell__bd">寮�鍚┈鐢�</div>
            <div class="tcui-cell__ft">
                <input class="tcui-switch" type="checkbox" id="open_majia" name="open_majia" value="1">
            </div>
        </section>
        <?php } ?>
   </section>
   <section class="btn-group-block">
       <?php if($fabuPayStatus == 1) { ?>
           <button type="button" id="id_fabu_btn" class="id_fabu_btn tc-template__bg">鍙戝竷锛屾敮浠橈骏<span class="id_fabu_price"><?php echo $typeInfo['fabu_price'];?></span></button>
           <?php if($isVipFabu == 1) { ?>
           <br/>鏈浜彈鈥�<font color="#fd0d0d"><?php echo $tcyikatongConfig['card_name'];?></font>鈥濆崐浠峰彂甯�
           <?php } ?>
           <div class="id_fabu_msg"></div>
       <?php } elseif($fabuPayStatus == 2) { ?>
           <button type="button" id="id_fabu_btn" class="id_fabu_btn tc-template__bg">閲戝竵鏀粯</button>
           <br/>鎴戠殑閲戝竵锛�<font color="#fd0d0d"><?php echo $__UserInfo['score'];?></font>锛屾湰娆℃墸闄わ細<font color="#fd0d0d"><?php echo $useScore;?></font>
       <?php } else { ?>
           <button type="button" id="id_fabu_btn" class="id_fabu_btn tc-template__bg">鍙� 甯�</button>
           <?php if($isVipFabu == 2) { ?>
           <br/>鏈浜彈鈥�<font color="#fd0d0d"><?php echo $tcyikatongConfig['card_name'];?></font>鈥濆厤璐瑰彂甯冿紝浠婃棩鍓╀綑<font color="#fd0d0d"><?php echo $shengyuVipTimes;?></font>娆�
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
                <div class="box-tishi__lt flex"><?php echo $tcyikatongConfig['card_name'];?>浼氬憳鍗婁环鍙戝竷</div>
                <a class="box-tishi__rt" href="plugin.php?id=tom_tcyikatong&amp;site=<?php echo $site_id;?>&amp;mod=card">寮�閫�</a>
            </div>
            <?php } ?>
            <?php if($isVipFabu == 4) { ?>
            <div class="fabu_card-box__tishi dislay-flex">
                <div class="box-tishi__lt flex"><?php echo $tcyikatongConfig['card_name'];?>浼氬憳鍏嶈垂鍙戝竷</div>
                <a class="box-tishi__rt" href="plugin.php?id=tom_tcyikatong&amp;site=<?php echo $site_id;?>&amp;mod=card">寮�閫�</a>
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
        <div class="tcui-dialog__hd"><strong class="tcui-dialog__title">娓╅Θ鎻愮ず</strong></div>
        <div class="tcui-dialog__bd">鏈爮鐩笉鏀寔鑻规灉鎵嬫満灏忕▼搴忓彂甯�</div>
        <div class="tcui-dialog__ft">
            <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=fabu&amp;prand=<?php echo $prand;?>" class="tcui-dialog__btn tcui-dialog__btn_default">鍏抽棴</a>
        </div>
    </div>
</div>
<?php } ?>
<section class="dialog succ-dialog id-fabu-succ" style="display: none;">
   <section class="dialog-wrap">
        <section class="dialog-center">
            <a href="javascript:void(0);" onclick="hideFabuSucc();" class="group-link close"></a>
             <section class="dialog-body">
                  <h1>鍙戝竷鎴愬姛</h1>
                  <p><span class="tc-template__border">鎯冲揩閫熶氦鏄撴垚鍔燂紝瑕佸父鏉ヤ釜浜轰腑蹇� </span><label class="tc-template__color tc-template__border">鍒锋柊</label><span class="tc-template__border"> 鍝︼紒</span></p>
                  <section class="dialog-btns clear">
                       <?php if($__IsMiniprogram == 1 ) { ?>
                       <a href="javascript:void(0);" class="share-link id-share-link">鏌ョ湅淇℃伅</a>
                       <?php } else { ?>
                       <a href="#" class="share-link id-share-link">鏌ョ湅淇℃伅</a>
                       <?php } ?>
                       <a href="#" class="buy-link id-buy-link">缃《鎺ㄥ箍</a>
                       <?php if($__ShowTchongbao == 1) { ?>
                       <a href="#" class="hb-link id-hb-link">绾㈠寘鎺ㄥ箍</a>
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
        <section class="wrap"><h2>閫夋嫨浣嶇疆</h2></section>
    </header>
    <div class="tcui-actionsheet__menu">
        <a class="tcui-actionsheet__cell" href="javascript:void(0);" id="mylocation">鎴戝綋鍓嶄綅缃�</a>
        <a class="tcui-actionsheet__cell" href="javascript:void(0);" id="maplocation">鍦板浘涓婇�夌偣</a>
    </div>
    <div class="clear"></div>
    <div class="tcui-actionsheet__action">
        <div class="tcui-actionsheet__cell" id="actionsheet_cancel">鍙栨秷</div>
    </div>
</div>
<?php } if($showPhoneDialog == 1  ) { ?>
<section class="dialog succ-dialog">
   <section class="dialog-wrap">
        <section class="dialog-center">
             <section class="dialog-body">
                  <h1>缁戝畾鎵嬫満鍙�</h1>
                  <p><span class="tc-template__border">蹇呴』缁戝畾鎵嬫満鍙峰悗鎵嶈兘鍙戝竷淇℃伅</span></p>
                  <section class="dialog-btns clear">
                      <a href="plugin.php?id=tom_tongcheng&amp;site=<?php echo $site_id;?>&amp;mod=phone&amp;phone_back=<?php echo $phone_back_url;?>" class="share-link" style="width: 90%;">鍘昏璇�</a>
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
    $('#choseOverDays').html('<font color="#fd0d0d">鏈夋晥'+days+'澶�/'+price+'鍏�</font>');
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
        $('.id_fabu_btn').html('閲戝竵鏀粯');
        $('.id_fabu_msg').html('<br/>鎴戠殑閲戝竵锛�<font color="#fd0d0d">'+score+'</font>锛屾湰娆℃墸闄わ細<font color="#fd0d0d">'+use_score+'</font>');
    }else{
        $('.id_fabu_msg').html('');
         <?php if($isVipFabu == 1) { ?>
         $('.id_fabu_btn').html('鍙戝竷锛屾敮浠橈骏<span class="id_fabu_price">'+vipprice+'</span>');
         <?php } else { ?>
         $('.id_fabu_btn').html('鍙戝竷锛屾敮浠橈骏<span class="id_fabu_price">'+price+'</span>');
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
        tusi('蹇呴』閫夋嫨鍙戝竷澶╂暟');
        return false;
    }
    <?php } ?>

    <?php if($cateList) { ?>
    var cate_id      = $("#cate_id").val();
    if(cate_id == 0){
        tusi('蹇呴』濉啓<?php echo $typeInfo['cate_title'];?>');
        return false;
    }
    <?php } ?>
    
    <?php if($attrList) { ?>
    <?php if(is_array($attrList)) foreach($attrList as $key => $val) { ?>        <?php if($val['is_must'] == 1) { ?>
            <?php if($val['type'] == 1 || $val['type'] == 5) { ?>
            var attr_<?php echo $val['id'];?> = $('#attr_<?php echo $val["id"];?>').val();
            if(attr_<?php echo $val['id'];?> == ''){
                tusi('蹇呴』濉啓<?php echo $val["name"];?>');
                return false;
            }
            <?php } elseif($val['type'] == 2) { ?>
            var attr_<?php echo $val['id'];?> = $('#attr_<?php echo $val["id"];?>').val();
            if(attr_<?php echo $val['id'];?> == 0){
                tusi('蹇呴』濉啓<?php echo $val["name"];?>');
                return false;
            }
            <?php } elseif($val['type'] == 3) { ?>
            var attrdate_<?php echo $val['id'];?> = $('#attrdate_<?php echo $val["id"];?>').val();
            if(attrdate_<?php echo $val['id'];?> == ''){
                tusi('蹇呴』濉啓<?php echo $val["name"];?>');
                return false;
            }
            <?php } ?>
        <?php } ?>
    <?php } ?>        
    <?php } ?>
    
    if($('#xieyi').attr("checked")) {
    }else{
        tusi("蹇呴』鍚屾剰鍙戝竷鍗忚");
        return false;
    }
    <?php if($tongchengConfig['open_fabu_title'] == 1) { ?>
    var title          = $("#title").val();
    if(title == ""){
        tusi("蹇呴』濉啓鏍囬");
        return false;
    }
    <?php } ?>
    <?php if($modelInfo['area_select'] == 1  ) { ?>
    if(area_id == ""){
        tusi("蹇呴』閫夋嫨鍖哄煙");
        return false;
    }
    <?php } ?>
    
    if(xm == ""){
        tusi("蹇呴』濉啓鑱旂郴浜�");
        return false;
    }
    <?php if($tongchengConfig['fabu_phone_check'] == 1  ) { ?>
    if(tel == "" || !checkMobile(tel)){
        tusi("蹇呴』濉啓鎵嬫満鍙�");
        return false;
    }
    <?php } else { ?>
    if(tel == ""){
        tusi("蹇呴』濉啓鎵嬫満鍙�");
        return false;
    }
    <?php } ?>
    <?php if($modelInfo['open_dingwei'] == 1 ) { ?>
    <?php if($__Ios == 1 || $__Android == 1 ) { ?>
        var address     = $("#address").val();
        var hidlat      = $("#hidlat").val();
        if(hidlat == "" || address == ""){
            tusi("蹇呴』瀹氫綅浣嶇疆");
            return false;
        }
    <?php } ?>
    <?php } ?>
    if(content == ""){
        tusi("蹇呴』濉啓<?php echo $typeInfo['desc_title'];?>");
        return false;
    }
    
    if(count > max_photo_num){
        tusi("瓒呰繃涓婁紶寮犳暟闄愬埗");
        return false;
    }
    
    loading('澶勭悊涓�...');
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
                tusi("涓嬪崟鎴愬姛锛岀珛鍗虫敮浠�");
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
                tusi("璐﹀彿琚皝锛屼笉鍏佽鍙戝竷");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 303){
                tusi("鐢熸垚寰俊璁㈠崟澶辫触");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 304){
                tusi("鎻掑叆璁㈠崟鏁版嵁澶辫触");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 305){
                tusi("<?php echo $tongchengConfig['fabu_next_minute'];?>鍒嗛挓鍚庢墠鑳藉啀鍙戝竷");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 306){
                tusi("娌℃湁椹敳鍙敤");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 307){
                tusi("娌℃湁瀹夎TOM鏀粯涓績鎻掍欢");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 404){
                tusi("鎻掑叆淇℃伅鏁版嵁澶辫触");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 500){
                tusi("鏁版嵁楠岃瘉閿欒");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 501){
                submintPayStatus = 0;
                tusi("浣犲彂甯冪殑鍐呭宸茬粡瀛樺湪鐩镐技鍐呭");
            }else if(data.status == 502){
                submintPayStatus = 0;
                tusi("鍙戝竷澶╂暟寮傚父");
            }else if(data.status == 505){
                submintPayStatus = 0;
                tusi("鍖呭惈杩濈璇嶏細"+data.word);
                //setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else{
                tusi("鍙戝竷鍑洪敊");
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
    a > 0 && $(this).is(":checked") && t.find("input:checked").length > a && ($(this).prop("checked", !1), tusi("鍙厑璁搁�夋嫨" + a + "椤�"))
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