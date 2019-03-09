<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<script src="//apis.map.qq.com/tools/geolocation/min?key=<?php echo $tcshopConfig['tx_js_ak'];?>&referer=<?php echo $tcshopConfig['plugin_name'];?>" type="text/javascript"></script>
<script>
// µÿÕºAPI START
var latitude = longitude = null;
var type = 0;
var isSaveClick = true;
var gc = new BMap.Geocoder();
function getaddress(lat, lng) {
    $('#hidlat').val(lat);
    $('#hidlng').val(lng);
    if (isSaveClick) {
        $('#locationtext').text("ÂÆö‰Ωç‰∏≠...");
        var point = new BMap.Point(lng, lat);
        gc.getLocation(point, function (rs) {
            var addComp = rs.addressComponents;
            $('#locationtext').text('ÂÆö‰Ωç');
            $('#address').val(addComp.city + addComp.district + addComp.street + addComp.streetNumber);
        });
    }
    isSaveClick = true;
}
function getLocation() {
    getaddress(res.latitude, res.longitude);
}
function LocationOK(x, y) {
    getaddress(x, y);
    $("#baidumap").hide();
}
function LocationCancel(x, y) {
    $("#baidumap").hide();
}

var options = {timeout: 9000};
$("#mylocation").click(function() {
    $("#actionsheet_cancel").click();
    type = 2;
    
    var TxGeolocation = new qq.maps.Geolocation();
    TxGeolocation.getLocation(function(position){

        var data = JSON.stringify(position, null, 4);
var data = eval('('+data+')');
            var lat = data.lat;
            var lng = data.lng;
            console.log(data);
            $('#hidlat').val(lat);
            $('#hidlng').val(lng);

var point = new BMap.Point(lng, lat);
            var convertor = new BMap.Convertor();
            var pointArr = [];
            pointArr.push(point);
            convertor.translate(pointArr, 3, 5, function(data) {
                if (data.status === 0) {
                    getaddress(data.points[0].lat, data.points[0].lng);
                } else {
                    getaddress(lat, lng);
                }
            });
        
    }, '', options);
    
});

$("#maplocation").click(function() {
    $("#baidumap").show();
    $("#actionsheet_cancel").click();
});

$(function () {
    var actionSheet = $('#actionSheet_wrap');
    function hideActionSheet() {
        if (actionSheet.hasClass('tcui-actionsheet_toggle')) {
            actionSheet.removeClass('tcui-actionsheet_toggle');
        }
        return false;
    }
    $('#actionsheet_cancel').on('click', hideActionSheet);
    $("#showActionSheet").on("click", function () {
        if (tomBrowser.versions.WindowsWechat) {
            return tusi("Âè™ËÉΩÂú®ÊâãÊú∫Á´ØÂÆö‰ΩçÂì¶");
        }
        
        type = 1;
        <?php if($tongchengConfig['open_moblie_https_location'] == 1) { ?>
        h5Geolocation();
        <?php } else { ?>
        wapGeolocation()
        <?php } ?>
        actionSheet.addClass('tcui-actionsheet_toggle');
        return false;
    });
});

function h5Geolocation(){
if (navigator.geolocation){
navigator.geolocation.getCurrentPosition(
function(position) {  
var lat = position.coords.latitude;
var lng = position.coords.longitude;
var point = new BMap.Point(lng, lat);
var convertor = new BMap.Convertor();
var pointArr = [];
pointArr.push(point);
convertor.translate(pointArr, 1, 5, function(data) {
                    if (data.status === 0) {
                        latitude = data.points[0].lat;
                        longitude = data.points[0].lng;
} else {
                        latitude = lat;
                        longitude = lng;
}
                    if(type == 1){
                        $('#hidlat').val(latitude); // Œ≥∂»£¨∏°µ„ ˝£¨∑∂ŒßŒ™90 ~ -90
                        $('#hidlng').val(longitude); // æ≠∂»£¨∏°µ„ ˝£¨∑∂ŒßŒ™180 ~ -180°£
                        $("#baidumap iframe").attr("src", 'plugin.php?id=tom_tcshop&site=<?php echo $site_id;?>&mod=baidumap&lat=' + latitude + "&lng=" + longitude);
                    }else if(type == 2){
                        getaddress(latitude, longitude);
                    }
});
 },
function(error) {
tusi("ÂÆö‰ΩçÂ§±Ë¥•:"+error.code)
}
)
}else{
tusi('ÊµèËßàÂô®‰∏çÊîØÊåÅGeolocationÊúçÂä°');
}
}

function wapGeolocation(){
    var TxGeolocation = new qq.maps.Geolocation();
    TxGeolocation.getLocation(function(position){
        var data = JSON.stringify(position, null, 4);
var data = eval('('+data+')');
            var lat = data.lat;
            var lng = data.lng;
            console.log(data);
            $('#hidlat').val(lat);
            $('#hidlng').val(lng);
            $("#baidumap iframe").attr("src", 'plugin.php?id=tom_tcshop&site=<?php echo $site_id;?>&mod=baidumap&lat=' + lat + "&lng=" + lng);
    }, '', options);
    
}
// µÿÕºAPI END
</script>