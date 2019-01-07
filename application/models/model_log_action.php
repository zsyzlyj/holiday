<?php 

class Model_log_action extends CI_Model{
	public function __construct(){
		parent::__construct();
	}
	public function getLogData(){
		$sql = "SELECT * FROM log_action";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getLogById($userId = null){
		if($userId){
			$sql = "SELECT * FROM log_action WHERE user_id = ?";	
			$query = $this->db->query($sql, array($userId));
			return $query->row_array();
		}
	}
	public function create($data = ''){
		if($data){
			$create = $this->db->insert('log_action', $data);
			return ($create == true) ? true : false;
		}
	}
}