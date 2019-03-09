<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<script>
var list_model_id   = "<?php echo $model_id;?>";
var list_type_id    = "<?php echo $type_id;?>";
var list_cate_id    = "<?php echo $cate_id;?>";
var list_city_id    = "<?php echo $city_id;?>";
var list_area_id    = "<?php echo $area_id;?>";
var list_street_id  = "<?php echo $street_id;?>";
var list_keyword    = '<?php echo $keyword;?>';
var list_ordertype    = '<?php echo $ordertype;?>';

function set_model_id(modelId){
    list_cate_id    = ""+0;
    list_type_id    = ""+0;
    list_model_id    = ""+modelId;
    list_keyword    = "";
}
function set_type_id(typeId){
    list_cate_id    = ""+0;
    list_type_id    = ""+typeId;
    list_keyword    = "";
}
function set_cate_id(cateId){
    list_cate_id    = ""+cateId;
    list_keyword    = "";
}
function set_city_id(cityId){
    list_street_id    = ""+0;
    list_area_id    = ""+0;
    list_city_id    = ""+cityId;
}
function set_area_id(areaId){
    list_street_id    = ""+0;
    list_area_id    = ""+areaId;
}
function set_street_id(streetId){
    list_street_id    = ""+streetId;
}
function set_ordertype(orderType){
    list_ordertype    = ""+orderType;
}

function open_list(){
    pageIndex = 1;
    var url = 'plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=list'+'&model_id='+list_model_id+'&type_id='+list_type_id+'&cate_id='+list_cate_id+'&city_id='+list_city_id+'&area_id='+list_area_id+'&street_id='+list_street_id+'&keyword='+list_keyword+'&ordertype='+list_ordertype;
    window.location = url;
}

$(document).on("click", ".id-area",function() {
    $(".tc-list-top-filter>li>a").removeClass("active");
    $(".id-list-div").children().addClass("dn");
    $(".id-list-div").removeClass("dn");
    $(".id-areadiv").removeClass("dn");
    $(".id-area").addClass("active");
    return;
});

$(".id-areadiv").on("click", ".item", function (event) {
    var t = $(this);
    var areaId = t.data("id"),areaName = t.data("name");
    $(".id-area-txt").html(areaName);
    set_area_id(areaId);
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxGetStreetUrl;?>",
        data: { area_id:areaId},
        success: function(msg){
            var data = eval('('+msg+')');
            if(data == 100){
                open_list();
            }else{
                $(".id-streetdiv").html(data);
                $(".id-areadiv").addClass("width50");
                $(".id-streetdiv").removeClass("dn");
            }
            
        }
    });
    $(this).addClass("click").siblings().removeClass("click");
    event.stopPropagation();
    return;
});

$(".id-streetdiv").on("click", ".item", function (event) {
    var t = $(this);
    var streetId = t.data("id"),areaName = t.data("name");
    $(".id-area-txt").html(areaName);
    set_street_id(streetId);
    open_list();
    $(this).addClass("click").siblings().removeClass("click");
    event.stopPropagation();
    return;
});

$(document).on("click", ".id-model",function() {
    $(".tc-list-top-filter>li>a").removeClass("active");
    $(".id-list-div").children().addClass("dn");
    $(".id-list-div").removeClass("dn");
    $(".id-modeldiv").removeClass("dn");
    $(".id-model").addClass("active");
    return;
});

$(".id-modeldiv").on("click", ".item", function (event) {
    var t = $(this);
    var modelId = t.data("id"),modelName = t.data("name");
    $(".id-model-txt").html(modelName);
    set_model_id(modelId);
    open_list();
    $(this).addClass("click").siblings().removeClass("click");
    event.stopPropagation();
    return;
});

$(document).on("click", ".id-type",function() {
    $(".tc-list-top-filter>li>a").removeClass("active");
    $(".id-list-div").children().addClass("dn");
    $(".id-list-div").removeClass("dn");
    $(".id-typediv ").removeClass("dn");
    $(".id-type").addClass("active");
    return;
});

$(".id-typediv").on("click", ".item", function (event) {
    var t = $(this);
    var typeId = t.data("id"),typeName = t.data("name");
    $(".id-type-txt").html(typeName);
    set_type_id(typeId);
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxGetCateUrl;?>",
        data: { type_id:typeId},
        success: function(msg){
            var data = eval('('+msg+')');
            if(data == 100){
                open_list();
            }else{
                $(".id-catediv").html(data);
                $(".id-typediv").addClass("width50");
                $(".id-catediv").removeClass("dn");
            }
            
        }
    });
    $(this).addClass("click").siblings().removeClass("click");
    event.stopPropagation();
    return;
});

$(".id-catediv").on("click", ".item", function (event) {
    var t = $(this);
    var cateId = t.data("id"),cateName = t.data("name");
    $(".id-type-txt").html(cateName);
    set_cate_id(cateId);
    open_list();
    $(this).addClass("click").siblings().removeClass("click");
    event.stopPropagation();
    return;
});

$(document).on("click", ".id-ordertype",function() {
    $(".tc-list-top-filter>li>a").removeClass("active");
    $(".id-list-div").children().addClass("dn");
    $(".id-list-div").removeClass("dn");
    $(".id-ordertypediv").removeClass("dn");
    $(".id-ordertype").addClass("active");
    return;
});

$(".id-ordertypediv").on("click", ".item", function (event) {
    var t = $(this);
    var ordertypeId = t.data("id"),ordertypeName = t.data("name");
    $(".id-ordertype-txt").html(ordertypeName);
    set_ordertype(ordertypeId);
    open_list();
    $(this).addClass("click").siblings().removeClass("click");
    event.stopPropagation();
    return;
});

$(".tc-list-filter-area-fixed").click(function () {
    $(this).addClass("dn");
    $(".id-areadiv").removeClass("width50");
    $(".id-typediv").removeClass("width50");
    $(".tc-list-top-filter>li>a").removeClass("active");
    $(".id-list-div").children().addClass("dn");
});

function cancelscroll()
{
    $("body").css({
        'overflow': 'auto',
        'position': 'static',
        'top': 'auto'
    });
}
function noscroll()
{
    var scrollTop = $("body").scrollTop();
    $("body").css({
        'width':'100%',
        'overflow': 'hidden',
        'position': 'fixed',
        'top': scrollTop * -1
    });
}
</script>