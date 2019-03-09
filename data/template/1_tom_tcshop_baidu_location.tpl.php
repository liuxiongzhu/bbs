<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<script>
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
                        $.get("<?php echo $ajaxUpdateLbsUrl;?>&latitude="+data.points[0].lat+"&longitude="+data.points[0].lng);
                        <?php if($_GET['mod'] == 'details' && $__ShowTchongbao == 1 && $tchongbaoInfo['only_show'] == 1 && $openLocaltionDistance == 1) { ?>
                            $('#latitude').val(data.points[0].lat);
                            $('#longitude').val(data.points[0].lng);
                            locationRequest();
                        <?php } ?>
} else {
                        $.get("<?php echo $ajaxUpdateLbsUrl;?>&latitude="+lat+"&longitude="+lng);
                        <?php if($_GET['mod'] == 'details' && $__ShowTchongbao == 1 && $tchongbaoInfo['only_show'] == 1 && $openLocaltionDistance == 1) { ?>
                            $('#latitude').val(lat);
                            $('#longitude').val(lng);
                            locationRequest();
                        <?php } ?>
}
                    <?php if($_GET['mod'] == 'details') { ?>
                    setTimeout(function(){getDistance();},500);
                    <?php } ?>
});
 },
function(error) {
                $('#loadingToast').hide();
                getLocationStatus = 2;
tusi("定位失败:"+error.code);
}
)
}else{
tusi('浏览器不支持Geolocation服务');
}
}

function wapGeolocation(){
var geolocation = new BMap.Geolocation();
geolocation.getCurrentPosition(function(r){
if(this.getStatus() == BMAP_STATUS_SUCCESS){
            $.get("<?php echo $ajaxUpdateLbsUrl;?>&latitude="+r.point.lat+"&longitude="+r.point.lng);
            <?php if($_GET['mod'] == 'details') { ?>
            setTimeout(function(){getDistance();},500);
                <?php if($__ShowTchongbao == 1 && $tchongbaoInfo['only_show'] == 1 && $openLocaltionDistance == 1) { ?>
                    $('#latitude').val(r.point.lat);
                    $('#longitude').val(r.point.lng);
                    locationRequest();
                <?php } ?>
            <?php } ?>
}else{
            $('#loadingToast').hide();
            getLocationStatus = 2;
tusi('定位失败:'+this.getStatus());
}        
},{enableHighAccuracy: true})
}
</script>