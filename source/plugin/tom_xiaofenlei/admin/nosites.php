<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
    
showtableheader();
echo '<tr><th colspan="15" class="partition">' . $Lang['sites_help_title'] . '</th></tr>';
echo '<tr><td  class="tipsblock" s="1"><ul id="tipslis">';
echo '<li><font color="#fd0d0d">' . $Lang['sites_help_no'] . '</font></li>';
echo '</ul></td></tr>';
showtablefooter();