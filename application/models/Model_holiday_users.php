<?php 

class Model_holiday_users extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	public function getUserData(){
		$sql = "SELECT * FROM holiday_users WHERE user_id != ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}
	public function getUserById($userId = null){
		if($userId){
			$sql = "SELECT * FROM holiday_users WHERE user_id = ?";	
			$query = $this->db->query($sql, array($userId));
			return $query->row_array();
		}
	}

	public function create($data = ''){
		if($data){
			$create = $this->db->insert('holiday_users', $data);
			return ($create == true) ? true : false;
		}
	}
	
	public function createbatch($data){
		if($data){
			$insert = $this->db->insert_batch('holiday_users', $data);
			return ($insert == true) ? true : false;
		}
	}
	/*
		更新用户的权限
	*/
	public function update($data=array(),$id){
		$this->db->where('user_id',$id);
		$update = $this->db->update('holiday_users', $data);
		return ($update == true) ? true : false;	
	}
	public function edit($data = array(), $id = null){
		$this->db->where('user_id', $id);
		$update = $this->db->update('holiday_users', $data);
			
		return ($update == true) ? true : false;	
	}

	public function delete($id){
		$this->db->where('user_id', $id);
		$delete = $this->db->delete('holiday_users');
		return ($delete == true) ? true : false;
	}

	public function deleteAll(){
		$sql='delete from holiday_users';
		$delete = $this->db->query($sql);
	}
}