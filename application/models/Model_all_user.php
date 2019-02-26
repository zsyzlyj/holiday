<?php 

class Model_all_user extends CI_Model{
	public function __construct(){
		parent::__construct();
	}
	public function getUserData(){
		$sql = "SELECT * FROM all_user WHERE user_id != ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}
	public function createbatch($data = ''){
		if($data){
			$create = $this->db->insert_batch('all_user', $data);
			return ($create == true) ? true : false;
		}
	}
	public function deleteAll(){
		$sql='delete from all_user';
		$delete = $this->db->query($sql);
	}
}