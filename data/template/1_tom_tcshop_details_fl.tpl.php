<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<section class="tc-sec mt0" id="index-fl-list">
    <div class="tcui-loadmore" style="padding:1em"><i class="tcui-loading"></i><span class="tcui-loadmore__tips">正在加载...</span></div>
</section>
<section style="display: none;" id="load-fl-html">
    <div class="tcui-loadmore" style="padding:1em;min-height:400px;"><i class="tcui-loading"></i><span class="tcui-loadmore__tips">正在加载...</span></div>
</section>
<section style="display: none;" id="no-load-fl-html">
    <div class="tcui-loadmore" style="padding:1em"><span class="tcui-loadmore__tips">没有更多信息...</span></div>
</section>
<section  style="display: none;" id="no-list-fl-html">
    <div class="clear10" style="height:7em;"></div>
    <div class="tcui-loadmore tcui-loadmore_line">
       <span class="tcui-loadmore__tips">没有信息</span>
    </div>
</section>
<div class="deta-item id-fl-item-more" style="padding: 0px 0 0;">
    <div class="item-more">
        <a href="<?php echo $__TongchengHost;?>plugin.php?id=tom_tongcheng&site=<?php echo $site_id;?>&mod=home&uid=<?php echo $tcshopInfo['user_id'];?>">查看更多信息</a>	
    </div>
</div>

<script type="text/javascript">
var loadFlHtml = $("#load-fl-html").html();
var noListFlHtml = $("#no-list-fl-html").html();
var loadFlListStatus = 0;

<?php if($cateInfo['youhui_model_ids']) { ?>
loadFlList('<?php echo $cateInfo['youhui_model_ids'];?>');
<?php } else { ?>
loadFlList('<?php echo $tcshopConfig['youhui_model_id'];?>|<?php echo $tcshopConfig['zhaopin_model_id'];?>');
<?php } ?>

function loadFlList(modelIds){
    if(loadFlListStatus == 1){
        return false;
    }
    loadFlListStatus = 1;
    $("#index-fl-list").html(loadFlHtml);
    $.ajax({
        type: "GET",
        url: "<?php echo $ajaxLoadFlListUrl;?>",
        data: {model_ids:modelIds, page:1,pagesize:6},
        success: function(msg){
            loadFlListStatus = 0;
            var data = eval('('+msg+')');
            if(data == 205){
                $("#index-fl-list").html(noListFlHtml);
                $(".id-fl-item-more").hide();
                return false;
            }else{
                $("#index-fl-list").html(data);
            }
        }
    });
}

</script><?php include template('tom_tongcheng:list_sub'); ?>