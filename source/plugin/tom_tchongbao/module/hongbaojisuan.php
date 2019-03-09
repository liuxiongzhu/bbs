<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if($pjMoney > 10){
	$min_money = ($pjMoney - 10) * 100;
	$max_money = ($pjMoney + 10) * 100;
	$randMoneyTmp = mt_rand($min_money,$max_money);
	$randMoney = $randMoneyTmp / 100;
}else if($pjMoney > 5){
	$min_money = ($pjMoney - 5) * 100;
	$max_money = ($pjMoney + 5) * 100;
	$randMoneyTmp = mt_rand($min_money,$max_money);
	$randMoney = $randMoneyTmp / 100;
}else if($pjMoney > 1){
	$min_money = ($pjMoney - 1) * 100;
	$max_money = ($pjMoney + 1) * 100;
	$randMoneyTmp = mt_rand($min_money,$max_money);
	$randMoney = $randMoneyTmp / 100;
}else if($pjMoney > 0.5){
	$min_money = ($pjMoney - 0.5) * 100;
	$max_money = ($pjMoney + 0.5) * 100;
	$randMoneyTmp = mt_rand($min_money,$max_money);
	$randMoney = $randMoneyTmp / 100;
}else{
	$max_money = $pjMoney * 100;
	$randMoneyTmp = mt_rand(1, $max_money);
	$randMoney = $randMoneyTmp / 100;
}