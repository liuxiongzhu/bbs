<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<link rel="stylesheet" href="source/plugin/tom_tcshop/images/yinru_shop_style.css?v=<?php echo $cssJsVersion;?>" />
<section class="details-info" id="id-details-shop" style="margin-bottom: 8px;display: none;">
    <div class="shop_list" style="margin-top: 0px;">
        <div class="shop_list-title" style="background-color: #FFF;">TA的店铺</div>
        <div class="list-item" id="shop-list"></div>
        <div class="list-msg" style="display: none;background-color: #FFF;" id="shop-load-html">加载中...</div>
        <div class="list-msg" style="display: none;background-color: #FFF;" id="no-shop-list-html">没有相关店铺</div>
    </div>
</section>
<script type="text/javascript">
var loadShopPage = 1;
function indexLoadShopList(){
    loadShopPage = 1;
    loadShopList(1);
}

var loadShopListStatus = 0;
function loadShopList(Page) {
    if(loadShopListStatus == 1){
        return false;
    }
    loadShopListStatus = 1;
    $("#shop-list").html('');
    $("#shop-load-html").show();
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxLoadShopListUrl;?>",
        data: {page:Page},
        success: function(msg){
            var data = eval('('+msg+')');
            $("#shop-load-html").hide();
            if(data == 205){
                loadShopListStatus = 1;
                $("#no-shop-list-html").show();
                return false;
            }else{
                loadShopPage += 1;
                $("#id-details-shop").show();
                $("#shop-list").html(data);
            }
        }
    });
}
$(document).ready(function(){
   indexLoadShopList();
});
</script>