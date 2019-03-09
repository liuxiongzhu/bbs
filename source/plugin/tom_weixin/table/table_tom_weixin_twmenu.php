<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
} 

class table_tom_weixin_twmenu extends discuz_table{
	public function __construct() {
        parent::__construct();
		$this->_table = 'tom_weixin_twmenu';
		$this->_pk    = 'id';
	}

    public function fetch_by_id($id,$field='*') {
		return DB::fetch_first("SELECT $field FROM %t WHERE id=%d", array($this->_table, $id));
	}
    
    public function fetch_all_by_cmd($cmd,$limit=0) {
        $limitStr = '';
        if(!empty($limit)){
            $limitStr = ' LIMIT '.$limit;
        }
		return DB::fetch_all("SELECT * FROM %t WHERE cmd LIKE %s ORDER BY paixu ASC $limitStr ", array($this->_table,'%'.$cmd.'%'));
	}
	
    public function fetch_all_list($where,$start = 0,$limit = 10) {
		$data = DB::fetch_all("SELECT * FROM %t WHERE 1 %i ORDER BY id DESC LIMIT $start,$limit",array($this->_table,$where));
		return $data;
	}
    
    public function fetch_all_count($where) {
        $return = DB::fetch_first("SELECT count(*) AS num FROM ".DB::table($this->_table)." WHERE 1 $where ");
		return $return['num'];
	}
	
	public function delete_by_id($id) {
		return DB::query("DELETE FROM %t WHERE id=%d", array($this->_table, $id));
	}

}


?>
