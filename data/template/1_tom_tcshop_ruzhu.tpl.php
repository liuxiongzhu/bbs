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
<title>商家入驻 - <?php echo $__SitesInfo['name'];?></title>
<link rel="stylesheet" href="source/plugin/tom_tongcheng/images/style.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tcshop/images/iconfont/iconfont.css?v=<?php echo $cssJsVersion;?>" />
<link rel="stylesheet" href="source/plugin/tom_tcshop/images/shop_style.css?v=<?php echo $cssJsVersion;?>" />
<script src="source/plugin/tom_tcshop/images/jquery.min-2.1.3.js" type="text/javascript"></script>
<script src="source/plugin/tom_tongcheng/images/layer_mobile/layer.js?v=<?php echo $cssJsVersion;?>" type="text/javascript"></script>
<script type="text/javascript">
    var commonjspath = 'source/plugin/tom_tongcheng/images';
</script>
<script src="source/plugin/tom_tongcheng/images/common.js?v=<?php echo $cssJsVersion;?>" type="text/javascript" type="text/javascript"></script><?php include template('tom_tongcheng:template_css'); ?><style>
.tcui-actionsheet__cell:before{border:0}
.tcui-actionsheet__cell{border-bottom:1px solid #EFEFF4;padding:20px 0}
.tcui-article td{border: 1px #bbb9b8 solid;}
.tcui-cells_checkbox i{font-style: normal;}
.layui-m-layer0 .layui-m-layerchild{width: 70%;}
.layui-m-layercont{padding: 5px 3px;}
.dialog-btns a{ color:<?php echo $tongchengConfig['template_color'];?>;border-color:<?php echo $tongchengConfig['template_color'];?>; }
.dialog-btns a:first-child{ background:<?php echo $tongchengConfig['template_color'];?>;}
.picker .picker-panel .picker-choose .confirm{ color:<?php echo $tongchengConfig['template_color'];?> !important;}
.edit-form ul li{line-height: initial;}
.edit-form ul li .paixu{font-size: 0.7em;height: 30px;line-height: 30px;display: none;}
.edit-form ul li .paixu input{width: 30px;text-align: center;border: 1px solid #efefef;}
</style>
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
</script>
</head>
<body>
<div id="qubieBox" class="slide-menu" style="display: none;">
    <header class="header on tc-template__bg">
        <section class="wrap">
            <section class="sec-ico go-back" onclick="hideQubieBox();">返回</section>
            <h2>版本区别</h2>
        </section>
    </header>
    <div class="slide-scroller">
        <article class="tcui-article" style="line-height:1.7;">
            <section>
                <?php echo $vip_txt;?>
            </section>
        </article>
    </div>
</div>
<div id="xieyiBox" class="slide-menu" style="display: none;">
    <header class="header on  tc-template__bg">
        <section class="wrap">
            <section class="sec-ico go-back" onclick="hideXieyiBox();">返回</section>
            <h2>入驻协议</h2>
        </section>
    </header>
    <div class="slide-scroller">
        <article class="tcui-article" style="line-height:1.7;">
            <section>
                <?php echo $xieyi_txt;?>
            </section>
        </article>
    </div>
</div>
<header class="header header-index on in2  tc-template__bg">
   <section class="wrap">
        <?php if($__HideHeader == 0 ) { ?>
        <section class="sec-ico go-back" onclick="history.back();">返回</section>
        <?php } ?>
        <h2>商家入驻</h2>
        <section class="sec-ico btn slide-btn">
            <a href="javascript:void(0);" onclick="showXieyiBox();">入驻须知</a>
        </section>
   </section>
</header>
<form class="mainer" name="payForm" id="payForm" >
   <section class="wrap edit-form">
        <section class="edit-item">
            <section class="input-control">
                 <span>店铺名称</span>
                 <section class="user-fav">
                      <section class="sec-input">
                           <input type="text" id="name" name="name" placeholder="请输入店铺名称" value=""  />
                      </section>
                      <div class="frt"></div>
                 </section>
            </section>
             <section class="input-control ">
                  <span>店铺分类</span>
                  <section class="user-fav">
                       <section class="sec-input">
                           <div id="choseCate"><font color="#8e8e8e">选择分类</font></div>
                           <input type="hidden" name="cate_id" id="cate_id" value="">
                           <input type="hidden" name="cate_child_id" id="cate_child_id" value="">
                       </section>
                       <div class="frt">
                            <div class="right-arrow"></div>
                       </div>
                  </section>
             </section>
            <?php if($tcshopConfig['open_ruzhu_area'] == 1  ) { ?>
            <section class="input-control " >
                 <span>店铺区域</span>
                 <section class="user-fav">
                      <section class="sec-input">
                           <div id="choseCity"><font color="#8e8e8e">选择区域</font></div>
                           <input type="hidden" name="area_id" id="area_id" value="">
                           <input type="hidden" name="street_id" id="street_id" value="">
                      </section>
                      <div class="frt"><div class="right-arrow"></div></div>
                 </section>
            </section>
            <?php } ?>
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
            <?php if($tcshopConfig['open_simplify_ruzhu'] == 0) { ?>
            <section class="input-control ">
                 <span>营业时间</span>
                 <section class="user-fav">
                      <section class="sec-input">
                           <input type="text" id="business_hours" name="business_hours" value="" placeholder="请输入，如：9:00-24:00"/>
                      </section>
                      <div class="frt"></div>
                 </section>
            </section>
            <?php } ?>
            <section class="input-control ">
                 <span>联系电话</span>
                 <section class="user-fav">
                      <section class="sec-input">
                           <input type="text" id="tel" name="tel" placeholder="请输入联系电话" value=""  />
                      </section>
                      <div class="frt"></div>
                 </section>
            </section>
            <?php if($tcshopConfig['open_simplify_ruzhu'] == 0) { ?>
                <?php if($tcshopConfig['open_must_shopkeeper_tel'] == 1) { ?>
                <section class="input-control ">
                     <span>店主手机</span>
                     <section class="user-fav">
                          <section class="sec-input">
                               <input type="text" id="shopkeeper_tel" name="shopkeeper_tel" placeholder="不公开，仅平台联系使用" value=""  />
                          </section>
                          <div class="frt"></div>
                     </section>
                </section>
                <?php } ?>
                <section class="input-control clear bb0" style="margin-bottom: 5px;">
                      <div style="line-height: 3em;">店铺介绍</div>
                      <section class="textarea">
                           <section class="sec-input">
                                <textarea id="content" name="content" maxlength="10000"></textarea>
                           </section>
                      </section>
                 </section>
                <?php if($__IsWeixin == 1 && $tongchengConfig['open_many_pic_upload'] == 1) { ?>   
                <section class="input-control ">
                     <div style="line-height: 3em;">店铺头像<font color="#8e8e8e">尺寸（200x200px）</font></div>
                      <ul>
                           <li>
                                <section class="img pic-upload-btn">
                                    <div id="filedata1" class="post-upload-fileprew"></div>
                                    <img src="source/plugin/tom_tongcheng/images/img7.png" />
                                </section>
                           </li>
                           <div id="picurl"></div>
                      </ul>
                </section>
                <section class="input-control ">
                    <div style="line-height: 2em;margin-top: 0.5em;">店铺相册<font color="#8e8e8e">（最多10 张）</font></div>
                    <div style="line-height: 1em;margin-bottom: 0.5em;"><font color="#f5833b;">前 3 张会生成幻灯片，建议尺寸: 720*324px</font></div>
                      <ul>
                          <div id="photolist"></div>
                           <li>
                                <section class="img pic-upload-btn">
                                    <div id="filedata2" class="post-upload-fileprew"></div>
                                    <img src="source/plugin/tom_tongcheng/images/img7.png" />
                                </section>
                           </li>
                      </ul>
                </section>
                <section class="input-control ">
                     <div style="line-height: 3em;">商家微信<font color="#8e8e8e">（上传商家微信二维码）</font></div>
                      <ul>
                           <li>
                                <section class="img pic-upload-btn">
                                    <div id="filedata3" class="post-upload-fileprew"></div>
                                    <img src="source/plugin/tom_tongcheng/images/img7.png" />
                                </section>
                           </li>
                           <div id="kefu_qrcode"></div>
                      </ul>
                </section>
                <?php if($tcshopConfig['open_must_business_licence'] == 1) { ?>
                <section class="input-control ">
                     <div style="line-height: 3em;">营业执照<font color="#8e8e8e">（上传商家营业执照）</font></div>
                      <ul>
                           <li>
                                <section class="img pic-upload-btn">
                                    <div id="filedata4" class="post-upload-fileprew"></div>
                                    <img src="source/plugin/tom_tongcheng/images/img7.png" />
                                </section>
                           </li>
                           <div id="business_licence"></div>
                      </ul>
                </section>
                <?php } ?>
                <?php } else { ?>
                <section class="input-control ">
                     <div style="line-height: 3em;">店铺头像<font color="#8e8e8e">尺寸（200x200px）</font></div>
                      <ul>
                           <li>
                                <section class="img pic-upload-btn">
                                    <input type="file" name="filedata1" id="filedata1" class="post-upload-fileprew"  />
                                    <img src="source/plugin/tom_tongcheng/images/img7.png" />
                                </section>
                           </li>
                           <div id="picurl"></div>
                      </ul>
                </section>
                <section class="input-control ">
                    <div style="line-height: 2em;margin-top: 0.5em;">店铺相册<font color="#8e8e8e">（最多10 张）</font></div>
                    <div style="line-height: 1em;margin-bottom: 0.5em;"><font color="#f5833b;">前 3 张会生成幻灯片，建议尺寸: 720*324px</font></div>
                      <ul>
                          <div id="photolist"></div>
                           <li>
                                <section class="img pic-upload-btn">
                                    <input type="file" name="filedata2" id="filedata2" class="post-upload-fileprew"/>
                                    <img src="source/plugin/tom_tongcheng/images/img7.png" />
                                </section>
                           </li>
                      </ul>
                </section>
                <section class="input-control ">
                     <div style="line-height: 3em;">商家微信<font color="#8e8e8e">（上传商家微信二维码）</font></div>
                      <ul>
                           <li>
                                <section class="img pic-upload-btn">
                                    <input type="file" name="filedata3" id="filedata3" class="post-upload-fileprew"  />
                                    <img src="source/plugin/tom_tongcheng/images/img7.png" />
                                </section>
                           </li>
                           <div id="kefu_qrcode"></div>
                      </ul>
                </section>
                <?php if($tcshopConfig['open_must_business_licence'] == 1) { ?>
                <section class="input-control ">
                     <div style="line-height: 3em;">营业执照<font color="#8e8e8e">（上传商家营业执照）</font></div>
                      <ul>
                           <li>
                                <section class="img pic-upload-btn">
                                    <input type="file" name="filedata4" id="filedata4" class="post-upload-fileprew"  />
                                    <img src="source/plugin/tom_tongcheng/images/img7.png" />
                                </section>
                           </li>
                           <div id="business_licence"></div>
                      </ul>
                </section>
                <?php } ?>
                <?php } ?>
            <?php } ?>
        </section>
        <?php if($__ShowTchehuoren == 1 && $showInviteCodeInput == 1) { ?>
        <section class="input-control invite_box">
             <span>邀请码</span>
             <section class="user-fav">
                  <section class="sec-input">
                       <input type="text" id="invite_code" name="invite_code" placeholder="无邀请码,可不填写" value=""  />
                       <section id="invite_code_msg" class="input-control invite_box invite_code_msg"></section>
                  </section>
                  <div class="frt"></div>
             </section>
        </section>
        <div class="tcui-cells__tips"></div>
        <?php } ?>
        <section class="input-control">
            <div style="line-height: 3em;">入驻同城<i id="id_ruzhu_discount" style="color: #f00;display: none;">(已享<?php echo $tcshop_ruzhu_discount_msg;?>折)</i><?php if($tcshopConfig['open_ruzhu_one'] == 1  ) { ?><a href="javascript:void(0);" onclick="showQubieBox();"><font color="#00abff" style="font-size: 1em;float: right;">版本区别</font></a><?php } ?></div>
             <div class="tcui-cells tcui-cells_checkbox" style="margin-top: 0px;">
                <?php if($tcshopConfig['open_ruzhu_one'] == 1  ) { ?>
                <label class="tcui-cell tcui-check__label" for="s11">
                    <div class="tcui-cell__hd">
                        <input type="radio" class="tcui-check" name="ruzhu_level" value="1" id="s11" checked="checked">
                        <i class="tcui-icon-checked"></i>
                    </div>
                    <div class="tcui-cell__bd">
                        <p>基础版(<i id="id_ruzhu_price"><?php echo $tcshopConfig['ruzhu_price'];?></i>元/
                            <?php if($tcshopConfig['base_time_type'] == 1  ) { ?>永久<?php } ?>
                            <?php if($tcshopConfig['base_time_type'] == 2  ) { ?>7天<?php } ?>
                            <?php if($tcshopConfig['base_time_type'] == 3  ) { ?>1个月<?php } ?>
                            <?php if($tcshopConfig['base_time_type'] == 4  ) { ?>3个月<?php } ?>
                            <?php if($tcshopConfig['base_time_type'] == 5  ) { ?>半年<?php } ?>
                            <?php if($tcshopConfig['base_time_type'] == 6  ) { ?>1年<?php } ?>
                            )<?php if($tcshopConfig['open_back_score'] == 1 ) { ?><font color="#fd0d0d" style="font-size: 0.7em;">(入驻返金币<?php echo $ruzhuBackScore;?>)</font><?php } ?></p>
                    </div>
                </label>
                <?php } ?>
                <label class="tcui-cell tcui-check__label" for="s12">
                    <div class="tcui-cell__hd">
                        <input type="radio" class="tcui-check" name="ruzhu_level" value="2" id="s12" <?php if($tcshopConfig['open_ruzhu_one'] == 0 ) { ?>checked="checked"<?php } ?>>
                        <i class="tcui-icon-checked"></i>
                    </div>
                    <div class="tcui-cell__bd">
                        <p>高级版(<i id="id_vip_ruzhu_price"><?php echo $tcshopConfig['vip_ruzhu_price'];?></i>元/1年)<?php if($tcshopConfig['open_back_score'] == 1 ) { ?><font color="#fd0d0d" style="font-size: 0.7em;">(入驻返金币<?php echo $ruzhuVipBackScore;?>)</font><?php } ?></p>
                    </div>
                </label>
                <label class="tcui-cell tcui-check__label" for="s13">
                    <div class="tcui-cell__hd">
                        <input type="radio" class="tcui-check" name="ruzhu_level" value="3" id="s13">
                        <i class="tcui-icon-checked"></i>
                    </div>
                    <div class="tcui-cell__bd">
                        <p>高级版(<i id="id_vip_ruzhu_price_two"><?php echo $tcshopConfig['vip_ruzhu_price_two'];?></i>元/2年)<?php if($tcshopConfig['open_back_score'] == 1 ) { ?><font color="#fd0d0d" style="font-size: 0.7em;">(入驻返金币<?php echo $ruzhuVipTwoBackScore;?>)</font><?php } ?></p>
                    </div>
                </label>
            </div>
             <section>
                 <input class="tcui-agree__checkbox" type="checkbox" name="xieyi" id="xieyi" value="1" checked />  <a href="javascript:void(0);" onclick="showXieyiBox();">我同意条款，保证信息合法合规。</a>
             </section>
        </section>
   </section>
   <section class="btn-group-block">
        <button type="button" id="id_ruzhu_btn" class="id_ruzhu_btn tc-template__bg">立即入驻</button>
        <input type="hidden" name="formhash" value="<?php echo $formhash;?>">
        <input type="hidden" name="user_id" value="<?php echo $__UserInfo['id'];?>">
        <input type="hidden" name="city_id" id="city_id" value="<?php echo $__CityInfo['id'];?>">
        <div class="clear10"></div>
        <div class="clear10"></div>
        <div class="clear10"></div>
   </section>
</form>
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
<?php if($showMustPhoneBtn == 1) { ?>
<div class="js_dialog">
    <div class="tcui-mask"></div>
    <div class="tcui-dialog">
        <div class="tcui-dialog__hd"><strong class="tcui-dialog__title">温馨提示</strong></div>
        <div class="tcui-dialog__bd">需要先绑定手机号，然后才能入驻好店</div>
        <div class="tcui-dialog__ft">
            <a href="<?php echo $phoneUrl;?>" class="tcui-dialog__btn tcui-dialog__btn_default"><font color="#fd0d0d">去绑定</font></a>
        </div>
    </div>
</div>
<?php } if($__IsMiniprogram == 1 && $__Ios == 1  && $tcshopConfig['closed_ios_pay'] == 1 ) { ?>
<div class="js_dialog">
    <div class="tcui-mask"></div>
    <div class="tcui-dialog">
        <div class="tcui-dialog__hd"><strong class="tcui-dialog__title">温馨提示</strong></div>
        <div class="tcui-dialog__bd"><?php echo $tcshopConfig['closed_ios_pay_msg'];?></div>
        <div class="tcui-dialog__ft">
            <a href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=index&amp;prand=<?php echo $prand;?>" class="tcui-dialog__btn tcui-dialog__btn_default">关闭</a>
        </div>
    </div>
</div>
<?php } ?>
<section class="dialog succ-dialog id-prompt" style="display: none;">
   <section class="dialog-wrap">
        <section class="dialog-center">
            <a href="javascript:void(0);" onclick="$('.id-prompt').hide();" class="group-link close"></a>
             <section class="dialog-body">
                  <h1>温馨提示</h1>
                  <p><span class="tc-template__border">您有店铺未完善资料，请点击下方按钮前往</span></p>
                  <section class="dialog-btns clear">
                       <a href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=mylist" class="hb-link tc-template__bg">立即前往</a>
                  </section>
             </section>
        </section>
   </section>
</section>
<?php if($subscribeFlag==2) { ?>
<section id="subscribe" style="top:0; z-index:99;">
    <div class="subscribe_box">
        <span>关注后接受审核和消息通知</span>
        <div class="right">
            <div class="guanzu_show"><a class="tc-template__bg" onclick="guanzu();">关注</a></div>
            <div class="guanzu_close" onclick="hide_guanzu();"><i></i></div>
        </div>
    </div>
</section>
<?php } if($showRuzhuXzBox == 1) { ?>
<section class="dialog succ-dialog id-prompt" id="xianzhi_box">
   <section class="dialog-wrap">
        <section class="dialog-center">
            <a href="javascript:void(0);" onclick="$(this).parents('.dialog').hide();" class="group-link close"></a>
             <section class="dialog-body">
                  <h1>已经入驻提示</h1>
                  <p><span class="tc-template__border">你已经有入驻店铺</span></p>
                  <section class="dialog-btns clear">
                       <a style="float:none; margin:0 auto;" href="plugin.php?id=tom_tcshop&amp;site=<?php echo $site_id;?>&amp;mod=mylist" >点击查看</a>
                  </section>
             </section>
        </section>
   </section>
</section>
<?php } ?>
<script>var cate = eval(decodeURIComponent('<?php echo $cateData;?>'));var selectedIndex_Cate = [0, 0];</script>
<script>var city = eval(decodeURIComponent('<?php echo $cityData;?>'));var selectedIndex_City = [0, 0];</script>
<?php if($isGbk) { ?>
<script src="source/plugin/tom_tcshop/images/picker/picker.min.gbk.js" type="text/javascript"></script>
<script src="source/plugin/tom_tcshop/images/picker/picker.city.gbk.js" type="text/javascript"></script>
<script src="source/plugin/tom_tcshop/images/picker/picker.cate.gbk.js" type="text/javascript"></script>
<?php } else { ?>
<script src="source/plugin/tom_tcshop/images/picker/picker.min.utf8.js" type="text/javascript"></script>
<script src="source/plugin/tom_tcshop/images/picker/picker.city.utf8.js" type="text/javascript"></script>
<script src="source/plugin/tom_tcshop/images/picker/picker.cate.utf8.js" type="text/javascript"></script>
<?php } ?>
<script src="//api.map.baidu.com/api?v=2.0&ak=<?php echo $tcshopConfig['baidu_js_ak'];?>" type="text/javascript"></script>
<script src="//res.wx.qq.com/open/js/jweixin-1.3.2.js" type="text/javascript" type="text/javascript"></script>
<script>
function guanzu(){
    layer.open({
        content: '<img src="<?php echo $tongchengConfig['fwh_qrcode'];?>"><p>长按二维码识别订阅我们<p/>'
        ,btn: '确认'
      });
}
function hide_guanzu(){
    $("#subscribe").hide();
}
<?php if($showGuanzuBox == 1) { ?>
    layer.open({
        content: '<img src="<?php echo $tongchengConfig['fwh_qrcode'];?>"><p>可以关注我们接受审核通知<p/>'
        ,btn: '确认'
      });
<?php } ?>
    
<?php if($__ShowTchehuoren == 1 && $showInviteCodeInput == 1) { ?>
$(document).on('change', '#invite_code', function(){
    var invite_code = $.trim($('#invite_code').val());
    if(invite_code == ''){
        $('#invite_code_msg').hide();
        $('#id_ruzhu_discount').hide();
        $('#id_ruzhu_price').html('<?php echo $tcshopConfig['ruzhu_price'];?>');
        $('#id_vip_ruzhu_price').html('<?php echo $tcshopConfig['vip_ruzhu_price'];?>');
        $('#id_vip_ruzhu_price_two').html('<?php echo $tcshopConfig['vip_ruzhu_price_two'];?>');
        return;
    }
    
    $.ajax({
        type: "GET",
        url: "<?php echo $tchehuorenAjaxUrl;?>",
        dataType : "json",
        data: {act:"invite_code",invite_code:invite_code},
        success: function(data){
            if(data.status == 200) {
                <?php if($showDiscountPrice == 1) { ?>
                $('#id_ruzhu_price').html('<?php echo $ruzhuDiscountPrice;?>');
                $('#id_vip_ruzhu_price').html('<?php echo $vipRuzhuDiscountPrice;?>');
                $('#id_vip_ruzhu_price_two').html('<?php echo $vipRuzhuDiscountPriceTwo;?>');
                $('#id_ruzhu_discount').show();
                <?php } ?>
                $('#invite_code_msg').html('<span>邀请人：</span><section class="user-fav"><img src="'+data.picurl+'">'+data.xm+'</section>').show();
            }else if(data.status == 301){
                $('#invite_code_msg').html('<p style="color:#f00">邀请码错误或该合伙人已被冻结</p>').show();
            }else{
                $('#invite_code_msg').hide();
            }
        }
    });
    
})
<?php } if($showPromptBox == 1) { ?>
$(document).ready(function(){
    $('.id-prompt').show();
})
<?php } ?>
    
function showQubieBox(){
    $("#qubieBox").show();
}    
function hideQubieBox(){
    $("#qubieBox").hide();
} 
function showXieyiBox(){
    $("#xieyiBox").show();
}    
function hideXieyiBox(){
    $("#xieyiBox").hide();
} 

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
      'openLocation', 
      'getLocation',
      'chooseImage',
      'uploadImage',
      'downloadImage'
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
<script>
var tcshop_id    = 0;
var li_i = 0;
var picurl_count = 0;
var photo_count = 0;
var qrcode_count = 0;
var business_licence_count = 0;
    
var submintPayStatus = 0;
$(".id_ruzhu_btn").click( function (){
    if(submintPayStatus == 1){
        return false;
    }
    
    if($('#xieyi').attr("checked")) {
    }else{
        tusi("必须同意入驻协议");
        return false;
    }
    
    var name      = $("#name").val();
    if(name == ""){
        tusi("必须输入店铺名称");
        return false;
    }
    
    var cate_child_id      = $("#cate_child_id").val();
    if(cate_child_id == ""){
        tusi("必须选择分类");
        return false;
    }
    <?php if($tcshopConfig['open_ruzhu_area'] == 1  ) { ?>
    var area_id      = $("#area_id").val();
    if(area_id == ""){
        tusi("必须选择区域");
        return false;
    }
    <?php } ?>
    var hidlat      = $("#hidlat").val();
    if(hidlat == ""){
        tusi("必须定位店铺位置");
        return false;
    }
    var tel      = $("#tel").val();
    if(tel == ""){
        tusi("必须输入联系电话");
        return false;
    }
    <?php if($tcshopConfig['open_simplify_ruzhu'] == 0) { ?>
    var business_hours      = $("#business_hours").val();
    var content             = $("#content").val();
    if(business_hours == ""){
        tusi("必须输入营业时间");
        return false;
    }
    
        <?php if($tcshopConfig['open_must_shopkeeper_tel'] == 1) { ?>
        var shopkeeper_tel      = $("#shopkeeper_tel").val();

        if(shopkeeper_tel == "" || !checkMobile(shopkeeper_tel)){
            tusi("必须输入店主手机");
            return false;
        }
        <?php } ?>
    
    if(picurl_count == 0){
        tusi("必须上传店铺头像");
        return false;
    }

    if(photo_count == 0){
        tusi("至少上传一张相册");
        return false;
    }

    if(qrcode_count == 0){
        tusi("必须上传商家微信二维码");
        return false;
    }
    
    <?php if($tcshopConfig['open_must_business_licence'] == 1) { ?>
    if(business_licence_count == 0){
        tusi("必须上传营业执照");
        return false;
    }
    <?php } ?>
    
    if(content == ""){
        tusi("必须填写详细店铺介绍");
        return false;
    }
    <?php } ?>
    
    loading('处理中...');
    submintPayStatus = 1;
    $.ajax({
        type: "POST",
        url: "<?php echo $payUrl;?>",
        dataType : "json",
        data: $('#payForm').serialize(),
        success: function(data){
            loading(false);
            if(data.status == 200) {
                tcshop_id = data.tcshop_id;
                if(data.pay_status == 1) {
                    tusi("下单成功，立即支付");
                    setTimeout(function(){window.location.href=data.payurl+"&prand=<?php echo $prand;?>";},500);
                }else{
                    submintPayStatus = 0;
                    setTimeout(function(){window.location.href="<?php echo $backLinkUrl;?>"+tcshop_id+"&prand=<?php echo $prand;?>";},1888);
                }
            }else if(data.status == 301){
                tusi("账号被封，不允许发布");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 302){
                tusi("没有安装TOM支付中心插件");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 303){
                tusi("生成微信订单失败");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 304){
                tusi("插入订单数据失败");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 305){
                $('#xianzhi_box').show();
                //setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 404){
                tusi("插入信息数据失败");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else if(data.status == 500){
                tusi("数据验证错误");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }else{
                tusi("入驻出错");
                setTimeout(function(){window.location.href=window.location.href+"&prand=<?php echo $prand;?>";},1888);
            }
        }
    });
});

function checkMobile(s){
var regu =/^[1][3|8|4|5|7|9][0-9]{9}$/;
var re = new RegExp(regu);
if (re.test(s)) {
return true;
}else{
return false;
}
} 
</script><?php include template('tom_tcshop:upload'); if($__IsWeixin == 1) { ?>
    <?php if($tongchengConfig['open_many_pic_upload'] == 1) { ?>
    <?php include template('tom_tcshop:wx_upload'); ?>    <?php } ?>
    <?php if($tcshopConfig['open_tx_map_location'] == 1) { ?>
    <?php include template('tom_tcshop:tx_map'); ?>    <?php } else { ?>
    <?php include template('tom_tcshop:wx_map'); ?>    <?php } } else { include template('tom_tcshop:baidu_map'); } ?>
</body>
</html>