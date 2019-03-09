<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$tomSysOffset = getglobal('setting/timeoffset');

$vid = isset($_GET['vid'])? intval($_GET['vid']):0;

$voteInfo = C::t('#tom_weixin_vote#tom_weixin_vote')->fetch_by_id($vid);

if(isset($_G['uid']) && $_G['uid'] > 0 && $_G['groupid'] == 1){
    
    $itemListTmp = C::t('#tom_weixin_vote#tom_weixin_vote_item')->fetch_all_list(" AND vote_id={$vid} AND status=0 ","ORDER BY num DESC",0,2000);
    $itemList = array();
    foreach ($itemListTmp as $key => $value) {
        $itemList[$key]['no'] = $value['no'];
        $itemList[$key]['name'] = $value['name'];
        $itemList[$key]['tel'] = $value['tel'];
        $itemList[$key]['num'] = $value['num'];
    }
    
    $item_pm = lang('plugin/tom_weixin_vote','item_pm');
    $item_id = lang('plugin/tom_weixin_vote','item_id');
    $item_name = lang('plugin/tom_weixin_vote','item_name');
    $item_tel = lang('plugin/tom_weixin_vote','item_tel');
    $item_num = lang('plugin/tom_weixin_vote','item_num');

    $listData[] = array($item_pm,$item_id,$item_name,$item_tel,$item_num); 
    $i = 1;
    foreach ($itemList as $v){
        $lineData = array();
        $lineData[] = $i;
        $lineData[] = $v['no'];
        $lineData[] = $v['name'];
        $lineData[] = $v['tel'];
        $lineData[] = $v['num'];
        $listData[] = $lineData;
        $i++;
    }
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition:filename=exportVote.xls");

    foreach ($listData as $fields){
        foreach ($fields as $k=> $v){
            $str = @diconv("$v",CHARSET,"GB2312");
            echo $str ."\t";
        }
        echo "\n";
    }
    exit;
}else{
    exit('Access Denied');
}

