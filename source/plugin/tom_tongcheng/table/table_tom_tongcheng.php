<?php

/*
   This is NOT a freeware, use is subject to license terms
   版权所有：TOM微信 www.tomwx.cn
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
} 

class table_tom_tongcheng extends discuz_table{
	public function __construct() {
        parent::__construct();
		$this->_table = 'tom_tongcheng';
		$this->_pk    = 'id';
	}

    public function fetch_by_id($id,$field='*') {
		return DB::fetch_first("SELECT $field FROM %t WHERE id=%d", array($this->_table, $id));
	}
	
    public function fetch_all_list($condition,$orders = '',$start = 0,$limit = 10,$content = '') {
        if(!empty($content)){
            $data = DB::fetch_all("SELECT * FROM %t WHERE 1 %i AND content LIKE %s $orders LIMIT $start,$limit",array($this->_table,$condition,'%'.$content.'%'));
        }else{
            $data = DB::fetch_all("SELECT * FROM %t WHERE 1 %i $orders LIMIT $start,$limit",array($this->_table,$condition));
        }
		return $data;
	}
    
    public function fetch_all_nearby_list($condition,$start = 0,$limit = 10,$lat='',$lng='') {
        $maxRefreshTime = TIMESTAMP - (3 * 30 * 86400);
        $data = DB::fetch_all("SELECT *,acos(cos($lat*pi()/180 )*cos(latitude*pi()/180)*cos($lng*pi()/180 -longitude*pi()/180)+sin($lat*pi()/180 )*sin(latitude*pi()/180))*6370996.81/1000  as distance FROM %t WHERE is_dingwei=1 AND refresh_time>$maxRefreshTime %i ORDER BY distance ASC,id DESC  LIMIT $start,$limit",array($this->_table,$condition));
		return $data;
	}
    
    public function insert_id() {
		return DB::insert_id();
	}
    
    public function fetch_all_count($condition,$content = '') {
        if(!empty($content)){
            $return = DB::fetch_first("SELECT count(*) AS num FROM %t WHERE 1 %i AND content LIKE %s ",array($this->_table,$condition,'%'.$content.'%'));
        }else{
            $return = DB::fetch_first("SELECT count(*) AS num FROM %t WHERE 1 %i ",array($this->_table,$condition));
        }
		return $return['num'];
	}
	
	public function delete_by_id($id) {
		return DB::query("DELETE FROM %t WHERE id=%d", array($this->_table, $id));
	}

}



