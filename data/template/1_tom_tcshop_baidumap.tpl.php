<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); if($isGbk) { ?>
<meta http-equiv="Content-Type" content="text/html; charset=GBK">
<?php } else { ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php } ?>
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="telephone=no" name="format-detection" />
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta content="yes" name="apple-touch-fullscreen">
<style type="text/css">
    body, html, #allmap {
        width: 100%;
        height: 100%;
        overflow: hidden;
        margin: 0;
        font-family: "Microsoft Yahei";
    }
</style>
<script src="//api.map.baidu.com/api?v=2.0&ak=<?php echo $tcshopConfig['baidu_js_ak'];?>" type="text/javascript"></script>
<div id="allmap"></div>
<div style=" position: fixed;bottom: 0px; height:50px; background-color: #FFF; width:100%;text-align:center; line-height:50px;color:green">
    <table width="100%" height="50px" style="text-align:center; line-height:50px;color:green">
        <tr height="50px">
            <td width="50%" style="border-right:solid 1px #cacaca;"  onclick="cancel();">
                取消
            </td>
            <td onclick="ok();">
                确定选中点
            </td>
        </tr>
    </table>
</div>
<script type="text/javascript">
    function ok() {
        window.parent.LocationOK(point.lat, point.lng);
    }
    function cancel() {
        window.parent.LocationCancel();
    }
    function GetQueryString(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        if (r != null) return unescape(r[2]); return "";
    }
    // �ٶȵ�ͼAPI����
    var map = new BMap.Map("allmap");    // ����Mapʵ��
    var point = new BMap.Point(0, 0);
    var marker = new BMap.Marker(point);// ������ע
    var lng = GetQueryString("lng");
    var lat = GetQueryString("lat");
    if (lng == "") {
        lng = 113.335832;
    }
    if (lat == "") {
        lat = 23.128414;
    }
    var point = new BMap.Point(lng, lat);
    map.centerAndZoom(point, 15);  // ��ʼ����ͼ,�������ĵ�����͵�ͼ����
    map.addControl(new BMap.MapTypeControl());   //���ӵ�ͼ���Ϳؼ�
    map.enableScrollWheelZoom(true);     //��������������
    marker = new BMap.Marker(point);
    map.addOverlay(marker);

    map.addEventListener("touchend", function (e) {
        map.removeOverlay(marker);
        var center = map.getCenter();
        point = new BMap.Point(e.point.lng, e.point.lat);
        marker = new BMap.Marker(point);
        map.addOverlay(marker);
    });
</script>

