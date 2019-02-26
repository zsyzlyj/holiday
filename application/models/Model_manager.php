<?php 

class model_manager extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	public function getManagerData(){
		$sql = "SELECT * FROM manager WHERE user_id != ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}
	public function getManagerById($userId = null){
		if($userId){
			$sql = "SELECT * FROM manager WHERE user_id = ?";	
			$query = $this->db->query($sql, array($userId));
			return $query->row_array();
		}
	}
	public function getManagerByDept($dept = null){
		if($dept){
			$sql = "SELECT * FROM manager WHERE locate(?,dept)";
			$query = $this->db->query($sql, array($dept));
			return $query->result_array();
		}
	}

	public function create($data = ''){
		if($data){
			$create = $this->db->insert('manager', $data);
			return ($create == true) ? true : false;
		}
	}
	
	public function createbatch($data){
		if($data){
			$insert = $this->db->insert_batch('manager', $data);
			return ($insert == true) ? true : false;
		}
	}
	/*
		更新用户的权限
	*/
	public function update($data=array(),$id){
		$this->db->where('user_id',$id);
		$update = $this->db->update('manager', $data);
		return ($update == true) ? true : false;	
	}

	public function delete($id){
		$this->db->where('user_id', $id);
		$delete = $this->db->delete('manager');
		return ($delete == true) ? true : false;
	}
	public function deleteAll(){
		$sql='delete from manager';
		$delete = $this->db->query($sql);
	}
}