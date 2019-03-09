<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
} 

class table_tom_weixin_vote_log extends discuz_table{
	public function __construct() {
        parent::__construct();
		$this->_table = 'tom_weixin_vote_log';
		$this->_pk    = 'id';
	}

    public function fetch_by_id($id,$field='*') {
		return DB::fetch_first("SELECT $field FROM %t WHERE id=%d", array($this->_table, $id));
	}
    
    public function fetch_by_v_i_u_t($vote_id,$item_id,$user_id,$time_key) {
		return DB::fetch_first("SELECT * FROM %t WHERE vote_id=%d AND item_id=%d AND user_id=%d AND time_key=%d ", array($this->_table, $vote_id,$item_id,$user_id,$time_key));
	}
	
    public function fetch_all_list($condition,$orders = '',$start = 0,$limit = 10) {
		$data = DB::fetch_all("SELECT * FROM %t WHERE 1 %i $orders LIMIT $start,$limit",array($this->_table,$condition));
		return $data;
	}
    
    public function fetch_count_by_vid_ip($vote_id,$ip,$time_key) {
        $return = DB::fetch_first("SELECT count(*) AS num FROM %t WHERE vote_id=%d AND part1=%s AND time_key=%d ", array($this->_table, $vote_id,$ip,$time_key));
		return $return['num'];
	}
    
    public function fetch_all_count($condition) {
        $return = DB::fetch_first("SELECT count(*) AS num FROM ".DB::table($this->_table)." WHERE 1 $condition ");
		return $return['num'];
	}
	
	public function delete_by_id($id) {
		return DB::query("DELETE FROM %t WHERE id=%d", array($this->_table, $id));
	}
    
    public function delete_by_vote_id($vote_id) {
		return DB::query("DELETE FROM %t WHERE vote_id=%d", array($this->_table, $vote_id));
	}

}

